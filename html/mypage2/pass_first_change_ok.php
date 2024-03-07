<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

require_once ('../include/KISA_SHA256.php');

$PwdChange = Replace_Check_XSS2($PwdChange);

$enc_pwd = encrypt_SHA256($PwdChange); //비밀번호 암호화

$Sql = "UPDATE Member SET Pwd='$enc_pwd', PassChange='Y' WHERE ID='$LoginMemberID'";
$Row = mysqli_query($connect, $Sql);

mysqli_close($connect);
?>
<script type="text/javascript">
<!--
	alert("비밀번호가 변경되었습니다.");
	top.location.href="/mypage/lecture.php";
//-->
</script>