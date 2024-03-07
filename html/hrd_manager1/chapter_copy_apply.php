<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$TargetLectureCode = Replace_Check($TargetLectureCode);
$LectureCode = Replace_Check($LectureCode);


$SQL = "SELECT * FROM Chapter WHERE LectureCode='$LectureCode' ORDER BY OrderByNum ASC";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	$i = 1;
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);


		$maxno = max_number("Seq","Chapter");

		$Sql2 = "INSERT INTO Chapter 
				(Seq, LectureCode, ChapterType, Sub_idx, OrderByNum, RegDate) 
				VALUES ($maxno, '$TargetLectureCode', '$ChapterType', '$Sub_idx', $i, NOW())";
		//echo $Sql2."<BR>";
		$Row2 = mysqli_query($connect, $Sql2);

		if(!$Row2) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}

	$i++;
	}
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
?>
<script type="text/javascript">
<!--
	alert("[차시 정보 가져오기]를 실행중 에러가 발생했습니다.");
	top.DataResultClose();
//-->
</script>
<?
}else{
	mysqli_query($connect, "COMMIT");
?>
<script type="text/javascript">
<!--
	top.ChapterListRoading();
	alert("[차시 정보 가져오기]가 완료되었습니다.");
	top.DataResultClose();
//-->
</script>
<?
}

mysqli_close($connect);
?>
