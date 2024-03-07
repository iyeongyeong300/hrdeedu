<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$col = Replace_Check($col);
$sw = Replace_Check($sw);


$where = array();


if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "$col LIKE '%$sw%'";
	}
}

$where[] = "a.MemberOut='N'";
$where[] = "a.Sleep='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건

$orderby = "ORDER BY a.RegDate DESC, a.idx DESC";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


$filename = "수강생목록_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("아이디");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("사업주");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("생년월일");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("성별");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("이메일");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("휴대폰");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("부서");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("직위");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("가입일");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("대리수강방지");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("계정사용유무");

$i=2;
$k = 1;
$SQL = "SELECT a.*, b.CompanyName, AES_DECRYPT(UNHEX(a.Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(a.ResNo),'$DB_Enc_Key') AS ResNo FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where $orderby";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
while($ROW = mysqli_fetch_array($QUERY))
	{
	extract($ROW);


	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ResNo, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($Gender, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Email, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Mobile, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($Position, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($RegDate, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($ProtectID, PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($UseYN, PHPExcel_Cell_DataType::TYPE_STRING);

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
