<?php
namespace App\Services\Cms\api\method;

use App\Services\Cms\api\response\TableResponse;

interface GetTable
{
    /** @return TableResponse */
    public function getTable(): TableResponse;
}
