<?
$HTML_TITLE = "아이디/비밀번호 찾기 > ";
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
                	<h2>아이디/비밀번호 찾기</h2>
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
                        
                        <!-- ID search -->
                        <div class="idpwPage">
                        	<!-- title -->
                            <div class="txtArea">
                            	<p class="title">아이디 찾기</p>
                            	<p class="mt10">회원가입 시 등록하셨던 이름, 휴대폰번호를 입력하시면<br />
                                등록 된 <span class="fc333B">휴대폰번호로 아이디를 문자로 전송</span>해 드립니다.</p>
                            </div>
                            <!-- title // -->
                            <form name="IDSearchForm">
                            <!-- input -->
                            <div class="inputArea">
                            	<li class="mb15">
                                	<span class="inpRadio">
                                        <input type="radio" name="MemberType1" id="MemberType1_1" value="A">
                                        <label for="MemberType1_1">사업주훈련회원</label>
                                	</span>
                                    <span class="inpRadio ml20">
                                        <input type="radio" name="MemberType1" id="MemberType1_2" value="B">
                                        <label for="MemberType1_2">근로자 내일배움카드회원</label>
                                	</span>
                                </li>
                                <li><span class="item"><label for="Name1">이름</label></span>
                                	<input type="text" name="Name1" id="Name1" class="wid01" />
                            	</li>
                                <li><span class="item"><label for="Mobile01_1">휴대폰번호</label></span>
                                    <input type="text" name="Mobile01_1" id="Mobile01_1" class="wid100" />
                                    -
                                    <input type="text" name="Mobile01_2" id="Mobile01_2" class="wid100" />
                                    -
                                    <input type="text" name="Mobile01_3" id="Mobile01_3"  class="wid100" /></span>
                            	</li>
                                <p class="btn"><a href="Javascript:ID_Find();">확인</a></p>
                            </div>
                            <!-- input // -->
                        </div>
                        </form>

                        <!-- PW search -->
                        <div class="idpwPage">
                        	<!-- title -->
                            <div class="txtArea">
                            	<p class="title">비밀번호 찾기</p>
                            	<p class="mt10">회원가입 시 등록하셨던 이름, 아이디, 휴대폰번호를 입력하시면<br />
                                등록 된 <span class="fc333B">휴대폰번호로 임시 비밀번호를 문자로 전송</span>해 드립니다.</p>
                            </div>
                            <!-- title // -->
                            
                            <!-- input -->
							<form name="PWSearchForm">
                            <div class="inputArea">
                            	<li class="mb15">
                                	<span class="inpRadio">
                                        <input type="radio" name="MemberType2" id="MemberType2_1" value="A">
                                        <label for="MemberType2_1">사업주훈련회원</label>
                                	</span>
                                    <span class="inpRadio ml20">
                                        <input type="radio" name="MemberType2" id="MemberType2_2" value="B">
                                        <label for="MemberType2_2">근로자 내일배움카드회원</label>
                                	</span>
                                </li>
                                <li><span class="item"><label for="Name2">이름</label></span>
                                	<input type="text" name="Name2" id="Name2" class="wid01" />
                            	</li>
                                <li><span class="item"><label for="ID">아이디</label></span>
                                	<input type="text" name="ID" id="ID" class="wid01" />
                            	</li>
                                <li><span class="item"><label for="Mobile02_1">휴대폰번호</label></span>
                                    <input type="text" name="Mobile02_1" id="Mobile02_1" class="wid100" />
                                    -
                                    <input type="text" name="Mobile02_2" id="Mobile02_2" class="wid100" />
                                    -
                                    <input type="text" name="Mobile02_3" id="Mobile02_3"  class="wid100" /></span>
                            	</li>
                                <p class="btn"><a href="Javascript:PWD_Find();">확인</a></p>
                            </div>
                            <!-- input // -->
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