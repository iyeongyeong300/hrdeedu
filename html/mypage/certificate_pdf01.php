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
	$LectureStart_view = $LectureStart_Year."�� ".$LectureStart_Month."�� ".$LectureStart_Day."��";

	$LectureEnd_array = explode("-",$LectureEnd);
	$LectureEnd_Year = $LectureEnd_array[0];
	$LectureEnd_Month = $LectureEnd_array[1];
	$LectureEnd_Day = $LectureEnd_array[2];
	$LectureEnd_view = $LectureEnd_Year."�� ".$LectureEnd_Month."�� ".$LectureEnd_Day."��";


	if($ServiceType==1) {
		$typeText = "����� �����ɷ°��� �Ʒð���(���ͳ� ����)";
	}

	if($ServiceType==3 || $ServiceType==5 || $ServiceType==9) {
		$typeText = "���ͳ� �Ʒð���";
	}

	if($ServiceType==4) {
		$typeText = "�ٷ��� ��������";
	}

	$resultDate00 = date('Y-m-d');
	$resultDate01 = substr($resultDate00,0,4);
	$resultDate02 = substr($resultDate00,5,2);
	$resultDate03 = substr($resultDate00,8,2);
	$resultDate = $resultDate01." ��  ".(int)$resultDate02."��  ".(int)$resultDate03."��";
}

$NotPDF = "Y";

if($PassOk!="Y") {
	$NotPDF = "N";
	$msg01 = "���Ῡ�θ� Ȯ���ϼ���.";
}

if($LoginAdminID && $LoginAdminDept=="A") {
	$PaymentCount=1; //�����ڷ� �α��ν� �������ο� ������� ���
}

/*
if($PaymentCount<1) {
	$NotPDF = "N";
	$msg02 = "������ �������θ� Ȯ���ϼ���.";
}
*/


if($NotPDF=="Y") {



	$pdf = new PDF_Korean();
	$pdf->AddUHCFont();
	$pdf->AddPage();
	$pdf->AddUHCFont('����', 'Batang');
 
		
		$pdf->Image('../images/certi_print_img01.jpg',2.5,2.5,205,292.5,'','');

		$pdf->Ln(25);
		$pdf->SetLeftMargin(63);

		
		$pdf->SetFont('����','',32);
		$pdf->WriteHTML("��      ��      ��");

		$pdf->SetLeftMargin(0);
		$pdf->Ln(26);
		$pdf->SetFont('����','',14);

		$userName = iconv("UTF-8", "CP949", $Name);
		$pdf->WriteHTML("                ��      �� : ".$userName);

		$pdf->Ln(10);
		$birth = iconv("UTF-8", "CP949", $BirthDay);
		$pdf->WriteHTML("                ������� : ".$birth);

		$pdf->Ln(16);
		$companyName = iconv("UTF-8", "CP949", $CompanyName);
		$pdf->WriteHTML("                �Ҽ�ȸ�� : ".$companyName);

		$pdf->Ln(10);
		$contentsName = iconv("UTF-8", "CP949", $ContentsName);
		$pdf->WriteHTML("                �Ʒð��� : ".$contentsName);

		$pdf->Ln(10);
		$start_end = $LectureStart_Year.'�� '.$LectureStart_Month.'�� '.$LectureStart_Day.'�� ~ '.$LectureEnd_Year.'�� '.$LectureEnd_Month.'�� '.$LectureEnd_Day.'�� ('.$ContentsTime.'h)';
		$pdf->WriteHTML("                �ƷñⰣ : ".$start_end);

		$pdf->Ln(10);

		if($ServiceType == 1){
			$typeText = '����� �����ɷ°��� �Ʒð���(���ͳ� ����)';
		}else if($ServiceType == 3 || $ServiceType == 5 || $ServiceType == 9){
			$typeText = '���ͳ� �Ʒð���';
		}
		$pdf->WriteHTML("                ������� : ".$typeText);

		if($LectureCode=="AAAA1") { //�ϴܿ� ���Ǳ�����Ź������� ����Ͽ����� ���� ���
		$pdf->Ln(24);
		}else{
		$pdf->Ln(34);
		}

		$pdf->SetFont('����','',19);
		$pdf->WriteHTML("               �� ����� ���� ��� �����ɷ� ���߹� ��20�� ��");
		$pdf->Ln(10);
		$pdf->WriteHTML("               ��24���� ������ ���Ͽ� �� �������� �ǽ���");
		$pdf->Ln(10);
		$pdf->WriteHTML("                    �Ʒ��� ������ �� �Ⱓ ���ȿ� ������");
		$pdf->Ln(10);
		$pdf->WriteHTML("                    �����Ͽ��⿡ �� ������ �����մϴ�.");

		if($LectureCode=="AAAA1" || $LectureCode=="AAAA1") {
			$pdf->SetFont('����','',16);
			$pdf->Ln(17);
			if($LectureCode=="AAAA1") {
				$pdf->WriteHTML("                1. ����������ȣ����-����������ȣ (1�ð�)");
				$pdf->Ln(7);
				$pdf->WriteHTML("                2. ����������ȣ����-�������� ������ Ȯ�� ��ġ (1�ð�)");
				$pdf->Ln(7);
				$pdf->WriteHTML("                3. ����� ���汳�� (1�ð�)");
				$pdf->Ln(25);
				$pdf->SetFont('����','',18);
				$pdf->WriteHTML("                                     ".$resultDate."");
				$pdf->Ln(27);
				$pdf->SetFont('����','',20);
				$SiteName = iconv("UTF-8", "CP949", $CertSiteName);
				$pdf->WriteHTML("                              ".$SiteName."");
				$pdf->Image('../images/company_stamp.png',128,247,20,21,'','');
			}

		}else{

			$pdf->Ln(30);
			$pdf->SetFont('����','',18);
			$pdf->WriteHTML("                                     ".$resultDate."");
			$pdf->Ln(32);
			$pdf->SetFont('����','',20);
			$SiteName = iconv("UTF-8", "CP949", $CertSiteName);
			$pdf->WriteHTML("                                ".$SiteName."");
			//$pdf->Image('../images/company_stamp.png',148,238,20,21,'','');
                        $pdf->Image('../images/company_stamp3.png',138,236,20,21,'','');
		}

		if($LectureCode=="AAAA1") {
			$pdf->Ln(14);
			$pdf->SetFont('����','',8);
			$pdf->WriteHTML("                        ������������ǹ��� ��31����5�� �� ���� �� �����Ģ ��34����1�׿� ���� ���� ���Ǳ�����Ź������� ����Ͽ����� �����մϴ�.");
			$pdf->Ln(3);
			$pdf->WriteHTML("                                                    (�ֽ�ȸ�� ���屳�����߿����� / ��2018-180003ȣ, 2018.04.05 / ����������뵿û��)");
		}


	
 


	$FileName = iconv("CP949","UTF-8", "������_".date('YmdHis').".pdf");
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