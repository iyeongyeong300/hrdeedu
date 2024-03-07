<?
header("content-type:text/html; charset=EUC-KR");

include "../include/include_function.php";

require('../lib/fpdf181/korean.php');

$CompanyCode = Replace_Check($CompanyCode);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$LectureCode = Replace_Check($LectureCode);
$ServiceType = Replace_Check($ServiceType);
$ServiceTypeYN = Replace_Check($ServiceTypeYN);
 
$where = array();
$where[] = "a.CompanyCode='$CompanyCode'";
$where[] = "a.LectureStart='$LectureStart'";
$where[] = "a.LectureEnd='$LectureEnd'";
if($LectureCode) {
	$where[] = "a.LectureCode='$LectureCode'";
}
$where[] = "a.PassOk='Y'";
if($ServiceTypeYN) {
	if($ServiceTypeYN=="Y") {
		$where[] = "a.ServiceType=1";
	}else{
		$where[] = "a.ServiceType IN (3,5,9)";
	}
}else{
	if($ServiceType) {
		$where[] = "a.ServiceType='$ServiceType'";
	}
}
$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$orderby = "ORDER BY b.Name ASC";

$NotPDF = "N";

$Sql2 = "SELECT COUNT(a.Seq) FROM Study AS a 
		LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
		LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
		LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
		$where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

if($TOT_NO>0) {
	$NotPDF = "Y";
}

if($NotPDF=="Y") {
	$pdf = new PDF_Korean();
	$pdf->AddUHCFont();
	$pdf->AddPage();
	$pdf->AddUHCFont('����', 'Batang');

	$i = 0;
	$SQL = "SELECT  a.ID, a.LectureStart, a.LectureEnd, a.PassOk, a.ServiceType, a.LectureCode, 
        			b.Name, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay, 
        			c.CompanyName, d.ContentsName, d.ContentsTime 
			FROM Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			$where $orderby";
	//echo $SQL;
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY)){
    	while($ROW = mysqli_fetch_array($QUERY)){
    		extract($ROW);
    
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
    
    		if($i>0) {
    		  $pdf->AddPage();
    		}
    		
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
    
    		// ���� ������� _ �������� �ڸ���.
    		$pdf->Ln(10);
    		$contentsName = iconv("UTF-8", "CP949", $ContentsName);		
    		$contentsNameArr = explode("_",$contentsName);
    		
            if(count($contentsNameArr) == 5) {
    			$contentsName1 = $contentsNameArr[0] . "_" . $contentsNameArr[1] . "_" . $contentsNameArr[2];
                $contentsName2 =  "_" . $contentsNameArr[3] . "_" . $contentsNameArr[4];
                $pdf->WriteHTML("                �Ʒð��� : ". $contentsName1);
                $pdf->Ln(7);
                $pdf->WriteHTML("                                ". $contentsName2);
    		} else {
                $pdf->WriteHTML("                �Ʒð��� : ". $contentsName);
            }
    
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
    				$SiteName = iconv("UTF-8", "CP949", $CertSiteName2);			
    				$pdf->WriteHTML("                        ".$SiteName."");
    				$pdf->Ln(10);
    				$pdf->SetFont('����','',18);
    				$SiteName3 = iconv("UTF-8", "CP949", $CertSiteName3);			
    				$pdf->WriteHTML("                                      ".$SiteName3."");
    				$pdf->Image('../images/company_stamp2.png',158,247,20,21,'','');
    			}    
    		}else{    
                $stamp_img = "company_stamp2.png";
                if ($LectureCode == "MN003") { // ��޺����Ű��ǹ��ڱ���_���Ǻ����α�������
                    $stamp_img = "company_stamp.png";
                }
    			$pdf->Ln(30);
    			$pdf->SetFont('����','',18);
    			$pdf->WriteHTML("                                     ".$resultDate."");
    			$pdf->Ln(32);
    			$pdf->SetFont('����','',20);
    			   if ($LectureCode == "MN012") { // ��޺����Ű��ǹ��ڱ���_���Ǻ����α�������
                    $SiteName = "�ֽ�ȸ�� ����ġ�˵𿡼�";
                    $pdf->WriteHTML("                           ".$SiteName."");
                } else { 
                    $SiteName = iconv("UTF-8", "CP949", $CertSiteName2);			
                    $pdf->WriteHTML("                        ".$SiteName."");
                }
    	
    			$pdf->Ln(10);
    			$pdf->SetFont('����','',18);
    			$SiteName3 = iconv("UTF-8", "CP949", $CertSiteName3);			
    			$pdf->WriteHTML("                                      ".$SiteName3."");
    			
    			$pdf->Image('../images/company_stamp2.png',148,238,25,26,'','');
    		}
    
    		if($LectureCode=="AAAA1") {
    			$pdf->Ln(14);
    			$pdf->SetFont('����','',8);
    			$pdf->WriteHTML("                        ������������ǹ��� ��31����5�� �� ���� �� �����Ģ ��34����1�׿� ���� ���� ���Ǳ�����Ź������� ����Ͽ����� �����մϴ�.");
    			$pdf->Ln(3);
    			$pdf->WriteHTML("                                                    (�ֽ�ȸ�� ���屳�����߿����� / ��2018-180003ȣ, 2018.04.05 / ����������뵿û��)");
    		}    
    		$i++;
		}
	}
	$FileName = iconv("CP949","UTF-8", "HRDe���������_������_".$companyName.".pdf");
	$pdf->Output('D',$FileName,true);
}else{
	$msg = "���᳻���� �����ϴ�.";
	$msg = iconv("CP949","UTF-8",$msg);
?>
<script type="text/javascript">
<!--
	alert("<?=$msg?>");
	self.close();
//-->
</script>
<?
}
?>
