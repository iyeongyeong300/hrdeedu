<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$Seq = Replace_Check_XSS2($Seq);

$Sql = "SELECT 
			a.ID, a.ServiceType, a.LectureStart, a.LectureEnd, a.PassOk, 
			b.Name, AES_DECRYPT(UNHEX(b.BirthDay),'$DB_Enc_Key') AS BirthDay, 
			c.CompanyName, 
			d.ContentsName, 
			(SELECT COUNT(idx) FROM PaymentSheet WHERE CompanyCode=a.CompanyCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PayStatus='Y') AS PaymentCount 
			FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			WHERE a.Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ID = $Row['ID'];
	$ServiceType= $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$PassOk = $Row['PassOk'];
	$Name = $Row['Name'];
	$BirthDay = $Row['BirthDay'];
	$CompanyName = $Row['CompanyName'];
	$ContentsName = $Row['ContentsName'];
	$PaymentCount = $Row['PaymentCount'];

	$LectureStart_array = explode("-",$LectureStart);
	$LectureStart_Year = $LectureStart_array[0];
	$LectureStart_Month = $LectureStart_array[1];
	$LectureStart_Day = $LectureStart_array[2];
	$LectureStart_view = $LectureStart_Year."년 ".$LectureStart_Month."월 ".$LectureStart_Day."일";

	$LectureEnd_array = explode("-",$LectureEnd);
	$LectureEnd_Year = $LectureEnd_array[0];
	$LectureEnd_Month = $LectureEnd_array[1];
	$LectureEnd_Day = $LectureEnd_array[2];
	$LectureEnd_view = $LectureEnd_Year."년 ".$LectureEnd_Month."월 ".$LectureEnd_Day."일";


	if($ServiceType==1) {
		$typeText = "사업주 직업능력개발 훈련과정(인터넷 원격)";
	}

	if($ServiceType==3 || $ServiceType==5 || $ServiceType==9) {
		$typeText = "인터넷 훈련과정";
	}

	if($ServiceType==4) {
		$typeText = "근로자 교육과정";
	}

}

if($PassOk!="Y") {
?>
<script type="text/javascript">
<!--
	alert("수료여부를 확인하세요.");
	DataResultClose();
//-->
</script>
<?
exit;
}


//if($PaymentCount<1) {
?>
<script type="text/javascript">
<!--
	//alert("교육비 결제여부를 확인하세요.");
	//DataResultClose();
//-->
</script>
<?
//exit;
//}
?>
<!-- layer Ask -->
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="../images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">수료증 출력</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>테두리선(상장모양)의 출력을 원하시면 출력 옵션에서 배경 그래픽 출력을<br>선택해주세요.</li>
			</ul>
		</div>
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <caption>학습내용 질문하기</caption>
			  <colgroup>
				  <col width="16%" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td >성명</td>
				<td><?=$Name?></td>
			  </tr>
			  <tr>
				<td >생년월일</td>
				<td><?=$BirthDay?></td>
			  </tr>
			  <tr>
				<td >소속</td>
				<td><?=$CompanyName?></td>
			  </tr>
			  <tr>
				<td >훈련과정</td>
				<td><?=$ContentsName?></td>
			  </tr>
			  <tr>
				<td >훈력직종</td>
				<td><?=$typeText?></td>
			  </tr>
			  <tr>
				<td >훈련기간</td>
				<td><?=$LectureStart_view?> ~ <?=$LectureEnd_view?></td>
			  </tr>
			</table>
		</div>
		<div class="fc000B mt20">
		위의 사항을 확인하고 수료증을 출력합니다.
		</div>

		<!-- btn -->
		<p class="btnAreaTc02">
			<span class="btnSmSky01"><a href="Javascript:CertificatePrintPage(<?=$Seq?>);">수료증 출력하기</a></span>
			<span class="btnSmSky01"><a href="/mypage/certificate_pdf01.php?Seq=<?=$Seq?>" target="ScriptFrame">수료증 PDF로 출력하기</a></span>
		</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Ask // -->
<?
mysqli_close($connect);
?>