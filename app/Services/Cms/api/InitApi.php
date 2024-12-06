<?php
namespace App\Services\Cms\api;

use App\Services\Cms\classes\CmsApi;
use Illuminate\Database\Eloquent\Builder;

class InitApi extends CmsApi
{
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        return $builder;
    }
    final public function check(): bool
    {
        return false;
    }
}
