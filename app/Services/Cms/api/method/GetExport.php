<?php
namespace App\Services\Cms\api\method;

use App\Services\Cms\api\response\ExportResponse;

interface GetExport
{
    /** @return ExportResponse */
    public function getExport(): ExportResponse;
}
