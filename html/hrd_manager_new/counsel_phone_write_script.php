<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);
$Category = Replace_Check($Category);
$Name = Replace_Check($Name);
$Status = Replace_Check($Status);
$Contents = Replace_Check2($Contents);


if($mode=="New") {

	$Sql = "INSERT INTO CounselPhone(ID, Name, Category, Contents, RegDate, Status, Del) VALUES('$ID', '$Name', '$Category', '$Contents', NOW(), '$Status', 'N')";
	$Row = mysqli_query($connect, $Sql);

}

if($mode=="Edit") {

	$Sql = "UPDATE CounselPhone SET Name='$Name', Category='$Category', Contents='$Contents', Status='$Status' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

}

if($mode=="Delete") {

	$Sql = "UPDATE CounselPhone SET Del='Y' WHERE idx=$idx";
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