<modern-modal data-modal-id="consult-modal" data-modal-animate="fade-up">
    {{-- @dd($aaa) --}}
    <div class="close-btn" data-modal-close></div>
    <div class="modal-container">
        <div class="consult-container">
            <div class="unitTitle-block center">
                <div class="sub">
                    <p>222線上產品諮詢清單</p>
                </div>
                <div class="text">
                    <p>以下列表為加入線上諮詢清單的產品，確認無誤後可填寫聯絡人資訊，相關單位工作人員將盡快聯繫您。</p>
                </div>
            </div>
            <div class="consult-content" step-active="1">
                <!-- 步驟 1-->
                <div class="block active" step-target="1">
                    <div class="grid step-block"><span class="step">01</span>
                        <span class="itemTitle-w">確認諮詢產品</span>
                        <span class="total paragraphText-w">共計：0 項</span>
                    </div>
                    <div class="grid consult-list">
                        <p class="paragraphText-w">產品諮詢清單</p>
                        <div class="list-outer">
                            <!-- 若無加入項目, list-group 加上 .d-none, .no-consult 移除 .d-none-->
                            <div class="list-group bk-list-group">
                                @include('Front.product.consult_pd_list')
                                {{-- @foreach ($partItems as $item)
                                    <div class="list">
                                        <div class="row">
                                            <ul>
                                                <li class="paragraphText-s">
                                                    <span>產品類別 "{{ $item['id'] }}"</span>
                                                    <span>{!! $item->item['banner_title'] !!}</span>
                                                </li>
                                                <li class="paragraphText-s">
                                                    <span>產品系列</span>
                                                    <span>{!! $item->item->series['title'] !!}</span>
                                                </li>
                                                <li class="paragraphText-s">
                                                    <span>產品項目</span>
                                                    <span>{!! $item->item->series->category['banner_title'] !!}</span>
                                                </li>
                                            </ul>
                                            <div class="main">
                                                <p class="itemTitle-w">{{ $item['title'] }}</p>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-grid">
                                                    <label class="form-group textarea small">
                                                        <div class="input-wrap">
                                                            <textarea class="textarea-scrollbar" form-field="note1" type="text" placeholder="新增備註..." name="description"></textarea>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="icon delete" onclick="document.body.fesd.ajaxDelete()">
                                            <i class="icon-delete"></i>
                                        </div>
                                    </div>
                                @endforeach --}}
                                {{-- <div class="list">
                                    <div class="row">
                                        <ul>
                                            <li class="paragraphText-s">
                                                <span>產品類別</span>
                                                <span>IoT
                                                    RAM<sup>TM</sup>
                                                </span>
                                            </li>
                                            <li class="paragraphText-s">
                                                <span>產品系列</span>
                                                <span>PSRAM</span>
                                            </li>
                                            <li class="paragraphText-s">
                                                <span>產品項目</span>
                                                <span>SPI & QSPI</span>
                                            </li>
                                        </ul>
                                        <div class="main">
                                            <p class="itemTitle-w">APS1604M-3SQR</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-grid"><label class="form-group textarea small">
                                                    <div class="input-wrap">
                                                        <textarea class="textarea-scrollbar" form-field="note1" type="text" placeholder="新增備註..." name="description"></textarea>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                    <div class="icon delete" onclick="document.body.fesd.ajaxDelete()"><i
                                            class="icon-delete"></i>
                                    </div>
                                </div>
                                <div class="list">
                                    <div class="row">
                                        <ul>
                                            <li class="paragraphText-s">
                                                <span>產品類別</span>
                                                <span>IoT
                                                    RAM<sup>TM</sup>
                                                </span>
                                            </li>
                                            <li class="paragraphText-s"><span>產品系列</span><span>LPDDR</span></li>
                                            <li class="paragraphText-s"><span>產品項目</span><span>Low Voltage</span></li>
                                        </ul>
                                        <div class="main">
                                            <p class="itemTitle-w">AD225616G1</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-grid"><label class="form-group textarea small">
                                                    <div class="input-wrap">
                                                        <textarea class="textarea-scrollbar" form-field="note1" type="text" placeholder="新增備註..." name="description"></textarea>
                                                    </div>
                                                </label></div>
                                        </div>
                                    </div>
                                    <div class="icon delete" onclick="document.body.fesd.ajaxDelete()"><i
                                            class="icon-delete"></i>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="no-consult d-none">
                                <div class="icon">
                                    <i class="icon-warning"></i>
                                </div>
                                <span class="paragraphText">您尚未將任何產品加入線上諮詢清單，請先選擇產品以便進行諮詢。</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid other">
                        <div class="form-row">
                            <div class="form-grid"><label class="form-group textarea">
                                    <div class="subject">
                                        <p class="paragraphText-w">其他產品需求</p>
                                    </div>
                                    <div class="input-wrap">
                                        <textarea class="textarea-scrollbar" form-field="description" type="text" placeholder="新增備註...." name="description">
                                        </textarea>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="default-btn" href="javascript:;" color="light-gray" size="large"
                            onclick="document.body.fesd.ajaxAllDelete()">
                            <div class="txt">移除所有產品 </div>
                        </a>
                        <!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
                        <div class="spread-btn default-btn anchorEffect" color="black" size="large"
                            style="--hoverball: #2E2E2E" onclick="document.body.fesd.processSwitchStep()"
                            data-anchor-container="modern-modal[data-modal-id=&quot;consult-modal&quot;] [data-overlayscrollbars-viewport]"
                            data-anchor-target="">
                            <div class="txt">前往下一步 </div>
                        </div>
                    </div>
                </div>
                <!-- 步驟 2-->
                <div class="block" step-target="2">
                    <div class="grid step-block"><span class="step">02</span><span class="itemTitle-w">填寫聯繫資料</span>
                    </div>
                    <div class="consult-form">
                        <div class="form-wrap">
                            <div class="form-row">
                                <div class="form-grid first">
                                    <!-- 必填在 .form-group 加 .required--><!-- 錯誤在 .form-group 加 .error--><label
                                        class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>公司名稱</p>
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
                                        </div><dropdown-el class="type-fullbox" d4-placeholder="請選擇您的主要職務"
                                            form-field="service" field-type="isSelect">
                                            <li>
                                                <p>預設選項1</p>
                                            </li>
                                            <li>
                                                <p>預設選項2</p>
                                            </li>
                                            <li>
                                                <p>預設選項3</p>
                                            </li>
                                            <li>
                                                <p>預設選項4</p>
                                            </li>
                                        </dropdown-el>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-grid"><label class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>聯絡姓名</p>
                                        </div>
                                        <div class="input-wrap"><input form-field="name" type="text"
                                                placeholder="請填寫您的聯絡姓名"></div>
                                    </label></div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <div class="subject paragraphText-w">
                                            <p>稱謂</p>
                                        </div>
                                        <dropdown-el class="type-fullbox" d4-placeholder="請選擇您的稱謂" form-field="service"
                                            field-type="isSelect">
                                            <li>
                                                <p>預設選項1</p>
                                            </li>
                                            <li>
                                                <p>預設選項2</p>
                                            </li>
                                            <li>
                                                <p>預設選項3</p>
                                            </li>
                                            <li>
                                                <p>預設選項4</p>
                                            </li>
                                        </dropdown-el>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-grid"><label class="form-group required">
                                        <div class="subject paragraphText-w">
                                            <p>電子信箱</p>
                                        </div>
                                        <div class="input-wrap"><input form-field="mail" type="text"
                                                placeholder="請填寫您的電子信箱"></div>
                                    </label></div>
                                <div class="form-grid"><label class="form-group required error">
                                        <div class="subject paragraphText-w">
                                            <p>聯絡電話</p>
                                            <div class="error-text">欄位格式輸入錯誤</div>
                                        </div>
                                        <div class="input-wrap"><input form-field="tel" type="text"
                                                placeholder="0912345678"></div>
                                    </label></div>
                            </div>
                            <div class="form-row">
                                <div class="form-grid"><label class="form-group textarea required">
                                        <div class="subject paragraphText-w">
                                            <p>備註</p>
                                        </div>
                                        <div class="input-wrap">
                                            <textarea class="textarea-scrollbar" form-field="description" type="text" placeholder="請輸入您的訊息內容"
                                                name="description"></textarea>
                                        </div>
                                    </label></div>
                            </div>
                            <div class="form-row password">
                                <div class="form-grid"><label class="form-group required verification">
                                        <div class="subject paragraphText-w">
                                            <p>驗證碼</p>
                                        </div>
                                        <div class="input-wrap"><input type="text" placeholder="請輸入正確的驗證碼"
                                                form-field="verifyCode">
                                            <div class="inner-icon"><a class="refresh-btn" href="javascript:;"><img
                                                        src="./assets/img/others/pic_01.jpg" alt=""></a>
                                                <div class="icon"> <i class="icon-change"></i></div>
                                            </div>
                                        </div>
                                    </label></div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="default-btn anchorEffect" href="javascript:;" color="light-gray" size="large"
                            onclick="document.body.fesd.processSwitchStep(false)"
                            data-anchor-container="modern-modal[data-modal-id=&quot;consult-modal&quot;] [data-overlayscrollbars-viewport]"
                            data-anchor-target="">
                            <div class="txt">返回上一步</div>
                        </a>
                        <!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
                        <a class="spread-btn default-btn form-submit" href="product_consultSuccess.html"
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
    <div class="text paragraphText">是否確定要移所有產品？</div>
    <div class="btn-group">
        <div class="default-btn form-clear" data-modal-close color="light-gray" size="large">
            <div class="txt">我再想想</div>
        </div><!--***- 11.13 新增 spread-btn 的 class, 以及 style="--hoverball: #2E2E2E" 的屬性-->
        <div class="spread-btn default-btn form-submit" data-modal-close color="black" style="--hoverball: #2E2E2E"
            size="large">
            <div class="txt">確定移除 </div>
        </div>
    </div>
</modern-modal>
