<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$col = Replace_Check($col);
$sw = Replace_Check($sw);
$Gubun = Replace_Check($Gubun);


$where = array();


if($Gubun) {
	$where[] = "a.CompanyScale='$Gubun'";
}

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "a.$col LIKE '%$sw%'";
	}
}

$where[] = "a.Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건

$orderby = "ORDER BY a.RegDate DESC, a.idx DESC";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Company AS a LEFT OUTER JOIN StaffInfo AS b ON a.SalesManager=b.ID $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);


$filename = "사업주목록_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:AB'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:AB'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AB'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AB'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("회사 규모");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("회사명");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("사업자 번호");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("HRD 번호");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("사업주 ID");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("대표자명");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("대표 전화번호");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("고객센터 전화번호");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("고객센터 전화번호 사용 여부");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("대표 팩스번호");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("고객센터 팩스번호");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("업태");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("업종");
$objPHPExcel->getActiveSheet()->getCell('O1')->setValue("우편번호");
$objPHPExcel->getActiveSheet()->getCell('P1')->setValue("주소");
$objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("상세 주소");
$objPHPExcel->getActiveSheet()->getCell('R1')->setValue("은행명");
$objPHPExcel->getActiveSheet()->getCell('S1')->setValue("계좌번호");
$objPHPExcel->getActiveSheet()->getCell('T1')->setValue("이메일");
$objPHPExcel->getActiveSheet()->getCell('U1')->setValue("홈페이지");
$objPHPExcel->getActiveSheet()->getCell('V1')->setValue("사이버교육센터");
$objPHPExcel->getActiveSheet()->getCell('W1')->setValue("사이버교육센터 사용 여부");
$objPHPExcel->getActiveSheet()->getCell('X1')->setValue("교육담당자");
$objPHPExcel->getActiveSheet()->getCell('Y1')->setValue("교육담당자 연락처");
$objPHPExcel->getActiveSheet()->getCell('Z1')->setValue("교육담당자 이메일");
$objPHPExcel->getActiveSheet()->getCell('AA1')->setValue("영업담당자");
$objPHPExcel->getActiveSheet()->getCell('AB1')->setValue("메모");



$i=2;
$k = 1;
$SQL = "SELECT a.*, b.Name AS SalesName FROM Company AS a LEFT OUTER JOIN StaffInfo AS b ON a.SalesManager=b.ID $where $orderby";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
while($ROW = mysqli_fetch_array($QUERY))
	{
	extract($ROW);

	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($CompanyScale_array[$CompanyScale], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($CompanyCode, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($HRD, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($CompanyID, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Ceo, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Tel, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($Tel2, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($CSEnabled, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($Fax, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($Fax2, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($Uptae, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($Upjong, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('O'.$i)->setValueExplicit($Zipcode, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('P'.$i)->setValueExplicit($Address01, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->setValueExplicit($Address02, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('R'.$i)->setValueExplicit($Bank_array[$BankName], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('S'.$i)->setValueExplicit($BankNumber, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('T'.$i)->setValueExplicit($Email, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('U'.$i)->setValueExplicit($HomePage, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('V'.$i)->setValueExplicit($CyberURL, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('W'.$i)->setValueExplicit($CyberEnabled, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('X'.$i)->setValueExplicit($EduManager, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('Y'.$i)->setValueExplicit($EduManagerPhone, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('Z'.$i)->setValueExplicit($EduManagerEmail, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('AA'.$i)->setValueExplicit($SalesName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('AB'.$i)->setValueExplicit($Remark, PHPExcel_Cell_DataType::TYPE_STRING);

	$i++;
	$k++;
	}
}

mysqli_free_result($QUERY);

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
