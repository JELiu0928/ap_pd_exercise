$(document).ready(function () {
    if ($('.editSentBtn').length > 0) {
        var specificationNewForm = $(`
            <a style="float:left;padding: 6px 8px;margin-bottom: 10px;display: inline-flex;align-items:center;background-color: #c00;color: #fff;cursor: pointer;">
                <li class="overviewSpecificationForm">產品規格表管理</li>
            </a>
        `);

        $('.bkSpecificationBtn').before(specificationNewForm);
        $('.overviewSpecificationForm').on('click', async () => {
            if (confirm('要使用本按鈕功能必須先進行存檔，按下確定後將會自動儲存')) {
                $('.editSentBtnCustom').click();
            } else {
                return;
            }
            bkModalInit('item-specification-modal');
            bkModalOpen('item-specification-modal', itemSpecificationModalSet);  // 開啟燈箱
        });

        function itemSpecificationModalSet() {
            // 確保 modal 內容已經加載
            $('#item-specification-modal').on('shown.bs.modal', function () {
                // 資料加載開始
                const gridDiv = document.querySelector('#productSpecificationGrid');
                
                if (!gridDiv) {
                    console.error('Grid container with id productSpecificationGrid not found!');
                    return;
                }

                // 顯示轉圈圈
                $(`#item-specification-modal .loader`).fadeIn(300);

                // 初始化空的 AG Grid
                const gridOptions = initAgGrid('productSpecificationGrid', [], []);
                
                // 載入資料
                sendDataToBackend(gridOptions);
            });
        }

        function sendDataToBackend(gridOptions) {
            gridOptions.api.stopEditing();  // 停止編輯

            const updatedData = [];
            gridOptions.api.forEachNode((node) => {
                updatedData.push(node.data);
            });

            $.ajax({
                type: "post",
                url: $('.base-url-plus').val() + '/' + $('.base-location').val() + "/Ajax/cms/getItemSpecificationCmsView",
                data: JSON.stringify({ rows: updatedData }),
                headers: {
                    'content-type': 'application/json',
                    'x-csrf-token': $("#_token").val(),
                },
                beforeSend: function () {
                    // 這裡可以繼續保持顯示轉圈圈
                },
            }).done(function (res) {
                // 資料加載完成後，添加返回的視圖內容
                $('#item-specification-modal .bk-modal-content').append(res.view);

                // 初始化 AG Grid
                const gridOptions = initAgGrid(
                    'productSpecificationGrid', 
                    res.columnDefs, 
                    res.rowData
                );

                // 資料加載完成後，隱藏轉圈圈
                console.log('資料加載完成，隱藏轉圈圈');
                bkModalLoaded('item-specification-modal'); // 確保這行被正確執行

            }).fail(function () {
                console.log('ajax錯誤');
                // 資料加載錯誤，隱藏轉圈圈
                console.log('資料加載錯誤，隱藏轉圈圈');
                bkModalLoaded('item-specification-modal');
            });
        }

        function initAgGrid(gridContainerId, columnDefs, rowData) {
            const gridOptions = {
                columnDefs: columnDefs,
                rowData: rowData,
                defaultColDef: {
                    sortable: true,
                    filter: true,
                    resizable: true,
                    editable: true,
                },
                pagination: true,
                paginationPageSize: 10,
            };

            const gridDiv = document.querySelector(`#${gridContainerId}`);
            new agGrid.Grid(gridDiv, gridOptions);
            return gridOptions;
        }
    }
});

// $(document).ready(function () {
//     if ($('.editSentBtn').length > 0) {
//         var specificationNewForm = $(`
//             <a style="float:left;padding: 6px 8px;margin-bottom: 10px;display: inline-flex;align-items:center;background-color: #c00;color: #fff;cursor: pointer;">
//                 <li class="overviewSpecificationForm">產品規格表管理</li>
//             </a>
//         `);

//         $('.bkSpecificationBtn').before(specificationNewForm);
//         $('.overviewSpecificationForm').on('click', async () => {
//             if (confirm('要使用本按鈕功能必須先進行存檔，按下確定後將會自動儲存')) {
//                 $('.editSentBtnCustom').click();
//             } else {
//                 return;
//             }
//             bkModalInit('item-specification-modal');
//             bkModalOpen('item-specification-modal', itemSpecificationModalSet);
//         });

//         function itemSpecificationModalSet() {
//             // 確保 modal 內容已經加載
//             $('#item-specification-modal').on('shown.bs.modal', function () {
//                 const gridDiv = document.querySelector('#productSpecificationGrid');
                
//                 if (!gridDiv) {
//                     console.error('Grid container with id productSpecificationGrid not found!');
//                     return;
//                 }
        
//                 // 初始化空的 AG Grid
//                 const gridOptions = initAgGrid('productSpecificationGrid', [], []);
                
//                 // 在這裡你可以繼續處理表格資料和事件
//                 // $('.loadDataBtn').on('click', () => {
//                 //     sendDataToBackend(gridOptions); // 資料載入
                    
//                 // });
//                 bkModalLoaded('item-specification-modal');


//             });
//         }

//         $('.loadDataBtn').on('click', () => {
//             sendDataToBackend(gridOptions);
//             // bkModalLoaded('item-specification-modal');

//         });
//     }

//     function sendDataToBackend(gridOptions) {
//         gridOptions.api.stopEditing();

//         const updatedData = [];
//         gridOptions.api.forEachNode((node) => {
//             updatedData.push(node.data);
//         });

//         $.ajax({
//             type: "post",
//             url: $('.base-url-plus').val() + '/' + $('.base-location').val() + "/Ajax/cms/getItemSpecificationCmsView",
//             data: JSON.stringify({ rows: updatedData }),
//             headers: {
//                 'content-type': 'application/json',
//                 'x-csrf-token': $("#_token").val(),
//             }
//         }).done(function (res) {
//             $('#item-specification-modal .bk-modal-content').append(res.view);
//             const gridOptions = initAgGrid(
//                 'productSpecificationGrid', 
//                 res.columnDefs, 
//                 res.rowData
//             );

//             bkModalLoaded('item-specification-modal');
//         }).fail(function () {
//             console.log('ajax錯誤');
//         });
//     }

//     function initAgGrid(gridContainerId, columnDefs, rowData) {
//         const gridOptions = {
//             columnDefs: columnDefs,
//             rowData: rowData,
//             defaultColDef: {
//                 sortable: true,
//                 filter: true,
//                 resizable: true,
//                 editable: true,
//             },
//             pagination: true,
//             paginationPageSize: 10,
//         };
    
//         const gridDiv = document.querySelector(`#${gridContainerId}`);
//         new agGrid.Grid(gridDiv, gridOptions);
//         return gridOptions;
//     }

//     function onCellEdit(params) {
//         console.log('編輯結束的數據：', params.data);
//     }

//     async function sendProductSpecificationData(gridOptions) {
//         gridOptions.api.stopEditing();

//         const updatedData = [];
//         gridOptions.api.forEachNode((node) => {
//             updatedData.push(node.data);
//         });

//         try {
//             const response = await $.ajax({
//                 type: 'POST',
//                 url: $('.base-url-plus').val() + '/' + $('.base-location').val() + "/Ajax/cms/saveItemSpecification",
//                 data: JSON.stringify({ rows: updatedData }),
//                 contentType: 'application/json',
//                 headers: {
//                     'x-csrf-token': $('#_token').val(),
//                 },
//             });
//             alert('數據保存成功');
//             console.log('後端響應：', response);
//         } catch (error) {
//             console.error('數據保存失敗', error);
//             alert('數據保存失敗');
//         }
//     }
// });
