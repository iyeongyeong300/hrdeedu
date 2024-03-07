<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
?>
<!-- layer Ask -->
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:PlayInfoClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title" id="drag">학습내용 질문하기</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>질문내용은 강사님 확인 후 <span class="fcSky01B">나의 강의실 &gt; 자료/상담관리</span>에서 확인하실 수 있습니다.</li>
			</ul>
		</div>
		<form name="CounselForm" method="POST" action="/player/study_counsel_ok.php" target="ScriptFrame">
		<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
		<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
		<input type="hidden" name="Contents_idx" id="Contents_idx" value="<?=$Contents_idx?>">
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <caption>학습내용 질문하기</caption>
			  <colgroup>
				  <col width="16%" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td class="item">제목</td>
				<td><input type="text" name="Title" id="Title" placeholder="제목 입력" class="widp100" /></td>
			  </tr>
			  <tr>
				<td class="item">문의종류</td>
				<td>
					<select name="Category" id="Category"  class="wid400">
						<option value="">선택하세요</option>
						<?
						while (list($key,$value)=each($Counsel_array)) {
						?>
					   <option value="<?=$key?>"><?=$value?></option>
						<?
						}
						?>
					</select>
				</td>
			  </tr>
			  <tr>
				<td colspan="2"><textarea name="Contents" id="Contents" rows="14" class="widp100" placeholder="내용 입력"></textarea></td>
			  </tr>
			</table>
		</div>
		</form>
		
		<!-- btn -->
		<p class="btnAreaTc02" id="SubmitBtn"><span class="btnSmSky01"><a href="Javascript:PlayStudyCounselSubmit();">질문하기</a></span></p>
		<p id="WaitMag" style="display:none"><br>처리중입니다. 기다려 주세요.</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Ask // -->
<script type="text/javascript">
<!--
$(document).ready(function() {

	$("#drag").css("cursor","move");

	$("#drag").mouseover(function(){
		$("div[id='StudyInformation']").draggable();
		$("div[id='StudyInformation']").draggable("option","disabled",false);
	})

	$("#drag").mouseleave(function(){
		$("div[id='StudyInformation']").draggable("option","disabled",true);
	});

});
//-->
</script>