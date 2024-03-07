<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureCode = Replace_Check($LectureCode);
?>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>단과 컨텐츠 상세 정보</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
<?
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode' AND Del='N'";
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
	$Price01 = $Row['Price01']; //교육비용 우선지원 
	$Price02 = $Row['Price02']; //교육비용 대규모 1000인 미만 
	$Price03 = $Row['Price03']; //교육비용 대규모 1000인 이상 
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
	$attachFileView = "<A HREF='./direct_download.php?code=course&file=".$attachFile."'><B>".$attachFile."</B></a>";
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
	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
	  <colgroup>
		<col width="9%" />
		<col width="16%" />
		<col width="9%" />
		<col width="16%" />
		<col width="9%" />
		<col width="16%" />
		<col width="9%" />
		<col width="16%" />
	  </colgroup>
		<tr>
			<th>등급 /<br>과정코드</th>
			<td> <?=$ClassGrade_array[$ClassGrade]?>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="redB"><?=$LectureCode?></span></td>
			<th>사이트<br>노출</th>
			<td> <?=$UseYN_array[$UseYN]?></td>
			<th>심사코드</th>
			<td> <?=$PassCode?></td>
			<th>HRD-NET<br>코드</th>
			<td> <?=$HrdCode?></td>
		</tr>
		<tr>
			<th>과정명</th>
			<td bgcolor="#FFFFFF" colspan="3"> <?if($Hit=="Y") {?><span class="redB">[인기]</span> <?}?><?=$ContentsName?></td>
			<th>차시수</th>
			<td bgcolor="#FFFFFF"> <?=$Chapter?> 차시&nbsp;&nbsp;[ <?=$ChapterLimit_array[$ChapterLimit]?> ]</td>
			<th>교육시간</th>
			<td bgcolor="#FFFFFF"> <?=$ContentsTime?> 시간</td>
		</tr>
		<tr>
			<th>과정분류</th>
			<td bgcolor="#FFFFFF"> <?=$Category1Name?> <?=$Category2Name?>
			</td>
			<th>서비스<br>구분</th>
			<td bgcolor="#FFFFFF"> <?=$ServiceTypeCourse_array[$ServiceType]?></td>
			<th>진도시간<br>기준</th>
			<td bgcolor="#FFFFFF"> <?=$CompleteTime_array[$CompleteTime]?></td>
			<th>진도체크<br>방식</th>
			<td bgcolor="#FFFFFF"> <?=$ProgressCheck_array[$ProgressCheck]?></td>
		</tr>
		<tr>
			<th>교육비용</th>
			<td bgcolor="#FFFFFF" colspan="7"> 
			<?=number_format($Price,0)?> 원&nbsp;&nbsp;|&nbsp;&nbsp;
			<span class="redB">환급비용 </span>&nbsp;:&nbsp;
			우선지원 : <?=number_format($Price01,0)?> 원&nbsp;&nbsp;/&nbsp;&nbsp;
			대규모 1000인 미만 : <?=number_format($Price02,0)?> 원&nbsp;&nbsp;/&nbsp;&nbsp;
			대규모 1000인 이상 : <?=number_format($Price03,0)?> 원
			</td>
		</tr>
		<tr>
			<th>내용<br>전문가</th>
			<td bgcolor="#FFFFFF"> <?=$Professor?> </td>
			<th>학급정원</th>
			<td bgcolor="#FFFFFF"> <?=$Limited?> 명</td>
			<th>컨텐츠<br>유효기간</th>
			<td bgcolor="#FFFFFF"> <?=$ContentsPeriod?></td>
			<th>인정만료일</th>
			<td bgcolor="#FFFFFF"> <?=$ContentsAccredit?>  ~ <?=$ContentsExpire?></td>
		</tr>
		<tr>
			<th>CP사</th>
			<td bgcolor="#FFFFFF"> <?=$Cp?></td>
			<th>CP 수수료</th>
			<td bgcolor="#FFFFFF"> <?=$Commission?> %</td>
			<th>모바일<br>지원</th>
			<td bgcolor="#FFFFFF"> <?=$UseYN_array[$Mobile]?></td>
			<th>교재비</th>
			<td bgcolor="#FFFFFF"> <?=number_format($BookPrice,0)?> 원</td>
		</tr>
		<tr>
			<th>참고도서<br>설명</th>
			<td bgcolor="#FFFFFF"> <?=$BookIntro?></td>
			<th>학습자료<br>등록</th>
			<td bgcolor="#FFFFFF"><?=$attachFileView?></td>
			<th>과정<br>이미지</th>
			<td bgcolor="#FFFFFF"><?=$PreviewImageView?></td>
			<th>교재<br>이미지</th>
			<td bgcolor="#FFFFFF"><?=$BookImageView?></td>
		</tr>
		<tr>
			<th>중간평가<br>[객관식]</th>
			<td bgcolor="#FFFFFF"> 문항수 : <?=$Mid01EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Mid01Score?> 점</td>
			<th>중간평가<br>[단답형]</th>
			<td bgcolor="#FFFFFF">문항수 : <?=$Mid02EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Mid02Score?> 점</td>
			<th>중간평가<br>[서술형]</th>
			<td bgcolor="#FFFFFF" colspan="3"> 문항수 : <?=$Mid03EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Mid03Score?> 점</td>
		</tr>
		<tr>
			<th>최종평가<br>[객관식]</th>
			<td bgcolor="#FFFFFF"> 문항수 : <?=$Test01EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Test01Score?> 점</td>
			<th>최종평가<br>[단답형]</th>
			<td bgcolor="#FFFFFF">문항수 : <?=$Test02EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Test02Score?> 점</td>
			<th>최종평가<br>[서술형]</th>
			<td bgcolor="#FFFFFF" colspan="3">문항수 : <?=$Test03EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Test03Score?> 점</td>
		</tr>
		<tr>
			<th>과제<br>[객관식]</th>
			<td bgcolor="#FFFFFF"> 문항수 : <?=$Report01EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Report01Score?> 점</td>
			<th>과제<br>[단답형]</th>
			<td bgcolor="#FFFFFF">문항수 : <?=$Report02EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Report02Score?> 점</td>
			<th>과제<br>[서술형]</th>
			<td bgcolor="#FFFFFF" colspan="3">문항수 : <?=$Report03EA?> 문항&nbsp;&nbsp;/&nbsp;&nbsp;배점 : <?=$Report03Score?> 점</td>
		</tr>
		<tr>
			<th>시험<br>제한시간</th>
			<td bgcolor="#FFFFFF"> <?=$TestTime?> 분</td>
			<th>반영비율</th>
			<td bgcolor="#FFFFFF" colspan="5"> 중간평가  : <?=$MidRate?> %&nbsp;&nbsp;/&nbsp;&nbsp;최종평가  : <?=$TestRate?> %&nbsp;&nbsp;/&nbsp;&nbsp;과제  : <?=$ReportRate?> %</td>
		</tr>
		<tr>
			<th>수료기준</th>
			<td bgcolor="#FFFFFF" colspan="7"> 
			<span class="redB">진도율 </span>  : <?=$PassProgress?> %이상&nbsp;&nbsp;/&nbsp;&nbsp;
			<span class="redB">중간평가</span>  : 총점 <?=$TotalPassMid?> 점&nbsp;&nbsp;/&nbsp;&nbsp;
			<span class="redB">최종평가</span>  : 총점 <?=$TotalPassTest?> 점 중 <?=$PassTest?> 점 이상&nbsp;&nbsp;/&nbsp;&nbsp;
			<span class="redB">과제</span>  : 총점 <?=$TotalPassReport?> 점 중 <?=$PassReport?> 점 이상&nbsp;&nbsp;/&nbsp;&nbsp;
			<br><span class="redB">반영비율을 적용한 총점 </span>  : <?=$PassScore?> 점 이상 수료
			</td>
		</tr>
		<tr>
			<th>과정소개</th>
			<td colspan="7"><?=$Intro?></td>
		</tr>
		<tr>
			<th>교육대상</th>
			<td  colspan="7"><?=$EduTarget?></td>
		</tr>
		<tr>
			<th>교육목표</th>
			<td colspan="7"><?=$EduGoal?></td>
		</tr>
	</table>


	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
		<tr>
			<td align="left" width="200">&nbsp;</td>
			<td align="center"> </td>
			<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
		</tr>
	</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>