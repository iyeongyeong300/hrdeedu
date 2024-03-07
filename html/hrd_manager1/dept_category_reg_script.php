<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Dept = Replace_Check($Dept);
$ParentCategory = Replace_Check($ParentCategory);
$Deep = Replace_Check($Deep);
$DeptString = Replace_Check($DeptString);
$TopMenuGrant = Replace_Check($TopMenuGrant);
$SubMenuGrant = Replace_Check($SubMenuGrant);
$DeptName = Replace_Check($DeptName);


$cmd = false;

//신규 등록---------------------------------------------------
if($mode=="New") {

	$maxno = max_number("idx","DeptStructure");


	if($DeptString) {
		$DeptString = $DeptString.$maxno."|";
	}else{
		$DeptString = $maxno."|";
	}

	$Deep2 = $Deep + 1;

	$Sql = "INSERT INTO DeptStructure(idx, Dept, ParentCategory, Deep, DeptName, DeptString, TopMenuGrant, SubMenuGrant, SiteCode) 
				VALUES($maxno, '$Dept', $ParentCategory, $Deep2, '$DeptName', '$DeptString', '$TopMenuGrant', '$SubMenuGrant', '$SiteCode')";
	//echo $Sql;
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}
//신규 등록---------------------------------------------------

//수정---------------------------------------------------
if($mode=="Edit") {
	$Sql = "UPDATE DeptStructure SET DeptName='$DeptName', TopMenuGrant='$TopMenuGrant', SubMenuGrant='$SubMenuGrant' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
}
//수정---------------------------------------------------


//삭제---------------------------------------------------
if($mode=="Del") {

	$Sql = "SELECT COUNT(*) FROM DeptStructure WHERE ParentCategory=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$TOT_NO = $Row[0];

	if($TOT_NO>0) {
?>
<script type="text/javascript">
<!--
	alert("하부에 등록된 카테고리가 존재합니다.");
	self.close();
//-->
</script>
<?
	exit;
	}

	mysqli_free_result($Result);


	$Sql = "DELETE FROM DeptStructure WHERE idx=$idx";
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