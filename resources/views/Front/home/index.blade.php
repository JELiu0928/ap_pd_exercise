<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head itemscope="itemscope" itemtype="http://schema.org/WebSite"></head>

<body>
    <script type="text/javascript" src="{{ asset('/vender/assets/plugins/jquery/jquery-3.4.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vender/backend/js/jquery.serializejson.js') }}"></script>
    <form id="Form_tab0" class="active">
        <select class="" name="Datalist[select2Multi][]" multiple="">
        <option value="1">選項1</option>
        <option value="2">選項2</option>
        <option value="3">選項2</option>
        </select>
        </form>
    總覽頁
</body>

</html>
