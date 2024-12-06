<?php

namespace App\Services\Cms\classes;

use App\Http\Controllers\Fantasy\MakeUnit;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsMenu;
use App\Models\Basic\Cms\CmsRole;
use App\Models\Basic\ReviewNotify;
use App\Services\Cms\api\response\UpdateResponse;
use App\Services\Cms\api\traits\Logger;
use ErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

abstract class CmsApi
{
    use Logger;

    /** @var CmsApi|null $next */
    private $next;
    /** @var array|null $roles */
    private $roles;
    /** @var Request $req */
    protected $req;
    /** @var CmsMenu $cmsMenu */
    protected $cmsMenu;
    /** @var BranchOrigin $branchOrigin */
    protected $branchOrigin;
    /** @var array $modelArray  modelName => modelClass */
    protected $modelArray = [];
    /** @var array $copyArray modelName => [ childModelName => foreignKey ] */
    protected $copyArray = [];

    /** @return bool */
    abstract protected function check(): bool;

    /**
     * @return CmsApiResponse
     * */
    final public function handle(string $action, Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        $this->req = $req;
        $this->cmsMenu = $cmsMenu;
        $this->branchOrigin = $branchOrigin;

        if (method_exists($this, $action) && $this->check()) {
            return $this->{$action}();
        } else {
            if (!empty($this->next)) {
                return $this->next->handle($action, $req, $cmsMenu, $branchOrigin);
            } else {
                throw new ErrorException(get_called_class() . ': No CmsApi Match.', 500);
            }
        }
    }

    /** format when update, create, copy */
    abstract protected function formatBuilder(string $modelClass, Builder $builder): Builder;

    protected function getRoles(): array
    {
        if (null === $this->roles) {
            $roles = [
                'view' => false,
                'edit' => false,
                'delete' => false,
                'create' => false,
                'need_review' => false,
                'can_review' => false,
                'is_review_edit' => false,
                'canBatch' => false,
                'canExport' => false,
            ];

            $branch = $this->branchOrigin;
            $locale = $this->req->locale;
            $user = Session::get('fantasy_user');

            $branchUnit = BranchOriginUnit::where('origin_id', $branch->id)->where('locale', $locale)->first();
            $branchUnit = !empty($branchUnit) ? $branchUnit->toArray() : [];

            /*======檢查是否有 新增/刪除 審核 ======*/
            if ($branch && config('cms.reviewfunction') && in_array($locale, json_decode($branch['local_review_set']))) {
                $roles['need_review'] = true;
            }

            /*======檢查是否有 新增/刪除 審核 ======*/
            $role = CmsRole::where('type', 2)->where('user_id', $user['id'])->where('branch_unit_id', $branchUnit['id'])->first();

            if (!empty($role)) {
                $role_json = json_decode($role->roles, true);
                $roles['is_review_edit'] = $role['is_review_edit'];

                $roleArray = explode(";", $role_json[$this->cmsMenu->id] ?? '');
                $roles['can_review'] = intval($roleArray[4] ?? 0) === 1;
                $roles['edit'] = intval($roleArray[3] ?? 0) === 1 || $roles['can_review'];
                $roles['delete'] = intval($roleArray[2] ?? 0) === 1 || $roles['can_review'];
                $roles['create'] = intval($roleArray[1] ?? 0) === 1 || $roles['can_review'];
                $roles['view'] = intval($roleArray[0] ?? 0) === 1 || $roles['can_review'] || $roles['edit'] || $roles['delete'] || $roles['create'];
            }

            $this->roles = $roles;
        }

        return $this->roles;
    }

    protected function getEdit(): string
    {
        $action = $this->req->action;

        $viewPrefix = implode(DIRECTORY_SEPARATOR, explode('.', $this->cmsMenu->view_prefix));
        $cmsTemplate = config('cms.blade_template');
        $bladeTemplateId = BranchOrigin::where('url_title', $this->req->branch)->value('blade_template');
        foreach ($cmsTemplate as $row) {
            if ($row['key'] == $bladeTemplateId) {
                $folderName = $row['blade_folder'];
            }
        }
        if (file_exists(resource_path('views/Fantasy/cms/' . $folderName . '/' . $viewPrefix))) {
            $viewPrefix = $folderName . '/' . $viewPrefix;
        }
        require_once resource_path('views/Fantasy/cms/' . $viewPrefix . '/setting.php');
        if (empty($menuList)) {
            throw new ErrorException('Cant find Setting File.');
        }

        if ($action === 'batch') {
            $menuList = ['batch' => '批次修改'];
        } elseif ($action === 'search') {
            $menuList = ['search' => '資料查詢'];
        }

        MakeUnit::setAction(['action' => $action]);

        list(
            'titleView' => $titleView,
            'contentView' => $contentView,
            'data' => $data,
            'reviewNotifies' => $reviewNotifies
        ) = $this->editContent($menuList, $viewPrefix);

        return view('Fantasy.cms_view.Edit.edit', [
            'menu' => $this->cmsMenu,
            'action' => $action,
            'tabs' => $menuList,
            'role' => $this->getRoles(),
            'title' => $titleView,
            'content' => $contentView,
            'active' => $this->req->formKey,
            'is_reviewed' => $data['is_reviewed'] ?? 0,
            'ReviewNotify' => $reviewNotifies,
        ])->render();

    }

    protected function editContent($menuList, $viewPrefix)
    {
        $data = $associationData = $ReviewNotify = [];
        $dataId = $this->req->ids[0] ?? 0;
        $modelName = $this->cmsMenu['model'];
        $modelClass = $this->modelArray[$modelName];
        if (!empty($dataId) && !in_array($this->req->action, ['create', 'batch'])) {
            $data = $this->formatBuilder('editContent', $modelClass::where('id', $dataId))->first();
            $ReviewNotify = ReviewNotify::where('data_id', $data['id'])->where('branch_id', $this->cmsMenu['branch_id'])->where('user_id', session('fantasy_user')['id'])->first();
            $associationData = $this->getSon($data);
        }
        $contentView = '';
        foreach ($menuList as $formKey => $val) {
            $contentView .= view(
                'Fantasy.cms.' . $viewPrefix . '.edit',
                [
                    "active" => $this->req->formKey,
                    "formKey" => $formKey,
                    "data" => $data,
                    "role" => $this->getRoles(),
                    "model" => $modelName,
                    "options" => [],
                    "associationData" => $associationData,
                    "menu_id" => $this->cmsMenu['id'],
                ]
            )->render();
        }

        if (!defined($modelClass . '::custom_edit_box_title')) {
            $boxTitle = $data['title'] ?? '';
        } else {
            $boxTitle = $data[$modelClass::custom_edit_box_title] ?? $modelClass::custom_edit_box_title;
        }

        $titleView = view('Fantasy.cms_view.Edit.title', [
            'ids' => $this->req->ids,
            'data' => $data,
            'action' => $this->req->action,
            'boxTitle' => $boxTitle,
        ])->render();

        return [
            'titleView' => $titleView,
            'contentView' => $contentView,
            'data' => $data,
            'reviewNotifies' => $ReviewNotify,
        ];
    }

    /** @param Model $data */
    protected function getSon($data)
    {
        $ret = $data->getAttributes();
        $relations = $data->getRelations();
        foreach ($relations as $modelName => $content) {
            if (!$content instanceof Collection) {
                continue;
            }
            $ret['son'][$modelName] = [];
            foreach ($content as $d) {
                $ret['son'][$modelName][] = $this->getSon($d);
            }
        }
        return $ret;
    }

    protected function update(Request $req = null): UpdateResponse|null
    {

        $noParent = $req === null;
        $reviewDirty = [];
        $req = $req ?? $this->req;
        $role = $this->getRoles();
        $model = $this->modelArray[$req->modelName] ?? '';
        $ids = array_values(array_filter($req->ids, fn($id) => $id !== 0));
        $data = array_map(function ($d) {
            if (gettype($d) === 'array') {
                return json_encode($d);
            }
            return $d;
        }, $req->data);

        $data['branch_id'] = $this->branchOrigin->id;
        $parentId = 0;

        if (!$this->beforeUpdate($model, $data)) {
            throw new ErrorException('BeforeUpdate not finished.', 500);
        }

        if (!is_subclass_of($model, Model::class)) {
            throw new ErrorException('Model Key Not Exist : ' . $req->modelName, 500);
        }

        // delete
        if ($req->delete) {
            $this->delete($req);
            return null;
        }

        // create
        $isCreate = empty($ids);
        if ($isCreate) {
            list($ids, $parentId) = $this->create($model, $data, $noParent, $role);
        }

        $modelCollect = $isCreate ? [] : $model::when(!empty($ids), function ($q) use ($ids) {
            $idsStr = implode(', ', $ids);
            $q->whereIn('id', $ids)->orderBy(DB::raw("FIELD(id,{$idsStr})"));
        })->get();

        // update
        foreach ($modelCollect as $index => $m) {
            foreach ($data as $k => $v) {
                if ($m[$k] == $v || ($m[$k] == '0000-00-00' && $v === '')) {
                    continue;
                }
                $m[$k] = $v;
            }
            if ($m->isDirty()) {
                $reviewDirty = $m->getDirty();
                if ($noParent) {
                    unset($reviewDirty['is_visible']);
                    unset($reviewDirty['is_preview']);
                }
                if (count($reviewDirty) > 0) {
                    $reviewDirty[$index] = true;
                }
                if ($noParent) {
                    $m->create_id = session('fantasy_user')['id'];
                }
                $m->save();
                $this->addUpdateLog($m);
            }
            //刪除審核通知
            if ($role['need_review'] && $role['can_review'] && $m->is_reviewed == 1) {
                ReviewNotify::where('branch_id', $m->branch_id)
                    ->where('locale', $req->locale)
                    ->where('model', $req->modelName)
                    ->where('data_id', $m->id)
                    ->delete();
            }
            $parentId = $m->id;
        }

        $childResponse = [];
        if (count($ids) === 1) {
            foreach ($req->child ?? [] as $c) {
                $r = new Request;
                $c['data'][$c['parentKey']] = $parentId;
                $c['data']['is_reviewed'] = 1;
                unset($c['data']['quillFantasyKey']);
                unset($c['data']['quillSonFantasyKey']);
                foreach ($c as $k => $v) {
                    $r->{$k} = $v;
                }
                $childResponse[] = $this->update($r);
            }
        }

        $childIsDirty = array_reduce($childResponse, function ($res, $child) {
            return $child === null || $child->isDirty() || $res;
        }, false);

        if ($noParent && ($role['need_review'] && !$role['can_review'])) {
            foreach ($modelCollect as $index => $m) {
                $needUpdate = $reviewDirty[$index] ?? false;
                if ($needUpdate || $childIsDirty) {
                    $m->is_reviewed = 0;
                    $m->save();
                    $this->addUpdateLog($m);
                }
            }
        }

        $newData = $this->formatBuilder(
            $model,
            $model::where('branch_id', $this->branchOrigin->id)
                ->when(!empty($ids), function ($q) use ($ids) {
                    $idsStr = implode(', ', $ids);
                    $q->whereIn('id', $ids)->orderBy(DB::raw("FIELD(id,{$idsStr})"));
                })
                ->when(empty($ids), function ($q) {
                    $q->where('id', 0);
                })
        )
            ->get()
            ->keyBy('id');

        if (!$this->afterUpdate($model, $newData)) {
            throw new ErrorException('AfterUpdate not finished.', 500);
        }

        return UpdateResponse::create($ids, $newData, $childResponse, (count($reviewDirty) > 0 || $childIsDirty));
    }

    protected function create($model, $data, $noParent, $role)
    {
        unset($data['id']);
        $m = (new $model);
        $m->forceFill($data);
        if ($noParent) {
            $m->is_reviewed = ($role['need_review'] && $role['can_review'] && intval($data['is_reviewed'] ?? 0)) ? 1 : 0;
            $m->create_id = session('fantasy_user')['id'];
        }
        $m->save();
        $this->addCreateLog($m);

        $ids = [$m->id];
        $parentId = $m->id;
        return [$ids, $parentId];
    }

    protected function delete(Request $req = null)
    {
        $req = $req ?? $this->req;

        $model = $this->modelArray[$req->modelName] ?? '';
        $ids = $req->ids;

        if (!$this->beforeDelete($model, $ids)) {
            throw new ErrorException('BeforeDelete not finished.', 500);
        }

        if (!is_subclass_of($model, Model::class)) {
            throw new ErrorException($model . ' is not a model.', 500);
        }

        $child = $this->deleteArray[$req->modelName] ?? [];
        foreach ($child as $childModelName => $key) {
            $childmodel = $this->modelArray[$childModelName] ?? '';
            $childIds = $childmodel::whereIn($key, $ids)->pluck('id');
            $r = (new Request)->merge([
                'modelName' => $childModelName,
                'ids' => $childIds,
            ]);
            $this->delete($r);
        }

        $model::whereIn('id', $ids)->get()->each(function ($m) {
            $this->addDeleteLog($m);
            $m->delete();
        });

        if (!$this->afterDelete($model, $ids)) {
            throw new ErrorException('AfterDelete not finished.', 500);
        }

        return [
            'ids' => $ids,
        ];
    }

    protected function copy(Request $req = null, $isChild = false)
    {
        $req = $req ?? $this->req;

        $model = $this->modelArray[$req->modelName];
        $ids = $req->ids ?? [];
        $parentKey = $req->parentKey ?? '';
        $parentId = $req->parentId ?? 0;
        $newParentId = $req->newParentId ?? 0;

        if (!is_subclass_of($model, Model::class)) {
            throw new ErrorException($model . ' is not a model.', 500);
        }

        $modelCollect = $model::when(!empty($ids), function ($q) use ($ids) {
            $q->whereIn('id', $ids);
        })->when(!empty($parentId) && !empty($parentKey), function ($q) use ($parentId, $parentKey) {
            $q->where($parentKey, $parentId);
        })->get();

        $ids = [];

        foreach ($modelCollect as $key => $m) {
            $url_randkey = str_replace('.', '', microtime(true)) . $key;
            $fillData = $m->getAttributes();
            unset($fillData['id']);

            if (!empty($parentId) && !empty($parentKey) && !empty($newParentId)) {
                $fillData[$parentKey] = $newParentId;
            }

            if (!$isChild && isset($fillData['is_visible']))
                $fillData['is_visible'] = 0;
            if (!$isChild && isset($fillData['is_reviewed']))
                $fillData['is_reviewed'] = 0;
            if (!$isChild && isset($fillData['title']))
                $fillData['title'] .= '_clone';
            if (isset($fillData['url_name']))
                $fillData['url_name'] .= '_' . $url_randkey;
            if (isset($fillData['url_title']))
                $fillData['url_title'] .= '_' . $url_randkey;

            $newModel = new $model;
            $newModel->forceFill($fillData)->save();
            $ids[] = $newModel->id;

            $child = $this->copyArray[$req->modelName] ?? [];
            foreach ($child as $childModelName => $key) {
                $r = (new Request)->merge([
                    'parentKey' => $key,
                    'parentId' => $m->id,
                    'newParentId' => $newModel->id,
                    'modelName' => $childModelName,
                ]);
                $this->copy($r, true);
            }
        }
        return $this->formatBuilder(
            $model,
            $model::where('branch_id', $this->branchOrigin->id)
                ->when(!empty($ids), function ($q) use ($ids) {
                    $idsStr = implode(', ', $ids);
                    $q->whereIn('id', $ids)->orderBy(DB::raw("FIELD(id,{$idsStr})"));
                })
                ->when(empty($ids), function ($q) {
                    $q->where('id', 0);
                })
        )
            ->get()
            ->keyBy('id')
            ->all();
    }

    /**
     * @param CmsApi $api
     * @return CmsApi
     */
    final public function setNext(CmsApi $api)
    {
        if (!empty($api)) {
            $this->next = $api;
        }
        return $this->next;
    }
    protected function beforeUpdate(&$modelClass, &$data): bool
    {
        return true;
    }
    protected function afterUpdate(&$modelClass, &$newData): bool
    {
        return true;
    }
    protected function beforeDelete(&$modelClass, &$ids): bool
    {
        return true;
    }
    protected function afterDelete(&$modelClass, &$ids): bool
    {
        return true;
    }
}
