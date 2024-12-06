<div class="change_pwd_modal wddChangePWDMain">
    <article class="changePwd_sec">
        <div class="title">
            <div class="fantasylogo">
                密碼變更<span class="fantasyver"></span>
            </div>
        </div>
        <h2>請輸入新密碼</h2>
        <div id="accountForm">
            <div class="frame">
                <div class="input_box">
                    <input type="password" placeholder="請輸入密碼" class="changePWDInput" name="password">
                </div>
                <div class="input_box">
                    <input type="password" placeholder="請再次輸入密碼" class="changePWDInput2" name="password2">
                </div>
            </div>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        </div>
        <div class="changePWDErrorMsg" style="color: red;display:none">
                請確認密碼是否輸入相同
        </div>
        <br>
        <button class="changePWd_btn changePWDBtn" type="submit">修改密碼</button>
        {{-- <div class="forwho">{{config('cms.ProjectName')}}</br>All Rights Reserved.<span>Fantasy By WDD</span></div> --}}
    </article>
</div>
