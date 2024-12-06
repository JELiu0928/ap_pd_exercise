<?php
namespace App\Services\Cms\agGrid;

use App\Services\Cms\agGrid\traits\ColorCol;
use App\Services\Cms\agGrid\traits\DateCol;
use App\Services\Cms\agGrid\traits\ImageCol;
use App\Services\Cms\agGrid\traits\LongTextCol;
use App\Services\Cms\agGrid\traits\NumberCol;
use App\Services\Cms\agGrid\traits\NumberInputCol;
use App\Services\Cms\agGrid\traits\RadioButtonCol;
use App\Services\Cms\agGrid\traits\RankInputCol;
use App\Services\Cms\agGrid\traits\ReviewCol;
use App\Services\Cms\agGrid\traits\SelectCol;
use App\Services\Cms\agGrid\traits\SelectMultiCol;
use App\Services\Cms\agGrid\traits\TextCol;
use App\Services\Cms\agGrid\traits\TimestampCol;
use ErrorException;
use stdClass;

class ColumnSet
{
    use TextCol, LongTextCol, DateCol, TimestampCol, NumberCol, NumberInputCol, RankInputCol, RadioButtonCol, SelectCol, SelectMultiCol, ImageCol, ColorCol, ReviewCol;
    const defaultKeys = ['wrapText', 'autoHeight', 'resizable', 'sortable', 'filter'];
    private $default = [
        'wrapText' => true,
        'autoHeight' => true,
        'resizable' => true,
        'sortable' => true,
        'filter' => true,
        'menuTabs' => [],
    ];
    private $fields = [];
    private $config = [];
    private $relations = [];
    private $group = [];

    public function with($relation, $headerName = '', ColumnSet $columnSet = null): static
    {

        $relation = preg_replace('/^_/', '', (preg_replace_callback('/[A-Z]{1}/', function ($match) {
            foreach ($match as $m) {
                return '_' . strtolower($m);
            }
        }, $relation)));
        $this->addWith($relation, $headerName ?: $relation, $columnSet ?? ColumnSet::make());

        return $this;
    }

    private function addWith($relation, $headerName, ColumnSet $columnSet)
    {
        $this->relations[$relation] = [
            'headerName' => $headerName,
            'columnSet' => $columnSet,
        ];
    }

    public function addCanGroup(string | array $col): static
    {
        if (gettype($col) === 'array') {
            array_push($this->group, ...$col);
        } else if (gettype($col) === 'string') {
            array_push($this->group, $col);
        }

        return $this;
    }

    /**
     * @param string|array $key draggable, selectable, multiSortable, animateRows
     * @param bool $value
     */
    public function setConfig($key, $value = true)
    {
        if (gettype($key) === 'array') {
            foreach ($key as $k => $v) {
                $this->changeConfig($k, $v);
            }
        } else {
            $this->changeConfig($key, $value);
        }
        return $this;
    }

    private function changeConfig($key, $val)
    {
        switch ($key) {
            case 'draggable':
                if ($val) {
                    $this->config['rowDragManaged'] = true;
                    $this->config['rowDragMultiRow'] = true;
                } else {
                    unset($this->config['rowDragManaged']);
                    unset($this->config['rowDragMultiRow']);
                }
                break;
            case 'selectable':
                if ($val) {
                    $this->config['suppressRowClickSelection'] = true;
                    $this->config['rowSelection'] = 'multiple';
                } else {
                    unset($this->config['suppressRowClickSelection']);
                    unset($this->config['rowSelection']);
                }
                break;
            case 'multiSortable':
                if ($val) {
                    unset($this->config['suppressMultiSort']);
                } else {
                    $this->config['suppressMultiSort'] = true;
                }
                break;
            case 'animateRows':
                $this->config['animateRows'] = $val;
                break;
            case 'pagination':
                $this->config['pagination'] = $val;
                break;
            case 'paginationPageSize':
                //paginationPageSize default = 100;
                $this->config['paginationPageSize'] = $val;
                break;
            default:
                throw new ErrorException(__CLASS__ . ' : Not Allow Config Key.', 500);
        }
    }

    /**
     * @param string|array $key wrapText, autoHeight, resizable, sortable, filter
     * @param bool $value
     */
    public function setDefault($key, $value = true)
    {
        if (gettype($key) === 'array') {
            foreach ($key as $k => $v) {
                $this->changeDefault($k, $v);
            }
        } else {
            $this->changeDefault($key, $value);
        }
        return $this;
    }

    private function changeDefault($key, $value)
    {
        if (in_array($key, $this::defaultKeys) && gettype($value) === 'boolean') {
            $this->default[$key] = $value;
        } else {
            throw new ErrorException(__CLASS__ . ' : Not Allow Default Key.', 500);
        }
    }

    public function get($fieldPrefix = '', bool $addPrefix = false)
    {
        $relations = [];

        foreach ($this->relations as $relation => $set) {
            if ($set['columnSet'] instanceof ColumnSet) {
                $relations[$relation]['headerName'] = $set['headerName'];
                $relations[$relation]['colSetting'] = $set['columnSet']->get((empty($fieldPrefix) ? '' : $fieldPrefix . ' - ') . $set['headerName'], $addPrefix);
            }
        }

        return [
            'defaultColDef' => $this->default,
            'fields' => !empty($fieldPrefix) && $addPrefix ? array_map(function ($field) use ($fieldPrefix) {
                $field['headerName'] = $fieldPrefix . ' - ' . $field['headerName'];
                return $field;
            }, $this->fields) : $this->fields,
            'config' => $this->config,
            'relations' => count($relations) === 0 ? new stdClass : $relations,
            'group' => $this->group,
        ];
    }

    /**
     * @param array $default
     * @param bool $draggable
     */
    private function __construct()
    {

    }
    /** @return ColumnSet */
    public static function make($default = [], $selectable = true, $draggable = true, $multiSortable = false, $pagination = true)
    {
        return (new static())->setDefault($default)->setConfig(['selectable' => $selectable, 'draggable' => $draggable, 'multiSortable' => $multiSortable, 'pagination' => $pagination]);
    }
}
