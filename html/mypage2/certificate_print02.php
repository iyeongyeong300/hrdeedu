<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$CompanyCode = Replace_Check($CompanyCode);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$ServiceTypeYN = Replace_Check($ServiceTypeYN);


$where = array();

$where[] = "a.CompanyCode='$CompanyCode'";

$where[] = "a.LectureStart='$LectureStart'";

$where[] = "a.LectureEnd='$LectureEnd'";

$where[] = "a.PassOk='Y'";

if($ServiceTypeYN=="Y") {
	$where[] = "a.ServiceType=1";
}else{
	$where[] = "a.ServiceType IN (3,5)";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$orderby = "ORDER BY b.Name ASC";

//echo $where;

$Sql2 = "SELECT COUNT(a.Seq) FROM Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			$where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style_certi.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function() {

	Yes = confirm("<?=$TOT_NO?>건의 수료내역이 있습니다.\n\n인쇄하시겠습니까?");
	if(Yes==true) {
		window.print();
	}
});
//-->
</script>
</HEAD>
<!-- <BODY leftmargin="0" topmargin="0" onload="window.print();"> -->
<BODY leftmargin="0" topmargin="0">
<?
$i = 0;
$SQL = "SELECT 
			a.ID, a.LectureStart, a.LectureEnd, a.PassOk, a.ServiceType, a.LectureCode, 
			b.Name, AES_DECRYPT(UNHEX(b.BirthDay),'$DB_Enc_Key') AS BirthDay, 
			c.CompanyName, 
			d.ContentsName, d.ContentsTime 
			FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			$where $orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
while($ROW = mysqli_fetch_array($QUERY))
	{
	extract($ROW);

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
?>
<?if($i>0) {?>
<p style="page-break-before:always;"></p>
<?}?>
<div class="certi_print" id="CertiDiv" >

	<div class="backImg" ><img src="/images/certi_print_img01.jpg" /></div>
    
    <div class="infoArea">
    	<p class="title_ty01">수&nbsp;&nbsp;&nbsp;&nbsp;료&nbsp;&nbsp;&nbsp;&nbsp;증</p>
        
        <ul class="info">
        	<li>
            	<span>성&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명</span>
                <span><?=$Name?></span>
        	</li>
            <li>
            	<span>생년월일</span>
                <span><?=$BirthDay?></span>
        	</li>
			<li class="mt10">
            	<span>소속회사</span>
                <span><?=$CompanyName?></span>
        	</li>
            <li>
            	<span>훈련과정</span>
                <span><?=$ContentsName?></span>
        	</li>
            <li>
            	<span>훈련기간</span>
                <span><?=$LectureStart_view?> ~ <?=$LectureEnd_view?> (<?=$ContentsTime?>h)</span>
        	</li>
            <li>
            	<span>교육장소</span>
                <span><?=$typeText?></span>
        	</li>
        </ul>
        
        <div class="txt_ty01" style="margin-top:20px;">위 사람은 우리 교육원에서 실시한 재직자 직무역량향상<br />
			교육을 수료하였으므로 이 증서를 수여합니다.
        </div>
        <?if($LectureCode=="AAAA1") { ?>
			<div class="txt_ty02" style="margin-top:20px;">
			1. 개인정보보호교육-개인정보보호 (1시간)<br />
			2. 성희롱 예방교육 (1시간)<br />
			3. 장애와 장애인의 이해 (1시간)<br />
			4. 장애인과 고용 (1시간)<br />
			5. 장애인 인식개선, 장애인과 의사소통하는 방법 (1시간)<br />
			6. 퇴직연금제도 (1시간)<br />
			7. 화재 예방을 위한 소방안전교육 (1시간)
        </div>

		<?}else{?>
        <div class="txt_ty02" style="margin-top:20px;"><br /><br /><br /><br /><br /><br /></div>
		<?}?>
        
        <div class="txt_ty01" style="margin-top:20px;"><?=$resultDate?></div>
        
        <div class="txt_ty01" style="margin-top:10px; text-align:center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$CertSiteName?><img src="/images/company_stamp.png" align="absmiddle" width="95" height="98" /></div>
        
        
    </div>
    
</div>

<?
$i++;
	}
}
?>

</BODY>
</html>
<?
mysqli_close($connect);
?>