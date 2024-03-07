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
			  <caption></caption>
			  <colgroup>
				  <col width="120px" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td class="item vt"><label for="PwdChange">비밀번호</label></td>
				<td>
					<input type="password" name="PwdChange" id="PwdChange" class="wid300" />
					<div class="fs12">※ 비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.</div>
				</td>
			  </tr>  
			  <tr>
				<td class="item vt"><label for="PwdChange2">비밀번호 확인</label></td>
				<td>
					<input type="password" name="PwdChange2" id="PwdChange2" class="wid300" />
					<div class="fs12">※ 정확한 확인을 위해 비밀번호를 한번 더 입력하세요.</div>
				</td>
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