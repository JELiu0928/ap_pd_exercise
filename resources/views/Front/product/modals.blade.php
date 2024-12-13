<modern-modal data-modal-id="consult-modal" data-modal-animate="fade-up">
    {{-- @dd($aaa) --}}
    <div class="close-btn" data-modal-close></div>
    <div class="modal-container">
        <div class="consult-container">
            <div class="unitTitle-block center">
                <div class="sub">
                    <p>線上產品諮詢清單</p>
                </div>
                <div class="text">
                    <p>以下列表為加入線上諮詢清單的產品，確認無誤後可填寫聯絡人資訊，相關單位工作人員將盡快聯繫您。</p>
                </div>
            </div>
            <div class="consult-content" step-active="1">
                <!-- 步驟 1-->
                {{-- @dump($partItemCounts) --}}

                <div class="block active" step-target="1">
                    <div class="grid step-block"><span class="step">01</span>
                        <span class="itemTitle-w">確認諮詢產品</span>
                        <span class="total paragraphText-w ">
                            共計：<span class="bk-total-count">{{ $partItemCounts }}</span> 項
                        </span>
                    </div>
                    <div class="grid consult-list">
                        <p class="paragraphText-w">產品諮詢清單</p>
                        <div class="list-outer">
                            <!-- 若無加入項目, list-group 加上 .d-none, .no-consult 移除 .d-none-->
                            <div class="list-group bk-list-group {{ $partItemCounts == 0 ? 'd-none' : '' }}">
                                @include('Front.product.consult_pd_list')
                            </div>
                            <div class="no-consult @if ($partItemCounts != 0) d-none @endif ">
                                <div class="icon">
                                    <i class="icon-warning"></i>
                                </div>
                                <span class="paragraphText">您尚未將任何產品加入線上諮詢清單，請先選擇產品以便進行諮詢。</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid other">
                        <div class="form-row">
                            <div class="form-grid">
                                <label class="form-group textarea">
                                    <div class="subject">
                                        <p class="paragraphText-w">其他產品需求</p>
                                    </div>
                                    <div class="input-wrap ">
                                        <textarea class="textarea-scrollbar bk-other-require" form-field="other-require" type="text" placeholder="新增備註...."
                                            name="description"></textarea>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="default-btn bk-delete-all @if ($partItemCounts != 0) d-none @endif "
                            href="javascript:;" color="light-gray" size="large" {{-- onclick="document.body.fesd.ajaxAllDelete()" --}}>
                            <div class="txt">移除所有產品 </div>
                        </a>
                        <!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
                        <div class="spread-btn default-btn anchorEffect bk-next-step @if ($partItemCounts != 0) disabled @endif "
                            color="black" size="large" style="--hoverball: #2E2E2E" {{-- onclick="document.body.fesd.processSwitchStep()" --}}
                            data-anchor-container="modern-modal[data-modal-id=&quot;consult-modal&quot;] [data-overlayscrollbars-viewport]"
                            data-anchor-target="">
                            <div class="txt">前往下一步</div>
                        </div>
                    </div>
                </div>
                <!-- 步驟 2-->
                <div class="block" step-target="2">
                    <div class="grid step-block">
                        <span class="step">02</span>
                        <span class="itemTitle-w">填寫聯繫資料</span>
                    </div>
                    <div class="consult-form bk-consult-form">
                        <div class="form-wrap">
                            <div class="form-row">
                                <div class="form-grid first">
                                    <!-- 必填在 .form-group 加 .required--><!-- 錯誤在 .form-group 加 .error--><label
                                        class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>公司名稱</p>
                                            <div class="error-text"></div>

                                        </div>
                                        <div class="input-wrap">
                                            <input form-field="companyName" type="text" placeholder="請填寫您的公司名稱">
                                        </div>
                                    </label>
                                </div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <div class="subject paragraphText-w">
                                            <p>主要職務</p>
                                            <div class="error-text"></div>

                                        </div>
                                        {{-- @dump($consultJobs) --}}
                                        <dropdown-el class="type-fullbox" d4-placeholder="請選擇您的主要職務" form-field="job"
                                            field-type="isSelect">
                                            @foreach ($consultJobs as $job)
                                                <li>
                                                    <p bk-job-id="{{ $job['id'] }}">{{ $job['title'] }}</p>
                                                </li>
                                            @endforeach
                                        </dropdown-el>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-grid">
                                    <label class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>聯絡姓名</p>
                                            <div class="error-text"></div>
                                        </div>
                                        <div class="input-wrap">
                                            <input form-field="name" type="text" placeholder="請填寫您的聯絡姓名">
                                        </div>
                                    </label>
                                </div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <div class="subject paragraphText-w">
                                            <p>稱謂</p>
                                            <div class="error-text"></div>
                                        </div>
                                        <dropdown-el class="type-fullbox" d4-placeholder="請選擇您的稱謂" form-field="service"
                                            field-type="isSelect">
                                            @foreach ($genders as $key => $gender)
                                                <li>
                                                    <p bk-gender-id="{{ $key }}">{{ $gender }}</p>
                                                </li>
                                            @endforeach

                                        </dropdown-el>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-grid">
                                    <label class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>電子信箱</p>
                                            <div class="error-text"></div>
                                        </div>
                                        <div class="input-wrap">
                                            <input form-field="mail" type="text" placeholder="請填寫您的電子信箱">
                                        </div>
                                    </label>
                                </div>
                                <div class="form-grid">
                                    <label class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>聯絡電話</p>
                                            <div class="error-text"></div>
                                        </div>
                                        <div class="input-wrap">
                                            <input form-field="tel" type="text" placeholder="0912345678">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-grid">
                                    <label class="form-group textarea required">
                                        <div class="subject paragraphText-w">
                                            <p>備註</p>
                                            <div class="error-text"></div>
                                        </div>
                                        <div class="input-wrap">
                                            <textarea class="textarea-scrollbar" form-field="description" type="text" placeholder="請輸入您的訊息內容"
                                                name="description"></textarea>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="form-row password">
                                <div class="form-grid">
                                    <label class="form-group required verification">
                                        <div class="subject paragraphText-w">
                                            <p>驗證碼</p>
                                            <div class="error-text"></div>
                                        </div>
                                        <div class="input-wrap">
                                            <input type="text" placeholder="請輸入正確的驗證碼" form-field="verifyCode">
                                            <div class="inner-icon">
                                                <a class="refresh-btn bk-refresh-captcha" href="javascript:;">
                                                    {{-- <img src="./assets/img/others/pic_01.jpg" alt=""> --}}
                                                    <img class="bk-consult-captcha-img"
                                                        src="{{ Captcha::src('flat') }}" alt="">
                                                </a>
                                                <div class="icon"> <i class="icon-change"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="default-btn anchorEffect bk-prev-step" href="javascript:;" color="light-gray"
                            size="large" {{-- onclick="document.body.fesd.processSwitchStep(false)" --}}
                            data-anchor-container="modern-modal[data-modal-id=&quot;consult-modal&quot;] [data-overlayscrollbars-viewport]"
                            data-anchor-target="">
                            <div class="txt">返回上一步</div>
                        </a>
                        <!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
                        <a class="spread-btn default-btn form-submit bk-form-submit" {{-- href="product_consultSuccess.html" --}}
                            style="--hoverball: #2E2E2E" color="black" size="large">
                            <div class="txt">確認送出 </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</modern-modal>

<modern-modal data-modal-id="notice-delete" data-modal-animate="fade-up">
    <div class="icon"> <i class="icon-delete"> </i></div>
    <div class="title itemTitle-lw">移除產品</div>
    <div class="text paragraphText">是否確定要移除此產品？</div>
    <div class="btn-group">
        <div class="default-btn form-clear" data-modal-close color="light-gray" size="large">
            <div class="txt">我再想想</div>
        </div><!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
        <div class="spread-btn default-btn form-submit bk-delete-submit" data-modal-close color="black"
            style="--hoverball: #2E2E2E" size="large">
            <div class="txt">確定移除 </div>
        </div>
    </div>
</modern-modal>
<modern-modal data-modal-id="notice-deleteAll" data-modal-animate="fade-up">
    <div class="icon"> <i class="icon-delete"> </i></div>
    <div class="title itemTitle-lw">移除所有產品</div>
    <div class="text paragraphText">是否確定要移除所有產品？</div>
    <div class="btn-group">
        <div class="default-btn form-clear" data-modal-close color="light-gray" size="large">
            <div class="txt">我再想想</div>
        </div><!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
        <div class="spread-btn default-btn form-submit bk-delete-all-submit" data-modal-close color="black"
            style="--hoverball: #2E2E2E" size="large">
            <div class="txt">確定移除 </div>
        </div>
    </div>
</modern-modal>
