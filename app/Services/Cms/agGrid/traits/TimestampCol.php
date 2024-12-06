<?php
namespace App\Services\Cms\agGrid\traits;

trait TimestampCol
{
    public function timestampCol($column, $headerName = '', $width = 140)
    {
        if (gettype($column) === 'array') {
            foreach ($column as $col => $header) {
                $this->addTimestampCol($col, $header, $width);
            }
        } else {
            $this->addTimestampCol($column, $headerName, $width);
        }
        return $this;
    }
    private function addTimestampCol($column, $headerName = '', $width = 140)
    {
        $this->fields[] = [
            'field' => $column,
            'headerName' => $headerName ?: $column,
            'width' => $width,
            'type' => 'TimestampCol',
        ];
    }
}
