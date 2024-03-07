<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$pay_idx = Replace_Check_XSS2($pay_idx);
$ID = Replace_Check_XSS2($ID);

if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	alert("로그인후에 이용이 가능합니다.");
	DataResultClose();
//-->
</script>
<?
}else{


	$Sql = "SELECT * 
				FROM PaymentSheet2 AS a
				WHERE a.ID='$ID' AND (a.PayStatus='R' OR a.PayStatus='S' OR a.PayStatus='Y') AND a.idx=$pay_idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CardPrice = $Row['CardPrice'];
		$PayStatus = $Row['PayStatus'];
		$BankInfo = $Row['BankInfo'];

		$BankInfo_array = explode("|",$BankInfo);

		$BANKNAME = $BankInfo_array[1];
		$ACCOUNTNO = $BankInfo_array[2];
		$RECEIVERNAME = $BankInfo_array[3];
		$DEPOSITENDDATE = $BankInfo_array[4];
	}

?>
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">입금계좌 정보</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>가상계좌 결제 요청시 입금 정보입니다.</li>
			</ul>
		</div>
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <caption>입금계좌 정보</caption>
			  <colgroup>
				  <col width="120px" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td >은행명</td>
				<td><?=$$BANKNAME?></td>
			  </tr>
			  <tr>
				<td >입금계좌명</td>
				<td><?=$$ACCOUNTNO?></td>
			  </tr>
			  <tr>
				<td >예금주</td>
				<td><?=$RECEIVERNAME?></td>
			  </tr>
			  <tr>
				<td >입금만료일</td>
				<td><?=$DEPOSITENDDATE?></td>
			  </tr>
			</table>
		</div>


		<!-- btn -->
		<p class="btnAreaTc02 mt20">
			<span class="btnSmSky01"><a href="Javascript:DataResultClose();">확인</a></span>
		</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>

<?
}

mysqli_close($connect);
?>