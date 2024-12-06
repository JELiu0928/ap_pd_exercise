export function getEditView(ajaxData) {
    return new Promise(async (res, rej) => {
        try {
            let response = await $.ajax({
                method: 'post',
                url: window.location.href.replace(/\/unit\//, '/edit/'),
                data: JSON.stringify(ajaxData),
                headers: {
                    'content-type': 'application/json'
                }
            });
            res(response);
        } catch (e) {
            rej(e);
        }
    })
}