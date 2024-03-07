<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$CompanyCode = Replace_Check($CompanyCode);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$LectureCode = Replace_Check($LectureCode);

$ExcelTitle = "수강신청현황 (과정코드: ".$LectureCode." / 교육기간: ".$LectureStart." ~ ".$LectureEnd.")";

$Sql = "SELECT CompanyName FROM Company WHERE CompanyCode='".$CompanyCode."'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyName = "[".$Row['CompanyName']."]";
}

$sheet = $objPHPExcel->getActiveSheet();

$sheet->getDefaultStyle()->getFont()->setName('맑은 고딕'); // 폰트
$sheet->getDefaultStyle()->getFont()->setName('맑은 고딕')->setSize(10); // 폰트 크기

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);

$objPHPExcel->getActiveSheet()->getCell('A1')->setValue($ExcelTitle);
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');

$objPHPExcel->getActiveSheet()->getCell('A2')->setValue($CompanyName);
$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');

$objPHPExcel->getActiveSheet()->getCell('A3')->setValue('총번');
$objPHPExcel->getActiveSheet()->getCell('B3')->setValue('순번');
$objPHPExcel->getActiveSheet()->getCell('C3')->setValue('훈련 과정명');
$objPHPExcel->getActiveSheet()->getCell('D3')->setValue('훈련기간');
$objPHPExcel->getActiveSheet()->getCell('E3')->setValue('회사명');
$objPHPExcel->getActiveSheet()->getCell('F3')->setValue('부서');
$objPHPExcel->getActiveSheet()->getCell('G3')->setValue('직급');
$objPHPExcel->getActiveSheet()->getCell('H3')->setValue('성명');
$objPHPExcel->getActiveSheet()->getCell('I3')->setValue('생년월일');
$objPHPExcel->getActiveSheet()->getCell('J3')->setValue('교육비');
$objPHPExcel->getActiveSheet()->getCell('K3')->setValue('환급액');
$objPHPExcel->getActiveSheet()->getCell('L3')->setValue('실부담액');

$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');

$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


##-- 검색 조건
$where = array();

$where[] = "a.ServiceType=1";

$where[] = "a.CompanyCode='$CompanyCode'";

$where[] = "a.LectureStart='$LectureStart'";

$where[] = "a.LectureEnd='$LectureEnd'";

$where[] = "a.LectureCode='$LectureCode'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY a.Seq DESC";




$Colume = "a.LectureCode, a.LectureStart, a.LectureEnd, a.Price, a.rPrice, a.rPrice2, 
				b.ContentsName, b.ContentsTime, 
				c.CompanyName, 
				d.Depart, d.Name, AES_DECRYPT(UNHEX(d.BirthDay),'$DB_Enc_Key') AS BirthDay 
				";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
						LEFT OUTER JOIN Member AS d ON a.ID=d.ID 
					";

$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

$CellCount = $TOT_NO + 3;

$objPHPExcel->getActiveSheet()->getStyle('A4:L'.$CellCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:L'.$CellCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$i = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);

		$k = $i+3;
		$objPHPExcel->getActiveSheet()->getCell('A'.$k)->setValueExplicit($i, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('B'.$k)->setValueExplicit($i, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getCell('C'.$k)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);

		$LectureDate = $LectureStart." ~ ".$LectureEnd;

		$objPHPExcel->getActiveSheet()->getCell('D'.$k)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('E'.$k)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('F'.$k)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('G'.$k)->setValueExplicit("", PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('H'.$k)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('I'.$k)->setValueExplicit($BirthDay, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('J'.$k)->setValueExplicit($Price, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('K'.$k)->setValueExplicit($rPrice, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$PriceB = $Price - $rPrice;

		$objPHPExcel->getActiveSheet()->getCell('L'.$k)->setValueExplicit($PriceB, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->getNumberFormat()->setFormatCode("#,##0");
		$objPHPExcel->getActiveSheet()->getStyle('K'.$k)->getNumberFormat()->setFormatCode("#,##0");
		$objPHPExcel->getActiveSheet()->getStyle('L'.$k)->getNumberFormat()->setFormatCode("#,##0");



$i++;
	}
}


mysqli_close($connect);

$fileName = iconv("utf-8","euc-kr","수강신청현황 (".$LectureCode."_".$LectureStart." ~ ".$LectureEnd.").xls");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$fileName);
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter ->save('php://output');
exit;
?>