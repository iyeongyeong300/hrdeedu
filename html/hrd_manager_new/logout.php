<?
include "../include/include_function.php"; 

setCookie("LoginAdminID","",0);
setCookie("LoginAdminName","",0);
setCookie("LoginAdminDepart","",0);
setCookie("LoginAdminDept","",0);
setCookie("LoginAdminDeptString","",0);
setCookie("LoginAdminTopMenuGrant","",0);
setCookie("LoginAdminSubMenuGrant","",0);
setCookie("LoginDate","",0);

unset($_SESSION["LoginAdminID"]);

mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href="./index.php";
//-->
</SCRIPT>
