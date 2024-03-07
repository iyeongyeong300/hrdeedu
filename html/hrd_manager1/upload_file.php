<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Ele = Replace_Check($Ele);
$EleArea = Replace_Check($EleArea);
$FileType = Replace_Check($FileType);
?>
<div class="btnAreaTl02">
	<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">파일 업로드</span>
</div>
<form name="UploadForm1" method="post" action="upload_file_ok.php" enctype="multipart/form-data" target="ScriptFrame">
	<INPUT TYPE="hidden" name="Ele" id="Ele" value="<?=$Ele?>">
	<INPUT TYPE="hidden" name="EleArea" id="EleArea" value="<?=$EleArea?>">
	<INPUT TYPE="hidden" name="FileType" id="FileType" value="<?=$FileType?>">
<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
	<colgroup>
		<col width="120px" />
		<col width="" />
	  </colgroup>
	<tr>
		<th>파일 선택</th>
		<td ><input name="file" id="file" type="file"  size="80"></td>
	</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
		<td height="15">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="150" valign="top">&nbsp;</td>
		<td align="center" valign="top">
		<span id="SubmitBtn2"><input type="button" value="등록 하기" onclick="UploadFileSubmitOk()" class="btn_inputBlue01"></span>
		<span id="Waiting2" style="display:none"><strong>처리중입니다...</strong></span>
		</td>
		<td width="150" align="right" valign="top"><input type="button" value="닫기" onclick="DataResultClose();" class="btn_inputLine01"></td>
	</tr>
</table>
</form>