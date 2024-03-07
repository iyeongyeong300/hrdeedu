<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
include "./include/include_admin_check.php";

$CompanyCode = Replace_Check($CompanyCode);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$ServiceTypeYN = Replace_Check($ServiceTypeYN);


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
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style2.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>

</HEAD>
<BODY leftmargin="0" topmargin="0">
<div class="certi_print">
<?
$where = array();

$where[] = "a.CompanyCode='$CompanyCode'";

$where[] = "a.LectureStart='$LectureStart'";

$where[] = "a.LectureEnd='$LectureEnd'";

//$where[] = "a.PassOk='Y'";


$where[] = "a.ServiceType=1";
$qServiceType = " AND ServiceType=1";


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

$num++;
	}
}


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


		$Study_Seq = "";
			$SQL2 = "SELECT a.Seq, a.Progress, a.MidScore, a.TestScore, a.ReportScore, a.TotalScore, a.PassOK, a.Price, a.rPrice, b.Name, b.BirthDay 
							FROM Study AS a 
							LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
							LEFT OUTER JOIN Course AS c ON a.LectureCode=c.LectureCode 
							$where ORDER BY a.PassOK ASC, b.Name ASC";
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


			$i2++;
				}
			}

	}
}



$i = 0;
foreach($LectureCodeArray as $LectureCodeArrayValue) {

	$Sql_s = "SELECT COUNT(idx) FROM SurveyAnswer WHERE LectureCode='$LectureCodeArrayValue' AND Study_Seq IN ($Study_Seq)";
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);
	$Survey_count = $Row_s[0];

	if($Survey_count>0) {
?>
	<div style="width:800px; margin:0 auto; page-break-before: always;">
	<div style="font-size:18px; font-weight:bold; text-align:center"><center>만족도 설문결과 [<?=$ContentsNameArray[$i]?>] [<?=str_replace("-",".",$LectureStart);?> ~ <?=str_replace("-",".",$LectureEnd);?>]</center></div>
	<div style="font-size:18px; font-weight:bold; text-align:center; padding-top:10px"><center>[<?=$CompanyName;?>] [<?=$PassOkPersonArray[$i]?>명 / <?=$TotalPersonArray[$i]?>명]</center></div>
	<?
	$k = 0;
	$SQL4 = "SELECT * FROM SurveyAnswer WHERE LectureCode='$LectureCodeArrayValue' AND Study_Seq IN ($Study_Seq) ORDER BY idx ASC";
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
				<td width="100" style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][1]?>% (<?=number_format($AnswerResult[$k4][1])?>명)</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example02?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][2]?>% (<?=number_format($AnswerResult[$k4][2])?>명)</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example03?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][3]?>% (<?=number_format($AnswerResult[$k4][3])?>명)</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px; border-bottom:0px"><?=$Example04?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; border-bottom:0px"><?=$AnswerResultPercent[$k4][4]?>% (<?=number_format($AnswerResult[$k4][4])?>명)</td>
			</tr>
			<tr>
				<td align="right" style="text-align:right; border-top:0px; border-right:0px"><?=$Example05?></td>
				<td style="text-align:right; border-top:0px; border-left:0px; "><?=$AnswerResultPercent[$k4][5]?>% (<?=number_format($AnswerResult[$k4][5])?>명)</td>
			</tr>
		</table>
		<?
		$k4++;
		}
		?>
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