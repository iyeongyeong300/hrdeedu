<?php

header("content-type:text/html; charset=utf-8");

function hrdtalk($type, $phone_number, $vars, $template_code) {

    global $connect;

    if(empty($phone_number)) {
           return "N1";
    }

    if(empty($template_code)) {
           return "N1";
    }

    $sql = "SELECT Massage FROM SendMessage WHERE TemplateCode='".$template_code."' LIMIT 1";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);

    $TRAN_ORI = $row['Massage'];
    $TRAN_MSG = $TRAN_ORI;
    $TRAN_TMPL_CD = $template_code;

    foreach($vars as $key => $val) {
        $TRAN_MSG = str_replace("#{".$key."}",$val, $TRAN_MSG);
    }

    $TRAN_SENDER_KEY = "bc54308732b7789e673004d47b4e6a5ce75110b1"; //발신프로필키                        
    $TRAN_CALLBACK = "18116552"; //발신번호
    $TRAN_PHONE = $phone_number; //수신번호
    $TRAN_SUBJECT = "HRDe평생교육원입니다"; //MMS전환시 문자 제목
    $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음

    $query = "INSERT INTO HRDTALK.MTS_ATALK_MSG (
        TRAN_SENDER_KEY,
        TRAN_TMPL_CD,
        TRAN_CALLBACK,
        TRAN_PHONE,
        TRAN_SUBJECT,
        TRAN_MSG,
        TRAN_DATE,
        TRAN_TYPE,
        TRAN_STATUS,
        TRAN_REPLACE_TYPE,
        TRAN_REPLACE_MSG
    ) VALUES (
        '$TRAN_SENDER_KEY',
        '$TRAN_TMPL_CD',
        '$TRAN_CALLBACK',
        '$TRAN_PHONE',
        '$TRAN_SUBJECT',
        '$TRAN_MSG',
         NOW(),
         5,
        '1',
        '$TRAN_REPLACE_TYPE',
        '$TRAN_ORI'
    )";

    $result = mysqli_query($connect, $query);

    if($result) {
        return "Y";
    } else {
        return "N2";
    }
}

