//#region 
// 加入諮詢方法 1.使用點選加入諮詢
// 刪除諮詢方法 1.諮詢燈箱點選刪除 2.諮詢燈箱移除所有產品

//step
//使用點選加入諮詢 綁定加入諮詢按鈕 發送ajax請求給後端,發送成功改變產品加入按鈕樣式、改變浮動諮詢選單數量
//展開諮詢表單(前端固定方法)，重新載入產品諮詢結構，考慮多頁籤操作
// --綁定垃圾桶刪除按鈕方法 發送ajax請求給後端，發送成功後移除結構
// --移除全部商品，發送ajax請求給後端，發送成功後移除結構
//前往下一步，填寫聯繫資訊
//綁定確認送出按鈕，發送ajax請求給後端，檢查欄位是否填寫，修改對應樣式、文字
//跳轉成功頁面
// export const _consult = {};
// _consult.url = $('.base-url').val();
// _consult.stop = false;
// //綁定加入諮詢
// _consult.addBtn = function(){}

// //綁定展開燈箱方法 仔入結構
// _consult.openLightBox = function(){
//     remove原有結構
//     ajax{

//         _consult.removeBtn();
//     }
// }
// //綁定垃圾桶刪除按鈕方法
// _consult.removeBtn = function(){
//     _consult.removeFun();
// }
// _consult.removeAllBtn = function(){
//     _consult.removeFun()
// }
// _consult.removeFun = function(){

// }

//#endregion
export const _consult = {};

const partIDArr = [];
let partID;
let isAllDelete = false
_consult.initPage = function () {
    
};
_consult.handleConsultClick = function () {
    //增加按鈕
    $(".bk-add-consult-btn").on("click", function () {
        // document.body.fesd.ajaxConsult();
        partID = $(this).closest(".bk-tr").attr("bk-part-id");
        console.log("partID", partID);
        $(`.bk-part-${partID}`).addClass("added");
        getAjaxData(partID);
      
    });
};

_consult.deletePartClick = function () {
    // 清除之前的事件綁定bk-delete-btn"
    let data;
    $(".bk-delete-btn").off("click");
    $(".bk-delete-all").off("click");
    // 因為submit共用,所以要標示
    $(".bk-delete-btn").on("click", function () {
        document.body.fesd.ajaxDelete();

        partID = $(this).closest(".bk-part-item").attr("bk-part-id");
        data = { partID };
        $(".bk-delete-submit").removeClass("delete-all").addClass("delete-single");
    });
    $(".bk-delete-all").on("click", function () {
        document.body.fesd.ajaxDelete();

        $(".bk-delete-submit").removeClass("delete-single").addClass("delete-all");
    });

    $(".bk-delete-submit").off("click").on("click", async function () {
        // 根據類名區分操作
        if ($(this).hasClass("delete-all")) {
            deleteAllItems();
        } else if ($(this).hasClass("delete-single")) {
            deleteSingleItem(data);
        }
    });

    // 刪除全部
    function deleteAllItems() {
        $.ajax({
            type: "post",
            url: $(".base-url").val() + `/Ajax/deleteAllFromConsultList`,
            data: JSON.stringify({}),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
        .done(function (res) {
            console.log('刪除全部結果:', res);
            if (res.status) {
                $(".bk-list-group").empty(); // 清空所有項目
                $('.bk-count').attr('total-num', res.count);
                $('.bk-total-count').text(`共計：${res.count || 0} 項`);
                // if ($(`.bk-tr.bk-part-${data.partID}`).length > 0) {
                    $(`.bk-tr`).removeClass('added');
                // }
                showConsult();
            }
        })
        .fail(function (error) {
            console.log("刪除全部錯誤", error);
        });
    }

    // 刪除單個項目的處理
    function deleteSingleItem(data) {
        $.ajax({
            type: "post",
            url: $(".base-url").val() + `/Ajax/deleteProductFromConsultList`,
            data: JSON.stringify(data),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
        .done(function (res) {
            console.log('刪除單個結果:', res);
            if (res.status) {
                setTimeout(() => {
                    if ($(`.bk-tr.bk-part-${data.partID}`).length > 0) {
                        $(`.bk-tr.bk-part-${data.partID}`).removeClass('added');
                    }
                    $(`.bk-list-group .bk-part-${data.partID}`).remove();
                    $('.bk-count').attr('total-num', res.count);
                    $('.bk-total-count').text(`共計：${res.count || 0} 項`);
                    showConsult();
                }, 100);
            }
        })
        .fail(function (error) {
            console.log("刪除單個錯誤", error);
        });
    }
};

// _consult.deletePartClick = function () {
//        // 移除之前的事件綁定，避免重複綁定
//        $(".bk-delete-btn").off("click");
//     //刪除按鈕
//     $(".bk-delete-btn").on("click", function () {
//         document.body.fesd.ajaxDelete();
//         partID = $(this).closest(".bk-part-item").attr("bk-part-id");
//         let data = { partID };

//         $(".bk-delete-submit").off("click");
//         $(".bk-delete-submit").on("click", async function () {
//             $.ajax({
//                 type: "post",
//                 url:
//                     $(".base-url").val() + `/Ajax/deleteProductFromConsultList`,
//                 data: JSON.stringify(data),
//                 headers: {
//                     "content-type": "application/json",
//                     "x-csrf-token": $("#_token").val(),
//                 },
//             })
//                 .done(function (res) {
//                     console.log('res.status',res.status)
//                     if (res.status) {
//                         // 沒有用setTimeout會刪不掉
//                         setTimeout(() => {
//                             if ($(`.bk-tr.bk-part-${partID}`).length > 0) {
//                                 $(`.bk-tr.bk-part-${partID}`).removeClass('added'); // 移除 added 類
//                                 console.log('我有刪除added')
//                             } else {
//                                 console.log('元素不存在');
//                             }
//                             $(`.bk-list-group .bk-part-${partID}`).remove();
//                             console.log('res.count',res.count);
//                             $('.bk-count').attr('total-num',res.count)
//                             $('.bk-total-count').text(`共計：${res.count || 0} 項`)
//                             console.log('list children = ',$(".bk-list-group").children().length)
//                             showConsult();
//                         }, 100);
                        
//                     }
//                 })
//                 .fail(function (error) {
//                     // return error;
//                     console.log("something not right.", error);
//                 });
//         });
//     });

//     $(".bk-delete-all").off("click");
//     $(".bk-delete-all").on("click", function () {
//         document.body.fesd.ajaxAllDelete()
//         $.ajax({
//             type: "post",
//             url:
//                 $(".base-url").val() + `/Ajax/deleteAllFromConsultList`,
//             data: JSON.stringify(data),
//             headers: {
//                 "content-type": "application/json",
//                 "x-csrf-token": $("#_token").val(),
//             },
//         }).done(function (res) {
//                 console.log('res.status',res.status)
//                 if (res.status) {
//                     // 沒有用setTimeout會刪不掉
//                     setTimeout(() => {
//                         if ($(`.bk-tr.bk-part-${partID}`).length > 0) {
//                             $(".bk-list-group").empty();

//                         } 
//                         console.log('res.count',res.count);
//                         $('.bk-count').attr('total-num',res.count)
//                         $('.bk-total-count').text(`共計：${res.count || 0} 項`)
//                         // console.log('list children = ',$(".bk-list-group").children().length)
//                         showConsult();
//                     }, 100);
                    
//                 }
//         })
//         .fail(function (error) {
//                 // return error;
//                 console.log("something not right.", error);
//         });
      
//     });
// };
//控制諮詢表單內清單顯示(有產品與沒產品時)
const showConsult = function(){
    if ($(".bk-list-group").children().length == 0) {
        $(".bk-list-group").addClass("d-none");
        $(".no-consult").removeClass("d-none");
    } else {
        // 確保 no-consult 隱藏
        $(".bk-list-group").removeClass("d-none");
        $(".no-consult").addClass("d-none");
    }
}
const commonPostAjax = function (url, data = null) {
    // let data = {
    //     data,
    // };
    data = data;
    $.ajax({
        type: "post",
        url: $(".base-url").val() + `/Ajax/${url}`,

        data: JSON.stringify(data),
        // data: data,
        headers: {
            "content-type": "application/json",
            "x-csrf-token": $("#_token").val(),
        },
    })
        .done(function (res) {
            return res;
            console.log("commonPostAjax === ", res);
        })
        .fail(function (error) {
            return error;
            console.log("something not right.", error);
        });
};
// addConsult bk-add-consult-btn
_consult.openLightBox = function () {
    $(".bk-asideBtn").on("click", function () {
        console.log("燈箱打開");
        $.ajax({
            type: "get",
            url: $(".base-url").val() + `/Ajax/getConsultData`,

            // data: JSON.stringify(data),
            // data: data,
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
            .done(function (res) {
                console.log("lightbox", res);
                $(".bk-list-group").html(res.view);
                showConsult();
                _consult.deletePartClick();
            })
            .fail(function (error) {
                console.log("something not right.", error);
            });
    });
};

const getAjaxData = function (partID) {
    const data = {
        partID: partID, // 確保 partID 被加入到資料中
    };
    console.log("data", data); // 在控制台檢查發送的資料

    $.ajax({
        type: "post",
        url: $(".base-url").val() + `/Ajax/addProductToConsultList`,
        // url: $(".base-url").val() + `/Ajax/ddd`,
        data: JSON.stringify(data),
        // data: data,
        headers: {
            "content-type": "application/json",
            "x-csrf-token": $("#_token").val(),
        },
    })
        .done(function (res) {
            if (res.status) {
                //改變加入按鈕樣式
                //改變浮動諮詢按鈕數量
                setTimeout(() => {

                    showConsult();
                
                    $('.bk-list-group').removeClass('d-none')
                    $(".bk-count").attr("total-num", res.count);
                    $('.bk-total-count').text(`共計：${res.count || 0} 項`)
                }, 100); // 延遲 100 毫秒
                
            }
            // if(!res.status){{
            //     //
            // }
            console.log("res = ", res);
            // console.log(res.view);
            // console.log('$(".bk-list-group")', $(".bk-list-group"));
            // $(".bk-list-group").html(res.view);
            // $("#product-aggrid-modal .bk-modal-content").append(res.view);
            // prosuctSpecAggridInit();
            // bkModalLoaded("product-aggrid-modal");
        })
        .fail(function (error) {
            console.log("something not right.", error);
        });
};
