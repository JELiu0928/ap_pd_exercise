<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <style>
        body {
            margin: 0;
            background-color: #eee;
        }

        main {
            display: flex;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        .nav {
            width: 250px;
            background-color: #fff;
            overflow: auto;
        }

        .nav a {
            color: #000;
            width: 100%;
            display: block;
            padding: 10px;
            box-sizing: border-box;
        }

        .content {
            flex: 1;
            padding: 30px 100px;
            overflow: auto;
            box-sizing: border-box;
        }

        .note {
            background-color: #fff;
            box-sizing: border-box;
            padding: 25px;
        }

        .box {
            margin-bottom: 30px;
        }

        .box strong {
            display: block;
            margin-bottom: 15px;
        }

        .action-btn {
            display: flex;
        }

        .action-btn div {
            cursor: pointer;
            padding: 10px 20px;
            box-sizing: border-box;
            background-color: #93ddff;
        }

        .input-text {
            padding: 7px;
            min-width: 350px;
            outline: none;
        }

        .folderList {
            display: flex;
        }

        .folderList div {
            cursor: pointer;
            padding: 10px;
        }

        .bladeList {
            display: flex;
        }

        .bladeList div {
            cursor: pointer;
            padding: 10px;
        }

        .note tr:hover {
            background-color: #eee;
        }

        .note tr {
            height: 30px;
        }

        .note .btn a {
            background-color: #8d8d8d;
            color: #fff;
            padding: 5px;
            font-size: 15px;
            margin: 0px 2px;
            cursor: pointer;
        }

        .note .btn a.active {
            background-color: #f79345;
        }
        .other_data .active{
            background-color: #f79345;
        }
        .menu_action{
            display: flex;
        }
    </style>
    <link rel="stylesheet" href="/LeonBuilder/excel-v3/dist/jexcel.css" type="text/css" />
    <link rel="stylesheet" href="/LeonBuilder/excel-v3/dist/jsuites.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/LeonBuilder/files/assets/css/jquery.nestable.min.css">
</head>
<body>
    <main>
        <div class="nav">
            <a href="{{ url('leon/database') }}">資料表</a>
            <a href="{{ url('leon/menu') }}">選單設定</a>
            <a href="{{ url('leon/LangData') }}">多語系資料複製</a>
            <a href="{{ url('leon/HtmltoBlade') }}">前端切版轉blade</a>
            <a href="{{ url('leon/BladelangUI') }}">固定UI翻譯</a>
            <a href="{{ url('leon/Sitemap') }}">Sitemap掃描</a>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </main>
    <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="/LeonBuilder/excel-v3/dist/jexcel.js"></script>
    <script src="/LeonBuilder/excel-v3/dist/jsuites.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

    </script>
    @yield('script')
</body>

</html>
