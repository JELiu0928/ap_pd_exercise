<?php
namespace App\Services\Cms\agGrid\traits;

trait RankInputCol
{
    public function rankInputCol($column, $headerName = '', $width = 80)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addRankInputCol($col, $header, $width);
            }
        } else {
            $this->addRankInputCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addRankInputCol($column, $headerName = '', $width = 80)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'RankInputCol',
        ];
    }
}
