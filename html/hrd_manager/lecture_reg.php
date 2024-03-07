<?
$MenuType = "A";
$PageName = "lecture_reg";
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

Switch ($mode) {
	case "new":
		$ScriptTitle = "등록";
	break;
	case "edit":
		$ScriptTitle = "수정";
	break;
	case "del":
		$ScriptTitle = "삭제";
	break;
}
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강등록 개별 등록</h2>

            <div class="conZone">
            	<!-- ## START -->
<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#LectureStart, #LectureEnd, #ExcelLectureStart, #ExcelLectureEnd").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$("#LectureStart, #LectureEnd, #ExcelLectureStart, #ExcelLectureEnd").val("");
	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
	
	ExcelServiceTypeSelected();
	$("#LectureCode, #ExcelLectureCode, #ExcelTutor").select2();
	changeSelect2Style();
});
//-->
</script>

<SCRIPT LANGUAGE="JavaScript">
<!--
function SubmitOk() {

	val = document.Form1;

	if(val.LectureStart.value=="") {
		alert("수강기간을 선택하세요.");
		return;
	}

	if(val.LectureEnd.value=="") {
		alert("수강기간을 선택하세요.");
		return;
	}

	if(val.LectureReStudyMonth.value=="") {
		alert("복습기간을 입력하세요.");
		return;
	}

	if(IsNumber(val.LectureReStudyMonth.value)==false) {
		alert("복습기간은 숫자만 입력하세요.");
		return;
	}

	if($("#UserID").length<1 || $("#UserID").val()=="") {
		alert("수강생을 검색하세요.");
		return;
	}

	if($("#Tutor").length<1 || $("#Tutor").val()=="") {
		alert("첨삭강사를 검색하세요.");
		return;
	}

	if($("#SalesManagerTemp").length<1 || $("#SalesManagerTemp").val()=="") {
		alert("영업담당자를 검색하세요.");
		return;
	}


	if(val.OpenChapter.value=="") {
		alert("실시회차를 입력하세요.");
		return;
	}

	if(IsNumber(val.OpenChapter.value)==false) {
		alert("실시회차는 숫자만 입력하세요.");
		return;
	}


	Yes = confirm("등록 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

function UploadSubmitOk() {

	val = document.ExcelUpForm;
	/*if((val.ExcelLectureStart.value=="")||(val.ExcelLectureEnd.value=="")){
		alert("수강 기간을 선택하세요.");
		return;
	}*/
	
	if(val.file.value=="") {
		alert("엑셀 파일을 선택하세요.");
		val.file.focus();
		return;
	}

	Yes = confirm("업로드 하시겠습니까?");
	if(Yes==true) {
		$("#UploadSubmitBtn").hide();
		$("#UploadWaiting").show();
		val.submit();
	}
}

function ExcelServiceTypeSelected(){
	var excelServiceType = $("#ExcelServiceType option:selected").val();
	
	if((excelServiceType == '1')||(excelServiceType == '3')) { //일반(비환급)
		$(".excelQT").hide();
		$(".excelLC").show();
	}else if(excelServiceType == '5'){ //비환급(평가있음)
		$(".excelQT").show();
		$(".excelLC").hide();
	}
}

//-->
</SCRIPT>
                <!-- 입력 -->
<form name="Form1" method="post" action="lecture_reg_script.php" target="ScriptFrame">
	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
	  <colgroup>
		<col width="120px" />
		<col width="" />
		<col width="120px" />
		<col width="" />
	  </colgroup>
		<tr>
			<th>수강 기간</th>
			<td><input name="LectureStart" id="LectureStart" type="text" size="12" value="" readonly>  ~  <input name="LectureEnd" id="LectureEnd" type="text" size="12" value="" readonly></td>
			<th>복습 기간</td>
			<td>종료일로부터 <input name="LectureReStudyMonth" id="LectureReStudyMonth" type="text" value="2" size="3" maxlength="2"> 개월</td>
		</tr>
		<tr>
			<th>과정 선택</font></th>
			<td>
			<select name="LectureCode" id="LectureCode" onchange="LectureCodeSelected()">
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
				<option value="<?=$ROW['LectureCode']?>"><?=$ROW['ContentsName']?> | <?=$ROW['LectureCode']?> | <?=$PackageYN?> | <?=$ServiceType2?></option>
			<?
				}
			}
			?>
			</select>
			</td>
			<th>비용수급사업장</t>
			<td><input type="text" name="nwIno" id="nwIno" size="20" value=""></td>
		</tr>
		<tr>
			<th>수강생</th>
			<td><input type="text" name="TempSearchID" id="TempSearchID" size="20"> <button type="button" onclick="LectureRegIDSearch()" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;<span id="SearchIDResult"></span></td>
			<th>첨삭 강사</th>
			<td><input type="text" name="TempSearchTutor" id="TempSearchTutor" size="20"> <button type="button" onclick="LectureRegTutorSearch()" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;<span id="SearchTutorResult"></span></td>
		</tr>
		<tr>
			<th>영업 담당자</th>
			<td>
			<input name="SalesName" id="SalesName" type="text"  size="20" value="<?=$SalesName?>"> <button type="button" onclick="SalesManagerSearch();" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;&nbsp;<span id="SalesManagerHtml"></span>
			</td>
			<th>진도율</th>
			<td>
			<select name="Progress" id="Progress" style="width:100px">
				<option value="0">0%</option>
				<option value="50">50%</option>
				<option value="80">80%</option>
				<option value="100">100%</option>
			</select>
			</td>
		</tr>
		<tr>
			<th>개설 용도</th>
			<td bgcolor="#FFFFFF">
			<select name="ServiceType" id="ServiceType" style="width:150px">
				<?
				while (list($key,$value)=each($ServiceType_array)) {
					?>
				<option value="<?=$key?>"><?=$value?></option>
				<?
				}
				reset($ServiceType_array);
				?>
			</select>
			</td>
			<th>실시 회차</th>
			<td><input type="text" name="OpenChapter" id="OpenChapter" size="10" value="1"></td>
		</tr>
	</table>
	<!--페이지 버튼 -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>&nbsp;</td>
			<td height="15">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="100" valign="top">&nbsp;</td>
			<td align="center" valign="top">
			<span id="SubmitBtn"><button type="button" onclick="SubmitOk()" class="btn btn_Blue">등록 하기</button></span>
			<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
			</td>
			<td width="100" align="right" valign="top">&nbsp;</td>
		</tr>
	</table>
	</form>

	<div class="btnAreaTl02">
	<span class="fs16b fc333B sub_title2">수강등록 엑셀파일로 등록</span>
	</div>

	<form name="ExcelUpForm" method="post" action="lecture_reg_excel_upload.php" enctype="multipart/form-data" target="ScriptFrame">
	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
		<colgroup>
			<col width="7%" />
			<col width="33%" />
			<col width="7%" />
			<col width="53%" />
		</colgroup>
		<tr style="display:none">
			<th>수강 기간</th>
			<td>
				<input name="ExcelLectureStart" id="ExcelLectureStart" type="text" size="12" value="" readonly>  ~  <input name="ExcelLectureEnd" id="ExcelLectureEnd" type="text"  size="12" value="" readonly>
			</td>
			<th>첨삭강사</th>
			<td>
				<select name="ExcelTutor" id="ExcelTutor" >
					<optgroup label="-- 이름 | 아이디 | 소속 --">
					<?
					$SQL2 = "SELECT * FROM StaffInfo WHERE Del='N' AND UseYN='Y' AND Dept='C' ORDER BY Name ASC";
					$QUERY2 = mysqli_query($connect, $SQL2);
					if($QUERY2 && mysqli_num_rows($QUERY2))
					{
						$i = 1;
						while($Row2 = mysqli_fetch_array($QUERY2))
						{

						?>
						<option value="<?=$Row2['ID']?>"><?=$Row2['Name']?> | <?=$Row2['ID']?> | <?=$Row2['Team']?></option>
						<?
						$i++;
						}
					}else{
					?>
					<option value="">검색된 첨삭강사가 없습니다.</option>
					<?
					}
					?>
				</select>
			</td>
		</tr>
		<tr style="display:none">
			<th>환급 여부</th>
			<td align="left">
				<select name="ExcelServiceType" id="ExcelServiceType" style="width:150px" onchange="ExcelServiceTypeSelected()">
					<?
					while (list($key,$value)=each($ServiceType3_array)) {
						?>
						<option value="<?=$key?>"><?=$value?></option>
					<?
					}
					reset($ServiceType3_array);
					?>
				</select>
			</td>
			<th class="excelLC">과정명</th>
			<td class="excelLC">
				<select name="ExcelLectureCode" id="ExcelLectureCode" >
					<optgroup label="-- 과 정 명 | 과정 코드 --">
					<?
					$SQL3 = "SELECT * FROM Course WHERE Del='N' ORDER BY ContentsName ASC";
					//$SQL3 = "SELECT * FROM Course WHERE LectureCode IN ('LAW03', 'SAFEAE', 'SAFEBE', 'SAFECE', 'SAFEDE', 'SAFEEE', 'SAFEFE') AND Del='N' AND ServiceType = '3' ORDER BY ContentsName ASC";
					$QUERY3 = mysqli_query($connect, $SQL3);
					if($QUERY3 && mysqli_num_rows($QUERY3))
					{
						$i = 1;
						while($Row3 = mysqli_fetch_array($QUERY3))
						{

						?>
						<option value="<?=$Row3['LectureCode']?>"><?=$Row3['ContentsName']?> | <?=$Row3['LectureCode']?> </option>
						<?
						$i++;
						}
					}
					?>
				</select>
			</td>
			<th class="excelQT">분기</th>
			<td class="excelQT">
				<select name="ExcelQuaterType" id="ExcelQuaterType" style="width:150px">
					<?
					while (list($key,$value)=each($QuaterType_array)) {
					?>
						<option value="<?=$key?>"><?=$value?></option>
					<?
					}
					reset($QuaterType_array);
					?>
				</select>
			</td>
		</tr>
		<tr>
			<th>파일 등록</th>
			<td align="left"> <input name="file" id="file" type="file" size="60">
				<span id="UploadSubmitBtn"><button type="button" onclick="UploadSubmitOk()" class="btn round btn_Blue line"><i class="xi-upload"></i> 업로드 하기</button></span>
				<span id="UploadWaiting" style="display:none"><strong>처리중입니다. 잠시만 기다려 주세요...</strong></span>
			</td>
			<th>등록 샘플</th>
			<td align="left">
				<button type="button" onclick="location.href='./sample/수강등록.xlsx'" class="btn round btn_Green line"><i class="xi-download"></i> 양식 다운로드</button>
				<button type="button" onclick="location.href='./sample/수강등록(샘플).xlsx'" class="btn round btn_Green line"><i class="xi-download"></i> 샘플 다운로드</button>
			</td>
		</tr>
	</table>
	</form>
	<div id="ExcelUploadList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>
	<!--컨텐츠 e--></td>
		</tr>
	</table>
	<script type="text/javascript">
	<!--
	$(window).load(function() {
		ExcelUploadListRoading('A');
	});
	//-->
	</script>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>