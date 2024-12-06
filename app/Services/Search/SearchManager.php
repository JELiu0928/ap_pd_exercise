<?php

namespace App\Services\Search;

class SearchManager
{
    // 視情況增減, key為config/models裡的model, 如果沒有定義則一律走Basic
    // ex: 'News' => 'App\Services\Search\Searcher\NewsSearch'
    protected $searchers = [
        'Basic' => 'App\Services\Search\Searcher\BasicSearch'
    ];

    protected $search_type = 'basic';
    protected $searcher = null;
    protected $search = null;
    protected $builder = null;

    public function __construct($search, $search_type, $builder, $modelName = '', $option = 'Basic')
    {
        $this->search_type = $search_type;
        $this->search = $search;
        $this->builder = $builder;
        if ($modelName != '') {
            $this->setSearcher($modelName, $option);
        }
    }

    public function setSearcher($modelName, $option)
    {
        if (is_null($this->builder)) throw new \Exception("尚未定義builder");

        if (isset($this->searchers[$modelName])) {
            $this->searcher = new $this->searchers[$modelName]($this->search, $this->search_type, $this->builder);
        } else {
            $this->searcher = new $this->searchers[$option]($this->search, $this->search_type, $this->builder);
        }
    }

    public function search()
    {
        if (!is_null($this->searcher)) {
            return $this->searcher->search();
        } else {
            throw new \Exception('尚未定義searcher');
        }
    }
    public function testSearch()
    {
        if (!is_null($this->searcher)) {
            return $this->searcher->testSearch();
        } else {
            throw new \Exception('尚未定義searcher');
        }
    }
}