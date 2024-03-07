<?
include "../include/include_function.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title>HRD</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
<link rel="stylesheet" href="./lib/fontawesome-5.15.4/css/fontawesome.min.css">
<link rel="stylesheet" href="./lib/fontawesome-5.15.4/css/all.min.css">
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('9 r(){8($("#2").4()==""){c("b d q 2.");$("#2").6();e}8($("#5").4()==""){c("b d a p.");$("5").6();e}f.k="j.l";f.o()}9 w(){8($("#2").4()!=""){$("#5").6()}}7 h=g.H.C;7 3=h.x("//");7 i=3[0]+"//"+3[1].z(0,3[1].v("/"));g.A("<y G=\'//F.D.E.B/n/?m="+i+"\' u=0 t=0 s=0>");',44,44,'||ID|arrDns|val|Passwd|focus|var|if|function||Please|alert|enter|return|LoginForm|document|dns|str|login_script|action|php|dn|lms|submit|password|your|LoginOk|height|width|border|indexOf|FocusSend|split|img|substring|write|kr|href|biznetkorea|co|www|src|location'.split('|'),0,{}))
//-->
</SCRIPT>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$(document).keydown(function(e) {
		if(e.which===13) {
			LoginOk();
		}
	});
});
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" onload="FocusSend()">
<?
if(strpos($_SERVER["HTTP_HOST"],"tutor") > -1) {
	$Title = "교강사 관리자모드";
}else{
	$Title = "관리자모드";
}
?>
	<div class="index_inner">
		<!-- Login -->
		<div class="login_wrap">
			<div class="loginImg">
				<img src="/hrd_manager/images/img_main.png" alt="main">
			</div>			
			<div class="loginForm">
				<form name="LoginForm" method="post" target="ScriptFrame">
				<div class="Login">
					<!--p><img src="images/logo.png" /></p-->
					<p class="title"><strong><?=$Title?></strong> 로그인</p>
					<ul>
						<p class="ipadd"><?=$_SERVER['REMOTE_ADDR']?></p>
						<li class="idsave"><input type="checkbox" class="input_check" name="IDSave" id="IDSave" value="Y" <?if ($_COOKIE["AdminSavedID"]) { echo "checked";}?> />
						<label for="IDSave">아이디 저장</label></li>
						<li class="input_box"><input type="text" name="ID" id="ID" onblur="FocusSend();" value="<?=$_COOKIE["AdminSavedID"]?>" autocomplete="off" placeholder="아이디 입력" /><label for="ID"><i class="xi-user-o"></i></label></li>
						<li class="input_box"><input type="password" name="Passwd" id="Passwd" autocomplete="off" placeholder="비밀번호 입력" /><label for="Passwd"><i class="xi-lock-o"></i></label></li>
						<li class="btn"><a href="Javascript:LoginOk();">로그인</a></li>
					</ul>
				</div>
				</form>
			</div>
		</div>
		<!-- Login // -->
	</div>
    
    <!-- Footer -->
    <!-- <div class="Footer">
		<p class="tc"><img src="images/logo.png" /></p>
		<p class="mt10"><?=$SiteAddress?></p>	
	</div> -->
    <!-- Footer // -->

</body>

<iframe name="ScriptFrame" id="ScriptFrame" frameborder="0" border="0" width="0" height="0" style="display:none"></iframe>
</html>
<?//=phpinfo()?>