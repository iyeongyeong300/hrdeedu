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
	$lmsSheetIndex = 0;
	if(strpos($_FILES['file']['name'],'HRD 훈련생 등록')!== false){
		$lmsSheetIndex = 1;
	}
	$objExcel->setActiveSheetIndex($lmsSheetIndex);
	$objWorksheet = $objExcel->getActiveSheet();
	$rowIterator = $objWorksheet->getRowIterator();

	foreach ($rowIterator as $row) { // 모든 행에 대해서
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); 
	}

	$maxRow = $objWorksheet->getHighestRow();
	
	$query_select = "SELECT MAX(idx) FROM CompanyExcelTemp WHERE ID='$LoginAdminID'";
	$result_select = mysqli_query($connect, $query_select);
	$row_select = mysqli_fetch_array($result_select);

	$max_no = $max_no + 1;
	$k = $max_no;

	// 신규 처리 방식 23.04.11
	if($lmsSheetIndex===1){
	
		$CompanyName = trim($objWorksheet->getCell('B3')->getValue()); // 회사명
		$CompanyScale = "C"; //회사규모
		$CompanyCode = trim($objWorksheet->getCell('D3')->getValue()); // 사업자등록번호
		$HRD = ''; // HRD번호
		$Ceo = trim($objWorksheet->getCell('B4')->getValue()); // 대표자명
		$Zipcode = '00000'; // 우편번호
		$Address01 = trim($objWorksheet->getCell('B7')->getValue()); // 주소
		$Address02 = ''; // 상세주소
		$Uptae = trim($objWorksheet->getCell('B6')->getValue()); // 업태
		$Upjong = trim($objWorksheet->getCell('D6')->getValue()); // 업종
		$Tel = trim($objWorksheet->getCell('B5')->getValue()); // 회사 전화번호
		$Email = trim($objWorksheet->getCell('D9')->getValue()); // 세금계산서 이메일
		$EduManager = trim($objWorksheet->getCell('B8')->getValue()); // 교육담당자
		$EduManagerPhone = trim($objWorksheet->getCell('D8')->getValue()); // 교육담당자 연락처
		$EduManagerEmail = trim($objWorksheet->getCell('B9')->getValue()); // 교육담당자 이메일
		$SalesManager = trim($objWorksheet->getCell('F3')->getValue()); // 영업담당자 ID
		$SalesManagerCode = substr($SalesManager,0,4);
		
		$companyIdSelect = "SELECT MAX(CompanyID) FROM Company WHERE CompanyID LIKE CONCAT('$SalesManagerCode','%')";
		$companyIdResult = mysqli_query($connect, $companyIdSelect);
		$companyIdRowselect = mysqli_fetch_array($companyIdResult);
		$maxCompanyIdx = substr($companyIdRowselect[0],-3);
		$newCompanyIdx = (int)$maxCompanyIdx + 1;
		
		$CompanyID = $SalesManagerCode.str_pad($newCompanyIdx, 3, '0', STR_PAD_LEFT); // 회사아이디
		$Remark = $CompanyID; // 메모 = 회사ID
		$CyberEnabled = 'N'; // 사이버 교육센터
		$Tel2 = ''; // 고객센터 번호
		$Fax2 = ''; // 고객센터 팩스번호
		$CSEnabled = 'N'; // 고객센터 번호 사용 여부
		
		$CompanyCode = str_replace('-','',$CompanyCode);
		$CompanyCode = str_replace(' ','',$CompanyCode);
		
		/*
		$CompanyID = trim($CompanyID);
		$CompanyID = str_replace(' ','',$CompanyID);
		
		if(!$CompanyID) {
			$CompanyID = $CompanyCode;
		}
		*/
		
		if($CompanyName && $CompanyCode) {
		//임시 테이블에 등록
			$maxno = max_number("idx","CompanyExcelTemp");
			$Sql = "INSERT INTO CompanyExcelTemp
						(idx, ID, CompanyName, CompanyID, CompanyScale, CompanyCode, HRD, Ceo, Zipcode, Address01, Address02, Uptae, Upjong, 
						Tel, Email, EduManager, EduManagerPhone, EduManagerEmail, SalesManager, Remark, CyberEnabled, Tel2, Fax2, CSEnabled, RegDate) 
						VALUES($maxno, '$LoginAdminID', '$CompanyName', '$CompanyID', '$CompanyScale', '$CompanyCode', '$HRD', '$Ceo', '$Zipcode', 
						'$Address01', '$Address02', '$Uptae', '$Upjong', '$Tel', '$Email', '$EduManager', '$EduManagerPhone', '$EduManagerEmail', 
						'$SalesManager', '$Remark', '$CyberEnabled', '$Tel2', '$Fax2', '$CSEnabled', NOW())";
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

	}else{ // 기존 처리 방식

		for($i = 2; $i <= $maxRow; $i++) {
			$CompanyName = $objWorksheet->getCell('A' . $i)->getValue(); // 회사명
			$CompanyID = $objWorksheet->getCell('B' . $i)->getValue(); // 사업주아이디
			$CompanyScale = $objWorksheet->getCell('C' . $i)->getValue(); //회사규모
			$CompanyCode = $objWorksheet->getCell('D' . $i)->getValue(); // 사업자등록번호
			$HRD = $objWorksheet->getCell('E' . $i)->getValue(); // HRD번호
			$Ceo = $objWorksheet->getCell('F' . $i)->getValue(); // 대표자명
			$Zipcode = $objWorksheet->getCell('G' . $i)->getValue(); // 우편번호
			$Address01 = $objWorksheet->getCell('H' . $i)->getValue(); // 주소
			$Address02 = $objWorksheet->getCell('I' . $i)->getValue(); // 상세주소
			$Uptae = $objWorksheet->getCell('J' . $i)->getValue(); // 업태
			$Upjong = $objWorksheet->getCell('K' . $i)->getValue(); // 업종
			$Tel = $objWorksheet->getCell('L' . $i)->getValue(); // 회사 전화번호
			$Email = $objWorksheet->getCell('M' . $i)->getValue(); // 이메일
			$EduManager = $objWorksheet->getCell('N' . $i)->getValue(); // 교육담당자
			$EduManagerPhone = $objWorksheet->getCell('O' . $i)->getValue(); // 교육담당자 연락처
			$EduManagerEmail = $objWorksheet->getCell('P' . $i)->getValue(); // 교육담당자 이메일
			$SalesManager = $objWorksheet->getCell('Q' . $i)->getValue(); // 영업담당자 ID
			$Remark = $objWorksheet->getCell('R' . $i)->getValue(); // 메모
			$CyberEnabled = $objWorksheet->getCell('S' . $i)->getValue(); // 사이버 교육센터
			$Tel2 = $objWorksheet->getCell('T' . $i)->getValue(); // 고객센터 번호
			$Fax2 = $objWorksheet->getCell('U' . $i)->getValue(); // 고객센터 팩스번호
			$CSEnabled = $objWorksheet->getCell('V' . $i)->getValue(); // 고객센터 번호 사용 여부
			$CompanyManageCode = $objWorksheet->getCell('W' . $i)->getValue(); // 기업관리코드
	
			$CompanyCode = trim($CompanyCode);
			$CompanyCode = str_replace('-','',$CompanyCode);
			$CompanyCode = str_replace(' ','',$CompanyCode);

			/*
			if(!$CompanyCode) {
				$CompanyCode = "0000";
			}
			*/

			$CompanyID = trim($CompanyID);
			$CompanyID = str_replace(' ','',$CompanyID);
			
			if(!$CompanyID) {
				$CompanyID = $CompanyCode;
			}
			if(!$CompanyScale) {
				$CompanyScale = "C";
			}
			if(!$Zipcode) {
				$Zipcode = "00000";
			}
			if(!$CSEnabled || $CSEnabled!="Y") {
				$CSEnabled = "N";
			}
			if(!$CyberEnabled || $CyberEnabled!="Y") {
				$CyberEnabled = "N";
			}
			
			if($CompanyName && $CompanyCode) {
	
			//임시 테이블에 등록
				$maxno = max_number("idx","CompanyExcelTemp");
				$Sql = "INSERT INTO CompanyExcelTemp
							(idx, ID, CompanyName, CompanyID, CompanyScale, CompanyCode, HRD, Ceo, Zipcode, Address01, Address02, Uptae, Upjong, 
						Tel, Email, EduManager, EduManagerPhone, EduManagerEmail, SalesManager, Remark, CyberEnabled, Tel2, Fax2, CSEnabled, HomePage, RegDate) 
							VALUES($maxno, '$LoginAdminID', '$CompanyName', '$CompanyID', '$CompanyScale', '$CompanyCode', '$HRD', '$Ceo', '$Zipcode', 
							'$Address01', '$Address02', '$Uptae', '$Upjong', '$Tel', '$Email', '$EduManager', '$EduManagerPhone', '$EduManagerEmail', 
						'$SalesManager', '$Remark', '$CyberEnabled', '$Tel2', '$Fax2', '$CSEnabled','$CompanyManageCode', NOW())";
						
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
	}
?>
<script type="text/javascript">
<!--
	top.location.reload();
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