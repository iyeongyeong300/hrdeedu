<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<?
$mode = Replace_Check($mode);
$LectureCode = Replace_Check($LectureCode);
$Chapter_seq = Replace_Check($Chapter_seq);

$ChapterType = Replace_Check($ChapterType);
$Content_idx = Replace_Check($Content_idx);
$Exam_idx_arrary = Replace_Check($Exam_idx_arrary);
$OrderByNum = Replace_Check($OrderByNum);

$cmd = false;


if($ChapterType=="A") {
	$Sub_idx = $Content_idx;
}else{
	$Sub_idx = $Exam_idx_arrary;
}

if($mode=="new") { //신규 작성---------------------------------------------------------------------------------------------------------


	if($ChapterType!="A") { //등록 형태가 강의차시가 아닌 평가인 경우 중복된 값을 체크

		$Sub_idx_array = explode("|",$Sub_idx);
		$Sub_idx_array_unique = array_unique($Sub_idx_array); //중복을 제거한 배열값

		$Sub_idx_array_count = count($Sub_idx_array); //원래 배열 갯수
		$Sub_idx_array_unique_count = count($Sub_idx_array_unique); //중복제거한 배열 갯수

		if($Sub_idx_array_count != $Sub_idx_array_unique_count) {
?>
		<script type="text/javascript">
		<!--
			alert("평가 문제에 중복된 항목이 존재합니다.");
			top.$("#SubmitBtn").show();
			top.$("#Waiting").hide();
		//-->
		</script>
<?
		exit;
		}

	}


	$maxno = max_number("Seq","Chapter");

	$Sql = "INSERT INTO Chapter 
				(Seq, LectureCode, ChapterType, Sub_idx, OrderByNum, RegDate) 
				VALUES ($maxno, '$LectureCode', '$ChapterType', '$Sub_idx', $OrderByNum, NOW())";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}//신규 작성---------------------------------------------------------------------------------------------------------


if($mode=="edit") { //수정---------------------------------------------------------------------------------------------------------

	if($ChapterType!="A") { //등록 형태가 강의차시가 아닌 평가인 경우 중복된 값을 체크

		$Sub_idx_array = explode("|",$Sub_idx);
		$Sub_idx_array_unique = array_unique($Sub_idx_array); //중복을 제거한 배열값

		$Sub_idx_array_count = count($Sub_idx_array); //원래 배열 갯수
		$Sub_idx_array_unique_count = count($Sub_idx_array_unique); //중복제거한 배열 갯수

		if($Sub_idx_array_count != $Sub_idx_array_unique_count) {
?>
		<script type="text/javascript">
		<!--
			alert("평가 문제에 중복된 항목이 존재합니다.");
			top.$("#SubmitBtn").show();
			top.$("#Waiting").hide();
		//-->
		</script>
<?
		exit;
		}

	}


	$Sql = "UPDATE Chapter SET ChapterType='$ChapterType', Sub_idx='$Sub_idx', OrderByNum=$OrderByNum WHERE Seq=$Chapter_seq";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}//수정---------------------------------------------------------------------------------------------------------

if($mode=="del") { //삭제---------------------------------------------------------------------------------------------------------

	$Sql = "DELETE FROM  Chapter  WHERE Seq=$Chapter_seq";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}//삭제---------------------------------------------------------------------------------------------------------


if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}


mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
		<?if($mode=="new") {?>
			<?if($ChapterType=="A") {?>
				top.$("#SubmitBtn").show();
				top.$("#Waiting").hide();
				var OrderByNum2 = eval(top.$("#OrderByNum").val())+1;
				top.$("#OrderByNum").val(OrderByNum2);
				top.ChapterListRoading();
			<?}else{?>
				top.ChapterListRoading();
				top.DataResultClose();
			<?}?>
		<?}?>
		<?if($mode=="edit") {?>
			top.ChapterListRoading();
			top.DataResultClose();
		<?}?>
		<?if($mode=="del") {?>
			top.DataResultClose();
			top.location.reload();
		<?}?>
	<?}?>
//-->
</SCRIPT>