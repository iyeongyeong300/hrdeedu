<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);


$Sql = "SELECT * FROM StudyExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$LectureCode = $Row['LectureCode']; //과정 코드
	$Tutor = $Row['Tutor']; //첨삭 강사
	$Name = $Row['Name']; //수강생 성명
	$ResNo = $Row['ResNo']; //주민번호
	$Mobile = $Row['Mobile']; //휴대폰
	$Email = $Row['Email']; //이메일
	$CompanyCode = $Row['CompanyCode']; //사업자번호
	$Depart = $Row['Depart']; //부서명
	$LectureStart = $Row['LectureStart']; //강의 시작일
	$LectureEnd = $Row['LectureEnd']; //강의 종료일
	$LectureReStudy = $Row['LectureReStudy']; //복습종료일
	$Price = $Row['Price']; //수강금액
	$rPrice = $Row['rPrice']; //환급액
	$ServiceType = $Row['ServiceType']; //서비스 구분
	$UserID = $Row['UserID']; //수강생 아이디
	$Pwd = $Row['Pwd']; //비밀번호
	$nwIno = $Row['nwIno']; //비용수급사업장
	$trneeSe = $Row['trneeSe']; //훈련생구분
	$IrglbrSe = $Row['IrglbrSe']; //비정규직구분
	$OpenChapter = $Row['OpenChapter']; //실시회차
	$SalesID = $Row['SalesID']; //영업자 아이디
	$EduManager = $Row['EduManager']; //교육담당자 여부
	$tok2ID = $Row['tok2ID']; //tok2 아이디
}

if(!$LectureReStudy) {
	$indate_str = strtotime($LectureEnd."2 month");
	$LectureReStudy = date("Y-m-d",$indate_str);
}

if(!$OpenChapter) {
	$OpenChapter = "1";
}

if(!$Price || !$rPrice) {

	//사업주 정보 불러오기
	$Sql = "SELECT CompanyScale, CompanyID FROM Company WHERE CompanyCode='$CompanyCode'";
	//echo $Sql;
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CompanyScale = $Row['CompanyScale']; //사업자 규모
		$CompanyID = $Row['CompanyID']; //사업주 아이디
	}

	//교육과정 정보를 불러오기
	$Sql = "SELECT Price, Price01, Price02, Price03 FROM Course WHERE LectureCode='$LectureCode'";
	//echo $Sql."<BR>";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$PriceB = $Row['Price']; //교육비용
		$Price01 = $Row['Price01']; ///우선지원 환급비
		$Price02 = $Row['Price02']; ///대규모 1000인 미만 환급비
		$Price03 = $Row['Price03']; ///대규모 1000인 이상 환급비
	}

	$Price = $PriceB;

	//사업장 규모별 환급비용을 선정
	switch($CompanyScale) {
		case "A": //대규모 1000인 이상
			$rPrice = $Price03;
		break;
		case "B": //대규모 1000인 미만
			$rPrice = $Price02;
		break;
		case "C": //우선지원대상
			$rPrice = $Price01;
		break;
		default:
			$rPrice = "0";
	}

}

if(!$Price) {
	$Price = "0";
}
if(!$rPrice) {
	$rPrice = "0";
}
?>
<!-- <script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script> -->
<script type="text/javascript">
<!--
$(document).ready(function(){

	$("#LectureStart2").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#LectureStart2').val("<?=$LectureStart?>");

	$("#LectureEnd2").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#LectureEnd2').val("<?=$LectureEnd?>");

	$("#LectureReStudy2").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#LectureReStudy2').val("<?=$LectureReStudy?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});

function LectureEditSubmitOk() {

	val = document.EditForm;
	
	if($("#idx2").val()=="") {
		alert("오류가 발생했습니다.");
		DataResultClose();
		ExcelUploadListRoading('A');
		return;
	}
	if($("#Tutor2").val()=="") {
		alert("첨삭강사 아이디를 입력하세요.");
		return;
	}
	if($("#Name2").val()=="") {
		alert("수강생 이름을 입력하세요.");
		return;
	}
	if($("#ResNo2").val()=="") {
		alert("주민등록번호를 입력하세요.");
		return;
	}
	if($("#Mobile2").val()=="") {
		alert("휴대폰을 입력하세요.");
		return;
	}
	if($("#CompanyCode2").val()=="") {
		alert("사업자번호를 입력하세요.");
		return;
	}
	if($("#LectureStart2").val()=="") {
		alert("수강 기간을 입력하세요.");
		return;
	}
	if($("#LectureEnd2").val()=="") {
		alert("수강 기간을 입력하세요.");
		return;
	}
	/*
	if($("#LectureReStudy2").val()=="") {
		alert("복습 기간을 입력하세요.");
		return;
	}
	if($("#Price2").val()=="") {
		alert("수강금액을 입력하세요.");
		return;
	}
	if($("#rPrice2").val()=="") {
		alert("환급액을 입력하세요.");
		return;
	}
	*/
	if($("#SalesID2").val()=="") {
		alert("영업담당자 아이디를 입력하세요.");
		return;
	}
	if($("#UserID2").val()!="") {
		if(ID_Validity($("#UserID2").val())==false) {
			return;
		}
	}
	if($("#OpenChapter2").val()!="") {
		if(IsNumber($("#OpenChapter2").val())==false) {
			alert("실시회차는 숫자만 입력하세요.");
			return;
		}
	}

	Yes = confirm("수정하시겠습니까?");
	if(Yes==true) {
		val.submit();
	}

}
//-->
</script>
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>업로드한 엑셀파일 수정</h2>
		
		<div class="conZone">
			<!-- ## START -->
			
			<form name="EditForm" method="post" action="lecture_reg_edit_script.php" target="ScriptFrame">
			<input type="hidden" name="idx2" id="idx2" value="<?=$idx?>">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
			  <colgroup>
				<col width="120px" />
				<col width="" />
				<col width="120px" />
				<col width="" />
				<col width="120px" />
				<col width="" />
			  </colgroup>
			  <tr>
				<th>과정 선택</th>
				<td align="left" colspan="5">
				<select name="LectureCode2" id="LectureCode2">
					<optgroup label="-- 과 정 명 | 과정 코드 | 패키지 여부 | 서비스 구분 --">
				<?
				$SQL = "SELECT * FROM Course WHERE Del='N' ORDER BY PackageYN DESC, ContentsName ASC";
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY))
				{
					while($ROW = mysqli_fetch_array($QUERY))
					{
						if($ROW['PackageYN']=="Y") {
							$PackageYN = "패키지";
							$ServiceType2 = "";
						}else{
							$PackageYN = "단과";
							$ServiceType2 = $ServiceTypeCourse_array[$ROW['ServiceType']];
						}
				?>
					<option value="<?=$ROW['LectureCode']?>" <?if($ROW['LectureCode']==$LectureCode) {?>selected<?}?>><?=$ROW['ContentsName']?> | <?=$ROW['LectureCode']?> | <?=$PackageYN?> | <?=$ServiceType2?></option>
				<?
					}
				}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<th>첨삭 강사</th>
				<td align="left"><input type="text" name="Tutor2" id="Tutor2" size="20" value="<?=$Tutor?>"></td>
				<th>수강생 이름</th>
				<td align="left"><input type="text" name="Name2" id="Name2" size="20" value="<?=$Name?>"></td>
				<th>주민등록번호</th>
				<td align="left"><input type="text" name="ResNo2" id="ResNo2" size="20"  value="<?=$ResNo?>"></td>
			</tr>
			<tr>
				<th>휴대폰</th>
				<td align="left"><input type="text" name="Mobile2" id="Mobile2" size="20" value="<?=$Mobile?>"></td>
				<th>이메일</th>
				<td align="left"><input type="text" name="Email2" id="Email2" size="20" value="<?=$Email?>"></td>
				<th>사업자번호</th>
				<td align="left"><input type="text" name="CompanyCode2" id="CompanyCode2" size="20" value="<?=$CompanyCode?>"></td>
			</tr>
			<tr>
				<th>부서명</th>
				<td align="left"><input type="text" name="Depart2" id="Depart2" size="35" value="<?=$Depart?>"></td>
				<th>수강 기간</th>
				<td align="left"><input name="LectureStart2" id="LectureStart2" type="text"  size="12" value="" readonly>  ~ <input name="LectureEnd2" id="LectureEnd2" type="text"  size="12" value="" readonly></td>
				<th>복습 기간</th>
				<td align="left"><input name="LectureReStudy2" id="LectureReStudy2" type="text"  size="12" value="" readonly></td>
			</tr>
			<tr>
				<th>수강금액</th>
				<td align="left"><input type="text" name="Price2" id="Price2" size="20" value="<?=$Price?>"></td>
				<th>환급액</th>
				<td align="left"><input type="text" name="rPrice2" id="rPrice2" size="20" value="<?=$rPrice?>"></td>
				<th>서비스구분</th>
				<td align="left">
					<select name="ServiceType2" id="ServiceType2" style="width:150px">
						<?
						while (list($key,$value)=each($ServiceType_array)) {
							?>
						<option value="<?=$key?>" <?if($ServiceType==$key){?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($ServiceType_array);
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th>아이디</th>
				<td align="left"><input type="text" name="UserID2" id="UserID2" size="20" value="<?=$UserID?>"></td>
				<th>비밀번호</th>
				<td align="left"><input type="text" name="Pwd2" id="Pwd2" size="20" value="<?=$Pwd?>"></td>
				<th>비용수급사업장</th>
				<td align="left"><input type="text" name="nwIno2" id="nwIno2" size="35" value="<?=$nwIno?>"></td>
			</tr>
			<tr>
				<th>훈련생구분</th>
				<td align="left"><input type="text" name="trneeSe2" id="trneeSe2" size="35" value="<?=$trneeSe?>"></td>
				<th>비정규직구분</th>
				<td align="left"><input type="text" name="IrglbrSe2" id="IrglbrSe2" size="35" value="<?=$IrglbrSe?>"></td>
				<th>실시회차</th>
				<td align="left"><input type="text" name="OpenChapter2" id="OpenChapter2" size="10" value="<?=$OpenChapter?>"></td>
			</tr>
			<tr>
				<th>영업담당자</th>
				<td align="left"><input type="text" name="SalesID2" id="SalesID2" size="20" value="<?=$SalesID?>"></td>
				<th>교육담당자 여부</th>
				<td align="left">
				<select name="EduManager2" id="EduManager2" style="width:150px">
						<?
						while (list($key,$value)=each($UseYN_array)) {
							?>
						<option value="<?=$key?>" <?if($EduManager==$key){?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($UseYN_array);
						?>
					</select>
				</td>
				<th> </th>
				<td align="left"> </td>
			</tr>
			</table>
			</form>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
					<span id="EditSubmitBtn"><input type="button" value="수정 하기" onclick="LectureEditSubmitOk()" class="btn_inputBlue01"></span>
					<span id="EditWaiting" style="display:none"><strong>처리중입니다...</strong></span>
					</td>
					<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>

			
			<!-- ## END -->
		</div>
		<!-- ########## // -->
	</div>

</div>

<?
mysqli_close($connect);
?>