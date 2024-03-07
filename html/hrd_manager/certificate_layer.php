<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq);

$Sql = "SELECT 
			a.ID, a.ServiceType, a.LectureStart, a.LectureEnd, a.PassOk, 
			b.Name, AES_DECRYPT(UNHEX(b.BirthDay),'$DB_Enc_Key') AS BirthDay, 
			c.CompanyName, 
			d.ContentsName, 
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
	$ServiceType= $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$PassOk = $Row['PassOk'];
	$Name = $Row['Name'];
	$BirthDay = $Row['BirthDay'];
	$CompanyName = $Row['CompanyName'];
	$ContentsName = $Row['ContentsName'];
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

}

if($PassOk!="Y") {
?>
<script type="text/javascript">
<!--
	alert("수료여부를 확인하세요.");
	DataResultClose();
//-->
</script>
<?
exit;
}

//if($PaymentCount<1) {
?>
<script type="text/javascript">
<!--
	//alert("교육비 결제여부를 확인하세요.");
	//DataResultClose();
//-->
</script>
<?
//exit;
//}
?>
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>수료증 출력</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
		<colgroup>
		<col width="120px" />
		<col width="" />
	  </colgroup>
		<tr>
			<th>성명</th>
			<td><?=$Name?></td>
		</tr>
		<tr>
			<th>생년월일</th>
			<td><?=$BirthDay?></td>
		</tr>
		<tr>
			<th>소속</th>
			<td><?=$CompanyName?></td>
		</tr>
		<tr>
			<th>훈련과정</th>
			<td><?=$ContentsName?></td>
		</tr>
		<tr>
			<th>훈력직종</th>
			<td><?=$typeText?></td>
		</tr>
		<tr>
			<th>훈련기간</th>
			<td><?=$LectureStart_view?> ~ <?=$LectureEnd_view?></td>
		</tr>
	</table>


	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
		<tr>
			<td>&nbsp;</td>
			<td height="35" align="center">
				<button type="button" class="btn round btn_LBlue line" onclick="CertificatePrintPage(<?=$Seq?>)"><i class="fas fa-print"></i> 수료증 출력하기</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" class="btn round btn_LRed line" onclick="CertificatePrintPDF(<?=$Seq?>)"><i class="fas fa-file-pdf"></i> 수료증 PDF로 출력하기</button>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="left" width="100">&nbsp;</td>
			<td align="center"> </td>
			<td width="100" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
		</tr>
	</table>

            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>