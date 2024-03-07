<?
$HTML_TITLE = "정보입력 > 회원가입 > ";
include "../include/include_top.php";

//로그인 여부 체크
include "../include/login_not_check.php";
?>
        
        <!-- Container -->
        <div id="container">
        
        	<!-- page Title -->
        	<div class="titleZoneFull">
            	<!-- title -->
                <div class="titleZone">
                	<h2>회원가입</h2>
        		</div>
                <!-- title // -->
        	</div>
        	<!-- page Title // -->
        	
			<!-- Content -->
            <div class="Content">
                
                <!-- content area -->
                <div class="contentMax">
                    
                    <!-- info area -->
                    <div class="conInfoMax">
                    	<!-- area -->
                        <?
						$ACS = Replace_Check($ACS);
						$Marketing = Replace_Check($Marketing);
						$Name = Replace_Check($Name);
						$BirthDay = Replace_Check($BirthDay);
						$Gender = Replace_Check($Gender);
						$Mobile = Replace_Check($Mobile);

						if($Mobile) {
							$Mobile_Arrary = explode("-",$Mobile);
							$Mobile01 = $Mobile_Arrary[0];
							$Mobile02 = $Mobile_Arrary[1];
							$Mobile03 = $Mobile_Arrary[2];
						}
						?>
						<form name="JoinForm" method="POST" action="join_ok.php" target="ScriptFrame">
						<input type="hidden" name="ACS" id="ACS" value="<?=$ACS?>">
						<input type="hidden" name="Marketing" id="Marketing" value="<?=$Marketing?>">
						<input type="hidden" name="CompanyCode" id="CompanyCode" value="">
						<input type="hidden" name="Etc01" id="Etc01">
						<input type="hidden" name="Etc02" id="Etc02">
                        <!-- input -->                        
                        <h3>회원가입 정보</h3>
                  		<div class="join_input">
                            <table cellpadding="0">
                              <caption>회원정보 입력</caption>
                              <colgroup>
                                  <col class="wid180" />
                                  <col class="" />
                              </colgroup>
                              <tr>
                                <th><label for="Name">이름</label></th>
                                <td><input type="text" name="Name" id="Name" class="wid310" value="<?=$Name?>" /></td>
                              </tr>
                              <tr>
                                <th><label for="Mobile01">휴대전화</label></th>
                                <td><input type="text" name="Mobile01" id="Mobile01" class="wid80" value="<?=$Mobile01?>" maxlength="3" />
                                    -
                                    <input type="text" name="Mobile02" id="Mobile02" class="wid100" value="<?=$Mobile02?>" maxlength="4" />
                                    -
                                <input type="text" name="Mobile03" id="Mobile03" class="wid100" value="<?=$Mobile03?>" maxlength="4" /></td>
                              </tr>
                              <tr>
                                <th><label for="ID">아이디</label></th>
                                <td><input type="text" name="ID" id="ID" class="wid310"  />
                                	<input type="button" name="btn" value="아이디 중복확인" class="btnInputSm" onclick="Javascript:IDCheck();">
									<div class="mt7 fc777 fs15">※ 영문 소문자, 숫자조합으로 6~20자 / 한글, 특수문자 불가능</div>
									<div id="id_check_msg"><input type="hidden" name="ID_Check" id="ID_Check" value="N"></div>
                                </td>
                              </tr>
                              <tr>
                                <th><label for="Pwd">비밀번호</label></th>
                                <td><input type="password" class="wid310" name="Pwd" id="Pwd" />
                                	<div class="mt7 fc777 fs15">※ 비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.</div>
                                </td>
                              </tr>
                              <tr>
                                <th><label for="Pwd2">비밀번호 확인</label></th>
                                <td><input type="password" class="wid310" name="Pwd2" id="Pwd2" />
                                	<div class="mt7 fc777 fs15">※ 정확한 확인을 위해 비밀번호를 한번 더 입력하세요.</div>
                                </td>
                              </tr>
                              <tr>
                                <th><label for="Email">이메일</label></th>
                                <td><input type="text" class="wid400" name="Email" id="Email" /></td>
                              </tr>
							  <tr>
                                <th><label for="SecurityCode">보안코드 입력</label></th>
                                <td><img src="/include/make_image.php" alt="숫자" align="absmiddle">&nbsp;&nbsp;<input type="text" class="wid200" name="SecurityCode" id="SecurityCode" />&nbsp;&nbsp;&nbsp;<label for="SecurityCode">왼쪽 보안코드를 입력하세요.</label></td>
                              </tr>
                            </table>
                   	  	</div>
						</form>
   		        		<!-- input // -->
                        
                        <!-- btn -->
						<div class="btnAreaTc04" id="SubmitBtn">
                        	<span class="btnSky01"><a href="Javascript:MemberJoin();" class="wid180">가입완료</a></span>
                        </div>

                        <div class="tc" id="WaitMag" style="display:none">
                    	<br><br>처리중입니다. 기다려 주세요...
						</div>


                      <!-- area // -->
                    </div>
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
