<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의
include "../../include/login_check_pop.php";
?>
<html>
<head>
	<title>NICE평가정보 가상주민번호 서비스</title>
<style type="text/css"> 
BODY
{
    COLOR: #7f7f7f;
    FONT-FAMILY: "Dotum","DotumChe","Arial";
    BACKGROUND-COLOR: #ffffff;
}
</style>
</head>

<body>

<?php

	//보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 

	//session_start();
	
	/********************************************************************************************************************************************
		NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		서비스명 : 가상주민번호서비스 (IPIN) 서비스
		페이지명 : 가상주민번호서비스 (IPIN) 사용자 인증 정보 결과 페이지
		
				   수신받은 데이터(인증결과)를 복호화하여 사용자 정보를 확인합니다.
	*********************************************************************************************************************************************/
	
	$sSiteCode = $IPIN_CheckPlus_sitecode;			// NICE평가정보에서 발급한 IPIN 서비스 사이트코드
	$sSitePw = $IPIN_CheckPlus_sitepasswd;			// NICE평가정보에서 발급한 IPIN 서비스 사이트패스워드

	$sEncData = $_POST['enc_data'];	// ipin_process.php 에서 리턴받은 암호화된 인증결과 데이타
    
	//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $sEncData, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
    if(base64_encode(base64_decode($sEncData))!=$sEncData) {echo " 입력 값 확인이 필요합니다"; exit;}		
  //////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
	// 모듈의 경로 설정 
	// 모듈의 경로와 파일명을 절대경로로 입력합니다. 
	// 예) $sModulePath				= "C:\\module\\IPIN2Client.exe";
	//     $sModulePath				= "/root/module/IPIN2Client";
	$sModulePath				= $Auth_IPIN_path;
	
	// CP요청번호 추출
	// ipin_main.php 에서 세션에 저장한 CP요청번호를 추출합니다.
	// 데이타 위변조를 확인하기 위함이며 필수사항이 아닌 보안을 위한 권고사항입니다.
  $sCPRequest = $_SESSION['CPREQUEST'];
   
	$sDecData					= "";			// 복호화 된 인증결과 데이타
	$sRtnMsg					= "";			// 처리결과 메세지
    
    if ($sEncData != "") {
    
    	// 인증결과 데이타 복호화
    	// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
    	// 예) $sDecData = system("$sModulePath RES $sSiteCode $sSitePw $sEncData");
    	$sDecData = `$sModulePath RES $sSiteCode $sSitePw $sEncData`;
    	
    	if ($sDecData == -9) {
    		$sRtnMsg = "입력값 오류 : 복호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
    	} else if ($sDecData == -12) {
    		$sRtnMsg = "NICE평가정보에서 발급한 개발정보가 정확한지 확인해 보세요.";
    	} else {
    	
    		// 복호화 데이타 분할
    		// 복호화된 데이타는 '값의 길이(byte):실제값' 형식으로 구성됩니다.
    		// PHP 5.3.0 이상 버전에서는 split 대신 explode 함수를 이용해주십시오.
    		$arrData = explode(":", $sDecData);
    		$iCount = count($arrData);
    		
    		if ($iCount >= 5) {
    		
    			/*
					다음과 같이 사용자 정보를 추출할 수 있습니다.
					사용자에게 보여주는 정보는, '이름' 데이타만 노출 가능합니다.
				
					사용자 정보를 다른 페이지에서 이용하실 경우에는
					보안을 위하여 암호화 데이타($sEncData)를 통신하여 복호화 후 이용하실것을 권장합니다. (현재 페이지와 같은 처리방식)
					
					만약, 복호화된 정보를 통신해야 하는 경우엔 데이타가 유출되지 않도록 주의해 주세요. (세션처리 권장)
					form 태그의 hidden 처리는 데이타 유출 위험이 높으므로 권장하지 않습니다.
				*/
				
				$strResultCode		= GetValue($sDecData, "RESULT_CODE");			// 결과코드
				if ($strResultCode == 1) {
					$strCPRequest	= GetValue($sDecData, "CPREQUESTNO");			// CP 요청번호
					
					if ($sCPRequest == $strCPRequest) {
				
						$sRtnMsg = "사용자 인증 성공";
						
						$strVnumber			= GetValue($sDecData, "VNUMBER");			// 가상주민번호 (13자리, 숫자 또는 문자 포함)
						$strUserName		= GetValue($sDecData, "NAME");				// 이름
						$strDupInfo			= GetValue($sDecData, "DUPINFO");			// 중복가입 확인값 (DI - 64 byte 고유값)
						$strGender			= GetValue($sDecData, "GENDERCODE");	// 성별 코드 (개발 가이드 참조)
						$strAgeInfo			= GetValue($sDecData, "AGECODE");			// 연령대 코드 (개발 가이드 참조)
						$strBirthDate		= GetValue($sDecData, "BIRTHDATE");		// 생년월일 (YYYYMMDD)
						$strNationalInfo	= GetValue($sDecData, "NATIONALINFO");	// 내/외국인 정보 (개발 가이드 참조)
						$strAuthInfo		= GetValue($sDecData, "AUTHMETHOD");	// 본인확인 수단 (개발 가이드 참조)
						$strCoInfo			= GetValue($sDecData, "COINFO1");			// 연계정보 확인값 (CI - 88 byte 고유값)
						$strCIUpdate		= GetValue($sDecData, "CIUPDATE");		// CI 갱신정보
					
					} else {
						$sRtnMsg = "CP 요청번호 불일치 : 세션에 넣은 $sCPRequest 데이타를 확인해 주시기 바랍니다.";
					}
				} else {
					$sRtnMsg = "리턴값 확인 후, NICE평가정보 개발 담당자에게 문의해 주세요. [$strResultCode]";
				}
    		
    		} else {
    			$sRtnMsg = "리턴값 확인 후, NICE평가정보 개발 담당자에게 문의해 주세요.";
    		}
    	
    	}
    } else {
    	$sRtnMsg = "처리할 암호화 데이타가 없습니다.";
    }
    


    function GetValue($str , $name)
    {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str) )
        {
            // non-numeric 오류 발생 시 $len 변수의 타입을 변환해주시기 바랍니다.
            // 예) $len = (int) substr($str , $pos1 , $pos2 - $pos1);
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;
            if( $key == $name )
            {
                // non-numeric 오류 발생 시 $len 변수의 타입을 변환해주시기 바랍니다.
                // 예) $len = (int) substr($str , $pos1 , $pos2 - $pos1);
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            }
            else
            {
                // non-numeric 오류 발생 시 $len 변수의 타입을 변환해주시기 바랍니다.
                // 예) $len = (int) substr($str , $pos1 , $pos2 - $pos1);
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }            
        }
    }


$strUserName = iconv("EUC-KR", "UTF-8", $strUserName);

//인증결과 성명이 일치하는지 확인
$Sql = "SELECT Name FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

$Name = $Row["Name"];

//echo "DB이름:".$Name."<BR>";
//echo "리턴이름:".$strUserName."<BR>";
?>
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<?
if($Name != $strUserName) {
?>
<script type="text/javascript">
<!--
	alert("본인인증 결과 성명이 일치하지 않습니다.");
	opener.top.location.reload();
	self.close();
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
	var m_trnDT = "<?=date('Y-m-d H:i:s')?>";
	opener.CertCheckProc(m_trnDT);
	self.close();
//-->
</script>
<?
}
?>
	<!-- 처리결과 : <?= $sRtnMsg ?><br>
	이름 : <?= $strUserName ?><br> -->

	<form name="user" method="post">
		<input type="hidden" name="enc_data" value="<?= $sEncData ?>"><br>
	</form>
</body>
</html>