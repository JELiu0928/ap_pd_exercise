import { unitState } from "../../states/unitState.js";


const RadioButtonCol = (agControl, role, col) => {

    function RadioButton() {
        this.agControl = agControl;
    };

    RadioButton.prototype = {
        // gets called once before the renderer is used
        init(params) {
            // create the cell
            if (params.value == null) {

            } else {
                this.eGui = document.createElement('div');
                this.eGui.classList.add('checkbox-field');
                this.eGui.innerHTML = `
                    <div style="text-align: center;" >
                        <div class="ag-wrapper ag-input-wrapper ag-checkbox-input-wrapper" role="presentation">
                            <input class="ag-input-field-input ag-checkbox-input radio-button" type="checkbox">
                        </div>
                    </div>
                `;
                this.refresh(params);

                if (role.edit) {
                    this.eventListener = async () => {
                        this.agControl.onRadioButtonClicked(params.node, params.data.id, params.colDef.field, !this.cellValue);
                    };
                    this.button.addEventListener('click', this.eventListener);
                } else {
                    this.eGui.style.cssText = `pointer-events: none;`
                }
                // add event listener to button
            }

        },

        getGui() {
            return this.eGui;
        },

        // gets called whenever the cell refreshes
        refresh(params) {
            // set value into cell again
            this.ui = this.eGui.querySelector('.ag-checkbox-input-wrapper');
            this.button = this.eGui.querySelector('.radio-button');
            this.cellValue = params.value == 1 || params.value == '1' || params.value == true;
            this.button.checked = params.value;

            if (this.cellValue) {
                this.ui.classList.add('ag-checked');
            } else {
                this.ui.classList.remove('ag-checked');
            }

            // return true to tell the grid we refreshed successfully
            return true;
        },

        // gets called when the cell is removed from the grid
        destroy() {
            // do cleanup, remove event listener from button
            if (this.eButton) {
                // check that the button element exists as destroy() can be called before getGui()
                this.eButton.removeEventListener('click', this.eventListener);
            }
        }
    }

    return RadioButton;
};

export default RadioButtonCol;
