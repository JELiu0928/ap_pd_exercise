@extends('leon.template')
@section('content')
<h4>資料表</h4>

<div class="note" data-id="{{ $id }}">
    <div class="btn other_data">
        <a data-key="is_onepage" class="{{ $other_data['is_onepage']??0 ? 'active':'' }}">獨立</a>
        <a data-key="is_visible" class="{{ $other_data['is_visible']??0 ? 'active':'' }}">顯示</a>
        <a data-key="is_rank" class="{{ $other_data['is_rank']??0 ? 'active':'' }}">排序</a> 
        <a data-key="isDelete" class="{{ $other_data['isDelete']??0 ? 'active':'' }}">禁刪</a>
        <a data-key="isCreate" class="{{ $other_data['isCreate']??0 ? 'active':'' }}">禁增</a>
        <a data-key="isExport" class="{{ $other_data['isExport']??0 ? 'active':'' }}">匯出</a>
        <a data-key="isShareModel" class="{{ $other_data['isShareModel']??0 ? 'active':'' }}">共用表</a>
        <a data-key="isSeo" class="{{ $other_data['isSeo']??0 ? 'active':'' }}">seo</a>
        <a data-key="isClose" class="{{ $other_data['isClose'] ?? 0 ? 'active':'' }}">blade不改</a>
        <a data-key="isArticle" class="{{ $val['other_data']['isArticle'] ?? 0 ? 'active':'' }}">段落編輯</a>
        <a data-key="isArticleImg" class="{{ $val['other_data']['isArticleImg'] ?? 0 ? 'active':'' }}">段落圖影</a>
    </div>
    <div id="spreadsheet"></div>
    <div class="action-btn">
        <div class="btn-create">建立</div>
    </div>
</div>
@stop
    @section('script')

    <script type="text/javascript">
        $(".other_data a").click(function(){
            $(this).toggleClass('active');
        });

        var spreadsheet;
        $(".btn-create").click(function () {
            let other_data = {};
            $(".other_data a").each(function(){
                let key = $(this).attr('data-key');
                let active = $(this).hasClass('active');
                other_data[key] = active ? 1 : 0;
            });


            let spreadsheetData = spreadsheet.getData();
            var database = [];
            let temp_name = "";
            spreadsheetData.forEach(function (value) {
                //資料表名
                if (value['note'] != "" && value['name'] != "" && value['type'] == "" && value['formtype'] == "") {
                    temp_name = value['name'];
                    database[temp_name] = {
                        note: value['note'],
                        name: value['name'],
                        list: []
                    };
                } else {
                    if (value['note'] != "" && value['name'] != "") {
                        database[temp_name]['list'].push(value);
                    }
                }
            });

            let ajax_count = 0;
            Object.keys(database).forEach(function (value) {
                $.ajax({
                    url: location.href,
                    type: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    data: {
                        ajax: true,
                        value: database[value],
                        otherdata:other_data
                    }
                }).done(function (response) {
                    ajax_count = ajax_count + 1;
                    if (ajax_count == Object.keys(database).length) {
                        alert('ok');
                    }
                }).fail(function () {
                    console.log("ajax error");
                });
            });
        });


        let columns = [{
                width: 50,
                key: 'show',
                type: 'checkbox',
                title: '表格'
            },
            {
                width: 50,
                key: 'show_rank',
                type: 'text',
                title: '表排'
            },
            {
                width: 50,
                key: 'excel',
                type: 'checkbox',
                title: '匯出'
            },
            {
                width: 50,
                key: 'batch',
                type: 'checkbox',
                title: '批次'
            },
            {
                width: 50,
                key: 'search',
                type: 'checkbox',
                title: '搜尋'
            },
            {
                width: 50,
                key: 'son',
                type: 'checkbox',
                title: '次分類'
            },
            {
                width: 50,
                key: 'disable',
                type: 'checkbox',
                title: '禁改'
            },
            {
                width: 50,
                key: 'lang',
                type: 'checkbox',
                title: '多語'
            },
            {
                width: 130,
                key: 'note',
                type: 'text',
                title: '欄位描述'
            },
            {
                width: 130,
                key: 'name',
                type: 'text',
                title: '欄位名稱'
            },
            {
                width: 130,
                key: 'type',
                type: 'autocomplete',
                title: '欄位類型',
                source: ['int', 'text', 'varchar', 'date', 'datetime', 'double', 'float', 'json']
            },
            {
                width: 130,
                key: 'formtype',
                type: 'autocomplete',
                title: '表單類型',
                source: [
                    'textInput',
                    'lang_textInput',
                    'textInputTarget',
                    'textInputTargetAcc',
                    'textArea',
                    'lang_textArea',
                    'radio_btn',
                    'radio_area',
                    'select2',
                    'select2Multi',
                    'imageGroup',
                    'imageGroup_all',
                    'imageGroup_3size',
                    'imageGroup_array',
                    'colorPicker',
                    'datePicker',
                    'filePicker',
                    'numberRange',
                    // 'inputHidden',
                    // 'sn_textArea',
                    'numberInput',
                    // 'reviewed_radio_btn',
                    // 'select',
                    // 'selectBydata',
                    // 'selectMulti',
                    // 'selectMultiBydata',
                    // 'selectGroup',
                    // 'selectGroupDownward',
                    // 'selectGroupUpward',
                    'dateRange',
                ]
            },
            {
                width: 120,
                key: 'model',
                type: 'text',
                title: '選單資料來源'
            },
            {
                width: 80,
                key: 'tip',
                type: 'text',
                title: 'Tip提示'
            },
            {
                width: 80,
                key: 'tab',
                type: 'text',
                title: '換頁標籤'
            },
            {
                width: 80,
                key: 'img',
                type: 'text',
                title: '圖片來源'
            },
            {
                width: 80,
                key: 'other',
                type: 'text',
                title: '其他'
            },
        ]

        let colWidths = columns.map((function (value, index) {
            return value['width'];
        }));

        if ($(".note").attr('data-id') != "") {
            $.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    ajax: true,
                    getdata: true,
                    id: $(".note").attr('data-id')
                }
            }).done(function (response) {
                console.log(response);
                let newData = [];
                response.map(function (item, index) {
                    let temparr = [];
                    for (const key in columns) {
                        let val = item[columns[key]['key']] || '';
                        temparr.push(val);
                    }
                    newData.push(temparr);
                });
                let colWidths = columns.map((function (value, index) {
                    return value['width'];
                }));
                spreadsheet = jexcel(document.getElementById('spreadsheet'), {
                    data: newData,
                    colWidths: colWidths,
                    minDimensions: [5, 10],
                    columns: columns
                });
            }).fail(function () {
                console.log("ajax error");
            });
        } else {
            spreadsheet = jexcel(document.getElementById('spreadsheet'), {
                data: [],
                colWidths: colWidths,
                minDimensions: [5, 10],
                columns: columns
            });
        }

    </script>
    @stop
