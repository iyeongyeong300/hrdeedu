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
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("생년월일"); // Brad (2021.11.26) : '생년월일' 추가
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("성별");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("이메일");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("전화번호");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("휴대폰");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("영문 이름");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("우편번호");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("주소");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("상세 주소");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("부서");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("직위");
$objPHPExcel->getActiveSheet()->getCell('O1')->setValue("관심분야");
$objPHPExcel->getActiveSheet()->getCell('P1')->setValue("가입경로");
$objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("메일링");
$objPHPExcel->getActiveSheet()->getCell('R1')->setValue("ACS");
$objPHPExcel->getActiveSheet()->getCell('S1')->setValue("가입일");
$objPHPExcel->getActiveSheet()->getCell('T1')->setValue("교육 담당자 여부");
$objPHPExcel->getActiveSheet()->getCell('U1')->setValue("계정사용 여부");
$objPHPExcel->getActiveSheet()->getCell('V1')->setValue("사업주");
$objPHPExcel->getActiveSheet()->getCell('W1')->setValue("대리수강 방지");
$objPHPExcel->getActiveSheet()->getCell('X1')->setValue("마케팅 수신동의");


$i=2;
$k = 1;
$SQL = "SELECT a.*, ";
$SQL .= "b.CompanyName, ";
$SQL .= "AES_DECRYPT(UNHEX(a.BirthDay),'$DB_Enc_Key') AS BirthDay, "; // Brad (2021.11.26) : '생년월일' 추가
$SQL .= "AES_DECRYPT(UNHEX(a.Email),'$DB_Enc_Key') AS Email, ";
$SQL .= "AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile ";
$SQL .= "FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where $orderby";
$QUERY = mysqli_query($connect, $SQL);

if($QUERY && mysqli_num_rows($QUERY)) {
	while($ROW = mysqli_fetch_array($QUERY)) {
		extract($ROW);

		$Email = InformationProtection($Email,'Email','S');
		$Mobile = InformationProtection($Mobile,'Mobile','S');
		$BirthDay = InformationProtection($BirthDay,'BirthDay','S');

		$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($BirthDay, PHPExcel_Cell_DataType::TYPE_STRING); // Brad (2021.11.26) : '생년월일' 추가
		$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($Gender_array[$Gender], PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($Email, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Tel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Mobile, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($NameEng, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($Zipcode, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($Address01, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($Address02, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($Position, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('O'.$i)->setValueExplicit($Etc01, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('P'.$i)->setValueExplicit($Etc02, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->setValueExplicit($Mailling, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('R'.$i)->setValueExplicit($ACS, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('S'.$i)->setValueExplicit($RegDate, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('T'.$i)->setValueExplicit($EduManager, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('U'.$i)->setValueExplicit($UseYN, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('V'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('W'.$i)->setValueExplicit($ProtectID, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('X'.$i)->setValueExplicit($CompanySMS_array[$Marketing], PHPExcel_Cell_DataType::TYPE_STRING);

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
