<?php
namespace App\Services\Cms\agGrid\traits;

trait NumberInputCol
{
    public function numberInputCol($column, $headerName = '', $width = 0)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addNumberInputCol($col, $header, $width);
            }
        } else {
            $this->addNumberInputCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addNumberInputCol($column, $headerName = '', $width = 0)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'NumberInputCol',
        ];
    }
}
