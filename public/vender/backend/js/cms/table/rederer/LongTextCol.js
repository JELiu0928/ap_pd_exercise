
const LongTextCol = (agControl, role, col) => {
    function LongTextCol() {
    };

    LongTextCol.prototype = {
        // gets called once before the renderer is used
        init(params) {
            // create the cell
            this.eGui = document.createElement('div');

            this.eGui.style.cssText = `
            display: -webkit-box;
            -webkit-line-clamp: ${role.maxLines ?? 3};
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            `;

            this.refresh(params);
        },

        getGui() {
            return this.eGui;
        },

        refresh(params) {
            this.eGui.innerHTML = params.value;
            return true;
        },

        destroy() {

        }
    }

    return LongTextCol;
};

export default LongTextCol;
