<?php
namespace App\Services\Cms\agGrid\traits;

trait NumberCol
{
    public function numberCol($column, $headerName = '', $width = 0)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addNumberCol($col, $header, $width);
            }
        } else {
            $this->addNumberCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addNumberCol($column, $headerName = '', $width = 0)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'NumberCol',
        ];
    }
}
