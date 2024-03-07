<?
if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	location.href="logout.php";
//-->
</script>
<?
exit;
}
?>