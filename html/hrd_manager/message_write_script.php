<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$mode = Replace_Check($mode);
$Title = Replace_Check($Title);
$Content = Replace_Check2($Content);


if($mode=="New") {

	$ReciveID = $ID;
	$SendID = $LoginAdminID;

	$Sql = "INSERT INTO Message(ReciveID, SendID, Title, Content, SendDate) VALUES('$ReciveID', '$SendID', '$Title', '$Content', NOW())";
	$Row = mysqli_query($connect, $Sql);

}

if($mode=="Delete") {

	$Sql = "DELETE FROM Message WHERE Seq=$Seq";
	$Row = mysqli_query($connect, $Sql);

}



if($Row) {
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
	opener.location.reload();
	<?}?>
	self.close();
//-->
</SCRIPT>