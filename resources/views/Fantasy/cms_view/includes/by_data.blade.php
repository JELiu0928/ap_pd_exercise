<div class="ajax_ams ajax_temp">

  <div class="box_container">

    <!--title_section-->
    <div class="title_section">
      <div class="info"><p>Select Data</p></div>
      <div class="close_ajax_btn">
        <span class="fa fa-remove"></span>
      </div>
    </div>
    <!---->

    <!--search_section-->
    <div class="search_section" data-model="{{ $model }}">
      <div class="title_area">
        <span class="fa fa-search"></span>
        <p>SEARCH</p>
      </div>
      <div class="keyin_area">
        <input type="text" id="db_lbox_keyword" placeholder="請輸入關鍵字搜尋資料 / wddwade (  只有針對資料名稱欄位做AJAX搜尋  )">
      </div>
      <div class="clear_btn" id="db_lbox_search">
        <p>SEARCH</p>
      </div>
      <div class="clear_btn" id="db_lbox_clear">
        <p>CLEAR</p>
      </div>
    </div>
    <!---->

    <!--table_section-->
    <div class="table_section">
      <div class="container-fluid bg-white" style="width:100%;">
        <div class="table-box card card-transparent main-table no_left" data-tableID="ams_ajax_table" style="position: relative;">
          <div class="card-block db_lbox_table">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="width:20px" class="text-center">
                    <button class="btn btn-link">
                      <i class="pg-unordered_list"></i>
                    </button>
                  </th>
              
                  @foreach($table as $key => $value)
                  <th style="width:{{ $value['width'] }}">{{ $value['title'] }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach($detail as $key => $value)
                <tr class="tbody_tick">
                  <td class="v-align-middle">
                    <div class="checkbox text-center">
                      <input type="checkbox" id="{{ $value['id'] }}" class="input_number db_lbox_select_checkbox" data-title="{{ $value['show_title'] }}">
                      <label for="" class="no-padding no-margin">
                        <span></span>
                      </label>
                    </div>
                  </td>
                  @foreach ($table as $key1 => $value1)
                    @if($value1['type']=='text_img')
                      <td class="v-align-middle">
                        <div class="box text_pic">
                          <div class="head_img open_builder">
                            <img src="{{ $imageAry[ $value['image'] ] }}" alt="">
                          </div>
                          <p class="bold open_builder">{{ $value[ $value1['value'] ] }}</p>
                        </div>
                      </td>
                    @elseif($value1['type']=='select')
                      <td class="v-align-middle">
                        <div class="box text">
                          <p class="box text">{{ $value['re_title'] }}</p>
                        </div>
                      </td>
                    @elseif($value1['type']=='selectMulti')
                      <td class="v-align-middle">
                        <div class="box text">
                          <p class="box text">{{ $value['re_title'] }}</p>
                        </div>
                      </td>
                    @elseif($value1['type']=='radio_btn')
                      <td class="v-align-middle">
                        <div class="box multi">
                          <ul>
                            <li @if($value[ $value1['value'] ]==1) class="ch" @endif>
                              <p>S</p>
                            </li>
                          </ul>
                        </div>
                      </td>
                    @else
                      <td class="v-align-middle">
                        <div class="box text">
                          <p class="box text">{{ $value[ $value1['value'] ] }}</p>
                        </div>
                      </td>
                    @endif
                  @endforeach
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
      <li class="list selected"><p>YOU CAN SELECT <span class="number"></span> DATA</p></li>
      <li class="list setting db_lbox_setting"><span class="fa fa-check"></span><p>SETTING</p></li>
      <li class="list close_ajax_btn"><span class="fa fa-remove"></span><p>CANCEL</p></li>
    </ul>
    <!--control_btn-->

  </div>

</div>