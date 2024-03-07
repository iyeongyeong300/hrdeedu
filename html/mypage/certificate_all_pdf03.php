<?
header("content-type:text/html; charset=EUC-KR");

include "../include/include_function.php";

require('../lib/fpdf181/korean.php');

$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$CompanyName = Replace_Check($CompanyName);
$ServiceType = Replace_Check($ServiceType);

$where = array();
if($LectureStart) {
    $where[] = "s.LectureStart='".$LectureStart."'";
}
if($LectureEnd) {
    $where[] = "s.LectureEnd='".$LectureEnd."'";
}
if($CompanyName) {
    $where[] = "c.CompanyName = '".$CompanyName."'";
}
if($ServiceType) {
    $where[] = "s.ServiceType=".$ServiceType;
    $whereA = " WHERE c.CompanyName='$CompanyName' AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' AND a.ServiceType='$ServiceType' AND a.PassOk='Y' ";
}else{
    $where[] = "s.ServiceType IN (1,3,5,9)";
    $whereA = " WHERE c.CompanyName='$CompanyName' AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' AND a.ServiceType IN (1,3,5,9) AND a.PassOk='Y' ";
}
$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

//해당 데이터가 있어야지만 수료증 출력
$NotPDF = "N";

$SqlA = "SELECT COUNT(s.Seq)
        FROM Study s JOIN Company c JOIN Course f ON s.CompanyCode = c.CompanyCode and s.LectureCode = f.LectureCode
        $where $where2 AND s.PassOK = 'Y'  ";
$ResultA = mysqli_query($connect, $SqlA);
$RowA = mysqli_fetch_array($ResultA);
$TOT_NO = $RowA[0];

if($TOT_NO>0) {
    $NotPDF = "Y";
}

if($NotPDF=="Y"){
    $pdf = new PDF_Korean();
    $pdf->AddUHCFont();
    $pdf->AddPage();
    $pdf->AddUHCFont('바탕', 'Batang');
    
    $i = 0;
    $SQLB = "SELECT a.ID, a.LectureStart, a.LectureEnd, a.PassOk, a.ServiceType, a.LectureCode,
                    b.Name, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay,
                    c.CompanyName, d.ContentsName, d.ContentsTime
            FROM Study AS a
            LEFT OUTER JOIN Member AS b ON a.ID=b.ID
            LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode
            LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode
            $whereA
            ORDER BY b.Name ASC  ";
    $QUERYB = mysqli_query($connect, $SQLB);
    if($QUERYB && mysqli_num_rows($QUERYB)){
        while($ROWB = mysqli_fetch_array($QUERYB)){
            extract($ROWB);
            
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
            if($ServiceTypeA==4) {
                $typeText = "근로자 교육과정";
            }
            
            $resultDate00 = date('Y-m-d');
            $resultDate01 = substr($resultDate00,0,4);
            $resultDate02 = substr($resultDate00,5,2);
            $resultDate03 = substr($resultDate00,8,2);
            $resultDate = $resultDate01." 년  ".(int)$resultDate02."월  ".(int)$resultDate03."일";
            
            if($i>0) {
                $pdf->AddPage();
            }
            $pdf->Image('../images/certi_print_img01.jpg',2.5,2.5,205,292.5,'','');
            
            $pdf->Ln(25);
            $pdf->SetLeftMargin(63);
            
            $pdf->SetFont('바탕','',32);
            $pdf->WriteHTML("수      료      증");
            
            $pdf->SetLeftMargin(0);
            $pdf->Ln(26);
            $pdf->SetFont('바탕','',14);
            
            $userName = iconv("UTF-8", "CP949", $Name);
            $pdf->WriteHTML("                성      명 : ".$userName);
            
            $pdf->Ln(10);
            $birth = iconv("UTF-8", "CP949", $BirthDay);
            $pdf->WriteHTML("                생년월일 : ".$birth);
            
            $pdf->Ln(16);
            $companyName = iconv("UTF-8", "CP949", $CompanyName);
            $pdf->WriteHTML("                소속회사 : ".$companyName);
            
            // 제목 길어져서 _ 기준으로 자르기.
            $pdf->Ln(10);
            $contentsName = iconv("UTF-8", "CP949", $ContentsName);
            $contentsNameArr = explode("_",$contentsName);
            if(count($contentsNameArr) == 5) {
                $contentsName1 = $contentsNameArr[0] . "_" . $contentsNameArr[1] . "_" . $contentsNameArr[2];
                $contentsName2 =  "_" . $contentsNameArr[3] . "_" . $contentsNameArr[4];
                $pdf->WriteHTML("                훈련과정 : ". $contentsName1);
                $pdf->Ln(7);
                $pdf->WriteHTML("                                ". $contentsName2);
            } else {
                $pdf->WriteHTML("                훈련과정 : ". $contentsName);
            }
            
            $pdf->Ln(10);
            $start_end = $LectureStart_Year.'년 '.$LectureStart_Month.'월 '.$LectureStart_Day.'일 ~ '.$LectureEnd_Year.'년 '.$LectureEnd_Month.'월 '.$LectureEnd_Day.'일 ('.$ContentsTime.'h)';
            $pdf->WriteHTML("                훈련기간 : ".$start_end);
            
            $pdf->Ln(10);
            
            if($ServiceType == 1){
                $typeText = '사업주 직업능력개발 훈련과정(인터넷 원격)';
            }else if($ServiceType == 3 || $ServiceType == 5 || $ServiceType == 9){
                $typeText = '인터넷 훈련과정';
            }
            $pdf->WriteHTML("                교육장소 : ".$typeText);
            
            if($LectureCode=="AAAA1") { //하단에 보건교육위탁기관으로 등록하였음이 있을 경우
                $pdf->Ln(24);
            }else{
                $pdf->Ln(34);
            }
            
            $pdf->SetFont('바탕','',19);
            $pdf->WriteHTML("               위 사람은 국민 평생 직업능력 개발법 제20조 및");
            $pdf->Ln(10);
            $pdf->WriteHTML("               제24조의 규정에 의하여 본 교육원이 실시한");
            $pdf->Ln(10);
            $pdf->WriteHTML("                    아래의 교육을 위 기간 동안에 성실히");
            $pdf->Ln(10);
            $pdf->WriteHTML("                    수행하였기에 본 증서를 수여합니다.");
            
            if($LectureCode=="AAAA1" || $LectureCode=="AAAA1") {
                $pdf->SetFont('바탕','',16);
                $pdf->Ln(17);
                if($LectureCode=="AAAA1") {
                    $pdf->WriteHTML("                1. 개인정보보호교육-개인정보보호 (1시간)");
                    $pdf->Ln(7);
                    $pdf->WriteHTML("                2. 개인정보보호교육-개인정보 안정성 확보 조치 (1시간)");
                    $pdf->Ln(7);
                    $pdf->WriteHTML("                3. 성희롱 예방교육 (1시간)");
                    $pdf->Ln(25);
                    $pdf->SetFont('바탕','',18);
                    $pdf->WriteHTML("                                     ".$resultDate."");
                    $pdf->Ln(27);
                    $pdf->SetFont('바탕','',20);
                    $SiteName = iconv("UTF-8", "CP949", $CertSiteName2);
                    $pdf->WriteHTML("                        ".$SiteName."");
                    $pdf->Ln(10);
                    $pdf->SetFont('바탕','',18);
                    $SiteName3 = iconv("UTF-8", "CP949", $CertSiteName3);
                    $pdf->WriteHTML("                                      ".$SiteName3."");
                    $pdf->Image('../images/company_stamp2.png',158,247,20,21,'','');
                }
            }else{
                $stamp_img = "company_stamp2.png";
                if ($LectureCode == "MN003") { // 긴급복지신고의무자교육_보건복지부교육영상
                    $stamp_img = "company_stamp.png";
                }
                $pdf->Ln(30);
                $pdf->SetFont('바탕','',18);
                $pdf->WriteHTML("                                     ".$resultDate."");
                $pdf->Ln(32);
                $pdf->SetFont('바탕','',20);
                if ($LectureCode == "MN012") { // 긴급복지신고의무자교육_보건복지부교육영상
                    $SiteName = "주식회사 에이치알디에셋";
                    $pdf->WriteHTML("                           ".$SiteName."");
                } else {
                    $SiteName = iconv("UTF-8", "CP949", $CertSiteName2);
                    $pdf->WriteHTML("                        ".$SiteName."");
                }
                
                $pdf->Ln(10);
                $pdf->SetFont('바탕','',18);
                $SiteName3 = iconv("UTF-8", "CP949", $CertSiteName3);
                $pdf->WriteHTML("                                      ".$SiteName3."");
                
                //$pdf->Image('../images/company_stamp.png',148,238,20,21,'','');
                if($ServiceType == 1){
                    $pdf->Image('../images/company_stamp3.png',138,236,25,26,'','');
                }else if($ServiceType == 3 || $ServiceType == 5 || $ServiceType == 9){
                    $pdf->Image('../images/company_stamp2.png',148,238,25,26,'','');
                }
            }
            
            if($LectureCode=="AAAA1") {
                $pdf->Ln(14);
                $pdf->SetFont('바탕','',8);
                $pdf->WriteHTML("                        「산업안전보건법」 제31조제5항 및 같은 법 시행규칙 제34조제1항에 따라 안전 보건교육위탁기관으로 등록하였음을 증명합니다.");
                $pdf->Ln(3);
                $pdf->WriteHTML("                                                    (주식회사 톡톡교육개발연구원 / 제2018-180003호, 2018.04.05 / 광주지방고용노동청장)");
            }
            $i++;
        }
    }
    $FileName = iconv("CP949","UTF-8", "HRDe평생교육원_수료증(전체)_".$companyName.".pdf");
    $pdf->Output('D',$FileName,true);    
}else{
    $msg = "수료내역이 없습니다.";
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
