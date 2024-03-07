<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Price = Replace_Check_XSS2($Price);

$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsName = html_quote($Row['ContentsName']); //과정명
}

if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	alert("로그인후에 수강신청이 가능합니다.");
	DataResultClose();
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
function LectureRequestSubmitOk() {

	var checked_value = $(':radio[name="LectureDate"]:checked').val();
	var checked_length = $(':radio[name="LectureDate"]').length;

	if(checked_length==0) {
		alert("등록된 교육기간 존재하지 않아 학습신청을 할수 없습니다.");
		return;
	}

	if(checked_value==undefined) {
		alert("교육기간을 선택하세요.");
		return;
	}
	

	Yes = confirm("신청하시겠습니까?");
	if(Yes==true) {
		RequestForm.submit();
	}

}
//-->
</script>
<!-- layer Lecture App -->
<div class="layerArea wid500">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="../images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">학습신청</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="lecLine">
			<p class="lecT"><?=$ContentsName?></p>
		</div>
		<form name="RequestForm" method="POST" action="/include/lecture_request_ok.php" target="ScriptFrame">
		<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
		<input type="hidden" name="Price" id="Price" value="<?=$Price?>">
		<div class="info mt20">
			<ul class="radioList fs16b">
				<?
				$i = 0;
				$NowDate = date("Y-m-d");
				$SQL = "SELECT DISTINCT LectureStart, LectureEnd FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart>'$NowDate' ORDER BY LectureStart ASC, LectureEnd ASC LIMIT 0,3";
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY))
				{
					while($ROW = mysqli_fetch_array($QUERY))
					{
						extract($ROW);
				?>
				<li><span class="inpRadio">
					  <input type="radio" name="LectureDate" id="LectureDate<?=$i?>" value="<?=$LectureStart?>|<?=$LectureEnd?>">
					  <label for="LectureDate<?=$i?>"><?=$LectureStart?> ~ <?=$LectureEnd?></label>
					</span>
				</li>
				<?
				$i++;
					}
				}else{
				?>
				<li>신청 가능한 교육 기간이 없습니다.</li>
				<?
				}
				?>
			</ul>
		</div>
		</form>
		<!-- btn -->
		<p class="btnAreaTc02">
			<span class="btnSmSky01"><a href="Javascript:LectureRequestSubmitOk();">학습신청</a></span>
			<span class="btnSmGray01"><a href="Javascript:DataResultClose();">취소</a></span>
		</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Lecture App // -->
<?
}

mysqli_close($connect);
?>