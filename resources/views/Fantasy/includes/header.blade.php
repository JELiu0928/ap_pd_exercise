<div class="header">
    <div class="blockCover">
        <div class="blockLogo">
            <p>{{ $unitTitle }}</p>
        </div>
        @if(!empty($unitSubTitle))
            <div class="blockName">
                <p>{{ $unitSubTitle }}</p>
            </div>
        @endif
    </div>
    <div class="inforCover">
        <div class="projectName">{{ Config::get('app.name') }}</div>
        @if(isset($locale))
            <a href="{{ BaseFunction::preview_url('') }}" target="is_blank" class="previewButton" data-toggle="tooltip" data-placement="bottom" data-original-title="前往預覽未正式發佈的網站內容">PREVIEW</a>
        @endif
        <div class="projectName">
            <span class="">{{ Session::get('fantasy_user')['name'] }}</span>
        </div>
        @if(isset($ReviewNotifyCount) && $ReviewNotifyCount > 0)
            <div class="userName">
                <span class=""><a href="//{{ request()->getHost().'/Fantasy/Review' }}">未審核({{ $ReviewNotifyCount }})</a></span>
            </div>
        @endif
        @if(isset($SelfReviewNotifyCount) && $SelfReviewNotifyCount > 0)
            <div class="userName">
                <span class=""><a href="//{{ request()->getHost().'/Fantasy/Review/track' }}">追蹤審核({{ $SelfReviewNotifyCount }})</a></span>
            </div>
        @endif
        <div class="userPhoto dropdown">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline">
                    <?php
                        $photo = (!empty($FantasyUser)) ? BaseFunction::RealFiles($FantasyUser['photo_image']) : '';
                        $realphoto = !empty($photo) ? $photo : asset('/vender/assets/img/profiles/wdd.jpg');
                    ?>
                    @if(!empty($realphoto))
                        <img src="{{ $realphoto }}" alt="" data-src="{{ $realphoto }}" data-src-retina="{{ $realphoto }}" width="32" height="32">
                    @else
                        <span class="fa fa-user-circle-o" aria-hidden="true"></span>
                    @endif
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                {{-- <a href="javascript:;" class="dropdown-item">
                <i class="pg-settings_small"></i> Settings</a>
                <a href="javascript:;" class="dropdown-item">
                <i class="pg-outdent"></i> Feedback</a>
                <a href="javascript:;" class="dropdown-item">
                <i class="pg-signals"></i> Help</a> --}}
                @foreach($FantasyUsersList as $val)
                    <a href="{{ url('/auth/login/'.$val['id']) }}" class="dropdown-item"><i class="pg-signals"></i> {{ $val['name'] }}</a>
                @endforeach
                <div class="clearfix bg-master-lighter dropdown-item changePWD">修改密碼
                    <span class="pull-right">
                        <i class="fa fa-pencil-square-o"></i>
                    </span>
                </div>
                <a href="javascript:basic_logout();" class="clearfix bg-master-lighter dropdown-item">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right">
                        <i class="pg-power"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
