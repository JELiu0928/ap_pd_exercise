<?php
namespace App\Services\Cms\agGrid\traits;

trait SelectMultiCol
{
    public function selectMultiCol($column, string $headerName = '', array $options = [], int $width = 140)
    {
        $this->addSelectMultiCol($column, $headerName, $options, $width);
        return $this;
    }
    private function addSelectMultiCol($column, $headerName, $options, $width = 140)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'SelectMultiCol',
            'options' => $options,
        ];
    }
}
