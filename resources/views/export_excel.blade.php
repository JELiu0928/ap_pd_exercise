<html>
    <body>
        <input type="hidden" id='data' value="{{ $dataArr }}">
        <button id='exportButton'>匯出所有資料表</button>
    </body>
    {{-- <script type="module" src="{{ asset('/vender/exceljs/polyfill.js') }}"></script> --}}
    {{-- <script type="module" src="{{ asset('/vender/exceljs/exceljs.js') }}"></script> --}}
    <script type="module">
        import { } from '/vender/exceljs/polyfill.js';
        import { } from '/vender/exceljs/exceljs.js';

        // 当按钮被点击时执行导出操作
        exportButton.addEventListener('click', async () => {
            try {
                // 创建一个工作簿
                const workbook = new ExcelJS.Workbook();

                const _data = document.getElementById('data').value;
                const _dataArr = JSON.parse(_data)

                // 创建一个工作表
                // const worksheet = workbook.addWorksheet('Sheet 1');
                // // 添加数据到工作表
                // worksheet.addRow(['姓名', '年龄']);
                // worksheet.addRow(['John', 30]);
                // worksheet.addRow(['Alice', 25]);

                _dataArr.forEach(function(val,index){
                    var worksheet = workbook.addWorksheet(val.table);
                    //不需要背著請隱藏
                    worksheet.addRow(val['comment']);
                    worksheet.addRow(val['col']);
                    val['val'].forEach(function(row,key){
                        worksheet.addRow(row);
                    });
                });

                // 生成Excel文件
                const buffer = await workbook.xlsx.writeBuffer();

                // 创建一个Blob对象
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                // 创建一个下载链接并触发下载
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'sample.xlsx';
                a.click();

                // 释放URL对象
                window.URL.revokeObjectURL(url);
            } catch (error) {
                console.error('导出Excel时出现错误:', error);
            }
        });
    </script>
</html>
