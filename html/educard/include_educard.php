<?
$REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
$PageUrl = $REQUEST_URI[0];
$PageUrl = str_replace("/educard/","",$PageUrl);
$PageUrl = str_replace(".php","",$PageUrl);


switch($PageUrl) {
	case "course":
		$HTML_TITLE = "내일배움카드 > 내일배움카드 소개";
		$TabCss01 = " class='show'";
	break;
	case "course":
		$HTML_TITLE = "내일배움카드 > 내일배움카드 소개";
		$TabCss01 = " class='show'";
	break;
	case "course":
		$HTML_TITLE = "내일배움카드 > 내일배움카드 발급";
		$TabCss02 = " class='show'";
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
	<h2>내일배움카드</h2>
	<!-- menu -->
	<div class="submenuArea">
		<!--
		<ul class="depth">
			<?
			$SQL = "SELECT * FROM CourseCategory WHERE Deep=2 AND ParentCategory=$Menu03ParentCategory AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
			//echo $SQL;
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
			?>
			<li><a href="/educard/course.php?Category=<?=$ROW['idx']?>" <?if($ROW['idx']==$Category) {?>class="show"<?}?>><?=$ROW['CategoryName']?></a></li>
			<?
				}
			}
			?>
		</ul>
		-->
		<ul class="depth">
			<li><a href="/educard/course_01.php" <?=$TabCss01?>>내일배움카드 소개</a></li>
			<li><a href="https://www.hrd.go.kr/hrdp/ma/pmmao/indexNew.do" <?=$TabCss02?>>내일배움카드 발급</a></li>
		</ul>
	</div>
	<!-- menu // -->
	
	<!-- CS -->
	<!--
	<?
	include "../educard/include_cs.php";
	?>
	-->
	<!-- CS // -->

</div>