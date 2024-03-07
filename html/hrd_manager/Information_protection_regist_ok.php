<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$TB = Replace_Check($TB);
$Field = Replace_Check($Field);
$ele = Replace_Check($ele);
$ID = Replace_Check($ID);
$url = Replace_Check($url);
$AdminID = Replace_Check($AdminID);
$Gubun = Replace_Check($Gubun);
$Content = Replace_Check($Content);

$Sql = "INSERT INTO InformationProtectionLog(TB, Field, ID, url, AdminID, Gubun, Content, RegDate) 
			VALUES('$TB', '$Field', '$ID', '$url', '$AdminID', '$Gubun', '$Content', NOW())";
$Row = mysqli_query($connect, $Sql);

if($Row) {
?>
<script type="text/javascript">
<!--
	top.DataResultClose2();
	top.InformationProtectionView('<?=$TB?>','<?=$Field?>','<?=$ele?>','<?=$ID?>');
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
	alert("개인정보 열람사유 등록중 오류 발생");
	top.DataResultClose2();
//-->
</script>
<?
}

mysqli_close($connect);
?>