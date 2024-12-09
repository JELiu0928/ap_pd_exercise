if ($(".editSentBtn").length > 0) {
    var specificationNewForm = $(`
            <a style="float:left;padding: 6px 8px;margin-bottom: 10px;display: inline-flex;align-items:center;background-color: #c00;color: #fff;cursor: pointer;">
                <li class="specificationForm">產品規格表管理</li>
            </a>
        `);

    $(".bkSpecificationBtn").before(specificationNewForm);
    $(".specificationForm").on("click", async () => {
        if (confirm("要使用本按鈕功能必須先進行存檔，按下確定後將會自動儲存")) {
            $(".editSentBtnCustom").click();
        } else {
            return;
        }
        bkModalInit("item-specification-modal"); // 初始化燈箱
        bkModalOpen("item-specification-modal", itemSpecificationModalSet); // 開啟燈箱
    });
    function itemSpecificationModalSet() {
        let sendData = {
            itemId: dataID,
        };
        console.log("sendData==", sendData);
        itemSpecificationAggridAjax(sendData);
    }
    function itemSpecificationAggridAjax(sendData = {}) {
        $.ajax({
            type: "post",
            url:
                $(".base-url-plus").val() +
                "/" +
                $(".base-location").val() +
                "/Ajax/cms/getItemSpecificationCmsView",
            data: JSON.stringify(sendData),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
            .done(function (res) {
                console.log("res = ", res);
                $("#item-specification-modal .bk-modal-content").append(
                    res.view
                );
                specAggridInit();
                bkModalLoaded("item-specification-modal");
            })
            .fail(function () {
                console.log("something not right.");
                bkModalLoaded("item-specification-modal");
            });
    }

    function specAggridInit() {
        // console.log("未解析前", $("#productColumns").val());
        let productColumns = JSON.parse($("#productColumns").val());
        let productData = JSON.parse($("#productData").val());
        console.log("Columns:", productColumns);
        console.log("productData:", productData);
        let aggridOptions = {
            rowHeight: 50, //設定行高為30px,預設為25px
            columnDefs: productColumns,
            // rowData: [],
            rowData: productData,
            // onGridReady: function () {
            // //表格建立完成後執行的事件
            // // itemSpecificationAggridOptions.api.sizeColumnsToFit();//調整表格大小自適應
            // },
            defaultColDef: {
                editable: true, //單元表格是否可編輯
                enableRowGroup: true,
                enablePivot: true,
                enableValue: true,
                sortable: true, //開啟排序
                resizable: true, //是否可以調整列大小，就是拖曳改變列大小
                filter: true, //開啟刷選
                // cellEditor: "agLargeTextCellEditor", // 啟用多行文字輸入
                // width: 150,
                cellEditorParams: {
                    maxLength: 65535,
                },
            },
            pagination: false, //開啟分頁（前端分頁）
            paginationAutoPageSize: false, //依照網頁高度自動分頁（前端分頁）
            suppressMovableColumns: true,
            suppressDragLeaveHidesColumns: true,
            tooltipShowDelay: 1000,
            columnHoverHighlight: true,
            //******************設定置頂行樣式**********
            getRowStyle: function (params) {
                if (params.node.rowPinned) {
                    return {
                        "font-weight": "bold",
                        color: "red",
                    };
                }
            },
        };
        //在dom載入完成後 初始化agGrid完成
        let eGridDivSpecification = document.querySelector(
            "#productSpecificationGrid"
        );
        new agGrid.Grid(eGridDivSpecification, aggridOptions);
        aggridOptions.columnApi.autoSizeColumn();

        // 送出
        $(".productAggridSendBtn").on("click", function () {
            aggridOptions.api.stopEditing();
            let data = {};
            data.data = [];
            // console.log("產品ＩＤ", $("#itemId").val());
            data.itemId = $("#itemId").val();
            // data.use_self_caption = $("#itemSpecificationUseSelfCaption").val();
            // 取每一個型號那行的資料
            aggridOptions.api.forEachNode((r, key) => {
                data["data"][key] = r.data;
                console.log("r.data", r.data);
            });
            data = JSON.stringify(data);
            // console.log("data", data);
            $.ajax({
                type: "post",
                url:
                    $(".base-url-plus").val() +
                    "/" +
                    $(".base-location").val() +
                    "/Ajax/cms/updateSpecificationInfo",
                data: data,
                headers: {
                    "content-type": "application/json",
                    "x-csrf-token": $("#_token").val(),
                },
            }).done(function (res) {
                console.log(res);
                if (res.status) {
                    alert("儲存成功!");
                    aggridOptions.rowData = JSON.parse(res.resData);
                    aggridOptions.api.setRowData(aggridOptions.rowData);
                } else {
                    alert("儲存失敗，請重新整理頁面再次操作");
                }
            });
        });
    }
}
