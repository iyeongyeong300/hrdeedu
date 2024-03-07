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
$ServiceType = Replace_Check($ServiceType);

$ExcelTitle = "수납확인서";


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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(25);

$objPHPExcel->getActiveSheet()->getCell('A1')->setValue($ExcelTitle);
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');




$objPHPExcel->getActiveSheet()->getCell('A2')->setValue($companyName);
$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');

$objPHPExcel->getActiveSheet()->getCell('A3')->setValue('순번');
$objPHPExcel->getActiveSheet()->getCell('B3')->setValue('훈련 과정명');
$objPHPExcel->getActiveSheet()->getCell('C3')->setValue('훈련기간');
$objPHPExcel->getActiveSheet()->getCell('D3')->setValue('회사명');
$objPHPExcel->getActiveSheet()->getCell('E3')->setValue('성명');
$objPHPExcel->getActiveSheet()->getCell('F3')->setValue('생년월일');
$objPHPExcel->getActiveSheet()->getCell('G3')->setValue('자부담금');


$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');

$objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


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

$CellCount = $TOT_NO + 4;

$objPHPExcel->getActiveSheet()->getStyle('A4:G'.$CellCount)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:G'.$CellCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


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

		$objPHPExcel->getActiveSheet()->getCell('B'.$k)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);

		$LectureDate = $LectureStart." ~ ".$LectureEnd;

		$objPHPExcel->getActiveSheet()->getCell('C'.$k)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('D'.$k)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('E'.$k)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('F'.$k)->setValueExplicit($BirthDay, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('G'.$k)->setValueExplicit(number_format($rPrice2,0), PHPExcel_Cell_DataType::TYPE_STRING);



		$PriceT = $PriceT + $rPrice2;


$i++;
	}
}

$k2 = $i+3;

$objPHPExcel->getActiveSheet()->getCell('A'.$k2)->setValue('자부담금합계');
$objPHPExcel->getActiveSheet()->getCell('G'.$k2)->setValueExplicit(number_format($PriceT,0), PHPExcel_Cell_DataType::TYPE_STRING);

$objPHPExcel->getActiveSheet()->mergeCells('A'.$k2.':F'.$k2);

$k3 = $k2+4;
$objPHPExcel->getActiveSheet()->getCell('A'.$k3)->setValue('위 자부담금을 영수하였음을 증명합니다.');
$objPHPExcel->getActiveSheet()->mergeCells('A'.$k3.':G'.$k3);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k3.':G'.$k3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$k4 = $k3+2;
$objPHPExcel->getActiveSheet()->getCell('A'.$k4)->setValue(date('Y-m-d'));
$objPHPExcel->getActiveSheet()->mergeCells('A'.$k4.':G'.$k4);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k4.':G'.$k4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$k5 = $k4+2;

$objPHPExcel->getActiveSheet()->getStyle('A'.$k5)->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getCell('A'.$k5)->setValue($CertSiteName);
$objPHPExcel->getActiveSheet()->mergeCells('A'.$k5.':G'.$k5);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k5.':G'.$k5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//이미지 추가
$path = "../images/company_stamp.png";
$objDrawing = new PHPExcel_Worksheet_Drawing(); 
$objDrawing->setName('eledu_stamp'); 
$objDrawing->setDescription('eledu_stamp'); 
$objDrawing->setPath($path); 
$objDrawing->setResizeProportional(true); 
$objDrawing->setWidth(95);  // 이미지 크기
$objDrawing->setOffsetX(0);  // 이미지가 시작할 위치를 퍼센트로 적용 셀의 크기에 가로가 35%만큼 이동해서 시작
$objDrawing->setOffsetY(-10);  // 이미지가 시작할 위치를 퍼센트로 적용 셀의 크기에 세로가 5%만큼 이동해서 시작
$objDrawing->setCoordinates('F'.$k5); 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


mysqli_close($connect);

$fileName = iconv("utf-8","euc-kr","수납확인서 (".$LectureCode."_".$LectureStart." ~ ".$LectureEnd.").xls");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$fileName);
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter ->save('php://output');
exit;
?>