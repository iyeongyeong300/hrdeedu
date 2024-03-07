<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$idx_value = Replace_Check($idx_value);

$error_count = 0;


$idx_value_array = explode("|",$idx_value);

$i = 1;
foreach($idx_value_array as $idx) {

	$idx = trim($idx);

	if($idx) {
		$Sql = "UPDATE DeptStructure SET OrderByNum=$i WHERE idx=$idx";
		$Row = mysqli_query($connect, $Sql);
		if(!$Row) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}
	}
$i++;
}

$msg = "처리되었습니다.";


if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.";
}else{
	mysqli_query($connect, "COMMIT");
}


mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.location.reload();
//-->
</SCRIPT>