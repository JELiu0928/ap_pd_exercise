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

export const _consult = {};

const partIDArr = [];
let partID;

_consult.initPage = function name() {
    commonPostAjax("openLightBox");
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
    //刪除按鈕
    $(".bk-delete-btn").on("click", function () {
        // partID = $(this).closest(".bk-tr").attr("bk-part-id");
        document.body.fesd.ajaxDelete();
        // console.log(
        //     "delllll",
        //     $(this).closest(".bk-part-item").attr("bk-part-id")
        // );
        partID = $(this).closest(".bk-part-item").attr("bk-part-id");
        console.log("del partID", partID);
        let data = { partID };
        // console.log("delres", res);
        $(".bk-delete-submit").on("click", async function () {
            $.ajax({
                type: "post",
                url:
                    $(".base-url").val() + `/Ajax/deleteProductFromConsultList`,
                data: JSON.stringify(data),
                // data: data,
                headers: {
                    "content-type": "application/json",
                    "x-csrf-token": $("#_token").val(),
                },
            })
                .done(function (res) {
                    // return res;
                    if (res.status) {
                        // console.log("delthis=", $(this));
                        $(`.bk-list-group .bk-part-${partID}`).remove();
                        // console.log();
                        if ($(".bk-list-group").children().length == 0) {
                            $(".bk-list-group").addClass("d-none");
                            $(".no-consult").removeClass("d-none");
                        }
                    }
                    console.log("commonPostAjax === ", res);
                })
                .fail(function (error) {
                    // return error;
                    console.log("something not right.", error);
                });
        });
    });
};

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
                // $.each(res.partIDs, function (_, partID) {
                //     $(`.bk-part-${partID}`).addClass("added");
                // });
                // $('.bk-count').attr('total-num',res.count)
                // $(this).closest(".bk-tr").addClass("added");

                $(".consult-btn").attr("total-num", res.count);
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
