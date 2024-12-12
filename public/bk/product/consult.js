//#region
// 加入諮詢方法 1.使用點選加入諮詢V
// 刪除諮詢方法 1.諮詢燈箱點選刪除 V 2.諮詢燈箱移除所有產品 V

//step
//使用點選加入諮詢 綁定加入諮詢按鈕 發送ajax請求給後端,發送成功改變產品加入按鈕樣式、改變浮動諮詢選單數量V
//展開諮詢表單(前端固定方法)，重新載入產品諮詢結構，考慮多頁籤操作
// --綁定垃圾桶刪除按鈕方法 發送ajax請求給後端，發送成功後移除結構 V
// --移除全部商品，發送ajax請求給後端，發送成功後移除結構 V
//前往下一步，填寫聯繫資訊
//綁定確認送出按鈕，發送ajax請求給後端，檢查欄位是否填寫，修改對應樣式、文字 V
//跳轉成功頁面 V
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

let partID;
_consult.baseUrl = $(".base-url").val();
_consult.initPage = function () {};
_consult.handleConsultClick = function () {
    //增加按鈕
    $(".bk-add-consult-btn").on("click", function () {
        // document.body.fesd.addConsult();
        partID = $(this).closest(".bk-tr").attr("bk-part-id");
        console.log("partID", partID);
        $(`.bk-part-${partID}`).addClass("added");
        getAjaxData(partID);
    });
};

// 刪除單個和全部是不同前端事件
_consult.deletePartClick = function () {
    // 清除之前的事件綁定
    let data;
    $(".bk-delete-btn").off("click");
    $(".bk-delete-all").off("click");
    // 因為submit共用,所以要標示
    $(".bk-delete-btn").on("click", function () {
        document.body.fesd.ajaxDelete();
        partID = $(this).closest(".bk-part-item").attr("bk-part-id");
        data = { partID };
        $(".bk-delete-submit")
            .off("click")
            .on("click", async function () {
                deleteSingleItem(data);
            });
    });

    $(".bk-delete-all").on("click", function () {
        document.body.fesd.ajaxAllDelete();
        $(".bk-delete-all-submit")
            .off("click")
            .on("click", async function () {
                deleteAllItems();
            });
    });

    // $(".bk-delete-submit")
    //     .off("click")
    //     .on("click", async function () {
    //         if ($(this).hasClass("delete-all")) {
    //             deleteAllItems();
    //         } else if ($(this).hasClass("delete-single")) {
    //             deleteSingleItem(data);
    //         }
    //     });

    // 刪除全部
    function deleteAllItems() {
        $.ajax({
            type: "post",
            url: _consult.baseUrl + `/Ajax/deleteAllFromConsultList`,
            data: JSON.stringify({}),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
            .done(function (res) {
                console.log("全部", res);
                if (res.status) {
                    $(".bk-list-group").empty();
                    $(".bk-count").attr("total-num", res.count);
                    $(".bk-total-count").text(`共計：${res.count} 項`);
                    $(`.bk-tr`).removeClass("added");
                    showConsult();
                    deleteAllBtnShow(res.count);
                }
            })
            .fail(function (error) {
                console.log("錯誤", error);
            });
    }

    // 刪除單個項目的處理
    function deleteSingleItem(data) {
        $.ajax({
            type: "post",
            url: _consult.baseUrl + `/Ajax/deleteProductFromConsultList`,
            data: JSON.stringify(data),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
            .done(function (res) {
                console.log("單個", res);
                if (res.status) {
                    setTimeout(() => {
                        if ($(`.bk-tr.bk-part-${data.partID}`).length > 0) {
                            $(`.bk-tr.bk-part-${data.partID}`).removeClass(
                                "added"
                            );
                        }
                        $(`.bk-list-group .bk-part-${data.partID}`).remove();
                        $(".bk-count").attr("total-num", res.count);
                        $(".bk-total-count").text(`共計：${res.count} 項`);
                        showConsult();
                        deleteAllBtnShow(res.count);
                    }, 100);
                }
            })
            .fail(function (error) {
                console.log("錯誤", error);
            });
    }
};

//控制諮詢表單內清單顯示(有產品與沒產品時)
const showConsult = function () {
    if ($(".bk-list-group").children().length == 0) {
        $(".bk-list-group").addClass("d-none");
        $(".no-consult").removeClass("d-none");
    } else {
        // 確保 no-consult 隱藏
        $(".bk-list-group").removeClass("d-none");
        $(".no-consult").addClass("d-none");
    }
};
_consult.openLightBox = function () {
    $(".bk-asideBtn").on("click", function () {
        console.log("燈箱打開");
        document.body.fesd.ajaxConsult();
        $.ajax({
            type: "get",
            url: _consult.baseUrl + `/Ajax/getConsultData`,
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
                deleteAllBtnShow(res.count);
            })
            .fail(function (error) {
                console.log("something not right.", error);
            });
    });
};

const getAjaxData = function (partID) {
    $.ajax({
        type: "post",
        url: _consult.baseUrl + `/Ajax/addProductToConsultList`,
        data: JSON.stringify({
            partID: partID,
        }),
        // data: data,
        headers: {
            "content-type": "application/json",
            "x-csrf-token": $("#_token").val(),
        },
    })
        .done(function (res) {
            console.log("res = ", res);
            if (res.status) {
                //改變加入按鈕樣式
                //改變浮動諮詢按鈕數量
                setTimeout(() => {
                    showConsult();
                    $(".bk-list-group").removeClass("d-none");
                    $(".bk-count").attr("total-num", res.count);
                    $(".bk-total-count").text(`共計：${res.count} 項`);
                }, 100); // 延遲 100 毫秒
            }
        })
        .fail(function (error) {
            console.log("錯誤.", error);
        });
};
_consult.handleStepClick = function () {
    $(".bk-next-step").on("click", function () {
        document.body.fesd.processSwitchStep();
        console.log("下一步");
    });
    $(".bk-prev-step").on("click", function () {
        document.body.fesd.processSwitchStep(false);
        console.log("上一步");
    });

    $(".bk-refresh-captcha").on("click", function () {
        refreshCaptcha();
        console.log("刷新驗證碼");
    });
};
_consult.otherRequireChange = function () {
    //如果其他產品需求的textArea有變化
    $(".bk-other-require").on("input", function () {
        console.log(this);
        let value = $(this).val();

        if (value.trim() !== "") {
            // 當內容不為空，移除 disabled 類別
            $(".bk-next-step").removeClass("disabled");
        } else {
            // 當內容為空，添加 disabled 類別
            $(".bk-next-step").addClass("disabled");
        }
    });
};

// 送出給後端需要 產品型號/聯絡資料
_consult.submitForm = function (params) {
    $(".bk-form-submit").on("click", function () {
        // document.body.fesd.processSwitchStep(false);
        console.log("submitForm", $(".bk-consult-form"));
        let data = $(".bk-consult-form")[0].value;
        data["other_require"] = $(".bk-other-require").val();
        let partList = {};
        $(".bk-part-item").each(function () {
            const part_id = $(this).attr("bk-part-id");
            const description = $(this).find(".bk-part-description").val();
            partList[part_id] = {
                part_id: part_id,
                description: description,
            };
        });

        console.log("consult data = ", data);
        $(".form-group").removeClass("error");
        $(".form-group").find(".error-text").text("");
        $.ajax({
            type: "post",
            url: _consult.baseUrl + `/Ajax/submitForm`,
            data: JSON.stringify({ data, partList }),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
            .done(function (res) {
                if (!res.status) {
                    console.log("!res ==", res);
                    // $(res.errorMsg).each(function (fieldName, errMsg) {
                    $.each(res.errorMsg, function (fieldName, errMsg) {
                        // console.log(fieldName);

                        // console.log(
                        //     "欄位",
                        //     $(`[form-field=${fieldName}]`).closest(
                        //         ".form-group"
                        //     )
                        // );
                        $(`[form-field=${fieldName}]`)
                            .closest(".form-group")
                            .addClass("error");
                        $(`[form-field=${fieldName}]`)
                            .closest(".form-group")
                            .find(".error-text")
                            .text(errMsg);
                        refreshCaptcha();
                    });
                } else {
                    $(".form-group").removeClass("error");
                    $(".bk-list-group").empty();
                    // 跳轉成功頁面
                    window.location.href =
                        _consult.baseUrl + "/product/success";
                }
            })
            .fail(function (error) {
                console.log("錯誤.", error);
            });
    });
};
const refreshCaptcha = function () {
    console.log("已刷新");
    $('input[form-field="verifyCode"]').val("");
    let captcha = "/captcha/flat?" + Math.random();
    $(".bk-consult-captcha-img").attr("src", captcha);
};

const deleteAllBtnShow = function (count) {
    if (count == 0) {
        $(".bk-delete-all").addClass("d-none");
        $(".bk-next-step").addClass("disabled");
        _consult.otherRequireChange();
    } else {
        $(".bk-delete-all").removeClass("d-none");
        $(".bk-next-step").removeClass("disabled");
    }
};
