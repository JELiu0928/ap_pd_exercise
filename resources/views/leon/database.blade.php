@extends('leon.template')
@section('content')
<h4>資料表<a href="/leon/database/add">新增</a></h4>
<div class="note">
    <table>
        <tr>
            <td style="width:150px;">標題</td>
            <td style="width:150px;">名稱</td>
            <td>功能</td>
            <td style="width:150px;">功能</td>
        </tr>
        @foreach($leon_database as $val)
            <tr>
                <td>{{ $val['db_note'] }}</td>
                <td><a href="/leon/database/add/{{ $val['id'] }}">{{ $val['db_name'] }}</td>
                <td class="btn other_data" data-id="{{ $val['id'] }}">
                    <a data-key="is_onepage" class="{{ $val['other_data']['is_onepage']??0 ? 'active':'' }}">獨立</a>
                    <a data-key="is_visible" class="{{ $val['other_data']['is_visible']??0 ? 'active':'' }}">顯示</a>
                    <a data-key="is_rank" class="{{ $val['other_data']['is_rank']??0 ? 'active':'' }}">排序</a> 
                    <a data-key="isDelete" class="{{ $val['other_data']['isDelete']??0 ? 'active':'' }}">禁刪</a>
                    <a data-key="isCreate" class="{{ $val['other_data']['isCreate']??0 ? 'active':'' }}">禁增</a>
                    <a data-key="isCopy" class="{{ $val['other_data']['isCopy']??0 ? 'active':'' }}">禁複</a>
                    <a data-key="isExport" class="{{ $val['other_data']['isExport']??0 ? 'active':'' }}">匯出</a>
                    <a data-key="isShareModel" class="{{ $val['other_data']['isShareModel']??0 ? 'active':'' }}">共用表</a>
                    <a data-key="isSeo" class="{{ $val['other_data']['isSeo']??0 ? 'active':'' }}">seo</a>
                    <a data-key="isClose" class="{{ $val['other_data']['isClose'] ?? 0 ? 'active':'' }}">blade不改</a>
                    <a data-key="isArticle" class="{{ $val['other_data']['isArticle'] ?? 0 ? 'active':'' }}">段落編輯</a>
                    <a data-key="isArticleImg" class="{{ $val['other_data']['isArticleImg'] ?? 0 ? 'active':'' }}">段落圖影</a>
                </td>
                <td class="btn" data-id="{{ $val['id'] }}">
                    <a data-key="is_onepage" class="">刪除</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@stop

    @section('script')
    <script>
        $(".folderList div").click(function () {
            let val = $(this).html();
            $('[name="path"]').val(val);
        });
        $(".bladeList div").click(function () {
            let val = $(this).html();
            $('[name="blade_path"]').val(val);
        });

        $(".other_data a").click(function () {
            let _this = $(this);
            let _key = _this.data('key');
            let _dataId = _this.closest('.btn').data('id');
            let value = 0;
            if (!_this.hasClass('active')) {
                value = 1;
            }
            $.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    ajax: true,
                    _key: _key,
                    _dataId: _dataId,
                    value: value
                }
            }).done(function (response) {
                if (!_this.hasClass('active')) {
                    _this.addClass('active');
                } else {
                    _this.removeClass('active');
                }
            }).fail(function () {
                console.log("ajax error");
            });
        });

    </script>
    @stop
