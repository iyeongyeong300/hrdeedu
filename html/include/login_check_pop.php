<?
if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	alert("로그인후에 이용하세요.");
	//opener.location.href="/member/login.php";
	opener.location.href="/new/member/login.html";
	self.close();
//-->
</script>
<?
exit;
}
?>