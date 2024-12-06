@extends('leon.template')
@section('content')
<h4>前端切版轉blade</h4>
<div class="note">
    <div class="box">
        <strong>步驟一、選擇切版資料夾、放在public裡面</strong>
        <div class="folderList">
            @foreach($folderList as $val)
                <div>{{ $val }}</div>
            @endforeach
        </div>
        <input class="input-text" type="text" name="path" value="">
    </div>
    <div class="box">
        <strong>步驟二、選擇blade資料夾</strong>
        <div class="bladeList">
            @foreach($bladeList as $val)
                <div>{{ $val }}</div>
            @endforeach
        </div>
        <input class="input-text" type="text" name="blade_path" value="">
    </div>
    <div class="action-btn">
        <div class="btn-lang">運行</div>
    </div>
</div>
@stop
    @section('script')
    <script>
        $(".folderList div").click(function () {
            let val = $(this).html();
            $('[name="path"]').val(val);
        });
        $(".bladeList div").click(function () {
            let val = $(this).html();
            $('[name="blade_path"]').val(val);
        });
        $(".btn-lang").click(function () {
            let path = $('[name="path"]').val();
            let blade_path = $('[name="blade_path"]').val();
            $.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    ajax: true,
                    path: path,
                    blade_path: blade_path
                }
            }).done(function (response) {
                alert('ok');

            }).fail(function () {
                console.log("ajax error");
            });
        });

    </script>
    @stop
