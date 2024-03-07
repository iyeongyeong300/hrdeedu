<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$idx = Replace_Check_XSS2($idx);
$mode = Replace_Check_XSS2($mode);

if($LoginMemberID) {

	if($mode=="Regist") {
		$Sql = "INSERT INTO StudyPDS_Scrap(idx, ID, RegDate) VALUES($idx, '$LoginMemberID', NOW())";
		$Row = mysqli_query($connect, $Sql);
	}

	if($mode=="Delete") {
		$Sql = "DELETE FROM StudyPDS_Scrap WHERE idx=$idx AND ID='$LoginMemberID'";
		$Row = mysqli_query($connect, $Sql);
	}

}
?>
 <!-- layer -->
 <div class="layerArea wid450">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultCloseReload();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title"><?if($mode=="Regist") {?>학습자료 찜하기<?}else{?>학습자료 찜 취소하기<?}?></div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<?if($mode=="Regist") {?>
		<p class="fc777">학습자료 찜하기가 완료되었습니니다.<br />
		<span class="fc333B">온라인 학습실 &gt; 자료/상담관리</span>에서 확인하세요.</p>
		<?}else{?>
		<p class="fc777">학습자료 찜 취소하기가 완료되었습니니다.<br />
		<?}?>
		<p class="btnAreaTc02"><span class="btnSmSky01"><a href="Javascript:DataResultCloseReload();">확인</a></span></p>
	  <!-- area // -->
	</div>
	<!-- info // -->
 </div>
 <!-- layer // -->