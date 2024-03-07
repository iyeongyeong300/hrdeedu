<?
$MenuType = "D";
$PageName = "course";
$ReadPage = "course_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

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
            <h2>단과 컨텐츠 관리 [<?=$CategoryType_array[$ctype_session]?>]</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM Course WHERE idx=$idx AND Del='N'";
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
	$Price01 = $Row['Price01']; //자부담 교육비용 우선지원 
	$Price02 = $Row['Price02']; //자부담 교육비용 대규모 1000인 미만 
	$Price03 = $Row['Price03']; //자부담 교육비용 대규모 1000인 이상 
	$Price01View = $Row['Price01View']; //교육비용 우선지원 
	$Price02View = $Row['Price02View']; //교육비용 대규모 1000인 미만 
	$Price03View = $Row['Price03View']; //교육비용 대규모 1000인 이상 
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
	$Intro = nl2br($Row['Intro']); //과정소개
	$EduTarget = nl2br($Row['EduTarget']); //교육대상
	$EduGoal = nl2br($Row['EduGoal']); //교육목표
	$Hit = $Row['Hit']; //인기 강의
	$ChapterLimit = $Row['ChapterLimit']; //차시제한 여부
	$tok2 = $Row['tok2']; //tok2 연계 여부
	$IE8Compat = $Row['IE8Compat']; //브라우저 호환성 여부
	$ContentsURLSelect = $Row['ContentsURLSelect']; //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
}

$Sql = "SELECT * FROM CourseCategory WHERE Deep=1 AND UseYN='Y' AND Del='N' AND idx=$Category1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Category1Name = $Row['CategoryName'];
}

$Sql = "SELECT * FROM CourseCategory WHERE Deep=2 AND UseYN='Y' AND Del='N' AND idx=$Category2";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Category2Name = " > ".$Row['CategoryName'];
}

if($attachFile) {
	$attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>";
}

if($PreviewImage) {
	$PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='100' align='absmiddle'>";
}

if($BookImage) {
	$BookImageView = "<img src='/upload/Course/".$BookImage."' height='100' align='absmiddle'>";
}


$Sql = "SELECT COUNT(*) FROM Member WHERE TestLectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TestIDCount = $Row[0];
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 컨텐츠를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

function ChapterDelete(mode,LectureCode,Chapter_seq) {
	del_confirm = confirm("클릭한 차시 구성을 삭제하시겠습니까?");
	if(del_confirm==true) {
		document.DeleteForm2.LectureCode.value = LectureCode;
		document.DeleteForm2.Chapter_seq.value = Chapter_seq;
		DeleteForm2.submit();
	}
}
//-->
</SCRIPT>
                <!-- 입력 -->
				<input type="hidden" name="LectureCodeValue" id="LectureCodeValue" value="<?=$LectureCode?>">
				<form name="DeleteForm" method="post" action="course_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
					<INPUT TYPE="hidden" name="LectureCode" value="<?=$LectureCode?>">
				</form>
				<form name="DeleteForm2" method="post" action="chapter_regist_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" id="mode" value="del">
					<INPUT TYPE="hidden" name="LectureCode" id="LectureCode">
					<INPUT TYPE="hidden" name="Chapter_seq" id="Chapter_seq">
				</form>
				<form name="TestIDForm" method="post" action="course_testid_creat.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
					<INPUT TYPE="hidden" name="CreatCount" id="CreatCount" value="5">
				</form>
				<?if($AdminWrite=="Y") {?>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
					<tr>
						<td align="right"><a href="Javascript:TestIDView('<?=$LectureCode?>');">[등록된 심사용 테스트 아이디 <?=$TestIDCount?>건 보기]</a>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="심사용 테스트 아이디 생성" onclick="TestIDCreat()" class="btn_inputLine01"></td>
					</tr>
				</table>
				<?}?>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="130px" />
                    <col width="" />
					<col width="130px" />
                    <col width="" />
					<col width="130px" />
                    <col width="" />
					<col width="140px" />
                    <col width="" />
                  </colgroup>
					<tr>
						<th>등급 / 과정코드</th>
						<td align="left"> <?=$ClassGrade_array[$ClassGrade]?>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="redB"><?=$LectureCode?></span></td>
						<th>사이트노출 / <br>컨텐츠 경로</th>
						<td align="left"> <?=$UseYN_array[$UseYN]?>&nbsp;&nbsp;/&nbsp;&nbsp;
					<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect1" value="A" <?if($ContentsURLSelect=="A") {?>checked<?}?> disabled> <label for="ContentsURLSelect1">주 경로</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect2" value="B" <?if($ContentsURLSelect=="B") {?>checked<?}?> disabled> <label for="ContentsURLSelect2">예비 경로</label></td>
						<th>심사코드</th>
						<td align="left"> <?=$PassCode?></td>
						<th>HRD-NET 과정코드</th>
						<td align="left"> <?=$HrdCode?></td>
					</tr>
					<tr>
						<th>과정명</th>
						<td align="left" colspan="3"> <?if($Hit=="Y") {?><span class="redB">[인기]</span> <?}?><?=$ContentsName?></td>
						<th>차시수</th>
						<td align="left"> <?=$Chapter?> 차시&nbsp;&nbsp;[ <?=$ChapterLimit_array[$ChapterLimit]?> ]</td>
						<th>교육시간</th>
						<td align="left"> <?=$ContentsTime?> 시간</td>
					</tr>
					<tr>
						<th>과정분류</th>
						<td align="left"> <?=$Category1Name?> <?=$Category2Name?></td>
						<th>서비스 구분</th>
						<td align="left"> <?=$ServiceTypeCourse_array[$ServiceType]?></td>
						<th>진도시간 기준</th>
						<td align="left"> <?=$CompleteTime_array[$CompleteTime]?></td>
						<th>진도체크방식</th>
						<td align="left"> <?=$ProgressCheck_array[$ProgressCheck]?></td>
					</tr>
					<tr>
						<th>교육비용</th>
						<td align="left" colspan="5"> 
						<?=number_format($Price,0)?> 원&nbsp;&nbsp;|&nbsp;&nbsp;
						<span class="redB">환급비용 </span>&nbsp;:&nbsp;
						<?=$CompanyScaleTitle01?> : <?=number_format($Price01View,0)?> 원&nbsp;&nbsp;/&nbsp;&nbsp;
						<?=$CompanyScaleTitle02?> : <?=number_format($Price02View,0)?> 원&nbsp;&nbsp;/&nbsp;&nbsp;
						<?=$CompanyScaleTitle03?> : <?=number_format($Price03View,0)?> 원
						</td>
						<th>&nbsp;</th>
						<td align="left">  </td>
					</tr>
					<tr>
						<th>자부담금</th>
						<td align="left" colspan="5"> 
						우선지원 : <?=number_format($Price01,0)?> 원&nbsp;&nbsp;/&nbsp;&nbsp;
						대규모 1000인 미만 : <?=number_format($Price02,0)?> 원&nbsp;&nbsp;/&nbsp;&nbsp;
						대규모 1000인 이상 : <?=number_format($Price03,0)?> 원
						</td>
						<th> </th>
						<td align="left">  </td>
					</tr>
					<tr>
						<th>내용전문가</th>
						<td align="left"> <?=$Professor?> </td>
						<th>학급정원</th>
						<td align="left"> <?=$Limited?> 명</td>
						<th>컨텐츠 유효기간</th>
						<td align="left"> <?=$ContentsPeriod?></td>
						<th>인정만료일</th>
						<td align="left"> <?=$ContentsAccredit?>  ~ <?=$ContentsExpire?></td>
					</tr>
					<tr>
						<th>CP사</th>
						<td align="left"> <?=$Cp?></td>
						<th>CP 수수료</th>
						<td align="left"> <?=$Commission?> %</td>
						<th>모바일 지원</th>
						<td align="left"> <?=$UseYN_array[$Mobile]?></td>
						<th>교재비</th>
						<td align="left"> <?=number_format($BookPrice,0)?> 원</td>
					</tr>
					<tr>
						<th>참고도서설명</th>
						<td align="left"> <?=$BookIntro?></td>
						<th>학습자료 등록</th>
						<td align="left"><?=$attachFileView?></td>
						<th>과정 이미지</th>
						<td align="left"><?=$PreviewImageView?></td>
						<th>교재 이미지</th>
						<td align="left"><?=$BookImageView?></td>
					</tr>
					<tr>
						<th>중간평가[객관식]</th>
						<td align="left"> 문항수 : <?=$Mid01EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Mid01Score?> 점</td>
						<th>중간평가[단답형]</th>
						<td align="left">문항수 : <?=$Mid02EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Mid02Score?> 점</td>
						<th>중간평가[서술형]</th>
						<td align="left" colspan="3"> 문항수 : <?=$Mid03EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Mid03Score?> 점</td>
					</tr>
					<tr>
						<th>최종평가[객관식]</th>
						<td align="left"> 문항수 : <?=$Test01EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Test01Score?> 점</td>
						<th>최종평가[단답형]</th>
						<td align="left">문항수 : <?=$Test02EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Test02Score?> 점</td>
						<th>최종평가[서술형]</th>
						<td align="left" colspan="3">문항수 : <?=$Test03EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Test03Score?> 점</td>
					</tr>
					<tr>
						<th>과제[객관식]</th>
						<td align="left"> 문항수 : <?=$Report01EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Report01Score?> 점</td>
						<th>과제[단답형]</th>
						<td align="left">문항수 : <?=$Report02EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Report02Score?> 점</td>
						<th>과제[서술형]</th>
						<td align="left" colspan="3">문항수 : <?=$Report03EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Report03Score?> 점</td>
					</tr>
					<tr>
						<th>시험제한시간</th>
						<td align="left"> <?=$TestTime?> 분</td>
						<th>반영비율</th>
						<td align="left" colspan="5"> 중간평가  : <?=$MidRate?> %&nbsp;&nbsp;/&nbsp;&nbsp;최종평가  : <?=$TestRate?> %&nbsp;&nbsp;/&nbsp;&nbsp;과제  : <?=$ReportRate?> %</td>
					</tr>
					<tr>
						<th>수료기준</th>
						<td align="left" colspan="7"> 
						<span class="redB">진도율 </span>  : <?=$PassProgress?> %이상&nbsp;&nbsp;/&nbsp;&nbsp;
						<span class="redB">중간평가</span>  : 총점 <?=$TotalPassMid?> 점&nbsp;&nbsp;/&nbsp;&nbsp;
						<span class="redB">최종평가</span>  : 총점 <?=$TotalPassTest?> 점 중 <?=$PassTest?> 점 이상&nbsp;&nbsp;/&nbsp;&nbsp;
						<span class="redB">과제</span>  : 총점 <?=$TotalPassReport?> 점 중 <?=$PassReport?> 점 이상&nbsp;&nbsp;/&nbsp;&nbsp;
						<span class="redB">반영비율을 적용한 총점 </span>  : <?=$PassScore?> 점 이상 수료
						</td>
					</tr>
					<tr>
						<th>과정소개</th>
						<td align="left" colspan="7"><?=$Intro?></td>
					</tr>
					<tr>
						<th>교육대상</th>
						<td align="left" colspan="7"><?=$EduTarget?></td>
					</tr>
					<tr>
						<th>교육목표</th>
						<td align="left" colspan="7"><?=$EduGoal?></td>
					</tr>
					<!-- <tr>
						<th>브라우저 호환성</th>
						<td align="left" colspan="7"><?if($IE8Compat=="Y") {?><img src="images/checked.gif" align="absmiddle"> IE8 브라우저 호환성 적용<?}else{?><img src="images/unchecked.gif" align="absmiddle"> IE8 브라우저 호환성 적용하지 않음<?}?></td>
					</tr> -->
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<?if($AdminWrite=="Y") {?>
						<td align="left" width="150" valign="top"><input type="button" value="컨텐츠 삭제" onclick="DelOk()" class="btn_inputLine01"></td>
						<td align="center" valign="top">
						<input type="button" value="컨텐츠 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
						<?}?>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
				<br><br>
				<div id="ChapterList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>
				<br><br><br><br><br><br>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<script type="text/javascript">
<!--
$(window).load(function() {
	ChapterListRoading();
});

//-->
</script>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>