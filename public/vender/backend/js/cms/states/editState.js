const init = {
    editArea: null,
    editing: false,
    isContent: false,
    changing: false,
    ids: [],
    formKey: ''
};

export const editState = new Proxy(init, {
    set(o, k, v) {

        if (k === 'editing' && typeof v === 'boolean') {
            if (v) {
                o.editArea?.css('pointer-events', 'none');
                $('#main').css('pointer-events', 'none');
                $('.block_out').addClass('show');
            } else {
                if (!o.changing) {
                    setTimeout(() => {
                        o.editArea?.css('pointer-events', 'auto');
                        $('#main').css('pointer-events', 'auto');
                        $('.block_out').removeClass('show');
                    }, 500)
                }
            }
        }

        if (k === 'changing' && typeof v === 'boolean') {
            if (v) {
                o.editArea?.css('pointer-events', 'none');
                $('#main').css('pointer-events', 'none');
            } else {
                if (!o.editing) {
                    setTimeout(() => {
                        o.editArea?.css('pointer-events', 'auto');
                        $('#main').css('pointer-events', 'auto');
                    }, 500)
                }
            }
        }

        if (k === 'isContent' && typeof v === 'boolean') {
            if (v) {
                $('body').addClass('isContent');
            } else {
                $('body').removeClass('isContent');
            }
        }
        o[k] = v;
        return true;
    },
    get(o, k) {
        return o[k];
    }
}
); 