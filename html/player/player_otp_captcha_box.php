<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$mode = Replace_Check_XSS2($mode);
?>
<div class="layerArea wid900">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">OTP 인증</div>
	<!-- info -->
	<div class="infoArea" style="text-align:center">
		<!-- area -->
		<iframe name='OptCert' id='OptCert' width='870' height='510' src='/player/player_otp_captcha.php?Chapter_Number=<?=$Chapter_Number?>&LectureCode=<?=$LectureCode?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$Chapter_Seq?>&Contents_idx=<?=$Contents_idx?>&mode=<?=$mode?>' border='2' frameborder='2' scrolling="no"></iframe>
	</div>
	<!-- info // -->
</div>
<!-- layer 본인인증 // -->
<?
mysqli_close($connect);
?>