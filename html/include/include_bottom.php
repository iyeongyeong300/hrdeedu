		<div id="Footer">
        	<!-- side -->
            <div class="sideArea">
            	<ul>
                     <li><a href="/group/introduce.php">교육원소개</a></li> 
                     <li><a href="/refund/employinsure.php">고용보험환급 안내</a></li> 
                    <li><a href="/member/agreement.php">이용약관</a></li>
                    <li><a href="/member/privacy.php">개인정보취급방침</a></li>
					 <!-- <li><a href="/support/remote.php">PC원격지원</a></li> -->
                </ul>
        	</div>
            <!-- side // -->
           	<!-- logo copy mark -->
           	<div class="copyArea">
            	<h1><img src="../images/site/footer.png" alt="<?=$SiteName?>" /></h1>
                <!-- copy -->
                <div class="copy">
                    <p class="address"><?=$SiteAddress?><br />
                    	고객상담센터 : <?=$SitePhone?>
						<!--<span class="gap">팩스 : <?=$SiteFax?></span>-->
						<span class="gap">이메일 : <a href="mailto:<?=$SiteEmail?>"><?=$SiteEmail?></a></span>
						<span class="gap">개인정보책임자 : <?=$SitePersonalInformationManager?></span>
						<br />
                      	상호명 : <?=$SiteName?>
						<span class="gap">대표자 : <?=$SiteCeo?></span>
						<span class="gap">사업자 등록번호 : <?=$SiteCompanyNumber?></span>
						<span class="gap">통신판매업신고번호 : <?=$SiteSalesReportNumber?></span>
						<br />
                        <?=$SiteCopyright?><br />
                    	본 사이트 내의 컨텐츠는 저작권법 상의 보호를 받고 있습니다.
                    </p>
            	</div>
                <!-- copy // -->
                <!-- mark -->
                <!-- mark // -->
       	  	</div>
            <!-- logo copy mark // -->
            <div class="topBtn"><a href="Javascript:MoveTop();"><img src="../images/common/btn_top.png" alt="페이지 위로" /></a></div>
         </div>
         <!-- Footer // -->

	</div>

<form name="TimeCheckForm">
	<input type="hidden" name="NowTime" id="NowTime" value="0">
</form>
<!-- jQuery로 데이터 처리를 위한 영역 -->
<div id="SysBg_White" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #FFFFFF;display:none;"></div>
<div id="SysBg_Black" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #000000;display:none;"></div>
<div id="Roading" style="display:none;z-index:100"><BR /><BR /><BR /><BR /><img src="/images/loader.gif" alt="로딩중" /></div>
<div id="DataResult" style="display:none;z-index:10000"></div>
<iframe name="ScriptFrame" border="0" frameborder="0" width="0" height="0" title="데이터 처리를 위한 프레임" style="display:none"></iframe>
<!-- jQuery로 데이터 처리를 위한 영역 -->
<? if(isset($_SESSION['LoginMemberID'])) { ?>
<script type="text/javascript">
<!--
$(document).ready(function() {

	setInterval("LogoutTimeCheck()",1000);
	LogOutTimeView();
	setInterval("LogInCheck()",6000);

});
//-->
</script>
<?}?>
</body>
</html>
<?
// 접속 통계==================================================================
if(empty($_SESSION['Sta'])) {

	$timeinfo = getdate(time());
	$s_year = $timeinfo["year"];
	$s_mon = $timeinfo["mon"];
	$s_day = $timeinfo["mday"];
	$s_hour = $timeinfo["hours"];
	$col_name = "hour_".$s_hour;

	$Sql_s = "SELECT COUNT(*) AS StaNum FROM Sta WHERE s_year=$s_year AND s_mon=$s_mon AND s_day = $s_day";
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);

	if($Row_s['StaNum'] > 0) {
		$Sql_s2 = "UPDATE Sta SET $col_name= $col_name + 1 WHERE s_year = $s_year AND s_mon = $s_mon AND s_day = $s_day";
	}else{
		$Sql_s2 = "INSERT INTO Sta(s_year, s_mon, s_day, $col_name) VALUES($s_year, $s_mon, $s_day, 1)";
	}
	mysqli_query($connect, $Sql_s2);

	$_SESSION["Sta"] = "Y";

}
//==========================================================================

mysqli_close($connect);
?>
