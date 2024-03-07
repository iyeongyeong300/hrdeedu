<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$send_mode = Replace_Check($send_mode);
$TutorRemark 	= Replace_Check($TutorRemark);
 
  

if($send_mode=="update") {

	 
	$Sql = "UPDATE DiscussionAnswer Set TutorRemark='$TutorRemark' , RegDate2= now() WHERE idx=$idx ";
	$Row = mysqli_query($connect, $Sql);
	

}
 
if($Row ) {
	$ProcessOk = "Y";
	$msg = " 등록되었습니다 .";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.DataResultClose();
	<?}?>
//-->
</SCRIPT>