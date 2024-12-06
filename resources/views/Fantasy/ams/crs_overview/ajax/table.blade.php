                    @foreach($data as $key => $row)
                    <tr class="tbody_tick">
                        <td class="v-align-middle">
                            <div class="checkbox text-center">
                                <input type="checkbox" id="" class="input_number">
                                <label for="" class="no-padding no-margin">
                                    <span></span>
                                </label>
                            </div>
                        </td>
                        <td class="v-align-middle tool_ctrl edit_ams_wrapper" data-type="crs-overview"
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
                        <td class="v-align-middle edit_ams_wrapper" data-type="crs-overview" data-id="{{ $row['id'] }}">
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
                    @endforeach