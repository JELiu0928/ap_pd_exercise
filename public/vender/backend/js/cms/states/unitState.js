const init = {
    changing: false,
    canCreate: false,
    canEdit: false,
    canDelete: false,
    canExplode: false,
    ids: [],
    modelName: '',
}


export const unitState = new Proxy(init, {
    set(o, k, v) {
        if (k === 'changing' && typeof v === 'boolean') {
            if (v) {
                $('html, body').css('pointer-events', 'none');
            } else {
                setTimeout(() => {
                    $('html, body').css('pointer-events', 'auto');
                }, 200);
            }
        }

        if (k === 'ids' && Array.isArray(v)) {
            if (v.length > 0) {
                $('.dropdown-item.batchBtn[data-action="1"]').show();
                $('.dropdown-item.ExportBtnCheck').show();
                $('.dropdown-item.cloneBtn').show();
            } else {
                $('.dropdown-item.batchBtn[data-action="1"]').hide();
                $('.dropdown-item.ExportBtnCheck').hide();
                $('.dropdown-item.cloneBtn').hide();
            }
            o[k] = v;
        }
        o[k] = v;
        return true;
    },
    get(o, k) {
        if (k === 'rawData') {

        } else {
            return o[k];
        }
    }
});