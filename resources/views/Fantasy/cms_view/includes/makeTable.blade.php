{{-- 將搜尋條件放在頁面上以供使用 --}}
@foreach ($search as $key => $value)
@if ($key == 'sort')
<input type="hidden" class="searchRulesSet" data-type="sort" data-name="{{ key($value) }}" data-value="{{ current($value) }}">
@else
<input type="hidden" class="searchRulesSet" data-type="{{$value['type']}}" data-name="{{$key}}" data-value="{{ is_array($value['value']) ? json_encode($value['value'],JSON_UNESCAPED_UNICODE) : $value['value'] }}">
@endif
@endforeach
<input type="hidden" class="search_type" value="{{$search_type}}">
<div class="content-head cms-index_table" data-menu_id="{{$menu_id}}" data-can_review="{{$can_review}}" data-edit="{{$isEdit}}" data-delete="{{$isDelete}}" data-create="{{$isCreate}}" data-model="{{$modelName}}" data-page="{{$page}}" data-pn="{{$pn}}" data-auth="{{$hasAuth}}" data-pagetitle="{{$pageTitle}}" data-issearch="{{$isSearch}}" data-isbatch="{{$isBatch}}" data-isClone="{{$isClone}}" data-isExport="{{$isExport}}">
    <h1>{{$pageTitle}}
        @if(!empty($pageIntroduction))
        <i class="fa fa-info-circle i_tooltip" data-toggle="tooltip" data-placement="top" data-original-title="{{$pageIntroduction}}"></i>
        @endif
    </h1>
    <div class="content-nav">
        <div class="navleft">

            @if($isLink!="")
            <div class="btn-item">
                <a href="{{BaseFunction::b_url('') . $isLink}}" target="_blank" class="link-btn">
                    <span class="icon-dashbord"></span>
                    <span class="text">Link 單元連結</span>
                </a>
            </div>
            @endif

            {{-- 新增按鈕 --}}
            @if ($isCreate == 1)
            <div class="btn-item">
                <a href="javascript:void(0)" class="createBtn" data-model="{{$modelName}}">
                    <span class="icon-add"></span>
                    <span class="text">ADD DATA 新增</span>
                </a>
            </div>
            @endif
            @if ($isImport == 1)
            <div class="btn-item">
                <a href="javascript:void(0)" class="ImportBtn" data-model="{{$modelName}}">
                    <span class="icon-option"></span>
                    <span class="text">Import 匯入</span>
                </a>
            </div>
            @endif
            {{-- 刪除按鈕 --}}
            @if ($isDelete == 1)
            <div class="btn-item">
                <a href="javascript:void(0)" class="remove-data-btn" id="leon-cms-delete-list" data-model="{{$modelName}}">
                    <span class="icon-delete"></span>
                    <span class="text">DELETE 刪除</span>
                </a>
            </div>
            @endif
            @if(count($data) > 0 && $isBatch == 1)
            <div class="btn-item dropdown">
                <a href="javascript:void(0)" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon-batch"></span>
                    <span class="text">BATCH 批次修改</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left profile-dropdown" role="menu">
                    <a href="javascript:void(0)" class="dropdown-item batchBtn" data-model="{{$modelName}}" data-action="1">
                        <i class="pg-outdent"></i> 批次修改 : 選取資料
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item batchBtn" data-model="{{$modelName}}" data-action="2">
                        <i class="pg-outdent"></i> 批次修改 : 篩選結果
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item batchBtn" data-model="{{$modelName}}" data-action="3">
                        <i class="pg-outdent"></i> 批次修改 : 全部資料
                    </a>
                    <a href="javascript:void(0)" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left">關閉選單</span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>
                </div>
            </div>
            @endif
            @if(count($data) > 0 && ($isExport == 1 || $isExport2 == 1 || $isClone == 1))
            <div class="btn-item dropdown">
                <a href="javascript:void(0)" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon-option"></span>
                    <span class="text">OPTION 選項</span>
                </a>

                <div class="dropdown-menu dropdown-menu-left profile-dropdown" role="menu">

                    @if ($isExport == 1)
                    <a href="{{BaseFunction::f_url("export/".$exportName)}}" target="_blank" class="dropdown-item ExportBtn" data-model="{{$modelName}}" title="匯出所有資料">
                        <i class="pg-outdent"></i>匯出Excel : 全部資料
                    </a>
                    <a href="javascript:void(0)" class="dropdown-item ExportBtnSrh" style="display:none;" data-href="{{BaseFunction::f_url("Excel/".$exportName)}}" data-model="{{$modelName}}" title="目前篩選資料">
                        <i class="pg-outdent"></i>匯出Excel : 篩選資料
                    </a>
                    @endif

                    @if ($isExport == 1)
                    <a href="javascript:void(0)" class="dropdown-item ExportBtnCheck" data-model="{{$modelName}}" title="下載勾選項目">
                        <i class="pg-outdent"></i> 匯出Excel : 選取資料
                    </a>
                    @endif

                    @if($isClone == 1)
                    <a href="javascript:void(0)" class="dropdown-item cloneBtn" data-model="{{$modelName}}">
                        <i class="pg-refresh_new"></i> 複製資料
                    </a>
                    @endif

                    <a href="javascript:void(0)" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left">關閉選單</span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>

                </div>
            </div>
            @endif
        </div>

        <div class="navright">
            {{-- 快速搜尋 --}}
            @if($QuickSearch != '')
            <a href="javascript:void(0)" class="btn-item searchbar" data-quick="{{$QuickSearch}}" data-type="{{ $QuickType }}">
                <span class="icon-search quickSearchBtn"></span>
                @if ($search_type == 'fast')
                <input type="text" class="search-data active" value="{{$search[array_key_first($search)]['value']}}">
                @else
                <input type="text" class="search-data">
                @endif
                <span class="text quickSearchBtn">SEARCH</span>
            </a>
            @endif
            <a href="javascript:void(0)" class="btn-item quickSearchBtn reload" data-model="{{$modelName}}">
                <span class="text">RELOAD</span>
            </a>
            {{-- Filter按鈕 --}}
            @if($isSearch == 1)
            <a href="javascript:void(0)" class="btn-item searchBtn" data-model="{{$modelName}}">
                <span class="icon-filter"></span>
                <span class="text">FILTER</span>
            </a>
            @endif

        </div>
    </div>
</div>

<div class="content-body">
    {{-- 表頭 --}}
    <div class="datatable">
        <table class="tables">
            <thead>
                <tr>
                    <th class="w_Check w_Check_all">
                        <div class="fake-thead" style="pointer-events: none;">
                            <div class="fake-th first">
                                <label class="select-item">
                                    <input type="checkbox">
                                    <span class="check-circle icon-check"></span>
                                </label>
                            </div>
                        </div>
                    </th>
                    {{-- thead --}}
                    @foreach ($tableSet as $key => $value)

                    @switch($value['type'])
                    @case('w_rank')
                    <th class="text-center w_Sort rwdhide">
                        <div class="fake-th {{(isset($search['sort']['w_rank']) && $search['sort']['w_rank'] == 'asc') ? 'active' : ''}}">
                            <span class="sort theadSortBtn" data-column="w_rank">排序</span>
                        </div>
                    </th>
                    @break

                    @case('preview')
                    <th class="text-center w_Preview">
                        <div class="fake-th {{(isset($search['sort']['is_preview']) && $search['sort']['is_preview'] == 'asc') ? 'active' : ''}}">
                            <span class="sort theadSortBtn" data-column="is_preview">預覽</span>
                        </div>
                    </th>
                    @break

                    @case('review')
                    <th class="text-center w_Status w150">
                        <div class="fake-th {{(isset($search['sort']['is_visible']) && $search['sort']['is_visible'] == 'asc') ? 'active' : ''}}">
                            <span class="sort theadSortBtn" data-column="is_visible">發佈審核</span>
                        </div>
                    </th>
                    @break
                    @case('visible')
                    <th class="text-center w_Status">
                        <div class="fake-th {{(isset($search['sort']['is_visible']) && $search['sort']['is_visible'] == 'asc') ? 'active' : ''}}">
                            <span class="sort theadSortBtn" data-column="is_visible">顯示狀態</span>
                        </div>
                    </th>
                    @break

                    @case('admin')
                    <th class="text-center w_Admin rwdhide">
                        <div class="fake-th {{(isset($search['sort']['create_id']) && $search['sort']['create_id'] == 'asc') ? 'active' : ''}}">
                            <span class="sort theadSortBtn" data-column="create_id">管理者</span>
                        </div>
                    </th>
                    @break

                    @case('updated')
                    <th class="w_Update">
                        <div class="fake-th {{(isset($search['sort']['updated_at']) && $search['sort']['updated_at'] == 'asc') ? 'active' : ''}}">
                            <span class="sort theadSortBtn" data-column="updated_at">最後異動時間</span>
                        </div>
                    </th>
                    @break

                    @case('none')
                    <th class="">
                        <div class="fake-th">
                            <span></span>
                        </div>
                    </th>
                    @break

                    @case('function')
                    <th class="fake-th-test">
                        <div class="fake-th">
                            <span>快速功能</span>
                        </div>
                    </th>
                    @break

                    @default
                    <th class="{{$value['width']}} {{$value['text-center'] == true ? "text-center" : ""}}">
                        <div class="fake-th {{(isset($search['sort'][$value['columns']]) && $search['sort'][$value['columns']] == 'asc') ? 'active' : ''}}">
                            @if(isset($value["columns"]))
                            <span class="sort theadSortBtn" data-column="{{$value['columns']}}">{{$value['title']}}</span>
                            @else
                            <span class="">{{$value['title']}}</span>
                            @endif
                        </div>
                    </th>
                    @endswitch
                    @endforeach
                </tr>
            </thead>

            {{-- tbody --}}
            <tbody>
                @foreach ($data as $key => $value)
                <tr>
                    <td class="text-center w_Check">
                        <div class="tableContent">
                            <label class="select-item">
                                <input type="checkbox" data-id="{{$value['id']}}">
                                <span class="check-circle icon-check"></span>
                            </label>
                        </div>
                    </td>
                    @foreach ($tableSet as $key2 => $value2)
                    @if($value2['type'] == 'text_image')
                    @php
                    $img_array = explode(",", $value2['img']);
                    $tempImg = '/noimage.svg';
                    foreach($img_array as $img_arrayVal){
                    if(isset($fileRouteArray[$value[$img_arrayVal]])){
                    $tempImg = $fileRouteArray[$value[$img_arrayVal]]['real_route'];
                    break;
                    }
                    }
                    @endphp
                    <td class="@if($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableMaintitle">
                            <img src="{{$tempImg}}" alt="" class="title-img rwdhide">
                            <span class="title-name">{{$value[$value2['columns']]}}</span>
                        </div>
                    </td>
                    @elseif($value2['type'] == 'function')

                    <td class="run_function @if($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-function="{{$value2['function']}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{$value2['title']}}</div>
                    </td>

                    @elseif($value2['type'] == 'text_image2')

                    <td class="@if($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableMaintitle">
                            @if (!empty($value[$value2['img']]))
                            <img src="{{$value[$value2['img']]}}" alt="" class="title-img rwdhide">
                            @else
                            <img src="/noimage.svg" alt="" class="title-img rwdhide">
                            @endif
                            <span class="title-name">{{$value[$value2['columns']]}}</span>
                        </div>
                    </td>

                    @elseif ($value2['type'] == 'select')
                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">
                            @php
                            if(isset($value2['options1'])){
                            $temp_str = collect($value2['options'])->where('key',$value[$value2['columns']])->first()['title'] ?? '';
                            $temp_str1 = collect($value2['options1'])->where('key',$value[$value2['columns1']])->first()['title'] ?? '';
                            echo ($temp_str != '-') ? $temp_str : $temp_str1;
                            }else{
                            echo collect($value2['options'])->where('key',$value[$value2['columns']])->first()['title'] ?? '';
                            }
                            @endphp

                        </div>
                    </td>

                    @elseif($value2['type'] == 'select_parent')
                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{$value[$value2['parent']][$value2['parentTitle']]}}</div>
                    </td>


                    @elseif($value2['type'] == 'select_grandparent')

                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{$value[$value2['parent']][$value2['grandparent']][$value2['grandparentTitle']]}}</div>
                    </td>

                    @elseif ($value2['type'] == 'select_mult')

                    @php
                    if(!empty($value[$value2['columns']])){
                    $tempText = config('models.' . $value2['parent'])::whereIn('id', json_decode($value[$value2['columns']], true))->get()->pluck($value2['parentTitle']);
                    $multText = !empty($tempText) ? implode("<br>", $tempText->toarray()) : "";
                    }else{
                    $multText ="";
                    }
                    @endphp

                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{!!$multText!!}</div>
                    </td>

                    @elseif ($value2['type'] == 'selectMulti')

                    @php
                    $selectMultiData = [];
                    $search_id = json_decode($value[$value2['columns']], true);
                    $search_id = (!empty($search_id)) ? $search_id : [];
                    foreach($value2['options'] as $val){
                    if(in_array($val['key'],$search_id)){
                    $selectMultiData[] = $val['title'];
                    }
                    }
                    $multText = !empty($selectMultiData) ? implode("<br>", $selectMultiData) : "";
                    @endphp

                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{!!$multText!!}</div>
                    </td>

                    @elseif($value2['type'] == 'text')

                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{$value[$value2['columns']]}}</div>
                    </td>

                    @elseif($value2['type'] == 'radio')

                    <td class="@if ($value2['text-center'])text-center @endif @if($value2['width']){{$value2['width']}}@endif">
                        <div class="tableContent">
                            <label class="switch reSwitchBtn" data-id="{{$value['id']}}" data-model="{{$modelName}}" data-column="{{$value2['columns']}}">
                                <input type="checkbox" {{$value[$value2['columns']] == 1 ? 'checked' : ''}}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </td>

                    @elseif($value2['type'] == 'w_rank')

                    <td class="text-center w_Sort rwdhide {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{$value['w_rank']}}</div>
                    </td>

                    @elseif($value2['type'] == 'preview')

                    <td class="text-center w_Preview">
                        <div class="tableContent">
                            <label class="switch reSwitchBtn" data-id="{{$value['id']}}" data-model="{{$modelName}}" data-column="is_preview">
                                <input type="checkbox" {{$value['is_preview'] == 1 ? 'checked' : ''}}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </td>
                    @elseif($value2['type'] == 'review')
                    @if($can_review)
                    <td class="text-center w_Preview">
                        <div class="tableContent">
                            <label class="switch reSwitchBtn" data-id="{{$value['id']}}" data-model="{{$modelName}}" data-column="is_visible">
                                <input type="checkbox" {{$value['is_visible'] == 1 ? 'checked' : ''}}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </td>
                    @else
                    <td class="text-center w_Status {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{($value['is_visible'] == 1) ? 'Publish' : 'Unpublished'}}</div>
                    </td>
                    @endif

                    @elseif($value2['type'] == 'visible')
                    <td class="text-center w_Preview">
                        <div class="tableContent">
                            <label class="switch reSwitchBtn" data-id="{{$value['id']}}" data-model="{{$modelName}}" data-column="is_visible">
                                <input type="checkbox" {{$value['is_visible'] == 1 ? 'checked' : ''}}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </td>

                    @elseif($value2['type'] == 'admin')

                    <td class="text-center w_Admin rwdhide {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{(!isset($fantasyUser[$value['create_id']]) || $value['create_id'] == 0) ? '' : $fantasyUser[$value['create_id']]}}</div>
                    </td>

                    @elseif($value2['type'] == 'updated')

                    <td class="w_Update {{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">{{$value['updated_at']}}</div>
                    </td>

                    @elseif($value2['type'] == 'none')

                    <td class="{{$editClass}}" data-id="{{$value['id']}}" data-model="{{$modelName}}">
                        <div class="tableContent">點擊編輯</div>
                    </td>

                    @endif
                    @endforeach
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="pageCountContent">
        <div class="page-count">Showing <span>{{number_format(((($page - 1) * config('cms.pageSize')) + 1))}}</span> to <span>{{number_format($page * config('cms.pageSize'))}}</span> of <span>{{number_format($count)}}</span> Data</div>

        <div class="page-select">
            <nav aria-label="Page navigation">
                <ul class="pagination">

                    {{-- 上一頁 --}}
                    @if($page != 1)
                    <li class="page-item pn_btn" data-type="page" data-page="1">
                        <a class="page-link" href="javascript:void(0)">
                            << FIRST </a> </li> <li class="page-item pn_btn" data-type="last">
                                <a class="page-link" href="javascript:void(0)">
                                    < PREV </a> </li> @endif {{-- 上十頁 --}} @if($page> 10)
                    <li class="page-item pn_btn" data-type="last10">
                        <a class="page-link" href="javascript:void(0)">...</a>
                    </li>
                    @endif

                    {{-- 上兩頁 --}}
                    @if ($page > 2)
                    <li class="page-item pn_btn" data-type="page" data-page="{{($page - 2)}}">
                        <a class="page-link" href="javascript:void(0)">{{($page - 2)}}</a>
                    </li>
                    @endif

                    {{-- 上一頁 --}}
                    @if ($page != 1)
                    <li class="page-item pn_btn" data-type="page" data-page="{{($page - 1)}}">
                        <a class="page-link" href="javascript:void(0)">{{($page - 1)}}</a>
                    </li>
                    @endif

                    {{-- 這一頁 --}}
                    <li class="page-item pn_btn active" data-type="page" data-page="{{$page}}">
                        <a class="page-link" href="javascript:void(0)">{{$page}}</a>
                    </li>

                    {{-- 下一頁 --}}
                    @if( ($pn - $page) > 0)
                    <li class="page-item pn_btn" data-type="page" data-page="{{($page + 1)}}">
                        <a class="page-link" href="javascript:void(0)">{{($page + 1)}}</a>
                    </li>
                    @endif

                    {{-- 下兩頁 --}}
                    @if (($pn - $page) > 1)
                    <li class="page-item pn_btn" data-type="page" data-page="{{($page + 2)}}">
                        <a class="page-link" href="javascript:void(0)">{{($page + 2)}}</a>
                    </li>
                    @endif

                    {{-- 下十頁 --}}
                    @if (($pn - $page) > 10)
                    <li class="page-item pn_btn" data-type="next10"><a class="page-link" href="javascript:void(0)">...</a></li>
                    @endif

                    {{-- 下一頁 --}}
                    @if (($pn - $page) > 0)
                    <li class="page-item pn_btn" data-type="next"><a class="page-link" href="javascript:void(0)">NEXT ></a></li>
                    <li class="page-item pn_btn" data-type="page" data-page="{{($pn)}}"><a class="page-link" href="javascript:void(0)">LAST >></a></li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>

</div>
