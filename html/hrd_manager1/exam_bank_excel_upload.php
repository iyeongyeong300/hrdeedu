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

	$query_select = "SELECT MAX(idx) FROM ExamBankExcelTemp WHERE ID='$LoginAdminID'";
	$result_select = mysqli_query($connect, $query_select);
	$row_select = mysqli_fetch_array($result_select);
	$max_no = $row_select[0];
	$max_no = $max_no + 1;

	$k = $max_no;
	for($i = 2; $i <= $maxRow; $i++) {

		$LectureCode = $objWorksheet->getCell('A' . $i)->getValue(); // 과정코드
		$Question = $objWorksheet->getCell('D' . $i)->getValue(); //질문
		$Example01 = $objWorksheet->getCell('E' . $i)->getValue(); // 예문1
		$Example02 = $objWorksheet->getCell('F' . $i)->getValue(); // 예문2
		$Example03 = $objWorksheet->getCell('G' . $i)->getValue(); // 예문3
		$Example04 = $objWorksheet->getCell('H' . $i)->getValue(); // 예문4
		$Example05 = $objWorksheet->getCell('I' . $i)->getValue(); // 예문5
		$Answer = $objWorksheet->getCell('J' . $i)->getValue(); // 정답
		$Comment = $objWorksheet->getCell('K' . $i)->getValue(); // 해답 설명
		$ScoreBasis = $objWorksheet->getCell('L' . $i)->getValue(); // 채점기준
		$ExamType = $objWorksheet->getCell('N' . $i)->getValue(); // 문제 유형
		$TestType = $objWorksheet->getCell('O' . $i)->getValue(); // 시험 유형

		$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);

		if($Row) {
			$ContentsName = $Row['ContentsName']; //과정명
		}

		switch($TestType) {
			case "mid":
				$Gubun = "[중간평가] ".$ContentsName;
			break;
			case "final":
				$Gubun = "[최종평가] ".$ContentsName;
			break;
			case "report":
				$Gubun = "[과제] ".$ContentsName;
			break;
		}

		switch($ExamType) {
			case "A":
				$AnswerQuery = $Answer;
				$Answer2Query = "";
			break;
			case "B":
				$AnswerQuery = "";
				$Answer2Query = $Answer;
			break;
			case "C":
				$AnswerQuery = "";
				$Answer2Query = $Answer;
			break;
		}


		if($Example01=="0") {
			$Example01 = "0 ";
		}
		if($Example02=="0") {
			$Example02 = "0 ";
		}
		if($Example03=="0") {
			$Example03 = "0 ";
		}
		if($Example04=="0") {
			$Example04 = "0 ";
		}
		if($Example05=="0") {
			$Example05 = "0 ";
		}
		if($Comment=="0") {
			$Comment = "0 ";
		}
		if($ScoreBasis=="0") {
			$ScoreBasis = "0 ";
		}

		if($Example01==="0") {
			$Example01 = "0 ";
		}
		if($Example02==="0") {
			$Example02 = "0 ";
		}
		if($Example03==="0") {
			$Example03 = "0 ";
		}
		if($Example04==="0") {
			$Example04 = "0 ";
		}
		if($Example05==="0") {
			$Example05 = "0 ";
		}
		if($Comment==="0") {
			$Comment = "0 ";
		}
		if($ScoreBasis==="0") {
			$ScoreBasis = "0 ";
		}





		if(!$Example01) {
			$Example01 = "";
		}
		if(!$Example02) {
			$Example02 = "";
		}
		if(!$Example03) {
			$Example03 = "";
		}
		if(!$Example04) {
			$Example04 = "";
		}
		if(!$Example05) {
			$Example05 = "";
		}
		if(!$Comment) {
			$Comment = "";
		}
		if(!$ScoreBasis) {
			$ScoreBasis = "";
		}

		$Question = addslashes($Question);
		$Example01 = addslashes($Example01);
		$Example02 = addslashes($Example02);
		$Example03 = addslashes($Example03);
		$Example04 = addslashes($Example04);
		$Example05 = addslashes($Example05);
		$AnswerQuery = addslashes($AnswerQuery);
		$Answer2Query = addslashes($Answer2Query);
		$Comment = addslashes($Comment);
		$ScoreBasis = addslashes($ScoreBasis);

		//$Answer2Query = str_replace("\n","<BR>",$Answer2Query);
		$Comment = str_replace("\n","<BR>",$Comment);
		$ScoreBasis = str_replace("\n","<BR>",$ScoreBasis);

		//임시 테이블에 등록
		$maxno = max_number("idx","ExamBankExcelTemp");
		$Sql = "INSERT INTO ExamBankExcelTemp 
				(idx, Gubun, ExamType, Question, Example01, Example02, Example03, Example04, Example05, Answer, Answer2, Comment, ScoreBasis, ID, RegDate) 
				VALUES ($maxno, '$Gubun', '$ExamType', '$Question', '$Example01', '$Example02', '$Example03', '$Example04', '$Example05', '$AnswerQuery', '$Answer2Query', '$Comment', '$ScoreBasis', '$LoginAdminID', NOW())";
		//echo $k.":".$Sql."<BR><BR>";
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


	$k++;
	}

?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
<!--
	top.document.ExcelUpForm.reset();
	top.$("#UploadSubmitBtn").show();
	top.$("#UploadWaiting").hide();
	top.ExamExcelUploadListRoading('A');
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