import { unitState } from "../../states/unitState.js";

const RadioButtonFilter = (agControl, role, col) => {
    function RadioButton() {
        this.agControl = agControl;
    }

    RadioButton.prototype = {
        // gets called once before the renderer is used
        init(params) {
            this.val = 0;
            this.col = params.colDef.field;

            this.eGui = document.createElement("div");
            this.eGui.style.width = "85px";
            this.eGui.style.minWidth = "100%";
            this.eGui.innerHTML = `
                    <div class="ag-filter-apply-panel">
                      <ul>
                        <li>
                          <div class="input-wrap">
                            <input id="preview-open" type="radio" name="${params.colDef.field}" value="1">
                            <div class="fake-input"></div>
                          </div>
                          <label for="preview-open">開啟</label>
                        </li>
                        <li>
                          <div class="input-wrap">
                            <input id="preview-close" type="radio" name="${params.colDef.field}" value="0">
                            <div class="fake-input"></div>
                          </div>
                          <label for="preview-close">關閉</label>
                        </li>
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
                this.val = e.target.value;
                this.filterActive = true;
                params.filterChangedCallback();
            };
        },

        clearEvent(params) {
            return () => {
                this.eGui.querySelectorAll("input").forEach((el) => {
                    el.checked = false;
                    this.filterActive = false;
                    params.filterChangedCallback();
                });
            };
        },

        doesFilterPass(params) {
            return params.data[this.col] == this.val;
        },

        isFilterActive() {
            return this.filterActive;
        },

        getModel() {
            if (!this.isFilterActive()) {
                return null;
            }
            return { filterType: "radio", type: "equal", filter: this.val };
        },

        setModel(model) {
            if (model === null) {
                this.eGui.querySelectorAll("input").forEach((el) => {
                    el.checked = false;
                    this.filterActive = false;
                });
            }
        },
    };

    return RadioButton;
};

export default RadioButtonFilter;
