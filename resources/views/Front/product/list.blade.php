@extends('Front.template')

@section('css')
    {{-- <link rel="stylesheet" crossorigin href="/dist/assets/css/product.min.css?v={{ BaseFunction::getV() }}"> --}}
    <link rel="stylesheet" crossorigin href="/dist/assets/css/product_list.min.css?v={{ BaseFunction::getV() }}">

@endsection

@section('script')
    {{-- <script type="module" crossorigin src="/dist/assets/js/product.min.js?v={{ BaseFunction::getV() }}"></script> --}}
    <script type="module" crossorigin src="/dist/assets/js/product_list.min.js?v={{ BaseFunction::getV() }}"></script>

@endsection

@section('script_back')
    {{-- <link rel="modulepreload" crossorigin href="/dist/assets/js/process.min.js?v={{ BaseFunction::getV() }}"> --}}
    {{-- <script type="module" src="/bk/product/consult.js?v={{ BaseFunction::getV() }}""></script> --}}
    {{-- <script type="module" crossorigin src="/dist/assets/js/product_list.min.js?v={{ BaseFunction::getV() }}"></script> --}}
    <script defer type="module" src="/bk/product/index.js?v={{ BaseFunction::getV() }}"></script>

@endsection

@section('bodyClass', 'product_list')
@section('content')
    @include('Front.include.headerArea')

    <!-- 主要內容-->


    <main>
        <!-- 共用內頁 banner 設定-->
        <!-- 標題文字顏色: 黑/白/漸層, 黑 title-color="black", 白 title-color="white", 漸層 title-color="gradient"--><!-- 描述文字顏色(麵包屑顏色跟隨描述文字): 黑/白, 黑 sub-color="black", 白 sub-color="white"--><!-- 圖片建議尺寸: 電腦 2880x675(px), 平板 1535x675(px), 手機 750x900(px)-->
        <section class="detail-banner" d-grid data-aost detect-target data-aost-fade
            title-color="{{ $category['banner_title_color'] }}" sub-color="{{ $category['banner_intro_color'] }}"
            text-align="{{ $category['banner_text_location'] }}">
            <div class="breadcrumb">
                <ul>
                    <li> <a class="icon" href="{{ BaseFunction::b_url('') }}"><i class="icon-home"></i></a></li>
                    <li><a href="{{ BaseFunction::b_url('product') }}"><span class="categoryBtn">產品專區新</span></a></li>
                    <li><span class="categoryBtn">{!! $category['banner_title'] !!}</span></li>
                </ul>
            </div>
            <div class="banner-container" d-grid>
                @if (!empty($category['banner_pc_img']))
                    <div class="bg">
                        <picture>
                            <source data-srcset="{{ $category['banner_m_img_url'] }}" media="(max-width: 575px)">
                            <source data-srcset="{{ $category['banner_pad_img_url'] }}" media="(max-width: 1200px)"><img
                                class="lazy" data-src="{{ $category['banner_pc_img_url'] }}" alt="">
                        </picture>
                    </div>
                @endif

                <div class="container">
                    <div class="content-block">
                        <div class="wrapper">
                            <!-- 文字皆鎖兩行-->
                            <div class="unitTitle">
                                <h2>{!! $category['banner_title'] !!}</h2>
                            </div>
                            <div class="paragraphText">
                                <p>{!! $category['banner_intro'] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="anchor">
            <div class="container" data-aost data-aost-fade>
                <div class="common-categoryBar">
                    <div class="cate-outer">
                        <!-- m4-status="" 預設 active 選項及出現的內容-->
                        <multipurpose-nav m4-type="drag" m4-option="{&quot;drag&quot;:{&quot;selected&quot;:false}}"
                            m4-status="1">
                            {{-- 不會換active --}}
                            @foreach ($productCategories as $key => $cate)
                                <li class="item @if ($setActiveKey == $cate['id']) ) active @endif"
                                    data-option="{{ $cate['id'] }}">
                                    {{-- <li class="item" data-option="{{ $key + 1 }}"> --}}
                                    <a class="category" href="{{ BaseFunction::b_url($cate['half_url']) }}">
                                        <p class="categoryBtn">{!! $cate['banner_title'] !!}</p>
                                    </a>
                                </li>
                            @endforeach
                            <li class="item" data-option="3">
                                <a class="category bk-asideBtn" href="javascript:;"
                                    onclick="document.body.fesd.ajaxConsult()">
                                    <div class="categoryBtn">
                                        <p>線上產品諮詢清單</p>
                                        <div class="icon"> <i class="icon-consult"></i></div>
                                    </div>
                                </a>
                            </li>
                        </multipurpose-nav>
                    </div>
                </div>
                <div class="other-categoryBar fixStyle">
                    <div class="cate-outer">
                        <multipurpose-nav m4-type="drag" m4-option="{&quot;drag&quot;:{&quot;selected&quot;:false}}">
                            @if ($is_overview || $is_overviewList)
                                <li class="item"><a class="category" href="javascript:;"
                                        data-anchor-target="[anchor-target=&quot;1&quot;]">
                                        <p class="categoryBtn">{{ $category['overview_title'] }}</p>
                                    </a></li>
                            @endif
                            @if ($is_advantages)
                                <li class="item"><a class="category" href="javascript:;"
                                        data-anchor-target="[anchor-target=&quot;2&quot;]">
                                        <p class="categoryBtn">{{ $category['advantages_zone_title'] }}</p>
                                    </a></li>
                            @endif
                            @if ($is_product)
                                <li class="item"><a class="category" href="javascript:;"
                                        data-anchor-target="[anchor-target=&quot;3&quot;]">
                                        <p class="categoryBtn">{{ $category['product_title'] }}</p>
                                    </a></li>
                            @endif

                        </multipurpose-nav>
                    </div>
                </div>
            </div>
        </section>
        {{-- 概述 --}}
        @if ($is_overview || $is_overviewList)
            <section class="info-block" d-grid anchor-target="1">
                <div class="container" data-aost>
                    <div class="unitTitle-block center">
                        <div class="title">
                            <p>{{ $category['overview_title'] }}</p>
                        </div>
                        @if (!empty($category['overview_intro']))
                            <div class="text">
                                <p>{{ $category['overview_intro'] }}</p>
                            </div>
                        @endif
                    </div>
                    @if ($is_overview)
                        <div class="top-block">
                            <!-- 後臺可新增, 左圖右文 data-type="photo-left" 右圖左文 data-type="photo-right" 無圖 data-type="photo-none"-->
                            @foreach ($cateOverviews->overviews as $overview)
                                <div class="item" data-type="photo-left" data-aost>
                                    <div class="photo-outer">
                                        <div class="photo">
                                            <img class="lazy" data-src="{{ $overview['img_url'] }}" alt="">
                                        </div>
                                        <div class="desc">
                                            <p>{!! $overview['img_intro'] !!}</p>
                                        </div>
                                    </div>
                                    <div class="content text-block">
                                        <div class="title">
                                            <div class="itemTitle-lw">{!! nl2br($overview['title']) !!}</div>
                                        </div>
                                        <div class="text">
                                            <div class="paragraphText">{!! nl2br($overview['intro']) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                    {{-- @dd($is_overviewList) --}}

                    @if ($is_overviewList)
                        <div class="bottom-block" data-aost>
                            <div class="text-block">
                                {{-- @if (!empty(strip_tags($category->series_zone_title))) --}}
                                <div class="title">
                                    <div class="itemTitle-lw">{!! nl2br($category['series_zone_title']) !!}</div>
                                </div>
                                {{-- @endif --}}
                                @if (!empty(strip_tags($category->series_zone_intro)))
                                    <div class="text">
                                        <div class="paragraphText">{!! nl2br($category['series_zone_intro']) !!}</div>
                                    </div>
                                @endif
                            </div>
                            <div class="content">
                                @foreach ($cateOverviews->overviewLists as $overviewList)
                                    <div class="item">
                                        <div class="itemTitle-w">{!! nl2br($overviewList['title']) !!}</div>
                                        <div class="paragraphText">{!! nl2br($overviewList['intro']) !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </section>
        @endif
        {{-- @dump($category) --}}

        @if ($is_advantages)
            <section class="advantage-block" anchor-target="2">
                <!--***- 11.15 狀態新增-->
                <!-- 無背景圖 data-bg="false", 標題顏色 title-color="black" or title-color="gradient", 內文固定黑色-->
                <!-- 有背景圖 data-bg="true", 標題顏色 title-color="black" or title-color="gradient" or title-color="white", 內文顏色 text-color="black" or text-color="white"-->
                <div class="container" data-aost data-bg="true" title-color="black" text-color="black">
                    <div class="grid left">
                        <!-- 若無上背景圖, 需把 .bg 結構移除-->
                        @if (!empty($category['advantages_zone_img']))
                            <div class="bg">
                                <picture>
                                    <img class="lazy" data-src="{{ $category['advantages_zone_img_url'] }}"
                                        alt="">
                                </picture>
                            </div>
                        @endif
                        <div class="wrapper">
                            <div class="unitTitle-block left">
                                <div class="title">
                                    <p>{{ $category['advantages_zone_title'] }}</p>
                                </div>
                                @if (!empty($category['advantages_zone_intro']))
                                    <div class="text">
                                        <p>{{ $category['advantages_zone_intro'] }}</p>
                                    </div>
                                @endif
                            </div>
                            <!--***- 11.12 tab 更改結構形式--><!-- collapse 選單-->
                            <div class="common-category">
                                <div class="cate-outer">
                                    <!-- m4-status="" 預設 active 選項及出現的內容-->
                                    <multipurpose-nav m4-type="collapse"
                                        m4-option="{&quot;drag&quot;:{&quot;selected&quot;:true},&quot;collapse&quot;:{&quot;selected&quot;:true,&quot;placeholder&quot;:&quot;SELECT&quot;}}"
                                        m4-status="1">
                                        @foreach ($cateAdvantages->advantagesTags as $key => $tag)
                                            <li class="item" data-option="{{ $key + 1 }}"
                                                t4-control="advantage-tab" t4-role="tab"
                                                data-anchor-target=".advantage-block">
                                                <div class="spread-btn paragraphText" style="--hoverball: #2E2E2E">
                                                    {!! $tag['title'] !!}
                                                </div>
                                            </li>
                                        @endforeach

                                    </multipurpose-nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid right">
                        <!-- 右區塊有開背景兩色 白 & 灰 bg-color="white" & bg-color="gray"-->
                        <tab-el t4-name="advantage-tab">
                            @foreach ($cateAdvantages->advantagesTags as $tag)
                                <div class="tab-panel" t4-role="tabPanel"
                                    bg-color="{{ $tag['advantages_zone_bg_color'] }}">
                                    <div class="scroller">
                                        <div class="item-outer">
                                            @foreach ($tag->advantagesLists as $list)
                                                <ripple-btn class="item" r4-hover="true" data-cotton>
                                                    <div class="title">
                                                        <p class="itemTitle-w">{!! $list['title'] !!}</p>
                                                    </div>
                                                    <div class="text">
                                                        <div class="paragraphText">{!! $list['intro'] !!}</div>
                                                    </div>
                                                </ripple-btn>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tab-el>
                    </div>
                </div>
            </section>
        @endif
        <!-- 相關產品-->
        @if ($is_product)
            <section class="all-products" d-grid anchor-target="3">
                <div class="container" data-aost>
                    <div class="unitTitle-block center">
                        <div class="title">
                            <p>{{ $category['product_title'] }}</p>
                        </div>
                        @if (!empty($category['product_intro']))
                            <div class="text">
                                <p>{{ $category['product_intro'] }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-outer">
                        @foreach ($cateProducts->series as $series)
                            @foreach ($series->items as $item)
                                <div class="card">
                                    <a class="pic"
                                        href="{{ BaseFunction::b_url($cateProducts['half_url']) . '/' . $item['url_name'] }}">
                                        <picture>
                                            <img class="lazy" data-src="{{ $item['list_img_url'] }}" alt="">
                                        </picture>
                                    </a>
                                    <div class="text">
                                        <a class="itemTitle-w"
                                            href="{{ BaseFunction::b_url($cateProducts['half_url']) . '/' . $item['url_name'] }}">
                                            <div>{!! $item['banner_title'] !!}</div>
                                        </a>
                                        <div class="paragraphText">
                                            <div>{!! $item['banner_keyword_intro'] !!}</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">{!! $series['title'] !!}</p>
                                                </div>
                                            </div>
                                            <div class="btn">
                                                <a
                                                    href="{{ BaseFunction::b_url($cateProducts['half_url']) . '/' . $item['url_name'] }}">
                                                    <div class="common-btn">
                                                        <span class="buttonText">More</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>
    @include('Front.include.footerArea')

@endsection
