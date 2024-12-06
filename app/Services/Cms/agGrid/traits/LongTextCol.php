<?php
namespace App\Services\Cms\agGrid\traits;

trait LongTextCol
{
    public function longTextCol($column, $headerName = '', $width = 250)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addLongTextCol($col, $header, $width);
            }
        } else {
            $this->addLongTextCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addLongTextCol($column, $headerName = '', $width = 250)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'LongTextCol',
        ];
    }
}
