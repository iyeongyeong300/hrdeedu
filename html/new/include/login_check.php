<?
if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	top.location.href="/new/member/login.html";
//-->
</script>
<?
exit;
}
?>