<?php declare(strict_types=1);

namespace TotalCRM\DBase;

use TotalCRM\DBase\Column\ColumnInterface;
use TotalCRM\DBase\Column\DBaseColumn;
use TotalCRM\DBase\DataConverter\Encoder\EncoderInterface;
use TotalCRM\DBase\DataConverter\Encoder\IconvEncoder;
use TotalCRM\DBase\Enum\Codepage;
use TotalCRM\DBase\Enum\TableType;
use TotalCRM\DBase\Exception\TableException;
use TotalCRM\DBase\Header\Header;
use TotalCRM\DBase\Header\Reader\HeaderReaderFactory;
use TotalCRM\DBase\Memo\MemoFactory;
use TotalCRM\DBase\Memo\MemoInterface;
use TotalCRM\DBase\Record\RecordFactory;
use TotalCRM\DBase\Record\RecordInterface;
use TotalCRM\DBase\Stream\Stream;
use TotalCRM\DBase\Table\Table;
use TotalCRM\DBase\Table\TableAwareTrait;

/**
 * Class TableReader
 * @package TotalCRM\DBase
 */
class TableReader
{
    use TableAwareTrait;

    /** @var Stream */
    protected $fp;

    /** @var int Current record position. */
    protected $recordPos = -1;

    /** @var int */
    protected $deleteCount = 0;

    /** @var bool */
    protected $isColumnId = false;

    /** @var RecordInterface|null */
    protected $record;

    /** @var EncoderInterface */
    protected $encoder;

    /**
     * @var Table
     */
    protected $table;

    /**
     * Table constructor.
     *
     * @param array $options Array of options:<br>
     *                       encoding - convert text data from<br>
     *                       columns - available columns<br>
     *                       encoder - encoder class name, default: IconvEncoder::class
     *                       isColumnId - enable column id indexes by name. id => 0_id, default:false<br>
     *
     * @throws \Exception
     */
    public function __construct(string $filepath, array $options = [])
    {
        $this->table = new Table();
        $this->table->filepath = $filepath;

        $this->encoder = isset($options['encoder']) && $options['encoder'] instanceof EncoderInterface
            ? $options['encoder']
            : new IconvEncoder()
        ;
        $this->table->options = $this->resolveOptions($options);

        $this->open();
        $this->readHeader();
        $this->openMemo();
    }

    protected function resolveOptions(array $options): array
    {
        return array_merge([
            'columns'  => [],
            'encoding' => null,
            'editMode' => null,
            'isColumnId' => false,
        ], $options);
    }

    protected function open(): void
    {
        if (!file_exists($this->getFilepath())) {
            throw new \Exception(sprintf('File %s cannot be found', $this->getFilepath()));
        }

        if ($this->table->stream) {
            $this->table->stream->close();
        }

        $this->table->stream = Stream::createFromFile($this->getFilepath());
    }

    protected function readHeader(): void
    {
        $this->table->header = HeaderReaderFactory::create($this->getFilepath(), $this->table->options)->read();
        $this->getStream()->seek($this->table->header->length);

        $this->recordPos = -1;
        $this->deleteCount = 0;
    }

    protected function openMemo(): void
    {
        if (TableType::hasMemo($this->getVersion())) {
            $this->table->memo = MemoFactory::create($this->table, $this->encoder);
        }
    }

    protected function getHeader(): Header
    {
        return $this->table->header;
    }

    protected function getMemo(): ?MemoInterface
    {
        return $this->table->memo;
    }

    public function close(): void
    {
        $this->getStream()->close();
        if ($memo = $this->getMemo()) {
            $memo->close();
        }
    }

    public function nextRecord(): ?RecordInterface
    {
        if (!$this->isOpen()) {
            $this->open();
        }

        if ($this->record) {
            $this->record->destroy();
            $this->record = null;
        }

        $valid = false;

        do {
            if (($this->recordPos + 1) >= $this->getHeader()->recordCount) {
                return null;
            }

            $this->recordPos++;
            $this->record = RecordFactory::create($this->table, $this->encoder, $this->recordPos, $this->getStream()
                ->read($this->getHeader()->recordByteLength));

            if ($this->record->isDeleted()) {
                $this->deleteCount++;
            } else {
                $valid = true;
            }
        } while (!$valid);

        return $this->record;
    }

    /**
     * Get record by row index.
     *
     * @param int $position Zero based position
     */
    public function pickRecord(int $position): ?RecordInterface
    {
        if ($position >= $this->getHeader()->recordCount) {
            throw new TableException("Row with index {$position} does not exists");
        }

        $curPos = $this->getStream()->tell();
        $seekPos = $this->getHeader()->length + $position * $this->getHeader()->recordByteLength;
        if (0 !== $this->getStream()->seek($seekPos)) {
            throw new TableException("Failed to pick row at position {$position}");
        }

        $record = RecordFactory::create($this->table, $this->encoder, $position, $this->getStream()
            ->read($this->getHeader()->recordByteLength));
        // revert pointer
        $this->getStream()->seek($curPos);

        return $record;
    }

    public function previousRecord(): ?RecordInterface
    {
        if (!$this->isOpen()) {
            $this->open();
        }

        if ($this->record) {
            $this->record->destroy();
            $this->record = null;
        }

        $valid = false;

        do {
            if (($this->recordPos - 1) < 0) {
                return null;
            }

            $this->recordPos--;

            $this->getStream()->seek($this->getHeader()->length + ($this->recordPos * $this->getHeader()->recordByteLength));

            $this->record = RecordFactory::create(
                $this->table,
                $this->encoder,
                $this->recordPos,
                $this->getStream()->read($this->getRecordByteLength())
            );

            if ($this->record->isDeleted()) {
                $this->deleteCount++;
            } else {
                $valid = true;
            }
        } while (!$valid);

        return $this->record;
    }

    public function moveTo(int $index): ?RecordInterface
    {
        $this->recordPos = $index;

        if ($index < 0) {
            return null;
        }

        $this->getStream()->seek($this->getHeader()->length + ($index * $this->getHeader()->recordByteLength));

        $this->record = RecordFactory::create($this->table, $this->encoder, $this->recordPos, $this->getStream()
            ->read($this->getHeader()->recordByteLength));

        return $this->record;
    }

    /**
     * @return ColumnInterface
     */
    public function getColumn(string $name)
    {
        foreach ($this->getHeader()->columns as $column) {
            if ($column->name === $name) {
                return new DBaseColumn($column);
            }
        }

        throw new \Exception("Column $name not found");
    }

    public function getRecord(): ?RecordInterface
    {
        return $this->record;
    }

    public function getCodepage(): int
    {
        return $this->getHeader()->languageCode;
    }

    /**
     * @return ColumnInterface[]
     */
    public function getColumns(): array
    {
        $columns = [];
        foreach ($this->getHeader()->columns as $column) {
            assert(!empty($column->name));
            $columns[$column->name] = new DBaseColumn($column);
        }

        return $columns;
    }

    public function getColumnCount(): int
    {
        return count($this->getHeader()->columns);
    }

    /**
     * @return int
     */
    public function getRecordCount()
    {
        return $this->getHeader()->recordCount;
    }

    /**
     * @return int
     */
    public function getRecordPos()
    {
        return $this->recordPos;
    }

    public function getRecordByteLength()
    {
        return $this->getHeader()->recordByteLength;
    }

    /**
     * @return string
     */
    public function getFilepath()
    {
        return $this->table->filepath;
    }

    public function getVersion(): int
    {
        return $this->getHeader()->version;
    }

    /**
     * @see Codepage
     */
    public function getLanguageCode(): int
    {
        return $this->getHeader()->languageCode;
    }

    /**
     * @return int
     */
    public function getDeleteCount()
    {
        return $this->deleteCount;
    }

    public function getConvertFrom(): ?string
    {
        return $this->table->options['encoding'];
    }

    /**
     * @return bool
     */
    protected function isOpen()
    {
        return $this->getStream() ? true : false;
    }

    public function isFoxpro(): bool
    {
        return TableType::isFoxpro($this->getHeader()->version);
    }

    public function getModifyDate()
    {
        return $this->getHeader()->modifyDate;
    }

    public function isInTransaction(): bool
    {
        return $this->getHeader()->inTransaction;
    }

    public function isEncrypted(): bool
    {
        return $this->getHeader()->encrypted;
    }

    public function getMdxFlag(): string
    {
        return chr($this->getHeader()->mdxFlag);
    }

    public function getHeaderLength(): int
    {
        return $this->getHeader()->length;
    }
}
