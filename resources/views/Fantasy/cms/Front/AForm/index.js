if ($('.editSentBtn').length > 0) {
    let formHtml = `
        <li data-form="testForm" class="opened wait-sent">
            <a href="javascript:void(0);">
                <p class="menu_listName">打開表格</p>
            </a>
        </li>`;
    $('[data-form="Form0"]').after(formHtml);

    let _lbox = `
        <div class="overlay" id="overlay"
            style="position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
        ">
            <div class="modal" style="position: absolute;
            background-color: #fff;
            transform: translate(5%, 5%);
            width: 90%;
            height: 90%;
            padding: 20px;">
                <button id="closeModalButton">關閉</button>
                <div class="bkBox"></div>
                <button id="sendData">送出</button>
            </div>
        </div>`;

    // let _saveBtn = $('.editSentBtn').last().clone();
    // _saveBtn.removeClass('editSentBtn').addClass('editSentBtnCustom').hide();
    // $('.editSentBtn').last().after(_saveBtn)

    $('[data-form="testForm"]').on('click',async()=>{
        $('body').append(_lbox);
        $('#closeModalButton').on('click',()=>{
            $("#overlay").remove();
        });

        $.ajax({
            type: "post",
            url: $('.base-url-plus').val() + '/' + $('.base-location').val() + "/testTable/"+$('input[name="modelName"]').attr('data-id'),
            headers: {
                'content-type': 'application/json',
                'x-csrf-token': $("#_token").val(),
            }
        })
        .done(function (res) {
            //aggrid基本結構
            $('.bkBox').html(res.view);
            aggridInit();
        })
        .fail(function () {
            console.log('something not right.');
        });
    });

    //aggrid初始化
    function aggridInit(){

        function CheckboxRenderer() {}

        CheckboxRenderer.prototype.init = function(params) {
            this.params = params;
            this.checked = parseInt(params.value) === 1;

            this.eGui = document.createElement('input');
            this.eGui.type = 'checkbox';
            // this.eGui.classList.add('product-filter-checkbox');
            this.eGui.checked = this.checked;

            this.checkedHandler = this.checkedHandler.bind(this);
            this.params.eGridCell.addEventListener('click', this.checkedHandler);
        }

        CheckboxRenderer.prototype.checkedHandler = function(e) {
            this.checked = !this.checked;
            let checkedValue = this.checked ? 1 : 0;
            this.eGui.checked = this.checked;
            let colId = this.params.column.colId;
            let path = colId.split('.'); // '${id}.checked'
            let id = path.shift(); //表頭id
            let key = path.shift();
            let rowIndex = this.params.rowIndex;

            if (Object.keys(prevChangeCheckbox).length > 0 && keydownShift) {

                let rowIndexMin = Math.min(prevChangeCheckbox.rowIndex, rowIndex)
                let rowIndexMax = Math.max(prevChangeCheckbox.rowIndex, rowIndex)
                let cellIndexMin = Math.min(prevChangeCheckbox.id, id)
                let cellIndexMax = Math.max(prevChangeCheckbox.id, id)
                for (let i = rowIndexMin; i <= rowIndexMax; i++) {
                    for (let j = cellIndexMin; j <= cellIndexMax; j++) {
                        gridOption.api.getDisplayedRowAtIndex(i).setDataValue(j + '.' + key, checkedValue);
                    }
                }
            }
            if (Object.keys(prevChangeCheckbox).length == 0 || !keydownShift) {
                $('[row-index="' + prevChangeCheckbox.rowIndex + '"] [col-id="' + prevChangeCheckbox.id + '.' + key + '"]').css("border", ""); //其餘儲存格移除樣式
                $('[row-index="' + rowIndex + '"] [col-id="' + id + '.' + key + '"]').css("border", "2px solid red"); //第一個儲存格框選樣式
                prevChangeCheckbox.rowIndex = rowIndex;
                prevChangeCheckbox.id = id;
                prevChangeCheckbox.checked = checkedValue;
            }
            gridOption.api.getDisplayedRowAtIndex(rowIndex).setDataValue(id + '.' + key, checkedValue);
        }

        CheckboxRenderer.prototype.getGui = function(params) {
            return this.eGui;
        }
        //賦值後觸發 init destroy 避免多次綁定
        CheckboxRenderer.prototype.destroy = function(params) {
            this.params.eGridCell.removeEventListener('click', this.checkedHandler);
        }

        //表頭定義
        var _columnDefs = JSON.parse($("#bkColDef").val());
        //表格資料
        var _rowData = JSON.parse($("#bkRowData").val());
        //儲存格形式 文字 選擇匡
        var _cellType = $("#bkCellType").val();
        //預設為文字輸入
        var gridOption = {
            rowHeight: 30, //设置行高为30px,默认情况下是25px
            columnDefs: _columnDefs,
            rowData: _rowData,
            onGridReady: function() {
                //表格创建完成后执行的事件
                // gridOption.api.sizeColumnsToFit();//调整表格大小自适应
            },
            // components: {
            //     checkboxRenderer: CheckboxRenderer
            // },
            defaultColDef: {
                editable: true, //单元表格是否可编辑
                enableRowGroup: true,
                enablePivot: true,
                enableValue: true,
                sortable: true, //开启排序
                resizable: true, //是否可以调整列大小，就是拖动改变列大小
                filter: true, //开启刷选
                // cellEditor: 'agLargeTextCellEditor', // 啟用多行文本輸入
                width: 100,
            },
            pagination: false, //开启分页（前端分页）
            paginationAutoPageSize: false, //根据网页高度自动分页（前端分页）
            suppressMovableColumns: true,
            suppressDragLeaveHidesColumns: true,
            tooltipShowDelay: 1000,
            columnHoverHighlight: true,
            //**************设置置顶行样式**********
            getRowStyle: function(params) {
                if (params.node.rowPinned) {
                    return {
                        'font-weight': 'bold',
                        'color': 'red'
                    };
                }
            },
        };
        //單行編輯
        if(_cellType==0){}
        //多行編輯
        if(_cellType==1){
            gridOption.defaultColDef.cellEditor = 'agLargeTextCellEditor';
        }
        //選擇框
        if(_cellType==2){
            gridOption.components = {checkboxRenderer: CheckboxRenderer};
            gridOption.defaultColDef.editable = false;
        }

        //偵測shift是否被按
        var keydownShift = false;
        //shift被按時的儲存格內容
        var prevChangeCheckbox = {};

        //偵測shift是否按著
        $('#bkGrid').on('keydown', function(e) {
            if (e.key === "Shift" && keydownShift == false) {
                keydownShift = true;
            }
        });
        $('#bkGrid').on('keyup', function(e) {
            if (e.key === "Shift" && keydownShift == true) {
                keydownShift = false;
            }
        });

        //aggrid初始化
        var eGridDiv = document.querySelector('#bkGrid');
        new agGrid.Grid(eGridDiv, gridOption);

        //送出資料
        $('#sendData').on('click',()=>{
            submit();
        })
        function submit() {
            gridOption.api.stopEditing();
            var sendData = {};
            sendData.data = {};
            sendData.model = $('#modelName').val();
            sendData.formID = $('#formID').val();
            gridOption.api.forEachNode((r, key) => {
                sendData.data[key] = r.data;
            });

            $.ajax({
                type: "post",
                url: $('.base-url-plus').val() + '/' + $('.base-location').val() + "/testTableSave",
                data: sendData,
                headers: {
                    'x-csrf-token': $("#_token").val(),
                }
            })
            .done(function(res) {
                alert('儲存')
            });

        }
    }

}
