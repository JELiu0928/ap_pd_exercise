    <input id="productColumns" type="hidden" value="{{ $formSpecTitlesJson }}">
    <input id="productData" type="hidden" value="{{ $productPartsJson }}">
    <input id="itemId" type="hidden" value="{{ $itemId }}">
    <header>
        <div class="logo">
            <img src="{{ asset('vender/assets/img/Fantasy-icon.svg') }}" alt="">
        </div>
        <div class="text">Fantasy 產品規格表</div>
        <div class="close-btn modal-destroy">
            <div class="icon"></div>
        </div>
        {{-- <p> {{ $productCategories->simple_title }}</p> --}}
    </header>
    <div class="container">
        <p class="tips">雙擊兩下表格內容可以進行編輯。若是希望在特定欄位增加一列內容請以shift+Enter的方式換行輸入，前台將會以此作為判斷標準。</p>
        {{-- <p class="tips">下方的表頭點擊右邊的箭頭可進行收合；如有勾選項目，長按 shift 後點擊勾選頭尾按鈕，可快速進行選取</p> --}}
        {{-- <div id="productSpecificationGrid" class="ag-theme-alpine" style="height: calc(92vh - 210px);"></div> --}}
        {{-- <div id="productSpecificationGrid" style="height: 400px; width: 100%;"></div> --}}
        <div id="productSpecificationGrid" class="ag-theme-alpine" style="height: 400px; width: 100%;"></div>
        <div class="button-wrap">
            <div class="button gray modal-destroy">關閉</div>
            <div class="button green productAggridSendBtn">確定送出</div>
        </div>
    </div>
    {{-- <button onclick="saveFilterModel();">測試按鈕</button> --}}
    {{-- <button onclick="showAll();">顯示所有產品</button> --}}
