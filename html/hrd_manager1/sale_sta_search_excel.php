<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$Dept_idx = Replace_Check($Dept_idx);
$DeptString = Replace_Check($DeptString);
$StartColume = Replace_Check($StartColume);
$EndColume = Replace_Check($EndColume);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$SalesID = Replace_Check($SalesID);
$TOT_NO = Replace_Check($TOT_NO);

##-- 검색 조건
$where = array();
$where2 = array();
$where3 = array();
$where4 = array();

$where[] = "a.Dept='B'";

if($DeptString) {
	$where[] = "a.DeptString LIKE '".$DeptString."%'";
}


$where2[] = "b.Dept='B'";
$where2[] = "b.UseYN='Y'";
$where2[] = "b.Del='N'";

if($SalesID) {
	$where2[] = "(b.ID='".$SalesID."' OR b.Name='".$SalesID."')";
}


if(!$StartColume) {
	$StartColume = "LectureStart";
}

if(!$EndColume) {
	$EndColume = "LectureEnd";
}

if(!$LectureStart) {
	$LectureStart = date("Y")."-01-01";
}

if(!$LectureEnd) {
	$LectureEnd = date("Y-m-").get_end_day(date("Y"),date("m"));
}

if($StartColume=="InputDate") {
	$LectureStart = $LectureStart." 00:00:01";
}

if($EndColume=="InputDate") {
	$LectureEnd = $LectureEnd." 59:59:59";
}

$where3[] = "(c.".$StartColume." >= '".$LectureStart."' AND c.".$EndColume." <= '".$LectureEnd."')";
$where3[] = "c.ServiceType=1";
$where3[] = "c.SalesID=b.ID";


$where4[] = "e.Dept_idx=a.idx";
$where4[] = "(d.".$StartColume." >= '".$LectureStart."' AND d.".$EndColume." <= '".$LectureEnd."')";
$where4[] = "d.ServiceType=1";
$where4[] = "e.Dept='B'";
$where4[] = "e.UseYN='Y'";
$where4[] = "e.Del='N'";



$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$where2 = implode(" AND ",$where2);
if($where2) $where2 = "WHERE $where2";

$where3 = implode(" AND ",$where3);
if($where3) $where3 = "WHERE $where3";

$where4 = implode(" AND ",$where4);
if($where4) $where4 = "WHERE $where4";

$str_orderby = "ORDER BY a.OrderByNum ASC";
$str_orderby2 = "ORDER BY b.Name ASC";



//수강 인원
$FirstSubQuery01 = "(SELECT COUNT(d.Seq) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4) AS StudyCount";
//수료 인원
$FirstSubQuery02 = "(SELECT COUNT(d.Seq) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4 AND d.PassOk='Y') AS StudyPassOkCount";
//전체 매출
$FirstSubQuery03 = "(SELECT SUM(d.rPrice) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4 AND d.PassOk='Y') AS SumPrice";
//수수료율 평균
$FirstSubQuery04 = "(SELECT AVG(e.CommissionRatio) FROM StaffInfo AS e WHERE e.Dept_idx=a.idx AND e.Dept='B' AND e.UseYN='Y' AND e.Del='N') AS CommissionRatio";
//예상 수당
$FirstSubQuery05 = "(SELECT SUM(d.rPrice * e.CommissionRatio * 0.01) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4 AND d.PassOk='Y') AS Commission";



//수강 인원
$SecondSubQuery01 = "(SELECT COUNT(c.Seq) FROM Study AS c $where3) AS StudyCount";
//수료 인원
$SecondSubQuery02 = "(SELECT COUNT(c.Seq) FROM Study AS c $where3 AND c.PassOk='Y') AS StudyPassOkCount";
//전체 매출
$SecondSubQuery03 = "(SELECT SUM(c.rPrice) FROM Study AS c $where3 AND c.PassOk='Y') AS SumPrice";


$filename = "영업통계(사업주)_".date('Ymd');

$TOT_NO2 = $TOT_NO + 2;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("구분");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("수강 인원");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("수료 인원");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("이수율(%)");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("전체 매출");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("영업자 수수료율(%)");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("예상 수당");

$TotalStudyCount = 0;
$TotalStudyPassOkCount = 0;
$TotalSumPrice = 0;
$TotalCommission = 0;
$i=2;

$SQL = "SELECT *, $FirstSubQuery01, $FirstSubQuery02, $FirstSubQuery03, $FirstSubQuery04, $FirstSubQuery05 FROM DeptStructure AS a $where $str_orderby";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
while($ROW = mysqli_fetch_array($QUERY))
	{
	extract($ROW);

	switch($Deep) {
		case 1:
			$bgcolor = "f2f2f2";
		break;
		case 2:
			$bgcolor = "ffffe1";
		break;
		case 3:
			$bgcolor = "ffdddd";
		break;
		case 4:
			$bgcolor = "d9d9ff";
		break;
		case 5:
			$bgcolor = "d9ecff";
		break;
		case 6:
			$bgcolor = "d9ffd9";
		break;
		case 7:
			$bgcolor = "e6ffe6";
		break;
		case 8:
			$bgcolor = "ebf5f5";
		break;
		case 9:
			$bgcolor = "e6f2f2";
		break;
		case 9:
			$bgcolor = "d7ebff";
		break;

		default:
			$bgcolor = "FFFFFF";
	}

	if(!$StudyPassOkCount || !$StudyCount) {
		$FirstPassOkRatio = 0;
	}else{
		$FirstPassOkRatio = $StudyPassOkCount / $StudyCount * 100;
	}

	if(!$CommissionRatio) {
		$CommissionRatio = 0;
	}

	if(!$SalesID) {

		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($bgcolor);

		$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($DeptName, PHPExcel_Cell_DataType::TYPE_STRING);

		$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('#,##0');
		$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($StudyCount, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('#,##0');
		$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($StudyPassOkCount, PHPExcel_Cell_DataType::TYPE_NUMERIC);


		$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		if($FirstPassOkRatio>0) {
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('#.#0');
		}
		$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit(number_format($FirstPassOkRatio,2), PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('#,##0');
		$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($SumPrice, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($CommissionRatio, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('#,##0');
		$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Commission, PHPExcel_Cell_DataType::TYPE_NUMERIC);

		}


		$SQL2 = "SELECT *, $SecondSubQuery01, $SecondSubQuery02, $SecondSubQuery03 FROM StaffInfo AS b $where2 AND b.Dept_idx=$idx $str_orderby2";
		//echo $SQL2."<BR>";
		$QUERY2 = mysqli_query($connect, $SQL2);
		if($QUERY2 && mysqli_num_rows($QUERY2))
		{
			while($ROW2 = mysqli_fetch_array($QUERY2))
			{

			$i++;

			if(!$ROW2['StudyCount'] || !$ROW2['StudyPassOkCount']) {
				$SecondPassOkRatio = 0;
			}else{
				$SecondPassOkRatio = $ROW2['StudyPassOkCount'] / $ROW2['StudyCount'] * 100;
			}

			if(!$ROW2['SumPrice'] || !$ROW2['CommissionRatio']) {
				$SecondCommission = 0;
			}else{
				$SecondPassOkRatio = $ROW2['StudyPassOkCount'] / $ROW2['StudyCount'] * 100;
			}

			$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($ROW2['Name'], PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ROW2['StudyCount'], PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ROW2['StudyPassOkCount'], PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			if($SecondPassOkRatio>0) {
			$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('#.#0');
			}
			$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit(number_format($SecondPassOkRatio,2), PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ROW2['SumPrice'], PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($ROW2['CommissionRatio'], PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($SecondCommission, PHPExcel_Cell_DataType::TYPE_NUMERIC);


			$TotalStudyCount = $TotalStudyCount + $ROW2['StudyCount'];
			$TotalStudyPassOkCount = $TotalStudyPassOkCount + $ROW2['StudyPassOkCount'];
			$TotalSumPrice = $TotalSumPrice + $ROW2['SumPrice'];
			$TotalCommission = $TotalCommission + $SecondCommission;
			$TotalCount++;

			}
		}



	$i++;
	}
}

	if(!$TotalStudyPassOkCount || !$TotalStudyCount) {
		$TotalPassOkRatio = 0;
	}else{
		$TotalPassOkRatio = $TotalStudyPassOkCount / $TotalStudyCount * 100;
	}


	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');

	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit('합계', PHPExcel_Cell_DataType::TYPE_STRING);

	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('#,##0');
	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($TotalStudyCount, PHPExcel_Cell_DataType::TYPE_NUMERIC);

	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('#,##0');
	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($TotalStudyPassOkCount, PHPExcel_Cell_DataType::TYPE_NUMERIC);

	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	if($TotalPassOkRatio>0) {
	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('#.#0');
	}
	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($TotalPassOkRatio, PHPExcel_Cell_DataType::TYPE_NUMERIC);

	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getNumberFormat()->setFormatCode('#,##0');
	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($TotalSumPrice, PHPExcel_Cell_DataType::TYPE_NUMERIC);

	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit('', PHPExcel_Cell_DataType::TYPE_STRING);

	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('#,##0');
	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($TotalCommission, PHPExcel_Cell_DataType::TYPE_NUMERIC);



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
