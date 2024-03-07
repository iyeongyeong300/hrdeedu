<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$ParentCategory = Replace_Check($ParentCategory);
$Deep = Replace_Check($Deep);
$CategoryName = Replace_Check($CategoryName);
$OrderByNum = Replace_Check($OrderByNum);
$UseYN = Replace_Check($UseYN);
$CategoryType = Replace_Check($CategoryType);

$cmd = false;

//신규 등록---------------------------------------------------
if($mode=="New") {

	$maxno = max_number("idx","CourseCategory");

	$Sql = "INSERT INTO CourseCategory(idx, ParentCategory, Deep, CategoryName, OrderByNum, UseYN, Del, CategoryType) 
				VALUES($maxno, $ParentCategory, $Deep, '$CategoryName', $OrderByNum, '$UseYN', 'N', '$CategoryType')";
	//echo $Sql;
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}
//신규 등록---------------------------------------------------

//수정---------------------------------------------------
if($mode=="Edit") {
	$Sql = "UPDATE CourseCategory SET ParentCategory=$ParentCategory, Deep=$Deep, CategoryName='$CategoryName', OrderByNum=$OrderByNum, UseYN='$UseYN', CategoryType='$CategoryType' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
}
//수정---------------------------------------------------


//삭제---------------------------------------------------
if($mode=="Del") {

	$Sql = "UPDATE CourseCategory SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}
//삭제---------------------------------------------------


if($Row && $cmd) {
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