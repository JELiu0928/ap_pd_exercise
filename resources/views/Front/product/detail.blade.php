@extends('Front.template')

@section('css')
    <link rel="stylesheet" crossorigin href="/dist/assets/css/product_detail.min.css?v={{ BaseFunction::getV() }}" />

@endsection
@section('script')
    {{-- <script type="module" crossorigin src="/dist/assets/js/product.min.js?v={{ BaseFunction::getV() }}"></script> --}}
    {{-- <script type="module" crossorigin src="/dist/assets/js/product_list.min.js?v={{ BaseFunction::getV() }}"></script> --}}
    <script type="module" crossorigin src="/dist/assets/js/product_detail.min.js?v={{ BaseFunction::getV() }}"></script>

@endsection

@section('script_back')
    <script defer type="module" src="/bk/product/index.js?v={{ BaseFunction::getV() }}"></script>
@stop

@section('bodyClass', 'product_detail')
@section('content')
    @include('Front.include.headerArea')

    <!-- 主要內容-->
    <main>
        <!-- banner 背景圖片建議尺寸: 電腦 2880x1035(px), 平板 1535x750(px), 手機 560x1255(px)-->
        <!-- 標題 title-color="black" title-color="white" title-color="gradient"-->
        <!-- 其他文字顏色 sub-color="black" sub-color="white"--><!-- 產品圖片建議尺寸: 電腦版 1080x675(px) 手機版 500x315(px)-->
        <!-- 若無上產品圖, 請將 .photo-outer 結構移除-->
        <section class="customize-banner" d-grid data-aost detect-target
            title-color="{{ $productInfo['banner_title_color'] }}" sub-color="{{ $productInfo['banner_intro_color'] }}"
            text-align="center">
            <div class="breadcrumb">
                <ul>
                    <li>
                        <a class="icon" href="{{ BaseFunction::b_url('/') }}"><i class="icon-home"></i></a>
                    </li>
                    <li>
                        <a href="{{ BaseFunction::b_url('/product') }}"><span class="categoryBtn">產品專區</span></a>
                    </li>
                    <li>
                        {{-- @dump($productInfo['series']['category']['half_url']) --}}
                        <a href="{{ BaseFunction::b_url($productInfo->series->category['half_url']) }}"><span
                                class="categoryBtn">{!! $productInfo->series->category['banner_title'] !!}</span></a>
                    </li>
                    <li><span class="categoryBtn">{!! $productInfo['banner_title'] !!}</span></li>
                </ul>
            </div>
            <div class="banner-container" d-grid>
                <div class="bg">
                    @if (!empty($productInfo['banner_pc_img_url']))
                        <picture>
                            <source data-srcset="{{ $productInfo['banner_m_img_url'] }}" media="(max-width: 575px)" />
                            <source data-srcset="{{ $productInfo['banner_pad_img_url'] }}" media="(max-width: 1200px)" />
                            <img class="lazy" data-src="{{ $productInfo['banner_pc_img_url'] }}" alt="" />
                        </picture>
                    @endif
                </div>
                <div class="container" data-aost>
                    @if (!empty($productInfo['product_pc_img']))
                        <div class="photo-outer">
                            <!-- 產品圖片建議尺寸: 電腦版 1080x675(px) 手機版 500x315(px)-->
                            <picture>
                                <source data-srcset="{{ $productInfo['product_m_img_url'] }}" media="(max-width: 575px)" />
                                <img class="lazy" data-src="{{ $productInfo['product_pc_img_url'] }}" alt="" />
                            </picture>
                        </div>
                    @endif
                    <div class="content-block">
                        <div class="sub-block">
                            <div class="series-outer">
                                <div class="icon"><i class="icon-tag"> </i></div>
                                <span>產品系列</span>
                                <div class="tag">
                                    <!-- 產品系列標籤, 最多一個-->
                                    <div class="tagItem">
                                        <p class="categoryBtn">PSRAM</p>
                                    </div>
                                </div>
                            </div>
                            <!-- 社群分享-->
                            <!-- 社群分享-->
                            <div class="share-block" web-share>
                                <div class="icon-outer" share-target="facebook">
                                    <div class="icon"><i class="icon-facebook"></i></div>
                                </div>
                                <div class="icon-outer" share-target="wechat">
                                    <div class="icon"><i class="icon-wechat"></i></div>
                                </div>
                                <div class="icon-outer" share-target="linkedin">
                                    <div class="icon"><i class="icon-linkedin"></i></div>
                                </div>
                                <div class="icon-outer" share-target="url" copy-success="Copied">
                                    <div class="icon"><i class="icon-copy"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="title-block">
                            <h2 class="unitTitle">{!! $productInfo['banner_title'] !!}</h2>
                            <div class="text-block">
                                <h3 class="itemTitle-w">{!! $productInfo['banner_keyword_title'] !!}</h3>
                                <div class="paragraphText">{!! $productInfo['banner_keyword_intro'] !!}</div>
                                <!-- 關鍵字標籤-->
                                <!-- 自訂按鈕文字、連結-->
                                <!-- 若無上連結, 請把 href 移除-->
                                <div class="keywords-block">
                                    @foreach ($productInfo->keywords as $keyword)
                                        <a href="{{ $keyword['link'] }}">
                                            <ripple-btn class="tag categoryBtn" r4-hover="true" data-cotton>
                                                {{ $keyword['title'] }}
                                            </ripple-btn>
                                        </a>
                                    @endforeach
                                    {{-- <a href="javascript:;">
                                        <ripple-btn class="tag categoryBtn" r4-hover="true" data-cotton>
                                            顯示器
                                        </ripple-btn>
                                    </a> --}}
                                </div>
                            </div>
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
                        <multipurpose-nav m4-type="drag" m4-option='{"drag":{"selected":false}}' m4-status="">
                            @if ($is_article)
                                <li class="item">
                                    <a class="category" href="javascript:;" data-anchor-target='[anchor-target="1"]'>
                                        <p class="categoryBtn">產品介紹</p>
                                    </a>
                                </li>
                            @endif
                            <li class="item">
                                <a class="category" href="javascript:;" data-anchor-target='[anchor-target="2"]'>
                                    <p class="categoryBtn">產品規格表</p>
                                </a>
                            </li>
                            <li class="item">
                                <a class="category" href="javascript:;" data-anchor-target='[anchor-target="3"]'>
                                    <p class="categoryBtn">相關文章</p>
                                </a>
                            </li>
                        </multipurpose-nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- 產品介紹-->
        @if ($is_article)
            <section class="detail-info" d-grid anchor-target="1">
                <div class="container" data-aost>
                    <div class="unitTitle-block center">
                        <div class="sub">
                            <span>Information</span>
                            <span>產品介紹</span>
                        </div>
                    </div>
                    <!-- 段落編輯器-->
                    <!-- 按鈕有客製化樣式-->
                    <div class="_articleBlock" data-aost>
                        @include('article_v3', [
                            'articles' => $productInfo->articles,
                            'imageGroupKey' => 'articleImgs',
                        ])

                    </div>
                </div>
            </section>
        @endif

        <section class="specification-block" d-grid anchor-target="2">
            <div class="container" data-aost collapse rwdActive breakPoint900>
                <div class="unitTitle-block center">
                    <div class="sub"><span>Specification</span><span>產品規格表</span></div>
                </div>
                <div class="collapseBox filter-collapse">
                    <div class="icon no-transform"><i class="icon-filter"></i></div>
                    <p class="paragraphText-w">產品篩選</p>
                </div>
                <!-- 規格表；下拉有篩選功能-->
                <div class="collapseTarget">
                    <div>
                        <div class="dropdown-wrap">
                            @foreach ($dropdownArr as $spec)
                                {{-- @dump($spec) --}}
                                <dropdown-el class="dropdown1 bk-drop" bk-dropdown-spec-id="{{ $spec['spec_id'] }}"
                                    d4-placeholder="{{ $spec['spec_title'] }}">
                                    <li data-option="customID" class="bk-spec-item">
                                        {{ $spec['spec_title'] }}
                                    </li>
                                    @foreach ($spec['content'] as $content)
                                        <li class="bk-spec-item">{{ $content }}</li>
                                    @endforeach
                                    {{-- <li>32Mb</li>
                                    <li>64Mb</li>
                                    <li>128Mb</li> --}}
                                </dropdown-el>
                            @endforeach
                            {{-- <dropdown-el class="dropdown2" d4-placeholder="voltage">
                                <li data-option="customID">Voltage</li>
                                <li>1.8V</li>
                            </dropdown-el>
                            <dropdown-el class="dropdown3" d4-placeholder="config">
                                <li data-option="customID">Config.</li>
                                <li>X4</li>
                            </dropdown-el>
                            <dropdown-el class="dropdown4" d4-placeholder="rate">
                                <li data-option="customID">Data rate (Mbps)</li>
                                <li>84</li>
                                <li>133</li>
                                <li>144</li>
                                <li>333</li>
                            </dropdown-el> --}}
                            <div class="delete-button bk-clearFilter">
                                <div class="icon"><i class="icon-delete"></i></div>
                                <p>清除條件</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-block">
                    <div class="common-table" data-type="drag">
                        <div class="thead-outer">
                            <div class="scroller">
                                <div class="thead">
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>Part Number</p>
                                        </div>
                                        {{-- 表頭 --}}
                                        {{-- @dd($specTitles) --}}
                                        @foreach ($specTitles as $title)
                                            <div class="td" bk-spec-title-id="{{ $title['id'] }}">
                                                <p>{{ $title['title'] }}</p>
                                            </div>
                                        @endforeach
                                        <div class="td action fixed-right">
                                            <p>Action</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--***- 11.12 tbody 父層多包一個 tbody-outer-->
                        <div class="tbody-outer">
                            <div class="scroller">
                                <div class="tbody">
                                    <!-- 加入諮詢, 在 tr 加上 added 的 class-->
                                    <!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    @foreach ($specParts as $part)
                                        {{-- @dump(in_array($part['id'],$sessionPartIDs)) --}}
                                        <div class="tr bk-tr {{ 'bk-part-' . $part['id'] }} {{is_array($sessionPartIDs) && in_array($part['id'],$sessionPartIDs) ? 'added' : '' }} "
                                            bk-part-id="{{ $part['id'] }}">
                                            <div class="td fixed-left">
                                                <p>{{ $part['title'] }}</p>
                                                <div class="row-flex rwd action">
                                                    <a class="flex" href="javascript:;" target="_blank">
                                                        <div class="icon">
                                                            <i class="icon-download"> </i>
                                                        </div>
                                                    </a>
                                                    {{-- rwd --}}
                                                    <div class="flex addConsult bk-add-consult-btn" {{-- onclick="document.body.fesd.addConsult()"> --}}>
                                                        <div class="icon">
                                                            <i class="icon-plus"></i>
                                                            <i class="icon-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($specTitles as $title)
                                                {{-- @dump($title) --}}
                                                <div class="td" bk-title-spec-id="{{ $title['id'] }}">
                                                    <p>{!! isset($specContentArr[$title->id][$part->id]) ? $specContentArr[$title->id][$part->id] : '' !!}</p>
                                                </div>
                                            @endforeach
                                            <div class="td action fixed-right">
                                                <a class="flex" href="javascript:;" target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                    <p class="paragraphText">下載檔案</p>
                                                </a>
                                                {{-- <div class="flex addConsult" onclick="document.body.fesd.addConsult()"> --}}
                                                <div class="flex addConsult bk-add-consult-btn">
                                                    <div class="icon">
                                                        <i class="icon-plus"></i>
                                                        <i class="icon-check"></i>
                                                    </div>
                                                    <p class="paragraphText">加入諮詢</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tips">
                        <div class="icon"><i class="icon-drag"></i></div>
                        <p class="paragraphText-s">拖曳表格即可瀏覽完整資訊</p>
                    </div>
                    {{-- <!-- 表格底下皆有預留文字敘述欄位, 可參考 investor_financial_revenue.html 之 .table-text 的結構--> --}}
                    @if (!empty(strip_tags($productInfo->spec_note)))
                        <div class="table-text">
                            <div class="paragraphText">{!! nl2br($productInfo->spec_note) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <!-- 相關文章-->
        <section class="related-news" d-grid anchor-target="3" bg-color="white">
            <div class="container" data-aost>
                <div class="unitBlockSub"><span>Related Articles</span><span>相關文章</span></div>
                <div class="content-block">
                    <div class="item">
                        <div class="top">
                            <div class="date">
                                <p class="paragraphText-w">2023-11-20</p>
                            </div>
                            <a class="title" href="javascript:;">
                                <p class="articlesSub">愛普攜手來頡，佈局 3D 封裝電源管理</p>
                            </a>
                            <div class="text">
                                <p class="paragraphText">愛普（6531 TW）13 日發佈重大訊息，以新台幣 5 億元取得來頡科技股份有限公司（6799 TW）4
                                    佰萬股股份，藉此一投資案，愛普可提升公司資金運用效益，同時也期望將愛普 3D 堆疊先進封裝經驗和技術進一步推展至電源管理應用領域。</p>
                            </div>
                        </div>
                        <div class="bottom" data-href="javascript:;">
                            <div class="categoryBtn">
                                <a class="btn" href="./news.html"><span>新聞稿發佈</span></a><a class="btn"
                                    href="./news.html"><span>技術文章</span></a>
                            </div>
                            <ripple-btn class="plus blue" r4-hover="true" data-cotton><a href="./news.html"><i
                                        class="icon-plus"></i></a></ripple-btn>
                        </div>
                    </div>
                    <div class="item">
                        <div class="top">
                            <div class="date">
                                <p class="paragraphText-w">2023-11-04</p>
                            </div>
                            <a class="title" href="javascript:;">
                                <p class="articlesSub">愛普科技與 Mobiveil 攜手提供系統單晶片業者推進至 250MHz 之 PSRAM 解決方案</p>
                            </a>
                            <div class="text">
                                <p class="paragraphText">全球客製化記憶體解決方案設計公司愛普科技（愛普，股票代碼 TW6531）2023/03/28 宣布與矽智財（SIP）、平台和 IP
                                    設計服務供應商 Mobiveil, Inc 聯手合作推出 IOT RAM（OPI & HPI PSRAM）記憶體解決方案，提供系統單晶片（SoC）設計者更多方案選項。</p>
                            </div>
                        </div>
                        <div class="bottom" data-href="javascript:;">
                            <div class="categoryBtn">
                                <a class="btn" href="./news.html"><span>新聞稿發佈</span></a>
                            </div>
                            <ripple-btn class="plus blue" r4-hover="true" data-cotton><a href="./news.html"><i
                                        class="icon-plus"> </i></a></ripple-btn>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- 相關產品-->
        <!--***- 11.15 修正 breakline 位置 父層 section 補 data-aost -->
        <section class="related-products" d-grid data-aost>
            <div class="breakLine"></div>
            <div class="container" data-aost>
                <div class="unitTitle-block center">
                    <div class="sub"><span>More Products</span><span>更多產品</span></div>
                </div>
                <div class="content-block">
                    <div class="swiper relatedProduct-swiper">
                        <div class="swiper-wrapper card-outer">
                            <!-- 圖片建議尺寸 660x450(px)-->
                            <div class="swiper-slide">
                                <div class="card">
                                    <a class="pic" href="javascript:;">
                                        <picture><img class="lazy"
                                                data-src="/dist/assets/img/solution/pic_02_660x450.jpg" alt="" />
                                        </picture>
                                    </a>
                                    <div class="text">
                                        <a class="title" href="javascript:;">
                                            <p class="itemTitle-w">SPI & QSPI</p>
                                        </a>
                                        <div class="desc">
                                            <div class="paragraphText">邊緣 AI 產品、智慧家庭、穿戴式設備、5G 通訊、顯示器時序控制 (T-CON) 等應用</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">PSRAM</p>
                                                </div>
                                            </div>
                                            <div class="btn">
                                                <a href="javascript:;">
                                                    <div class="common-btn"><span class="buttonText">More</span></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card">
                                    <a class="pic" href="javascript:;">
                                        <picture><img class="lazy"
                                                data-src="/dist/assets/img/solution/pic_03_660x450.jpg" alt="" />
                                        </picture>
                                    </a>
                                    <div class="text">
                                        <a class="title" href="javascript:;">
                                            <p class="itemTitle-w">OPI & HPI</p>
                                        </a>
                                        <div class="desc">
                                            <div class="paragraphText">數據機連網設備、物聯網、邊緣運算人工智慧、智慧顯示裝置、穿戴式應用</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">PSRAM</p>
                                                </div>
                                            </div>
                                            <div class="btn">
                                                <a href="javascript:;">
                                                    <div class="common-btn"><span class="buttonText">More</span></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card">
                                    <a class="pic" href="javascript:;">
                                        <picture><img class="lazy"
                                                data-src="/dist/assets/img/solution/pic_04_660x450.jpg" alt="" />
                                        </picture>
                                    </a>
                                    <div class="text">
                                        <a class="title" href="javascript:;">
                                            <p class="itemTitle-w">Low Voltage</p>
                                        </a>
                                        <div class="desc">
                                            <div class="paragraphText">數據機連網設備、物聯網、邊緣運算人工智慧、智慧顯示裝置、穿戴式裝置、使用電池供電的產品</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">LPDDR</p>
                                                </div>
                                            </div>
                                            <div class="btn">
                                                <a href="javascript:;">
                                                    <div class="common-btn"><span class="buttonText">More</span></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('Front.include.footerArea')

@endsection
