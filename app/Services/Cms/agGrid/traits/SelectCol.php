<?php
namespace App\Services\Cms\agGrid\traits;

trait SelectCol
{
    public function selectCol($column, string $headerName = '', array $options = [], int $width = 140)
    {
        $this->addSelectCol($column, $headerName, $options, $width);
        return $this;
    }
    private function addSelectCol($column, $headerName, $options, $width = 140)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'SelectCol',
            'options' => $options,
        ];
    }
}
