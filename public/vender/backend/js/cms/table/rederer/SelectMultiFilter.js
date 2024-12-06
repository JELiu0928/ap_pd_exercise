import { unitState } from "../../states/unitState.js";

const SelectMultiFilter = (agControl, role, col) => {
    function selectMultiFilter() {
        this.agControl = agControl;
    }

    selectMultiFilter.prototype = {
        // gets called once before the renderer is used
        init(params) {
            this.val = new Set();
            this.col = params.colDef.field;

            const ids = Object.keys(col.options);

            this.eGui = document.createElement("div");
            this.eGui.style.width =
                ids.reduce((res, id) => {
                    return Math.max(
                        res,
                        (col.options[id].title?.length || 0) * 30
                    );
                }, 85) + "px";
            this.eGui.style.minWidth = "100%";

            this.eGui.innerHTML = `<div class="ag-filter-apply-panel">
                  <ul>
                    ${ids
                        .map(
                            (id) => `<li>
                      <div class="input-wrap">
                        <input id="checkbox-${id}" type="checkbox" value="${id}">
                        <div class="fake-input"></div>
                      </div>
                      <label for="checkbox-${id}">${col.options[id].title}</label>
                    </li>`
                        )
                        .join("")}
                  </ul>
                </div>
                <div class="ag-filter-apply-panel">
                    <button type="button" ref="clearFilterButton" class="ag-standard-button ag-filter-apply-panel-button">Clear
                    </button>
                </div>`;

            this.filterActive = false;
            this.eGui
                .querySelector("button")
                .addEventListener("click", this.clearEvent(params));
            this.eGui.querySelectorAll("input").forEach((el) => {
                el.addEventListener("click", this.clickEvent(params));
            });
        },

        getGui() {
            return this.eGui;
        },

        clickEvent(params) {
            return (e) => {
                if (e.target.checked) {
                    this.val.add(parseInt(e.target.value) || 0);
                } else {
                    this.val.delete(parseInt(e.target.value) || 0);
                }
                this.filterActive = this.val.size > 0;
                params.filterChangedCallback();
            };
        },

        clearEvent(params) {
            return () => {
                this.eGui.querySelectorAll("input").forEach((el) => {
                    el.checked = false;
                    this.val.clear();
                    this.filterActive = false;
                    params.filterChangedCallback();
                });
            };
        },

        doesFilterPass(params) {
            if (this.val.size === 0) return true;
            let res = false;
            for (const id of this.val.values()) {
                res = params.data[this.col].indexOf(`\"${id}\"`) > 0;
                if (res) break;
            }
            return res;
        },

        isFilterActive() {
            return this.filterActive;
        },

        getModel() {
            if (!this.isFilterActive()) {
                return null;
            }
            return {
                filterType: "radio",
                type: "contains",
                filter: this.val.values(),
            };
        },

        setModel(model) {
            if (model === null) {
                this.eGui.querySelectorAll("input").forEach((el) => {
                    el.checked = false;
                    this.val.clear();
                    this.filterActive = false;
                });
            }
        },
    };

    return selectMultiFilter;
};

export default SelectMultiFilter;
