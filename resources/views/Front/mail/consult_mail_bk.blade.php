<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
</head>

<body style="margin:0;padding:0;font-family: 'Poppins', sans-serif, Microsoft JhengHei">
    <table bgcolor="#efefef" cellpadding="0" cellspacing="0" width="100%" style="padding:88px 10px">
        <tbody>
            <tr>
                <td width="900" style="max-width:900px">
                    <table width="900" border="0" cellspacing="0" cellpadding="0" align="center" valign="top">
                        <tbody>
                            <tr>
                                <td width="auto" align="center" valign="top" bgcolor="#fff"
                                    style="background-color:#ffffff;box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2)">
                                    <table width="100%" border="0" cellpadding="30">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="middle" width="100%"
                                                    style="border-bottom: 1px solid #cccccc;">
                                                    <a href="javascript:;">
                                                        <img src="{{ Config::get('app.url') . '/maillogo.png' }}"
                                                            alt="">
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" border="0" style="padding: 50px 15% 30px">
                                        <tbody>
                                            <tr>
                                                <td>

                                                    <table width="100%" border="0">
                                                        <tr>
                                                            <td align="center" style="padding-bottom: 20px;"><b
                                                                    style="font-size: 28px;font-weight: 600;letter-spacing: 1.2px">Consult
                                                                </b><b style="font-size:24px;">產品諮詢表單通知</b></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table width="100%" border="0" style="padding: 0px 15% 15px">
                                        <tbody>
                                            <tr>
                                                <td>

                                                    <table width="100%"
                                                        style="padding: 30px 10% 15px; border-top: 2px solid #000;">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>公司名稱：</b>{{ $form['companyName'] }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>主要職務：</b>{{ $form['job'] ? $form['job'] : '未填寫' }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>聯絡姓名：</b>{{ $form['name'] }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>稱謂：</b>{{ $form['service'] ? $form['service'] : '未填寫' }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>電子信箱：</b>{{ $form['mail'] }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>聯絡電話：</b>{{ $form['tel'] }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>備註：</b>{!! @nl2br($form['description'] ? $form['description'] : '未填寫') !!}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>諮詢產品：</b><br />
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            @php
                                                                                $count = count($partItem);
                                                                            @endphp
                                                                            @foreach ($partItem as $key => $item)
                                                                                @if ($count != 0)
                                                                                    <tr>
                                                                                        <td>
                                                                                            名稱：{!! $item['part_title'] ?? '' !!}
                                                                                            <br />
                                                                                            <div>
                                                                                                備註：{!! $item['description'] ? $item['description'] : '未填寫' !!}
                                                                                            </div><br />
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                            @if ($count == 0)
                                                                                <tr>
                                                                                    <td>
                                                                                        未選擇產品
                                                                                    </td>
                                                                                </tr>
                                                                            @endif

                                                                            {{-- @foreach ($partList as $key => $productItem)
                                                                                @if ($key != $cnt)
                                                                                    <tr>
                                                                                        <td>
                                                                                            名稱：{!! $productItem->title ?? '' !!}
                                                                                            <br />
                                                                                            <div>
                                                                                                備註：{!! $productItem->part_note ? $productItem->part_note : '未填寫' !!}
                                                                                            </div><br />
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                @if ($key == $cnt)
                                                                                    <tr>
                                                                                        <td>
                                                                                            名稱：{!! $productItem->title ?? '' !!}
                                                                                            <br />
                                                                                            <div>
                                                                                                備註：{!! $productItem->part_note ? $productItem->part_note : '未填寫' !!}
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach --}}
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" border="0" cellpadding="0"
                                                                        cellspacing="0"
                                                                        style="font-size: 14px;padding-bottom : 12px">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><b>其他需求：</b>{!! @nl2br($form['other_require'] ? $form['other_require'] : '未填寫') !!}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table width="100%" border="0"
                                        style="padding: 40px 15% 60px; border-top: 1px solid #cccccc;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellpadding="0"
                                                        cellspacing="0"
                                                        style="font-size: 14px; text-align: center; padding-top: 30px; color: #e3304d;">
                                                        <tbody>
                                                            <tr>
                                                                <td><b>提醒您本信件為系統發送，請勿直接回覆。</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
