<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$str = Replace_Check($str);

if($str=="A") {
	$ExamBankRegResult = "대기";
}
if($str=="B") {
	$ExamBankRegResult = "<font color='blue'>등록</font>";
}
if($str=="C") {
	$ExamBankRegResult = "<font color='red'>오류</font>";
}
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
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
	val.action = "exam_bank_select_delete.php";
	$("#BtnDelete").prop("disabled",true);
	$("#BtnSubmit").prop("disabled",true);
	val.submit();
}

}
//-->
</script>
		<br><br>
		<div style="text-align:left">
		* 붉은색으로 표시된 항목은 오류가 예상되는 항목입니다.<br>
		* 상태 설명 : 대기(엑셀을 업로드 후 등록 대기 상태), 처리중(DB 입력 처리중), 등록(정상적으로 등록 완료), 오류(DB입력 오류)<br><br>
		</div>
		<form name="Form2" method="post" target="ScriptFrame">
			<input type="hidden" name="idx_value" id="idx_value">
			<input type="hidden" name="mode" id="mode">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="view_ty01">
			<colgroup>
			<col width="30px" />
			<col width="40px" />
			<col width="" />
			<col width="80px" />
			<col width="" />
			<col width="" />
			<col width="300px" />
			<col width="400px" />
			<col width="50px" />
		  </colgroup>
		  <tr>
			<th rowspan="2"><input type="checkbox" name="cj" id="cj" onclick="CheckAll()" style="width:17px; height:17px; background:none; border:none;"></th>
			<th rowspan="2">번호</th>
			<th>차시 구분</th>
			<th>문제유형</th>
			<th>보기 1</th>
			<th>보기 2</th>
			<th>정답</th>
			<th>해답 설명</th>
			<th rowspan="2">상태</th>
		  </tr>
		  <tr>
			<th colspan="2" style="border-left:1px solid #ccc;">질문</th>
			<th>보기 3</th>
			<th>보기 4</th>
			<th>보기 5</th>
			<th>채점기준(서술형)</th>
		  </tr>
		<?
		$error_count = 0;
		$i = 1;
		$bgcolor = "";

		$SQL = "SELECT * FROM ExamBankExcelTemp WHERE ID='$LoginAdminID' ORDER BY idx ASC";
		$QUERY = mysqli_query($connect, $SQL);
		if($QUERY && mysqli_num_rows($QUERY))
		{
			while($ROW = mysqli_fetch_array($QUERY))
			{
				extract($ROW);

				if($i%2==0) {
					$bgcolor = "#ffffff";
				}else{
					$bgcolor = "#f0f0f0";
				}
				
				if(!$Gubun) {
					$str_Gubun = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					$str_Gubun = $Gubun;
				}

				if(!$ExamType) {
					$str_ExamType = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					if($ExamType!="A" && $ExamType!="B" && $ExamType!="C") {
						$str_ExamType = "<font color='red'>".$ExamType."</font>";
						$error_count++;
					}else{
						$str_ExamType = $ExamType_array[$ExamType];
					}
				}

				if(!$Question) {
					$str_Question = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					$str_Question = $Question;
				}

				if($ExamType == "A") {

					if(!$Example01) {
						$str_Example01 = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Example01 = $Example01;
					}

					/*
					if(!$Example02) {
						$str_Example02 = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Example02 = $Example02;
					}

					if(!$Example03) {
						$str_Example03 = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Example03 = $Example03;
					}

					if(!$Example04) {
						$str_Example04 = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Example04 = $Example04;
					}

					if(!$Example05) {
						$str_Example05 = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Example05 = $Example05;
					}
					*/
				}


				if($ExamType == "A") {

					if(!$Answer) {
						$str_Answer = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Answer = $Answer;
					}

				}else{
					if(!$Answer2) {
						$str_Answer = "<font color='red'>미입력</font>";
						$error_count++;
					}else{
						$str_Answer = nl2br($Answer2);
					}
				}

		?>
		<tr style="background-color:<?=$bgcolor?>;" >
			<td rowspan="2" style="text-align:center"><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" style="width:17px; height:17px; background:none; border:none;"><br><img src="images/btn_edit04.gif" style="padding-top:5px; cursor:pointer" onclick="ExamBankRegEdit('<?=$idx?>');"><?//=$idx?></td>
			<td rowspan="2" style="text-align:center"><?=$i?></td>
			<td><?=$str_Gubun?></td>
			<td style="text-align:center"><?=$str_ExamType?></td>
			<td><?=$str_Example01?></td>
			<td><?=$Example02?></td>
			<td style="text-align:center"><?=$str_Answer?></td>
			<td><?=$Comment?></td>
			<td rowspan="2" style="text-align:center"><span id="ExamBankRegResult"><?=$ExamBankRegResult?></span></td>
		</tr>
		<tr style="background-color:<?=$bgcolor?>;" >
			<td colspan="2" style="border-left:1px solid #ccc;"><?=$Question?></td>
			<td><?=$Example03?></td>
			<td><?=$Example04?></td>
			<td><?=$Example05?></td>
			<td><?=$ScoreBasis?></td>
		</tr>
		<?
			$i++;
			}
		}else{
		?>
		<tr>
			<td height="50" colspan="14" style="text-align:center">업로드한 엑셀파일이 없습니다.</td>
		</tr>
		<? } ?>
		</table>
		</form>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
			<tr>
				<td width="150" style="text-align:left"><input type="button" id="BtnDelete" value="선택항목 삭제" onclick="CheckedDelete()" class="btn_inputLine01"></td>
				<td align="center" valign="top">
				<?if($error_count>0) {?>
				<span class="redB">오류 건수가 [ <?=number_format($error_count,0)?> ]건이 있습니다. </span>
				<?}else{?>
				<input type="button" id="BtnSubmit" value="문제 등록하기" onclick="ExamBankRegistSubmitOk()" class="btn_inputBlue01">
				<?}?>
				</td>
				<td width="150" align="right" valign="top">&nbsp;</td>
			</tr>
		</table>
<?
mysqli_close($connect);
?>