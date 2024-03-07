<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$str = Replace_Check($str);

if($str=="A") {
	$LectureRegResult = "대기";
}
if($str=="B") {
	$LectureRegResult = "<font color='blue'>등록</font>";
}
if($str=="C") {
	$LectureRegResult = "<font color='red'>오류</font>";
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
	val.action = "lecture_reg_select_delete.php";
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
		* 상태 설명 : 대기(엑셀을 업로드 후 수강등록 대기 상태), 처리중(DB 입력 처리중), 등록(정상적으로 등록 완료), 오류(회원가입오류, DB입력 오류, 동일한 과정·수간기간·서비스 구분이 이미 등록되어 있는 경우)
		</div>
		<form name="Form2" method="post" target="ScriptFrame">
			<input type="hidden" name="idx_value" id="idx_value">
			<input type="hidden" name="mode" id="mode">
		<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
		<thead>
		  <tr>
			<th rowspan="2"><input type="checkbox" name="cj" id="cj" onclick="CheckAll()" class="checkbox"></th>
			<th rowspan="2">번호</th>
			<th>과정코드</td>
			<th>첨삭강사</td>
			<th>이름</td>
			<th>주민등록번호</td>
			<th>휴대폰</td>
			<th>이메일</td>
			<th>사업자번호</td>
			<th>부서명</td>
			<th>수강시작일</td>
			<th>수강종료일</td>
			<th>복습종료일</td>
			<th rowspan="2">상태</th>
		  </tr>
		  <tr>
			<th style="border-left:solid 1px #fff">수강금액</td>
			<th>환급액</td>
			<th>서비스구분</td>
			<th>아이디</td>
			<th>비밀번호</td>
			<th>비용수급사업장</td>
			<th>훈련생구분</td>
			<th>비정규직구분</td>
			<th>실시회차</td>
			<th>영업담당자</td>
			<th>교육담당자 여부</td>
		  </tr>
		</thead>
		<?
		$error_count = 0;
		$i = 1;
		$bgcolor = "";
		/*
		$SQL = "SELECT *, 
					(SELECT COUNT(LectureCode) FROM Course WHERE LectureCode=StudyExcelTemp.LectureCode) AS LectureCodeCount,
					(SELECT COUNT(CompanyCode) FROM Company WHERE CompanyCode=StudyExcelTemp.CompanyCode) AS CompanyCodeCount,
					(SELECT COUNT(ID) FROM StaffInfo WHERE ID=StudyExcelTemp.Tutor AND Dept='C') AS TutorCount,
					(SELECT COUNT(ID) FROM StaffInfo WHERE ID=StudyExcelTemp.SalesID AND Dept='B') AS SalesIDCount 
					FROM StudyExcelTemp WHERE ID='$LoginAdminID' ORDER BY idx ASC";
		*/
		$SQL = "SELECT a.*, b.LectureCode AS LectureCode2, c.CompanyCode AS CompanyCode2, d.ID AS Tutor2, e.ID AS SalesID2 
					FROM StudyExcelTemp a 
					LEFT OUTER JOIN Course b ON a.LectureCode=b.LectureCode 
					LEFT OUTER JOIN Company c ON a.CompanyCode=c.CompanyCode 
					LEFT OUTER JOIN StaffInfo d ON a.Tutor=d.ID AND d.Dept='C' 
					LEFT OUTER JOIN StaffInfo e ON a.SalesID=e.ID AND e.Dept='B' 
					WHERE a.ID='$LoginAdminID' ORDER BY idx ASC";
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
				
				//과정코드 체크
				if(!$LectureCode) {
					$str_LectureCode = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					if(!$LectureCode2) {
						$str_LectureCode = "<font color='red'>".$LectureCode."</font>";
						$error_count++;
					}else{
						$str_LectureCode = $LectureCode;
					}
				}
				
				//첨삭강사 체크
				if(!$Tutor) {
					$str_Tutor = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					if(!$Tutor2) {
						$str_Tutor = "<font color='red'>".$Tutor."</font>";
						$error_count++;
					}else{
						$str_Tutor = $Tutor;
					}
				}
				
				//이름 체크
				if(!$Name) {
					$str_Name= "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					$str_Name = $Name;
				}
				
				//주민번호 체크
				$ResNo_array = explode("-",$ResNo);
				if(!is_numeric($ResNo_array[0]) || strlen($ResNo_array[0]) != 6 || !is_numeric($ResNo_array[1]) || strlen($ResNo_array[1]) != 7) {
					$str_ResNo = "<font color='red'>".$ResNo."</font>";
					$error_count++;
				}else{
					$str_ResNo = $ResNo;
				}
				
				//사업자번호 체크
				if(!$CompanyCode) {
					$str_CompanyCode = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					if(!$CompanyCode2) {
						$str_CompanyCode = "<font color='red'>".$CompanyCode."</font>";
						$error_count++;
					}else{
						$str_CompanyCode = $CompanyCode;
					}
				}
				
				//수강시작일 체크
				$LectureStart_array = explode("-",$LectureStart);
				if(!$LectureStart || !is_numeric($LectureStart_array[0]) || strlen($LectureStart_array[0]) != 4 || !is_numeric($LectureStart_array[1]) || strlen($LectureStart_array[1]) != 2 || !is_numeric($LectureStart_array[2]) || strlen($LectureStart_array[2]) != 2 || checkdate($LectureStart_array[1], $LectureStart_array[2], $LectureStart_array[0])==false) {
					$str_LectureStart = "<font color='red'>".$LectureStart."</font>";
					$error_count++;
				}else{
					$str_LectureStart = $LectureStart;
				}
				
				//수강종료일 체크
				$LectureEnd_array = explode("-",$LectureEnd);
				if(!$LectureEnd || !is_numeric($LectureEnd_array[0]) || strlen($LectureEnd_array[0]) != 4 || !is_numeric($LectureEnd_array[1]) || strlen($LectureEnd_array[1]) != 2 || !is_numeric($LectureEnd_array[2]) || strlen($LectureEnd_array[2]) != 2 || checkdate($LectureEnd_array[1], $LectureEnd_array[2], $LectureEnd_array[0])==false) {
					$str_LectureEnd = "<font color='red'>".$LectureEnd."</font>";
					$error_count++;
				}else{
					$str_LectureEnd = $LectureEnd;
				}
				
				//복습종료일 체크
				if($LectureReStudy) {
					$LectureReStudy_array = explode("-",$LectureReStudy);
					if(!$LectureReStudy || !is_numeric($LectureReStudy_array[0]) || strlen($LectureReStudy_array[0]) != 4 || !is_numeric($LectureReStudy_array[1]) || strlen($LectureReStudy_array[1]) != 2 || !is_numeric($LectureReStudy_array[2]) || strlen($LectureReStudy_array[2]) != 2 || checkdate($LectureReStudy_array[1], $LectureReStudy_array[2], $LectureReStudy_array[0])==false) {
						$str_LectureReStudy = "<font color='red'>".$LectureReStudy."</font>";
						$error_count++;
					}else{
						$str_LectureReStudy = $LectureReStudy;
					}
				}else{
					$indate_str = strtotime($LectureEnd."2 month");
					$str_LectureReStudy = date("Y-m-d",$indate_str);
				}

				//수강료 체크
				if($Price) {
					if(!is_numeric($Price)) {
						$str_Price = "<font color='red'>".$Price."</font>";
						$error_count++;
					}else{
						$str_Price = $Price;
					}
				}else{
					$str_Price = $Price;
				}
				//환급액 체크
				if($rPrice) {
					if(!is_numeric($rPrice)) {
						$str_rPrice = "<font color='red'>".$rPrice."</font>";
						$error_count++;
					}else{
						$str_rPrice = $rPrice;
					}
				}else{
					$str_rPrice = $rPrice;
				}
				//서비스 구분 체크
				if(!$ServiceType) {
					$str_ServiceType = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					if($ServiceType_array[$ServiceType]=="") {
						$str_ServiceType = "<font color='red'>".$ServiceType."</font>";
						$error_count++;
					}else{
						$str_ServiceType = $ServiceType;
					}
				}
				//실시회차 체크
				if(!$OpenChapter) {
					$str_OpenChapter = $OpenChapter;
				}else{
					if(!is_numeric($OpenChapter)) {
						$str_OpenChapter = "<font color='red'>".$OpenChapter."</font>";
						$error_count++;
					}else{
						$str_OpenChapter = $OpenChapter;
					}
				}
				//영업담당자 체크
				if(!$SalesID) {
					$str_SalesID = "<font color='red'>미입력</font>";
					$error_count++;
				}else{
					if(!$SalesID2) {
						$str_SalesID = "<font color='red'>".$SalesID."</font>";
						$error_count++;
					}else{
						$str_SalesID = $SalesID;
					}
				}
				//교육담당자 여부 체크
				if(!$EduManager) {
					$str_EduManager = $EduManager;
				}else{
					if($EduManager!="Y" && $EduManager!="N") {
						$str_EduManager = "<font color='red'>".$EduManager."</font>";
						$error_count++;
					}else{
						$str_EduManager = $EduManager;
					}
				}

				if(!$UserID) {
					$UserID = "자동 설정";
				}
				
		?>
		<tr bgcolor="<?=$bgcolor?>" >
			<td align="center" class="text01" rowspan="2"><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" class="checkbox"><br><img src="images/btn_edit04.gif" style="padding-top:5px; cursor:pointer" onclick="LectureRegEdit('<?=$idx?>');"><?//=$idx?></td>
			<td rowspan="2"><?=$i?></td>
			<td><?=$str_LectureCode?></td>
			<td><?=$str_Tutor?></td>
			<td><?=$str_Name?></td>
			<td><?=$str_ResNo?></td>
			<td><?=$Mobile?></td>
			<td><?=$Email?></td>
			<td><?=$str_CompanyCode?></td>
			<td><?=$Depart?></td>
			<td><?=$str_LectureStart?></td>
			<td><?=$str_LectureEnd?></td>
			<td><?=$str_LectureReStudy?></td>
			<td rowspan="2"><span id="LectureRegResult"><?=$LectureRegResult?></span></td>
		</tr>
		<tr bgcolor="<?=$bgcolor?>" >
			<td><?=$str_Price?></td>
			<td><?=$str_rPrice?></td>
			<td><?=$str_ServiceType?></td>
			<td><?=$UserID?></td>
			<td><?=$Pwd?></td>
			<td><?=$nwIno?></td>
			<td><?=$TRNEE_SE_array[$trneeSe]?></td>
			<td><?=$IRGLBR_SE_array[$IrglbrSe]?></td>
			<td><?=$str_OpenChapter?></td>
			<td><?=$str_SalesID?></td>
			<td><?=$str_EduManager?></td>
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
				<td width="150" valign="top"><button type="button" id="BtnDelete" onclick="CheckedDelete()" class="btn btn_DGray line">선택항목 삭제</button></td>
				<td align="center" valign="top">
				<?if($error_count>0) {?>
				<span class="redB">오류 건수가 [ <?=number_format($error_count,0)?> ]건이 있습니다. </span>
				<?}else{?>
				<button type="button" id="BtnSubmit" onclick="LectureRegistSubmitOk()" class="btn btn_Blue">수강 등록하기</button>
				<?}?>
				</td>
				<td width="150" align="right" valign="top">&nbsp;</td>
			</tr>
		</table>
<?
mysqli_close($connect);
?>