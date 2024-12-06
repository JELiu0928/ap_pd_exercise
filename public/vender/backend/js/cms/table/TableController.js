import { defineColumn } from './AgColumn.js';
import { unitState } from '../states/unitState.js';
import { AG_GRID_LOCALE_TW } from "../../../../ag-grid/locale.tw.js";

/**
 * @param {HTMLElement} target
 */
export const TableController = (target, {
    onRadioButtonClicked = (rowNode, id, column, newValue) => { return Promise.resolve(true) },
    onEditButtonClicked = (rowNode, id) => { return Promise.resolve(true) },
    onCellEditingStopped = (rowNode, id, column, newValue) => { return Promise.resolve(true) },
    onSelectionChanged = (selectList) => { return Promise.resolve(true) },
    onDragStopped = () => { return Promise.resolve(true) },
    onDisplayedColumnsChanged = (event) => { }
} = {}) => {

    var gridOptions = {};
    var rawColDefs = [];
    var rawData = [];
    var role = {};

    var object = {
        setGirdData,
        updateGrid,
        refreshGrid,
        foreachGridData,
        onRadioButtonClicked,
        onEditButtonClicked,
        onCellEditingStopped,
        onSelectionChanged,
        onDragStopped,
        updateRawData
    };

    function setGirdData(action) {
        gridOptions.api.applyTransaction(action);
    }

    return object;

    /**
     * @param {object} response - CmsApiResponse
     */
    async function updateGrid(response, colSort, cb = () => Promise.resolve()) {
        removeGrid();
        if (response.menu.is_content!=1) {
            gridOptions = newOptions();
            updateRole(response.data.role);
            createGrid(gridOptions, response.data.colSetting);
            rawData = response.data.data;
            await refreshGrid(true, colSort);
        } else {
            rawData = [];
        }
        await cb();
        return;
    }

    function newOptions() {
        const obj = {};
        return {
            localeText: AG_GRID_LOCALE_TW,
            suppressContextMenu: true,
            getRowId: (params) => params.data.id,
            onDisplayedColumnsChanged: (e) => {
                onDisplayedColumnsChanged(e, obj);
            }
        }
    }

    function removeGrid() {
        target.querySelector('.ag-root-wrapper')?.remove();
    }

    function createGrid(gridOptions, colSetting) {

        for (const key of Object.keys(colSetting.config)) {
            gridOptions[key] = colSetting.config[key];
        }

        const groupLength = colSetting.group?.length ?? 0;

        gridOptions.rowGroupPanelShow = groupLength > 0 ? 'always' : 'never';
        gridOptions.groupDisplayType = 'multipleColumns';


        let defaultColDef = colSetting.defaultColDef ?? {};
        let colDefs = [];


        colDefs.push(defineColumn(object, '').setType('blankCol').setWidth(38).get());

        if (colSetting.config.suppressRowClickSelection) {
            colDefs.push(defineColumn(object, '').setType('checkbox').get());
            gridOptions.onSelectionChanged = updateSelect;
        }

        if (role.edit || role.view) {
            colDefs.push(defineColumn(object, '').setType('edit').get());
        }

        if (colSetting.config.rowDragManaged) {
            gridOptions.rowDragEntireRow = true;
            gridOptions.onDragStopped = updateDrag;
        }

        rawColDefs = formatCol(colDefs, colSetting, role, gridOptions);

        new agGrid.Grid(target, gridOptions);

        gridOptions.api.setDefaultColDef(defaultColDef);
    }

    function formatCol(columnDefs, colSetting, role, currentOptions) {
        const def = [];
        for (const col of Array.from(colSetting.fields)) {
            let flex=col.width<150?false:true;
            def.push(defineColumn(object, role, {
                field: col.field,
                headerName: col.headerName ?? null,
                type: col.type ?? null,
                width: col.width,
                options: col.options ?? [],
                group: colSetting.group?.includes(col.field) ?? false,
                flex:flex
            }).get());
        }

        if (Object.keys(colSetting.relations).length > 0) {
            const relation = Object.keys(colSetting.relations)[0];
            def.push({
                field: relation,
                headerName: colSetting.relations[relation].headerName,
                cellRenderer: 'agGroupCellRenderer',
                enableRowGroup: false,
                width: colSetting.relations[relation].headerName.length * 30,
                cellClass: ['wdd-relation'],
                valueFormatter: () => '',
            });
            currentOptions.masterDetail = true;
            currentOptions.isRowMaster = (dataItem) => {
                return dataItem ? parseInt(dataItem[relation]?.length) > 0 : false;
            }
            currentOptions.detailRowAutoHeight = true;
            const detailGridOptions = newOptions();
            detailGridOptions.defaultColDef = { ...colSetting.relations[relation].colSetting.defaultColDef, flex: 0, minWidth: 150 };
            detailGridOptions.columnDefs = formatCol([], colSetting.relations[relation].colSetting, Object.assign({ ...role }, { edit: false }), detailGridOptions);
            currentOptions.detailCellRendererParams = {
                detailGridOptions,
                getDetailRowData: (params) => {
                    params.successCallback(params.data[relation]);
                },
            }
        }

        return [...columnDefs, ...def];
    }

    /**
     * @param {boolean} release release block
     * @ refresh by rawData ( no request )
     */
    function refreshGrid(endState = false, colSort) {
        return new Promise(res => {
            unitState.changing = true;
            gridOptions.api.setRowData([]);
            gridOptions.columnApi.resetColumnState();
            gridOptions.api.setFilterModel(null);

            let colDefs;
            if (colSort != null) {
                const groupPrefix = 'ag-Grid-AutoColumn-';
                colDefs = [...rawColDefs]
                    .reduce((carry, col) => {
                        if ((groupPrefix + col.field) in colSort) {
                            carry.push(Object.assign({ ...col }, { rowGroup: true, hide: true }))
                            colSort[col.field] = colSort[groupPrefix + col.field];
                        } else if (col.field in colSort || col.field == null) {
                            carry.push(col)
                        }
                        return carry;
                    }, [])
                    .sort((a, b) => colSort[a.field] - colSort[b.field]);
            } else {
                colDefs = [...rawColDefs];
            }

            gridOptions.api.setColumnDefs([]);
            gridOptions.api.setColumnDefs(colDefs);
            setTimeout(() => {
                gridOptions.api.setRowData(rawData);
                unitState.changing = endState;
                res('');
            }, 300);
        })
    }

    function updateRawData() {
        let newData = [];
        foreachGridData(rowNode => {
            newData.push(rowNode.data);
        })
        rawData = newData;
    }

    /**
     * @param {object} newRole
     */
    function updateRole(newRole) {

        if (newRole.edit) {
            gridOptions.readOnlyEdit = true;
            gridOptions.onCellEditRequest = updateCell;
        }

        role = newRole;
    }
    /**
     * @param {(rowNode) => void} callback
     * @param {boolean} sortAndFilter default false
     */
    function foreachGridData(callback, sortAndFilter = false) {
        if (sortAndFilter) {
            // iterate only nodes that pass the filter and ordered by the sort order
            gridOptions.api.forEachNodeAfterFilterAndSort((rowNode, index) => {
                callback(rowNode);
            });
        } else {
            // iterate through every node in the grid
            gridOptions.api.forEachNode((rowNode, index) => {
                callback(rowNode);
            });
        }
    }

    async function updateCell(e) {
        if (e.oldValue !== e.newValue) {
            await onCellEditingStopped(e.node, e.data.id, e.colDef.field, e.newValue);
        }
    }

    async function updateSelect(e) {
        let res = await onSelectionChanged(e.api.getSelectedNodes());
    }

    async function updateDrag(e) {
        let res = await onDragStopped();
    }
}





