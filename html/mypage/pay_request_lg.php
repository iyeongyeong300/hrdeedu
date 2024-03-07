<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$pay_idx = Replace_Check_XSS2($pay_idx);
$CompanyCode = Replace_Check_XSS2($CompanyCode);

if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	alert("로그인후에 결제가 가능합니다.");
	DataResultClose();
//-->
</script>
<?
}else{

		$OrderNum = MakeOrderNum();

	$Sql = "SELECT *, 
				(SELECT CompanyName FROM Company WHERE CompanyCode=a.CompanyCode) AS CompanyName 
				FROM PaymentSheet AS a
				WHERE a.companyCode='$CompanyCode' AND (a.PayStatus='R' OR a.PayStatus='Y') AND a.idx=$pay_idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CompanyName = $Row['CompanyName'];
		$LectureStart = $Row['LectureStart'];
		$LectureEnd = $Row['LectureEnd'];
		$CardPrice = $Row['CardPrice'];
		$PayStatus = $Row['PayStatus'];
	}

	$Sql = "SELECT Name, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Email = $Row['Email'];
		$Mobile = $Row['Mobile'];
		$Name = $Row['Name'];
	}



    /*
     * 1. 기본결제 인증요청 정보 변경
     * 
     * 기본정보를 변경하여 주시기 바랍니다.(파라미터 전달시 POST를 사용하세요)
     */
    $CST_PLATFORM = "service"; //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
    $CST_MID = "ekt002"; //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
									//테스트 아이디는 't'를 반드시 제외하고 입력하세요.
    $LGD_MID = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;   //상점아이디(자동생성)
    $LGD_OID = $OrderNum; //주문번호(상점정의 유니크한 주문번호를 입력하세요)
    $LGD_AMOUNT = $CardPrice; //결제금액("," 를 제외한 결제금액을 입력하세요)
    $LGD_BUYER = $Name; //구매자명
    $LGD_PRODUCTINFO = "EK티처 한국어교사원격평생교육원 수강료|".$CompanyCode."|".$LectureStart."|".$LectureEnd; //상품명
	//$LGD_PRODUCTINFO = "EK티처 한국어교사원격평생교육원 수강료";
    $LGD_BUYEREMAIL = $Email; //구매자 이메일
    $LGD_OSTYPE_CHECK = "P"; //값 P: XPay 실행(PC 결제 모듈): PC용과 모바일용 모듈은 파라미터 및 프로세스가 다르므로 PC용은 PC 웹브라우저에서 실행 필요. 
												//"P", "M" 외의 문자(Null, "" 포함)는 모바일 또는 PC 여부를 체크하지 않음
    //$LGD_ACTIVEXYN = "N"; //계좌이체 결제시 사용, ActiveX 사용 여부로 "N" 이외의 값: ActiveX 환경에서 계좌이체 결제 진행(IE)

    $LGD_CUSTOM_SKIN = "red"; //상점정의 결제창 스킨
    $LGD_CUSTOM_USABLEPAY = "SC0010-SC0030"; //디폴트 결제수단 (해당 필드를 보내지 않으면 결제수단 선택 UI 가 노출됩니다.)
    $LGD_WINDOW_VER = "2.5"; //결제창 버젼정보
    $LGD_WINDOW_TYPE = "iframe"; //결제창 호출방식 (수정불가)
    $LGD_CUSTOM_SWITCHINGTYPE = "IFRAME"; //신용카드 카드사 인증 페이지 연동 방식 (수정불가)  
    $LGD_CUSTOM_PROCESSTYPE = "TWOTR"; //수정불가

    /* 가상계좌(무통장) 결제 연동을 하시는 경우 아래 LGD_CASNOTEURL 을 설정하여 주시기 바랍니다. */    
    $LGD_CASNOTEURL = $SiteURL."/lib/LGU_XPay_Crossplatform_PHP/cas_noteurl.php";    

    /* LGD_RETURNURL 을 설정하여 주시기 바랍니다. 반드시 현재 페이지와 동일한 프로트콜 및  호스트이어야 합니다. 아래 부분을 반드시 수정하십시요. */    
    $LGD_RETURNURL = $SiteURL."/lib/LGU_XPay_Crossplatform_PHP/returnurl.php";  
    $configPath = $HomeDirectory."/lib/LGU_XPay_Crossplatform_PHP/lgdacom"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.     

	$LGD_ENCODING = "UTF-8";
	$LGD_ENCODING_NOTEURL = "UTF-8";
	$LGD_ENCODING_RETURNURL = "UTF-8";

    /*
     *************************************************
     * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
     * 
     * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
     *************************************************
     */

	require_once("../lib/LGU_XPay_Crossplatform_PHP/lgdacom/XPayClient.php");
	$xpay = new XPayClient($configPath, $CST_PLATFORM);
	$xpay->Init_TX($LGD_MID);
	$LGD_TIMESTAMP = $xpay->GetTimeStamp(); 
	$LGD_HASHDATA = $xpay->GetHashData($LGD_MID,$LGD_OID,$LGD_AMOUNT,$LGD_TIMESTAMP);
	//echo $LGD_HASHDATA."<BR>".$LGD_MID."<BR>".$LGD_OID."<BR>".$LGD_AMOUNT."<BR>".$LGD_TIMESTAMP;
    /*
     *************************************************
     * 2. MD5 해쉬암호화 (수정하지 마세요) - END
     *************************************************
     */

    $payReqMap['CST_PLATFORM']           = $CST_PLATFORM;				// 테스트, 서비스 구분
    $payReqMap['LGD_WINDOW_TYPE']        = $LGD_WINDOW_TYPE;			// 수정불가
    $payReqMap['CST_MID']                = $CST_MID;					// 상점아이디
    $payReqMap['LGD_MID']                = $LGD_MID;					// 상점아이디
    $payReqMap['LGD_OID']                = $LGD_OID;					// 주문번호
    $payReqMap['LGD_BUYER']              = $LGD_BUYER;					// 구매자
    $payReqMap['LGD_PRODUCTINFO']        = $LGD_PRODUCTINFO;			// 상품정보
    $payReqMap['LGD_AMOUNT']             = $LGD_AMOUNT;					// 결제금액
    $payReqMap['LGD_BUYEREMAIL']         = $LGD_BUYEREMAIL;				// 구매자 이메일
    $payReqMap['LGD_CUSTOM_SKIN']        = $LGD_CUSTOM_SKIN;			// 결제창 SKIN
    $payReqMap['LGD_CUSTOM_PROCESSTYPE'] = $LGD_CUSTOM_PROCESSTYPE;		// 트랜잭션 처리방식
    $payReqMap['LGD_TIMESTAMP']          = $LGD_TIMESTAMP;				// 타임스탬프
    $payReqMap['LGD_HASHDATA']           = $LGD_HASHDATA;				// MD5 해쉬암호값
    $payReqMap['LGD_RETURNURL']   		 = $LGD_RETURNURL;				// 응답수신페이지
    $payReqMap['LGD_VERSION']         	 = "PHP_Non-ActiveX_Standard";	// 버전정보 (삭제하지 마세요)
    $payReqMap['LGD_CUSTOM_USABLEPAY']  	= $LGD_CUSTOM_USABLEPAY;	// 디폴트 결제수단
	$payReqMap['LGD_CUSTOM_SWITCHINGTYPE']  = $LGD_CUSTOM_SWITCHINGTYPE;// 신용카드 카드사 인증 페이지 연동 방식
	$payReqMap['LGD_OSTYPE_CHECK']          = $LGD_OSTYPE_CHECK;        // 값 P: XPay 실행(PC용 결제 모듈), PC, 모바일 에서 선택적으로 결제가능 
	//$payReqMap['LGD_ACTIVEXYN']			= $LGD_ACTIVEXYN;			// 계좌이체 결제시 사용,ActiveX 사용 여부
    $payReqMap['LGD_WINDOW_VER'] 			= $LGD_WINDOW_VER;
	$payReqMap['LGD_DOMAIN_URL'] 			= "xpayvvip";

	$payReqMap['LGD_ENCODING'] = $LGD_ENCODING;
	$payReqMap['LGD_ENCODING_NOTEURL'] = $LGD_ENCODING_NOTEURL;
	$payReqMap['LGD_ENCODING_RETURNURL'] = $LGD_ENCODING_RETURNURL;

    
    // 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 .
    $payReqMap['LGD_CASNOTEURL'] = $LGD_CASNOTEURL;               // 가상계좌 NOTEURL

    //Return URL에서 인증 결과 수신 시 셋팅될 파라미터 입니다.*/
    $payReqMap['LGD_RESPCODE']           = "";
    $payReqMap['LGD_RESPMSG']            = "";
    $payReqMap['LGD_PAYKEY']             = "";

    $_SESSION['PAYREQ_MAP'] = $payReqMap;
?>
<!-- test일 경우 -->
<!-- <script language="javascript" src="https://pretest.uplus.co.kr:9443/xpay/js/xpay_crossplatform.js" type="text/javascript"></script> -->

<!--   service일 경우 아래 URL을 사용 -->
<script language="javascript" src="https://xpayvvip.uplus.co.kr/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
 
<script type="text/javascript">

/*
* 수정불가.
*/
	var LGD_window_type = '<?= $LGD_WINDOW_TYPE ?>';
	
/*
* 수정불가
*/
function launchCrossPlatform(){
	document.charset = "utf-8";
	lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type, null, "", "");
}
/*
* FORM 명만  수정 가능
*/
function getFormObject() {
        return document.getElementById("LGD_PAYINFO");
}

/*
 * 인증결과 처리
 */
function payment_return() {
	var fDoc;
	
		fDoc = lgdwin.contentWindow || lgdwin.contentDocument;
	
		
	if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
		
			document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;
			document.getElementById("LGD_PAYINFO").target = "ScriptFrame";
			document.getElementById("LGD_PAYINFO").action = "/lib/LGU_XPay_Crossplatform_PHP/payres.php";
			document.getElementById("LGD_PAYINFO").submit();
	} else {
		alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
		closeIframe();
	}
}

</script>
<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="/lib/LGU_XPay_Crossplatform_PHP/payres.php" >
<!-- layer Ask -->
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">결제하기</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>사업주명, 교육 기간, 결제 금액을 확인 후 결제를 진행하여 주세요.</li>
			</ul>
		</div>
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <caption>결제하기</caption>
			  <colgroup>
				  <col width="120px" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td >사업주명</td>
				<td><?=$CompanyName?></td>
			  </tr>
			  <tr>
				<td >교육 기간</td>
				<td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
			  </tr>
			  <tr>
				<td >결제 금액</td>
				<td><?=number_format($CardPrice,0)?> 원</td>
			  </tr>
			</table>
		</div>


		<!-- btn -->
		<p class="btnAreaTc02 mt20">
			<span class="btnSmSky01"><a href="Javascript:launchCrossPlatform();">결제 하기</a></span>
		</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Ask // -->
<?
foreach ($payReqMap as $key => $value) {
	echo "<input type='hidden' name='$key' id='$key' value='".$value."'>";
}
//var_dump($_SESSION);
?>
</form>
<?
}

mysqli_close($connect);
?>