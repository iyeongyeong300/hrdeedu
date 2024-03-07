<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

if($LoginMemberID) {

	$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID'";
	//echo $Sql;
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {

		$Name = $Row['Name'];
		$Mobile = $Row['Mobile'];
		$Email = $Row['Email'];

		$Mobile_Array = explode("-",$Mobile);
		$Mobile01 = $Mobile_Array[0];
		$Mobile02 = $Mobile_Array[1];
		$Mobile03 = $Mobile_Array[2];

	}

}
?>
<form name="SimpleAskForm" method="POST" action="/member/simple_ask_ok.php" target="ScriptFrame">
<input type="hidden" name="ID" id="ID" value="<?=$LoginMemberID?>">
<!-- layer Ask -->
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">간편문의</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="info">
			<table cellpadding="0" class="pan_reg">
			  <!--<caption>간편문의</caption>-->
			  <colgroup>
				<col width="18%" />
				<col width="*" />
			  </colgroup>
			  <tr>
				<td><strong><label for="Name">이름</label></strong></td>
				<td><input name="Name" id="Name" type="text" class="wid200" maxlength="20" value="<?=$Name?>" /></td>
			  </tr>
			  <tr>
				<td><strong><label for="Phone01">전화번호</label></strong></td>
				<td><input type="text" name="Phone01" id="Phone01" class="wid100" maxlength="3" value="<?=$Mobile01?>" />
				  -
				  <input type="text" name="Phone02" id="Phone02" class="wid100" maxlength="4" value="<?=$Mobile02?>" />
				  -
				  <input type="text" name="Phone03" id="Phone03" class="wid100" maxlength="4" value="<?=$Mobile03?>" /></td>
			  </tr>
			  <tr>
				<td><strong><label for="Email">이메일</label></strong></td>
				<td><input type="text" name="Email" id="Email" class="wid330" maxlength="50" value="<?=$Email?>" /></td>
			  </tr>
			  <tr>
				<td colspan="2"><textarea rows="8" name="Contents" id="Contents" class="widp100" placeholder="내용을 입력하세요."></textarea></td>
			  </tr>
			  <tr>
				<td colspan="2"><span class="inpCheck">
				  <input type="checkbox" name="privacy" id="privacy">
				  <label for="privacy">개인정보수집방침에 동의합니다.</label></span>
				  <span class="btnSmLine02 ml10"><a href="#" target="_blank" title="새창으로 열림">내용보기</a></span>
				</td>
			  </tr>
			  <tr>
				<td><strong>보안코드</strong></td>
				<td><img src="/include/make_image.php" alt="숫자" align="absmiddle">
				  <input type="text" name="SecurityCode" id="SecurityCode" class="wid100" />
				  <span class="fs13 fc777 ml10"><label for="SecurityCode">왼쪽의 보안코드를 입력하세요.</label></span></td>
			  </tr>
			</table>
	  </div>
		<!-- btn -->
		<p class="btnAreaTc02"><span class="btnSmSky01"><a href="Javascript:SimpleAskSubmit();">확인</a></span></p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Ask // -->
</form>