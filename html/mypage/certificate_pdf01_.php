<?
header("content-type:text/html; charset=EUC-KR");

include "../include/include_function.php";

require('../lib/fpdf181/korean.php');

$Seq = Replace_Check_XSS2($Seq);


//=================================================================================================================

$Sql = "SELECT 
			a.ID, a.LectureStart, a.LectureEnd, a.PassOk, a.ServiceType, a.LectureCode, 
			b.Name, AES_DECRYPT(UNHEX(b.BirthDay),'$DB_Enc_Key') AS BirthDay, 
			c.CompanyName, 
			d.ContentsName, d.ContentsTime, 
			(SELECT COUNT(idx) FROM PaymentSheet WHERE CompanyCode=a.CompanyCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PayStatus='Y') AS PaymentCount 
			FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			WHERE a.Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ID = $Row['ID'];
	$ServiceType = $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$PassOk = $Row['PassOk'];
	$LectureCode = $Row['LectureCode'];
	$Name = $Row['Name'];
	$BirthDay = $Row['BirthDay'];
	$CompanyName = $Row['CompanyName'];
	$ContentsName = $Row['ContentsName'];
	$ContentsTime = $Row['ContentsTime'];
	$PaymentCount = $Row['PaymentCount'];

	$LectureStart_array = explode("-",$LectureStart);
	$LectureStart_Year = $LectureStart_array[0];
	$LectureStart_Month = $LectureStart_array[1];
	$LectureStart_Day = $LectureStart_array[2];
	$LectureStart_view = $LectureStart_Year."년 ".$LectureStart_Month."월 ".$LectureStart_Day."일";

	$LectureEnd_array = explode("-",$LectureEnd);
	$LectureEnd_Year = $LectureEnd_array[0];
	$LectureEnd_Month = $LectureEnd_array[1];
	$LectureEnd_Day = $LectureEnd_array[2];
	$LectureEnd_view = $LectureEnd_Year."년 ".$LectureEnd_Month."월 ".$LectureEnd_Day."일";


	if($ServiceType==1) {
		$typeText = "사업주 직업능력개발 훈련과정(인터넷 원격)";
	}

	if($ServiceType==3 || $ServiceType==5 || $ServiceType==9) {
		$typeText = "인터넷 훈련과정";
	}

	if($ServiceType==4) {
		$typeText = "근로자 교육과정";
	}

	$resultDate00 = date('Y-m-d');
	$resultDate01 = substr($resultDate00,0,4);
	$resultDate02 = substr($resultDate00,5,2);
	$resultDate03 = substr($resultDate00,8,2);
	$resultDate = $resultDate01." 년  ".(int)$resultDate02."월  ".(int)$resultDate03."일";
}

$NotPDF = "Y";

if($PassOk!="Y") {
	$NotPDF = "N";
	$msg01 = "수료여부를 확인하세요.";
}

if($LoginAdminID && $LoginAdminDept=="A") {
	$PaymentCount=1; //관리자로 로그인시 결제여부와 상관없이 출력
}

/*
if($PaymentCount<1) {
	$NotPDF = "N";
	$msg02 = "교육비 결제여부를 확인하세요.";
}
*/


if($NotPDF=="Y") {


	$pdf = new PDF_Korean();
	$pdf->AddUHCFont();
	$pdf->AddPage();



	$pdf->Image('../images/certi_print_img01.jpg',2.5,2.5,205,292.5,'','');

	$pdf->Ln(25);
	$pdf->SetLeftMargin(63);

	$pdf->AddUHCFont('궁서', 'Gungsuh');
	$pdf->SetFont('궁서','',32);
	$pdf->WriteHTML("<B>수      료      증</B>");

	$pdf->SetLeftMargin(0);
	$pdf->Ln(26);
	$pdf->SetFont('궁서','',16);

	$userName = iconv("UTF-8", "CP949", $Name);
	$pdf->WriteHTML("                <B>성      명 : </B>".$userName);

	$pdf->Ln(10);
	$birth = iconv("UTF-8", "CP949", $BirthDay);
	$pdf->WriteHTML("                <B>생년월일 : </B>".$birth);

	$pdf->Ln(16);
	$companyName = iconv("UTF-8", "CP949", $CompanyName);
	$pdf->WriteHTML("                <B>소속회사 : </B>".$companyName);

	$pdf->Ln(10);
	$contentsName = iconv("UTF-8", "CP949", $ContentsName);
	$pdf->WriteHTML("                <B>훈련과정 : </B>".$contentsName);

	$pdf->Ln(10);
	$start_end = $LectureStart_Year.'년 '.$LectureStart_Month.'월 '.$LectureStart_Day.'일 ~ '.$LectureEnd_Year.'년 '.$LectureEnd_Month.'월 '.$LectureEnd_Day.'일 ('.$ContentsTime.'h)';
	$pdf->WriteHTML("                <B>훈련기간 : </B>".$start_end);

	$pdf->Ln(10);

	if($ServiceType == 1){
		$typeText = '사업주 직업능력개발 훈련과정(인터넷 원격)';
	}else if($ServiceType == 3 || $ServiceType == 5 || $ServiceType == 9){
		$typeText = '인터넷 훈련과정';
	}
	$pdf->WriteHTML("                <B>교육장소 : </B>".$typeText);

	if($LectureCode=="AAAA1") { //하단에 보건교육위탁기관으로 등록하였음이 있을 경우
	$pdf->Ln(24);
	}else{
	$pdf->Ln(34);
	}

	$pdf->SetFont('궁서','',19);
	$pdf->WriteHTML("         <B>위 사람은 우리 교육원에서 실시한 재직자 직무역량향상</B>");
	$pdf->Ln(10);
	$pdf->WriteHTML("        <B>교육을 수료하였으므로 이 증서를 수여합니다</B>");
	
	if($LectureCode=="AAAA1" || $LectureCode=="AAAA1") {
		$pdf->SetFont('궁서','',16);
		$pdf->Ln(17);
		if($LectureCode=="AAAA1") {
			$pdf->WriteHTML("                1. 개인정보보호교육-개인정보보호 (1시간)");
			$pdf->Ln(7);
			$pdf->WriteHTML("                2. 개인정보보호교육-개인정보 안정성 확보 조치 (1시간)");
			$pdf->Ln(7);
			$pdf->WriteHTML("                3. 성희롱 예방교육 (1시간)");
			$pdf->Ln(25);
			$pdf->SetFont('궁서','',18);
			$pdf->WriteHTML("                                     <B>".$resultDate."</B>");
			$pdf->Ln(27);
			$pdf->SetFont('궁서','',20);
			$CertSiteName = iconv("UTF-8", "CP949", $CertSiteName);
			// $pdf->WriteHTML("                              <B>".$CertSiteName."</B>");
			// $pdf->Image('../images/company_stamp.png',128,247,20,21,'','');
			$pdf->Image('../images/logo.png',70,215,20,21,'','');
			$pdf->WriteHTML("                                      <B>"."평생교육원장"."</B>");		
		}

	}else{

		$pdf->Ln(30);
		$pdf->SetFont('궁서','',18);
		$pdf->WriteHTML("                                     <B>".$resultDate."</B>");
		$pdf->Ln(32);
		$pdf->SetFont('궁서','',20);
		$CertSiteName = iconv("UTF-8", "CP949", $CertSiteName);
		// $pdf->WriteHTML("                              <B>".$CertSiteName."</B>");
		// $pdf->Image('../images/company_stamp.png',146,238,20,21,'','');
		$pdf->Image('../images/logo.png',70,215,20,21,'','');
		$pdf->WriteHTML("                                      <B>"."평생교육원장"."</B>");		
	}

	if($LectureCode=="AAAA1") {
		$pdf->Ln(14);
		$pdf->SetFont('궁서','',8);
		$pdf->WriteHTML("                        「산업안전보건법」 제31조제5항 및 같은 법 시행규칙 제34조제1항에 따라 안전 보건교육위탁기관으로 등록하였음을 증명합니다.");
		$pdf->Ln(3);
		$pdf->WriteHTML("                                                    (주식회사 톡톡교육개발연구원 / 제2018-180003호, 2018.04.05 / 광주지방고용노동청장)");
	}

	$FileName = iconv("CP949","UTF-8", "수료증_".date('YmdHis').".pdf");
	$pdf->Output('D',$FileName,true);


}else{

	$msg01 = iconv("CP949","UTF-8",$msg01);
	$msg02 = iconv("CP949","UTF-8",$msg02);
?>
<script type="text/javascript">
<!--
	alert("<?=$msg01?>\n\n<?=$msg02?>");
//-->
</script>
<?
}
?>