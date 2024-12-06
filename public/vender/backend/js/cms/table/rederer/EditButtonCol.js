import { unitState } from "../../states/unitState.js";


const EditButtonCol = (agControl, role, col) => {

    function EditButton() {
        this.agControl = agControl;
    };

    EditButton.prototype = {
        // gets called once before the renderer is used
        init(params) {
            // create the cell
            this.eGui = document.createElement('div');
            if (params?.data?.id == null) {

            } else {
                this.eGui.style.cssText = `cursor: pointer; padding: 10px; display: flex; justify-content: center; align-items: center;`;
                this.eGui.innerHTML = `
                    <span class="fa fa-pencil-square-o" data-key="bb95m"></span>
                `;

                // add event listener to button
                this.eventListener = async (e) => {
                    agControl.onEditButtonClicked(params.node, params.data.id);
                };
                this.eGui.addEventListener('click', this.eventListener);
            }
        },

        getGui() {
            return this.eGui;
        },

        // gets called whenever the cell refreshes
        refresh(params) {
            // set value into cell again
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

    return EditButton;
};

export default EditButtonCol;
