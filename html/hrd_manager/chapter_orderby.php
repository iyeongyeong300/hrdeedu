<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;
$Chapter_seq_array = Replace_Check($Chapter_seq_array);
$LectureCode = Replace_Check($LectureCode);

$Chapter_seq_array2 = explode("|",$Chapter_seq_array);

$i = 1;
foreach ($Chapter_seq_array2 as $Chapter_seq_array_value) {

	$Sql = "UPDATE Chapter SET OrderByNum=$i WHERE Seq=$Chapter_seq_array_value";
	//echo $Sql."<BR>";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

$i++;
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. ";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "정렬 처리되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.ChapterListRoading();
//-->
</SCRIPT>