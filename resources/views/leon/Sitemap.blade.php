@extends('leon.template')
@section('content')
<h4>前端切版轉blade</h4>
<div class="note">
    <div class="box">
        <strong>步驟一、請填入掃描網址</strong>
        <input class="input-text" type="text" id="scan_url" value="">
    </div>
    <div class="action-btn">
        <div class="btn-lang">運行</div>
    </div>
    <div class="sitemap"></div>
</div>
@stop
    @section('script')
    <script>
        var is_run = false;
        $(".btn-lang").click(function () {
            let site_url = $('#scan_url').val();
            if (is_run) {
                alert('正在掃描');
                return false;
            } else {
                ScanUrl($("#scan_url").val(), 1, 0);
                $(".sitemap").append('<div data-scan="true" data-pr="' + 1 + '">' + $("#scan_url").val() + '</div>');
            }
        });

        function SitemapNext() {
            $(".sitemap div").each(function (index) {
                if ($(this).attr('data-scan') == 'false') {
                    ScanUrl($(this).html(), $(this).attr('data-pr'), index);
                    $(this).attr('data-scan', 'true');
                    return false;
                }
            });
        }

        function CreateSitemap() {
            // var requestData = [];
            // $(".sitemap div").each(function (index) {
            //     requestData.push({
            //         pr: $(this).attr('data-pr'),
            //         url: $(this).html()
            //     });
            // });
            // $.ajax({
            //     url: "{{ url('autositemap/creat') }}",
            //     method: "POST",
            //     data: {
            //         requestData: JSON.stringify(requestData),
            //     },
            //     dataType: 'JSON',
            //     cache: false,
            //     success: function (data) {
            //         if (data.message == 'OK') {

            //         }
            //     }
            // });
        }

        function ScanUrl(scan_url, pr, index) {
            $.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {
                    ajax: true,
                    domain: $("#scan_url").val(),
                    scan_url: scan_url,
                }
            }).done(function (data) {
                if (data.message == 'OK') {
                    var new_count = 0;
                    for (var i = 0; i < data.url.length; i++) {
                        var is_find = false;
                        $(".sitemap div").each(function () {
                            if ($(this).html() == data.url[i].url) {
                                is_find = true;
                            }
                        });
                        if (is_find == false) {
                            new_count++;
                            $(".sitemap").append('<div data-scan="false" data-pr="' + data.url[i].pr + '">' + data.url[i].url + '</div>');
                            if (data.url[i].url.indexOf("未分類") >= 0) {
                                console.log('未分類:' + scan_url);
                            }
                        }
                    }
                    SitemapNext();
                    //如果是最後一筆且沒有網址了
                    if (new_count == 0 && index == ($(".sitemap div").length - 1)) {
                        CreateSitemap();
                        alert('OK');
                    }
                }

            }).fail(function () {
                console.log("ajax error");
            });
        }

    </script>
    @stop
