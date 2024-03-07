<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
include "./include/include_admin_check.php";

$CompanyNameA    = Replace_Check($CompanyName);
$LectureStartA   = Replace_Check($LectureStart);
$LectureEndA     = Replace_Check($LectureEnd);
$ServiceTypeA    = Replace_Check($ServiceType);


$whereA = array();
if($CompanyNameA){
    $whereA[] = "c.CompanyName = '$CompanyNameA'";
}
$whereA[] = "s.LectureStart='$LectureStartA'";
$whereA[] = "s.LectureEnd='$LectureEndA'";
$whereA[] = "s.ServiceType = 1";

$whereA = implode(" AND ",$whereA);
if($whereA) $whereA = "WHERE $whereA";

$SqlS = "SELECT s.CompanyCode, s.LectureCode, s.ServiceType , s.LectureStart , s.LectureEnd , c.CompanyName
        FROM Study s JOIN Company c JOIN Course f ON s.CompanyCode = c.CompanyCode and s.LectureCode = f.LectureCode
        $whereA
        GROUP BY s.CompanyCode, s.LectureCode, s.ServiceType
        ORDER BY c.CompanyName, f.ContentsName, s.ServiceType";
$ResultS = mysqli_query($connect, $SqlS);
$RowS = mysqli_fetch_array($ResultS);
$TOT_NO = $RowS[0];

if($TOT_NO == 0){
?>
<script type="text/javascript">
<!--
	alert("교육진행보고서가 없습니다.");
	self.close();
//-->
</script>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style2.css?v230918" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>

<style>
* {font-family: sans-serif; }
@page{
  margin-top: 70px;
  margin-bottom: 70px;
}
body {-webkit-print-color-adjust: exact;}
</style>
</HEAD>
<BODY>
<div id="certi_print_wrap" class="certi_print_wrap" style="width:830px">
	<?php
	$SqlA = "SELECT s.CompanyCode, s.LectureCode, s.ServiceType , s.LectureStart , s.LectureEnd , c.CompanyName 
            FROM Study s JOIN Company c JOIN Course f ON s.CompanyCode = c.CompanyCode and s.LectureCode = f.LectureCode
            $whereA
            GROUP BY s.CompanyCode, s.LectureCode, s.ServiceType
            ORDER BY c.CompanyName, f.ContentsName, s.ServiceType";
    $QUERYA = mysqli_query($connect, $SqlA);
    while($ROWA = mysqli_fetch_array($QUERYA)){
        $CompanyCode  = $ROWA['CompanyCode'];
        $LectureCode  = $ROWA['LectureCode'];
        $ServiceType  = $ROWA['ServiceType'];
        $LectureStart = $ROWA['LectureStart'];
        $LectureEnd   = $ROWA['LectureEnd'];
        $CompanyName  = $ROWA['CompanyName'];
    ?>
	<!-- 페이지 1====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<table>
						<tr>
						<td width="12%">문서번호</td>
						<td width="25%"></td>
						<td rowspan="2" width="7%">결<br/>재</td>
						<td width="12%">담당</td>
						<td width="12%"></td>
						<td width="12%"></td>
						<td width="12%">대표이사</td>
						</tr>
						<tr>
						<td>접수일자</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						</tr>
					</table>
				</div>
				<div class="tableArea" style="margin-top:140px">
					<table style="border:0px">
						<tr>
							<td style="font-size:20px; font-weight:bold; border:1px #000 dashed; border-bottom:5px #5D5D5D solid;width:120px">별지 3_2</td>
							<td style="font-size:34px; font-weight:bold; border:1px #000 dashed; border-left:0px; border-right:5px #5D5D5D solid;  border-bottom:5px #5D5D5D solid; ">교육진행보고서</td>
						</tr>
					</table>
				</div>
				<?php
				$SQL = "SELECT LectureCode, ContentsName FROM Course WHERE LectureCode = '$LectureCode' AND ServiceType = '$ServiceType'";
				$QUERY = mysqli_query($connect, $SQL);
				$Row = mysqli_fetch_array($QUERY);

				if($Row) {
					$ContentsName = $Row['ContentsName'];
				}
				
				?>

				<div class="tableArea mainTitle02">
					<table>
						<tr>
						<td>고객사</td>
						<td colspan=2><?=$CompanyName?></td>
						</tr>
						<tr>
						<td>교육명</td>
						<td colspan=2><?=$ContentsName?></td>
						</tr>
						<tr>
						<td rowspan=2>작성자</td>
						<td width="42%">소속</td>
						<td width="42%">성명</td>
						</tr>
						<tr>
						<td>훈련운영부</td>
						<td><?=$_COOKIE["LoginAdminName"]?></td>
						</tr>
						<tr>
						<td>작성일</td>
						<td colspan=2><?=date("Y년 m월 d일");?></td>
						</tr>
						<tr>
						<td colspan=3>“다음과 같이 교육진행보고서를 제출합니다.”</td>
						</tr>
					</table>
				</div>

				<div class="tableArea" style="text-align:center; margin-top:120px">
					<table style="margin:0 auto; border:0; font-weight:bold;">
						<tr>
						<td style="border:0"></td>
						<td width="60" style="border:0"><img src="/images/logo_mark.png" align="absmiddle" width="55" height="55" /></td>
						<td style="border:0;text-align:left; width:220px;">
							<div style="font-size:19px;margin-bottom:5px;">고용노동부 인증</div>
							<div style="font-size:28px;"><?=$CertSiteName?></div>
						</td>
						<td width="96" style="border:0"><img src="/images/company_stamp.png" align="absmiddle" width="95" height="98" /></td>
						<td style="border:0"></td>
						</tr>
					</table>
				</div>

				<div class="tableArea" style="margin-top:90px;">
					<table style="font-weight:bold;">
						<tr>
						<td style="font-size:15px; color:red;">대리수강 · 대리평가 · 답안지제공 등은 부정훈련입니다.</td>
						</tr>
						<tr>
						<td style="font-size:15px; color:red;">부정훈련신고 시 소정의 사례를 드립니다.</td>
						</tr>
						<tr>
						<td style="font-size:15px;">부정훈련 신고 직통전화 / 담당자 전화번호 / 1811-9530</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- 페이지 1====================================================================== -->
	
	<!-- 교육개요 ====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">1. 교육개요</div>
					<table>
						<tr>
							<th>구분</th>
							<th>내용</th>
						</tr>
						<tr>
							<td>교육명</td>
							<td><?=$ContentsName?></td>
						</tr>
						<tr>
							<td>교육기간</td>
							<td><?=$LectureStart?> - <?=$LectureEnd?></td>
						</tr>
						<tr>
							<td>교육대상</td>
							<td>전 근로자</td>
						</tr>
						<tr>
							<td>교육방법</td>
							<td>개별 온라인 교육</td>
						</tr>
						<tr>
							<td style="vertical-align:top">교육내용</td>
							<td style="width:630px;padding:8px;">
								<table style="width:100%;">
									<tr>
										<th style="width:27px">차시</th>
										<th>차시명</th>
										<th>내용</th>
									</tr>
									<?
										$Sql_s = "SELECT COUNT(Seq) FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='A'";
										$Result_s = mysqli_query($connect, $Sql_s);
										$Row_s = mysqli_fetch_array($Result_s);
										$Chapter_Count = $Row_s[0];

										$k = 0;
										$SQL3 = "SELECT a.Seq AS Chapter_seq, a.ChapterType, a.OrderByNum, a.Sub_idx, b.Gubun AS ContentGubun, b.ContentsTitle, b.Expl02 
										FROM Chapter AS a LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
										WHERE a.LectureCode='$LectureCode' AND a.ChapterType='A' ORDER BY a.OrderByNum ASC";

										$QUERY3 = mysqli_query($connect, $SQL3);
										if($QUERY3 && mysqli_num_rows($QUERY3))
										{
											while($ROW3 = mysqli_fetch_array($QUERY3))
											{

											$OrderByNumArray[$k] = $ROW3['OrderByNum'];
											$ContentsTitleArray[$k] = $ROW3['ContentsTitle'];
											$ContentArray[$k] = $ROW3['Expl02'];

										$k++;
											}
										}

										//$Loop_number = round($Chapter_Count / 2);
									?>
									<?
									for($k2=1;$k2<=$Chapter_Count;$k2++) {
									?>
									<tr>
										<td style="padding:5px 8px; text-align:center;page-break-inside: avoid;"><?=$OrderByNumArray[$k2-1]?></td>
										<td style="padding:5px 8px; text-align:left;page-break-inside: avoid;"><?=$ContentsTitleArray[$k2-1]?></td>
										<td style="padding:5px 8px; text-align:left;page-break-inside: avoid;"><?=nl2br($ContentArray[$k2-1])?></td>  
									</tr>
								<?
									}
								?>
							</table>
						</td>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- 교육개요 ====================================================================== -->
	<?php
		$where = array();

		$where[] = "a.CompanyCode='$CompanyCode'";
		$where[] = "a.LectureStart='$LectureStart'";
		$where[] = "a.LectureEnd='$LectureEnd'";

		if ($LectureCode) {
			$where[] = "a.LectureCode='$LectureCode'";
		}	

		$where[] = "a.ServiceType='$ServiceType'";

		$where[] = "m.MemberOut = 'N'";
		$where[] = "m.UseYN='Y'";
		$where[] = "m.Name NOT LIKE '%퇴사%'";
		
		$where = implode(" AND ",$where);
		if($where) $where = "WHERE $where";
			
		$JoinQuery = " Study a JOIN Member m ON a.ID=m.ID ";
	?>
	
	<!-- 훈련운영 진행===================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
				<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">2. 훈련운영 진행</div>
				
				<?php
					$SQL2 = "SELECT COUNT(CASE WHEN a.PassOK='Y' THEN 1 END) AS StudyPassOkCount, 
					COUNT(CASE WHEN a.PassOK='N' AND Progress='0' THEN 1 END) AS CountProgress1,
					COUNT(CASE WHEN a.PassOK='N' AND Progress<'80' THEN 1 END) AS CountProgress2,
					COUNT(CASE WHEN a.PassOK='N' AND Progress>'80' THEN 1 END) AS CountProgress3,
					COUNT(*) AS StudyTotalCount FROM $JoinQuery $where";
					$QUERY2 = mysqli_query($connect, $SQL2);
					$ROW2 = mysqli_fetch_array($QUERY2);
					
					if($ROW2){
						extract($ROW2);
						$PassOkRate = round(($StudyPassOkCount / $StudyTotalCount) * 100);
						$NoPassOkRate = 100 - $PassOkRate;
					}
				?>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">총괄</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th width="20%">구분</th>
							<th>인원(명)</th>
							<th>비율(%)</th>
						</tr>
						<tr>
							<td>교육인원</td>
							<td><?=$StudyTotalCount?></td>
							<td>100</td>
						</tr>
						<tr>
							<td>수료자</td>
							<td><?=$StudyPassOkCount?></td>
							<td><?=$PassOkRate?></td>
						</tr>
						<tr>
							<td>미수료자</td>
							<td><?=$StudyTotalCount-$StudyPassOkCount?></td>
							<td><?=$NoPassOkRate?></td>
						</tr>		
					</table>
					
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">미수료자 진도율 현황</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th width="20%">구분</th>
							<th>현황</th>
						</tr>
						<tr>
							<td>진도율 분석</td>
							<td style="text-align:left;padding:20px;">
								  <table>
									<tr>
										<th width="50%">진도율</th>
										<th>인원(명)</th>
									</tr>
									<tr>
										<td>0%</td>
										<td><?=$CountProgress1?></td>
									</tr>
									<tr>
										<td>80% 미만</td>
										<td><?=$CountProgress2?></td>
									</tr>
									<tr>
										<td>80% 이상</td>
										<td><?=$CountProgress3?></td>
									</tr>
								  </table>
								  <br>
								1. 0% 미만의 훈련생 : 1일 최대 수강 가능차시는 8차시로 하루만에 수료 가능합니다. 수강 80%이상 및 시험응시 진행해야 합니다.<br>
								2. 80% 미만 훈련생 : 진도율 80%이상까지 수강 후, 훈련종료일까지 시험에 응시해야 합니다.<br>
								3. 80% 이상 훈련생 : 시험 미응시자들은 반드시 훈련종료일까지는 시험에 응시해야 합니다.                    
							</td>
						</tr>
					</table>
					
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-3</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">진도율 향상 계획</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th width="20%">구분</th>
							<th>세부 내용</th>
						</tr>
						<tr>
							<td rowspan=2>3주 차</td>
							<td style="text-align:left;">학습진도율 0% 학습자의 경우 교육담당자님의 도움이 필요합니다.</td>
						</tr>
						<tr>
							<td style="text-align:left;">학습진도율 80% 미만 학습자는 개별 카톡 또는 문자를 발송합니다.</td>
						</tr>
						<tr>
							<td rowspan=2>4주 차</td>
							<td style="text-align:left;">학습진도율 80 % 미만 학습자는 개별 카톡 또는 문자/전화를 드립니다.</td>
						</tr>
						<tr>
							<td style="text-align:left;">교육담당자님과 협의 후, 미수료자에 대한 대책을 수립합니다.</td>
						</tr>
					</table>
					
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-4</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">요청사항</td>
						</tr>
					</table>
					<table style="text-align:left; border:1px solid #000;">
						<tr>
							<td style="text-align:left; border:0px;">□ 교육이 왜 진행되는지, 앞으로 어떻게 진행되는지 문의하시는 분이 많습니다.</td>
						</tr>
						<tr>
							<td style="text-align:left; border:0px;">□ 본사에서 교육의 필요성과 연간 일정을 안내해 주신다면 교육 진도율과 수료율을 높일 수 있다고 판단 하고 있습니다.</td>
						</tr>
						<tr>
							<td style="text-align:left; border:0px;">□ 법정 및 산업안전보건, 근로자 직무능력향상교육은 처음 1회차 교육이 중요합니다.
							한번 교육을 받으시고 나면 2회 차의 교육은 대부분의 근로자들이 교육의 필요성을 받아 들이시기 때문에 교육진행이 훨씬 용이합니다.</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- 학습자 주요 문의사항===================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
				<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">3. 학습자 주요 문의사항</div>
					<table class="certi-print-qna">
						<tr>
							<td rowspan=2>1</td>
							<td style="width:25px">Q</td>
							<td>사전에 교육 공지가 없었는데 왜 갑자기 진행하나요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>1. 오리엔테이션 자료 발송 및 개강문자 발송 등으로 안내<br>2. 추가적 질의는 회사에 문의 요청</td>
						</tr>
						<tr>
							<td rowspan=2>2</td>
							<td>Q</td>
							<td>향후에도 교육을 계속 받아야 하나요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>1. 법정교육 연 1회, 안전보건교육 연 4회 안내<br>2. 향후 일정은 회사와 협의 진행 안내</td>
						</tr>
						<tr>
							<td rowspan=2>3</td>
							<td>Q</td>
							<td>PC가 없어요.</td>
						</tr>
						<tr>
							<td>A</td>
							<td>핸드폰으로 수강 가능 안내</td>
						</tr>
						<tr>
							<td rowspan=2>4</td>
							<td>Q</td>
							<td>평가는 모바일로 가능한가요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>고용노동부 지침에 의해 평가는 PC에서만 가능 안내</td>
						</tr>
						<tr>
							<td rowspan=2>5</td>
							<td>Q</td>
							<td>컴퓨터 또는 모바일 사용법을 몰라요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>개별 지도 및 원격 지원</td>
						</tr>
						<tr>
							<td rowspan=2>6</td>
							<td>Q</td>
							<td>로그인이 되지 않아요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>아이디 · 비밀번호 오류 및 회원유형 잘못 선택 안내</td>
						</tr>
						<tr>
							<td rowspan=2>7</td>
							<td>Q</td>
							<td>본인 인증이 되지 않아요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>1. 크롬 및 엣지 다운로드 안내<br>2. 사내 PC 방화벽 문제가 있을 수 있으므로 모바일 인증 진행 안내</td>
						</tr>
						<tr>
							<td rowspan=2>8</td>
							<td>Q</td>
							<td>평가가 어려운데 도와 주세요.</td>
						</tr>
						<tr>
							<td>A</td>
							<td>학습자료 요약집 배포 및 안내</td>
						</tr>
						<tr>
							<td rowspan=2>9</td>
							<td>Q</td>
							<td>다음 차시 수강이 되지 않아요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>이전 차시 13분 학습 미충족 시 다음 차시 수강 제한 안내</td>
						</tr>
						<tr>
							<td rowspan=2>10</td>
							<td>Q</td>
							<td>하루에 8개 차시 이상 수강하면 안되나요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>고용노동부 원격훈련 규정상 하루 8차시까지만 수강 가능 안내</td>
						</tr>
						<tr>
							<td rowspan=2>11</td>
							<td>Q</td>
							<td>재평가는 언제 실시되나요?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>훈련 종료 후 1주일 동안 재평가 응시 가능 안내</td>
						</tr>
						<tr>
							<td rowspan=2>12</td>
							<td>Q</td>
							<td>AI 직무교육이 필요한 이유?</td>
						</tr>
						<tr>
							<td>A</td>
							<td>4차 산업 혁명에 대한 소양 및 교양 함양을 위해 정부에서 권장 안내</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- 교육생별 진도율 현황====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
				<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">4. 교육생별 진도율 현황</div>
				<table>
					<tr>
						<th>연번</th>
						<th>성명</th>
						<th>생년월일</th>
						<th>진도율</th>
						<th>수료여부</th>
					</tr>

					<?
						$Study_Seq = "";
						$SQL2 = "SELECT a.Seq, a.Progress,										
						(CASE WHEN a.MidScore IS NULL THEN 0 ELSE a.MidScore END) MidScore, 
						(CASE WHEN a.TestScore IS NULL THEN 0 ELSE a.TestScore END) TestScore, 
						(CASE WHEN a.ReportScore IS NULL THEN 0 ELSE a.ReportScore END) ReportScore, 
						(CASE WHEN a.TotalScore IS NULL THEN 0 ELSE a.TotalScore END) TotalScore, 
						a.PassOK, a.Price, a.rPrice, m.Name, AES_DECRYPT(UNHEX(m.BirthDay),'$DB_Enc_Key') AS BirthDay 
						FROM $JoinQuery $where ORDER BY a.PassOK ASC, m.Name ASC";

						$i2 = 1;
						$QUERY2 = mysqli_query($connect, $SQL2);
						if($QUERY2 && mysqli_num_rows($QUERY2))
						{
							while($ROW2 = mysqli_fetch_array($QUERY2))
							{

								if($ROW2['MidScore'] == null) {
									$MidScore = "0";
								} else {
									$MidScore = $ROW2['MidScore'];
								}

								if($ROW2['TestScore'] == null) {
									$TestScore = "0";
								} else {
									$TestScore = $ROW2['TestScore'];
								}

								if($ROW2['ReportScore'] == null) {
									$ReportScore = "0";
								} else {
									$ReportScore = $ROW2['ReportScore'];
								}

								if($ROW2['TotalScore'] == null) {
									$TotalScore = "0";
								} else {
									$TotalScore = $ROW2['TotalScore'];
								}

								if($ROW2['PassOK'] == "Y") {
									$PassOK = "수료";
								} else {
									$PassOK = "미수료";
								}

								if(!$Study_Seq) {
									$Study_Seq = $ROW2['Seq'];
								}else{
									$Study_Seq = $Study_Seq.", ".$ROW2['Seq'];
								}
								
						?>
					<tr>
						<td style="page-break-inside: avoid;"><?=$i2?></td>
						<td><?=$ROW2['Name']?></td>
						<td><?=$ROW2['BirthDay']?></td>
						<td><?=$ROW2['Progress']?></td>
						<td><?=$PassOK?></td>
					</tr>
						<? 
						$i2++;
							}
						}
						?>
				  </table>
				</div>
			</div>
		</div>
	</div>
	<!-- 교육생별 진도율 현황====================================================================== -->
	<?php
    }
    ?>
</div>

<script> 
$(function(){
	window.print();
}); 
</script>
</BODY>
</html>
<?
mysqli_close($connect);
?>