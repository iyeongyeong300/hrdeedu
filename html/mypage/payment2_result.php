<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$pay_idx = Replace_Check_XSS2($pay_idx);
$ID = Replace_Check_XSS2($ID);

if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	alert("로그인후에 이용이 가능합니다.");
	self.close();
//-->
</script>
<?
exit;
}

$Sql = "SELECT *, 
			(SELECT Name FROM Member WHERE ID=a.ID) AS Name 
			FROM PaymentSheet2 AS a
			WHERE a.ID='$ID' AND (a.PayStatus='R' OR a.PayStatus='Y') AND a.idx=$pay_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Name = $Row['Name'];
	$CardPrice = $Row['CardPrice'];
	$PayStatus = $Row['PayStatus'];
	$PayDate = $Row['PayDate'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>결제확인서 > <?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style2.css" />
<link rel="stylesheet" href="/css/jquery.bxslider.css?t=20190126" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
</head>

<body>
	
	<div id="wrap">
	
       
        <!-- Content -->
        <div id="ContentPageFull">
        
        	<div class="close"><a href="Javascript:self.close();"><img src="/images/common/btnbul_close02.png" alt="창닫기" /></a></div>
            
            <!-- content area -->
            <div class="conArea">
        	
                <!-- content Info -->
              <div class="coninfoArea">
					<!-- info area -->
                    
              <div class="pageTitle">원격훈련 교육비 결제 확인서</div>
                    
					<div class="panListArea mt30">
                    	<table cellpadding="0" class="table_receiptB">
                    		<caption>원격훈련 교육비 결제 확인서</caption>
                            <colgroup>
								<col width="140px;" />
                                <col width="" />
                            </colgroup>
                            <tr>
                    		  <th>성명</th>
                    		  <td><?=$Name?></td>
                   		    </tr>
                    		<tr>
                    		  <th>결제금액</th>
                    		  <td class="tr">\ <?=number_format($CardPrice,0)?></td>
                   		    </tr>
                            <tr>
                              <th>결제일시</th>
                    		  <td><?=$PayDate?></td>
                   		    </tr>
                   		</table>
		  	    	</div>
                    
                    <div class="panListArea mt10">
                    	<table cellpadding="0" class="table_receiptG">
                    		<caption>원격훈련 교육비 결제 확인서</caption>
                            <colgroup>
							<col width="40px;" />
								<col width="100px;" />
                                <col width="" />
							</colgroup>
                            <tr>
                              <th rowspan="4" style="background:#c5ef9f;">공<br />
                                급<br />
                                자<br />
                                정<br />
                              보</th>
                    		  <th>상 호 명</th>
                    		  <td>EK티처 한국어교사원격평생교육원</td>
                   		    </tr>
                    		<tr>
                    		  <th>대 표 자</th>
                    		  <td>유길상</td>
                   		    </tr>
                            <tr>
                              <th>사업자<br />
                              등록번호</th>
                    		  <td>106-12-83641</td>
                   		    </tr>
                            <tr>
                              <th>주소</th>
                              <td>서울시 금천구 가산디지털1로 219 벽산디지털밸리 6차 303~6호</td>
                            </tr>
                   		</table>
		  	    	</div>
                    
                	<div class="mt5 fs12 fcOrg01" style="line-height:1.4em;">
                    	<p>* 부가가치세법 제26조에 따라 교육비는 면세로 분류됩니다.</p>
                        <p>* 본 확인서는 부가가치세 신고용으로 사용할 수 없습니다.</p>
                  	</div>
                    
                  	<div class="mt30 tc lsn fs18b">EK티처 한국어교사원격평생교육원</div>

				  	<!-- info area // -->
            	</div>
                <!-- content Info // -->
                
			</div>
            <!-- content area // -->

        </div>
        <!-- Content // -->

		
	</div>
	
</body>
</html>
