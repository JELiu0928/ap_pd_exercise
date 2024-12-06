<?php
namespace App\Services\Cms\agGrid\traits;

trait ImageCol
{
    public function imageCol($column, $headerName = '', $width = 100)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addImageCol($col, $header, $width);
            }
        } else {
            $this->addImageCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addImageCol($column, $headerName = '', $width = 100)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'ImageCol',
        ];
    }
}
