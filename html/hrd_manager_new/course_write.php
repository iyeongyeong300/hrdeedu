<?
$MenuType = "D";
$PageName = "course";
$ReadPage = "course_read";
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);


if(!$mode) {
	$mode = "new";
}

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

if($ctype_session=="A") {
	$CompanyScaleTitle01 = "우선지원";
	$CompanyScaleTitle02 = "대규모 1000인 미만";
	$CompanyScaleTitle03 = "대규모 1000인 이상";
}

if($ctype_session=="B") {
	$CompanyScaleTitle01 = "일반훈련생";
	$CompanyScaleTitle02 = "취업성공패키지";
	$CompanyScaleTitle03 = "근로장려금";
}
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>단과 컨텐츠 관리 [<?=$CategoryType_array[$ctype_session]?>] <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM Course WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$ClassGrade = $Row['ClassGrade']; //등급
		$LectureCode = $Row['LectureCode']; //과정코드
		$UseYN = $Row['UseYN']; //사이트 노출
		$PassCode = $Row['PassCode']; //심사코드
		$HrdCode = $Row['HrdCode']; //HRD-NET 과정코드
		$Category1 = $Row['Category1']; //과정분류 대분류
		$Category2 = $Row['Category2']; //과정분류 소분류
		$ServiceType = $Row['ServiceType']; //서비스 구분
		$ContentsName = html_quote($Row['ContentsName']); //과정명
		$CompleteTime = $Row['CompleteTime']; //진도시간 기준
		$ProgressCheck = $Row['ProgressCheck']; //진도체크방식
		$Chapter = $Row['Chapter']; //차시수
		$ContentsTime = $Row['ContentsTime']; //교육시간
		$Price = $Row['Price']; //교육비용 일반
		$Price01 = $Row['Price01']; //자부담금 환급비용 우선지원 
		$Price02 = $Row['Price02']; //자부담금 환급비용 대규모 1000인 미만 
		$Price03 = $Row['Price03']; //자부담금 환급비용 대규모 1000인 이상 
		$Price01View = $Row['Price01View']; //환급비용 우선지원 
		$Price02View = $Row['Price02View']; //환급비용 대규모 1000인 미만 
		$Price03View = $Row['Price03View']; //환급비용 대규모 1000인 이상 
		$Professor = $Row['Professor']; //내용전문가 
		$Limited = $Row['Limited']; //학급정원
		$ContentsPeriod = substr($Row['ContentsPeriod'],0,10); //컨텐츠 유효기간
		$ContentsAccredit = substr($Row['ContentsAccredit'],0,10); //인정만료일 시작일
		$ContentsExpire = substr($Row['ContentsExpire'],0,10); //인정만료일 종료일
		$Cp = html_quote($Row['Cp']); //cp사
		$Commission = $Row['Commission']; //cp 수수료
		$Mobile = $Row['Mobile']; //모바일 지원
		$BookPrice = $Row['BookPrice']; //교재비
		$BookIntro = html_quote($Row['BookIntro']); //참고도서설명
		$attachFile = html_quote($Row['attachFile']); //학습자료
		$PreviewImage = html_quote($Row['PreviewImage']); //과정 이미지
		$BookImage = html_quote($Row['BookImage']); //교재 이미지
		$Mid01EA = $Row['Mid01EA']; //중간평가 객관식 문항수
		$Mid01Score = $Row['Mid01Score']; //중간평가 객관식 배점
		$Mid02EA = $Row['Mid02EA']; //중간평가 단답형 문항수
		$Mid02Score = $Row['Mid02Score']; //중간평가 단답형 배점
		$Mid03EA = $Row['Mid03EA']; //중간평가 서술형 문항수
		$Mid03Score = $Row['Mid03Score']; //중간평가 서술형 배점
		$Test01EA = $Row['Test01EA']; //최종평가 객관식 문항수
		$Test01Score = $Row['Test01Score']; //최종평가 객관식 배점
		$Test02EA = $Row['Test02EA']; //최종평가 단답형 문항수
		$Test02Score = $Row['Test02Score']; //최종평가 단답형 배점
		$Test03EA = $Row['Test03EA']; //최종평가 서술형 문항수
		$Test03Score = $Row['Test03Score']; //최종평가 서술형 배점
		$Report01EA = $Row['Report01EA']; //과제 객관식 문항수
		$Report01Score = $Row['Report01Score']; //과제 객관식 배점
		$Report02EA = $Row['Report02EA']; //과제 단답형 문항수
		$Report02Score = $Row['Report02Score']; //과제 단답형 배점
		$Report03EA = $Row['Report03EA']; //과제 서술형 문항수
		$Report03Score = $Row['Report03Score']; //과제 서술형 배점
		$TestTime = $Row['TestTime']; //시험제한시간
		$MidRate = $Row['MidRate']; //반영비율 중간평가 
		$TestRate = $Row['TestRate']; //반영비율 최종평가 
		$ReportRate = $Row['ReportRate']; //반영비율 과제
		$PassProgress = $Row['PassProgress']; //진도율  
		$TotalPassMid = $Row['TotalPassMid']; //중간평가 : 총점
		$TotalPassTest = $Row['TotalPassTest']; //최종평가 : 총점
		$PassTest = $Row['PassTest']; //최종평가 : 득점
		$TotalPassReport = $Row['TotalPassReport']; //과제 : 총점
		$PassReport = $Row['PassReport']; //과제 : 득점
		$PassScore = $Row['PassScore']; //반영비율을 적용한 총점
		$Intro = $Row['Intro']; //과정소개
		$EduTarget = $Row['EduTarget']; //교육대상
		$EduGoal = $Row['EduGoal']; //교육목표
		$Hit = $Row['Hit']; //인기강의여부
		$ChapterLimit = $Row['ChapterLimit']; //차시제한 여부
		$tok2 = $Row['tok2']; //tok2 연계여부
		$IE8Compat = $Row['IE8Compat']; //브라우저 호환성 여부
		$ContentsURLSelect = $Row['ContentsURLSelect']; //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
	}

}

if($attachFile) {
	$attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
}

if($PreviewImage) {
	$PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
}

if($BookImage) {
	$BookImageView = "<img src='/upload/Course/".$BookImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
}

if(!$PassProgress) {
	$PassProgress = 80;
}

if(!$CompleteTime) {
	$CompleteTime = 5;
}

if(!$ChapterLimit) {
	$ChapterLimit = "Y";
}

if(!$ContentsURLSelect) {
	$ContentsURLSelect = "A";
}
?>
<script type="text/javascript">
<!--
$(document).ready(function(){

	$("#ContentsPeriod").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsPeriod').val("<?=$ContentsPeriod?>");

	$("#ContentsAccredit").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsAccredit').val("<?=$ContentsAccredit?>");

	$("#ContentsExpire").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsExpire').val("<?=$ContentsExpire?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});
//-->
</script>

                <!-- 입력 -->
				<?if($mode=="new" && $AdminWrite=="Y") {?>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
					<tr>
						<td align="right"><input type="button" value="컨텐츠 정보 가져오기" onclick="CourseCopy()" class="btn_inputBlue01"></td>
					</tr>
				</table>
				<?}?>
				<form name="Form1" method="post" action="course_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="ctype" value="<?=$ctype_session?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="180px" />
                    <col width="" />
					<col width="180px" />
                    <col width="" />
                  </colgroup>
                  <tr>
					<th>등급 / 과정코드</th>
					<td align="left">
					<select name="ClassGrade" id="ClassGrade">
						<?
						while (list($key,$value)=each($ClassGrade_array)) {
						?>
						<option value="<?=$key?>" <?if($ClassGrade==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($ClassGrade_array);
						?>
					</select>&nbsp;&nbsp;/&nbsp;&nbsp;<?if($LectureCode) {?><input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>"><span class="redB"><?=$LectureCode?></span><?}else{?><input name="LectureCode" id="LectureCode" type="text"  size="10" value="<?=$LectureCode?>" maxlength="10"><?}?>
					</td>
					<th>사이트노출 / 컨텐츠 경로</th>
					<td align="left">
					<select name="UseYN" id="UseYN">
						<?
						while (list($key,$value)=each($UseYN_array)) {
						?>
						<option value="<?=$key?>" <?if($UseYN==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($UseYN_array);
						?>
					</select>&nbsp;&nbsp;/&nbsp;&nbsp;
					<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect1" value="A" <?if($ContentsURLSelect=="A") {?>checked<?}?>> <label for="ContentsURLSelect1">주 경로</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect2" value="B" <?if($ContentsURLSelect=="B") {?>checked<?}?>> <label for="ContentsURLSelect2">예비 경로</label>
					</td>
				</tr>
				<tr>
					<th>심사코드</th>
					<td align="left"><input name="PassCode" id="PassCode" type="text"  size="30" value="<?=$PassCode?>"> </td>
					<th>HRD-NET 과정코드</td>
					<td align="left"><input name="HrdCode" id="HrdCode" type="text"  size="30" value="<?=$HrdCode?>"></td>
				</tr>
				<tr>
					<th>과정분류</th>
					<td align="left">
					<select name="Category1" id="Category1" onchange="CourseCategorySelect()">
						<option value="">-- 대분류 선택 --</option>
						<?
						$SQL = "SELECT * FROM CourseCategory WHERE Deep=1 AND UseYN='Y' AND Del='N' AND CategoryType='$ctype_session' ORDER BY OrderByNum ASC, idx ASC";
						//echo $SQL;
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($ROW = mysqli_fetch_array($QUERY))
							{
						?>
						<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Category1) {?>selected<?}?>><?=$ROW['CategoryName']?></option>
						<?
							}
						}
						?>
					</select>&nbsp;&nbsp;<span id="Category2Area"></span>
					</td>
					<th>서비스 구분</th>
					<td align="left">
					<select name="ServiceType" id="ServiceType">
						<?
						if($ctype_session=="A") {
							while (list($key,$value)=each($ServiceTypeCourse_array)) {
								?>
							<option value="<?=$key?>" <?if($ServiceType==$key) {?>selected<?}?>><?=$value?></option>
							<?
							}
							reset($ServiceTypeCourse_array);
						}
						if($ctype_session=="B") {
							while (list($key,$value)=each($ServiceTypeCourse2_array)) {
								?>
							<option value="<?=$key?>" <?if($ServiceType==$key) {?>selected<?}?>><?=$value?></option>
							<?
							}
							reset($ServiceTypeCourse2_array);
						}
						?>
					</select>
					</td>
				</tr>
				<tr>
					<th>과정명</th>
					<td align="left"><input name="ContentsName" id="ContentsName" type="text"  size="80" value="<?=$ContentsName?>" maxlength="120">&nbsp;&nbsp;<input type="checkbox" name="Hit" id="Hit" value="Y" <?if($Hit=="Y") {?>checked<?}?> style="width:17px; height:17px; background:none; border:none;"> <label for="Hit">인기 강의</label></td>
					<th>8개 차시 수강 제한</th>
					<td align="left">
					<select name="ChapterLimit" id="ChapterLimit">
						<?
						while (list($key,$value)=each($ChapterLimit_array)) {
							?>
						<option value="<?=$key?>" <?if($ChapterLimit==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($ChapterLimit_array);
						?>
					</select>
					</td>
				</tr>
				<tr>
					<th>진도시간 기준</th>
					<td bgcolor="#FFFFFF">
					<select name="CompleteTime" id="CompleteTime">
						<?
						while (list($key,$value)=each($CompleteTime_array)) {
						?>
						<option value="<?=$key?>" <?if($CompleteTime==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($CompleteTime_array);
						?>
					</select>
					</td>
					<th>진도체크방식</th>
					<td bgcolor="#FFFFFF">
					<select name="ProgressCheck" id="ProgressCheck">
						<?
						while (list($key,$value)=each($ProgressCheck_array)) {
						?>
						<option value="<?=$key?>" <?if($ProgressCheck==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($ProgressCheck_array);
						?>
					</select>
					</td>
				</tr>
				<tr>
					<th>차시수</th>
					<td bgcolor="#FFFFFF"><input name="Chapter" id="Chapter" type="text"  size="5" value="<?=$Chapter?>" maxlength="3"> 차시</td>
					<th>교육시간</th>
					<td bgcolor="#FFFFFF"><input name="ContentsTime" id="ContentsTime" type="text"  size="5" value="<?=$ContentsTime?>" maxlength="3"> 시간</td>
				</tr>
				<tr>
					<th>교육비용</th>
					<td bgcolor="#FFFFFF" colspan="3"> 
					<input name="Price" id="Price" type="text"  size="10" value="<?=$Price?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;|&nbsp;&nbsp;
					<span class="redB">환급비용 </span>&nbsp;:&nbsp;
					<?=$CompanyScaleTitle01?> : <input name="Price01View" id="Price01View" type="text"  size="10" value="<?=$Price01View?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;/&nbsp;&nbsp;
					<?=$CompanyScaleTitle02?> : <input name="Price02View" id="Price02View" type="text"  size="10" value="<?=$Price02View?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;/&nbsp;&nbsp;
					<?=$CompanyScaleTitle03?> : <input name="Price03View" id="Price03View" type="text"  size="10" value="<?=$Price03View?>" maxlength="7" style="text-align:right"> 원
					</td>
				</tr>
				<tr>
					<th>자부담금</th>
					<td bgcolor="#FFFFFF" colspan="3"> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?=$CompanyScaleTitle01?> : <input name="Price01" id="Price01" type="text"  size="10" value="<?=$Price01?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;/&nbsp;&nbsp;
					<?=$CompanyScaleTitle02?> : <input name="Price02" id="Price02" type="text"  size="10" value="<?=$Price02?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;/&nbsp;&nbsp;
					<?=$CompanyScaleTitle03?> : <input name="Price03" id="Price03" type="text"  size="10" value="<?=$Price03?>" maxlength="7" style="text-align:right"> 원
					</td>
				</tr>
				<tr>
					<th>내용전문가</th>
					<td bgcolor="#FFFFFF"><input name="Professor" id="Professor" type="text"  size="30" value="<?=$Professor?>"> </td>
					<th>학급정원</th>
					<td bgcolor="#FFFFFF"><input name="Limited" id="Limited" type="text"  size="10" value="<?=$Limited?>" maxlength="4" style="text-align:right"> 명</td>
				</tr>
				<tr>
					<th>컨텐츠 유효기간</th>
					<td bgcolor="#FFFFFF"><input name="ContentsPeriod" id="ContentsPeriod" type="text"  size="12" value="<?=$ContentsPeriod?>" readonly> </td>
					<th>인정만료일</th>
					<td bgcolor="#FFFFFF"><input name="ContentsAccredit" id="ContentsAccredit" type="text"  size="12" value="<?=$ContentsAccredit?>" readonly>  ~ <input name="ContentsExpire" id="ContentsExpire" type="text"  size="12" value="<?=$ContentsExpire?>" readonly></td>
				</tr>
				<tr>
					<th>CP사</th>
					<td bgcolor="#FFFFFF"><input name="Cp" id="Cp" type="text"  size="50" value="<?=$Cp?>"> </td>
					<th>CP 수수료</th>
					<td bgcolor="#FFFFFF"><input name="Commission" id="Commission" type="text"  size="10" value="<?=$Commission?>" maxlength="5" style="text-align:right"> %</td>
				</tr>
				<tr>
					<th>모바일 지원</th>
					<td bgcolor="#FFFFFF">
					<select name="Mobile" id="Mobile">
						<?
						while (list($key,$value)=each($UseYN_array)) {
						?>
						<option value="<?=$key?>" <?if($Mobile==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						reset($UseYN_array);
						?>
					</select>
					</td>
					<th>교재비</th>
					<td bgcolor="#FFFFFF"><input name="BookPrice" id="BookPrice" type="text"  size="10" value="<?=$BookPrice?>" maxlength="6" style="text-align:right"> 원</td>
				</tr>
				<tr>
					<th>참고도서설명</th>
					<td bgcolor="#FFFFFF"><input name="BookIntro" id="BookIntro" type="text"  size="80" value="<?=$BookIntro?>"></td>
					<th>학습자료 등록</th>
					<td bgcolor="#FFFFFF"><input name="attachFile" id="attachFile" type="hidden" value="<?=$attachFile?>"><span id="attachFileArea"><?=$attachFileView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="UploadFile('attachFile','attachFileArea','text');" class="btn_inputLine01" ></td>
				</tr>
				<tr>
					<th>과정 이미지</th>
					<td bgcolor="#FFFFFF"><input name="PreviewImage" id="PreviewImage" type="hidden" value="<?=$PreviewImage?>"><span id="PreviewImageArea"><?=$PreviewImageView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="UploadFile('PreviewImage','PreviewImageArea','img');" class="btn_inputLine01" ></td>
					<th>교재 이미지</th>
					<td bgcolor="#FFFFFF"><input name="BookImage" id="BookImage" type="hidden" value="<?=$BookImage?>"><span id="BookImageArea"><?=$BookImageView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="UploadFile('BookImage','BookImageArea','img');" class="btn_inputLine01" ></td>
				</tr>
				<tr>
					<th>중간평가 [문항수/배점]</th>
					<td bgcolor="#FFFFFF" colspan="3">
					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty02">
						<tr>
							<th class="text01" width="80" align="center">객관식</th>
							<td bgcolor="#FFFFFF">문항수 : <input name="Mid01EA" id="Mid01EA" type="text"  size="6" value="<?=$Mid01EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Mid01Score" id="Mid01Score" type="text"  size="6" value="<?=$Mid01Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th class="text01" width="80" align="center">단답형</th>
							<td bgcolor="#FFFFFF">문항수 : <input name="Mid02EA" id="Mid02EA" type="text"  size="6" value="<?=$Mid02EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Mid02Score" id="Mid02Score" type="text"  size="6" value="<?=$Mid02Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th class="text01" width="80" align="center">서술형</th>
							<td bgcolor="#FFFFFF">문항수 : <input name="Mid03EA" id="Mid03EA" type="text"  size="6" value="<?=$Mid03EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Mid03Score" id="Mid03Score" type="text"  size="6" value="<?=$Mid03Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<th>최종평가 [문항수/배점]</th>
					<td bgcolor="#FFFFFF" colspan="3">
					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty02">
						<tr>
							<th class="text01" width="80" align="center">객관식</th>
							<td>문항수 : <input name="Test01EA" id="Test01EA" type="text"  size="6" value="<?=$Test01EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Test01Score" id="Test01Score" type="text"  size="6" value="<?=$Test01Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th class="text01" width="80" align="center">단답형</th>
							<td>문항수 : <input name="Test02EA" id="Test02EA" type="text"  size="6" value="<?=$Test02EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Test02Score" id="Test02Score" type="text"  size="6" value="<?=$Test02Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th class="text01" width="80" align="center">서술형</th>
							<td>문항수 : <input name="Test03EA" id="Test03EA" type="text"  size="6" value="<?=$Test03EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Test03Score" id="Test03Score" type="text"  size="6" value="<?=$Test03Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<th>과제 [문항수/배점]</th>
					<td bgcolor="#FFFFFF" colspan="3">
					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty02">
						<tr>
							<th class="text01" width="80" align="center">객관식</th>
							<td bgcolor="#FFFFFF">문항수 : <input name="Report01EA" id="Report01EA" type="text"  size="6" value="<?=$Report01EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Report01Score" id="Report01Score" type="text"  size="6" value="<?=$Report01Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th class="text01" width="80" align="center">단답형</th>
							<td bgcolor="#FFFFFF">문항수 : <input name="Report02EA" id="Report02EA" type="text"  size="6" value="<?=$Report02EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Report02Score" id="Report02Score" type="text"  size="6" value="<?=$Report02Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<th class="text01" width="80" align="center">서술형</th>
							<td bgcolor="#FFFFFF">문항수 : <input name="Report03EA" id="Report03EA" type="text"  size="6" value="<?=$Report03EA?>" maxlength="2"> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <input name="Report03Score" id="Report03Score" type="text"  size="6" value="<?=$Report03Score?>" maxlength="3"> 점&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<th>반영비율</th>
					<td bgcolor="#FFFFFF"> 중간평가  : <input name="MidRate" id="MidRate" type="text"  size="6" value="<?=$MidRate?>" maxlength="3"> %&nbsp;&nbsp;/&nbsp;&nbsp;최종평가  : <input name="TestRate" id="TestRate" type="text"  size="6" value="<?=$TestRate?>" maxlength="3"> %&nbsp;&nbsp;/&nbsp;&nbsp;과제  : <input name="ReportRate" id="ReportRate" type="text"  size="6" value="<?=$ReportRate?>" maxlength="3"> %</td>
					<th>시험제한시간</th>
					<td bgcolor="#FFFFFF"> <input name="TestTime" id="TestTime" type="text"  size="6" value="<?=$TestTime?>" maxlength="3"> 분</td>
				</tr>
				<tr>
					<th>수료기준</th>
					<td bgcolor="#FFFFFF" colspan="3"> 
					<span class="redB">진도율 </span>  : <input name="PassProgress" id="PassProgress" type="text"  size="6" value="<?=$PassProgress?>" maxlength="3"> %이상&nbsp;&nbsp;/&nbsp;&nbsp;
					<span class="redB">중간평가</span>  : 총점 <input name="TotalPassMid" id="TotalPassMid" type="text"  size="6" value="<?=$TotalPassMid?>" maxlength="3"> 점&nbsp;&nbsp;/&nbsp;&nbsp;
					<span class="redB">최종평가</span>  : 총점 <input name="TotalPassTest" id="TotalPassTest" type="text"  size="6" value="<?=$TotalPassTest?>" maxlength="3"> 점 중 <input name="PassTest" id="PassTest" type="text"  size="6" value="<?=$PassTest?>" maxlength="3"> 점 이상&nbsp;&nbsp;/&nbsp;&nbsp;
					<span class="redB">과제</span>  : 총점 <input name="TotalPassReport" id="TotalPassReport" type="text"  size="6" value="<?=$TotalPassReport?>" maxlength="3"> 점 중 <input name="PassReport" id="PassReport" type="text"  size="6" value="<?=$PassReport?>" maxlength="3"> 점 이상&nbsp;&nbsp;/&nbsp;&nbsp;
					<span class="redB">반영비율을 적용한 총점 </span>  : <input name="PassScore" id="PassScore" type="text"  size="6" value="<?=$PassScore?>" maxlength="3"> 점 이상 수료
					</td>
				</tr>
				<tr>
					<th>과정소개</th>
					<td align="left" colspan="3"><textarea name="Intro" id="Intro" style="width:80%; height:160px;"><?=$Intro?></textarea></td>
				</tr>
				<tr>
					<th>교육대상</th>
					<td align="left" colspan="3"><textarea name="EduTarget" id="EduTarget" style="width:80%; height:160px;"><?=$EduTarget?></textarea></td>
				</tr>
				<tr>
					<th>교육목표</th>
					<td align="left" colspan="3"><textarea name="EduGoal" id="EduGoal" style="width:80%; height:160px;"><?=$EduGoal?></textarea></td>
				</tr>
				<!-- <tr>
					<th>브라우저 호환성 여부</th>
					<td align="left" colspan="3"><input type="checkbox" name="IE8Compat" id="IE8Compat" value="Y" <?if($IE8Compat=="Y") {?>checked<?}?>> <label for="IE8Compat">IE8 브라우저 호환성 적용</label> (FLASH 컨텐츠가 브라우저 호환성 문제로 정상적이지 않은 경우에 체크하세요. 브라우저를 IE8로 애뮬레이팅 합니다.)</td>
				</tr> -->
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
					<span id="SubmitBtn"><input type="button" value="<?=$ScriptTitle?>" onclick="SubmitOk()" class="btn_inputBlue01"></span>
					<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
					</td>
					<td width="100" align="right" valign="top"><img src="images/none.gif" width="4" height="5"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php'" class="btn_inputLine01"></td>
				</tr>
                </table>
                </form>
                <!-- 버튼 -->

                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<!--

<?if($mode=="edit") {?>
CourseCategorySelectAfter(<?=$Category1?>,<?=$Category2?>);
<?}?>

function SubmitOk() {

	val = document.Form1;

	<?if($mode=="new") {?>
	if($("#LectureCode").val()=="") {
		alert("과정코드를 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if($("#LectureCode").val().length<4 || $("#LectureCode").val().length>10) {
		alert("과정코드는 영문 대문자, 숫자로 4자 이상, 10자 이하로 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if(LectureCodeCheck($("#LectureCode").val())==false) {
		alert("과정코드는 영문 대문자, 숫자로 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	<?}?>

	var Category1Selected = $("#Category1 option:selected").val();

	if(Category1Selected=="") {
		alert("과정분류 대분류를 선택하세요.");
		$("#Category1").focus();
		return;
	}
	if($("#ContentsName").val()=="") {
		alert("과정명을 입력하세요.");
		$("#ContentsName").focus();
		return;
	}
	if($("#Chapter").val()=="") {
		alert("차시수를 입력하세요.");
		$("#Chapter").focus();
		return;
	}
	if(IsNumber($("#Chapter").val())==false) {
		alert("차시수를 숫자만 입력하세요.");
		$("#Chapter").focus();
		return;
	}
	if($("#ContentsTime").val()=="") {
		alert("교육시간을 입력하세요.");
		$("#ContentsTime").focus();
		return;
	}
	if(IsNumber($("#ContentsTime").val())==false) {
		alert("교육시간은 숫자만 입력하세요.");
		$("#ContentsTime").focus();
		return;
	}
	if($("#Price").val()=="") {
		alert("교육비용:일반을 입력하세요.");
		$("#Price").focus();
		return;
	}
	if(IsNumber($("#Price").val())==false) {
		alert("교육비용은 숫자만 입력하세요.");
		$("#Price").focus();
		return;
	}
	if($("#Price01View").val()=="") {
		alert("교육비용:우선지원을 입력하세요.");
		$("#Price01View").focus();
		return;
	}
	if(IsNumber($("#Price01View").val())==false) {
		alert("교육비용은 숫자만 입력하세요.");
		$("#Price01View").focus();
		return;
	}
	if($("#Price02View").val()=="") {
		alert("교육비용:대규모 1000인 미만을 입력하세요.");
		$("#Price02View").focus();
		return;
	}
	if(IsNumber($("#Price02View").val())==false) {
		alert("교육비용은 숫자만 입력하세요.");
		$("#Price02View").focus();
		return;
	}
	if($("#Price03View").val()=="") {
		alert("교육비용:대규모 1000인 이상을 입력하세요.");
		$("#Price03View").focus();
		return;
	}
	if(IsNumber($("#Price03View").val())==false) {
		alert("교육비용은 숫자만 입력하세요.");
		$("#Price03View").focus();
		return;
	}
	if($("#Price01").val()=="") {
		alert("자부담금:우선지원을 입력하세요.");
		$("#Price01").focus();
		return;
	}
	if(IsNumber($("#Price01").val())==false) {
		alert("자부담금은 숫자만 입력하세요.");
		$("#Price01").focus();
		return;
	}
	if($("#Price02").val()=="") {
		alert("자부담금:대규모 1000인 미만을 입력하세요.");
		$("#Price02").focus();
		return;
	}
	if(IsNumber($("#Price02").val())==false) {
		alert("자부담금은 숫자만 입력하세요.");
		$("#Price02").focus();
		return;
	}
	if($("#Price03").val()=="") {
		alert("자부담금:대규모 1000인 이상을 입력하세요.");
		$("#Price03").focus();
		return;
	}
	if(IsNumber($("#Price03").val())==false) {
		alert("자부담금은 숫자만 입력하세요.");
		$("#Price03").focus();
		return;
	}
	if($("#Limited").val()=="") {
		alert("학급정원을 입력하세요.");
		$("#Limited").focus();
		return;
	}
	if(IsNumber($("#Limited").val())==false) {
		alert("학급정원은 숫자만 입력하세요.");
		$("#Limited").focus();
		return;
	}
	if($("#ContentsPeriod").val()=="") {
		alert("컨텐츠 유효기간을 입력하세요.");
		$("#ContentsPeriod").focus();
		return;
	}
	if($("#ContentsAccredit").val()=="") {
		alert("인정만료일 시작일을 입력하세요.");
		$("#ContentsAccredit").focus();
		return;
	}
	if($("#ContentsExpire").val()=="") {
		alert("인정만료일 종료일을 입력하세요.");
		$("#ContentsExpire").focus();
		return;
	}

	if($("#Mid01EA").val()=="") {
		alert("중간평가 객관식 문항수를 입력하세요.");
		$("#Mid01EA").focus();
		return;
	}
	if(IsNumber($("#Mid01EA").val())==false) {
		alert("중간평가 객관식 문항수는 숫자만 입력하세요.");
		$("#Mid01EA").focus();
		return;
	}
	if($("#Mid01Score").val()=="") {
		alert("중간평가 객관식 배점을 입력하세요.");
		$("#Mid01Score").focus();
		return;
	}
	if(IsNumber($("#Mid01Score").val())==false) {
		alert("중간평가 객관식 배점은 숫자만 입력하세요.");
		$("#Mid01Score").focus();
		return;
	}
	if($("#Mid02EA").val()=="") {
		alert("중간평가 단답형 문항수를 입력하세요.");
		$("#Mid02EA").focus();
		return;
	}
	if(IsNumber($("#Mid02EA").val())==false) {
		alert("중간평가 단답형 문항수는 숫자만 입력하세요.");
		$("#Mid02EA").focus();
		return;
	}
	if($("#Mid02Score").val()=="") {
		alert("중간평가 단답형 배점을 입력하세요.");
		$("#Mid02Score").focus();
		return;
	}
	if(IsNumber($("#Mid02Score").val())==false) {
		alert("중간평가 단답형 배점은 숫자만 입력하세요.");
		$("#Mid02Score").focus();
		return;
	}
	if($("#Mid03EA").val()=="") {
		alert("중간평가 서술형 문항수를 입력하세요.");
		$("#Mid03EA").focus();
		return;
	}
	if(IsNumber($("#Mid03EA").val())==false) {
		alert("중간평가 서술형 문항수는 숫자만 입력하세요.");
		$("#Mid03EA").focus();
		return;
	}
	if($("#Mid03Score").val()=="") {
		alert("중간평가 서술형 배점을 입력하세요.");
		$("#Mid03Score").focus();
		return;
	}
	if(IsNumber($("#Mid03Score").val())==false) {
		alert("중간평가 서술형 배점은 숫자만 입력하세요.");
		$("#Mid03Score").focus();
		return;
	}

	if($("#Test01EA").val()=="") {
		alert("최종평가 객관식 문항수를 입력하세요.");
		$("#Test01EA").focus();
		return;
	}
	if(IsNumber($("#Test01EA").val())==false) {
		alert("최종평가 객관식 문항수는 숫자만 입력하세요.");
		$("#Test01EA").focus();
		return;
	}
	if($("#Test01Score").val()=="") {
		alert("최종평가 객관식 배점을 입력하세요.");
		$("#Test01Score").focus();
		return;
	}
	if(IsNumber($("#Test01Score").val())==false) {
		alert("최종평가 객관식 배점은 숫자만 입력하세요.");
		$("#Test01Score").focus();
		return;
	}
	if($("#Test02EA").val()=="") {
		alert("최종평가 단답형 문항수를 입력하세요.");
		$("#Test02EA").focus();
		return;
	}
	if(IsNumber($("#Test02EA").val())==false) {
		alert("최종평가 단답형 문항수는 숫자만 입력하세요.");
		$("#Test02EA").focus();
		return;
	}
	if($("#Test02Score").val()=="") {
		alert("최종평가 단답형 배점을 입력하세요.");
		$("#Test02Score").focus();
		return;
	}
	if(IsNumber($("#Test02Score").val())==false) {
		alert("최종평가 단답형 배점은 숫자만 입력하세요.");
		$("#Test02Score").focus();
		return;
	}

	if($("#Test03EA").val()=="") {
		alert("최종평가 서술형 문항수를 입력하세요.");
		$("#Test03EA").focus();
		return;
	}
	if(IsNumber($("#Test03EA").val())==false) {
		alert("최종평가 서술형 문항수는 숫자만 입력하세요.");
		$("#Test03EA").focus();
		return;
	}
	if($("#Test03Score").val()=="") {
		alert("최종평가 서술형 배점을 입력하세요.");
		$("#Test03Score").focus();
		return;
	}
	if(IsNumber($("#Test03Score").val())==false) {
		alert("최종평가 서술형 배점은 숫자만 입력하세요.");
		$("#Test03Score").focus();
		return;
	}

	if($("#Report01EA").val()=="") {
		alert("과제 객관식 문항수를 입력하세요.");
		$("#Report01EA").focus();
		return;
	}
	if(IsNumber($("#Report01EA").val())==false) {
		alert("과제 객관식 문항수는 숫자만 입력하세요.");
		$("#Report01EA").focus();
		return;
	}
	if($("#Report01Score").val()=="") {
		alert("과제 객관식 배점을 입력하세요.");
		$("#Report01Score").focus();
		return;
	}
	if(IsNumber($("#Report01Score").val())==false) {
		alert("과제 객관식 배점은 숫자만 입력하세요.");
		$("#Report01Score").focus();
		return;
	}
	if($("#Report02EA").val()=="") {
		alert("과제 단답형 문항수를 입력하세요.");
		$("#Report02EA").focus();
		return;
	}
	if(IsNumber($("#Report02EA").val())==false) {
		alert("과제 단답형 문항수는 숫자만 입력하세요.");
		$("#Report02EA").focus();
		return;
	}
	if($("#Report02Score").val()=="") {
		alert("과제 단답형 배점을 입력하세요.");
		$("#Report02Score").focus();
		return;
	}
	if(IsNumber($("#Report02Score").val())==false) {
		alert("과제 단답형 배점은 숫자만 입력하세요.");
		$("#Report02Score").focus();
		return;
	}

	if($("#Report03EA").val()=="") {
		alert("과제 서술형 문항수를 입력하세요.");
		$("#Report03EA").focus();
		return;
	}
	if(IsNumber($("#Report03EA").val())==false) {
		alert("과제 서술형 문항수는 숫자만 입력하세요.");
		$("#Report03EA").focus();
		return;
	}
	if($("#Report03Score").val()=="") {
		alert("과제 서술형 배점을 입력하세요.");
		$("#Report03Score").focus();
		return;
	}
	if(IsNumber($("#Report03Score").val())==false) {
		alert("과제 서술형 배점은 숫자만 입력하세요.");
		$("#Report03Score").focus();
		return;
	}

	if($("#TestTime").val()=="") {
		alert("시험제한시간을 입력하세요.");
		$("#TestTime").focus();
		return;
	}
	if(IsNumber($("#TestTime").val())==false) {
		alert("시험제한시간은 숫자만 입력하세요.");
		$("#TestTime").focus();
		return;
	}
	if($("#MidRate").val()=="") {
		alert("중간평가 반영비율을 입력하세요.");
		$("#MidRate").focus();
		return;
	}
	if(IsNumber($("#MidRate").val())==false) {
		alert("중간평가 반영비율은 숫자만 입력하세요.");
		$("#MidRate").focus();
		return;
	}
	if($("#TestRate").val()=="") {
		alert("최종평가 반영비율을 입력하세요.");
		$("#TestRate").focus();
		return;
	}
	if(IsNumber($("#TestRate").val())==false) {
		alert("최종평가 반영비율은 숫자만 입력하세요.");
		$("#TestRate").focus();
		return;
	}
	if($("#ReportRate").val()=="") {
		alert("과제 반영비율을 입력하세요.");
		$("#ReportRate").focus();
		return;
	}
	if(IsNumber($("#ReportRate").val())==false) {
		alert("과제 반영비율은 숫자만 입력하세요.");
		$("#ReportRate").focus();
		return;
	}
	if($("#PassProgress").val()=="") {
		alert("수료기준 진도율을 입력하세요.");
		$("#PassProgress").focus();
		return;
	}
	if(IsNumber($("#PassProgress").val())==false) {
		alert("수료기준 진도율은 숫자만 입력하세요.");
		$("#PassProgress").focus();
		return;
	}
	if($("#TotalPassMid").val()=="") {
		alert("수료기준 중간평가 : 총점을 입력하세요.");
		$("#TotalPassMid").focus();
		return;
	}
	if(IsNumber($("#TotalPassMid").val())==false) {
		alert("수료기준 중간평가 : 총점은 숫자만 입력하세요.");
		$("#TotalPassMid").focus();
		return;
	}
	if($("#TotalPassTest").val()=="") {
		alert("수료기준 최종평가 : 총점을 입력하세요.");
		$("#TotalPassTest").focus();
		return;
	}
	if(IsNumber($("#TotalPassTest").val())==false) {
		alert("수료기준 최종평가 : 총점은 숫자만 입력하세요.");
		$("#TotalPassTest").focus();
		return;
	}
	if($("#PassTest").val()=="") {
		alert("수료기준 최종평가 : 득점을 입력하세요.");
		$("#PassTest").focus();
		return;
	}
	if(IsNumber($("#PassTest").val())==false) {
		alert("수료기준 최종평가 : 득점은 숫자만 입력하세요.");
		$("#PassTest").focus();
		return;
	}
	if($("#TotalPassReport").val()=="") {
		alert("수료기준 과제 : 총점을 입력하세요.");
		$("#TotalPassReport").focus();
		return;
	}
	if(IsNumber($("#TotalPassReport").val())==false) {
		alert("수료기준 과제 : 총점은 숫자만 입력하세요.");
		$("#TotalPassReport").focus();
		return;
	}
	if($("#PassReport").val()=="") {
		alert("수료기준 과제 : 득점을 입력하세요.");
		$("#PassReport").focus();
		return;
	}
	if(IsNumber($("#PassReport").val())==false) {
		alert("수료기준 과제 : 득점은 숫자만 입력하세요.");
		$("#PassReport").focus();
		return;
	}
	if($("#PassScore").val()=="") {
		alert("반영비율을 적용한 총점을 입력하세요.");
		$("#PassScore").focus();
		return;
	}
	if(IsNumber($("#PassScore").val())==false) {
		alert("반영비율을 적용한 총점은 숫자만 입력하세요.");
		$("#PassScore").focus();
		return;
	}

	//중간평가 입력사항 검증
	var MidScoreSum = 0;
	var MidScore01Sum = 0;
	var MidScore02Sum = 0;
	var MidScore03Sum = 0;

	if($("#Mid01EA").val()>0 || $("#Mid01Score").val()>0) {
		MidScore01Sum = $("#Mid01EA").val() * $("#Mid01Score").val();
		if(MidScore01Sum<1) {
			alert("중간평가[객관식] 문항과 배점입력이 정확하지 않습니다.");
			$("#Mid01EA").focus();
			return;
		}
	}
	if($("#Mid02EA").val()>0 || $("#Mid02Score").val()>0) {
		MidScore02Sum = $("#Mid02EA").val() * $("#Mid02Score").val();
		if(MidScore02Sum<1) {
			alert("중간평가[단답형] 문항과 배점입력이 정확하지 않습니다.");
			$("#Mid02EA").focus();
			return;
		}
	}
	if($("#Mid03EA").val()>0 || $("#Mid03Score").val()>0) {
		MidScore03Sum = $("#Mid03EA").val() * $("#Mid03Score").val();
		if(MidScore03Sum<1) {
			alert("중간평가[서술형] 문항과 배점입력이 정확하지 않습니다.");
			$("#Mid03EA").focus();
			return;
		}
	}

	MidScoreSum = ($("#Mid01EA").val() * $("#Mid01Score").val()) + ($("#Mid02EA").val() * $("#Mid02Score").val()) + ($("#Mid03EA").val() * $("#Mid03Score").val());

	if(MidScoreSum>0) { //중간평가를 실행한다면
		if(MidScoreSum!=100) {
			alert("중간평가 [객관식, 단답형, 서술형]의 문항수X배점의\n\n합계가 100점이 아닙니다.\n\n현재 "+MidScoreSum+"점입니다.\n\n입력 항목을 확인하세요.");
			return;
		}
	}


	//최종평가 입력사항 검증
	var TestScoreSum = 0;
	var TestScore01Sum = 0;
	var TestScore02Sum = 0;
	var TestScore03Sum = 0;

	if($("#Test01EA").val()>0 || $("#Test01Score").val()>0) {
		TestScore01Sum = $("#Test01EA").val() * $("#Test01Score").val();
		if(TestScore01Sum<1) {
			alert("최종평가[객관식] 문항과 배점입력이 정확하지 않습니다.");
			$("#Test01EA").focus();
			return;
		}
	}
	if($("#Test02EA").val()>0 || $("#Test02Score").val()>0) {
		TestScore02Sum = $("#Test02EA").val() * $("#Test02Score").val();
		if(TestScore02Sum<1) {
			alert("최종평가[단답형] 문항과 배점입력이 정확하지 않습니다.");
			$("#Test02EA").focus();
			return;
		}
	}
	if($("#Test03EA").val()>0 || $("#Test03Score").val()>0) {
		TestScore03Sum = $("#Test03EA").val() * $("#Test03Score").val();
		if(TestScore03Sum<1) {
			alert("최종평가[서술형] 문항과 배점입력이 정확하지 않습니다.");
			$("#Test03EA").focus();
			return;
		}
	}

	TestScoreSum = ($("#Test01EA").val() * $("#Test01Score").val()) + ($("#Test02EA").val() * $("#Test02Score").val()) + ($("#Test03EA").val() * $("#Test03Score").val());

	if(TestScoreSum>0) { //최종평가를 실행한다면
		if(TestScoreSum!=100) {
			alert("최종평가 [객관식, 단답형, 서술형]의 문항수X배점의\n\n합계가 100점이 아닙니다.\n\n현재 "+TestScoreSum+"점입니다.\n\n입력 항목을 확인하세요.");
			return;
		}
	}

	//과제 입력사항 검증
	var ReportScoreSum = 0;
	var ReportScore01Sum = 0;
	var ReportScore02Sum = 0;
	var ReportScore03Sum = 0;

	if($("#Report01EA").val()>0 || $("#Report01Score").val()>0) {
		ReportScore01Sum = $("#Report01EA").val() * $("#Report01Score").val();
		if(ReportScore01Sum<1) {
			alert("과제 [객관식] 문항과 배점입력이 정확하지 않습니다.");
			$("#Report01EA").focus();
			return;
		}
	}
	if($("#Report02EA").val()>0 || $("#Report02Score").val()>0) {
		ReportScore02Sum = $("#Report02EA").val() * $("#Report02Score").val();
		if(ReportScore02Sum<1) {
			alert("과제 [단답형] 문항과 배점입력이 정확하지 않습니다.");
			$("#Report02EA").focus();
			return;
		}
	}
	if($("#Report03EA").val()>0 || $("#Report03Score").val()>0) {
		ReportScore03Sum = $("#Report03EA").val() * $("#Report03Score").val();
		if(ReportScore03Sum<1) {
			alert("과제 [서술형] 문항과 배점입력이 정확하지 않습니다.");
			$("#Report03EA").focus();
			return;
		}
	}

	ReportScoreSum = ($("#Report01EA").val() * $("#Report01Score").val()) + ($("#Report02EA").val() * $("#Report02Score").val()) + ($("#Report03EA").val() * $("#Report03Score").val());

	if(ReportScoreSum>0) { //과제를 실행한다면
		if(ReportScoreSum!=100) {
			alert("과제 [객관식, 단답형, 서술형]의 문항수X배점의\n\n합계가 100점이 아닙니다.\n\n현재 "+ReportScoreSum+"점입니다.\n\n입력 항목을 확인하세요.");
			return;
		}
	}

	//반영비율 입력사항 검증
	var RateSum = 0;
	var TotalSum = 0;

	RateSum = parseInt($("#MidRate").val()) + parseInt($("#TestRate").val()) + parseInt($("#ReportRate").val());
	TotalSum = MidScoreSum + TestScoreSum + ReportScoreSum;

	if(TotalSum>0) {//중간,최종평가, 과제의 배점을 설정한 경우

		if(RateSum==0) { //반영비율 미설정
			alert("반영비율의 합이 0%입니다.\n\n입력 항목을 확인하세요.");
			return;
		}

		if(RateSum>0) { //반영비율을 설정했다면
			if(RateSum!=100) {
				alert("반영비율의 합이 100%가 아닙니다.\n\n현재 "+RateSum+"%입니다.\n\n입력 항목을 확인하세요.");
				return;
			}
		}

	}


	//수료기준 입력사항 검증

	//진도율
	if($("#PassProgress").val()>100) {
		alert("수료기준에 진도율이 100%를 초과하였습니다.");
		$("#PassProgress").focus();
		return;
	}

	//중가평가 총점
	if(MidScoreSum != $("#TotalPassMid").val()) {
		alert("중간평가 [객관식]+[주관식]을 연산한 합이\n\n수료기준 중간평가 총점과 일치하지 않습니다.\n\n배점에서 연산한 값으로 수료기준 중간평가 총점을 설정합니다.");
		$("#TotalPassMid").val(MidScoreSum);
		return;
	}

	//최종평가 총점
	if(TestScoreSum != $("#TotalPassTest").val()) {
		alert("최종평가 [객관식]+[주관식]을 연산한 합이\n\n수료기준 최종평가 총점과 일치하지 않습니다.\n\n배점에서 연산한 값으로 수료기준 최종평가 총점을 설정합니다.");
		$("#TotalPassTest").val(TestScoreSum);
		return;
	}

	if(parseInt($("#PassTest").val()) > parseInt($("#TotalPassTest").val())) {
		alert("수료기준 최종평가 득점이 총점보다 큰 값입니다.");
		$("#PassTest").focus();
		return;
	}

	//과제 총점
	if(ReportScoreSum != $("#TotalPassReport").val()) {
		alert("과제 문항수X배점을 연산한 합이\n\n수료기준 과제총점과 일치하지 않습니다.\n\n배점에서 연산한 값으로 수료기준 과제 총점을 설정합니다.");
		$("#TotalPassReport").val(ReportScoreSum);
		return;
	}

	if(parseInt($("#PassReport").val()) > parseInt($("#TotalPassReport").val())) {
		alert("수료기준 과제의 득점이 총점보다 큰 값입니다.");
		$("#PassReport").focus();
		return;
	}

	//반영비율을 적용한 총점  
	if(parseInt($("#PassScore").val())>100) {
		alert("반영비율을 적용한 총점이 100%를 초과하였습니다.");
		$("#PassScore").focus();
		return;
	}


	Yes = confirm("<?=$ScriptTitle?> 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

//-->
</SCRIPT>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>