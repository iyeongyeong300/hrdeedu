<?
include "../include/include_function.php";
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
ini_set("display_errors", 1);

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
$SalesID = Replace_Check($SalesID); //영업자 이름, ID
$SalesTeam = Replace_Check($SalesTeam); //영업자 소속
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

// 검색 오류 처리 - 23.01.03
if ($StudyPeriod != '') {
    $StudyPeriod_array = explode("~",$StudyPeriod);
    $LectureStart = $StudyPeriod_array[0];
    $LectureEnd = $StudyPeriod_array[1];
}


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

if($SalesID) {
	$where[] = "(a.SalesID='".$SalesID."' OR f.Name='".$SalesID."')";
}

if($SalesTeam) {
	$where[] = "f.Team LIKE '%".$SalesTeam."%'"; //"f.Team='".$SalesTeam."'";
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

//if($ServiceType) {
//	$where[] = "a.ServiceType=".$ServiceType;
//}
// 환급만..
$where[] = "a.ServiceType IN (1,4) ";

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
				d.CompanyName, d.Address01, d.Address02,
				e.Name AS TutorName,
				f.Name AS SalesName,
				f.Team AS SalesTeam
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
						LEFT OUTER JOIN StaffInfo AS f ON a.SalesID=f.ID 
					";

$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

$TOT_NO2 = 0;
$SQL = "SELECT a.Seq, a.ID FROM $JoinQuery $where $str_orderby";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)) {
    while($ROW = mysqli_fetch_array($QUERY)) {
        $Sql2 = "SELECT COUNT(a.Contents_idx) FROM Progress AS a LEFT OUTER JOIN Contents AS b ON a.Contents_idx=b.idx WHERE a.Study_Seq=$ROW[Seq] AND ID='$ROW[ID]' ";
//        echo $Sql2;
        $Result2 = mysqli_query($connect, $Sql2);
        $Row2 = mysqli_fetch_array($Result2);
        $TOT_NO2 += $Row2[0];
    }
}

$filename = "IP모니터링상세_".date('Ymd');

$TOT_NO3 = $TOT_NO + $TOT_NO2 + 2;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:R'.$TOT_NO3)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:R'.$TOT_NO3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:R'.$TOT_NO3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:R'.$TOT_NO3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FDE9D9');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("구분");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("영업자");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("영업자 소속");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("사업자");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("사업자 주소");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("ID");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("수강기간");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("첨삭완료");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("수강IP");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("중간응시IP");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("최종응시IP");
$objPHPExcel->getActiveSheet()->getCell('O1')->setValue("과제제출IP");
$objPHPExcel->getActiveSheet()->getCell('P1')->setValue("교강사");
$objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("평가첨삭IP");
$objPHPExcel->getActiveSheet()->getCell('R1')->setValue("과제첨삭IP");


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
	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($SalesName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($SalesTeam, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($Address01." " . $Address02, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($Tutor_limit_day2, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($StudyIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($MidIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($TestIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('O'.$i)->setValueExplicit($ReportIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('P'.$i)->setValueExplicit($TutorName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->setValueExplicit($TestCheckIP, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('R'.$i)->setValueExplicit($ReportCheckIP, PHPExcel_Cell_DataType::TYPE_STRING);

    $i++;
    //상세내역
    $objPHPExcel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEECE1');
    $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValue("");
    $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValue("차시");
    $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValue("차시명");
    $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValue("진도");
    $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValue("수강시간");
    $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValue("수강IP");
    $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValue("수강일");

    $SQL2 = "SELECT a.Contents_idx, b.idx, a.Chapter_Number, b.ContentsTitle, a.Progress, a.StudyTime, a.UserIP, a.RegDate FROM Progress AS a LEFT OUTER JOIN Contents AS b ON a.Contents_idx=b.idx WHERE a.Study_Seq=$Seq AND ID='$ID' ORDER BY CAST(Chapter_Number AS SIGNED) ASC, idx ASC";
    $QUERY2 = mysqli_query($connect, $SQL2);
    if($QUERY2 && mysqli_num_rows($QUERY2))
    {
        while($ROW2 = mysqli_fetch_array($QUERY2))
        {
            $StudyTime2 = Sec_To_His($ROW2["StudyTime"]);
            $i++;

            $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit("", PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ROW2["Chapter_Number"], PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ROW2["ContentsTitle"], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($ROW2["Progress"], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($StudyTime2, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($ROW2["UserIP"], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($ROW2["RegDate"], PHPExcel_Cell_DataType::TYPE_STRING);
        }
    }

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
