<?
if(!$LoginAdminID) {
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href="./logout.php";
//-->
</SCRIPT>
<?
exit;
}

//���� ���� �ο�
if($LoginAdminDept=="A") { //������
	$AdminWrite = "Y";
}
if($LoginAdminDept=="B") { //�������
	$AdminWrite = "N";
}
if($LoginAdminDept=="C") { //÷�谭��
	$AdminWrite = "Y";
}
?>