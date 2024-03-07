<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Dept_idx = Replace_Check($Dept_idx);
$DeptString = Replace_Check($DeptString);

$DeptStringName = DeptStringNaming($DeptString);

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	opener.$("#Dept_idx").val('<?=$Dept_idx?>');
	opener.$("#DeptString").val('<?=$DeptString?>');
	opener.$("#DeptValueSelectResult").html('<?=$DeptStringName?>');
	self.close();
//-->
</SCRIPT>