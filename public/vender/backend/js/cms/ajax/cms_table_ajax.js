export function getTableData(url, ajaxData) {
    return new Promise(async (res, rej) => {
        try {
            ajaxData['search'] = sessionStorage.getItem('Search_' + location.href.split('/').pop());
            ajaxData['page'] = sessionStorage.getItem('page_' + location.href.split('/').pop());
            let response = await $.ajax({
                data: JSON.stringify(ajaxData),
                method: 'post',
                url,
                headers: {
                    'content-type': 'application/json'
                }
            });;

            res(response);
        } catch (e) {
            rej(e);
        }
    });
}

export function updateTableData(ajaxData) {
    return new Promise(async (res, rej) => {
        try {
            let response = await $.ajax({
                data: JSON.stringify(ajaxData),
                method: 'put',
                url: '',
                headers: {
                    'content-type': 'application/json'
                }
            });
            res(response);
        } catch (e) {
            rej(e);
        }
    });
}

export function deleteTableData(ajaxData) {
    return new Promise(async (res, rej) => {
        try {
            let response = await $.ajax({
                data: JSON.stringify(ajaxData),
                method: 'delete',
                url: '',
                headers: {
                    'content-type': 'application/json'
                }
            });
            res(response);
        } catch (e) {
            rej(e);
        }
    });
}

export function copyTableData(ajaxData) {
    return new Promise(async (res, rej) => {
        try {
            let response = await $.ajax({
                data: JSON.stringify(ajaxData),
                method: 'options',
                url: '',
                headers: {
                    'content-type': 'application/json'
                }
            });
            res(response);
        } catch (e) {
            rej(e);
        }
    });
}

export function getExportData(ajaxData) {
    return new Promise(async (res, rej) => {
        try {
            let response = await $.post(window.location.href.replace(/\/unit\//, '/export/'), ajaxData);
            res(response);
        } catch (e) {
            rej(e);
        }
    });
}