@extends('leon.template')
@section('content')
<h4>多語系資料複製</h4>
<div class="note">
    <div class="box">
        <strong>步驟一、選擇主要語系</strong>
        <input type="radio" name="main_lang" id="main_lang1" value="tw_"><label for="main_lang1">繁體中文</label>
        <input type="radio" name="main_lang" id="main_lang2" value="en_"><label for="main_lang2">英文</label>
    </div>
    <div class="box">
        <strong>步驟二、選擇要複製的語系</strong>
        <input type="checkbox" name="langs[]" id="lang1" value="tw_"><label for="lang1">繁體中文</label>
        <input type="checkbox" name="langs[]" id="lang2" value="en_"><label for="lang2">英文</label>
        <input type="checkbox" name="langs[]" id="lang3" value="cn_"><label for="lang3">簡體中文</label>
        <input type="checkbox" name="langs[]" id="lang4" value="jp_"><label for="lang4">日文</label>
        <input type="checkbox" name="langs[]" id="lang5" value="kr_"><label for="lang5">韓文</label>
    </div>
    <div class="action-btn">
        <div class="btn-lang">運行</div>
    </div>
</div>
@stop
    @section('script')
    <script>
        $(".btn-lang").click(function () {
            let main_lang = $('[name="main_lang"]:checked').val();
            let langs = $('[name="langs[]"]:checked').map(function (_, el) {
                return $(el).val();
            }).get();
            $.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    ajax: true,
                    main_lang: main_lang,
                    langs: langs
                }
            }).done(function (response) {
                alert('ok');

            }).fail(function () {
                console.log("ajax error");
            });
        });

    </script>
    @stop
