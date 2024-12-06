<div class="ajax_ams ajax_temp">
  <div class="box_container">
    <!--title_section-->
    <div class="title_section">
      <div class="info">
        <p>Select Data</p>
      </div>
      <div class="close_ajax_btn member_lbox_cancel">
        <span class="fa fa-remove"></span>
      </div>
    </div>
    <!---->
    <!--search_section-->
    <div class="search_section" style="display:none;">
      <div class="title_area">
        <span class="fa fa-search"></span>
        <p>SEARCH</p>
      </div>
      <div class="keyin_area">
        <input type="text" placeholder="請輸入關鍵字搜尋資料 / wddwade (  只有針對資料名稱欄位做AJAX搜尋  )">
      </div>
      <div class="clear_btn">
        <p>CLEAR</p>
      </div>
    </div>
    <!---->
    <!--table_section-->
    <div class="table_section">
      <div class="container-fluid bg-white" style="width:100%;">
        <div class="table-box card card-transparent main-table no_left" data-tableID="ams_ajax_table" style="position: relative;">
          <div class="card-block">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="width:20px" class="text-center">
                    <button class="btn btn-link">
                      <i class="pg-unordered_list"></i>
                    </button>
                  </th>
                  <th style="width:35%">帳號名稱</th>
                  <th style="width:10%">姓名</th>
                  <th style="width:14%">電子郵件</th>
                  {{-- <th style="width:9%">狀態</th> --}}
                  <th style="width:20%">最後異動日期</th>
                  <th style="width:20%">帳號建立日期</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $row)
                <tr class="tbody_tick">
                  <td class="v-align-middle">
                    <div class="checkbox text-center">
                      <input type="checkbox" id="" class="input_number ams-member-checkbox" data-json="{{ $row['json_data'] }}">
                      <label for="" class="no-padding no-margin">
                        <span></span>
                      </label>
                    </div>
                  </td>
                  <td class="v-align-middle">
                    <div class="box text_pic">
                      <div class="head_img open_builder">
                        @if(!empty($row['_photo_image']))
                        <img src="{{$row['_photo_image']['real_route']}}">
                        @endif
                      </div>
                      <p class="bold open_builder">{{$row['account']}}</p>
                    </div>
                  </td>
                  <td class="v-align-middle">
                    <div class="box text">
                      <p>{{$row['name']}}</p>
                    </div>
                  </td>
                  <td class="v-align-middle">
                    <div class="box text">
                      <p>{{$row['mail']}}</p>
                    </div>
                  </td>
                  {{--                     <td class="v-align-middle">
                      <div class="box multi">
                        <ul>
                          <li>
                            <p>P</p>
                          </li>
                        </ul>
                      </div>
                    </td> --}}
                  <td class="v-align-middle">
                    <div class="box text">
                      <p>{{$row['updated_at']}}</p>
                    </div>
                  </td>
                  <td class="v-align-middle">
                    <div class="box text">
                      <p>{{$row['created_at']}}</p>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!---->
    <!--control_btn-->
    <ul class="ajax_control_btn">
      <li class="list selected">
        <p>YOU CAN SELECT <span class="number">1</span> DATA</p>
      </li>
      <li class="list setting member_lbox_setting" data-key="{{ $key_pp }}"><span class="fa fa-check"></span>
        <p>SETTING</p>
      </li>
      <li class="list close_ajax_btn member_lbox_cancel"><span class="fa fa-remove"></span>
        <p>CANCEL</p>
      </li>
    </ul>
    <!--control_btn-->
  </div>
</div>