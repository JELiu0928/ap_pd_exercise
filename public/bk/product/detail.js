export const _detail = {};
let filters = {}; //放篩選條件

_detail.baseUrl = $(".base-url").val();
_detail.handleDropdownClick = function () {
    // $(".bk-spec-item").on("click", function () {
    //     let selectedOption = $(this).attr("data-option");
    //     let dropdownSpecID = $(this)
    //     .closest(".bk-drop")
    //     .attr("bk-dropdown-spec-id");
    //     // ("原始值");
    //     let originalValue = "customID";
    //     //如果選擇原始值就刪掉
    //     if (selectedOption == originalValue) {
    //         delete filters[dropdownSpecID];
    //     } else {
    //         filters[dropdownSpecID] = selectedOption;
    //     }
    //     // console.log(filters);
    //     filterPartRow();
    // });
    const pathname = window.location.pathname;

// 使用 split() 方法將路徑部分分割
    const pathParts = pathname.split('/');

// 擷取需要的部分
    const cateURL = pathParts[3];   // 'iotram'
    const productURL = pathParts[4];  // 'SPIQSPI'

    $(".bk-spec-item-ajax").on("click", function () {
        console.log('click!!!!');
        let data = {};
        let selectedOption = $(this).attr("data-option");
        let dropdownSpecID = $(this).closest(".bk-drop").attr("bk-dropdown-spec-id");
        console.log('selectedOption',selectedOption);
        console.log('dropdownSpecID',dropdownSpecID);
        data['selectedOption'] = selectedOption;
        data['dropdownSpecID'] = dropdownSpecID;
        $.ajax({
            type: "post",
            url: _detail.baseUrl + `/Ajax/${cateURL}/${productURL}/filterPart`,
            data: JSON.stringify(data),
            headers: {
                "content-type": "application/json",
                "x-csrf-token": $("#_token").val(),
            },
        })
            .done(function (res) {
                console.log("res", res);
            })
            .fail(function (error) {
                console.log("錯誤", error);
            });
    })
};
_detail.clearFilter = function (params) {
    $(".bk-clearFilter").on("click", function () {
        // console.log("清除鍵");
        filters = {};
        $(".bk-tr").show();
    });
};
const filterPartRow = function () {
    // 如果沒有篩選條件，所有型號都要show
    if (Object.keys(filters).length === 0) {
        $(".bk-tr").show();
        setOddEvenColor();
        return;
    }
    //型號去尋找和篩選條件與表頭內容相同的
    $(".bk-tr").each(function () {
        let partRow = $(this);
        let isShowRow = false;
        // 篩選表頭條件
        for (let specID in filters) {
            let filterValue = filters[specID]; // 篩選值
            let matchSpec = partRow.find(`[bk-title-spec-id="${specID}"]`);
            let partTdValue = matchSpec.find("p").text().trim();
            //表格值 ＝ 篩選值
            if (filterValue === "customID") {
                continue;
            }
            if (partTdValue === filterValue) {
                isShowRow = true;
            }
            console.log(partTdValue);
        }
        if (isShowRow) {
            partRow.show(); // 沒有篩選條件或匹配成功時顯示
        } else {
            partRow.hide(); // 否則隱藏
        }

        // setOddEvenColor();
    });
};
// 設置奇偶行顏色 (不可行)
// function setOddEvenColor() {
//     $(".bk-tr:visible").each(function (index) {
//         if (index % 2 === 0) {
//             $(this).css("background-color", "white"); // 偶數行
//         } else {
//             $(this).css("background-color", "#f7f7f7"); // 奇數行
//         }
//     });
// }
