<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
include "./include/include_admin_check.php";

$CompanyCode = Replace_Check($CompanyCode);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$ServiceType = Replace_Check($ServiceType);
$LectureCode = Replace_Check($LectureCode);


$Sql = "SELECT CompanyName FROM Company WHERE CompanyCode='".$CompanyCode."'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyName = $Row['CompanyName'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title><?=$SiteName?>_수료결과보고서(구버전)_<?=$CompanyName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style2.css?v230918" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<!-- JQ-PLOT의 기본 설정 -->
<script type="text/javascript" src="../lib/jqplot/jquery.jqplot.js"></script>
<!-- 파이차트 관련 -->
<script type="text/javascript" src="../lib/jqplot/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="../lib/jqplot/jqplot.donutRenderer.js"></script>
<!-- 바차트 관련 -->
<script type="text/javascript" src="../lib/jqplot/jqplot.barRenderer.js"></script>
<script type="text/javascript" src="../lib/jqplot/jqplot.categoryAxisRenderer.js"></script>
<!-- 포인트,라벨 관련 -->
<script type="text/javascript" src="../lib/jqplot/jqplot.pointLabels.js"></script>
<script type="text/javascript" src="../lib/jqplot/jqplot.canvasAxisLabelRenderer.js"></script>
<script type="text/javascript" src="../lib/jqplot/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript">
<!--
function printChart(s1,s2,s3,s4,s5){

	if(s1==0 && s2==0 && s3==0 && s4==0 && s5==0 ){
		alert('수집된 데이터가 없습니다.')
	}else{
		//혼합차트 데이터
		s1 = [s1];
		s2 = [s2];
		s3 = [s3];
		s4 = [s4];
		s5 = [s5];

		var ticks = [['<BR><span style="font-size:12px">아주&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<BR>만족합니다<span>',s1,s1+'%'], ['<BR><span style="font-size:12px">만족&nbsp;&nbsp;<BR>합니다<span>',s2,s2+'%'], ['<BR><span style="font-size:12px">보통&nbsp;&nbsp;<BR>입니다<span>',s3,s3+'%'], ['<BR><span style="font-size:12px">부족&nbsp;&nbsp;<BR>합니다<span>',s4,s4+'%'] , ['<BR><span style="font-size:12px">많이 부족<BR>합니다&nbsp;&nbsp;<span>',s5,s5+'%']];

		//바챠트1
		var mixTicks = ['항목'];
		var plot2 = $.jqplot('barchart01', [ticks], {
			title:'<font size="4"><B>강의 만족도</B></font><BR><BR>',
			//seriesColors:['#FFCCE5', '#00749F', '#73C774', '#C7754C', '#17BDB8'],
			seriesDefaults:{
				renderer:$.jqplot.BarRenderer,
				rendererOptions:{
					varyBarColor:true,
					barWidth:40
				},
				pointLabels: {
					 show: true
				}
			},
			axes: {
				xaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
				},
				yaxis: {
					min: 0,
					max: 100,
					numberTicks: 5
				}

			}


		});


	}
}


function printChart2(s1,s2,s3,s4,s5){

	if(s1==0 && s2==0 && s3==0 && s4==0 && s5==0 ){
		alert('수집된 데이터가 없습니다.')
	}else{
		//혼합차트 데이터
		s1 = [s1];
		s2 = [s2];
		s3 = [s3];
		s4 = [s4];
		s5 = [s5];

		var ticks = [['<BR><span style="font-size:12px">적극 권하고<BR>싶습니다&nbsp;&nbsp;&nbsp;<span>',s1,s1+'%'], ['<BR><span style="font-size:12px">권하고&nbsp;&nbsp;<BR>싶습니다<span>',s2,s2+'%'], ['<BR><span style="font-size:12px">보통&nbsp;&nbsp;<BR>입니다<span>',s3,s3+'%'], ['<BR><span style="font-size:12px">다소 권하고&nbsp;&nbsp;<BR>싶지 않습니다<span>',s4,s4+'%'] , ['<BR><span style="font-size:12px">권하고 싶지<BR>않습니다&nbsp;&nbsp;&nbsp;<span>',s5,s5+'%']];
		//바챠트1
		var mixTicks = ['항목'];
		var plot2 = $.jqplot('barchart02', [ticks], {
			title:'<font size="4"><B>동료에게 교육 권장</B></font><BR><BR>',
			//seriesColors:['#FFCCE5', '#00749F', '#73C774', '#C7754C', '#17BDB8'],
			seriesDefaults:{
				renderer:$.jqplot.BarRenderer,
				rendererOptions:{
					varyBarColor:true,
					barWidth:40
				},
				pointLabels: {
					 show: true
				}
			},
			axes: {
				xaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
				},
				yaxis: {
					min: 0,
					max: 100,
					numberTicks: 5
				}

			}


		});


	}
}
//-->
</script>
</HEAD>
<BODY leftmargin="0" topmargin="0">
<!-- 페이지 1====================================================================== -->
<div class="certi_print">
    
	<div class="backImg"><img src="images/certi_print_img01.jpg" /></div>
    
    <div class="infoArea">
    	<p class="title_ty02">사업주 직업능력개발 인터넷 원격훈련 수료 결과서</p>
        
        <ul class="info">
        	<li>
            	<span>기&nbsp;&nbsp;업&nbsp;&nbsp;명</span>
                <span><?=$CompanyName?></span>
        	</li>
            <li>
            	<span>학습기간</span>
                <span><?=$LectureStart?> ~ <?=$LectureEnd?></span>
        	</li>
		</ul>

<?
$where = array();

$where[] = "a.CompanyCode='$CompanyCode'";

$where[] = "a.LectureStart='$LectureStart'";

$where[] = "a.LectureEnd='$LectureEnd'";
$where[] = "a.LectureCode='$LectureCode'";

//$where[] = "a.PassOk='Y'";



$where[] = "a.ServiceType='$ServiceType'";
$qServiceType = " AND ServiceType='$ServiceType'";
/*
if($ServiceTypeYN=="Y") {
	$where[] = "a.ServiceType=1";
	$qServiceType = " AND ServiceType=1";
}else{
	$where[] = "a.ServiceType IN (1,3,5)";
	$qServiceType = " AND ServiceType IN (1,3,5)";
}*/

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.PackageLevel ASC, b.ContentsName ASC";

$Colume = "DISTINCT(a.LectureCode), a.LectureStart, a.LectureEnd, 
				b.ContentsName, b.ContentsTime, 
				(SELECT SUM(Price) FROM Study WHERE CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd $qServiceType) AS TotalPrice, 
				(SELECT SUM(rPrice) FROM Study WHERE CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PassOk='Y' $qServiceType) AS TotalPrice2, 
				(SELECT COUNT(Seq) FROM Study WHERE CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd $qServiceType) AS TotalPerson, 
				(SELECT COUNT(Seq) FROM Study WHERE CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PassOk='Y' $qServiceType) AS PassOkPerson 
				";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
					";
$num = 0;
$LectureCodeArray = array();
$ContentsNameArray = array();
$TotalPersonArray = array();
$PassOkPersonArray = array();
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);

		$LectureCodeArray[] = $LectureCode;
		$ContentsNameArray[] = $ContentsName;
		$TotalPersonArray[] = $TotalPerson;
		$PassOkPersonArray[] = $PassOkPerson;
?>

		<ul class="info">
			<li>
            	<span>과&nbsp;&nbsp;정&nbsp;&nbsp;명</span>
                <span><?=$ContentsName?></span>
        	</li>
        </ul>
        
        <div class="tableArea">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>총 수강인원</td>
              <td><?=$TotalPerson?>명</td>
              <td>수료인원</td>
              <td><?=$PassOkPerson?>명</td>
              <td>미수료인원</td>
              <td><?=$TotalPerson-$PassOkPerson?>명</td>
              <td>교육비</td>
              <td><?=number_format($TotalPrice,0)?>원</td>
              <td>수료환급액</td>
              <td><?=number_format($TotalPrice2,0)?>원</td>
            </tr>
          </table>
        </div>
<?
$num++;
	}
}

$resultDate00 = date('Y-m-d');
$resultDate01 = substr($resultDate00,0,4);
$resultDate02 = substr($resultDate00,5,2);
$resultDate03 = substr($resultDate00,8,2);
$resultDate = $resultDate01." 년  ".(int)$resultDate02."월  ".(int)$resultDate03."일";

if($num<4) {
	$ul_top = "250";
}else{
	$ul_top = "100";
}
?>


   	  	<div class="txt_ty01" style="margin-top:<?=$ul_top?>px;">위의 내용은 <?=$CompanyName?>의 사업주 직업능력개발<br />
        인터넷 원격훈련 수료 결과가 틀림없음을 증명합니다.
		</div>
        
        <div class="txt_ty01" style="margin-top:50px;"><?=$resultDate?></div>
        
        <div class="txt_ty01" style="margin-top:50px;"><?=$CertSiteName?><img src="/images/company_stamp.png" align="absmiddle" width="95" height="98" /></div>
        
        
    </div>
    
</div>
<!-- 페이지 1====================================================================== -->

<!-- 페이지 2====================================================================== -->
<div class="certi_print_info" style="padding-top:1250px; page-break-after: always;">
    <p class="fb">학습기간: <?=$LectureStart?> ~ <?=$LectureEnd?></p>

<?
$str_orderby = "ORDER BY a.PackageLevel ASC, b.ContentsName ASC";

$Colume = "DISTINCT(a.LectureCode), b.ContentsName, c.CompanyName";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
					";

$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);
?>
    <p class="fb">과정명 : <?=$ContentsName?></p>
	<table style="width:790px; border-collapse:collapse; border-spacing:0px; border:1px solid #000; margin-bottom:50px; ">
        <tr>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">번호</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">이름</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">생년월일</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">진도율</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">중간평가</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">최종평가</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">과제</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">총점</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">수료여부</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">교육비</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">환급액</th>
        </tr>

		<?
			$Study_Seq = "";
			$SQL2 = "SELECT a.Seq, a.Progress, a.MidScore, a.TestScore, a.ReportScore, a.TotalScore, a.PassOK, a.Price, a.rPrice, b.Name, AES_DECRYPT(UNHEX(b.BirthDay),'$DB_Enc_Key') AS BirthDay 
							FROM Study AS a 
							LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
							LEFT OUTER JOIN Course AS c ON a.LectureCode=c.LectureCode 
							$where AND a.LectureCode='$LectureCode' ORDER BY a.PassOK ASC, b.Name ASC";
			//echo $SQL2;
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
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$i2?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$ROW2['Name']?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$ROW2['BirthDay']?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$ROW2['Progress']?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$MidScore?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$TestScore?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$ReportScore?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$TotalScore?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$PassOK?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=number_format($ROW2['Price'])?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=number_format($ROW2['rPrice'])?></td>    
        </tr>
			<? 
			$i2++;
				}
			}
			?>
      </table>
<?
	}
}
?>

</div>

<!-- 페이지 2====================================================================== -->

<!-- 페이지 3====================================================================== -->
<div style="page-break-after: always;">
<?
$i = 0;
foreach($LectureCodeArray as $LectureCodeArrayValue) {
?>
<div class="certi_print_info">
    <p class="fb">과정명 : <?=$ContentsNameArray[$i]?></p>
	<table style="width:790px; border-collapse:collapse; border-spacing:0px; border:1px solid #000; margin-bottom:50px; ">
		<colgroup>
			<col width="4%" />
			<col width="14%" />
			<col width="32%" />
			<col width="4%" />
			<col width="14%" />
			<col width="32%" />
		</colgroup>
        <tr>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">차시</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">차시명</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">학습내용</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">차시</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">차시명</th>
			<th style="padding:5px 8px; border:1px solid #000; text-align:center;">학습내용</th>
        </tr>
		<?
			$Sql_s = "SELECT COUNT(Seq) FROM Chapter WHERE LectureCode='$LectureCodeArrayValue' AND ChapterType='A'";
			$Result_s = mysqli_query($connect, $Sql_s);
			$Row_s = mysqli_fetch_array($Result_s);
			$Chapter_Count = $Row_s[0];

			$k = 0;
			$SQL3 = "SELECT a.Seq AS Chapter_seq, a.ChapterType, a.OrderByNum, a.Sub_idx, b.Gubun AS ContentGubun, b.ContentsTitle, b.Expl02 
			FROM Chapter AS a LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
			WHERE a.LectureCode='$LectureCodeArrayValue' AND a.ChapterType='A' ORDER BY a.OrderByNum ASC";
			//echo $SQL3;
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

			$Loop_number = round($Chapter_Count / 2);
		?>
		<?
		for($k2=1;$k2<=$Loop_number;$k2++) {
		?>
		<tr>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$OrderByNumArray[$k2-1]?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:left;"><?=$ContentsTitleArray[$k2-1]?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:left;"><?=nl2br($ContentArray[$k2-1])?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:center;"><?=$OrderByNumArray[$k2-1+$Loop_number]?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:left;"><?=$ContentsTitleArray[$k2-1+$Loop_number]?></td>
			<td style="padding:5px 8px; border:1px solid #000; text-align:left;"><?=nl2br($ContentArray[$k2-1+$Loop_number])?></td>    
		</tr>
		<?
			}
		?>
	</table>
</div>
<?
$i++;
}
?>
</div>
<!-- 페이지 3====================================================================== -->
<!-- 만족도 설문결과====================================================================== -->
<?
$i = 0;
foreach($LectureCodeArray as $LectureCodeArrayValue) {

	$Sql_s = "SELECT COUNT(idx) FROM SurveyAnswer WHERE LectureCode='$LectureCode' AND Study_Seq IN ($Study_Seq)";
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);
	$Survey_count = $Row_s[0];

	if($Survey_count>0) {
?>
	<div style="width:790px; margin:0 auto; page-break-before: always;">
	<div style="font-size:18px; font-weight:bold; text-align:center"><center>만족도 설문결과 [<?=$ContentsNameArray[$i]?>] [<?=str_replace("-",".",$LectureStart);?> ~ <?=str_replace("-",".",$LectureEnd);?>]</center></div>
	<div style="font-size:18px; font-weight:bold; text-align:center; padding-top:10px"><center>[<?=$CompanyName;?>] [<?=$PassOkPersonArray[$i]?>명 / <?=$TotalPersonArray[$i]?>명]</center></div>
	<?
	$k = 0;
	$SQL4 = "SELECT * FROM SurveyAnswer WHERE LectureCode='$LectureCode' AND Study_Seq IN ($Study_Seq) ORDER BY idx ASC";
	//echo $SQL4;
	$QUERY4 = mysqli_query($connect, $SQL4);
	if($QUERY4 && mysqli_num_rows($QUERY4))
	{
		while($ROW4 = mysqli_fetch_array($QUERY4))
		{

		$ATypeEA = $ROW4['ATypeEA'];
		$BTypeEA = $ROW4['BTypeEA'];
		$ExamA_idx = $ROW4['ExamA_idx'];
		$ExamB_idx = $ROW4['ExamB_idx'];
		$ExamA_answer = $ROW4['ExamA_answer'];
		$ExamB_answer = $ROW4['ExamB_answer'];

		if($k<1) {
			$ExamA_idx_Array = explode("|",$ExamA_idx);
		}

		$ExamA_answer_Array = explode("|",$ExamA_answer);

		$k2 = 0;
		foreach($ExamA_answer_Array as $ExamA_answer_Array_value) {

			if($ExamA_answer_Array_value==1) { //1번 선택
				$AnswerResult[$k2][1] = $AnswerResult[$k2][1]+1;
			}
			if($ExamA_answer_Array_value==2) { //2번 선택
				$AnswerResult[$k2][2] = $AnswerResult[$k2][2]+1;
			}
			if($ExamA_answer_Array_value==3) { //3번 선택
				$AnswerResult[$k2][3] = $AnswerResult[$k2][3]+1;
			}
			if($ExamA_answer_Array_value==4) { //4번 선택
				$AnswerResult[$k2][4] = $AnswerResult[$k2][4]+1;
			}
			if($ExamA_answer_Array_value==5) { //5번 선택
				$AnswerResult[$k2][5] = $AnswerResult[$k2][5]+1;
			}

			//합계
			$AnswerResult[$k2][6] = $AnswerResult[$k2][1] + $AnswerResult[$k2][2] + $AnswerResult[$k2][3] + $AnswerResult[$k2][4] + $AnswerResult[$k2][5];

		$k2++;
		}


	$k++;
		}
	}

	//백분율 구하기
	$k3 = 0;
	foreach($ExamA_idx_Array as $ExamA_idx_Array_value) {

		$AnswerResultPercent[$k3][1] = number_format($AnswerResult[$k3][1] / $AnswerResult[$k3][6] * 100); //1번 선택 백분율
		$AnswerResultPercent[$k3][2] = number_format($AnswerResult[$k3][2] / $AnswerResult[$k3][6] * 100); //2번 선택 백분율
		$AnswerResultPercent[$k3][3] = number_format($AnswerResult[$k3][3] / $AnswerResult[$k3][6] * 100); //3번 선택 백분율
		$AnswerResultPercent[$k3][4] = number_format($AnswerResult[$k3][4] / $AnswerResult[$k3][6] * 100); //4번 선택 백분율
		$AnswerResultPercent[$k3][5] = number_format($AnswerResult[$k3][5] / $AnswerResult[$k3][6] * 100); //5번 선택 백분율

	$k3++;
	}

	?>

	<table width="820" border="0" style="margin-top:20px; border:0px; padding:0;">
		<tr>
		<td width="450" style="border:0px; padding:0;">
		<?
		$k4 = 0;
		foreach($ExamA_idx_Array as $ExamA_idx_Array_value) {

			$Sql = "SELECT * FROM PollBank WHERE idx=$ExamA_idx_Array_value";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);

			if($Row) {
				$Gubun = $Row['Gubun'];
				$ExamType = $Row['ExamType'];
				$Question = nl2br($Row['Question']);
				$Example01 = $Row['Example01'];
				$Example02 = $Row['Example02'];
				$Example03 = $Row['Example03'];
				$Example04 = $Row['Example04'];
				$Example05 = $Row['Example05'];
			}

			if(($k4+1)==$ATypeEA) {
				$TableStyle = "padding:0; border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;";
			}else{
				$TableStyle = "padding:0; border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;";
			}
		?>
		<table width="100%" style="<?=$TableStyle?>">
			<tr>
				<td colspan="2" align="left" style="text-align:left; border-bottom:0px"><?=$k4+1?>. <?=$Question?></td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example01?></td>
				<td width="40" style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][1]?>%</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example02?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][2]?>%</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example03?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][3]?>%</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example04?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][4]?>%</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px"><?=$Example05?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; "><?=$AnswerResultPercent[$k4][5]?>%</td>
			</tr>
		</table>
		<?
		$k4++;
		}
		?>
	</td>
	<td style="border:0px; padding:0; text-align:right" valign="top" align="right">
	<div id="barchart01" style="width:370px;height:380px; padding:0; text-align:right"></div><br><br><br><br><br>
	<div id="barchart02" style="width:370px;height:380px; padding:0; text-align:right"></div><br><br><br><br><br>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){
		printChart(<?=$AnswerResultPercent[2][1]?>,<?=$AnswerResultPercent[2][2]?>,<?=$AnswerResultPercent[2][3]?>,<?=$AnswerResultPercent[2][4]?>,<?=$AnswerResultPercent[2][5]?>);
		printChart2(<?=$AnswerResultPercent[3][1]?>,<?=$AnswerResultPercent[3][2]?>,<?=$AnswerResultPercent[3][3]?>,<?=$AnswerResultPercent[3][4]?>,<?=$AnswerResultPercent[3][5]?>);
	});
	//-->
	</script>
	
	</td>
</tr>
</table>

	</div>
<?
	}
$i++;
}
?>
<!-- 만족도 설문결과====================================================================== -->

</BODY>
</html>
<?
mysqli_close($connect);
?>