<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$SearchGubun = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName = Replace_Check($CompanyName); //사업주명
$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$StudyPeriod = Replace_Check($StudyPeriod); //검색 기간
$CompanyCode = Replace_Check($CompanyCode); //사업자 번호
$ID = Replace_Check($ID); //이름, 아이디
$Progress1 = Replace_Check($Progress1); //진도율 시작
$Progress2 = Replace_Check($Progress2); //진도율 종료
$TotalScore1 = Replace_Check($TotalScore1); //총점 시작
$TotalScore2 = Replace_Check($TotalScore2); //총점 종료
$TutorStatus = Replace_Check($TutorStatus); //첨삭 여부
$LectureCode = Replace_Check($LectureCode); //강의 코드
$PassOk = Replace_Check($PassOk); //수료여부
$ServiceType = Replace_Check($ServiceType); //환급여부
$PackageYN = Replace_Check($PackageYN); //패키지 여부
$certCount = Replace_Check($certCount); //실명인증 횟수
$MidStatus = Replace_Check($MidStatus); //중간평가 상태
$TestStatus = Replace_Check($TestStatus); //최종평가 상태
$ReportStatus = Replace_Check($ReportStatus); //과제 상태
$TestCopy = Replace_Check($TestCopy); //평가모사답안 여부
$ReportCopy = Replace_Check($ReportCopy); //과제모사답안 여부
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일


##-- 검색 조건
$where = array();

if($SearchGubun=="A") { //기간 검색 

	if($SearchYear) {
		$where[] = "YEAR(a.LectureStart)=".$SearchYear;
	}

	if($SearchMonth) {
		$where[] = "MONTH(a.LectureStart)=".$SearchMonth;
	}

	if($CompanyCode) {
		$where[] = "a.CompanyCode='".$CompanyCode."'";
	}

	if($LectureStart) {
		$where[] = "a.LectureStart='".$LectureStart."'";
	}

	if($LectureEnd) {
		$where[] = "a.LectureEnd='".$LectureEnd."'";
	}

}

if($SearchGubun=="B") { //사업주  검색 

	if($CompanyName) {
		$where[] = "d.CompanyName LIKE '%".$CompanyName."%'";
	}

}




if($ID) {
	$where[] = "(a.ID='".$ID."' OR c.Name='".$ID."')";
}

if($Progress2) {
	if(!$Progress1) {
		$Progress1 = 0;
	}
	$where[] = "(a.Progress BETWEEN ".$Progress1." AND ".$Progress2.")";
}

if($TotalScore2) {
	if(!$TotalScore1) {
		$TotalScore1 = 0;
	}
	$where[] = "(a.TotalScore BETWEEN ".$TotalScore1." AND ".$TotalScore2.")";
}

if($TutorStatus=="N") {
	$where[] = "a.StudyEnd='N'";
}

if($LectureCode) {
	$where[] = "a.LectureCode='".$LectureCode."'";
}

if($PassOk) {
	$where[] = "a.PassOk='".$PassOk."'";
}

if($ServiceType) {
	$where[] = "a.ServiceType=".$ServiceType;
}

if($PackageYN) {
	if($PackageYN=="Y") {
		$where[] = "a.PackageRef>0";
	}
	if($PackageYN=="N") {
		$where[] = "a.PackageRef<1";
	}
}

if($certCount!=="") {
	$where[] = "a.certCount=".$certCount;
}

if($MidStatus) {
	$where[] = "a.MidStatus='".$MidStatus."'";
}

if($TestStatus) {
	$where[] = "a.TestStatus='".$TestStatus."'";
}

if($ReportStatus) {
	$where[] = "a.ReportStatus='".$ReportStatus."'";
}

if($TestCopy) {
	$where[] = "a.TestCopy='".$TestCopy."'";
}

if($ReportCopy) {
	$where[] = "a.ReportCopy='".$ReportCopy."'";
}



$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY a.Seq DESC";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
				a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.StudyIP, a.MidIP, a.TestIP, a.ReportIP, a.TestCheckIP, a.ReportCheckIP, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
				c.Name, c.Depart, 
				d.CompanyName, 
				e.Name AS TutorName 
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


$filename = "IP모니터링_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("구분");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("ID");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("수강기간");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("첨삭완료");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("수강IP");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("중간응시IP");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("최종응시IP");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("과제제출IP");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("교강사");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("평가첨삭IP");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("과제첨삭IP");


$i=2;
$k = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
while($ROW = mysqli_fetch_array($QUERY))
	{
	extract($ROW);

	$LectureDate = $LectureStart."~".$LectureEnd;

	$Tutor_limit_day = strtotime("$LectureEnd +4 days");
	$Tutor_limit_day2 = date("Y-m-d", $Tutor_limit_day)."까지";


	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ServiceType_array[$ServiceType], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Tutor_limit_day2, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($StudyIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($MidIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($TestIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($ReportIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($TutorName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($TestCheckIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($ReportCheckIP, PHPExcel_Cell_DataType::TYPE_STRING);


	$i++;
	$k++;
	}
}



$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->setActiveSheetIndex(0);
$filename = iconv("UTF-8", "EUC-KR", $filename);

/*
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=".$filename.".xls");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;
*/

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
