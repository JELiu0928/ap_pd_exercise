                    {{-- @foreach($data as $key => $row)
                    <tr class="tbody_tick">
                        <td class="v-align-middle">
                            <div class="checkbox text-center">
                                <input type="checkbox" id="" class="input_number">
                                <label for="" class="no-padding no-margin">
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        <td class="v-align-middle tool_ctrl edit_ams_wrapper" data-type="crs-template"
                            data-id="{{ $row['id'] }}">
                            <div class="box text_pic">
                                <div class="head_img open_builder">
                                    @if(isset($fileInformationArray[ $row['users_data']['photo_image'] ]) AND
                                    !empty($fileInformationArray[ $row['users_data']['photo_image'] ]))
                                    <img src="{{ $fileInformationArray[ $row['users_data']['photo_image'] ]['real_route'] }}"
                                        alt="">
                                    @endif
                                </div>
                                <p class="bold open_builder">{{ $row['users_data']['name'] }}</p>
                                @if(!empty($row['users_data']['mail']))
                                <div class="tool">
                                    <a href="mailto:{{$row['users_data']['mail']}}"><span
                                            class="fa fa-envelope open_builder"></span></a>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="v-align-middle edit_ams_wrapper" data-type="crs-template" data-id="{{ $row['id'] }}">
                            <div class="box text">
                                @if(!empty($row['branch_id']))
                                @foreach($branch_unit_options as $key2 => $row2)
                                @if($row2['key'] == $row['branch_id'])
                                <p>{{$row2['title']}}</p>
                                @endif
                                @endforeach
                                @else
                                <p>-</p>
                                @endif
                            </div>
                        </td>
                        <td class="v-align-middle">
                            <div class="box multi">
                                <ul>
                                    <li class="{{ ($row['is_active'] == 1) ? 'ch' : '' }} rabioAmsBtn"
                                        data-id="{{$row['id']}}" data-model="CmsRole" data-column="is_active">
                                        <p>P</p>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="v-align-middle">
                            <div class="box text">
                                <p>{{ $row['updated_at'] }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforeach --}}
                                            @foreach($data as $key => $row)
                                            <tr>
                                                <td class="text-center w_Check">
                                                    <div class="tableContent">
                                                        <label class="select-item">
                                                            <input type="checkbox" data-id="1">
                                                            <span class="check-circle icon-check"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="w_TableMaintitle edit_ams_wrapper" data-type="crs-template" data-id="{{ $row['id'] }}">
                                                    <div class="tableMaintitle open_builder">
                                                        <div class="title-img rwdhide">
                                                            @if(isset($fileInformationArray[ $row['users_data']['photo_image']]) AND !empty($fileInformationArray[$row['users_data']['photo_image'] ]))
                                                            <img src="{{ $fileInformationArray[ $row['users_data']['photo_image'] ]['real_route'] }}"alt="">
                                                            @endif
                                                        </div>
                                                        <span class="title-name open_builder">{{ $row['users_data']['name'] }}</span>
                                                        @if(!empty($row['users_data']['mail']))
                                                        <div class="tool">
                                                            <a href="mailto:{{$row['users_data']['mail']}}"><span
                                                                    class="fa fa-envelope open_builder"></span></a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class=" w_Category edit_ams_wrapper" data-type="crs-template" data-id="{{ $row['id'] }}">
                                                    <div class="tableContent">
                                                        @if(!empty($row['branch_id']))
                                                            @foreach($branch_unit_options as $key2 => $row2)
                                                                @if($row2['key'] == $row['branch_id'])
                                                                    {{$row2['title']}}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </td>
                                                {{-- <td class=" w_Category edit_ams_wrapper" data-type="crs-template" data-id="{{ $row['id'] }}">
                                                    <div class="tableContent">{{ !empty($row['mail']) ? $row['mail'] : ''}}</div>
                                                </td> --}}
                                                <td class="text-center w_Preview edit_ams_wrapper" data-type="crs-template" data-id="{{ $row['id'] }}">
                                                    <div class="tableContent">{{ ($row['is_active'] == 1) ? '啟用' : '未啟用' }}</div>
                                                </td>
                                                <td class="w_Update open_builder" data-type="crs-template" data-id="{{ $row['id'] }}">
                                                    <div class="tableContent">{{ $row['updated_at'] }}</div>
                                                </td>
                                            </tr>
                                            @endforeach