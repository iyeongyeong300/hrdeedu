<?php
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../../include/login_check_pop.php";
    //**************************************************************************************************************
    //NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
    
    //서비스명 :  체크플러스 - 안심본인인증 서비스
    //페이지명 :  체크플러스 - 결과 페이지
    
    //보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 
	//인증 후 결과값이 null로 나오는 부분은 관리담당자에게 문의 바랍니다.
    //**************************************************************************************************************
    
	//session_start();
	
	
    $sitecode = $CheckPlus_sitecode;					// NICE로부터 부여받은 사이트 코드
    $sitepasswd = $CheckPlus_sitepasswd;				// NICE로부터 부여받은 사이트 패스워드
    
	$cb_encode_path = $Auth_Mobile_path;
    
    $enc_data = $_REQUEST["EncodeData"];		// 암호화된 결과 데이타
    $param_r3 = $_REQUEST["param_r3"];		// 인증 구분

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가. 
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		
    if ($enc_data != "") {

		$plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
        
        //echo "[plaindata]  " . $plaindata . "<br>";

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
            $responsenumber = GetValue($plaindata , "RES_SEQ");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
            $name = GetValue($plaindata , "NAME");
            //$name = GetValue($plaindata , "UTF8_NAME"); //charset utf8 사용시 주석 해제 후 사용
            $birthdate = GetValue($plaindata , "BIRTHDATE");
            $gender = GetValue($plaindata , "GENDER");
            $nationalinfo = GetValue($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
            $dupinfo = GetValue($plaindata , "DI");
            $conninfo = GetValue($plaindata , "CI");
			$mobileno = GetValue($plaindata , "MOBILE_NO");
            $mobileco = GetValue($plaindata , "MOBILE_CO");

			$name = iconv("EUC-KR","UTF-8",$name);

            if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0)
            {
            	//echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
                $requestnumber = "";
                $responsenumber = "";
                $authtype = "";
                $name = "";
            	$birthdate = "";
            	$gender = "";
            	$nationalinfo = "";
            	$dupinfo = "";
            	$conninfo = "";
            	$mobileno = "";
            	$mobileco = "";
            }
        }
    }
?>

<?
    function GetValue($str , $name) //해당 함수에서 에러 발생 시 $len => (int)$len 로 수정 후 사용하시기 바랍니다.
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

//본인 인증한 휴대폰 번호가 회원정보와 일치하는지 확인
$Sql = "SELECT AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, Name, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

$UserMobile = $Row["Mobile"];
$UserName = $Row["Name"];
$UserBirthDay = $Row["BirthDay"];

$UserMobile = str_replace("-","",$UserMobile); //회원정보의 휴대폰 번호
$UserBirthDay = str_replace("-","",$UserBirthDay);
$mobileno = str_replace("-","",$mobileno); //NICE에서 리턴받은 휴대폰번호
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
<?
if(($UserMobile != $mobileno) || ($UserName != $name) || ($UserBirthDay != $birthdate)) {
?>
<script type="text/javascript">
<!--
	alert("본인인증에 사용된 휴대폰 인증 정보가\n\n회원정보의 정보와 일치하지 않습니다.\n\n\n\n본인명의의 휴대폰으로 인증을 진행하세요.");
	//opener.top.location.reload();
	self.close();
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
    //opener.CertCheckProc(m_trnDT);

    var m_trnDT = "<?=date('Y-m-d H:i:s')?>";
    var m_Ret = "T";
    var m_retCD = "000000";
    var m_trnID = <?=date('YmdHis')?>;
<? if ($param_r3 == "user_reset") { ?>
    opener.fn_userReset();
<? } else { ?>
    opener.pSubOtpLog(m_retCD,m_trnID,m_trnDT);
<? } ?>
	self.close();
//-->
</script>
<?
}
?>
<!-- 
    <center>
    <p><p><p><p>
    본인인증이 완료 되었습니다.<br>
    <table border=1>

        <tr>
            <td>요청 번호</td>
            <td><?= $requestnumber ?></td>
        </tr>            
        <tr>
            <td>나신평응답 번호</td>
            <td><?= $responsenumber ?></td>
        </tr>            
        <tr>
            <td>인증수단</td>
            <td><?= $authtype ?></td>
        </tr>
        <tr>
            <td>성명</td>
            <td><?= $name ?></td>
        </tr>
        <tr>
            <td>생년월일(YYYYMMDD)</td>
            <td><?= $birthdate ?></td>
        </tr>
        <tr>
            <td>성별</td>
            <td><?= $gender ?></td>
        </tr>
        <tr>
            <td>내/외국인정보</td>
            <td><?= $nationalinfo ?></td>
        </tr>
        <tr>
            <td>DI(64 byte)</td>
            <td><?= $dupinfo ?></td>
        </tr>
        <tr>
            <td>CI(88 byte)</td>
            <td><?= $conninfo ?></td>
        </tr>
        <tr>
			<td>휴대폰번호</td>
            <td><?= $mobileno ?></td>
        </tr>
		<tr>
			<td>통신사</td>
			<td><?= $mobileco ?></td>
        </tr>
		<tr>
			<td colspan="2">인증 후 결과값은 내부 설정에 따른 값만 리턴받으실 수 있습니다. <br>
			일부 결과값이 null로 리턴되는 경우 관리담당자 또는 계약부서(02-2122-4615)로 문의바랍니다.</td>
		</tr>
    </table>
    </center>
 -->
</body>
</html>
