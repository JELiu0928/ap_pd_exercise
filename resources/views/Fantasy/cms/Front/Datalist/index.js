(() => {
    const container = $('.position-img');

    const scrollEl = container.closest('.scroll-content');
    const topEl = container.find('.position-text .top');
    const leftEl = container.find('.position-text .left');
    const rightEl = container.find('.position-text .right');
    const bottomEl = container.find('.position-text .bottom');

    const img = container.find('img');
    const imgEl = img.get(0);

    const area = container.find('.position-area');

    img.on('mousedown', downEvent)

    showPosition({
        top: parseFloat(topEl.text()) || 0,
        left: parseFloat(leftEl.text()) || 0,
        right: parseFloat(rightEl.text()) || 0,
        bottom: parseFloat(bottomEl.text()) || 0,
    })

    function downEvent(e) {

        const width = imgEl.width;
        const height = imgEl.height;

        let imgTop = imgEl.offsetTop;
        let imgLeft = imgEl.offsetLeft;

        let parent = imgEl.offsetParent;

        while (parent != null) {
            imgTop += parent.offsetTop;
            imgLeft += parent.offsetLeft;
            parent = parent.offsetParent;
        }

        let imgRight = imgLeft + width;
        let imgBottom = imgTop + height;


        let scrollTop = scrollEl.get(0).scrollTop;
        let initX = e.clientX - imgLeft;
        let initY = e.clientY - imgTop + scrollTop;
        let left = initX / width * 100;
        let top = initY / height * 100;
        let right = (width - initX) / width * 100;
        let bottom = (height - initY) / height * 100;

        showPosition({
            top,
            left,
            right,
            bottom
        });

        $(document).on('mousemove', moveEvent)
            .on('mouseup', removeEvent);
        scrollEl.on('scroll', scrollEvent);

        function moveEvent(e2) {
            let tmpX = e2.clientX - imgLeft;
            let tmpY = e2.clientY - imgTop + scrollTop;

            if (tmpX < 0) {
                tmpX = 0;
            } else if (e2.clientX > imgRight) {
                tmpX = width;
            }

            if (tmpY < 0) {
                tmpY = 0;
            } else if (e2.clientY + scrollTop > imgBottom) {
                tmpY = height;
            }

            if (tmpX < initX) {
                left = tmpX / width * 100;
                right = (width - initX) / width * 100;
            } else {
                left = initX / width * 100;
                right = (width - tmpX) / width * 100;
            }

            if (tmpY < initY) {
                top = tmpY / height * 100;
                bottom = (height - initY) / height * 100;
            } else {
                top = initY / height * 100;
                bottom = (height - tmpY) / height * 100;
            }

            showPosition({
                top,
                left,
                right,
                bottom
            });

        }

        function removeEvent(e) {
            $(document).off('mousemove', moveEvent)
                .off('mouseup', removeEvent);
            scrollEl.off('scroll', scrollEvent);

        }

        function scrollEvent() {
            scrollTop = scrollEl.get(0).scrollTop;
        }

    }

    function showPosition({
        top,
        left,
        right,
        bottom
    }) {
        topEl.text(top.toFixed(3));
        leftEl.text(left.toFixed(3));
        rightEl.text(right.toFixed(3));
        bottomEl.text(bottom.toFixed(3));

        area.css('top', top + '%')
            .css('left', left + '%')
            .css('right', right + '%')
            .css('bottom', bottom + '%')
    }

    const button = $('.position-button');
    button.on('click', () => {
        let _temp = [];
        _temp.push(topEl.text())
        _temp.push(rightEl.text())
        _temp.push(bottomEl.text())
        _temp.push(leftEl.text())
        let _txt = JSON.stringify(_temp);

        let tempTextInput = document.createElement('input');
        tempTextInput.value = _txt;
        document.body.appendChild(tempTextInput);
        tempTextInput.select();
        tempTextInput.setSelectionRange(0, 99999);
        document.execCommand('copy');
        document.body.removeChild(tempTextInput);
        console.log(_txt)
    })
})();
