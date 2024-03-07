

<?
$HTML_TITLE = "로그인 > ";
include "../include/include_top.php";

//로그인 여부 체크
include "../include/login_not_check.php";
?> 
        <!-- Container -->
        <div id="container">

		<!-- Visual -->
		<div id="logVisual">
			<ul class="visual">
				<div class="slider1" id="slider1">
					<ul class="bxslider">
						<li style="background:url(../images/sub/visual03_back.png) no-repeat center; "><img src="/images/sub/visual03.jpg" alt="미래 지식기반 사회의 선두주자를 양성하는 교육기관 - 지식기반 사회의 기틀을 마련하기 위해 노력하는 교육기관이 될 수 있도록 최선을 다하겠습니다." /></li>
					</ul>
				</div>
			</ul>
		</div>
        <!-- Visual // -->

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
                        <form name="LoginForm" target="ScriptFrame" autocomplete="off">
						<input type="hidden" name="MemberType">
                        <div class="loginPage">
                       	  	<!-- <p class="imgArea"><img src="/images/sub/login_img01.png" alt="로그인" /></p> -->
                            
                            <!-- login -->
                            <ul class="inputArea"">
                       	    	<li class="idSave">
                                	<span class="inpRadio">
                                        <input type="radio" name="MemberType1" id="MemberType1" value="A" checked>
                                        <label for="MemberType1">사업주훈련회원</label>
                                	</span>
                                    <span class="inpRadio ml20">
                                        <input type="radio" name="MemberType1" id="MemberType2" value="B">
                                        <label for="MemberType2">근로자 내일배움카드회원</label>
                                	</span>
								</li>
                                <li><input type="text" name="ID" id="ID1" placeholder="아이디 입력" value="<?if (isset($_COOKIE["MemberSavedID"])) { echo $_COOKIE["MemberSavedID"];}?>" /></li>
                                <li><input type="password" name="Pwd" id="Pwd1" placeholder="비밀번호 입력" /></li>
                                <p class="btn"><a href="Javascript:LoginSubmit();">로그인</a></p>
                            </ul>
                            <!-- login //-->
                            
                            <!-- btn -->
                            <ul class="btnArea">
                                <li><a href="/member/join_step01.php">회원가입</a></li>
                                <li><a href="/member/idpw.php">아이디/비밀번호 찾기</a></li>
                                <li><a href="Javascript:SleepAccountRecovery();">휴면계정 복구</a></li>
                                <li><a href="Javascript:SimpleAsk();">간편문의</a></li>
                            </ul>
                            <!-- btn // -->
                        </div>
                        </form>
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
