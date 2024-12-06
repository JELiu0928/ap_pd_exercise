<!DOCTYPE html>
<html lang="en">

<head itemscope="itemscope" itemtype="http://schema.org/WebSite">
    @if (\Illuminate\Support\Str::contains(url()->current(), 'wdd.idv.tw'))
    {{-- 禁止搜尋引擎建立該網頁的索引，請於專案尚未上正式上架前保留這個設定，也請後端工程師把此設定放進後端管理中 --}}
    <meta name="robots" content="noindex" />
    {{-- 禁止 Google 該網頁建立索引，請於專案尚未上正式上架前保留這個設定，也請後端工程師把此設定放進後端管理中 --}}
    <meta name="googlebot" content="noindex" />
    @endif

    {{-- 網站語系及語言宣告 --}}
    <meta http-equiv="content-language" content="zh-TW" />
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- RWD設定 --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    {{-- 瀏覽器設定 --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    {{-- 網站標題 --}}
    <meta name="format-detection" content="telephone=no">
    <title>{{ $basic_seo['seo_title'] }}</title>
    <meta property="og:title" content="{{ $basic_seo['seo_og_title'] }}" />
    <meta itemprop="name" content="{{ $basic_seo['seo_title'] }}" />
    <meta name="twitter:title" content="{{ $basic_seo['seo_og_title'] }}" />
    <meta name="twitter:site" content="{{ $basic_seo['seo_og_title'] }}" />
    <meta name="twitter:creator" content="{{ $basic_seo['seo_og_title'] }}" />
    {{-- 網頁內容描述 --}}
    <meta name="description" content="{{ $basic_seo['seo_meta'] }}" />
    <meta itemprop="description" content="{{ $basic_seo['seo_meta'] }}" />
    <meta name="twitter:description" content="{{ $basic_seo['seo_meta'] }}" />
    <meta property="og:description" content="{{ $basic_seo['seo_description'] }}" />
    <meta property="og:site_name" content="{{ $basic_seo['seo_title'] }}" />
    {{-- 網站關鍵字 --}}
    <meta name="keywords" content="{{ $basic_seo['seo_keyword'] }}">
    {{-- 圖像 --}}
    @if (isset($basic_seo['og_img']) && $basic_seo['og_img'] != '/noimage.svg')
    <meta property="og:image" content="{{ URL::to('/') . $basic_seo['og_img'] }}" />
    <meta itemprop="image" content="{{ URL::to('/') . $basic_seo['og_img'] }}" />
    <meta name="twitter:card" content="{{ URL::to('/') . $basic_seo['og_img'] }}" />
    <meta name="twitter:image:src" content="{{ URL::to('/') . $basic_seo['og_img'] }}" />
    @endif
    {{-- LD Json --}}
    @if (isset($basic_seo['seo_structured']) && ($basic_seo['seo_structured'] != "" ))
    {!!seo_structured($basic_seo['seo_structured'])!!}
    @endif

    {{-- Open Graph Protocol for facebook --}}
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:locale" content="zh_TW" />
    <meta property="og:type" content="website" />

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?t=1">
    <link rel="icon" type="image/x-icon" href="/favicon.ico?t=1">
    <link rel="apple-touch-icon" href="/favicon.ico?t=1">

    {{-- Google Tag Manager --}}
    @if (isset($basic_seo['seo_ga']) && !empty($basic_seo['seo_ga']))
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', "{{ $basic_seo['seo_ga'] }}", 'auto');
        ga('send', 'pageview');

    </script>
    @endif
    @if (!empty($basic_seo['seo_gtm']))
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', "{{ $basic_seo['seo_gtm'] }}");

    </script>
    @endif
    @if(isset($basic_seo['seo_pixel']) && !empty($basic_seo['seo_pixel']) )
    <script>
        ! function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', "{{$basic_seo['seo_pixel']}}");
        fbq('track', 'PageView');

    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $basic_seo['seo_pixel'] }}&ev=PageView&noscript=1" /></noscript>
    @endif
    {{-- <!-- 非共用的Css --> --}}
    @yield('css')
    {{-- <!-- 非共用的Css(絕對後面那種) --> --}}
    @yield('css_back')
</head>

<body class="@yield('bodyClass')" id="@yield('bodyId')" data-page="@yield('bodyDataPage')">
    <h1 class="visuallyhidden">{{ !empty($basic_seo['seo_h1']) ? $basic_seo['seo_h1'] : 'goldennet' }}</h1>
    <input class="base-url" type="hidden" value="{{ BaseFunction::b_url('/') }}">
    <input class="base-locatoin" type="hidden" value="{{ $baseLocale }}">
    <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="cover-bg"></div>

    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- 共用 JS-->
    <script defer src="{{ asset('bk/bk_all.js?'.BaseFunction::getV()) }}"></script>
    <!-- 個別頁面引用 JS-->
    @if ($_SERVER["SERVER_ADDR"] == '127.0.0.1')
    <link rel="stylesheet" href="{{ asset('/LeonBuilder/excel-v3/dist/jexcel.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/LeonBuilder/excel-v3/dist/jsuites.css') }}" type="text/css" />
    <script nonce="{{$nonce}}" defer src="{{url('/vender/assets/js/leon_blade.js')}}"></script>
    @endif
    @yield('script')
    {{-- 非共用的JS區塊(更後面) --}}
    @yield('script_back')
</body>

</html>
