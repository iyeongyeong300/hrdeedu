<?
include "../include/include_function.php";

include "../include/login_check.php";


if($LoginEduManager!="Y") {
?>
<script type="text/javascript">
<!--
	location.href="/";
//-->
</script>
<?
exit;
}


$LectureStart = Replace_Check_XSS2($LectureStart);
$LectureEnd = Replace_Check_XSS2($LectureEnd);
$LectureCode = Replace_Check_XSS2($LectureCode);

$PassOk = Replace_Check_XSS2($PassOk);
$col = Replace_Check_XSS2($col);
$sw = Replace_Check_XSS2($sw);


$Sql = "SELECT *, (SELECT CompanyName FROM Company WHERE CompanyCode=Member.CompanyCode LIMIT 0,1) AS CompanyName FROM Member WHERE ID='$LoginMemberID' AND MemberOut='N' AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyCode = $Row['CompanyCode']; //사업자 번호
	$CompanyName = $Row['CompanyName']; //소속기업명
}

$Sql = "SELECT 
a.CompanyCode, c.Category1, c.Category2, 
(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND PassOk='Y') AS StudyCount, 
(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND PassOk='N') AS StudyBeCount, 
(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5,9) AND PassOk='Y') AS StudyCount2, 
(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5,9) AND PassOk='N') AS StudyBeCount2, 
c.ContentsName, c.LectureCode 
FROM Study AS a 
LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
LEFT OUTER JOIN Course AS c ON a.LectureCode=c.LectureCode 
WHERE b.CompanyCode='$CompanyCode' AND a.ServiceType IN (1,3,5) AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$StudyCount = $Row['StudyCount']; //환급수료인원
	$StudyBeCount = $Row['StudyBeCount']; //환급 미수료인원

	$StudySum = $StudyCount + $StudyBeCount; //환급 전체인원

	$StudyCount2 = $Row['StudyCount2']; //비환급수료인원
	$StudyBeCount2 = $Row['StudyBeCount2']; //비환급 미수료인원

	$StudySum2 = $StudyCount2 + $StudyBeCount2; //비환급 전체인원

	$ContentsName = $Row['ContentsName'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$HTML_TITLE?><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="-1"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="No-Cache"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/jquery.bxslider.css?t=20190126" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript">
<!--
var browser = "<?=$browser?>";
//-->
</script>
<!-- <script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript" src="/include/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
<script type="text/javascript" src="/include/jquery.bxslider.min.js"></script>
<script type="text/javascript">
<!--
function ManagerSearchOk() {

	/*
	if($("#sw").val()=="") {
		alert("검색어를 입력하세요.");
		return;
	}
	*/
	SearchForm1.submit();

}

function ManagerOrderBy(str) {

	document.SearchForm1.orderby.value = str;
	SearchForm1.submit();

}

function ManagerExcelOut() {
	ExcelForm.submit();
}
//-->
</script>
</head>

<body>
<form name="ExcelForm" method="POST" action="manager_trainee_excel.php" target="_blank">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="LectureStart" value="<?=$LectureStart?>">
<input type="hidden" name="LectureEnd" value="<?=$LectureEnd?>">
<input type="hidden" name="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="PassOk" value="<?=$PassOk?>">
<input type="hidden" name="CompanyCode" value="<?=$CompanyCode?>">
</form>
	<div id="wrap">
    
    	<div class="popupArea">
        	<!-- close -->
            <div class="close"><a href="Javascript:self.close();"><img src="../images/common/btn_close01.png" alt="창닫기" /></a></div>
       	  	<!-- title -->
            <div class="popName">수강현황</div>
            <!-- info Area -->
            <div class="infoArea">
            	
                <!-- ########## -->
            	<div class="managerTxt">
                    <p class="term"><?=$LectureStart?> ~ <?=$LectureEnd?> 개강</p>
                    <p>
                        <span><em>환급수료인원 : </em><strong><?=$StudyCount?>명</strong> / <?=$StudySum?>명</span>
                        <span><em>비환급수료인원 : </em><strong><?=$StudyCount2?>명</strong> / <?=$StudySum2?>명</span>
                    </p>
                  <p class="title"><?=$ContentsName?></p>
                </div>
                
                <!-- search -->
				<form name="SearchForm1" method="POST" action="/mypage/manager_trainee_list.php">
					<input type="hidden" name="orderby" id="orderby" value="a.Seq DESC">
					<input type="hidden" name="LectureStart" id="LectureStart" value="<?=$LectureStart?>">
					<input type="hidden" name="LectureEnd" id="LectureEnd" value="<?=$LectureEnd?>">
					<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
				<div class="search mt20">
                	<span>
						<select name="PassOk" id="PassOk" class="wid150">
                			<option value="">수료여부</option>
                			<option value="Y" <?if($PassOk=="Y") {?>selected<?}?>>수료</option>
							<option value="N" <?if($PassOk=="N") {?>selected<?}?>>미수료</option>
                		</select>
                	</span>
                    <span>
						<select name="col" id="col" class="wid150">
                			<option value="c.Name" <?if($col=="c.Name") {?>selected<?}?>>이름</option>
                    		<option value="a.ID" <?if($col=="a.ID") {?>selected<?}?>>ID</option>
                		</select>
                	</span>
                    <span><input type="text" name="sw" id="sw" class="wid200" placeholder="검색어 입력" /></span>
                    <span class="btn"><a href="Javascript:ManagerSearchOk();">검색</a></span>
                </div>
				</form>
                <!-- search // -->
				<?
				##-- 검색 조건
				$where = array();

				$where[] = "a.CompanyCode='".$CompanyCode."'";

				$where[] = "a.LectureStart='".$LectureStart."'";

				$where[] = "a.LectureEnd='".$LectureEnd."'";

				$where[] = "a.LectureCode='".$LectureCode."'";

				if($PassOk) {
					$where[] = "a.PassOk='".$PassOk."'";
				}

				$where[] = "a.ServiceType IN (1,3,5,9)";

				if($sw){
					$where[] = "$col LIKE '%$sw%'";
				}

				$where = implode(" AND ",$where);
				if($where) $where = "WHERE $where";

				if(!$orderby) {
					$str_orderby = "ORDER BY a.Seq DESC";
				}else{
					$str_orderby = "ORDER BY $orderby";
				}


				$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
								a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.LectureCode, a.CompanyCode, a.InputDate, 
								b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
								c.Name, c.Depart, 
								d.CompanyName, 
								e.Name AS TutorName, 
								(SELECT MAX(RegDate) FROM Progress WHERE ID=a.ID AND LectureCode=a.LectureCode AND Study_Seq=a.Seq) AS LastStudyTime 
								 ";

				$JoinQuery = " Study AS a 
										LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
										LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
										LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
										LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
									";
				?>
                <!-- list -->
                <div class="mt20">
                	<table cellpadding="0" cellspacing="0" class="taList_ty01">
                	  <caption>수강현황 목록</caption>
                	  <colgroup>
                	    <col width="*" />
                	    <col width="13%" />
                        <col width="7%" />
                        <col width="17%" />
                        <col width="17%" />
                        <col width="17%" />
                        <col width="8%" />
                        <col width="12%" />
                	  </colgroup>
                	  <tr>
                	    <th>번호<br />구분</th>
                	    <th>이름<br />아이디</th>
                	    <th>진도율</th>
                	    <th>중간응시일</th>
                	    <th>최종응시일</th>
                	    <th>과제응시일</th>
                	    <th>총점<br />수료여부</th>
                	    <th>부서</th>
                	  </tr>
					  <?
						$i = 1;
						$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
						//echo $SQL;
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($ROW = mysqli_fetch_array($QUERY))
							{
								extract($ROW);
						
								//첨삭완료일
								$Tutor_limit_day = strtotime("$LectureEnd +4 days");

								//중간평가
								if($MidRate<1) {
									$Mid_View = "평가 없음";
								}else{
									switch($MidStatus) {
										case "C":
											$MidRatePercent = $MidScore * $MidRate / 100;
											$Mid_View = $MidScore."(".$MidRatePercent.")<BR>".$MidSaveTime;
										break;
										case "Y":
											$Mid_View = "채점 대기중<BR>".$MidSaveTime;
										break;
										case "N":
											$Mid_View = "미응시";
										break;
										default :
											$Mid_View = "";
									}
								}

								//최종평가
								if($TestRate<1) {
									$Test_View = "평가 없음";
								}else{
									switch($TestStatus) {
										case "C":
											$TestRatePercent = $TestScore * $TestRate / 100;
											$Test_View = $TestScore."(".$TestRatePercent.")<BR>".$TestSaveTime;
										break;
										case "Y":
											$Test_View = "채점 대기중<BR>".$TestSaveTime;
										break;
										case "N":
											$Test_View = "미응시";
										break;
										default :
											$Test_View = "";
									}
								}

								//과제
								if($ReportRate<1) {
									$Report_View = "과제 없음";
								}else{
									switch($ReportStatus) {
										case "C":
											$ReportRatePercent = $ReportScore * $ReportRate / 100;
											$Report_View = $ReportScore."(".$ReportRatePercent.")<BR>".$ReportSaveTime;
										break;
										case "Y":
											$Report_View = "채점 대기중<BR>".$ReportSaveTime;
										break;
										case "N":
											$Report_View = "미응시";
										break;
										case "R":
											$Report_View = "반려";
										break;
										default :
											$Report_View = "";
									}
								}


								if(is_null($TotalScore)) {
									$TotalScore_View = "-";
								}else{
									$TotalScore_View = $TotalScore;
								}

								switch($PassOK) {
									case "N":
										$PassOK_View = "미수료";
									break;
									case "Y":
										$PassOK_View = "수료";
									break;
									default :
										$PassOK_View = "";
								}
						?>
                	  <tr>
                	    <td class="tc"><?=$i?><br />
               	        <?=$ServiceType_array[$ServiceType]?></td>
                	    <td class="tc"><?=$Name?><br /> 
               	        <?=$ID?></td>
                	    <td class="tc"><?=$Progress?>%</td>
                	    <td class="tc"><?=$Mid_View?></td>
                	    <td class="tc"><?=$Test_View?></td>
                	    <td class="tc"><?=$Report_View?></td>
                	    <td class="tc"><?=$TotalScore_View?><br /><?=$PassOK_View?></td>
                	    <td class="tc"><?=$Depart?></td>
               	      </tr>
					  <?
					  $i++;
						}
					}else{
					?>
					<tr>
						<td class="tc" colspan="20">수강내역이 없습니다.</td>
					</tr>
					<? } ?>
                	</table>
                </div>
                <!-- list // -->
                
                <!-- btn -->
                <div class="btnAreaTl03">
                	<span class="btnSky01"><a href="Javascript:ManagerExcelOut();">검색항목 엑셀출력</a></span>
                </div>
                <!-- ########## // -->
                
            </div>
            <!-- info Area -->
        </div>

	</div>

</body>
</html>