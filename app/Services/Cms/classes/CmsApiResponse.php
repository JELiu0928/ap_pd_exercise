<?php

namespace App\Services\Cms\classes;

interface CmsApiResponse
{
    /** @return array */
    public function toArray(): array;
}
