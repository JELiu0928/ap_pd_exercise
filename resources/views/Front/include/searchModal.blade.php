<modern-modal data-modal-id="search-modal" data-modal-animate="fade-up">
    <div class="close-btn" data-modal-close></div>
    <div class="container">
        <div class="unitTitle-block center">
            <div class="title">Search 搜尋</div>
        </div>
        <div class="search-input">
            <div class="input-outer">
                <div class="input-clear"></div>
                <input class="paragraphText-w searchInput" id="searchInput" type="text"
                    placeholder="請輸入關鍵字，或點擊下方的推薦關鍵字 " />
            </div>
            <a class="icon input-search" href="./search_result.html">
                <div class="spread-btn tag categoryBtn"><i class="icon-search"></i></div>
            </a>
        </div>
        <!-- 搜尋標籤有開給客戶新增減少--><!-- 若無上搜尋標籤 要將 .search-keyword 整區塊移除-->
        <div class="common-category search-keyword">
            <div class="cate-outer">
                <!-- m4-status="" 預設 active 選項及出現的內容--><multipurpose-nav m4-type="collapse"
                    m4-option='{"drag":{"selected":true},"collapse":{"selected":true,"placeholder":"SELECT"}}'
                    m4-status="">
                    <li class="item" data-option="1">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">IoT RAM<sup>TW</sup></div>
                    </li>
                    <li class="item" data-option="2">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">S-SiCap<sup>TW</sup></div>
                    </li>
                    <li class="item" data-option="3">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">VHM<sup>TW</sup></div>
                    </li>
                    <li class="item" data-option="4">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">可穿戴式裝置</div>
                    </li>
                    <li class="item" data-option="5">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">智慧家庭</div>
                    </li>
                    <li class="item" data-option="6">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">S-SiCap 中介層 IP</div>
                    </li>
                    <li class="item" data-option="7">
                        <div class="spread-btn paragraphText" style="--hoverball: #2e2e2e">test</div>
                    </li>
                </multipurpose-nav>
            </div>
        </div>
    </div>
</modern-modal>
