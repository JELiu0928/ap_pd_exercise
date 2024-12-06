<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
                <td width="auto" align="center" valign="top" bgcolor="#fff" style="background-color:#ffffff;box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2)">
                  
                  <table width="100%" border="0" style="padding: 50px 15% 30px">
                    <tbody>
                      <tr>
                        <td>
                          
                          <table width="100%" border="0">
                            <tr>
                              <td align="center" style="padding-bottom: 20px;"><b style="font-size: 28px;font-weight: 600;letter-spacing: 1.2px">Report </b><b style="font-size:24px;">舉報表單通知</b></td>
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
                          
                          <table width="100%" style="padding: 30px 10% 15px; border-top: 2px solid #000;">
                            <tbody>
                              <tr>
                                <td>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">您與臻鼎集團的關係</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>關係：</b>{{$data['w_relationship']}}</td>
                                        <td><b>補充：</b>{{$data['w_relationship_notes']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請提供您的姓名和聯繫方式</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>姓名：</b>{{$data['w_title']}}</td>
                                        <td><b>稱謂：</b>{{$data['w_sex']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>聯繫電話：</b>{{$data['w_contact_number']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>電子信箱：</b>{{$data['w_email']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請列出本案所涉及之臻鼎集團人員</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
								  @foreach ($data["firstname"] as $key => $v)
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>名字：</b>{{$data['firstname'][$key]}}</td>
                                        <td><b>姓氏：</b>{{$data['lastname'][$key]}}</td>
                                        <td><b>職稱：</b>{{$data['jobtitle'][$key]}}</td>
                                        <td><b>部門：</b>{{$data['department'][$key]}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  @endforeach
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">您是如何得知此違規行為</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>得知管道：</b>{{$data['w_learn']}}</td>
                                        <td><b>補充：</b>{{$data['w_learn_notes']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">管理階層知道此問題嗎</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>是否知道：</b>{{$data['w_know']}}</td>
                                        <td><b>補充：</b>{{$data['w_know_notes']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請列出本案發生之地點</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>地點：</b>{{$data['w_location']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請提供具體的或事件發生的大致時間及持續狀況</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b>時間：</b>{{$data['w_time']}}</td>
                                        <td><b>年：</b>{{$data['w_year']}}</td>
                                        <td><b>月：</b>{{$data['w_month']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請指出試圖隱瞞此問題的人以及他們為隱瞞問題所採取的步驟</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td>{{$data['w_trying']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請提供關於本案的所有細節或任何相關有價值之資料</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td>{{$data['w_case']}}</td>
                                      </tr>
                                    </tbody>
                                  </table>
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><b style="color:#1d65be;">請上傳支援的報告文件或檔案</b></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;padding-bottom : 12px">
                                    <tbody>
                                      <tr>
                                        <td><a href="{{$data['filepath']}}">{{$data['filepath']}}</a></td>
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
                  
                  <table width="100%" border="0" style="padding: 40px 15% 60px; border-top: 1px solid #cccccc;">
                    <tbody>
                      <tr>
                        <td>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; text-align: center; padding-top: 30px; color: #e3304d;">
                            <tbody>
                              <tr>
                                <td><b>提醒您本信件為系統發送，請勿直接回覆，</b></td>
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