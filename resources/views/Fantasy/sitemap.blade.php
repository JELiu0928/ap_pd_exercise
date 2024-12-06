<!DOCTYPE html>
<html>

<head>
  <meta name="robots" content="noindex">
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8" />
  <title>Fantasy - {{ $unitTitle }}</title>
  <!--============  Meta宣告  ============-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-touch-fullscreen" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta content="" name="description" />
  <meta content="" name="author" />

</head>

<body class="@yield('bodySetting')">
  <!-- 乾淨der網址 -->
  <input type="hidden" class="base-url-plus" value="{{ url('/') }}">
  <input type="hidden" class="base-url" value="{{ BaseFunction::f_url('/') }}">
  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" class="_token">
  <input type="text" id="scan_url" value="{{b_url('')}}">

  <a onclick="Sitemap();" style="cursor: pointer;">產生Sitemap</a>
  <div class="sitemap">

  </div>

  <script type="text/javascript" src="{{ asset('/vender/assets/plugins/jquery/jquery-3.4.1.js') }}"></script>
</body>

</html>
<script>
  //Leon 動態表格
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
  });
  var is_run = false;

  function Sitemap() {
    if (is_run) {
      alert('正在掃描');
      return false;
    } else {
      ScanUrl($("#scan_url").val(), 1, 0);
      $(".sitemap").append('<div data-scan="true" data-pr="' + 1 + '">' + $("#scan_url").val() + '</div>');
    }
  }

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
    var requestData = [];
    $(".sitemap div").each(function (index) {
      requestData.push({
        pr: $(this).attr('data-pr'),
        url: $(this).html()
      });
    });
    $.ajax({
      url: "{{url('autositemap/creat')}}",
      method: "POST",
      data: {
        requestData: JSON.stringify(requestData),
      },
      dataType: 'JSON',
      cache: false,
      success: function (data) {
        if (data.message == 'OK') {

        }
      }
    });
  }

  function ScanUrl(scan_url, pr, index) {
    $.ajax({
      url: "{{url('autositemap/auto')}}",
      method: "POST",
      data: {
        domain: $("#scan_url").val(),
        scan_url: scan_url,
      },
      dataType: 'JSON',
      cache: false,
      success: function (data) {
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
      }
    });
  }
</script>