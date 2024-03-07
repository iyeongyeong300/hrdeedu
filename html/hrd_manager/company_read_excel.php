<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$CompanyCode = Replace_Check($CompanyCode);

##-- 검색 등록수
$Sql = "SELECT *, ";
$Sql .= "AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, ";
$Sql .= "AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, ";
$Sql .= "AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, ";
$Sql .= "AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay ";
$Sql .= "FROM Member WHERE CompanyCode='$CompanyCode' ";
$Sql .= "ORDER BY Name ASC";

$Result = mysqli_query($connect, $Sql);
$TOT_NO = mysqli_num_rows($Result);

// mysqli_free_result($Result);


$filename = "수강생정보_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// echo $Sql;

//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("아이디");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("생년월일");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("성별");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("이메일");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("휴대폰");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("부서");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("직위");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("최종로그인");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("가입일");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("계정 사용유무");


$i = 2;
$k = 1;

// echo $Sql.$Result.",".$TOT_NO;

if ($Result && $TOT_NO) {
	while($ROW = mysqli_fetch_array($Result)) {
		extract($ROW);

		$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($BirthDay, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($Gender_array[$Gender], PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($Email, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Mobile, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($Position, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($LastLogin, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($RegDate, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($UseYN, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$i++;
		$k++;
	}
}

mysqli_free_result($Result);

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
