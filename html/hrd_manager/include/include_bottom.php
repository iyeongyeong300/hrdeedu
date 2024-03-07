    <div class="Footer">
    	<p class="tc"><a href="main.php"><img src="images/logo.png" /></a></p>
   	  	<p class="mt10"><?=$SiteAddress?></p>
    </div>
    <!-- Footer // -->

</div>

 <form name="TimeCheckForm">
	<input type="hidden" name="NowTime" id="NowTime" value="0">
</form>
<div id="SysBg_White" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #FFFFFF;display:none;"></div>
<div id="SysBg_Black" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #000000;display:none;"></div>
<div id="SysBg_Black_Click" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #000000;display:none;" onclick="DataResultClose()"></div>
<div id="Roading" style="display:none;z-index:100"><BR /><BR /><BR /><BR /><img src="/images/loader.gif" alt="로딩중" /></div>
<div id="DataResult" style="border-top: #a2a2a2 1px solid; border-right: #a2a2a2 1px solid; border-bottom: #a2a2a2 1px solid; border-left: #a2a2a2 1px solid; padding-top: 15px; padding-right: 15px; padding-bottom: 15px; padding-left: 15px; background:#fff; display:none"></div>
<div id="DataResult2" style="border-top: #a2a2a2 1px solid; border-right: #a2a2a2 1px solid; border-bottom: #a2a2a2 1px solid; border-left: #a2a2a2 1px solid; padding-top: 15px; padding-right: 15px; padding-bottom: 15px; padding-left: 15px; background:#fff; display:none"></div>
<iframe name="ScriptFrame" id="ScriptFrame" frameborder="0" border="0" width="0" height="0" style="display:none"></iframe>
<SCRIPT LANGUAGE="JavaScript">
<!--
function TimeCheck() {

	if(TimeCheckNo!="N") {

		if($("#NowTime").val()==7200) {
			location.href="logout.php";
		}else{
			$("#NowTime").val(parseInt($("#NowTime").val())+1);
			LogOutTimeView();
		}

	}

}

function send_LogOut() {
	location.href="logout.php";
}

setInterval("TimeCheck()",1000);
LogOutTimeView();
//-->
</SCRIPT>
</body>
</html>
<?
mysqli_close($connect);
?>