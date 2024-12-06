<?php

namespace App\Services\Search\Searcher;

class BasicSearch
{
    public $search = null;
    public $builder = null;
    public $search_type = null;

    public function __construct($search, $search_type, $builder)
    {
        $this->search_type = $search_type;
        $this->search = $search;
        $this->builder = $builder;
    }

    final public function search()
    {
        foreach ($this->search as $col => $search) {
            if ($col == 'sort') continue;
            $type = $search['type'];
            $value = $search['value'];
            switch ($type) {
                case "text":
                    $this->text($col, $value);
                    break;
                case "multi_select":
                    $this->multi_select($col, $value);
                    break;
                case "qtext":
                    $this->qtext($col, $value);
                    break;
                case "radio":
                    $this->radio($col, $value);
                    break;
                case "datePicker":
                    $this->datePicker($col, $value);
                    break;
                case "single_select":
                    $this->singleSelect($col, $value);
                    break;
                case "dateRange":
                    $this->dateRange($col, $value);
                    break;
                case "sort":
                    $this->sort($col, $value);
                    break;
            }
        }
        return  $this->builder;
    }

    final public function testSearch()
    {
        $q = $this;
        $this->builder->where(function ($b) use ($q) {
            return (new \App\Services\Search\Searcher\BasicSearch($q->search, $q->search_type, $b))->search();
        });

        return $this->builder;
    }

    protected function multi_select($col, $value)
    {
        if (!empty($value)) {
            if ($this->search_type == 'fast') {
                $this->builder->orwhere(function ($q) use ($col, $value) {
                    $q->where($col, 'like', '%"0"%');
                    foreach ($value as $key2 => $item) {
                        $q->orwhere($col, 'like', '%"' . $item . '"%');
                    }
                });
            } else {
                $this->builder->where(function ($q) use ($col, $value) {
                    $q->where($col, 'like', '%"0"%');
                    foreach ($value as $key2 => $item) {
                        $q->orwhere($col, 'like', '%"' . $item . '"%');
                    }
                });
            }
        }
    }
    protected function text($col, $value)
    {
        if ($this->search_type == 'fast') {
            $this->builder->orwhere($col, 'like', '%' . $value . '%');
        } else {
            $this->builder->where($col, 'like', '%' . $value . '%');
        }
    }

    protected function qtext($col, $value)
    {
        if ($this->search_type == 'fast') {
            $this->builder->orwhere(substr($col, 3), 'like', '%' . $value . '%');
        } else {

            $this->builder->where(substr($col, 3), 'like', '%' . $value . '%');
        }
    }

    protected function radio($col, $value)
    {
        $cond2 = $value == 't' ? 1 : 0;
        if ($this->search_type == 'fast') {
            $this->builder->orwhere($col, $cond2);
        } else {
            $this->builder->where($col, $cond2);
        }
    }

    protected function datePicker($col, $value)
    {
        if ($this->search_type == 'fast') {
            $this->builder->orwhereDate($col, '=', $value);
        } else {
            $this->builder->whereDate($col, '=', $value);
        }
    }

    protected function singleSelect($col, $value)
    {
        if ($value != null) {
            if ($this->search_type == 'fast') {
                $this->builder->orwhere($col, $value);
            } else {
                $this->builder->where($col, $value);
            }
        }
    }

    protected function dateRange($col, $value)
    {
        $date = explode(',', $value);
        if ($value != ',') {
            if ($this->search_type == 'fast') {
                $this->builder->orwhere($col, '>=', $date[0])
                    ->where($col, '<=', date("Y-m-d", strtotime("+1 day", strtotime($date[1]))));
            } else {
                $this->builder->where($col, '>=', $date[0])
                    ->where($col, '<=', date("Y-m-d", strtotime("+1 day", strtotime($date[1]))));
            }
        }
    }

    protected function sort($col, $value)
    {
        $this->builder->orderBy($col, $value);
    }
}