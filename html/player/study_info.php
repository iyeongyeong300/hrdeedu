<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Contents_idx = Replace_Check_XSS2($Contents_idx);


## 과정 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Professor = $Row['Professor']; //내용전문가 
}

## 차시 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Contents WHERE idx='$Contents_idx'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$Expl01 = nl2br($Row['Expl01']); //차시 목표
	$Expl02 = nl2br($Row['Expl02']); //훈련 내용
	$Expl03 = nl2br($Row['Expl03']); //학습 활동

}
?>
<!-- layer 학습요점 -->
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:PlayInfoClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title" id="drag">학습요점</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="clipInfo">
			<ul>
				<li>
					<h5>내용전문가</h5>
					<?=$Professor?>
				</li>
				<li>
					<h5>차시 목표</h5>
					<?=$Expl01?>
				</li>
				<li>
					<h5>훈련 내용</h5>
					<?=$Expl02?>
				</li>
				<li>
					<h5>학습 활동</h5>
					<?=$Expl03?>
				</li>
			</ul>
		</div>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer 학습요점 // -->
<script type="text/javascript">
<!--
$(document).ready(function() {

	$("#drag").css("cursor","move");

	$("#drag").mouseover(function(){
		$("div[id='StudyInformation']").draggable();
		$("div[id='StudyInformation']").draggable("option","disabled",false);
	})

	$("#drag").mouseleave(function(){
		$("div[id='StudyInformation']").draggable("option","disabled",true);
	});

});
//-->
</script>