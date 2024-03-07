<?
include "../include/include_top.php";
?>
        
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "./include_support.php";
				?>
                <!-- left // -->
                
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3>1:1 문의</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 학습지원센터 > 1:1 문의</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
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
                    <!-- info area -->
					<form name="CounselForm" method="POST" action="/support/ask_ok.php" target="ScriptFrame">
						<input type="hidden" name="Mobile01" id="Mobile01" value="<?=$Mobile01?>">
						<input type="hidden" name="Mobile02" id="Mobile02" value="<?=$Mobile02?>">
						<input type="hidden" name="Mobile03" id="Mobile03" value="<?=$Mobile03?>">
						<input type="hidden" name="Email01" id="Email01" value="<?=$Email01?>">
						<input type="hidden" name="Email02" id="Email02" value="<?=$Email02?>">
                    <div class="conInfoArea">
                    	<!-- area -->

                        <!-- ask -->
                        <div class="panAskArea">
                            <table cellpadding="0" class="pan_ask">
                              <caption>글쓰기</caption>
                              <colgroup>
                                  <col class="wid150" />
                                  <col class="" />
                              </colgroup>
                              <tr>
                                <th><label for="Name">이름</label></th>
                                <td><?if($LoginMemberID) {?><input type="text" name="Name" id="Name" class="wid400" value="<?=$Name?>" /><?}else{?>로그인후에 이용하세요.<?}?></td>
                              </tr>
                              <tr>
                                <th><label for="Category">문의종류</label></th>
                                <td><select name="Category" id="Category"  class="wid400">
                                  <option value="">선택하세요</option>
									<?
									while (list($key,$value)=each($Counsel_array)) {
									?>
								   <option value="<?=$key?>"><?=$value?></option>
									<?
									}
									?>
                                </select></td>
                              </tr>
                              <tr>
                                <th><label for="Title">문의 제목</label></th>
                                <td><input type="text" name="Title" id="Title" class="widp95" /></td>
                              </tr>
							  <tr>
                                <th><label for="SecurityCode">보안코드 입력</label></th>
                                <td><img src="/include/make_image.php" alt="숫자" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="SecurityCode" id="SecurityCode" class="wid100" maxlength="5" />
           	        	  &nbsp;&nbsp;&nbsp;<label for="SecurityCode">왼쪽 보안코드를 입력하세요.</label></td>
                              </tr>
                            </table>
                            <!-- txt write -->
           				  	<div class="conwrite"><textarea name="Contents" id="Contents" class="hei400"></textarea></div>
                            <!-- txt write // -->
                      	</div>    
                  		<!-- ask // -->
                        
                        <!-- btn -->
						<?if($LoginMemberID) {?>
                        <div class="btnAreaTc03" id="SubmitBtn">
                            <span class="btnBlue01"><a href="Javascript:CounselSubmit();">문의</a></span>
                      	</div>
						<div class="btnAreaTc03" id="WaitMag" style="display:">처리중입니다. 기다려 주세요.</div>
						<?}else{?>
						<div class="btnAreaTc03">
                            <span class="btnBlue01"><a href="Javascript:LoginCheck();">문의</a></span>
                      	</div>
						<?}?>
                    
                    	<!-- area // -->
                    </div>
					</form>
                    <!-- info area // -->
                
                </div>
                <!-- content area -->
            
            </div>
            <!-- Content // -->
            
        </div>
        <!-- Container // -->
         
<?
include "../include/include_bottom.php";
?>