<?
$REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
$PageUrl = $REQUEST_URI[0];
$PageUrl = str_replace("/group/","",$PageUrl);
$PageUrl = str_replace(".php","",$PageUrl);


switch($PageUrl) {
	case "introduce":
		$HTML_TITLE = "교육원소개 > 교육원소개";
		$TabCss01 = " class='show'";
	break;
	case "greetings":
		$HTML_TITLE = "인사말 > 교육원소개";
		$TabCss02 = " class='show'";
	break;
	case "vision":
		$HTML_TITLE = "비전 > 교육원소개";
		$TabCss03 = " class='show'";
	break;
	case "organogram":
		$HTML_TITLE = "조직도 > 교육원소개";
		$TabCss04 = " class='show'";
	break;
	case "history":
		$HTML_TITLE = "연혁 > 교육원소개";
		$TabCss05 = " class='show'";
	break;
	case "location":
		$HTML_TITLE = "오시는 길 > 교육원소개";
		$TabCss06 = " class='show'";
	break;

}

$HTML_TITLE = $HTML_TITLE." > ".$SiteName;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).attr("title","<?=$HTML_TITLE?>");
//-->
</SCRIPT>
<div class="leftArea" id="LeftMenuGo">
	<!-- title -->
	<h2>교육원소개</h2>
	<!-- menu -->
	<div class="submenuArea">
		<ul class="depth">
			<li><a href="introduce.php" <?=$TabCss01?>>교육원소개</a></li>
			<!-- <li><a href="greetings.php" <?=$TabCss02?>>인사말</a></li> -->
			<li><a href="vision.php" <?=$TabCss03?>>비전</a></li>
			<li><a href="organogram.php" <?=$TabCss04?>>조직도</a></li>
			<li><a href="history.php" <?=$TabCss05?>>연혁</a></li>
			<li><a href="location.php" <?=$TabCss06?>>오시는 길</a></li>
		</ul>
	</div>
	<!-- menu // -->
	
	<!-- CS -->
	<?
	include "../support/include_cs.php";
	?>
	<!-- CS // -->
</div>