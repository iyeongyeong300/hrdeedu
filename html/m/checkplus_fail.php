<?php
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

    //**************************************************************************************************************
    //NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //서비스명 :  체크플러스 - 안심본인인증 서비스
    //페이지명 :  체크플러스 - 결과 페이지
    
    //보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 
    //**************************************************************************************************************
    

    $sitecode = $CheckPlus_sitecode;						// NICE로부터 부여받은 사이트 코드
    $sitepasswd = $CheckPlus_sitepasswd;					// NICE로부터 부여받은 사이트 패스워드

	$cb_encode_path = $Auth_Mobile_path;
		
    $enc_data = $_REQUEST["EncodeData"];	// 암호화된 결과 데이타
 
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

<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.6, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="./css/style.css" />
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/function.js?t=20200210"></script>
</head>

<body>

<script type="text/javascript">
<!--
	alert('본인인증이 실패하였습니다.\n\n실패 코드 : <?=iconv("EUC-KR", "UTF-8", $errcode) ?>');
	self.close();
//-->
</script>

</body>
</html>