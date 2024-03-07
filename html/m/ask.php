<?
include "./include/include_top.php";
?>


        <!-- Content -->
        <div id="Content">
        
        	<!-- h2 -->
        	<h2>1:1문의</h2>
        
        	<!-- info Area -->
            <div class="contentArea">
        		<!-- content Area -->
                
                <div class="">
<?
if(isset($_SESSION['LoginMemberID'])) { //현재 로그인 중이면 회원정보 불러오기

	$Sql = "SELECT Name, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID' AND MemberOut='N' AND UseYN='Y'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Name = $Row['Name']; //이름
		$Email = $Row['Email']; //이메일
		$Mobile = $Row['Mobile']; //휴대폰
		$Email_Array = explode("@",$Email);
		$Email01 = $Email_Array[0];
		$Email02 = $Email_Array[1];
		$Mobile_Array = explode("-",$Mobile);
		$Mobile01 = $Mobile_Array[0];
		$Mobile02 = $Mobile_Array[1];
		$Mobile03 = $Mobile_Array[2];
	}

}
?>
                    <!-- ask -->
					<form name="CounselForm" method="POST" action="./ask_ok.php" target="ScriptFrame">
						<input type="hidden" name="Mobile01" id="Mobile01" value="<?=$Mobile01?>">
						<input type="hidden" name="Mobile02" id="Mobile02" value="<?=$Mobile02?>">
						<input type="hidden" name="Mobile03" id="Mobile03" value="<?=$Mobile03?>">
						<input type="hidden" name="Email01" id="Email01" value="<?=$Email01?>">
						<input type="hidden" name="Email02" id="Email02" value="<?=$Email02?>">
                	<div class="panAskArea">
               			<table cellpadding="0" class="pan_ask" style="border-top:none;">
               			  <caption>글쓰기</caption>
               			  <colgroup>
               			    <col class="wid80" />
               			    <col class="" />
               			  </colgroup>
               			  <tr>
               			    <th>이름</th>
               			    <td><?if($LoginMemberID) {?><?=$Name?><input type="hidden" name="Name" id="Name" value="<?=$Name?>" /><?}else{?>로그인후에 이용하세요.<?}?></td>
               			  </tr>
                          <tr>
               			    <th><label for="Category">문의종류</label></th>
               			    <td>
							<select name="Category" id="Category"  class="widp95">
                                  <option value="">선택하세요</option>
									<?
									while (list($key,$value)=each($Counsel_array)) {
									?>
								   <option value="<?=$key?>"><?=$value?></option>
									<?
									}
									?>
                                </select>
								</td>
               			  </tr>
               			  
               			  <tr>
               			    <th><label for="Title">문의 제목</label></th>
               			    <td><input type="text" name="Title" id="Title" class="widp95" /></td>
               			  </tr>
						  <tr>
               			    <th><label for="SecurityCode">보안코드</label></th>
               			    <td><img src="./include/make_image.php" alt="숫자" align="absmiddle">&nbsp;&nbsp;<input type="text" name="SecurityCode" id="SecurityCode" class="wid100" />&nbsp;&nbsp;<label for="SecurityCode">왼쪽 보안코드를 입력하세요.</label></td>
               			  </tr>
               			</table>
                            
               			<!-- txt write -->
               			<div class="conwrite"><textarea name="Contents" id="Contents" class="hei200"></textarea></div>
               			<!-- txt write // -->	
                	</div>
                	<!-- ask // -->
                    
                    <!-- btn -->
					<?
					if(isset($_SESSION['LoginMemberID'])) { 
					?>
                    <div class="btnAreaTc02">
                    	<span class="btnBlue01"><a href="Javascript:CounselSubmit();">문의</a></span>
                    </div>
					<?
					}else{
					?>
					<br><center>로그인후에 이용하세요.</center>
					<?
					}
					?>
                    <!-- btn // -->

                </div>
                
                <!-- content Area // -->
            </div>
			</form>
            <!-- info Area // -->

        </div>
        <!-- Content // -->
         
<?
include "./include/include_bottom.php";
?>