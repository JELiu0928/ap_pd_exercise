@if($action === 'edit' || $action === 'sonEdit')
    <div class="title">
        <p class="editTypeTitle">Content 內容資訊</p>
    </div>
    <h3 class="dataEditTitle">{{ $boxTitle ?? 'Title' }}</h3>
@elseif($action === 'batch')
    <div class="title">
        <p class="editTypeTitle">Batch 批次修改 ( {{ count($ids) }}筆 )</p>
    </div>
    <h3 class="dataEditTitle">請於左方啟用要批次修改的資料</h3>
@elseif($action === 'search')
    <div class="title">
        <p class="editTypeTitle">Filter 資料篩選</p>
    </div>
    <h3 class="dataEditTitle">請於左方啟用要篩選的資料</h3>
@elseif($action === 'create')
    <div class="title">
        <p class="editTypeTitle">Create 新增資訊</p>
    </div>
    <h3 class="dataEditTitle">-</h3>
@endif
