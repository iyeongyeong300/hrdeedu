<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
include "./include/include_admin_check.php";

$CompanyNameA    = Replace_Check($CompanyName);
$LectureStartA   = Replace_Check($LectureStart);
$LectureEndA     = Replace_Check($LectureEnd);
$ServiceTypeA    = Replace_Check($ServiceType);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title><?=$SiteName?>_교육결과보고서(전체)_<?=$CompanyNameA?></title>
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
	$whereA = array();
	if($ServiceTypeA){
	    $whereA[] = "s.ServiceType = '$ServiceTypeA'";
	}
	if($CompanyNameA){
	    $whereA[] = "c.CompanyName = '$CompanyNameA'";
	}
	$whereA[] = "s.LectureStart='$LectureStartA'";
	$whereA[] = "s.LectureEnd='$LectureEndA'";	
	$whereA = implode(" AND ",$whereA);
	if($whereA) $whereA = "WHERE $whereA";
	
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

    	$LectureIsValid = false;
    	
    	$SqlC = "SELECT * FROM Course WHERE LectureCode = '$LectureCode' AND ServiceType = '$ServiceType'";
    	$QUERYC = mysqli_query($connect, $SqlC);
    	$RowC = mysqli_fetch_array($QUERYC);
    	
    	if($RowC) {
    	    $LectureIsValid = true;
    	}
    	
    	if($LectureIsValid){
        	$where = array();    
        	$where[] = "a.CompanyCode='$CompanyCode'";
        	$where[] = "a.LectureStart='$LectureStart'";
        	$where[] = "a.LectureEnd='$LectureEnd'";
        	$where[] = "a.ServiceType='$ServiceType'";
        	
        	$where[] = "m.MemberOut = 'N'";
        	$where[] = "m.UseYN='Y'";
        	$where[] = "m.Name NOT LIKE '%퇴사%'";
        	
        	$where = implode(" AND ",$where);
        	if($where) $where = "WHERE $where";
        		
        	$JoinQuery = " Study a JOIN Member m ON a.ID=m.ID ";
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
							<td style="font-size:34px; font-weight:bold; border:1px #000 dashed; border-left:0px; border-right:5px #5D5D5D solid;  border-bottom:5px #5D5D5D solid; ">교육결과보고서</td>
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
						<td colspan=3>“다음과 같이 교육결과보고서를 제출합니다.”</td>
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
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">1-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육내용</td>
						</tr>
					</table>
					<table class="mb10">
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

					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">1-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육결과</td>
						</tr>
					</table>
					<?php
					$SQL2 = "SELECT COUNT(*) AS StudyTotalCount, COUNT(CASE WHEN a.PassOK='Y' THEN 1 END) AS StudyPassOkCount FROM $JoinQuery $where AND a.LectureCode = '$LectureCode' ";
					$QUERY2 = mysqli_query($connect, $SQL2);
					$ROW2 = mysqli_fetch_array($QUERY2);
					
					if($ROW2){
						extract($ROW2);
					}
					?>
					<table class="mb10">
						<tr>
							<th width="20%">교육인원(명)</th>
							<th>수료인원(명)</th>
							<th>미수료인원(명)</th>
						</tr>
						<tr>
							<td><?=$StudyTotalCount?></td>
							<td><?=$StudyPassOkCount?></td>
							<td><?=$StudyTotalCount - $StudyPassOkCount?></td>
						</tr>		
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- 교육개요 ====================================================================== -->
	
	<!-- 교육생별 수료 현황====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
				<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">2. 교육생별 수료 현황</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">수료자</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>연번</th>
							<th>성명</th>
							<th>생년월일</th>
							<th>진도율</th>
							<th>비고</th>
						</tr>

						<?
						$SQL3 = "SELECT a.Seq, a.Progress,
						(CASE WHEN a.MidScore IS NULL THEN 0 ELSE a.MidScore END) MidScore, 
						(CASE WHEN a.TestScore IS NULL THEN 0 ELSE a.TestScore END) TestScore, 
						(CASE WHEN a.ReportScore IS NULL THEN 0 ELSE a.ReportScore END) ReportScore, 
						(CASE WHEN a.TotalScore IS NULL THEN 0 ELSE a.TotalScore END) TotalScore, 
						a.PassOK, a.Price, a.rPrice, m.Name, AES_DECRYPT(UNHEX(m.BirthDay),'$DB_Enc_Key') AS BirthDay 
						FROM $JoinQuery $where AND PassOK ='Y' AND a.LectureCode = '$LectureCode' ORDER BY m.Name ASC";

						$i3 = 1;
						$QUERY3 = mysqli_query($connect, $SQL3);
						if($QUERY3 && mysqli_num_rows($QUERY3))
						{
							while($ROW3 = mysqli_fetch_array($QUERY3))
							{
								extract($ROW3);

								if($PassOK == "Y") {
									$PassOK = "수료";
								} else {
									$PassOK = "미수료";
								}
								
						?>
						<tr>
							<td style="page-break-inside: avoid;"><?=$i3?></td>
							<td><?=$Name?></td>
							<td><?=$BirthDay?></td>
							<td><?=$Progress?></td>
							<td></td>
						</tr>
						<? 
							$i3++;
							}
						}else{
						?>
						<tr>
							<td colspan="5">수료자가 없습니다.</td>
						</tr>
						<?
						}
					?>
					</table>

					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">미수료자</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>연번</th>
							<th>성명</th>
							<th>생년월일</th>
							<th>진도율</th>
							<th>비고</th>
						</tr>

						<?
						$SQL4 = "SELECT a.Seq, a.Progress,
						(CASE WHEN a.MidScore IS NULL THEN 0 ELSE a.MidScore END) MidScore, 
						(CASE WHEN a.TestScore IS NULL THEN 0 ELSE a.TestScore END) TestScore, 
						(CASE WHEN a.ReportScore IS NULL THEN 0 ELSE a.ReportScore END) ReportScore, 
						(CASE WHEN a.TotalScore IS NULL THEN 0 ELSE a.TotalScore END) TotalScore, 
						a.PassOK, a.Price, a.rPrice, m.Name, AES_DECRYPT(UNHEX(m.BirthDay),'$DB_Enc_Key') AS BirthDay 
						FROM $JoinQuery $where AND PassOK ='N' AND a.LectureCode = '$LectureCode' ORDER BY m.Name ASC";

						$i4 = 1;
						$QUERY4 = mysqli_query($connect, $SQL4);
						if($QUERY4 && mysqli_num_rows($QUERY4))
						{
							while($ROW4 = mysqli_fetch_array($QUERY4))
							{
								extract($ROW4);

								if($PassOK == "Y") {
									$PassOK = "수료";
								} else {
									$PassOK = "미수료";
								}
								
								
								if(($ServiceType=='5')&&($Progress == 100)) {
									$Etc = "이수";
								} else {
									$Etc = "";
								}
						?>
						<tr>
							<td style="page-break-inside: avoid;"><?=$i4?></td>
							<td><?=$Name?></td>
							<td><?=$BirthDay?></td>
							<td><?=$Progress?></td>
							<td><?=$Etc?></td>
						</tr>
						<? 
							$i4++;
							}
						}else{
						?>
						<tr>
							<td colspan="5">미수료자가 없습니다.</td>
						</tr>
						<?
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