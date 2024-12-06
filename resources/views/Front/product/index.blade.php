@extends('Front.template')

@section('css')
    <link rel="stylesheet" crossorigin href="/dist/assets/css/product.min.css?v={{ BaseFunction::getV() }}"">
@endsection

@section('script')
    <script type="module" crossorigin src="/dist/assets/js/product.min.js?v={{ BaseFunction::getV() }}""></script>
@endsection

@section('script_back')
    <link rel="modulepreload" crossorigin href="/dist/assets/js/process.min.js?v={{ BaseFunction::getV() }}"">
    {{-- <script type="module" src="/bk/product/consult.js?v={{ BaseFunction::getV() }}""></script> --}}

@endsection

@section('bodyClass', 'product')
@section('content')
    @include('Front.include.headerArea')

    <main>
        <!-- 共用總覽 banner 設定--><!-- 標題文字顏色: 黑/白/漸層, 黑 title-color="black", 白 title-color="white", 漸層 title-color="gradient"--><!-- 描述文字顏色(麵包屑顏色跟隨描述文字): 黑/白, 黑 sub-color="black", 白 sub-color="white"--><!-- 圖片建議尺寸: 電腦 2880x750(px), 平板 1535x675(px), 手機 560x675(px)-->
        <section class="common-banner" d-grid detect-target data-aost data-aost-fade title-color="black" sub-color="black"
            text-align="left">
            <div class="bg">
                <picture>
                    <source data-srcset="{{ $unitSet['banner_m_img_url'] }}" media="(max-width: 575px)">
                    <source data-srcset="{{ $unitSet['banner_pad_img_url'] }}" media="(max-width: 1200px)"><img
                        class="lazy" data-src="{{ $unitSet['banner_pc_img_url'] }}" alt="">
                </picture>
            </div>
            <div class="container">
                <div class="breadcrumb">
                    <ul>
                        <li> <a class="icon" href="./index.html"><i class="icon-home"></i></a></li>
                        <li><span class="categoryBtn">{{ $unitSet['title'] }}</span></li>
                    </ul>
                </div>
                <div class="content-block">
                    <div class="wrapper"> <!-- 文字皆鎖兩行-->
                        <div class="unitTitle">
                            <h2>{{ $unitSet['title'] }}</h2>
                        </div>
                        <div class="paragraphText">
                            <p>{{ $unitSet['subtitle'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="anchor">
            <div class="container" data-aost data-aost-fade>
                <div class="common-categoryBar fixStyle">
                    <div class="cate-outer">
                        <!-- m4-status="" 預設 active 選項及出現的內容-->
                        <multipurpose-nav m4-type="drag" m4-option="{&quot;drag&quot;:{&quot;selected&quot;:false}}"
                            m4-status="">
                            @foreach ($productCategories as $cate)
                                <li class="item"><a class="category" href="javascript:;"
                                        data-anchor-target="[anchor-target=&quot;1&quot;]">
                                        <p class="categoryBtn">{!! $cate['banner_title'] !!}</p>
                                    </a></li>
                            @endforeach
                            <li class="item"><a class="category" href="javascript:;"
                                    onclick="document.body.fesd.ajaxConsult()">
                                    <div class="categoryBtn">
                                        <p>線上產品諮詢清單</p>
                                        <div class="icon"> <i class="icon-consult"></i></div>
                                    </div>
                                </a></li>
                        </multipurpose-nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="detail-block" d-grid>
            <div class="container" data-aost>
                <div class="overviewTitle-block" data-align="center">
                    <p class="paragraphText-w">{{ $unitSet['content_subtitle'] }}</p>
                    <p class="unitBlockSub">{{ $unitSet['content_title'] }}</p>
                </div>
                <div class="item-outer"><!-- 圖片建議尺寸 810x575(px)-->
                    @foreach ($productCategories as $key => $cate)
                        <div class="item" anchor-target=""><a class="photo" href="./product_list.html">
                                <picture>
                                    <source srcset="{{ $cate['list_img_url'] }}" media="(max-width: 900px)">
                                    <img class="lazy" data-src="{{ $cate['list_img_url'] }}" alt="">
                                </picture>
                            </a>
                            <div class="content">
                                <div class="inner"><a href="./product_list.html">
                                        <p class="itemTitle-l">{!! $cate['banner_title'] !!}</p>
                                    </a>
                                    <div class="text">
                                        <div>
                                            <p class="paragraphText">{!! $cate['banner_intro'] !!}</p>
                                        </div>
                                    </div>
                                </div><a class="button" href="./product_list.html"> <ripple-btn class="plus blue large"
                                        r4-hover="true" data-cotton><i class="icon-plus"></i></ripple-btn></a>
                            </div>
                        </div>
                        {{-- <div class="item" anchor-target="2">
                            <div class="content">
                                <div class="inner"><a href="./product_list.html">
                                        <p class="itemTitle-l">S-SiCap<sup>TM</sup></p>
                                    </a>
                                    <div class="text">
                                        <div>
                                            <p class="paragraphText">高電容值密度、低等效串聯電感及等效串聯電阻</p>
                                        </div>
                                    </div>
                                </div><a class="button" href="./product_list.html"> <ripple-btn class="plus blue large"
                                        r4-hover="true" data-cotton><i class="icon-plus"></i></ripple-btn></a>
                            </div>
                        </div> --}}
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @include('Front.include.footerArea')

@show
