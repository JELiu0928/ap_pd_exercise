<?php
namespace App\Services\Cms\agGrid\traits;

trait TextCol
{
    public function textCol($column, $headerName = '', $width = 100)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addTextCol($col, $header, $width);
            }
        } else {
            $this->addTextCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addTextCol($column, $headerName = '', $width = 100)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'TextCol',
        ];
    }
}
