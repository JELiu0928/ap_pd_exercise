import { unitState } from "../../states/unitState.js";


const ImageCol = (agControl, role, col) => {

    function imageCol() {
        this.agControl = agControl;
    };

    imageCol.prototype = {
        // gets called once before the renderer is used
        init(params) {
            // create the cell
            this.eGui = document.createElement('div');
            $(this.eGui).addClass('img_box');
            this.imgGui = document.createElement('img');
            // this.imgGui.style.maxWidth = col.get().width + 'px';
            // this.imgGui.style.padding = '10px';
            this.eGui.append(this.imgGui);
            this.refresh(params);
            // add event listener to button

        },

        getGui() {
            return this.eGui;
        },

        // gets called whenever the cell refreshes
        refresh(params) {
            // set value into cell again
            // return true to tell the grid we refreshed successfully
            this.imgGui.src = params.data[params.colDef.field + '_thumbnail'] || '/noimage.svg';
            this.imgGui.alt = params.data[params.colDef.field + '_alt'] || 'none';

            return true;
        },

        // gets called when the cell is removed from the grid
        destroy() {
            // do cleanup, remove event listener from button
        }
    }

    return imageCol;
};

export default ImageCol;
