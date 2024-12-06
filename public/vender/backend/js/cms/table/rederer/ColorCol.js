
const ColorCol = (agControl, role, col) => {

    function colorCol() {
        this.agControl = agControl;
    };

    colorCol.prototype = {
        // gets called once before the renderer is used
        init(params) {
            // create the cell
            this.eGui = document.createElement('div');
            if (params.value == null) {
            } else {
                $(this.eGui)
                    .css('padding-bottom', '5px')
                    .css('padding', '5px')
                    .css('height', '50px');
                const transparent = document.createElement('div');
                $(transparent)
                    .css('background-image', 'url(/vender/assets/img/transparent.jpg)')
                    .css('background-size', 'cover')
                    .css('width', '100%')
                    .css('height', '100%');
                this.colorBlock = document.createElement('div');
                $(this.colorBlock)
                    .css('overflow', 'hidden')
                    .css('display', 'flex')
                    .css('flex-wrap', 'wrap')
                    .css('justify-content', 'center')
                    .css('align-items', 'center')
                    .css('width', '100%')
                    .css('height', '100%')
                    .css('border-style', 'solid')
                    .css('border-radius', '2px')
                    .css('border-width', '1px');
                this.colorText = document.createElement('div');
                $(this.colorText)
                    .css('text-align', 'center')
                    .css('background-color', 'rgba(255, 255, 255, 0.6)')
                    .css('border-radius', '2px')
                    .css('padding', '2px 5px')
                    .css('line-height', '18px')
                    .css('height', '20px');
                this.eGui.append(transparent);
                transparent.append(this.colorBlock);
                this.colorBlock.append(this.colorText);
                this.refresh(params);
            }
        },

        getGui() {
            return this.eGui;
        },

        // gets called whenever the cell refreshes
        refresh(params) {
            // set value into cell again
            // return true to tell the grid we refreshed successfully

            let data = params.value;
            this.colorBlock.style.backgroundColor = data;
            this.colorText.innerText = data;

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

    return colorCol;
};

export default ColorCol;
