importScripts('../../../../exceljs/polyfill.js');
importScripts('../../../../exceljs/exceljs.js');

self.onmessage = async (e) => {
    try {
        const wb = new ExcelJS.Workbook();
        const sheet = wb.addWorksheet(e.data.unitTitle, { properties: { tabColor: { argb: 'FFC0000' } } });

        sheet.addRow(formatCol(e.data));

        for (const row of formatData(e.data.colSetting, e.data.data)) {
            sheet.addRow(row);
        }

        const buffer = await wb.xlsx.writeBuffer();
        const blobData = new Blob([buffer], { type: "application/vnd.ms-excel;charset=utf-8;" });

        const data = {
            blob: blobData,
            fileName: getFileName() + '-' + e.data.unitTitle
        };

        self.postMessage(data);
        self.close();
    } catch (e) {
        self.postMessage(e);
        self.close();
    }
}

/**
 * @returns {Array}
 */
function formatCol(data) {

    let column = ['#'];

    data.colSetting.fields.forEach(col => {
        column.push(col.headerName);
    });

    let keys = Object.keys(data.colSetting.relations);

    if (keys.length !== 0) {
        for (const key of keys) {
            column = [...column, ...formatCol(data.colSetting.relations[key])];
        }
    }

    return column;
}

function formatData(colSetting, data, prefix = 0) {
    const result = [];

    let relation = Object.keys(colSetting.relations);
    let prefixList = relation.reduce((res, key) => {
        res[key] = res.length + 0;
        res.length = res.length + countPrefix(colSetting.relations[key].colSetting);
        return res;
    }, { length: 0 });

    let count = 1;
    const keys = colSetting.fields.map(col => col.field);
    for (const d of data) {
        let row = Array(prefix).fill('');
        row.push(count++);
        for (const key of keys) {
            row.push(d[key]);
        }
        result.push(row);
        for (const re of relation) {
            for (const child of formatData(colSetting.relations[re].colSetting, d[re], row.length + prefixList[re])) {
                result.push(child);
            }
        }
    }
    return result;
}

function countPrefix(colSetting) {
    return colSetting.fields.length + 1 + Object.keys(colSetting.relations).reduce((res, key) => {
        return res + countPrefix(colSetting.relations[key].colSetting);
    }, 0);
}

function getFileName() {
    let months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',];
    let date = new Date;
    return `${date.getFullYear()}-${months[date.getMonth()]}-${date.getDate() > 9 ? date.getDate() : '0' + date.getDate()}`;
}