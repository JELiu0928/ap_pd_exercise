<html>
    <body>
        <input type="file" ref="fileRef" id='fileData'>
        <button id='importButton'>匯入所有資料表</button>
    </body>
    {{-- <script type="module" src="{{ asset('/vender/exceljs/polyfill.js') }}"></script> --}}
    {{-- <script type="module" src="{{ asset('/vender/exceljs/exceljs.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('/vender/assets/plugins/jquery/jquery-3.4.1.js') }}"></script>
    <script type="module">

        var outputData = {};

        import { } from '/vender/exceljs/polyfill.js';
        import { } from '/vender/exceljs/exceljs.js';

        // 当按钮被点击时执行导出操作
        importButton.addEventListener('click', () => {
            const workbook = new ExcelJS.Workbook()
            const file = document.getElementById('fileData').files[0];

            async function loadAndSend(){
                function load() {
                    return new Promise( (resolve, reject)=>{
                        const reader = new FileReader();
                        reader.readAsArrayBuffer(file);
                        reader.onloadend = (e) => {
                            const buffer = e.target.result

                            // 2.解析buffer
                            workbook.xlsx.load(buffer).then((res) => {
                                //每張工作表
                                res._worksheets.forEach(function(val,index){
                                    const worksheet = res.getWorksheet(index)
                                    // sheet名称
                                    const sheetName = worksheet.name;
                                    outputData[sheetName] = [];
                                    worksheet.eachRow((row, rowNumber) => {
                                        if(rowNumber==1) return ;
                                        let temp = [];
                                        row.eachCell((cell, colNumber) => {
                                            let value = ''
                                            // 判断单元格的类型
                                            //    6-公式 ;2-数值；3-字符串。
                                            if (cell.type == 6) {
                                                value = cell.result
                                            } else {
                                                value = cell.value
                                            }
                                            temp.push(value);
                                            // console.log(
                                            //     `当前为第${rowNumber}行,第${colNumber}列,值为：${value}`
                                            // )
                                        });
                                        outputData[sheetName].push(temp);
                                    });
                                })

                                resolve(true);
                            });
                        }
                    });
                }

                let _action = await load().then(()=>{
                    console.log(outputData)
                    $.ajax({
                        type: "post",
                        url: '/importExcel',
                        data: outputData,
                    })
                    .done(function(res){

                    });
                });
            }
            loadAndSend();

        });
    </script>
</html>
