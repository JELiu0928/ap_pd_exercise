import { editState } from "../states/editState.js";
import { getEditView } from "../ajax/cms_edit_ajax.js";
import {
    updateTableData,
    deleteTableData,
    copyTableData,
} from "../ajax/cms_table_ajax.js";
import {
    summernoteSetting,
    colorPickerSetting,
    datePickerSetting,
    timePickerSetting,
} from "./editSetting.js";
import VerifyController from "../verify/VerifyContorller.js";

function debounce(func, delay = 250) {
    let timer = null;
    return function (...args) {
        let context = this;
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(context, args);
        }, delay);
    };
}

/**
 * @param {HTMLElement} editTarget
 */
export function EditController(
    editTarget,
    {
        afterSave = (response) => {
            return Promise.resolve(true);
        },
        afterDelete = (response) => {
            return Promise.resolve(true);
        },
        afterCopy = (response) => {
            return Promise.resolve(true);
        },
        afterCreate = (response) => {
            return Promise.resolve(true);
        },
        afterSearch = (ajaxData) => {
            return Promise.resolve(true);
        },
    } = {}
) {
    var editArea = $(editTarget);
    var verifyControl = new VerifyController(editArea);
    var editOriginalData;
    editState.editArea = editArea;

    return {
        clickEditButton,
        clickCreateButton,
        clickSearchButton,
        clickBatchButton,
        isContent,
        isSonContent,
        closeContent,
        clearEditArea,
        openContent,
        hasAuth
    };

    function refresh(formKey = null) {
        return new Promise(async (res) => {
            try {
                editState.editing = true;
                let response = await getEditView({
                    action: editState.action,
                    ids: editState.ids,
                    isSonContent: editState.isSonContent,
                    formKey,
                });
                editArea.html(response.view);
                editArea.find(".editorBody").scrollbar();

                $(editArea.find(".radio_area label.active").get().reverse()).map(function () {
                    radio_area_set(this);
                });

                if (editArea.find('input[name*="[url_name]"]')) {
                    let models = editArea.find('input[name*="[url_name]"]').get().map(function (url_el) {
                        return $(url_el).attr('name').replace('[url_name]', '');
                    });
                    console.log(models);
                    // getAllUrlname(this);
                }
                divToForm();
                tabInit();
                buttonInit();
                openContent();

                let script = document.createElement('script');
                script.text = response.jscode;
                document.getElementsByTagName('head')[0].appendChild(script).parentNode.removeChild(script);

                switch (editState.action) {
                    case "batch":
                        editOriginalData = formatDataBatch();
                        break;
                    case "search":
                        editOriginalData = formatDataSearch();
                        break;
                    default:
                        editOriginalData = formatData();
                }

                res(true);
                editState.editing = false;
            } catch (e) {
                console.log(e);
                res(false);
            }
        });
    }

    /**
     * @param { JQuery < HTMLElement >} parent
     */
    function divToForm(parent = null) {
        parent = parent == null ? editArea : parent;
        return parent.find("div.covertoform").map(function () {
            let child = $(this);
            let formEl = document.createElement("form");
            formEl.innerHTML = this.innerHTML;
            for (const attr of this.attributes) {
                formEl.setAttribute(attr.name, attr.value);
            }
            $(this).parent().append(formEl);
            divToForm($(formEl));
            child.remove();
            return formEl;
        });
    }

    /**
     * @param {JQuery<HTMLElement>} target
     * @returns
     */
    function divToFormReverse(target) {
        return target.find("div.covertoform").map(function () {
            let child = $(this);
            let formEl = document.createElement("form");
            formEl.innerHTML = this.innerHTML;
            for (const attr of this.attributes) {
                formEl.setAttribute(attr.name, attr.value);
            }
            $(this).parent().append(formEl);
            child.remove();
            return formEl;
        });
    }

    async function clickSearchButton(ids) {
        return new Promise(async (res) => {
            editState.action = "search";
            if ($(".cmsDetailAjaxSearch").html() == "") {
                editState.editing = true;
                editState.isContent = false;
                editState.ids = ids;
                let response = await refresh();
                editState.editing = false;
                res(response);
            } else {
                res("");
                openContent();
            }
        });
    }
    async function clickBatchButton(ids) {
        return new Promise(async (res) => {
            editState.editing = true;
            editState.isContent = false;
            editState.action = "batch";
            editState.ids = ids;
            let response = await refresh();
            editState.editing = false;
            res(response);
        });
    }

    async function isContent(id) {
        editState.editing = true;
        editState.action = id == 0 ? "create" : "edit";
        editState.ids = [id];
        let response = await refresh();
        editState.isContent = true;
        editState.editing = false;
        return response;
    }

    async function isSonContent(id) {
        editState.editing = true;
        editState.action = "sonEdit";
        editState.ids = [id];
        editState.isSonContent = true;
        let response = await refresh();
        editState.isContent = true;
        editState.editing = false;
        return response;
    }

    function clickEditButton(id) {
        return new Promise(async (res) => {
            editState.editing = true;
            editState.action = "edit";
            editState.ids = [id];
            let response = await refresh();
            editState.editing = false;
            res(response);
        });
    }

    function clickCreateButton() {
        return new Promise(async (res) => {
            editState.editing = true;
            editState.action = "create";
            editState.ids = [0];
            let response = await refresh();
            editState.editing = false;
            res(response);
        });
    }
    function formatData(checkSelect = false) {
        if (checkSelect) {
            $(".cmsDetailAjaxArea .editorContent select").each(function () {
                let _this = $(this);
                if (_this.prop("multiple") === true) {
                    if (_this.val().length == 0) {
                        _this.parent().append(
                            "<input class='save_befor_del' type='hidden' name='" +
                            _this.attr("name").replace("[]", "") +
                            "' value=''>"
                        );
                    }
                }
            });
            //圖片集不存空值
            $('.picture_box.img_list .open_fms_lightbox:not(.has_img)').remove();
        }
        let json1 = $(
            ".cmsDetailAjaxArea .editorContent > form"
        ).serializeJSON();
        if (json1[json1.modelName] == undefined) json1[json1.modelName] = {};
        let data1 = json1[json1.modelName];
        let child = $(".cmsDetailAjaxArea .editorContent li.son-table > form")
            .get()
            .map(function (el) {
                let json2 = $(el).serializeJSON();
                let data2 = json2[json2.modelName];
                let isDelete = data2.wait_save_del ?? 0;
                delete data2.wait_save_del;
                return {
                    ids: [parseInt(data2.id) || 0],
                    data: data2,
                    parentKey: json2.SecondIdColumn,
                    modelName: json2.modelName,
                    delete: isDelete,
                    child: $(el)
                        .find("ul.son-table > form")
                        .get()
                        .map(function (el) {
                            let json3 = $(el).serializeJSON();
                            let data3 = json3[json3.modelName];
                            let isDelete = data3.wait_save_del ?? 0;
                            delete data3.wait_save_del;
                            return {
                                ids: [parseInt(data3.id) || 0],
                                data: data3,
                                parentKey: json3.SecondIdColumn,
                                modelName: json3.modelName,
                                delete: isDelete,
                                child: [],
                            };
                        }),
                };
            });
        if (checkSelect) {
            $(".save_befor_del").remove();
        }
        return {
            ids: editState.ids,
            data: data1,
            modelName: json1.modelName,
            parentKey: null,
            child,
            delete: 0,
        };
    }
    function formatDataBatch() {
        let json1 = $(
            ".cmsDetailAjaxArea .editorContent > form"
        ).serializeJSON();
        let data1 = json1[json1.modelName];
        let batchSelect = json1["batch_" + json1.modelName];
        for (const key of Object.keys(batchSelect)) {
            if (batchSelect[key] == "" || batchSelect[key] == "0") {
                delete data1[key];
            }
        }
        return {
            ids: editState.ids,
            data: data1,
            modelName: json1.modelName,
            parentKey: null,
            child: [],
            delete: 0,
        };
    }
    function formatDataSearch() {
        let json1 = $("#search").serializeJSON();
        let is_select2 = $("#search select.____select2.actived.select2-hidden-accessible").attr("search-type");
        let data1 = json1[json1.modelName];
        let batchSelect = json1["batch_" + json1.modelName];
        for (const key of Object.keys(batchSelect)) {
            if (batchSelect[key] == "" || batchSelect[key] == "0") {
                delete data1[key];
                if (key.indexOf("_range_start") >= 0) {
                    delete data1[key.replace("_range_start", "_range_end")];
                }
                delete data1[key + "_target"];
            }
        }
        return {
            ids: editState.ids,
            data: data1,
            modelName: json1.modelName,
            parentKey: null,
            child: [],
            delete: 0,
            is_select2,
        };
    }
    function buttonInit() {
        /** @param {JQuery<HTMLElement>} target */
        function sonTableInit(target) {
            /**
             * 移動到該筆資料
             */
            function anchorToList() {
                const sonTable = $(this)
                    .parents(".frame")
                    .first()
                    .find("> .son-table");
                if (sonTable.hasClass("tabulation_body")) {
                    const tableID = $(this).attr("data-table");
                    const table = $(this)
                        .parents(".frame")
                        .first()
                        .find(`> .son-table[data-table="${tableID}"]`);
                    $(".editorBody.scroll-content").animate({
                        scrollTop:
                            table.find("> form").last().position().top - 38,
                    });
                } else {
                    //第三層
                    $(".editorBody.scroll-content").animate({
                        scrollTop:
                            sonTable.parents("form").first().position().top +
                            sonTable.find("> form").last().position().top -
                            80,
                    });
                }
            }
            target.find(".CopySonTableDataGroup").on("click", function () {
                if (editState.changing) return;
                const isThree = $(this).hasClass("threeTableCopy");
                if (
                    (!isThree &&
                        $(this)
                            .closest(".composite_btn")
                            .closest("li")
                            .next()
                            .next(".son-table")
                            .find("form.chosen").length === 0) ||
                    (isThree &&
                        $(this)
                            .closest("ul")
                            .next()
                            .next(".son-table")
                            .find("form.chosen").length === 0)
                )
                    return;

                editState.changing = true;

                if (isThree) {
                    $(this)
                        .closest("ul")
                        .next()
                        .next(".son-table")
                        .each(function () {
                            copyFrom.call(this);
                        });
                } else {
                    console.log("copy!!!");
                    $(this)
                        .closest(".composite_btn")
                        .closest("li")
                        .next()
                        .next(".son-table")
                        .each(function () {
                            copyFrom.call(this);
                        });
                }

                FormUnitInit();
                editState.changing = false;

                function copyFrom(formSelect = ".chosen", prepend = null) {
                    let rank = prepend == null ? Math.max.apply(null, [...$(this).find(">form").get().map(function (el) { return (parseInt(el.querySelector('input[name$="[w_rank]"]')?.value) || 0); }), 0,]) : 0;
                    $(this).find(" > form" + formSelect).each(function () {
                        const direction = prepend == null;
                        const currentPrepend = prepend == null ? $(this).closest(".son-table") : $(prepend);
                        const origin = this;
                        const originJson = $(origin).serializeJSON();
                        const originData = originJson[originJson.modelName];
                        originData.id = 0;
                        originData.w_rank = rank === 0 ? originData.w_rank : ++rank;

                        const copy = document.createElement("div");

                        for (const attr of origin.attributes) {
                            copy.setAttribute(attr.name, attr.value);
                            attr.name === "data-copy" && (copy.innerHTML = attr.value);
                        }
                        currentPrepend.append(copy);
                        copy.classList.remove("active");
                        const JQueryCopy = direction ? divToFormReverse(currentPrepend) : divToForm(currentPrepend);

                        $(this).find(".son-table").each(function (index) {
                            copyFrom.call(this, "", JQueryCopy.find(".son-table").get(index));
                        });

                        for (const key of Object.keys(originData)) {
                            let input = JQueryCopy.find(`[name$="[${key}]"]`).eq(0).attr("value", originData[key]).val(originData[key]);
                            JQueryCopy.find(".AutoSet_".key).html();

                            let parentElement = input.get(0)?.parentElement;
                            if (parentElement?.classList.contains("radio_btn_switch") && originData[key] == 1) {
                                parentElement?.classList.add("on");
                            } else {
                                parentElement?.classList.remove("on");
                            }

                            const img = input.siblings("img");
                            if (img.length > 0) {
                                const src = $(origin).find(`[name$="[${key}]"]`).siblings("img").attr("src");
                                if (src != null && src != "javascript:;" && src.length > 0) {
                                    input.closest(".frame.open_fms_lightbox").addClass("has_img");
                                    img.attr("src", src);
                                    const info = $(origin).find(`[name$="[${key}]"]`).closest(".frame").find(".info_detail").find("p");
                                    input.closest(".frame").find(".info_detail").find("p").each(function (index) {
                                        this.innerHTML = info.eq(index).html();
                                    });
                                } else {
                                    input.closest(".frame.open_fms_lightbox").removeClass("has_img");
                                }
                            }
                            const img_article_auto = input.closest('form').find('form:not(.three-item) .AutoSet_article_img');
                            if (img_article_auto.length > 0) {
                                const src = $(origin).find(`[name$="[${key}]"]`).siblings("img").attr("src");
                                if (src != null && src != "javascript:;" && src.length > 0) {
                                    img_article_auto.attr("src", src);
                                }
                            }

                            const file = input.closest(".file-picker");
                            if (file.length > 0) {
                                const src = $(origin).find(`[name$="[${key}]"]`);
                                const info = src.closest(".file-picker").find("input");
                                file.find("input").each(function (index) {
                                    if (index === 2) {
                                        $(this).attr("data-src", info.eq(index).attr("data-src")).attr("data-title", info.eq(index).attr("data-title"));
                                    } else {
                                        const val = info.eq(index).val();
                                        $(this).val(val).attr("value", val);
                                    }
                                });
                            }
                        }

                        if (origin.querySelector(".list_checkbox").checked) {
                            origin.querySelector(".list_checkbox").click();
                            JQueryCopy.get(0).querySelector(".list_checkbox").parentElement.classList.add("show");
                            JQueryCopy.get(0).querySelector(".list_checkbox").checked = true;
                        }

                        JQueryCopy.find(".DataSync").map(function (index, el) {
                            DataSync(el);
                        });
                        components.select2(JQueryCopy.find(".DataSyncSelect"));
                        JQueryCopy.find(".DataSyncSelect").map(function (index, el) {
                            DataSyncSelect(el);
                        });
                        JQueryCopy.find(".radio_area").map(function () {
                            let radio_area_val = $(this).find('input').val();
                            $(this).find('label').removeClass('active');
                            $(this).find('label[data-value="' + radio_area_val + '"]').addClass('active');
                        });
                        $(JQueryCopy.find(".radio_area label.active").get().reverse()).map(function () {
                            radio_area_set(this);
                        });
                        if (JQueryCopy.find('.AutoSet_article_style').length > 0) {
                            JQueryCopy.find('.AutoSet_article_style').html($(origin).find('.AutoSet_article_style').html());
                            JQueryCopy.find('.article_img').html($(origin).find('.article_img').html());
                            JQueryCopy.find('.list_box .s_img').first().html($(origin).find('.s_img').first().html());
                        }
                        sonTableInit(JQueryCopy);
                    });
                }
            });
            target.find(".addValueInTable").on("click", function () {
                if (editState.changing) return;
                editState.changing = true;
                const self = $(this);
                const isThree = self.hasClass("addInThirdTb");

                if (isThree) {
                    $(this)
                        .closest(".table_head")
                        .next("ul")
                        .removeAttr("style");
                } else {
                    const empty = $(this)
                        .closest(".composite_btn")
                        .closest("li")
                        .next(".emptyContent");
                    empty?.next(".tabulation_head").removeAttr("style");
                    empty?.remove();
                }

                const list = isThree
                    ? $(this).closest("ul").next().next(".son-table")
                    : $(this)
                        .closest(".composite_btn")
                        .closest("li")
                        .next()
                        .next(".son-table");

                const rank = Math.max.apply(null, [
                    ...list
                        .find(" > form")
                        .get()
                        .map(function (el) {

                            return (el.querySelector('input[name$="[w_rank]"]')?.value || 0);
                        }),
                    0,
                ]);
                const blank = document.createElement("div");
                blank.innerHTML = self.attr("data-content");
                const form = blank.querySelector("form");
                if (form.querySelector('input[name$="[w_rank]"]')) {
                    form.querySelector('input[name$="[w_rank]"]').value = parseInt(rank) + 1;
                }
                list.append(form);

                FormUnitInit();
                sonTableInit($(form));
                $($(form).find(".radio_area label.active").get().reverse()).map(function () {
                    radio_area_set(this);
                });
                editState.changing = false;
            });
            target
                .find(".CopySonTableDataGroup")
                .on("click", debounce(anchorToList));
            target.find(".addValueInTable").on("click", debounce(anchorToList));
        }

        sonTableInit(editArea);

        editArea.find(".editSentBtn").on("click", async function () {
            if (editState.editing) return;
            editState.editing = true;
            if (!(await verifyControl.saveVerify())) {
                editState.editing = false;
                return;
            }
            //判斷資料是否有更動 editOriginalData

            let ajaxData = "";
            if (editState.action === "batch") {
                if (
                    !confirm(
                        "如有資料已審核通過，批次修改編輯則需再次送出審核申請，是否繼續操作?"
                    )
                ) {
                    editState.editing = false;
                    return;
                }
                try {
                    ajaxData = formatDataBatch();
                    const response = await updateTableData(ajaxData);
                    await afterSave(response);
                    if (!CheckOnly(editOriginalData, ajaxData)) {
                        $(".notify_admin").removeClass("hide");
                    } else {
                        closeContent();
                        clearEditArea();
                    }
                } catch (e) {
                    console.log(e);
                    alert("server error.");
                }
                editState.editing = false;
                return;
            }
            if (editState.action === "search") {
                try {
                    ajaxData = formatDataSearch();
                    sessionStorage.removeItem(
                        "page_" + location.href.split("/").pop()
                    );
                    sessionStorage.setItem(
                        "Search_" + location.href.split("/").pop(),
                        JSON.stringify(ajaxData)
                    );
                    ajaxData["search"] = true;
                    await afterSearch(ajaxData);
                    closeContent();
                } catch (e) {
                    console.log(e);
                    alert("server error.");
                }
                editState.editing = false;
                return;
            }
            if (editState.action === "create" || editState.action === "edit" || editState.action === "sonEdit") {
                const is_reviewed = this.getAttribute("data-reviewed");
                const reviewed_pass = this.getAttribute("data-reviewed-pass");
                if (reviewed_pass == "0" && is_reviewed == "1") {
                    if (
                        !confirm(
                            "當前資料已審核通過，若您編輯則需再次送出審核申請，是否繼續操作?"
                        )
                    ) {
                        editState.editing = false;
                        return;
                    }
                } else {
                    if (!confirm("儲存目前編輯狀態?")) {
                        editState.editing = false;
                        return;
                    }
                }

                try {
                    //修正多選問題
                    ajaxData = formatData(true);
                    if (editState.has_auth > 0) {
                        ajaxData['has_auth'] = editState.has_auth;
                    }
                    const response = await updateTableData(ajaxData);
                    if (editState.action === "edit") {
                        if (!editState.isContent) {
                            await afterSave(response);
                        }
                        updateEditArea(response);
                        //判斷是否只有更改is_visible & is_preview
                        if (!CheckOnly(editOriginalData, ajaxData)) {
                            if (is_reviewed) $(".notify_admin").removeClass("hide");
                        }
                    }

                    if (editState.action === "create") {
                        if (!editState.isContent) {
                            await afterCreate(response);
                        }
                        editState.action = "edit";
                        editState.ids = response.ids;
                        updateEditArea(response);
                        await refresh(
                            $("li[data-form].active")?.attr("data-form")
                        );
                        //限制資料筆數
                        if ($(".createBtn").attr('data-max') != "" && $('.ag-center-cols-container>div').length >= $(".createBtn").attr('data-max')) {
                            $(".createBtn").closest('.btn-item').addClass('d-none');
                            $(".cloneBtn").addClass('d-none');
                        }
                    }
                    ajaxData = formatData();
                    editOriginalData = ajaxData;
                    refresh();
                } catch (e) {
                    console.log(e);
                    alert(JSON.parse(e.responseText).message);
                }
                editState.editing = false;
            }
        });

        editArea.find(".cms-copy-btn").on("click", async function () {
            if (editState.changing) return;
            if (!confirm("複製 1 筆資料?")) return;
            editState.editing = true;
            try {
                const response = await copyTableData({
                    ids: editState.ids,
                    modelName: $(".editorContent > form").serializeJSON()
                        .modelName,
                });
                editState.ids = Object.keys(response);
                await afterCopy(response);
                await refresh($("li[data-form].active")?.attr("data-form"));
            } catch (e) {
                alert("server error.");
            }
            editState.editing = false;
        });

        editArea.find(".cms-delete-btn").on("click", async function () {
            if (editState.changing) return;
            if (!confirm("刪除 1 筆資料?")) return;
            editState.editing = true;
            try {
                const response = await deleteTableData({
                    ids: editState.ids,
                    modelName: $(".editorContent > form").serializeJSON()
                        .modelName,
                });
                await afterDelete(response);
                closeContent();
                clearEditArea();
                //限制資料筆數
                if ($(".createBtn").attr('data-max') != "" && $('.ag-center-cols-container>div').length < $(".createBtn").attr('data-max')) {
                    $(".createBtn").closest('.btn-item').removeClass('d-none');
                    $(".cloneBtn").removeClass('d-none');
                }
            } catch (e) {
                alert("server error.");
            }
            editState.editing = false;
        });

        editArea.find(".remove").on("click", function () {
            // let ajaxData = formatData();
            // if (JSON.stringify(editOriginalData) != JSON.stringify(ajaxData)){
            //     if (!confirm("您修改資料尚未存檔，若未存檔關閉，修改的資料將會遺失")){
            //         return false;
            //     }
            // }
            closeContent();
        });

        editArea.find(".notify_admin").on("click", function () {
            const self = $(this);
            console.log(editState.ids);
            if (confirm("是否通知管理者審核?")) {
                $.ajax({
                    url:
                        $(".base-url").val() +
                        "/Ajax/notify-admin/" +
                        $(".editorContent > form").serializeJSON().modelName,
                    type: "GET",
                    async: false,
                    data: {
                        action: self.attr("data-action"),
                        data_id: editState.ids,
                        menu_id: location.href.split("/").pop(),
                    },
                    success: function (data) {
                        if (self.attr("data-action") == "review") {
                            $(".review_info_push").addClass("active");
                        } else {
                            $(".review_info_del").addClass("active");
                        }
                        alert("已通知管理者審核");
                    },
                });
            }
        });
        editArea.find(".notify_admin_cancel").on("click", function () {
            if (confirm("是否取消審核?")) {
                const self = $(this);
                $.ajax({
                    url:
                        $(".base-url").val() +
                        "/Ajax/notify-admin/" +
                        $(".editorContent > form").serializeJSON().modelName,
                    type: "GET",
                    async: false,
                    data: {
                        cancel: true,
                        data_id: editState.ids,
                        menu_id: location.href.split("/").pop(),
                    },
                    success: function (data) {
                        $(".review_info").removeClass("active");
                    },
                });
            }
        });

        /** @param {JQuery<HTMLElement>} list */
        function CheckOnly(obj1, obj2) {
            let obj1_temp = JSON.parse(JSON.stringify(obj1));
            let obj2_temp = JSON.parse(JSON.stringify(obj2));
            delete obj1_temp.data.is_visible;
            delete obj1_temp.data.is_preview;
            delete obj2_temp.data.is_visible;
            delete obj2_temp.data.is_preview;
            if (JSON.stringify(obj1_temp) == JSON.stringify(obj2_temp)) {
                return true;
            }
            return false;
        }

        function updateEditArea(response) {
            editArea.find(".wait-save-box").each(function () {
                const self = $(this);
                if (self.hasClass("active")) {
                    self.parent().remove();
                }
            });

            let childCount = 0;
            let sonCount = 0;
            let childIds = [];
            let sonIds = [];
            response.child.map(function (child) {
                childIds.push(child.ids[0]);
                child.child.map(function (son) {
                    sonIds.push(son.ids[0]);
                });
            });

            $(".editorContent li.son-table > form").each(function () {
                let self = $(this);
                self.find('>.list_box>input[name$="[id]"]').val(
                    childIds[childCount]
                );
                childCount++;
                self.find("ul.son-table > form").each(function () {
                    let self = $(this);
                    self.find('>.list_box>input[name$="[id]"]').val(
                        sonIds[sonCount]
                    );
                    sonCount++;
                });
            });
        }
    }

    function tabInit() {
        editArea.find("li[data-form]").each(function () {
            let tab = $(this);
            let formKey = tab.attr("data-form");
            let form = $(`form#${formKey}`);
            if (tab.hasClass("opened")) {
                editState.formKey = formKey;
                FormUnitInit();
                form.addClass("active");
            } else {
                tab.one("click", () => {
                    editState.formKey = formKey;
                    addOpenedStatus(tab);
                });
                form.hide();
            }
            tab.on("click", () => {
                switchTab(form, tab);
                editState.formKey = formKey;
            });
        });

        /**
         * @param {JQuery<HTMLElement>} tab
         */
        function addOpenedStatus(tab) {
            FormUnitInit();
            tab.addClass("opened").addClass("wait-sent");
        }

        /**
         * @param {JQuery<HTMLElement>} form
         * @param {JQuery<HTMLElement>} tab
         */
        function switchTab(form, tab) {
            if (tab.hasClass("active")) return;
            editArea.find("form[id]").hide();
            editArea.find("li[data-form]").removeClass("active");
            form.show();
            tab.addClass("active");
            $(form.find(".radio_area label.active").get().reverse()).map(function () {
                radio_area_set(this);
            });
        }
    }

    function hasAuth(use_id = 0) {
        editState.has_auth = use_id;
    }

    function closeContent() {
        editArea.find(".ajaxItem").removeClass("open").removeClass("open_fast");
        editArea.removeClass("open").removeClass("open_fast");
        editState.isContent = false;
        verifyControl.clearInputs();
    }

    function openContent() {
        editArea.addClass("open").addClass("open_fast");
        editArea.find(".ajaxItem").addClass("open").addClass("open_fast");
        $(".editorBody.scroll-content").animate(
            {
                scrollTop: 0,
            },
            200
        );
    }

    function clearEditArea() {
        editArea.html("");
        editState.ids = [];
    }

    function FormUnitInit() {
        const selector = `#${editState.formKey} `;
        $(selector + "form:not(.actived)")
            .addClass("actived")
            .each(function () {
                const self = $(this);
                const copy = document.createElement("div");
                copy.innerHTML = self.html();
                copy.querySelectorAll("form").forEach((el) => {
                    el.remove();
                });
                self.attr("data-copy", copy.innerHTML);
            });
        $(selector + ".color_picker:not(.actived)")
            .addClass("actived")
            .each(function () {
                const input = $(this).children(".palette");
                input.spectrum(colorPickerSetting.call(input));
                $(this).append(
                    `<div class="ticket_field"><p>${input.val()}</p></div><div class="color_picker_btn"><a class="color_picker_add"><span class="fa fa-plus"></span>加入常用</a></div>`
                );
            });
        $(selector + ".picture_box:not(.actived)")
            .addClass("actived")
            .each(function () {
                $(this)
                    .find(".frame")
                    .each(function () {
                        const rand = Math.random().toString(36).substring(2);
                        const self = $(this);
                        const img = self
                            .find(".box img.img_key")
                            .removeClass("img_key")
                            .addClass(`img_${rand}`);
                        const input = self
                            .find(".box input.value_key")
                            .removeClass("value_key")
                            .addClass(`value_${rand}`);
                        const open = self
                            .find('.box .lbox_fms_open[data-key="key"]')
                            .attr("data-key", rand);
                        const remove = self
                            .find('.box .image_remove[data-key="key"]')
                            .attr("data-key", rand);
                        const file = self
                            .find(".info_detail .file_key")
                            .removeClass("file_key")
                            .addClass(`file_${rand}`);
                        const folder = self
                            .find(".info_detail .folder_key")
                            .removeClass("folder_key")
                            .addClass(`folder_${rand}`);
                        const type = self
                            .find(".info_detail .type_key")
                            .removeClass("type_key")
                            .addClass(`type_${rand}`);
                        const size = self
                            .find(".info_detail .size_key")
                            .removeClass("size_key")
                            .addClass(`size_${rand}`);
                    });
                if ($(this).hasClass('imageCoordinate')) {
                    $(this)
                        .each(function () {
                            const rand = Math.random().toString(36).substring(2);
                            const self = $(this);
                            const img = self
                                .find("img.img_key")
                                .removeClass("img_key")
                                .addClass(`img_${rand}`);
                            const open = self
                                .find('.lbox_fms_open[data-key="key"]')
                                .attr("data-key", rand);
                            const input = self
                                .find("input.value_key")
                                .removeClass("value_key")
                                .addClass(`value_${rand}`);
                        });
                }
            });
        $(selector + ".file-picker:not(.actived)")
            .addClass("actived")
            .each(function () {
                const rand = Math.random().toString(36).substring(2);
                const self = $(this);
                const title = self
                    .find(".filepicker_input_key")
                    .removeClass("filepicker_input_key")
                    .addClass(`filepicker_input_${rand}`);
                const value = self
                    .find(".filepicker_value_key")
                    .removeClass("filepicker_value_key")
                    .addClass(`filepicker_value_${rand}`);
                const open = self
                    .find('.lbox_fms_open[data-key="key"]')
                    .attr("data-key", rand);
                const download = self
                    .find(
                        ".file_fantasy_download.filepicker_src_key.filepicker_title_key"
                    )
                    .removeClass("filepicker_src_key filepicker_title_key")
                    .addClass(
                        `filepicker_src_${rand} filepicker_title_${rand}`
                    );
            });

        $(selector + ".datepicker-input:not(.actived)")
            .addClass("actived")
            .each(function () {
                const setting = $(this).attr("data-toolbar");
                $(this).datepicker(
                    setting in datePickerSetting
                        ? datePickerSetting[setting]
                        : datePickerSetting.default
                );
            });

        $(selector + ".timepicker-input:not(.actived)")
            .addClass("actived")
            .each(function () {
                const setting = $(this).attr("data-toolbar");
                $(this).timepicker(
                    setting in timePickerSetting
                        ? timePickerSetting[setting]
                        : timePickerSetting.default
                );
            });

        $(selector + ".summernote-area:not(.actived):not([disabled])")
            .addClass("actived")
            .each(function () {
                const setting = $(this).attr("data-toolbar");
                $(this).summernote(
                    setting in summernoteSetting
                        ? summernoteSetting[setting]
                        : summernoteSetting.default
                );
                $(this).on('summernote.change', function () {
                    let content = $(this).summernote('code');

                    // 如果内容为 <p><br></p>，则清空编辑器
                    if (content === '<p><br></p>') {
                        $(this).summernote('code', '');  // 设置内容为空
                    }
                })
            });

        components.select2(
            $(selector + ".____select2:not(.actived)").addClass("actived")
        );
        verifyControl.addInputs(editArea.find("[data-verify]"));
        item_file_detail("file_detail_btn");
    }
}
