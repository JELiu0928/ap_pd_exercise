<li class="son-table message_box" data-model="{{$set['model']}}" data-field="{{$set['name']}}" data-admin="{{$FantasyUser['id']}}">
    @foreach($data as $val)
    <div class="{{ ($val['create_id'] != 0) ? 'right':'left' }} covertoform">
        <span>{{$val['textInput']}}</span>
        <input type="hidden" name="modelName" value="{{$set['model']}}">
        <input type="hidden" name="SecondIdColumn" value="parent_id">
        <input type="hidden" name="{{$set['model'].'[id]'}}" value="{{$val['id']}}">
        <input type="hidden" name="{{$set['model'].'['.$set['name'].']'}}" value="{{$val['textInput']}}">
        <input type="hidden" name="{{$set['model'].'[create_id]'}}" value="{{$val['create_id']}}">
        <input type="hidden" name="{{$set['model'].'[wait_save_del]'}}" value="0">
    </div>
    @endforeach
</li>
<li>
    <div class="message_form" contenteditable="true">

    </div>
    <div class="message_btn">
        送出留言
    </div>
    <div class="message_note">
        留言無法刪除，Setting前請務必確認資料是否正確
    </div>
    <script>
        $(".covertoform").each(function () {
            rename_element(this, 'form');
        });
        $(".message_btn").click(function () {
            let _message_form = $(".message_form")[0].textContent;
            $(".message_box").append(`<form class="right"><span>` + _message_form + `</span>
                <input type="hidden" name="modelName" value="` + $(".message_box").attr('data-model') + `">
                <input type="hidden" name="SecondIdColumn" value="parent_id">
                <input type="hidden" name="` + $(".message_box").attr('data-model') + `[id]" value="">
                <input type="hidden" name="` + $(".message_box").attr('data-model') + `[` + $(".message_box").attr('data-field') + `]" value="` + _message_form + `">
                <input type="hidden" name="` + $(".message_box").attr('data-model') + `[create_id]" value="` + $(".message_box").attr('data-admin') + `">
                <input type="hidden" name="` + $(".message_box").attr('data-model') + `[wait_save_del]" value="0">
                <a class="fa fa-remove" onclick="$(this).closest(\'form\').remove();"></a></form>`);
            $(".message_form")[0].textContent = '';

        });
        $('.message_form').keydown(function (e) {
            if (e.keyCode === 13) {
                document.execCommand('insertHTML', false, '<br><br>');
                return false;
            }
        });
        $('.editSentBtn').click(function (e) {
            $(".message_box .fa-remove").remove();
        });

    </script>
</li>
