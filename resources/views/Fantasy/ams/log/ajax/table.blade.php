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
                        <td class="w_TableMaintitle edit_ams_wrapper" data-type="log" data-id="{{ $row['id'] }}">
                            <div class="tableMaintitle open_builder">
                                <span class="title-name open_builder">{{ $row['create_time'] }}</span>
                            </div>
                        </td>
                        <td class="w_TableMaintitle edit_ams_wrapper" data-type="log" data-id="{{ $row['id'] }}">
                            <div class="tableMaintitle open_builder">
                                <span class="title-name open_builder">{{ $row['users_data']['name'] }}</span>
                            </div>
                        </td>
                        <td class="w_TableMaintitle edit_ams_wrapper" data-type="log" data-id="{{ $row['id'] }}">
                            <div class="tableMaintitle open_builder">
                                @php
                                    $tableName = json_decode(json_encode(\DB::select('SHOW TABLE STATUS WHERE Name=\''.$row['table_name'].'\'')), true)[0]['Comment'];
                                    $tableName = (!empty($tableName)) ? $tableName : $row['table_name'];
                                @endphp 
                                <span class="title-name open_builder">{{ $tableName }}</span>
                            </div>
                        </td>
                        <td class="w_TableMaintitle edit_ams_wrapper" data-type="log" data-id="{{ $row['id'] }}">
                            <div class="tableMaintitle open_builder">
                                <span class="title-name open_builder">{{ $row['log_type'] }}</span>
                            </div>
                        </td> 
                        <td class="w_TableMaintitle edit_ams_wrapper" data-type="log" data-id="{{ $row['id'] }}">
                            <div class="tableMaintitle open_builder">
                                <span class="title-name open_builder">{{ $row['ip'] }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach