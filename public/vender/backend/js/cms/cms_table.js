import { TableController } from "./table/TableController.js";
import { EditController } from "./edit/EditController.js";
import {
    copyTableData,
    deleteTableData,
    getExportData,
    updateTableData,
} from "./ajax/cms_table_ajax.js";
import { unitState } from "./states/unitState.js";
import { getTableData } from "./ajax/cms_table_ajax.js";

(function () {
    const tableTarget = document.querySelector("#main");
    const tableControl = TableController(tableTarget, {
        onCellEditingStopped,
        onRadioButtonClicked,
        onSelectionChanged,
        onEditButtonClicked,
        onDisplayedColumnsChanged,
    });

    const EditTarget = document.querySelector(
        ".cms_theme .cms_hiddenArea.cmsDetailAjaxArea"
    );
    const editControl = EditController(EditTarget, {
        afterSave,
        afterDelete,
        afterCopy,
        afterCreate,
        afterSearch,
    });

    const colSortManager = (() => {
        let useColSort = JSON.parse(localStorage.getItem("useColSort")) ?? {};
        let tmpColSort = null;
        let colSort = JSON.parse(localStorage.getItem("colSort")) ?? {};
        let url = "";
        return {
            set colSort(v) {
                if (v == null) return;
                colSort[url] = v;
                localStorage.setItem("colSort", JSON.stringify(colSort));
            },
            get colSort() {
                if (!this.useColSort) return null;
                return colSort[url];
            },
            set url(v) {
                if (typeof v !== "string" || v.length === 0) return;
                url = v;
            },
            get url() {
                return url;
            },
            set useColSort(v) {
                if (typeof v !== "boolean") return;
                useColSort[url] = v;
                localStorage.setItem("useColSort", JSON.stringify(useColSort));
            },
            get useColSort() {
                return useColSort[url] ?? false;
            },
            set tmpColSort(v) {
                tmpColSort = v;
            },
            get tmpColSort() {
                return tmpColSort;
            },
        };
    })();

    const SearchTarget = document.querySelector(
        ".cms_theme .cms_hiddenArea.cmsDetailAjaxSearch"
    );
    const searchControl = EditController(SearchTarget, {
        afterSearch,
    });

    window.addEventListener("load", async function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
            },
        });
        sessionStorage.removeItem("Search_" + location.href.split("/").pop());
        sessionStorage.removeItem("page_" + location.href.split("/").pop());
        menuInit();
    });

    function refresh(url = "", page = 1, option = {}, cb = (response) => {}) {
        return new Promise(async (res) => {
            try {
                unitState.changing = true;
                unitState.has_auth = 0;
                colSortManager.url = url;
                let response = await getTableData(
                    url,
                    Object.assign({ page }, option)
                );
                await tableControl.updateGrid(
                    response,
                    colSortManager.colSort,
                    async () => {
                        cb(response);
                        if (response.menu.is_content == 1) {
                            const id = response.data.data[0]?.id || 0;
                            await editControl.isContent(id);
                        } else if (response.menu.is_content == 2) {
                            const id = response.data.data[0]?.id || 0;
                            await editControl.isSonContent(id);
                        } else {
                            editControl.closeContent();
                            editControl.clearEditArea();

                            if(response.menu.has_auth == 1){
                                unitState.has_auth = response.menu.use_id;
                                editControl.hasAuth(response.menu.use_id);
                            }
                            buttonInit(response.data);
                        }
                            pageInit(
                                response.data.data,
                                response.data.totalPage,
                                response.data.perPage,
                                response.data.perCount,
                                response.data.totalCount
                            );
                        unitInit(response.data.crumb, response.data.unitTitle);
                        unitState.modelName = response.data.modelName;
                        unitState.ids = [];
                        if (response.dataId > 0 && !response.menu.is_content) {
                            await editControl.clickEditButton(response.dataId);
                        }
                        $('.previewButton').attr('href', response.preview_url);
                    }
                );
                res(true);
            } catch (e) {
                res(false);
                console.log(e);
            }
            unitState.changing = false;
        });
    }

    function menuInit() {
        $(".body-list li[data-route]").each(async function () {
            const route = $(this).attr("data-route");
            if (route.length > 0 && route !== "javascript:;") {
                $(this).on("click", async () => {
                    if (
                        !$(this).hasClass("active") &&
                        window.location.href != route
                    ) {
                        try {
                            await refresh(route, 1, {}, (response) => {
                                history.pushState(
                                    { route: window.location.href },
                                    "",
                                    route
                                );
                            });
                            colSortManager.tmpColSort = null;
                            changeMenu(route);
                            sessionStorage.removeItem(
                                "Search_" + location.href.split("/").pop()
                            );
                            sessionStorage.removeItem(
                                "page_" + location.href.split("/").pop()
                            );
                        } catch (e) {
                            console.log(e);
                        }
                    }
                });
                if ($(this).hasClass("active")) {
                    colSortManager.tmpColSort = null;
                    await refresh(window.location.href);
                    history.replaceState({ route: "" }, "", route);
                }
            }
        });

        window.addEventListener("popstate", async function (e) {
            if ($("body")[0].fms_open) {
                if (!e.state.folder_id) {
                    $("body")[0].fms_open = false;
                    let fms = $(".lbox_frame");
                    // fms.addClass("remove");
                    fms.removeClass('open');
                    $("body")[0].fms_open_index = 0;
                    // setTimeout(function () {
                    //     fms.removeClass("open go_animation remove");
                    //     fms.find(".ajax_temp").remove();
                    // }, 1000);
                } else if (e.state.folder_id == -1) {
                    history.go(-1);
                } else {
                    $("body")[0].fms_open_index = e.state.fms_open_index;
                    treeclick(
                        $(
                            '.tree-title[data-folder-id="' +
                                e.state.folder_id +
                                '"]'
                        ),
                        false
                    );
                }
            } else {
                if (!(e.state.route == window.location.href)) {
                    await refresh(window.location.href);
                    changeMenu(window.location.href);
                }
            }
        });

        function changeMenu(route) {
            $(`.body-list li[data-route]`)
                .removeClass("active")
                .each(function () {
                    const self = $(this);
                    if (self.attr("data-route") != route) return;
                    self.addClass("active")
                        .parents("li[data-route]")
                        .addClass("open")
                        .addClass("active");
                    self.parents(".sub-menu").slideDown(200);
                    self.siblings("li")
                        .removeClass("active")
                        .removeClass("open")
                        .find(".sub-menu")
                        .slideUp(200);
                    self.parents("li.level_list")
                        .siblings("li")
                        .removeClass("active")
                        .removeClass("open")
                        .find(".sub-menu")
                        .slideUp(200);
                });
        }
    }

    function buttonInit(res) {

        $(".main-table .content-nav").html(res.btnBlade);
        $(".dropdown-item.ExportBtn").on("click", () => {
            const ids = [];
            tableControl.foreachGridData((rowNode) => {
                ids.push(rowNode.data.id);
            });
            downloadXslx(ids);
        });
        $(".dropdown-item.ExportBtnSrh").on("click", () => {
            const ids = [];
            tableControl.foreachGridData((rowNode) => {
                ids.push(rowNode.data.id);
            }, true);
            downloadXslx(ids);
        });
        $(".dropdown-item.ExportBtnCheck").on("click", () => {
            const ids = getSelectIds();
            if (ids.length > 0) {
                downloadXslx(ids);
            }
        });
        $(".sortDefault").on("click", async () => {
            colSortManager.useColSort = false;
            await tableControl.refreshGrid(false, null);
        });
        $(".sortCustom").on("click", async () => {
            colSortManager.useColSort = true;
            await tableControl.refreshGrid(false, colSortManager.colSort);
        });
        $(".saveSort").on("click", async () => {
            colSortManager.useColSort = true;
            colSortManager.colSort = colSortManager.tmpColSort;
        });
        $(".createBtn").on("click", async () => {
            unitState.changing = true;
            await editControl.clickCreateButton();
            unitState.changing = false;
        });
        $(".searchBtn").on("click", async () => {
            let ids = getAllIds();
            unitState.changing = true;
            await searchControl.clickSearchButton(ids);
            unitState.changing = false;
        });

        $(".remove-data-btn").on("click", async () => {
            unitState.changing = true;
            try {
                const ids = getSelectIds();
                if (ids.length > 0 && confirm(`刪除 ${ids.length} 筆資料?`)) {
                    const response = await deleteTableData({
                        ids,
                        modelName: unitState.modelName,
                    });
                    await afterDelete(response);
                    //限制資料筆數
                    if($(".createBtn").attr('data-max') != "" && $('.ag-center-cols-container>div').length < $(".createBtn").attr('data-max')){
                        $(".createBtn").closest('.btn-item').removeClass('d-none');
                        $(".cloneBtn").removeClass('d-none');
                    }
                }
            } catch (e) {
                console.log(e);
                alert("server error");
            }
            unitState.changing = false;
        });
        $('.dropdown-item.batchBtn[data-action="2"]').on("click", async () => {
            unitState.changing = true;
            try {
                const ids = getFilterIds();
                if (ids.length > 0) {
                    const response = await editControl.clickBatchButton(ids);
                }
            } catch (e) {
                console.log(e);
                alert("server error");
            }
            unitState.changing = false;
        });
        $('.dropdown-item.batchBtn[data-action="1"]').on("click", async () => {
            unitState.changing = true;
            try {
                const ids = getSelectIds();
                if (ids.length > 0) {
                    const response = await editControl.clickBatchButton(ids);
                }
            } catch (e) {
                console.log(e);
                alert("server error");
            }
            unitState.changing = false;
        });
        $('.dropdown-item.batchBtn[data-action="3"]').on("click", async () => {
            unitState.changing = true;
            try {
                const ids = getAllIds();
                if (ids.length > 0) {
                    const response = await editControl.clickBatchButton(ids);
                }
            } catch (e) {
                console.log(e);
                alert("server error");
            }
            unitState.changing = false;
        });

        $(".dropdown-item.cloneBtn")
            .show()
            .on("click", async () => {
                unitState.changing = true;
                try {
                    const ids = getSelectIds();
                    if (confirm(`複製 ${ids.length} 筆資料?`)) {
                        const response = await copyTableData({
                            ids,
                            modelName: unitState.modelName,
                            has_auth : unitState.has_auth
                        });
                        await afterCopy(response);
                    }
                } catch (e) {
                    alert("server error");
                }
                unitState.changing = false;
            });

        function getFilterIds() {
            const ids = [];
            tableControl.foreachGridData((rowNode) => {
                ids.push(rowNode.data.id);
            }, true);
            return ids;
        }

        function getAllIds() {
            const ids = [];
            tableControl.foreachGridData((rowNode) => {
                ids.push(rowNode.data.id);
            }, false);
            return ids;
        }

        function getSelectIds() {
            const ids = [];
            tableControl.foreachGridData((rowNode) => {
                if (rowNode.selected) {
                    ids.unshift(rowNode.data.id);
                }
            }, true);
            return ids;
        }

        async function downloadXslx(ids) {
            try {
                let data = await getExportData({ ids: JSON.stringify(ids) });
                const worker = new Worker(
                    "/vender/backend/js/cms/worker/excel.js"
                );
                worker.onmessage = function (e) {
                    const a = document.createElement("a");
                    const url = window.URL.createObjectURL(e.data.blob);
                    a.href = url;
                    a.download = e.data.fileName + ".xlsx";
                    a.click();
                };
                worker.postMessage(data);
            } catch (e) {
                console.log(e);
            }
        }
    }

    function pageInit(data, totalPage, perPage, perCount = 1, totalCount = 1) {
        // $('.page')?.remove();
        $(".cmsDetailAjaxSearch").html('');
        if (totalPage > 1) {
            let page_html = "";
            const disableStyle = 'style="opacity: 0.2; pointer-events: none;"';
            if (totalPage <= 5) {
                for (const x of Array(totalPage).keys()) {
                    page_html += `<div class="go-page" data-page="${x + 1}">${
                        x + 1
                    }</div>`;
                }
            } else {
                page_html += `<div class="go-page ag-icon ag-icon-first" ${
                    perPage < 3 ? disableStyle : ""
                } data-page="1"></div>`;
                page_html += `<div class="go-page ag-icon ag-icon-previous" ${
                    perPage === 1 ? disableStyle : ""
                } data-page="prev"></div>`;
                if (perPage <= 3) {
                    for (const x of Array(5).keys()) {
                        page_html += `<div class="go-page go-nb" data-page="${
                            x + 1
                        }">${x + 1}</div>`;
                    }
                } else {
                    if (perPage + 2 <= totalPage) {
                        let star_page = perPage - 2;
                        for (const x of Array(5).keys()) {
                            page_html += `<div class="go-page go-nb" data-page="${
                                x + star_page
                            }">${x + star_page}</div>`;
                        }
                    } else {
                        let star_page = totalPage - 4;
                        for (const x of Array(5).keys()) {
                            page_html += `<div class="go-page go-nb" data-page="${
                                x + star_page
                            }">${x + star_page}</div>`;
                        }
                    }
                }
                page_html += `<div class="go-page ag-icon ag-icon-next" ${
                    perPage === totalPage ? disableStyle : ""
                } data-page="next"></div>`;
                page_html += `<div class="go-page go-last ag-icon ag-icon-last" ${
                    perPage > totalPage - 2 ? disableStyle : ""
                } data-page="${totalPage}"></div>`;
            }
            $(".content-bottom-page").html(page_html);
            $('.go-page[data-page="' + perPage + '"]').addClass("active");

            const _totalPage = totalPage;
            const _currentPage = perPage;
            $(".go-page")
                .off()
                .each(function () {
                    const self = $(this);
                    let _gopage = self.attr("data-page");
                    if (_gopage == null) return;
                    self.on("click", async () => {
                        if (_gopage == "next" && _currentPage !== _totalPage) {
                            _gopage = _currentPage + 1;
                        }

                        if (_gopage == "prev" && _currentPage !== 1) {
                            _gopage = _currentPage - 1;
                        }

                        if (
                            !isNaN(parseInt(_gopage)) &&
                            _gopage !== _currentPage
                        ) {
                            sessionStorage.setItem(
                                "page_" + location.href.split("/").pop(),
                                _gopage
                            );
                            await afterSearch();
                        }
                    });
                });

            $("#d-index-s").html(perPage * perCount - perCount + 1);
            $("#d-index-e").html(perPage * perCount);
            $("#d-index-t").html(totalCount);
            if (perPage * perCount > totalCount) {
                $("#d-index-e").html(totalCount);
            }
            $(".content-bottom").addClass("active");
        } else {
            $(".content-bottom").removeClass("active");
            $(".content-bottom-page").html("");
        }
    }

    /**
     * @param {Array} crumb
     * @param {string} title
     */
    function unitInit(crumb, title) {
        $(".content-head.cms-index_table > h1").text(title);
        const ol = $("ol.breadcrumb").html("");
        crumb.reverse().forEach((item) => {
            const li = document.createElement("li");
            li.classList.add("breadcrumb-item");
            const a = document.createElement("a");
            a.href = "javascript:;";
            a.innerText = item;
            li.append(a);
            ol.append(li);
        });
    }

    // events
    function afterDelete(response) {
        return new Promise((res) => {
            const ids = Array.from(response.ids);

            if (ids.length === 0) return;

            let remove = [];
            tableControl.foreachGridData((rowNode) => {
                if (rowNode.data) {
                    if (ids.includes(rowNode.data.id)) {
                        remove.push(rowNode.data);
                    }
                }
            });
            tableControl.setGirdData({ remove });
            tableControl.updateRawData();
            res("");
        });
    }

    function afterSave(response) {
        return new Promise((res) => {
            const ids = Array.from(response.ids);
            if (ids.length === 0) return;
            const update = [];
            for (const id of ids) {
                update.push(response.newData[id]);
            }
            tableControl.setGirdData({ update });
            tableControl.updateRawData();
            res("");
        });
    }

    function afterCopy(response) {
        return new Promise((res) => {
            const keys = Object.keys(response);
            const add = [];
            for (const key of keys) {
                add.unshift(response[key]);
            }
            tableControl.setGirdData({ add, addIndex: 0 });
            tableControl.updateRawData();
            res("");
        });
    }

    function afterCreate(response) {
        return new Promise((res) => {
            const ids = Array.from(response.ids);
            if (ids.length === 0) return;
            const add = [];
            for (const id of ids) {
                add.push(response.newData[id]);
            }
            tableControl.setGirdData({ add, addIndex: 0 });
            tableControl.updateRawData();
            res("");
        });
    }
    function afterSearch(response) {
        return new Promise((res) => {
            refresh();
            res("");
        });
    }

    function onCellEditingStopped(rowNode, id, column, newValue) {
        return new Promise(async (res) => {
            unitState.changing = true;
            try {
                const data = {};
                data[column] = newValue;
                const ajaxData = {
                    ids: [id],
                    data,
                    modelName: unitState.modelName,
                    parentKey: null,
                    child: [],
                    delete: 0,
                };
                const response = await updateTableData(ajaxData);
                await afterSave(response);
                res(true);
            } catch (e) {
                res(false);
            }
            unitState.changing = false;
        });
    }

    function onRadioButtonClicked(rowNode, id, column, newValue) {
        return new Promise(async (res) => {
            unitState.changing = true;
            try {
                const data = {};
                data[column] = newValue;
                const ajaxData = {
                    ids: [id],
                    data,
                    modelName: unitState.modelName,
                    parentKey: null,
                    child: [],
                    delete: 0,
                };
                let response = await updateTableData(ajaxData);
                await afterSave(response);
                res(true);
            } catch (e) {
                alert(JSON.parse(e.responseText).message);
                res(false);
            }
            unitState.changing = false;
        });
    }

    async function onEditButtonClicked(rowNode, id, column, newValue) {
        unitState.changing = true;
        await editControl.clickEditButton(rowNode.data.id);
        unitState.changing = false;
    }

    function onSelectionChanged(selectList) {
        return new Promise((res) => {
            const ids = selectList.map((row) => {
                return row.data.id;
            });
            unitState.ids = ids;
            res(true);
        });
    }

    function onDisplayedColumnsChanged(e) {
        colSortManager.tmpColSort =
            e.columnApi.columnModel.displayedColumns.reduce((res, cur, i) => {
                const field = cur.colId;
                if (field == null || field === "0") return res;
                res[field] = i;
                return res;
            }, {});
    }
})();
