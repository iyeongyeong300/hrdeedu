<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

$ID = Replace_Check_XSS2($ID);
?>
<!-- layer Ask -->
<div class="layerArea wid550">
	<!-- close -->
	<!-- title -->
	<div class="title">비밀번호 변경</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>최초 로그인시 비밀번호를 변경하여야 합니다.</li>
			</ul>
		</div>
		<form name="FirstPassForm" method="POST" action="/mypage/pass_first_change_ok.php" target="ScriptFrame">
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <caption>비밀번호 변경</caption>
			  <colgroup>
				  <col width="120px" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td class="item"><label for="PwdChange">비밀번호</label></td>
				<td><input type="password" name="PwdChange" id="PwdChange" class="wid300" /></td>
			  </tr>
			  <tr>
				<td class="item"><label for="PwdChange2">비밀번호 확인</label></td>
				<td><input type="password" name="PwdChange2" id="PwdChange2" class="wid300" /></td>
			  </tr>
			</table>
		</div>
		</form>
		
		<!-- btn -->
		<p class="btnAreaTc02" id="SubmitBtn"><span class="btnSmSky01"><a href="Javascript:PassFirstChangeSubmit();">변경하기</a></span></p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Ask // -->