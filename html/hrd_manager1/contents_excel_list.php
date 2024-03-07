<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$str = Replace_Check($str);

if($str=="A") {
	$ContentsRegResult = "대기";
}
if($str=="B") {
	$ContentsRegResult = "<font color='blue'>등록</font>";
}
if($str=="C") {
	$ContentsRegResult = "<font color='red'>오류</font>";
}
?>
<!-- <script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript">
<!--
	function CheckAll() {

	val = document.Form2;

	checkbox_count = $("input[id='check_seq']").length;
	//alert(checkbox_count);


	if(checkbox_count==0) {
		alert("등록된 엑셀파일이 없습니다.");
		return;
	}

	if(checkbox_count > 1) {
		for (i=0; i<val.check_seq.length; i++) {
		if (val.cj.checked == true) {
			if(val.check_seq[i].disabled == false) {
				val.check_seq[i].checked = true;
			}
		}else{
			val.check_seq[i].checked = false;
		}
	}

	}else{
		if (val.cj.checked == true) {
			if(val.check_seq.disabled == false) {
				val.check_seq.checked = true;
			}
		}else{
			val.check_seq.checked = false;
		}

	}

}

function CheckedDelete() {

val = document.Form2;

checkbox_count = $("input[id='check_seq']").length;
//alert(checkbox_count);


if(checkbox_count==0) {
	alert("등록된 엑셀파일이 없습니다.");
	return;
}

var idx_value = "";

if(checkbox_count > 1) {
	for (i=0; i<val.check_seq.length; i++) {
		if(val.check_seq[i].checked == true) {
			idx_value += val.check_seq[i].value + "|";
		}
	}
}else{
	if(val.check_seq.checked == true) {
		idx_value += val.check_seq.value + "|";
	}
}

if(idx_value=="") {
	alert("삭제하려는 항목을 선택하세요.");
	return;
}

Yes = confirm("선택한 항목을 삭제하시겠습니까?");
if(Yes==true) {
	val.idx_value.value = idx_value;
	val.mode.value = "del";
	val.action = "contents_select_delete.php";
	$("#BtnDelete").prop("disabled",true);
	$("#BtnSubmit").prop("disabled",true);
	val.submit();
}

}
//-->
</script>
<br><br>
<div class="tl pt15">
* 붉은색으로 표시된 항목은 오류가 예상되는 항목입니다.<br>
* 상태 설명 : 대기(엑셀을 업로드 후 등록 대기 상태), 처리중(DB 입력 처리중), 등록(정상적으로 등록 완료), 오류(DB입력 오류)
</div>

<form name="Form2" method="post" target="ScriptFrame">
	<input type="hidden" name="idx_value" id="idx_value">
	<input type="hidden" name="mode" id="mode">
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
  <colgroup>
	<col width="30px" />
	<col width="40px" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="50px" />
  </colgroup>
  <tr>
	<th><input type="checkbox" name="cj" id="cj" onclick="CheckAll()" style="width:17px; height:17px; background:none; border:none;"></th>
	<th>번호</th>
	<th>차시 구분</th>
	<th>차시명</th>
	<th>수강시간</th>
	<th>차시 목표</th>
	<th>훈련 내용</th>
	<th>학습 활동</th>
	<th>상태</th>
  </tr>
<?
$error_count = 0;
$i = 1;
$bgcolor = "";

$SQL = "SELECT * FROM ContentsExcelTemp WHERE ID='$LoginAdminID' ORDER BY idx ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);

		if($i%2==0) {
			$bgcolor = "#f0f0f0";
		}else{
			$bgcolor = "#ffffff";
		}
		
		if(!$Gubun) {
			$str_Gubun = "<font color='red'>미입력</font>";
			$error_count++;
		}else{
			$str_Gubun = $Gubun;
		}

		if(!$ContentsTitle) {
			$str_ContentsTitle = "<font color='red'>미입력</font>";
			$error_count++;
		}else{
			$str_ContentsTitle = $ContentsTitle;
		}

		if(!$LectureTime) {
			$str_LectureTime = "<font color='red'>미입력</font>";
			$error_count++;
		}else{
			$str_LectureTime = $LectureTime;
		}

		if(!$Expl01) {
			$str_Expl01 = "<font color='red'>미입력</font>";
			$error_count++;
		}else{
			$str_Expl01 = $Expl01;
		}

		if(!$Expl02) {
			$str_Expl02 = "<font color='red'>미입력</font>";
			$error_count++;
		}else{
			$str_Expl02 = $Expl02;
		}

		if(!$Expl03) {
			$str_Expl03 = "<font color='red'>미입력</font>";
			$error_count++;
		}else{
			$str_Expl03 = $Expl03;
		}

?>
<tr bgcolor="<?=$bgcolor?>" >
	<td align="center" class="text01"><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" style="width:17px; height:17px; background:none; border:none;"><br><img src="images/btn_edit04.gif" style="padding-top:5px; cursor:pointer" onclick="ContentsRegEdit('<?=$idx?>');"><?//=$idx?></td>
	<td align="center"><?=$i?></td>
	<td align="left"><?=$str_Gubun?></td>
	<td align="left"><?=$str_ContentsTitle?></td>
	<td align="center"><?=$str_LectureTime?></td>
	<td align="left"><?=nl2br($str_Expl01)?></td>
	<td align="left"><?=nl2br($str_Expl02)?></td>
	<td align="left"><?=nl2br($str_Expl03)?></td>
	<td align="center"  class="text01"><span id="ContentsRegResult"><?=$ContentsRegResult?></span></td>
</tr>
<?
	$i++;
	}
}else{
?>
<tr>
	<td height="50" align="center" bgcolor="#FFFFFF" class="text01" colspan="20">업로드한 엑셀파일이 없습니다.</td>
</tr>
<? } ?>
</table>
</form>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
		<td height="15">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="150" valign="top"><input type="button" id="BtnDelete" value="선택항목 삭제" onclick="CheckedDelete()" class="btn_inputLine01"></td>
		<td align="center" valign="top">
		<?if($error_count>0) {?>
		<span class="redB">오류 건수가 [ <?=number_format($error_count,0)?> ]건이 있습니다. </span>
		<?}else{?>
		<input type="button" id="BtnSubmit" value="차시 등록하기" onclick="ContentsRegistSubmitOk()" class="btn_inputBlue01">
		<?}?>
		</td>
		<td width="150" align="right" valign="top">&nbsp;</td>
	</tr>
</table>
<?
mysqli_close($connect);
?>