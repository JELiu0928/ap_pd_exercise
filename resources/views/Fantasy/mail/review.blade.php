<meta charset="utf-8" />
<style>
a,a.aapl-link,a.aapl-link:link {text-decoration: none;}
a.aapl-link:hover {text-decoration: underline}
p {margin: 0;padding: 0;}
ul {list-style: none;padding: 0;margin: 0;}
ul li {display: flex;flex-wrap: wrap;align-items: center;}
body {width: 100% !important;-webkit-text-size-adjust: none !important;font-family: Microsoft JhengHei, "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, "sans-serif" !important;font-style: normal !important;font-size: 14px !important;font-weight: 400 !important;line-height: 1.8 !important;color: #000 !important;}
#aapl-footer a {color: #000 !important}
.title-bar {background: linear-gradient(to right, #434343, #434343);margin: 0;padding: 10px 20px;width: auto;height: 100%;color: #fff;font-size: 20px;font-weight: 700;}
.title-line {display: flex;align-items: center;font-size: 20px;font-weight: 700;margin-bottom: 15px}
.title-line span {margin-left: 15px;flex: 1;height: 1px;background-color: #dbdbdb;}
.title-list li {font-size: 15px;}
.title-list li>p {margin: 5px 0}
.title-list li>.b {font-weight: 700;}
.title-list li ul {flex: 1;margin: 10px 0}
.title-list li ul li {flex: 1;justify-content: space-between;padding: 0 5px;border-bottom: 1px solid #000;}
.title-list li ul li p {text-align: left}
.title-list li ul li .index {flex-basis: 60px;flex-shrink: 0;text-align: center}
.title-list li ul li .item {flex: 1;flex-shrink: 0;}
.title-list li ul li .item span {display: block;}
.title-list li ul li .number {flex-basis: 60px;flex-shrink: 0;text-align: center}
.title-list li ul li .price {flex-basis: 100px;flex-shrink: 0;text-align: right}

.title-list li ul li:not(:first-child):not(:last-child) {
padding: 10px 5px
}

.title-list li ul li:first-child,
.title-list li ul li:last-child {
font-weight: 700;
border-top: 3px solid #000;
border-bottom: 3px solid #000;
}

.title-list li ul li:nth-last-child(2) {
border: none;
}

@media only screen and (max-width:700px) {
td[class="container"] {
padding: 0 !important;
}

td[class="content"] {
padding-left: 12px !important;
padding-right: 12px !important
}

td[class="_header_top"] {
height: 20px !important
}

td[class="_header_td"] {
padding-left: 12px !important;
padding-right: 12px !important
}

table {
width: 100% !important
}

table[class='responsive'],
table[class='responsive'] tbody,
table[class='responsive'] tr,
table[class='responsive'] td {
display: block
}

tr[class='promos'] {
max-width: 700px !important
}

table[class='promo'] {
display: block;
width: 99.8% !important;
margin: 0 auto
}

td[class='promo-container'] {
display: block !important;
width: 100% !important;
float: left !important
}

td[class='promo-spacer'] {
display: none
}

td img {
max-width: 100% !important;
height: auto !important
}

td[class='copyright'] {
-webkit-text-size-adjust: 100% !important;
}

table {
border: 0 !important;
}
}
</style>

<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" style="margin:0px auto;color: #000 !important;padding:27px 20px 40px 20px;background-color: #f5f5f5;">
    <tbody>
        <tr>
            <td width="100%">
                <table border="0" width="750" cellspacing="0" cellpadding="0" align="center" style="margin:0px auto;border:1px solid #d2d2d2">
                    <tbody>
                        <tr>
                            <td bgcolor="#ffffff" width="100%" height="40">&nbsp;</td>
                        </tr>

                        <tr>
                            <td align="right" bgcolor="#ffffff" style="padding:0px 50px">
                                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                    <tbody width="100%">
                                        <tr width="100%" style="min-width:100%">
                                            <td align="left" valign="middle" bgcolor="#ffffff" width="30%">
                                                <img src="{{ url('/assets/img/logo_243_52.png') }}" alt="" class="CToWUd">
                                            </td>
                                        </tr>

                                        <tr width="100%" colspan="2" height="10"></tr>

                                        <tr width="100%">
                                            <td align="left" valign="top" bgcolor="#ffffff" colspan="2">
                                                <p style="margin:0px;padding:10px 20px;background:linear-gradient(to right,#434343,#434343);width:auto;color:rgb(255,255,255);font-size:20px;font-weight:700">{{$data['subject']}}</p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td bgcolor="#ffffff" style="padding:0px 50px 50px">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td bgcolor="#ffffff">
                                                <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top" width="100%">
                                                                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="table-layout:fixed">
                                                                    <tbody>
                                                                        <tr width="100%">
                                                                            <td style="padding:15px 0px 0px;color:rgb(0,0,0);font-size:14px;line-height:1.6em">
                                                                                <ul style="list-style:none;padding:0px;margin:0px">
                                                                                    <li style="font-size:15px;display:flex">
                                                                                        <p style="margin:5px 0px;padding:0px;font-weight:700">申請者：</p>
                                                                                        <p style="margin:5px 0px;padding:0px">{{$data['data_name']}}</p>
                                                                                    </li>
                                                                                    <li style="font-size:15px;display:flex">
                                                                                        <p style="margin:5px 0px;padding:0px;font-weight:700">資料單元：</p>
                                                                                        <p style="margin:5px 0px;padding:0px">{{$data['data_unit']}}</p>
                                                                                    </li>
                                                                                    <li style="font-size:15px;display:flex">
                                                                                        <p style="margin:5px 0px;padding:0px;font-weight:700">資料名稱：</p>
                                                                                    </li>
																					@foreach($data['data_post'] as $val)
                                                                                    <li style="font-size:15px;display:flex;border-bottom: 1px #666 solid;">
                                                                                        <p style="margin:5px 0px;padding:0px;font-weight:700"><a href="{{$val['url']}}" target="_blank">{{$val['title']}}</a></p>
                                                                                    </li>
																					@endforeach
                                                                                </ul>
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td height="40"></td>
        </tr>

        <tr>
            <td style="text-align:center;font-size:14px;line-height:20px">
                <p style="margin:0px;padding:0px">此信件為系統自動寄發，請勿直接回覆此信件。</p>
            </td>
        </tr>
    </tbody>
</table>