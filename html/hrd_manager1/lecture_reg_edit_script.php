<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx2);
$LectureCode = Replace_Check($LectureCode2);
$Tutor = Replace_Check($Tutor2);
$Name = Replace_Check($Name2);
$ResNo = Replace_Check($ResNo2);
$Mobile = Replace_Check($Mobile2);
$Email = Replace_Check($Email2);
$CompanyCode = Replace_Check($CompanyCode2);
$Depart = Replace_Check($Depart2);
$LectureStart = Replace_Check($LectureStart2);
$LectureEnd = Replace_Check($LectureEnd2);
$LectureReStudy = Replace_Check($LectureReStudy2);
$Price = Replace_Check($Price2);
$rPrice = Replace_Check($rPrice2);
$ServiceType = Replace_Check($ServiceType2);
$UserID = Replace_Check($UserID2);
$Pwd = Replace_Check($Pwd2);
$nwIno = Replace_Check($nwIno2);
$trneeSe = Replace_Check($trneeSe2);
$IrglbrSe = Replace_Check($IrglbrSe2);
$OpenChapter = Replace_Check($OpenChapter2);
$SalesID = Replace_Check($SalesID2);
$EduManager = Replace_Check($EduManager2);
$tok2ID = Replace_Check($tok2ID);


$Sql = "UPDATE StudyExcelTemp SET 
			LectureCode='$LectureCode', Tutor='$Tutor', Name='$Name', ResNo='$ResNo', Mobile='$Mobile', 
			Email='$Email', CompanyCode='$CompanyCode', Depart='$Depart', LectureStart='$LectureStart', 
			LectureEnd='$LectureEnd', LectureReStudy='$LectureReStudy', Price='$Price', rPrice='$rPrice', 
			ServiceType='$ServiceType', UserID='$UserID', Pwd='$Pwd', nwIno='$nwIno', trneeSe='$trneeSe', 
			IrglbrSe='$IrglbrSe', OpenChapter='$OpenChapter', SalesID='$SalesID', EduManager='$EduManager', tok2ID='$tok2ID'  
			WHERE idx=$idx AND ID='$LoginAdminID'";
//echo $Sql;
$Row = mysqli_query($connect, $Sql);

if($Row) {
	$ProcessOk = "Y";
	$msg = "수정 되었습니다.";
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
	<?if($ProcessOk=="Y") {?>
	top.DataResultClose();
	top.ExcelUploadListRoading('A');
	<?}?>
//-->
</SCRIPT>