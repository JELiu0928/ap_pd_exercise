@extends('Front.template')

@section('css')
    {{-- <link rel="stylesheet" crossorigin href="/dist/assets/css/product.min.css?v={{ BaseFunction::getV() }}"> --}}
    {{-- <link rel="stylesheet" crossorigin href="/dist/assets/css/product_list.min.css?v={{ BaseFunction::getV() }}"> --}}
    <link rel="stylesheet" crossorigin href="/dist/assets/css/product_detail.min.css" />
    </head @endsection @section('script') {{-- <script type="module" crossorigin src="/dist/assets/js/product.min.js?v={{ BaseFunction::getV() }}"></script> --}} <script type="module" crossorigin src="/dist/assets/js/product_list.min.js?v={{ BaseFunction::getV() }}"></script>

@endsection

@section('script_back')
    <script type="module" crossorigin src="/dist/assets/js/product_detail.min.js"></script>

@endsection

@section('bodyClass', 'product_detail')
@section('content')
    @include('Front.include.headerArea')

    <!-- 主要內容-->
    <!-- 主要內容-->
    <main>
        <!-- banner 背景圖片建議尺寸: 電腦 2880x1035(px), 平板 1535x750(px), 手機 560x1255(px)--><!-- 標題 title-color="black" title-color="white" title-color="gradient"--><!-- 其他文字顏色 sub-color="black" sub-color="white"--><!-- 產品圖片建議尺寸: 電腦版 1080x675(px) 手機版 500x315(px)--><!-- 若無上產品圖, 請將 .photo-outer 結構移除-->
        <section class="customize-banner" d-grid data-aost detect-target title-color="black" sub-color="black"
            text-align="center">
            <div class="breadcrumb">
                <ul>
                    <li> <a class="icon" href="./index.html"><i class="icon-home"></i></a></li>
                    <li><a href="product.html"><span class="categoryBtn">產品專區</span></a></li>
                    <li><a href="product_list.html"><span class="categoryBtn">IoT RAM<sup>TM</sup></span></a></li>
                    <li><span class="categoryBtn">SPI & QSPI </span></li>
                </ul>
            </div>
            <div class="banner-container" d-grid>
                <div class="bg">
                    <picture>
                        <source data-srcset="/dist/assets/img/product/detail_banner_rwd_560x1255.jpg"
                            media="(max-width: 575px)">
                        <source data-srcset="/dist/assets/img/product/detail_banner_pad_1535x750.jpg"
                            media="(max-width: 1200px)"><img class="lazy"
                            data-src="/dist/assets/img/product/detail_banner_2880x1035.jpg" alt="">
                    </picture>
                </div>
                <div class="container" data-aost>
                    <div class="photo-outer"> <!-- 產品圖片建議尺寸: 電腦版 1080x675(px) 手機版 500x315(px)-->
                        <picture>
                            <source data-srcset="/dist/assets/img/product/product_rwd_01_500x315.png"
                                media="(max-width: 575px)"><img class="lazy"
                                data-src="/dist/assets/img/product/product_01_1080x675.png" alt="">
                        </picture>
                    </div>
                    <div class="content-block">
                        <div class="sub-block">
                            <div class="series-outer">
                                <div class="icon"> <i class="icon-tag"> </i></div><span>產品系列</span>
                                <div class="tag"><!-- 產品系列標籤, 最多一個-->
                                    <div class="tagItem">
                                        <p class="categoryBtn">PSRAM</p>
                                    </div>
                                </div>
                            </div><!-- 社群分享--><!-- 社群分享-->
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
                            <h2 class="unitTitle">客製化高頻寬記憶體</h2>
                            <div class="text-block">
                                <h3 class="itemTitle-w">世界第一個 3D 異質整合 DRAM 及邏輯晶片開發</h3>
                                <div class="paragraphText">Wi-Fi 模組設備、物聯網、智慧影像顯示裝置、穿戴式應用、工業感應器 (sensor) 設備</div>
                                <!-- 關鍵字標籤--><!-- 自訂按鈕文字、連結--><!-- 若無上連結, 請把 href 移除-->
                                <div class="keywords-block"> <a href="javascript:;"><ripple-btn class="tag categoryBtn"
                                            r4-hover="true" data-cotton>可穿戴式裝置</ripple-btn></a><a
                                        href="javascript:;"><ripple-btn class="tag categoryBtn" r4-hover="true"
                                            data-cotton>人工智慧和高速運算</ripple-btn></a><a href="javascript:;"><ripple-btn
                                            class="tag categoryBtn" r4-hover="true" data-cotton>顯示器</ripple-btn></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="anchor">
            <div class="container" data-aost data-aost-fade>
                <div class="common-categoryBar fixStyle">
                    <div class="cate-outer"><!-- m4-status="" 預設 active 選項及出現的內容--><multipurpose-nav m4-type="drag"
                            m4-option="{&quot;drag&quot;:{&quot;selected&quot;:false}}" m4-status="">
                            <li class="item"><a class="category" href="javascript:;"
                                    data-anchor-target="[anchor-target=&quot;1&quot;]">
                                    <p class="categoryBtn">產品介紹</p>
                                </a></li>
                            <li class="item"><a class="category" href="javascript:;"
                                    data-anchor-target="[anchor-target=&quot;2&quot;]">
                                    <p class="categoryBtn">產品規格表</p>
                                </a></li>
                            <li class="item"><a class="category" href="javascript:;"
                                    data-anchor-target="[anchor-target=&quot;3&quot;]">
                                    <p class="categoryBtn">相關文章</p>
                                </a></li>
                        </multipurpose-nav></div>
                </div>
            </div>
        </section><!-- 產品介紹-->
        <section class="detail-info" d-grid anchor-target="1">
            <div class="container" data-aost>
                <div class="unitTitle-block center">
                    <div class="sub"><span>Information</span><span>產品介紹</span></div>
                </div><!-- 段落編輯器--><!-- 按鈕有客製化樣式-->
                <div class="_articleBlock" data-aost>
                    <article class="_article">
                        <div class="_contentWrap">
                            <h4 class="_H">關於 SPI & QSPI</h4>
                            <div class="_wordCover">
                                <div class="_P">
                                    <p>IoTRAM<sup>TM</sup>中的 QSPI (Quad Serial Peripheral Interface) PSRAM 系列產品，擁有通用的 SPI
                                        序列式接口介面，除了低引腳數的特性，該系列產品可讓使用者自由選擇 SPI 單線 I/O 輸出入或是 Quad-I/O SPI 四線輸出入模式來提供更高的效能。更兼容的
                                        QSPI flash
                                        協定，使用者僅需修改軟體就可替換使用。</p>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class="_article typeR" article-flex="center">
                        <div class="_contentWrap">
                            <div class="_imgCover">
                                <div class="_cover">
                                    <div class="_photo"><img src="/dist/assets/img/product/detail_article_01.jpg"
                                            alt=""></div>
                                </div>
                            </div>
                            <div class="_wordCover">
                                <h4 class="_H">主要特性</h4>
                                <div class="_P">
                                    <ul>
                                        <li>低引腳數：簡化設計，降低產品系統成本</li>
                                        <li>高兼容性：與 QSPI flash 有高兼容性</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article class="_article" img-row="x5">
                        <div class="_contentWrap">
                            <h4 class="_H">產品應用</h4>
                            <div class="_imgCover">
                                <div class="_cover">
                                    <div class="_photo"><img src="/dist/assets/img/product/detail_article_02.jpg"
                                            alt=""></div>
                                    <p class="_description">Description</p>
                                </div>
                                <div class="_cover">
                                    <div class="_photo"><img src="/dist/assets/img/product/detail_article_03.jpg"
                                            alt=""></div>
                                    <p class="_description">Description</p>
                                </div>
                                <div class="_cover">
                                    <div class="_photo"><img src="/dist/assets/img/product/detail_article_04.jpg"
                                            alt=""></div>
                                    <p class="_description">Description</p>
                                </div>
                                <div class="_cover">
                                    <div class="_photo"><img src="/dist/assets/img/product/detail_article_05.jpg"
                                            alt=""></div>
                                    <p class="_description">Description</p>
                                </div>
                                <div class="_cover">
                                    <div class="_photo"><img src="/dist/assets/img/product/detail_article_06.jpg"
                                            alt=""></div>
                                    <p class="_description">Description</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="specification-block" d-grid anchor-target="2">
            <div class="container" data-aost collapse rwdActive breakPoint900>
                <div class="unitTitle-block center">
                    <div class="sub"><span>Specification</span><span>產品規格表</span></div>
                </div>
                <div class="collapseBox filter-collapse">
                    <div class="icon no-transform"><i class="icon-filter"></i></div>
                    <p class="paragraphText-w">產品篩選</p>
                </div><!-- 規格表；下拉有篩選功能-->
                <div class="collapseTarget">
                    <div>
                        <div class="dropdown-wrap"><dropdown-el class="dropdown1" d4-placeholder="density">
                                <li data-option="customID">Density</li>
                                <li>16Mb</li>
                                <li>32Mb</li>
                                <li>64Mb</li>
                                <li>128Mb</li>
                            </dropdown-el><dropdown-el class="dropdown2" d4-placeholder="voltage">
                                <li data-option="customID">Voltage</li>
                                <li>1.8V</li>
                            </dropdown-el><dropdown-el class="dropdown3" d4-placeholder="config">
                                <li data-option="customID">Config.</li>
                                <li>X4</li>
                            </dropdown-el><dropdown-el class="dropdown4" d4-placeholder="rate">
                                <li data-option="customID">Data rate (Mbps)</li>
                                <li>84</li>
                                <li>133</li>
                                <li>144</li>
                                <li>333</li>
                            </dropdown-el>
                            <div class="delete-button">
                                <div class="icon"> <i class="icon-delete"></i></div>
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
                                        <div class="td">
                                            <p>Density</p>
                                        </div>
                                        <div class="td">
                                            <p>Voltage</p>
                                        </div>
                                        <div class="td">
                                            <p>Config.</p>
                                        </div>
                                        <div class="td">
                                            <p>Data rate (Mbps)</p>
                                        </div>
                                        <div class="td">
                                            <p>Bandwidth (MBps)</p>
                                        </div>
                                        <div class="td">
                                            <p>Commercial</p>
                                        </div>
                                        <div class="td">
                                            <p>Industrial</p>
                                        </div>
                                        <div class="td">
                                            <p>Status</p>
                                        </div>
                                        <div class="td">
                                            <p>RBX</p>
                                        </div>
                                        <div class="td">
                                            <p>HalfsleepTM</p>
                                        </div>
                                        <div class="td">
                                            <p>KGD</p>
                                        </div>
                                        <div class="td">
                                            <p>USON8</p>
                                        </div>
                                        <div class="td">
                                            <p>SOP8</p>
                                        </div>
                                        <div class="td">
                                            <p>WLCSP</p>
                                        </div>
                                        <div class="td action fixed-right">
                                            <p>Action</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--***- 11.12 tbody 父層多包一個 tbody-outer-->
                        <div class="tbody-outer">
                            <div class="scroller">
                                <div class="tbody">
                                    <!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS1604M-SQR</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>16Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS1604M-3SQR</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>16Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>84</p>
                                        </div>
                                        <div class="td">
                                            <p>84</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS1604M-DQRA</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>16Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>333</p>
                                        </div>
                                        <div class="td">
                                            <p>333</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS3204L-3SQN</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>32Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>133</p>
                                        </div>
                                        <div class="td">
                                            <p>133</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS6404L-SQN</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>64Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS6404L-3SQN</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>64Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>3.0V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>133</p>
                                        </div>
                                        <div class="td">
                                            <p>133</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS6404L-SQH</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>64Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS6404L-SQRH</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>64Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS12804O-SQRH</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>128Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>144</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div><!-- 加入諮詢, 在 tr 加上 added 的 class--><!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接-->
                                    <div class="tr">
                                        <div class="td fixed-left">
                                            <p>APS12804O-DQ</p>
                                            <div class="row-flex rwd action"><a class="flex" href="javascript:;"
                                                    target="_blank">
                                                    <div class="icon"><i class="icon-download"></i></div>
                                                </a>
                                                <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                    <div class="icon"><i class="icon-plus"></i><i
                                                            class="icon-check"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="td">
                                            <p>128Mb</p>
                                        </div>
                                        <div class="td">
                                            <p>1.8V</p>
                                        </div>
                                        <div class="td">
                                            <p>X4</p>
                                        </div>
                                        <div class="td">
                                            <p>333</p>
                                        </div>
                                        <div class="td">
                                            <p>333</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~85</p>
                                        </div>
                                        <div class="td">
                                            <p>'-40~105</p>
                                        </div>
                                        <div class="td">
                                            <p>MP</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p></p>
                                        </div>
                                        <div class="td">
                                            <p>V</p>
                                        </div>
                                        <div class="td action fixed-right"><a class="flex" href="javascript:;"
                                                target="_blank">
                                                <div class="icon"><i class="icon-download"></i></div>
                                                <p class="paragraphText">下載檔案</p>
                                            </a>
                                            <div class="flex addConsult" onclick="document.body.fesd.addConsult()">
                                                <div class="icon"><i class="icon-plus"></i><i class="icon-check"></i>
                                                </div>
                                                <p class="paragraphText">加入諮詢</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tips">
                        <div class="icon"> <i class="icon-drag"></i></div>
                        <p class="paragraphText-s">拖曳表格即可瀏覽完整資訊</p>
                    </div><!-- 表格底下皆有預留文字敘述欄位, 可參考 investor_financial_revenue.html 之 .table-text 的結構-->
                    <div class="table-text">
                        <div class="paragraphText">愛普（6531 TW）13 日發佈重大訊息，以新台幣 5 億元取得來頡科技股份有限公司（6799 TW）4
                            佰萬股股份，藉此一投資案，愛普可提升公司資金運用效益，同時也期望將愛普 3D 堆疊先進封裝經驗和技術進一步推展至電源管理應用領域。</div>
                    </div>
                </div>
            </div>
        </section><!-- 相關文章-->
        <section class="related-news" d-grid anchor-target="3" bg-color="white">
            <div class="container" data-aost>
                <div class="unitBlockSub"><span>Related Articles</span><span>相關文章</span></div>
                <div class="content-block">
                    <div class="item">
                        <div class="top">
                            <div class="date">
                                <p class="paragraphText-w">2023-11-20</p>
                            </div><a class="title" href="javascript:;">
                                <p class="articlesSub">愛普攜手來頡，佈局 3D 封裝電源管理</p>
                            </a>
                            <div class="text">
                                <p class="paragraphText">愛普（6531 TW）13 日發佈重大訊息，以新台幣 5 億元取得來頡科技股份有限公司（6799 TW）4
                                    佰萬股股份，藉此一投資案，愛普可提升公司資金運用效益，同時也期望將愛普 3D 堆疊先進封裝經驗和技術進一步推展至電源管理應用領域。 </p>
                            </div>
                        </div>
                        <div class="bottom" data-href="javascript:;">
                            <div class="categoryBtn"><a class="btn" href="./news.html"><span>新聞稿發佈</span></a><a
                                    class="btn" href="./news.html"><span>技術文章</span></a></div><ripple-btn
                                class="plus blue" r4-hover="true" data-cotton><a href="./news.html"><i
                                        class="icon-plus"></i></a></ripple-btn>
                        </div>
                    </div>
                    <div class="item">
                        <div class="top">
                            <div class="date">
                                <p class="paragraphText-w">2023-11-04</p>
                            </div><a class="title" href="javascript:;">
                                <p class="articlesSub">愛普科技與 Mobiveil 攜手提供系統單晶片業者推進至 250MHz 之 PSRAM 解決方案</p>
                            </a>
                            <div class="text">
                                <p class="paragraphText">全球客製化記憶體解決方案設計公司愛普科技（愛普，股票代碼 TW6531）2023/03/28 宣布與矽智財（SIP）、平台和 IP
                                    設計服務供應商
                                    Mobiveil, Inc 聯手合作推出 IOT RAM（OPI & HPI PSRAM）記憶體解決方案，提供系統單晶片（SoC）設計者更多方案選項。</p>
                            </div>
                        </div>
                        <div class="bottom" data-href="javascript:;">
                            <div class="categoryBtn"><a class="btn" href="./news.html"><span>新聞稿發佈</span></a></div>
                            <ripple-btn class="plus blue" r4-hover="true" data-cotton><a href="./news.html"><i
                                        class="icon-plus">
                                    </i></a></ripple-btn>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- 相關產品--><!--***- 11.15 修正 breakline 位置 父層 section 補 data-aost -->
        <section class="related-products" d-grid data-aost>
            <div class="breakLine"></div>
            <div class="container" data-aost>
                <div class="unitTitle-block center">
                    <div class="sub"><span>More Products</span><span>更多產品</span></div>
                </div>
                <div class="content-block">
                    <div class="swiper relatedProduct-swiper">
                        <div class="swiper-wrapper card-outer"><!-- 圖片建議尺寸 660x450(px)-->
                            <div class="swiper-slide">
                                <div class="card"><a class="pic" href="javascript:;">
                                        <picture><img class="lazy"
                                                data-src="/dist/assets/img/solution/pic_02_660x450.jpg" alt="">
                                        </picture>
                                    </a>
                                    <div class="text"> <a class="title" href="javascript:;">
                                            <p class="itemTitle-w">SPI & QSPI</p>
                                        </a>
                                        <div class="desc">
                                            <div class="paragraphText">邊緣 AI 產品、智慧家庭、穿戴式設備、5G 通訊、顯示器時序控制 (T-CON) 等應用</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">PSRAM </p>
                                                </div>
                                            </div>
                                            <div class="btn"> <a href="javascript:;">
                                                    <div class="common-btn"><span class="buttonText">More</span></div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card"><a class="pic" href="javascript:;">
                                        <picture><img class="lazy"
                                                data-src="/dist/assets/img/solution/pic_03_660x450.jpg" alt="">
                                        </picture>
                                    </a>
                                    <div class="text"> <a class="title" href="javascript:;">
                                            <p class="itemTitle-w">OPI & HPI</p>
                                        </a>
                                        <div class="desc">
                                            <div class="paragraphText">數據機連網設備、物聯網、邊緣運算人工智慧、智慧顯示裝置、穿戴式應用</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">PSRAM </p>
                                                </div>
                                            </div>
                                            <div class="btn"> <a href="javascript:;">
                                                    <div class="common-btn"><span class="buttonText">More</span></div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card"><a class="pic" href="javascript:;">
                                        <picture><img class="lazy"
                                                data-src="/dist/assets/img/solution/pic_04_660x450.jpg" alt="">
                                        </picture>
                                    </a>
                                    <div class="text"> <a class="title" href="javascript:;">
                                            <p class="itemTitle-w">Low Voltage</p>
                                        </a>
                                        <div class="desc">
                                            <div class="paragraphText">數據機連網設備、物聯網、邊緣運算人工智慧、智慧顯示裝置、穿戴式裝置、使用電池供電的產品</div>
                                        </div>
                                        <div class="bot">
                                            <div class="tag">
                                                <div class="tagItem">
                                                    <p class="categoryBtn">LPDDR </p>
                                                </div>
                                            </div>
                                            <div class="btn"> <a href="javascript:;">
                                                    <div class="common-btn"><span class="buttonText">More</span></div>
                                                </a></div>
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

@show
