<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$col = Replace_Check_XSS2($col);
$sw = Replace_Check_XSS2($sw);
$orderby = Replace_Check_XSS2($orderby);
$LectureStart = Replace_Check_XSS2($LectureStart);
$LectureEnd = Replace_Check_XSS2($LectureEnd);
$LectureCode = Replace_Check_XSS2($LectureCode);
$PassOk = Replace_Check_XSS2($PassOk);
$CompanyCode = Replace_Check_XSS2($CompanyCode);

##-- 검색 조건
$where = array();

$where[] = "a.CompanyCode='".$CompanyCode."'";

$where[] = "a.LectureStart='".$LectureStart."'";

$where[] = "a.LectureEnd='".$LectureEnd."'";


if($LectureCode) {
	$where[] = "a.LectureCode='".$LectureCode."'";
}

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


$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


$filename = "학습진행현황_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:U'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:U'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:U'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:U'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);


$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("구분");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("ID");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("수강기간");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("첨삭완료");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("진도율");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("중간평가(%)");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("응시일");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("최종평가(%)");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("응시일");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("과제(%)");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("제출일");
$objPHPExcel->getActiveSheet()->getCell('O1')->setValue("총점");
$objPHPExcel->getActiveSheet()->getCell('P1')->setValue("수료여부");
$objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("교강사");
$objPHPExcel->getActiveSheet()->getCell('R1')->setValue("사업주");
$objPHPExcel->getActiveSheet()->getCell('S1')->setValue("부서");
$objPHPExcel->getActiveSheet()->getCell('T1')->setValue("실명인증(건)");
$objPHPExcel->getActiveSheet()->getCell('U1')->setValue("최종수강시간");


$i=2;
$k = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
while($ROW = mysqli_fetch_array($QUERY))
	{
	extract($ROW);

	$LectureDate = $LectureStart."~".$LectureEnd;

	$Tutor_limit_day = strtotime("$LectureEnd +4 days");
	$Tutor_limit_day2 = date("Y-m-d", $Tutor_limit_day)."까지";

	$Progress2 = $Progress."%";

	//중간평가
	if($MidRate<1) {
		$Mid_View = "평가 없음";
	}else{
		switch($MidStatus) {
			case "C":
				$MidRatePercent = $MidScore * $MidRate / 100;
				$Mid_View = $MidScore."(".$MidRatePercent.")";
			break;
			case "Y":
				$Mid_View = "채점 대기중";
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
				$Test_View = $TestScore."(".$TestRatePercent.")";
			break;
			case "Y":
				$Test_View = "채점 대기중";
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
				$Report_View = $ReportScore."(".$ReportRatePercent.")";
			break;
			case "Y":
				$Report_View = "채점 대기중";
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


	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ServiceType_array[$ServiceType], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Tutor_limit_day2, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Progress2, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($Mid_View, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($MidSaveTime, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($Test_View, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($TestSaveTime, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($Report_View, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($ReportSaveTime, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('O'.$i)->setValueExplicit($TotalScore_View, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('P'.$i)->setValueExplicit($PassOK_View, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->setValueExplicit($TutorName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('R'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('S'.$i)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('T'.$i)->setValueExplicit($certCount, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('U'.$i)->setValueExplicit($LastStudyTime, PHPExcel_Cell_DataType::TYPE_STRING);

	$i++;
	$k++;
	}
}



$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->setActiveSheetIndex(0);
$filename = iconv("UTF-8", "EUC-KR", $filename);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=".$filename.".xlsx");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
