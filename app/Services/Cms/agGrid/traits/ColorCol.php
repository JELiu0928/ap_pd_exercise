<?php
namespace App\Services\Cms\agGrid\traits;

trait ColorCol
{
    public function colorCol($column, $headerName = '', $width = 140)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addColorCol($col, $header, $width);
            }
        } else {
            $this->addColorCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addColorCol($column, $headerName = '', $width = 140)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'ColorCol',
        ];
    }
}
