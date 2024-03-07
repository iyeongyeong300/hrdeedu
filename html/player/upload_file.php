<?
include "../include/include_function.php";

$Expl = Replace_Check($Expl);
$File = Replace_Check($File);
?>
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:UploadFileClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">첨부파일 업로드</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>첨부파일을 선택하여 업로드하세요.</li>
			</ul>
		</div>
		<form name="UploadForm1" method="post" action="/player/upload_file_ok.php" enctype="multipart/form-data" target="ScriptFrame">
		<INPUT TYPE="hidden" name="Expl" id="Expl" value="<?=$Expl?>">
		<INPUT TYPE="hidden" name="File" id="File" value="<?=$File?>">
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <caption>첨부파일 업로드</caption>
			  <colgroup>
				  <col width="16%" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td class="item">첨부파일</td>
				<td><input name="file" id="file" type="file"  class="widp100" style="font-family:'Nanum Gothic','나눔고딕','맑은 고딕','Malgun Gothic','돋움','dotum'; color:#555; font-size:14px; border:solid 1px #cecece; vertical-align:middle;"></td>
			  </tr>
			</table>
		</div>
		</form>
		
		<!-- btn -->
		<p class="btnAreaTc02" id="UpBtn01"><span class="btnSmSky01"><a href="Javascript:UploadFileSubmitOk();">확인</a></span></p>
		<p id="UpBtn02" style="display:none"><br>처리중입니다. 기다려 주세요.</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>