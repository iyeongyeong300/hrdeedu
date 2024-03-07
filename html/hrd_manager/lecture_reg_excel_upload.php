<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

ob_start(); 

require_once "../lib/PHPExcel_1.8.0/Classes/PHPExcel.php"; // PHPExcel.php
$objPHPExcel = new PHPExcel();
require_once "../lib/PHPExcel_1.8.0/Classes/PHPExcel/IOFactory.php"; // IOFactory.php


$fileName = $_FILES['file']['tmp_name'];

try{


	// 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
	$objReader = PHPExcel_IOFactory::createReaderForFile($fileName);
	// 읽기전용으로 설정
	$objReader->setReadDataOnly(true);
	// 엑셀파일을 읽는다
	$objExcel = $objReader->load($fileName);
	// 첫번째 시트를 선택
	$objExcel->setActiveSheetIndex(0);
	$objWorksheet = $objExcel->getActiveSheet();
	$rowIterator = $objWorksheet->getRowIterator();

	foreach ($rowIterator as $row) { // 모든 행에 대해서
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); 
	}

	$maxRow = $objWorksheet->getHighestRow();

	$query_select = "SELECT MAX(idx) FROM StudyExcelTemp WHERE ID='$LoginAdminID'";
	$result_select = mysqli_query($connect, $query_select);
	$result_row = mysqli_fetch_array($result_select);
	$max_no = $result_row[0] + 1;


	$OpenChapterBasic = "";
	$k = $max_no;
	$startLine = 2;
	$excelType = 'v1';

	// 신규 처리 방식 23.04.11
	if($objWorksheet->getCell('E12')->getValue()=='근로자구분'){
		$excelType = 'v2';
		$startLine = 14;
	}
	
	for($i = $startLine; $i <= $maxRow; $i++) {
		if($excelType == 'v2'){
			$LectureCode = ''; // 강의코드
			$ContentsName = ''; // 과정명
			$Tutor = ''; // 첨삭강사
			
			if($_POST["ExcelServiceType"]=='3'){  //일반(비환급)
				$LectureCode = $_POST["ExcelLectureCode"]; 
				$Tutor = 'HRDET';
			}else if($_POST["ExcelServiceType"]=='5'){	// 비환급(평가있음)
				$Uptae = $objWorksheet->getCell('B6')->getValue();
				$JobType = trim($objWorksheet->getCell('E'.$i)->getValue());
				$JobTypeKey = array_search($JobType,$JobType_array);
				$QuaterType = '';
				if(($JobTypeKey == 'A')||($JobTypeKey == 'B')){ // 현장직, 사무직은 분기 추가
					$QuaterType = $_POST["ExcelQuaterType"];
				}
				$LectureCode = 'SAFE'.array_search($Uptae,$UptaeType_array).$JobTypeKey.$QuaterType; //SAFE.Uptae.jobtype.분기
				$Tutor = 'sanup';
			}

			$Name = trim($objWorksheet->getCell('B'.$i)->getValue()); //성명
			$ResNo = trim($objWorksheet->getCell('C'.$i)->getValue()); // 주민번호
			$Mobile = trim($objWorksheet->getCell('D'.$i)->getValue()); // 휴대폰
			$Email = ''; // 이메일
			$CompanyCode = trim($objWorksheet->getCell('D3')->getValue()); // 사업자번호
			$CompanyName = ''; // 회사명
			$Depart = ''; // 부서
			$LectureStart = $_POST["ExcelLectureStart"]; // 수강 시작일
			$LectureEnd = $_POST["ExcelLectureEnd"]; // 수강 종료일
			$LectureReStudy = date("Y-m-d",strtotime($LectureEnd . " + 7 days")); // 복습종료일 (수강종료일+7)
			$Price = ''; // 수강료
			$rPrice = ''; // 환급비
			$ServiceType = $_POST["ExcelServiceType"]; // 서비스 구분
			$UserID = trim($objWorksheet->getCell('F'.$i)->getValue()); // 수강생 아이디
			$Pwd = '1111'; // 비밀번호
			$nwIno = ''; // 비용수급사업장
			$trneeSe = ''; // 훈련생구분
			$IrglbrSe = ''; // 비정규직구분
			$OpenChapter = '1'; // 실시회차
			$SalesID = trim($objWorksheet->getCell('F3')->getValue()); // 영업담당자 아이디
			$EduManager = ''; // 교육담당자 여부
			if(($Name == $objWorksheet->getCell('B8')->getValue()) && ($Mobile == $objWorksheet->getCell('D8')->getValue())){
				$EduManager = 'Y';
			}
			$tok2ID = ''; // tok2 아이디

		}else{
			$LectureCode = trim($objWorksheet->getCell('A' . $i)->getValue()); // 강의코드
			$ContentsName = $objWorksheet->getCell('B' . $i)->getValue(); // 과정명
			$Tutor = trim($objWorksheet->getCell('C' . $i)->getValue()); // 첨삭강사
			$Name = trim($objWorksheet->getCell('D' . $i)->getValue()); //성명
			$ResNo = trim($objWorksheet->getCell('E' . $i)->getValue()); // 주민번호
			$Mobile = trim($objWorksheet->getCell('F' . $i)->getValue()); // 휴대폰
			$Email = trim($objWorksheet->getCell('G' . $i)->getValue()); // 이메일
			$CompanyCode = trim($objWorksheet->getCell('H' . $i)->getValue()); // 사업자번호
			$CompanyName = $objWorksheet->getCell('I' . $i)->getValue(); // 기업명
			$Depart = trim($objWorksheet->getCell('J' . $i)->getValue()); // 부서
			$LectureStart = trim($objWorksheet->getCell('K' . $i)->getValue()); // 수강 시작일
			$LectureEnd = trim($objWorksheet->getCell('L' . $i)->getValue()); // 수강 종료일
			$LectureReStudy = trim($objWorksheet->getCell('M' . $i)->getValue()); // 복습종료일
			$Price = trim($objWorksheet->getCell('N' . $i)->getValue()); // 수강료
			$rPrice = trim($objWorksheet->getCell('O' . $i)->getValue()); // 환급비
			$ServiceType = trim($objWorksheet->getCell('P' . $i)->getValue()); // 서비스 구분
			$UserID = trim($objWorksheet->getCell('Q' . $i)->getValue()); // 수강생 아이디
			$Pwd = trim($objWorksheet->getCell('R' . $i)->getValue()); // 비밀번호
			$nwIno = trim($objWorksheet->getCell('S' . $i)->getValue()); // 비용수급사업장
			$trneeSe = trim($objWorksheet->getCell('T' . $i)->getValue()); // 훈련생구분
			$IrglbrSe = trim($objWorksheet->getCell('U' . $i)->getValue()); // 비정규직구분
			$OpenChapter = trim($objWorksheet->getCell('V' . $i)->getValue()); // 실시회차
			$SalesID = trim($objWorksheet->getCell('W' . $i)->getValue()); // 영업담당자 아이디
			$EduManager = trim($objWorksheet->getCell('X' . $i)->getValue()); // 교육담당자 여부
			$tok2ID = trim($objWorksheet->getCell('Y' . $i)->getValue()); // tok2 아이디

			$LectureStart = PHPExcel_Style_NumberFormat::toFormattedString($LectureStart, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$LectureEnd = PHPExcel_Style_NumberFormat::toFormattedString($LectureEnd, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			$LectureReStudy = PHPExcel_Style_NumberFormat::toFormattedString($LectureReStudy, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		}

		if($LectureCode) {

			$CompanyCode = trim($CompanyCode);
			$CompanyCode = str_replace('-','',$CompanyCode);
			$CompanyCode = str_replace(' ','',$CompanyCode);

			if(!$trneeSe) {
				$trneeSe = "007";
			}

			if(!$IrglbrSe) {
				$IrglbrSe = "000";
			}

			if($EduManager=="1" || $EduManager=="Y") {
				$EduManager = "Y";
			}else{
				$EduManager = "N";
			}

			if(!$SalesID || strlen($SalesID) < 2) {
				$query_select2 = "SELECT SalesManager FROM Company WHERE CompanyCode='$CompanyCode'";
				$result_select2 = mysqli_query($connect, $query_select2);
				$result_row2 = mysqli_fetch_array($result_select2);
				$SalesID = $result_row2['SalesManager'];
			}

			if(!$OpenChapter) {
				$OpenChapter = $OpenChapterBasic;
			}

			$OpenChapterBasic = $OpenChapter;

			$ResNo_array = explode("-",$ResNo);
			$ResNo01 = $ResNo_array[0];
			$ResNo02 = $ResNo_array[1];

			$InputResNo = $ResNo01.$ResNo02;

			$Sql_m = "SELECT * FROM Member WHERE ResNo=HEX(AES_ENCRYPT('$InputResNo','el@2018!@#$'))";
			$Result_m = mysqli_query($connect, $Sql_m);
			$Row_m = mysqli_fetch_array($Result_m);

			if($Row_m) {
				$UserID = $Row_m['ID'];
				$tok2ID = $Row_m['tok2ID'];
			}

			//임시 테이블에 등록
			$maxno = max_number("idx","StudyExcelTemp");
			$Sql = "INSERT INTO StudyExcelTemp
						(idx, ID, LectureCode, Tutor, Name, ResNo, Mobile, Email, CompanyCode, Depart, LectureStart, LectureEnd, LectureReStudy, Price, rPrice, ServiceType, UserID, Pwd, nwIno, trneeSe, IrglbrSe, OpenChapter, SalesID, EduManager, RegDate, tok2ID) 
						VALUES($maxno, '$LoginAdminID', '$LectureCode', '$Tutor', '$Name', '$ResNo', '$Mobile', '$Email', '$CompanyCode', '$Depart', '$LectureStart', '$LectureEnd', '$LectureReStudy', '$Price', '$rPrice', '$ServiceType', '$UserID', '$Pwd', '$nwIno', '$trneeSe', '$IrglbrSe', '$OpenChapter', '$SalesID', '$EduManager', NOW(), '$tok2ID')";
			//echo $Sql;
			$Row = mysqli_query($connect, $Sql);

			if(!$Row) {
	?>
	<script type="text/javascript">
	<!--
		alert("데이터 확인 위해 엑셀파일을 저장중 오류 발생");
		top.location.reload();
	//-->
	</script>
	<?
			exit;
			}

		}


	$k++;
	}

?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
<!--
	
	top.document.ExcelUpForm.reset();
	top.$("#UploadSubmitBtn").show();
	top.$("#UploadWaiting").hide();
	top.ExcelUploadListRoading('A');
	
	top.$('#ExcelServiceType').val("3").trigger('change');
	top.$('#ExcelLectureCode option:eq(0)').prop('selected', true).trigger('change');
	
//-->
</script>
<?

}catch (exception $e) {
?>
<script type="text/javascript">
<!--
	alert("엑셀파일을 읽는도중 오류가 발생하였습니다.");
//-->
</script>
<?
exit;
}

ob_end_flush(); // 버퍼의 내용을 출력한 후 현재 출력 버퍼를 종료 

mysqli_close($connect);
?>