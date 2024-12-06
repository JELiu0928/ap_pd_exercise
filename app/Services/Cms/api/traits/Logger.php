<?php

namespace App\Services\Cms\api\traits;

use App\Models\Basic\LogData;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BaseFunctions;

trait Logger
{
    /** @param Model $model */
    protected function addCreateLog($model = null, $replaceData = [])
    {
        if ($model === null) {
            return;
        }
        BaseFunctions::checkLogTable();
        LogData::create(array_merge([
            'create_time' => date('Y-m-d H:i:s'),
            'table_name' => $model->getTable(),
            'data_id' => $model->id,
            'user_id' => session('fantasy_user')['id'],
            'log_type' => 'create',
            'ChangeData' => json_encode($model->getAttributes()),
            'classname' => 'CMS',
            'user_name' => session('fantasy_user')['name'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        ], $replaceData));
    }
    /** @param Model $model */
    protected function addUpdateLog($model = null, $replaceData = [])
    {
        if ($model === null) {
            return;
        }
        BaseFunctions::checkLogTable();
        LogData::create(array_merge([
            'create_time' => date('Y-m-d H:i:s'),
            'table_name' => $model->getTable(),
            'data_id' => $model->id,
            'user_id' => session('fantasy_user')['id'],
            'log_type' => 'update',
            'ChangeData' => json_encode($model->getAttributes()),
            'classname' => 'CMS',
            'user_name' => session('fantasy_user')['name'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        ], $replaceData));
    }

    /** @param Model $model */
    protected function addDeleteLog($model = null, $replaceData = [])
    {
        if ($model === null) {
            return;
        }
        BaseFunctions::checkLogTable();
        LogData::create(array_merge([
            'create_time' => date('Y-m-d H:i:s'),
            'table_name' => $model->getTable(),
            'data_id' => $model->id,
            'user_id' => session('fantasy_user')['id'],
            'log_type' => 'delete',
            'ChangeData' => json_encode($model->getAttributes()),
            'classname' => 'CMS',
            'user_name' => session('fantasy_user')['name'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        ], $replaceData));
    }

}
