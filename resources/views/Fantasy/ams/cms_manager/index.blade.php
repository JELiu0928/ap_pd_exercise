@extends('Fantasy.template')
@section('bodySetting', 'uiv2 ams_theme')
@section('css')
    <link type="text/css" href="/vender/assets/css/ams_style.css" rel="stylesheet">
@stop
@section('css_back')
@stop
@section('content')
    <!-- 左邊滑動的 sidebar -->
    @include('Fantasy.includes.sidebar')
    <!-- 左邊滑動的 sidebar -->
    <!-- 中間主區塊 -->
    <div class="mainBody page-container extract-block">
        <!-- 最上面的 header bar -->
        @include('Fantasy.includes.header')
        <!-- 最上面的 header bar -->
        <div class="page-content-wrapper mainContent full-height">
            <div class="content full-height">
                <!-- 左邊 SECONDARY SIDEBAR MENU-->
                <nav class="content-sidebar">
                    <div class="sidebar-menu">
                        @include('Fantasy.ams.includes.sidebar')
                    </div>
                </nav>
                <!-- 左邊 SECONDARY SIDEBAR MENU -->
                <div class="inner-content" style="">
                    <!-- 上面區塊 (佈告欄)-->
                    <div class="jumbotron">
                        <div class="container-fluid">
                            <div class="inner">
                                <div class="inner-left">
                                    <div class="switch-menu">
                                        <span class="bar"></span>
                                        <span class="bar"></span>
                                        <span class="bar"></span>
                                    </div>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ url('Fantasy/Ams') }}">AMS Overview 資訊總覽</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">CMS Template 權限管理</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="total">
                                    <p>
                                        <span class="text">Total Data</span>
                                        <span class="num">{{ count($data) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 上面區塊 -->

                    <!-- 下面列表 -->
                    <div class="content-scrollbox" style="position: relative;">
                        <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table">
                            <div class="content-head cms-index_table" data-edit="1" data-delete="1" data-create="1"
                                data-model="" data-page="1" data-pn="1" data-auth="0"
                                data-pagetitle="CMS Template 權限管理">
                                <h1>CMS Template 權限管理</h1>
                                <div class="content-nav">
                                    <div class="navleft">
                                        <div class="btn-item">
                                            <a class="create_ams_wrapper" data-type="cms-manager" data-id="0"
                                                href="javascript:void(0)">
                                                <span class="icon-add"></span>
                                                <span class="text">ADD DATA 新增</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content-body">
                                <div class="datatable">
                                    <table class="tables">
                                        <thead style="border-bottom: 1px solid #000;">
                                            <tr>
                                                <th class="w_TableMaintitle" style="padding: 3px 20px 0 20px;">
                                                    <div class="fake-thead fake-thead-ams">
                                                        <div class="fake-th first">
                                                        </div>
                                                    </div>
                                                    <div class="fake-th ">
                                                        <span class="" data-column="account">帳號名稱</span>
                                                    </div>
                                                </th>
                                                <th class="w_Category w180">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="name">分館</span>
                                                    </div>
                                                </th>
                                                <th class="w_Category w180">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="name">語系</span>
                                                    </div>
                                                </th>
                                                <th class="text-center w_Preview">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="is_active">狀態</span>
                                                    </div>
                                                </th>
                                                <th class="w_Update">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="updated_at">最後異動時間</span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="ams_tbody" data-type="cms-manager">
                                            @foreach ($data as $key => $row)
                                                <tr>
                                                    <td class="w_TableMaintitle edit_ams_wrapper" data-type="cms-manager"
                                                        data-id="{{ $row['id'] }}">
                                                        <div class="tableMaintitle open_builder">
                                                            <div class="title-img rwdhide">
                                                                @if (!empty($row['UsersData']['_photo_image']))
                                                                    <img
                                                                        src="{{ $row['UsersData']['_photo_image']['real_route'] }}">
                                                                @endif
                                                            </div>
                                                            <span
                                                                class="title-name open_builder">{{ $row['UsersData']['name'] }}</span>
                                                            @if (!empty($row['UsersData']['mail']))
                                                                <div class="tool">
                                                                    <a href="mailto:{{ $row['UsersData']['mail'] }}"><span
                                                                            class="fa fa-envelope open_builder"></span></a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class=" w_Category edit_ams_wrapper" data-type="cms-manager"
                                                        data-id="{{ $row['id'] }}">
                                                        <div class="tableContent">
                                                            {{ collect($branch_unit_options)->where('key', $row['branch_unit_id'])->first()['branch'] ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td class=" w_Category edit_ams_wrapper" data-type="cms-manager"
                                                        data-id="{{ $row['id'] }}">
                                                        <div class="tableContent">
                                                            {{ collect($branch_unit_options)->where('key', $row['branch_unit_id'])->first()['locale'] ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center w_Preview edit_ams_wrapper"
                                                        data-type="cms-manager" data-id="{{ $row['id'] }}">
                                                        <div class="tableContent">
                                                            {{ $row['is_active'] == 1 ? '啟用' : '未啟用' }}</div>
                                                    </td>
                                                    <td class="w_Update open_builder" data-type="cms-manager"
                                                        data-id="{{ $row['id'] }}">
                                                        <div class="tableContent">{{ $row['updated_at'] }}</div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <article class="hiddenArea ams_hiddenArea amsDetailAjaxArea ">
        <div class="hiddenArea_frame ajaxItem ams">
            <!--AMS 編輯管理權限-->
            <form class="ajaxContainer" id="ams_edit_form" action="">
            </form>
        </div>
    </article>
@section('script')
    <script>
        $(document).on('click', "li.option.single_select_fantasy", function() {
            $(this).closest('ul').children("input[type='hidden']").trigger('change');
        });

        $('body').on('change', "[name='amsData[branch_unit_id]']", function() {
            AutoLoadAms();
        });

        $('body').on('change', '[name="amsData[user_id]"]', function() {
            AutoLoadAms();
        });

        function AutoLoadAms() {
            if ($("[name='amsData[branch_unit_id]']").val() != "" && $("[name='amsData[branch_unit_id]']").val() != null) {
                temp_loading();
                $(".hide_auth").show();
                $(".ams_ios_switch").removeClass('lock');
                $.ajax({
                    url: "{{ url('Fantasy/Ajax/cms-manager') }}/" + $("[name='amsData[branch_unit_id]']").val(),
                    type: 'post',
                    data: {
                        'set_id': $('[name="amsData[user_id]"]').val(),
                        '_token': $("input._token[type='hidden'][name='_token']").val()
                    },
                    success: function(result) {
                        if(!result){
                            temp_loading();
                            return false;
                        }
                        $(".review-action").hide();
                        $(".ajax_html").html(result[0].html);

                        $("input[type='hidden'][name='_lang']").val(result[0].locale);

                        //關掉不可管理單元
                        $.each(result[0].unit_set, function(k, v) {
                            if (v == 0) {
                                $(".auth_" + k).find('.ams_ios_switch').each(function() {
                                    $(this).addClass('lock');
                                    $(this).removeClass('on');
                                    $(this).find('input.check_ams_rabio').attr('value', '0');
                                });
                                $(".hide_auth_" + k).hide();
                            }
                        });
                        //若需要審核
                        if (result[0].need_review) {
                            $(".review-action").show();
                        }
                        //啟用狀態
                        if (result[0].is_active) {
                            $('[name="amsData[is_active]"]').val(1).parent().addClass('on').off();
                        } else {
                            $('[name="amsData[is_active]"]').val(0).parent().removeClass('on').off();
                        }

                        //切換ID
                        if (result[0].id != null){
                            $('input.supportAmsId_Input').val(result[0].id);
                        }



                        quill_select();
                        amsBasicFunction.close_wrapper();
                        amsBasicFunction.open_wrapper();
                        $('.ams_ios_switch').radioAmsSwitch();
                        $('.updated_ams_edit_btn').updateAmsData();
                        $('.delete_ams_information').deleteAmsData();
                        $('.open_member_list').openAmsMember();
                        components.select2($(".____select2"));

                        setTimeout(function() {
                            $('.multi_select_has_auth .inner').attr('style', 'width:100%');
                            $('.multi_select_has_auth div.title').attr('style', 'width:0%');
                        });
                        temp_loading();
                    },
                    error: function(result) {
                        alert('頁面發生錯誤');
                        temp_loading();
                    },
                })
            } else {
                $('.ams_ios_switch').each(function() {
                    $(this).addClass('lock');
                    $(this).removeClass('on');
                    $(this).find('input.check_ams_rabio').attr('value', '0');
                });
                $('.multi_select_has_auth select').html('').select2({
                    data: {
                        id: null,
                        text: null
                    }
                });
                $(".hide_auth").hide();
            }
        }
    </script>
@stop
@section('script_back')
    <script type="text/javascript" src="/vender/backend/js/ams/ams.js"></script>
    <script type="text/javascript" src="/vender/backend/js/cms/cms_unit.js"></script>
@stop
@stop
