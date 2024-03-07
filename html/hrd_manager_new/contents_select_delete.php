<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query("SET AUTOCOMMIT=0");
mysqli_query("BEGIN");

$idx_value = Replace_Check($idx_value);
$mode = Replace_Check($mode);

$error_count = 0;

if($mode=="del") { //선택항목 삭제---------------------------------------------------------------------------------------------------------

	$idx_value_array = explode("|",$idx_value);

	foreach($idx_value_array as $idx) {

		$idx = trim($idx);

		if($idx) {
			$Sql = "DELETE FROM ContentsExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
			$Row = mysqli_query($connect, $Sql);
			if(!$Row) { //쿼리 실패시 에러카운터 증가
				$error_count++;
			}
		}
	}

	$msg = "삭제되었습니다.";

} //선택항목 삭제---------------------------------------------------------------------------------------------------------

if($error_count>0) {
	mysqli_query("ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.";
}else{
	mysqli_query("COMMIT");
}


mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.ContentsExcelUploadListRoading('A');
//-->
</SCRIPT>