<?php
namespace App\Services\Cms\api\response;

use App\Models\Basic\Cms\CmsMenu;
use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\classes\CmsApiResponse;
use Countable;
use Illuminate\Support\Collection;

use function PHPSTORM_META\type;

class TableResponse implements CmsApiResponse
{
    public $colSetting;
    public $data;
    public $role;
    public $totalPage;
    public $perPage;
    public $crumb;
    public $unitTitle;
    public $btnBlade;
    public $modelName;
    public $perCount;
    public $totalCount;

    private function __construct(array $colSetting, string $modelName, Collection $data, array $role, int $totalPage, int $perPage, array $crumb, string $unitTitle, string $btnBlade, int $perCount,int $totalCount)
    {
        $this->colSetting = $colSetting;
        $this->data = $data;
        $this->role = $role;
        $this->totalPage = $totalPage;
        $this->perPage = $perPage;
        $this->crumb = $crumb;
        $this->unitTitle = $unitTitle;
        $this->btnBlade = $btnBlade;
        $this->modelName = $modelName;
        $this->perCount = $perCount;
        $this->totalCount = $totalCount;
    }

    /** @return array */
    public function toArray(): array
    {
        return [
            'colSetting' => $this->colSetting,
            'data' => $this->data,
            'role' => $this->role,
            'totalPage' => $this->totalPage,
            'perPage' => $this->perPage,
            'crumb' => $this->crumb,
            'unitTitle' => $this->unitTitle,
            'btnBlade' => $this->btnBlade,
            'modelName' => $this->modelName,
            'perCount' => $this->perCount,
            'totalCount' => $this->totalCount,
        ];
    }

    /** @return static */
    public static function create(ColumnSet $colSetting, string $modelName,  Countable | array $data, CmsMenu $cmsMenu = null, array $role = [], string $unitTitle = 'Wade Digital Design', int $totalPage = 1, int $perPage = 0,int $perCount = 0,int $totalCount = 0)
    {

        $colSet = $colSetting->get();

        foreach (['view','create', 'edit', 'delete', 'is_review_edit', 'isExport', 'reviewed', 'can_review', 'need_review'] as $key) {
            $role[$key] = $role[$key] ?? false;
        }

        $role['filter'] = $colSet['defaultColDef']['filter'] ?? false;

        if (!$data instanceof Collection) {
            $data = collect($data);
        }

        if(isset($role['maxAddCount']) && $role['maxAddCount'] != "" && count($data) >= $role['maxAddCount']){
            $hideCreate = 'd-none';
        }

        $btnBlade = view('Fantasy.cms_view.btn', [
            'roles' => $role,
            'cmsMenu' => $cmsMenu,
            'hideCreate'=>$hideCreate ?? ''
        ])->render();

        $crumb = [];
        if (!empty($cmsMenu)) {
            do {
                $crumb[] = $cmsMenu->title;
            } while ($cmsMenu = $cmsMenu['crumb']);
        }

        return new static($colSet, $modelName, $data, $role, $totalPage, $perPage, $crumb, $unitTitle, $btnBlade, $perCount, $totalCount);
    }
}
