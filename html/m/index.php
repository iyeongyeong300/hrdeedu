<?
include "./include/include_top.php";
?>
<?
if(isset($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	location.href="lecture.php";
//-->
</script>
<?
}
?>

        <!-- Content -->
        <div id="Content">
        
        	<!-- h2 -->
        	<h2>로그인</h2>
        
        	<!-- info Area -->
			<form name="LoginForm" method="POST" action="login_ok.php" target="ScriptFrame">
            <div class="contentArea">
        		<!-- content Area -->

                <!-- input -->
                <div class="loginPage">
                	<p><img src="images/sub/login_img01.png" alt="로그인"></p>
                    <p class="selCheck">
                    	<label><input type="radio"  name="MemberType" id="MemberType1" value="A" />
                	 	사업주훈련회원</label>
                     	<span class="ml10"><label><input type="radio" name="MemberType" id="MemberType2" value="B" />
                	 	근로자 내일배움카드회원</label></span>
                    </p>
                	<p><input type="text" name="ID" id="ID" value="<?if (isset($_COOKIE["MemberSavedID"])) { echo $_COOKIE["MemberSavedID"];}?>" placeholder="아이디 입력" /></p>
                    <p><input type="password" name="Pwd" id="Pwd" placeholder="비밀번호 입력" /></p>
                    <p class="btn"><a href="Javascript:LoginSubmit();">로그인</a></p>
                </div>
                <!-- input // -->
                
                <!-- comment -->
                <div class="comment_1 mt30">
                	<ul>
                    	<li style="text-align:center;">회원가입 및 아이디/비밀번호 찾기는<br>PC에서 이용가능합니다.</li>
                    </ul>
                </div>
                <!-- comment // -->
        		
                <!-- content Area // -->
            </div>
			</form>
            <!-- info Area // -->

        </div>
        <!-- Content // -->
         
<?
include "./include/include_bottom.php";
?>
