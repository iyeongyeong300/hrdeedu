<?
if($_SESSION['IsPlaying'] == 'Y') {
	// echo "_SESSION['IsPlaying: ".$_SESSION['IsPlaying'];	
?>
<script type="text/javascript">
<!--
	//console.log ('IsPlaying ==== Y');
	alert ('2개 이상의 강의를 동시에 수강할 수 없습니다.');
	//top.location.href="/member/login.php";
	top.location.href="/new/member/login.html";
//-->
</script>
<?
	exit;
}
else {
	// echo "_SESSION['IsPlaying']: ".$_SESSION['IsPlaying'];
}
?>