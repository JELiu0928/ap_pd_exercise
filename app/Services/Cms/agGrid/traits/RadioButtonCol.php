<?php
namespace App\Services\Cms\agGrid\traits;

trait RadioButtonCol
{
    public function radioButtonCol($column, $headerName = '', $width = 120)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addRadioButtonCol($col, $header, $width);
            }
        } else {
            $this->addRadioButtonCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addRadioButtonCol($column, $headerName = '', $width = 120)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'RadioButtonCol',
        ];
    }
}
