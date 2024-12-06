import { unitState } from "../../states/unitState.js";

const SelectFilter = (agControl, role, col) => {
    function selectFilter() {
        this.agControl = agControl;
    }

    selectFilter.prototype = {
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

            this.eGui.innerHTML = `
                    <div class="ag-filter-apply-panel">
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
                    </div>
                `;

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
                    this.val.add(e.target.value);
                } else {
                    this.val.delete(e.target.value);
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
            return (
                this.val.size === 0 ||
                this.val.has(params.data[this.col] || "") ||
                this.val.has(params.data[this.col].toString() || "") ||
                this.val.has(parseInt(params.data[this.col]) || 0)
            );
        },

        isFilterActive() {
            return this.filterActive;
        },

        getModel() {
            if (!this.isFilterActive()) {
                return null;
            }
            return { filterType: "radio", type: "contains", filter: this.val };
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

    return selectFilter;
};

export default SelectFilter;
