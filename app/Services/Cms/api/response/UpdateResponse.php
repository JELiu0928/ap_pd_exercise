<?php

namespace App\Services\Cms\api\response;

use App\Services\Cms\classes\CmsApiResponse;
use Illuminate\Support\Collection;

class UpdateResponse implements CmsApiResponse
{
    public $ids;
    public $newData;
    public $child;
    private $dirty;

    private function __construct(array $ids, Collection $newData, array $child, bool $isDirty)
    {
        $this->ids = $ids;
        $this->newData = $newData;
        $this->child = $child;
        $this->dirty = $isDirty;
    }

    /** @return array */
    public function toArray(): array
    {
        $child = [];

        foreach ($this->child as $c) {
            if ($c instanceof UpdateResponse) {
                $array = $c->toArray();
                $child[] = $array;
            }
        }

        return [
            'ids' => $this->ids,
            'newData' => $this->newData->all(),
            'child' => $child,
        ];
    }

    public function isDirty()
    {
        return $this->dirty;
    }

    /** @return static */
    public static function create(array $ids, Collection $newData, array $child, bool $isDirty)
    {

        return new static($ids, $newData, $child, $isDirty);
    }
}
