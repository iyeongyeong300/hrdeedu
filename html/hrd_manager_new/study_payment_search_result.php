<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchGubun = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName = Replace_Check($CompanyName); //사업주명
$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$StudyPeriod = Replace_Check($StudyPeriod); //검색 기간
$StudyPeriod2 = Replace_Check($StudyPeriod2); //검색 기간2(사업주검색)
$CompanyCode = Replace_Check($CompanyCode); //사업자 번호
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$pg = Replace_Check($pg); //페이지


##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;


##-- 검색 조건
$where = array();


if($SearchGubun=="A") { //기간 검색 

	if($CompanyCode) {
		$where[] = "a.CompanyCode='".$CompanyCode."'";
	}

	if($LectureStart) {
		$where[] = "a.LectureStart='".$LectureStart."'";
	}

	if($LectureEnd) {
		$where[] = "a.LectureEnd='".$LectureEnd."'";
	}

}

if($SearchGubun=="B") { //사업주  검색 

	if($CompanyName) {
		$where[] = "b.CompanyName LIKE '%".$CompanyName."%'";
	}

	if($LectureStart) {
		$where[] = "a.LectureStart='".$LectureStart."'";
	}

	if($LectureEnd) {
		$where[] = "a.LectureEnd='".$LectureEnd."'";
	}

}

$where[] = "a.ServiceType IN (1,3,5)";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY a.LectureStart ASC, a.LectureEnd ASC";

$Colume = "DISTINCT(a.LectureStart) AS LectureStart, a.LectureEnd 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
					";

$JoinQuery2 = " Study AS a 
						LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
						LEFT OUTER JOIN PaymentSheet AS c ON a.CompanyCode=c.CompanyCode AND a.LectureStart=c.LectureStart AND a.LectureEnd=c.LectureEnd 
					";

$Sql2 = "SELECT COUNT(DISTINCT(a.LectureStart), a.LectureEnd) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];
//echo $TOT_NO."<br>";

##-- 페이지 클래스 생성
$PageFun = "StudyPaymentSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>수강기간</th>
		<th>교육비</th>
		<th>최종 환급액</th>
		<th>수강인원</th>
		<th>환급과정 교육비</th>
		<th>자부담금</th>
		<th>통장 입금액</th>
		<th>카드 결제금액</th>
		<th>상태 및 상태 변경</th>
		<th>메모 (결제 관련 특이사항 및 환불 관련 정보를 입력하세요.)</th>
	</tr>
	<?
	$k = 0;
	$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
	//echo $SQL."<br><br>";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		while($ROW = mysqli_fetch_array($QUERY))
		{
			extract($ROW);
	
			//첨삭완료일
			$Tutor_limit_day = strtotime("$LectureEnd +4 days");

	?>
	<tr>
		<td  height="28"><?=$PAGE_UNCOUNT--?></td>
		<td ><strong><?=$LectureStart?> ~ <?=$LectureEnd?></strong></td>
		<td  colspan="2">첨삭완료 : <?=date("Y-m-d", $Tutor_limit_day)?> 까지</td>
		<td  colspan="7">&nbsp;</td>
	</tr>
	<?
		if($SearchGubun=="B") {
			$where2 = " AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd'";
		}
		

		$SQL2 = "SELECT DISTINCT(a.CompanyCode), b.CompanyName, c.BankPrice, c.CardPrice, c.PayStatus, c.PaymentRemark, c.PayMethod, c.MOID, c.PayDate, c.CancelDate, 
					(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5)) AS TotalPrice, 
					(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5)) AS TotalRPrice, 
					(SELECT SUM(rPrice2) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS rPrice2Sum, 
					(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS TotalPrice2, 
					(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS TotalRPrice2, 
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS StudyCount, 
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5)) AS StudyBeCount 
					FROM $JoinQuery2 $where $where2 ORDER BY b.CompanyName ASC";
		//echo $SQL2."<br><br>";
		$QUERY2 = mysqli_query($connect, $SQL2);
		if($QUERY2 && mysqli_num_rows($QUERY2))
		{
			while($ROW2 = mysqli_fetch_array($QUERY2))
			{

				$TotalPrice = $ROW2['TotalPrice']; //전체 교육비
				$TotalRPrice = $ROW2['TotalRPrice']; //전체 환급액
				$TotalPrice2 = $ROW2['TotalPrice2']; //환급과정 교육비
				$TotalRPrice2 = $ROW2['TotalRPrice2']; //환급과정 환급액
				$rPrice2Sum = $ROW2['rPrice2Sum']; //자부담금 합계
				$CompanyCode = $ROW2['CompanyCode'];
				$StudyCount = $ROW2['StudyCount'];
				$StudyBeCount = $ROW2['StudyBeCount'];
				$BankPrice = $ROW2['BankPrice'];
				$CardPrice = $ROW2['CardPrice'];
				$PayStatus = $ROW2['PayStatus'];
				$PaymentRemark = $ROW2['PaymentRemark'];
				$PayMethod = $ROW2['PayMethod'];
				$MOID = $ROW2['MOID'];
				$PayDate = $ROW2['PayDate'];
				$CancelDate = $ROW2['CancelDate'];

				if(!$BankPrice) {
					$BankPrice = 0;
				}else{
					$BankPrice = $BankPrice;
				}
				if($CardPrice=="") {
					$CardPrice = $rPrice2Sum;
					//$CardPrice = 0;
				}else{
					$CardPrice = $CardPrice;
				}

				if($PayStatus=="R" || $PayStatus=="Y") {
					$price_readOnly = 'readonly';
					$price_readOnly_color = 'background-color:#eeeeee';
				}else{
					$price_readOnly = '';
					$price_readOnly_color = '';
				}

				$Sql2_s = "SELECT COUNT(Seq) FROM Study WHERE LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND CompanyCode='$CompanyCode' AND ServiceType IN (1,3,5) AND StudyEnd='N'";
				//echo $Sql2_s;
				$Result2_s = mysqli_query($connect, $Sql2_s);
				$Row2_s = mysqli_fetch_array($Result2_s);
				$StudyEndNoCount = $Row2_s[0];

	?>
	<tr>
		<td >&nbsp;</td>
		<td ><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$ROW2['CompanyName']?><br><br><?=$CompanyCode?></a></td>
		<td ><?=number_format($TotalPrice,0)?></td>
		<td ><?if($StudyEndNoCount<1) {?><?=number_format($TotalRPrice,0)?><?}else{?>진행중<?}?></td>
		<td >
		환급 : <?=$StudyCount?><br />
		비환급 : <?=$StudyBeCount?></td>
		<td ><?=number_format($TotalRPrice2,0)?></td>
		<td ><?=number_format($rPrice2Sum,0)?></td>
		<td >
		<input type="hidden" name="BasicPrice" id="BasicPrice" value="<?=$rPrice2Sum?>">
		<input type="text" name="BankPrice" id="BankPrice" value="<?=$BankPrice?>" style="text-align:right; height:25px; <?=$price_readOnly_color?>" onkeyup="PriceAutoCal(1,<?=$k?>)" <?=$price_readOnly?>></td>
		<td >
		<input type="text" name="CardPrice" id="CardPrice" value="<?=$CardPrice?>" style="text-align:right; height:25px; <?=$price_readOnly_color?>" onkeyup="PriceAutoCal(2,<?=$k?>)" <?=$price_readOnly?>></td>
		<td >
		<?
		if($PayStatus=='' || $PayStatus=='N') { //결제관련 등록된 사항이 없거나 금액만 저장한 경우
		?>
		<p><button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PaymentSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">금액 저장</button></p>
		<p><button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PayStatusSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 요청</button></p>
		<p><button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PayStatusComplete(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 완료</button></p>
		<?
		}
		?>
		<?
		if($PayStatus=='R') { //결제요청시
		?>
		<span class='fcOrg01B'>[결제 요청중]</span><br>
		<button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PayStatusCancelSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 요청 취소</button>
		<?
		}
		?>
		<?
		if($PayStatus=='Y') { //결제완료시
		?>
		<span class='fcOrg01B'>결제일 : <?=$PayDate?></span><br><span class='fcOrg01B'>주문번호 : <?=$MOID?></span>
		<?
		}
		?>
		</td>
		<td >
		<?
		if($PayStatus=='Y') { //결제완료시
		?>
		<p>
			<button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px; width:100px" onclick="PaymentCancelSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 취소(환불)</button>
			&nbsp;&nbsp;&nbsp;&nbsp;취소(환불) 사유를 저장후 취소 처리하세요.
		</p>
		<p>
			<textarea name="PaymentRemark" id="PaymentRemark" style="width:260px; height:60px"><?=$PaymentRemark?></textarea>
			<button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:60px" onclick="PaymentRemarkSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">메모저장</button>
		</p>
		<?
		}else{
		?>
		<textarea name="PaymentRemark" id="PaymentRemark" style="width:260px; height:60px"><?=$PaymentRemark?></textarea>
		<button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:60px" onclick="PaymentRemarkSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">메모저장</button>
		<?
		}
		?>
		</td>
	</tr>
	<?
			$k++;
			}
		}



		}
	}else{
	?>
	<tr>
		<td height="28"  colspan="20">검색된 내용이 없습니다.</td>
	</tr>
	<? } ?>
</table>

<!--페이지 버튼-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:15px;">
  <tr>
	<td align="center" valign="top"><?=$BLOCK_LIST?></td>
  </tr>
</table>
<?
mysqli_close($connect);
?>