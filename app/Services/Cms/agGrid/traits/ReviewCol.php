<?php
namespace App\Services\Cms\agGrid\traits;

trait ReviewCol
{
    public function reviewCol($column, $headerName = '', $width = 100)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addreviewCol($col, $header, $width);
            }
        } else {
            $this->addreviewCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addreviewCol($column, $headerName = '', $width = 100)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'ReviewCol',
        ];
    }
}
