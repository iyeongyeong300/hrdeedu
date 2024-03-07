<?
$REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
$PageUrl = $REQUEST_URI[0];
$PageUrl = str_replace("/refund/","",$PageUrl);
$PageUrl = str_replace(".php","",$PageUrl);


switch($PageUrl) {
	case "employinsure":
		$HTML_TITLE = "고용보험환급안내 > 고용보험환급안내";
		$TabCss01 = " class='show'";
	break;
	case "employer":
		$HTML_TITLE = "사업주과정안내 > 고용보험환급안내";
		$TabCss02 = " class='show'";
	break;
	case "card":
		$HTML_TITLE = "내일배움카드안내 > 고용보험환급안내";
		$TabCss03 = " class='show'";
	break;
	case "guide":
		$HTML_TITLE = "교육유의사항 > 고용보험환급안내";
		$TabCss04 = " class='show'";
	break;
	case "coursestep":
		$HTML_TITLE = "교육진행절차 > 고용보험환급안내";
		$TabCss05 = " class='show'";
	break;
	case "edumanage":
		$HTML_TITLE = "교육운영관리 > 고용보험환급안내";
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
	<h2>고용보험환급안내</h2>
	<!-- menu -->
	<div class="submenuArea">
		<ul class="depth">
			<li><a href="employinsure.php" <?=$TabCss01?>>고용보험환급안내</a></li>
			<li><a href="employer.php" <?=$TabCss02?>>사업주과정안내</a></li>
			<li><a href="card.php" <?=$TabCss03?>>내일배움카드안내</a></li>
			<li><a href="guide.php" <?=$TabCss04?>>교육유의사항</a></li>
			<li><a href="coursestep.php" <?=$TabCss05?>>교육진행절차</a></li>
			<li><a href="edumanage.php" <?=$TabCss06?>>교육운영관리</a></li>
		</ul>
	</div>
	<!-- menu // -->
	
	<!-- CS -->
	<?
	include "../support/include_cs.php";
	?>
	<!-- CS // -->
</div>