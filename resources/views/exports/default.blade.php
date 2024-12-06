<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>Document</title>

    <link href="/vender/ag-grid/css/ag-grid.css" rel="stylesheet">
    <link href="/vender/ag-grid/css/ag-theme-alpine.css" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        select::-ms-expand {
            display: none;
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .container {
            padding: 20px;
        }

        .button {
            display: grid;
            grid-template-columns: repeat(3, 200px);
            column-gap: 5px;
            margin: 10px 0;
        }

        .button[data-page] {
            grid-template-columns: 150px repeat(3, 200px);
        }

        .button button {
            padding: 5px 5px;
            transition-duration: .3s;
            border-style: solid;
            border-width: 1px;
            border-radius: 3px;
            border-color: lightgray;
            visibility: hidden;
        }

        .button button.show {
            visibility: visible;
            cursor: pointer;
        }

        .button button:hover {
            box-shadow: 0 0 3px 2px rgba(200, 200, 200, .5);
        }

        .button button:active {
            box-shadow: inset 0 0 3px 1px rgba(200, 200, 200, .5);
        }

        .button label {
            width: 100% height: 100%;
            text-align: center;
            display: grid;
            grid-template-columns: 1fr 1.2fr;

        }

        .page {
            border-radius: 3px;
            text-align: center;
            line-height: 22px;
        }

        .page:focus {
            border-radius: 3px;
            outline-style: none;
        }


        .main {
            height: 80vh;
        }

        .disable {
            pointer-events: none;
            opacity: .6;
        }
    </style>


</head>
</head>

<body>
    <input name="page" type="hidden" value="{{ $page }}">
    <div class="container">
        <h3>
            Hello Ag-gird!
        </h3>
        <div class="button">
            <button class="export-raw disable" type="button">Export Raw Data</button>
            <button class="export-form disable" type="button">Export Form Data</button>
            <button class="export-select disable" type="button">Export Select Data</button>
        </div>
        <div class="main ag-theme-alpine" id="main">
        </div>
    </div>
    <script src="/vender/backend/js/export/jquery.min.js"></script>
    <script src="/vender/ag-grid/ag-grid-cdn.js"></script>
    <script src="/vender/exceljs/polyfill.js"></script>
    <script src="/vender/exceljs/exceljs.js"></script>
    <script defer type="module" src="/vender/backend/js/cms/cms_table.js"></script>
</body>

</html>
