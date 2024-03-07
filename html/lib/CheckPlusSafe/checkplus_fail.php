<?php
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../../include/login_check_pop.php";


    $sitecode = $CheckPlus_sitecode;						// NICE로부터 부여받은 사이트 코드
    $sitepasswd = $CheckPlus_sitepasswd;					// NICE로부터 부여받은 사이트 패스워드

	//$cb_encode_path = "/home/LMS/lib/CheckPlusSafe/CPClient";
	$cb_encode_path = "/home/LMS/lib/CheckPlusSafe/64bit/CPClient_64bit";

		
    $enc_data = $_POST["EncodeData"];	// 암호화된 결과 데이타
 
	//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가. 
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}
   
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		
    if ($enc_data != "") {

		$plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
        //echo "[plaindata] " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
        }else{
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $errcode = GetValue($plaindata , "ERR_CODE");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
        }
    }
?>

<?
    function GetValue($str , $name)
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // 다르면 스킵한다.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>

</head>

<body>
    <center>
    <p><p><p><p>
    본인인증이 실패하였습니다.<br>
    <table width=500 border=1>
        <!-- <tr>
            <td>요청 번호</td>
            <td><?//= $requestnumber ?></td>
        </tr>  -->           
        <tr> 
            <td>본인인증 실패 코드</td>
            <td><?=iconv("EUC-KR", "UTF-8", $errcode) ?></td>
        </tr>            
        <tr>
            <td>인증수단</td>
            <td><?=iconv("EUC-KR", "UTF-8", $authtype) ?></td>
        </tr>
    </table>
    </center>
</body>
</html>