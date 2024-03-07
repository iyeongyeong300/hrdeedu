<script type="text/javascript">
<!--
$(document).ready(function(){

	//동영상 종료시 다음 영상 재생
	var Player2 = document.getElementById("mPlayer");

	Player2.onended = function() {

		var ContentsMobilePage = parseInt($("#ContentsMobilePage").val());
		var ContentsMobileNowPage = parseInt($("#ContentsMobileNowPage").val());

		if(ContentsMobilePage>ContentsMobileNowPage) {
			PlayNext();
		}

	};

});
//-->
</script>
<!-- clip -->
<div class="clipArea mt20">
	<div class="clip" id="MovieDiv"><?=$PlayerFunction?></div>
	<!-- arr -->
	<div class="arr">
		<span><a href="Javascript:PlayPrev();" id="PrevBtn" style="display:none"><img src="images/common/btn_play_prev01.png" alt="이전"></a></span>
		<span><strong id="PageDisplay">1</strong> / <?=$ContentsMobilePage?></span>
		<span><?if($ContentsMobilePage>1) {?><a href="Javascript:PlayNext();" id="NextBtn"><img src="images/common/btn_play_next01.png" alt="다음"></a><?}?></span>
	</div>
	<!-- arr // -->
</div>
<!-- clip // -->

<!-- Tab -->
<div class="viewTab">
	<ul class="area">
		<li><a href="Javascript:StudyProgressCheck('End','Y');">과정목록</a></li>
		<?if($attachFile) {?><li><a href="./include/lecture_download.php?LectureCode=<?=$LectureCode?>">학습자료 다운로드</a></li><?}?>
	</ul>
</div>
<!-- Tab // -->

<input type="hidden" name="ContentsMobilePage" id="ContentsMobilePage" value="<?=$ContentsMobilePage?>">
<input type="hidden" name="ContentsMobileNowPage" id="ContentsMobileNowPage" value="1">
<input type="hidden" name="PlayPath" id="PlayPath" value="<?=$PlayPath?>">

<!-- info -->
<div class="infoArea">
	<ul>
		<li>
			<p><span>학습 시간</span></p>
			<input name="StudyTimeNow" id="StudyTimeNow" type="text" value="00:00:00" style="width:95px; border:none; color:#ff3c00; font-weight:bold; font-size:20px; text-align:center; vertical-align:middle;" />
			<input type="hidden" name="StartTime" id="StartTime" value="<?=$StudyTime?>"><!-- 초기 수강시간 시작 초 -->
		</li>
		<li>
			<p><span>내용전문가</span></p>
			<?=$Professor?>
		</li>
		<li>
			<p><span>차시목표</span></p>
			<?=$Expl01?>
		</li>
		<li>
			<p><span>훈련내용</span></p>
			<?=$Expl02?>
		</li>
		<li>
			<p><span>학습활동</span></p>
			<?=$Expl03?>
		</li>
	</ul>
</div>
<!-- info // -->