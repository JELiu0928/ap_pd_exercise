@extends('Front.template')

@section('css')
    {{-- <link rel="stylesheet" crossorigin href="/dist/assets/css/product_detail.min.css?v={{ BaseFunction::getV() }}" /> --}}
    <link rel="stylesheet" crossorigin href="/dist/assets/css/product_consultSuccess.min.css?v={{ BaseFunction::getV() }}">

@endsection
@section('script')
    <script type="module" crossorigin src="/dist/assets/js/product_consultSuccess.min.js?v={{ BaseFunction::getV() }}">
    </script>

@endsection

@section('script_back')
    <script defer type="module" src="/bk/product/index.js?v={{ BaseFunction::getV() }}"></script>
@stop

@section('bodyClass', 'product_consultSuccess')
@section('content')
    @include('Front.include.headerArea')

    <!-- 主要內容-->
    <main>
        <section class="main-block" d-grid>
            <div class="container" data-aost>
                <div class="unitTitle-block center">
                    <div class="title" text-style="gradient">
                        <p>諮詢清單已成功送出</p>
                    </div>
                    <div class="text">
                        <p>感謝您的填寫，相關單位工作人員將盡快聯繫您，請耐心等候。</p>
                    </div>
                </div>
                <div class="content-block">
                    <div class="block">
                        <div class="grid step-block">
                            <span class="step">01</span>
                            <span class="itemTitle-w">確認諮詢產品</span>
                            <span class="total paragraphText-w">共計：{{ $successCount }} 項</span>
                            {{-- 共計：<span>{{ $successCount }} </span>項</span> --}}
                        </div>
                        <div class="grid consult-list">
                            <p class="paragraphText-w">產品諮詢清單</p>
                            <div class="list-outer">
                                @foreach ($consultItem->ProductConsultList as $list)
                                    {{-- @dump($list) --}}
                                    <div class="list">
                                        <div class="row">
                                            <ul>
                                                <li class="paragraphText"><span>產品類別</span>
                                                    <span>{!! $list->part->item->series->category['banner_title'] !!}</span>
                                                </li>
                                                <li class="paragraphText">
                                                    <span>產品系列</span>
                                                    {!! $list->part->item->series['title'] !!}
                                                </li>
                                                <li class="paragraphText">
                                                    <span>產品項目</span><span>{!! $list->part->item['banner_title'] !!}</span>
                                                </li>
                                            </ul>
                                            <div class="main">
                                                <p class="itemTitle-w">{{ $list->part['title'] }}</p>
                                            </div>
                                            <div class="note">
                                                <span class="paragraphText-w">備註：</span>
                                                <span class="paragraphText">{!! nl2br($list['description']) !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="no-consult d-none">
                                    <div class="icon">
                                        <i class="icon-warning"></i>
                                    </div>
                                    <span class="paragraphText">您尚未將任何產品加入線上諮詢清單，請先選擇產品以便進行諮詢。</span>
                                </div>
                            </div>
                        </div>
                        {{-- <!--***- 11.11 新增欄位--> --}}
                        <div class="grid other-list">
                            <p class="paragraphText-w">其他產品需求</p>
                            <div class="list-outer">
                                <div class="list">
                                    <p>{!! nl2br($consultItem['other_require']) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="grid step-block">
                            <span class="step">02</span>
                            <span class="itemTitle-w">填寫聯繫資料</span>
                        </div>
                        <div class="form-detail">
                            <div class="form-wrap">
                                <div class="form-row">
                                    <div class="form-grid">
                                        <div class="form-group required">
                                            <div class="subject">
                                                <p class="paragraphText-w">公司名稱</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['companyName'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <div class="subject">
                                                <p class="paragraphText-w">主要職務</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['job'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-grid">
                                        <div class="form-group required">
                                            <div class="subject">
                                                <p class="paragraphText-w">聯絡姓名</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['name'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <div class="subject">
                                                <p class="paragraphText-w">稱謂</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['service'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-grid">
                                        <div class="form-group required">
                                            <div class="subject">
                                                <p class="paragraphText-w">電子信箱</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['mail'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group required">
                                            <div class="subject">
                                                <p class="paragraphText-w">聯絡電話</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['tel'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <div class="subject">
                                                <p class="paragraphText-w">備註</p>
                                            </div>
                                            <div class="input-wrap">
                                                <p class="paragraphText">{{ $consultItem['description'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="default-btn form-clear" href="{{ BaseFunction::b_url('product') }}" color="light-gray"
                    size="small">
                    <div class="txt">返回產品專區</div>
                </a>
            </div>
        </section>
    </main>
    @include('Front.include.footerArea')
@endsection
