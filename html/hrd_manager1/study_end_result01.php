<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$CompanyCode = Replace_Check($CompanyCode);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);

$LectureStart_arrary = explode("-",$LectureStart);


$ExcelTitle = "개설현황 [".$LectureStart_arrary[0]."년 ".$LectureStart_arrary[1]."월 ".$LectureStart_arrary[2]."일]";


$Sql = "SELECT CompanyName FROM Company WHERE CompanyCode='".$CompanyCode."'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyName = $Row['CompanyName'];
}

$sheet = $objPHPExcel->getActiveSheet();

$sheet->getDefaultStyle()->getFont()->setName('맑은 고딕'); // 폰트
$sheet->getDefaultStyle()->getFont()->setName('맑은 고딕')->setSize(10); // 폰트 크기

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

$objPHPExcel->getActiveSheet()->getCell('A2')->setValue($ExcelTitle);
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

$objPHPExcel->getActiveSheet()->getCell('A3')->setValue($CompanyName);
$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');

$objPHPExcel->getActiveSheet()->getCell('A5')->setValue('순번');
$objPHPExcel->getActiveSheet()->getCell('B5')->setValue('훈련 과정명');
$objPHPExcel->getActiveSheet()->getCell('C5')->setValue('훈련기간');
$objPHPExcel->getActiveSheet()->getCell('D5')->setValue('훈련시간');
$objPHPExcel->getActiveSheet()->getCell('E5')->setValue('1인당 훈련비');
$objPHPExcel->getActiveSheet()->getCell('F5')->setValue('수강 인원');
$objPHPExcel->getActiveSheet()->getCell('G5')->setValue('총 훈련비');

$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');

$objPHPExcel->getActiveSheet()->getStyle('A1:G5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


##-- 검색 조건
$where = array();

$where[] = "a.ServiceType=1";

$where[] = "a.CompanyCode='$CompanyCode'";

$where[] = "a.LectureStart='$LectureStart'";

$where[] = "a.LectureEnd='$LectureEnd'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY b.ContentsName ASC";




$Colume = "DISTINCT(a.LectureCode), a.LectureStart, a.LectureEnd, 
				b.ContentsName, b.ContentsTime, 
				(SELECT SUM(Price) FROM Study WHERE CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND ServiceType=1) AS TotalPrice, 
				(SELECT COUNT(Seq) FROM Study WHERE CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND ServiceType=1) AS TotalPerson 
				";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
					";

$Sql = "SELECT COUNT(DISTINCT(a.LectureCode)) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

$CellCount = $TOT_NO + 5;

$objPHPExcel->getActiveSheet()->getStyle('A6:G'.$CellCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A6:G'.$CellCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$i = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);

		$k = $i+5;
		$objPHPExcel->getActiveSheet()->getCell('A'.$k)->setValueExplicit($i, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('B'.$k)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);

		$LectureDate = $LectureStart." ~ ".$LectureEnd;

		$objPHPExcel->getActiveSheet()->getCell('C'.$k)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);

		$date1 = new DateTime($LectureStart);
		$date2 = new DateTime($LectureEnd);
		$IntervalDay = $date1->diff($date2);
		$TrainingTime = $IntervalDay->days."일, ".$ContentsTime."시간";

		$objPHPExcel->getActiveSheet()->getCell('D'.$k)->setValueExplicit($TrainingTime, PHPExcel_Cell_DataType::TYPE_STRING);


		$PersonPerPrice = $TotalPrice / $TotalPerson;

		$objPHPExcel->getActiveSheet()->getCell('E'.$k)->setValueExplicit($PersonPerPrice, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('F'.$k)->setValueExplicit($TotalPerson, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('G'.$k)->setValueExplicit($TotalPrice, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getNumberFormat()->setFormatCode("#,##0");
		$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getNumberFormat()->setFormatCode("#,##0");
		$objPHPExcel->getActiveSheet()->getStyle('G'.$k)->getNumberFormat()->setFormatCode("#,##0");



$i++;
	}
}


mysqli_close($connect);

$fileName = iconv("utf-8","euc-kr","개설현황(".date("Y-m-d").").xls");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$fileName);
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter ->save('php://output');
exit;
?>