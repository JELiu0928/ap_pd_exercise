<style>
    @keyframes flash {

        0%,
        30%,
        60%,
        100% {
            background-color: rgba(205, 255, 92, 0.5);
        }

        45%,
        50% {
            background-color: rgba(253, 119, 57, 0.24);
        }
    }
</style>
<li class="inventory row_style">
    <div class="position-img picture_box imageCoordinate"
        style="position: relative; width: 100%; display: grid; grid-template-columns: 1fr 180px;gap: 15px; align-items:flex-start"
        draggable="false">
        <div style="position: relative;">
            <img class="img_key" src="{{ $imgSrc }}" alt="" draggable="false">
            <div class="position-area"
                style="position: absolute;
                pointer-events: none;
                animation: flash 4s linear infinite">
            </div>
        </div>
        <div class="position-text"
            style="position: sticky;top: 150px; display: grid; grid-template-columns: 1fr 1fr 10px;grid-template-rows: repeat(4, 1fr) 30px;max-height: 300px; line-height: 25px">
            <input class="value_key" name="{{ $name }}" type="hidden" value="{{ $value }}">
            <button class="lbox_fms_open" data-key="key" data-type="img" type="button"
                style="grid-column: 1/4; background-color: #10cfbd; border-style: none; cursor: pointer;border-radius: 3px; color: white">更換圖片</button>
            <div>Top : </div>
            <div class="top">{{ $data['top'] ?? '' }}</div> %
            <div>Left : </div>
            <div class="left">{{ $data['left'] ?? '' }}</div> %
            <div>Right : </div>
            <div class="right">{{ $data['right'] ?? '' }}</div> %
            <div>Bottom : </div>
            <div class="bottom">{{ $data['bottom'] ?? '' }}</div> %
            <button class="position-button" type="button"
                style="grid-column: 1/4; background-color: #10cfbd; border-style: none; cursor: pointer;border-radius: 3px; color: white">複製座標</button>
            <div class="tips" style="grid-column: 1/4;">
                <span class="title">TIPS</span>
                <p>請利用拖曳選取範圍，<br>點擊複製座標後貼至對應欄位。</p>
            </div>
        </div>
    </div>
</li>
