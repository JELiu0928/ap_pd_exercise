<?php
namespace App\Services\Cms\agGrid\traits;

trait DateCol
{
    public function dateCol($column, $headerName = '', $width = 140)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addDateCol($col, $header, $width);
            }
        } else {
            $this->addDateCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addDateCol($column, $headerName = '', $width = 140)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'DateCol',
        ];
    }
}
