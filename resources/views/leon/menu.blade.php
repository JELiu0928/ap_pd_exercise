@extends('leon.template')
@section('content')
<h4></h4>
<div class="menu_action">
    <a class="btn btn-primary" onclick="cssd();">縮起全部</a>
    <div class="form-group">
        <label class="col-form-label" for="db_note">名稱</label>
        <input type="text" class="form-control" id="db_note" name="db_note">
    </div>
    <div class="form-group">
        <label class="col-form-label" for="db_note">Model</label>
        <input type="text" class="form-control" id="db_model" name="db_model">
    </div>
    <a class="btn btn-primary" onclick="addgo();">建立主分類</a>
    <a class="btn btn-primary" onclick="autorun();">自動處理</a>
</div>
<div class="note">
    <div class="cf nestable-lists">
        <div class="dd" id="nestable"></div>
        <div class="dd" id="nestable2"></div>
    </div>
    <textarea id="nestable-output" style="width:100%"></textarea>
    <textarea id="nestable2-output" style="width:100%"></textarea>
    <a class="setting">setting</a>
</div>
@stop

    @section('script')

    <script type="text/javascript" src="/LeonBuilder/files/assets/js/jquery.nestable.js"></script>
    <script>
        function autorun() {
            $.ajax({
                url: '//' + window.location.host + '/leon/autorun',
                type: "POST",
                async: false,
                data: {
                    ajax: true,
                    data: $('#nestable-output').val()
                },
                success: function(data) {
                    alert("OK");
                }
            });
        }
        function cssd() {
            $('.dd').nestable('collapseAll');
        }
        function addgo() {
            var newItem = {
                "id": $("#db_model").val(),
                "content": $("#db_note").val(),
                "contenta": $("#db_note").val()
            };
            $('#nestable').nestable('add', newItem);
        }
        $(".setting").on('click',function(){
            $.ajax({
                url: window.location.href,
                type: "POST",
                async: false,
                data: {
                    ajax: true,
                    data: $('#nestable-output').val()
                },
                success: function(data) {
                    alert("OK");
                }
            });
        });

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        var updateOutputAll = function (e) {
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        };
        let json = '{!! $MenuData !!}';
        let json1 = '{!! $NewMenuData_en !!}';
        $('#nestable').nestable({
            group: 1,
            json: JSON.parse(json),
            contentCallback: function (item) {
                var content = item.content || '' ? item.content : item.id;
                content += ' <i>(id = ' + item.id + ')</i>';
                return content;
            }
        }).on('change blur', updateOutputAll);
        $('#nestable2').nestable({
            group: 1,
            json: JSON.parse(json1),
            contentCallback: function (item) {
                var content = item.content || '' ? item.content : item.id;
                content += ' <i>(id = ' + item.id + ')</i>';
                return content;
            }
        }).on('change blur', updateOutputAll);
        updateOutputAll();

    </script>
    @stop
