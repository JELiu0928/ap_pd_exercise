<div class="backEnd_quill">
    <div class="detailEditor">
        <div class="editorBody">
            <div class="editorHeader">
                <div class="info">
                    <div class="title">
                        <p>{{ $area_title }}</p>
                    </div>
                    <div class="area">
                        <h3>{{ $File['title'].((!empty($File['type']))?'.'.$File['type']:'') }}</h3>
                        <div class="control">
                            <ul class="btnGroup">
                            @if($file_type['title']=='資料夾')
                                <li class="check open_folder_edit">
                            @else
                                <li class="check open_file_edit">
                            @endif
                                <a href="javascript:void(0)">
                                    <span class="fa fa-pencil"></span>
                                </a>
                            </li>
                            <li class="remove">
                                <a href="javascript:;" class="close_btn">
                                    <span class="fa fa-remove"></span>
                                </a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="editorContent">
                <ul class="box_block_frame">
                    <li class="inventory fileInformation file_box">
                        <div class="file_frame ">
                            <div class="file_frame_info">
                                <div class="img_box">
                                <img src="{{ ($file_type['title']!='影像')? $file_type['img']:$File['real_route'] }}" alt="">
                                </div>
                            </div>
                            <input name="for_edit_id" type="hidden" value="{{$File['id']}}">
                            @if(!empty($folder_type))
                            <input name="for_edit_folder_level" type="hidden" value="{{$folder_type}}">
                            @endif
                            <div class="toolBtn">
                                @if($area_detail!='資料夾')
                                    @if($file_type['title']=='影像')
                                    <span class="icon fa fa-eye  open_img_box"  data-src="{{ $File['real_route'] }}" ></span>
                                    @endif
                                    <span class="icon pg-download file_fantasy_download" data-src="{{ $File['real_route'] }}" data-title="{{ $File['title'].".".$File['type'] }}"></span>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="inventory">
                        <p class="title bold">01. 擁有者{{-- , 權限 --}}</p>
                        <p class="info"><span class="bold">{{ $owner['name']??'N/A' }} </span>
                        @if(!empty($share_user))
                            <span class="icon fa fa-lock"></span> 只授權
                            @foreach($share_user as $key => $row)
                            {{$row}}@if(!$loop->last) , @endif
                            @endforeach
                            可以編輯
                        @else
                            ,所有管理者皆可檢視</p>
                        @endif
                    </li>
                    <li class="inventory">
                        <p class="title bold">02. {{ $area_detail }}名稱</p>
                        <p class="info">{{ $File['title'].((!empty($File['type']))?'.'.$File['type']:'') }}</p>
                    </li>
                    <li class="inventory">
                        <p class="title bold">03. {{ $area_detail }}類型,格式</p>
                        <p class="info">{{ $file_type['title'].', '.$File['type'] }}</p>
                    </li>
                    <li class="inventory">
                        <p class="title bold">04. {{ $area_detail }}大小,容量</p>
                        <p class="info"><span class="bold">@if($file_type['title']=='影像') {{ $File['resolution'] }} ,@endif</span> <span class="bold">{{ $File['_this_size'] }}</span>, 資料夾內有 <span class="bold">{{ $count_file }}</span> 個檔案</p>
                    </li>
                    <li class="inventory">
                        <p class="title bold">05. {{ $area_detail }}目錄位置</p>
                        <p class="info">{{ $file_path }}</p>
                    </li>
                    @if($area_detail!='資料夾')
                    <li class="inventory">
                        <p class="title bold">06. {{ $area_detail }}路徑</p>
                        <p class="info">{{ (!empty($File['real_route'])) ? $File['real_route'] : $file_path }} {{-- / <span class="icon fa fa-lock"></span>新後台v1.1無檔案權限功能 只授權 Quill, Boris 可以檢視 --}}</p>
                    </li>
                    @endif
                    {{-- 新後台v1.1無檔案修改功能--}}
                    <li class="inventory">
                        <p class="title bold">07. 最後異動時間</p>
                        <p class="info">
                        @if(!empty($last_edit_user))
                        <span class="bold">{{$last_edit_user['name']??'N/A'}}</span>, 在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($File['updated_at'])) }} 修改過</p>
                        @else
                            <span class="bold">{{$owner['name']??'N/A'}}</span>, 在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($File['updated_at'])) }} 修改過</p>
                        @endif
                    </li>
                    <li class="inventory">
                        <p class="title bold">08. {{ $area_detail }}建立日期</p>
                        <p class="info"><span class="bold">{{ $owner['name']??'N/A' }}</span>, 在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($File['created_at'])) }} 建立</p>
                    </li>
                    {{-- 新後台v1.1無檔案修改功能--}}
                    <li class="inventory">
                        <p class="title bold">09. 備註與說明</p>
                        <p class="info">{{$File['note']}}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--區塊功能按鈕-->
    <div class="hiddenArea_frame_controlBtn">
        <ul class="btnGroup">
            <li class="check @if($file_type['title']=='資料夾') open_folder_edit @else open_file_edit @endif">
                <a href="javascript:void(0)" >
                    <span class="fa fa-pencil"></span>
                    <p>EDIT</p>
                </a>
            </li>
            <li class="remove">
                <a href="javascript:void(0)" class="close_btn">
                    <span class="fa fa-remove"></span>
                    <p>CANCEL</p>
                </a>
            </li>
        </ul>
    </div>
</div>
