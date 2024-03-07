<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);

$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ctype = $Row['ctype']; //A 사업주과정, B 내일배움카드
	$Price = $Row['Price']; //교육비용 일반
	$Price01View = $Row['Price01View']; //교육비용 우선지원 
	$Price02View = $Row['Price02View']; //교육비용 대규모 1000인 미만 
	$Price03View = $Row['Price03View']; //교육비용 대규모 1000인 이상 

	$Price01 = $Row['Price01'];
	$Price02 = $Row['Price02'];
	$Price03 = $Row['Price03'];

}

if($ctype=="A") {
	$CompanyScaleTitle01 = "우선지원 기업";
	$CompanyScaleTitle02 = "대규모(1,000인 미만)";
	$CompanyScaleTitle03 = "대규모(10,000인 이상)";
}

if($ctype=="B") {
	$CompanyScaleTitle01 = "일반훈련생";
	$CompanyScaleTitle02 = "취업성공패키지";
	$CompanyScaleTitle03 = "근로장려금";
}
?>
<!-- layer Refund info -->
<div class="layerArea wid500">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="../images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">환급지원 / 자부담금</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="info">
			교육비 : <span class="fc000B"><?=number_format($Price,0)?>원</span><br><br>
			<table cellpadding="0" class="pan_reg">
			  <caption>환급지원 / 자부담금</caption>
			  <tr>
				<td><strong>구분</strong></td>
				<td class="tr"><strong>환급</strong></td>
				<td class="tr"><strong>자부담금</strong></td>
			  </tr>
			  <tr>
				<td><strong><?=$CompanyScaleTitle01?></strong></td>
				<td class="tr"><span class="fc000B"><?=number_format($Price01View,0)?>원</span></td>
				<td class="tr"><span class="fc000B"><?=number_format($Price01,0)?>원</span></td>
			  </tr>
			  <tr>
				<td><strong><?=$CompanyScaleTitle02?></strong></td>
				<td class="tr"><span class="fc000B"><?=number_format($Price02View,0)?>원</span></td>
				<td class="tr"><span class="fc000B"><?=number_format($Price02,0)?>원</span></td>
			  </tr>
			  <tr>
				<td><strong><?=$CompanyScaleTitle03?></strong></td>
				<td class="tr"><span class="fc000B"><?=number_format($Price03View,0)?>원</span></td>
				<td class="tr"><span class="fc000B"><?=number_format($Price03,0)?>원</span></td>
			  </tr>
			</table>
		</div>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Refund info // -->
<?
mysqli_close($connect);
?>