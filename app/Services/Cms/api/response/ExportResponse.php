<?php

namespace App\Services\Cms\api\response;

use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\classes\CmsApiResponse;
use Countable;
use Illuminate\Support\Collection;

class ExportResponse implements CmsApiResponse
{
    public $colSetting;
    public $data;
    public $unitTitle;
    private function __construct(array $colSetting, Collection $data, string $unitTitle)
    {
        $this->colSetting = $colSetting;
        $this->data = $data;
        $this->unitTitle = $unitTitle;
    }

    /** @return array */
    public function toArray(): array
    {
        return [
            'colSetting' => $this->colSetting,
            'data' => $this->data,
            'unitTitle' => $this->unitTitle,
        ];
    }

    /** @return static */
    public static function create(ColumnSet $colSetting, Countable | array $data, string $unitTitle = 'Wade Digital Design')
    {

        if (!$data instanceof Collection) {
            $data = collect($data);
        }

        return new static($colSetting->get('', true), $data, $unitTitle);
    }
}
