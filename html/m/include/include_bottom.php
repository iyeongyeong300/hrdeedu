        <!-- Footer -->
		<div id="Footer">
        	<!-- phone -->
            <div class="phone">
            	<a href="TEL:<?=$SitePhone?>">고객상담센터 <strong><?=$SitePhone?></strong></a>
            	<!-- top btn -->
            	<div class="btnTop"><a href="Javascript:TopMove();"><img src="images/common/btn_top.png" alt="페이지 위로"></a></div>
                <!-- top btn // -->
            </div>
            
			<!-- btn -->
            <!-- <div class="btnSide">
                <span><a href="#" target="_blank" title="새창으로 열림">PC버전</a></span>
          	</div> -->
            
        	<!-- copy area -->
            <div class="copyArea">
            	<p class="address"><?=$SiteAddress?><br>
                <!--팩스 : <?=$SiteFax?><br>-->
                이메일 : <?=$SiteEmail?><span class="gap">개인정보책임자 : <?=$SitePersonalInformationManager?></span><br>
                상호명 : <?=$SiteName?><span class="gap">대표자 : <?=$SiteCeo?></span><br>
                사업자 등록번호 : <?=$SiteCompanyNumber?><br>
                통신판매업신고번호 : <?=$SiteSalesReportNumber?><br>
                <?=$SiteCopyright?><br>
                본 사이트 내의 컨텐츠는 저작권법 상의 보호를 받고 있습니다.</p>
			</div>
			<!-- copy area // -->
		</div>
		<!-- Footer // -->
        
        <!-- Sitemenu -->
        <div class="sitemenuArea" id="AllMenu" style="display:none;">
        	<div class="logMy">
				<?
				//if($_SESSION['LoginTestID']=="Y") {
					if(empty($_SESSION['LoginMemberID'])) {
				?>
            	<span><a href="index.php">로그인</a></span>
				<?
					}else{
				?>
				<span><a href="logout.php">로그아웃</a></span>
				<?
					}
				//}
				?>
          	</div>
        	<ul>
                <li><a href="lecture.php"><span class="margin">모바일 학습실</span></a></li>
                <li><a href="notice.php"><span class="margin">공지사항</span></a></li>
                <li><a href="ask.php"><span class="margin">1:1문의</span></a></li>
            </ul>
        </div>
        <!-- Sitemenu // -->
		
	</div>

<?
if(isset($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
$(window).load(function() {

	setInterval("LogInCheck()",60000);

});
//-->
</script>
<?
}
?>
<!-- jQuery로 데이터 처리를 위한 영역 -->
<div id="SysBg_White" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #FFFFFF;display:none;"></div>
<div id="SysBg_Black" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #000000;display:none;"></div>
<div id="Roading" style="display:none;z-index:100"><BR /><BR /><BR /><BR /><img src="./images/loader.gif" alt="로딩중" /></div>
<div id="DataResult" style="display:none"></div>
<iframe name="ScriptFrame" border="0" frameborder="0" width="0" height="0" title="데이터 처리를 위한 프레임" style="display:none"></iframe>
<!-- jQuery로 데이터 처리를 위한 영역 -->

</body>
</html>