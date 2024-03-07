<?
$REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
$PageUrl = $REQUEST_URI[0];
$PageUrl = str_replace("/support/","",$PageUrl);
$PageUrl = str_replace(".php","",$PageUrl);


switch($PageUrl) {
	case "notice":
		$HTML_TITLE = "공지사항 > 학습지원센터";
		$TabCss01 = " class='show'";
	break;
	case "notice_view":
		$HTML_TITLE = "공지사항 > 학습지원센터";
		$TabCss01 = " class='show'";
	break;
	case "faq":
		$HTML_TITLE = "자주묻는질문 > 학습지원센터";
		$TabCss02 = " class='show'";
	break;
	case "edudata":
		$HTML_TITLE = "학습자료실 > 학습지원센터";
		$TabCss03 = " class='show'";
	break;
	case "edudata_view":
		$HTML_TITLE = "학습자료실 > 학습지원센터";
		$TabCss03 = " class='show'";
	break;
	case "ask":
		$HTML_TITLE = "1:1 문의 > 학습지원센터";
		$TabCss04 = " class='show'";
	break;
	case "prodown":
		$HTML_TITLE = "학습지원 다운로드 > 학습지원센터";
		$TabCss05 = " class='show'";
	break;
	case "remote":
		$HTML_TITLE = "PC 원격지원 > 학습지원센터";
		$TabCss06 = " class='show'";
	break;
	case "mycheck":
		$HTML_TITLE = "본인인증 안내 > 학습지원센터";
		$TabCss07 = " class='show'";
	break;

}

$HTML_TITLE = $BOARD_TITLE.$HTML_TITLE." > ".$SiteName;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).attr("title","<?=$HTML_TITLE?>");
//-->
</SCRIPT>
<div class="leftArea" id="LeftMenuGo">
	<!-- title -->
	<h2>학습지원도구</h2>
	<!-- menu -->
	<div class="submenuArea">
		<ul class="depth">
			<li><a href="notice.php" <?=$TabCss01?>>공지사항</a></li>
			<li><a href="faq.php" <?=$TabCss02?>>자주묻는 질문</a></li>
			<li><a href="edudata.php" <?=$TabCss03?>>학습자료실</a></li>
			<li><a href="ask.php" <?=$TabCss04?>>1:1 문의</a></li>
			<li><a href="prodown.php" <?=$TabCss05?>>학습지원 다운로드</a></li>
			<li><a href="remote.php" <?=$TabCss06?>>PC 원격지원</a></li>
			<li><a href="mycheck.php" <?=$TabCss07?>>본인인증 안내</a></li>
		</ul>
	</div>
	<!-- menu // -->
	
	<!-- CS -->
	<?
	include "../support/include_cs.php";
	?>
	<!-- CS // -->
</div>