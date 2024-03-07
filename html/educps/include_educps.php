<?
$Category = Replace_Check_XSS2($Category);

if($Category) {
	$Sql = "SELECT * FROM CourseCategory WHERE Deep=2 AND ParentCategory=$Menu01ParentCategory AND idx=$Category AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
}else{
	$Sql = "SELECT * FROM CourseCategory WHERE Deep=2 AND ParentCategory=$Menu01ParentCategory AND Del='N' ORDER BY OrderByNum ASC, idx ASC LIMIT 0,1";
}
// echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CategoryName = $Row['CategoryName'];
	$Category = $Row['idx'];
}


$HTML_TITLE = $CategoryName." > 법정의무교육 > ".$SiteName;
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).attr("title","<?=$HTML_TITLE?>");
//-->
</SCRIPT>
<div class="leftArea" id="LeftMenuGo">
	<!-- title -->
	<h2>법정의무교육</h2>
	<!-- menu -->
	<div class="submenuArea">
		<ul class="depth">
			<?
			$SQL = "SELECT * FROM CourseCategory WHERE Deep=2 AND ParentCategory=$Menu01ParentCategory AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
			// echo $SQL;
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
			?>
			<li><a href="/educps/course.php?Category=<?=$ROW['idx']?>" <?if($ROW['idx']==$Category) {?>class="show"<?}?>><?=$ROW['CategoryName']?></a></li>
			<?
				}
			}
			?>
		</ul>
	</div>
	<!-- menu // -->
	
	<!-- CS -->
	<?
	include "../support/include_cs.php";
	?>
	<!-- CS // -->
</div>