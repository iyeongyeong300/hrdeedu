<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$ContentGubun = Replace_Check($ContentGubun);
$LectureCode = Replace_Check($LectureCode);
$ChapterType = Replace_Check($ChapterType);

$SQL = "SELECT * FROM Contents WHERE Del='N' AND Gubun='$ContentGubun' ORDER BY RegDate ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	$i = 1;
	while($Row = mysqli_fetch_array($QUERY))
	{

		$Sub_idx = $Row['idx'];

		$maxno = max_number("Seq","Chapter");

		$Sql2 = "INSERT INTO Chapter 
					(Seq, LectureCode, ChapterType, Sub_idx, OrderByNum, RegDate) 
					VALUES ($maxno, '$LectureCode', '$ChapterType', '$Sub_idx', $i, NOW())";
		$Row2 = mysqli_query($connect, $Sql2);

		if(!$Row2) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}


	$i++;
	}
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. ";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "등록 되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.ChapterListRoading();
	top.DataResultClose();
//-->
</SCRIPT>