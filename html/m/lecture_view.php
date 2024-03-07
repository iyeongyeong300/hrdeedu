<?
include "./include/include_top.php";
?>
<?
include "./login_check.php";


$_SESSION["EndTrigger"] = "N"; //EndTrigger 초기화

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$mode = Replace_Check_XSS2($mode);

$OptInit = Replace_Check_XSS2($OptInit); //OPT 초기화의 경우

$Captcha_need = "N"; //갭차인증 필요여부 초기값
$MobileAuth_need = "N"; //모바일 본인인증 필요여부 초기값

##테스트 아이디 여부 체크 #####################################################################
$TestID = "N";

$Sql = "SELECT * FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$TestID = $Row['TestID'];
}
##테스트 아이디 여부 체크 #####################################################################

## 과정 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Course_idx = $Row['idx']; //과정 고유번호
	$ContentsName = $Row['ContentsName']; //과정명
	$attachFile = $Row['attachFile']; //학습자료
	$Professor = $Row['Professor']; //내용전문가 
	$CompleteTime = $Row['CompleteTime'] * 60; //진도시간 기준 
	$ChapterLimit = $Row['ChapterLimit']; //차시제한 여부
	$IE8Compat = $Row['IE8Compat']; //브라우저 호환성 여부
	$ContentsURLSelectGlobal = $Row['ContentsURLSelect'];

	$ext = substr(strrchr($attachFile,"."),1);
	$attachFileView = "학습자료_".$ContentsName.".".$ext;

}

## 차시 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Contents WHERE idx='$Contents_idx'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$Expl01 = nl2br($Row['Expl01']); //차시 목표
	$Expl02 = nl2br($Row['Expl02']); //훈련 내용
	$Expl03 = nl2br($Row['Expl03']); //학습 활동
	$LectureTime = ceil(($Row['LectureTime'] * 60) / 2); //수강시간

}
## 차시 정보 구하기 ########################################################################

$Sql = "SELECT * FROM Study WHERE LectureCode='$LectureCode' AND Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$ServiceType = $Row['ServiceType'];
	$OpenChapter = $Row['OpenChapter'];
	$LectureTerme_idx = $Row['LectureTerme_idx'];

}

## 최종 수강내역 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND Contents_idx=$Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsDetail_Seq = $Row['ContentsDetail_Seq'];
	$LastStudy = $Row['LastStudy'];
	$Progress = $Row['Progress'];
	$StudyTime = $Row['StudyTime'];

}else{

	$Progress = 0;
	$StudyTime = 0;

}

if($Progress>=100) {
	$_SESSION["EndTrigger"] = "Y";
}

## 최종 수강내역 정보 구하기 ########################################################################

//현재 과정 본인 인증 횟수
$Sql = "SELECT COUNT(*) FROM UserCertOTP WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$MobileAuth_count = $Row[0];

if($MobileAuth_count<1 && ($ServiceType==1 || $ServiceType==4)) { //과정 인증내역이 없으면 본인인증 필요 (과정당 1회만 인증)
	$MobileAuth_need = "Y";
}

//금일 수강한 차시수 ########################################################################

$Sql = "SELECT COUNT(*) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND LEFT(RegDate,10)='".date('Y-m-d')."' AND Contents_idx <> $Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Today_Progress_count = $Row[0];


if($mode=="S") { //신규 수강하기만 적용, 이어보기는 적용하지 하지 않음

	if($ChapterLimit=="Y" && $TestID=="N") {

		if($Today_Progress_count>7) {
		?>
		<script type="text/javascript">
		<!--
		alert("하루 8개 차시까지만 수강이 가능합니다.");
		location.href="lecture.php";
		//-->
		</script>
		<?
		exit;
		}

	}

}

//########################################################################

//캡차 인증여부 체크 ########################################################################
/*
if(empty($_SESSION['CAPTCHA_'.$Study_Seq.$Chapter_Seq])) {

	// 차시가 1, 9, 17... 차시 이거나 오늘 첫 수강이면 캡차 인증 처리
	$Chapter_Sequence  = $Chapter_Number % 8;

	if($ServiceType==1 || $ServiceType==4) {
		if($Today_Progress_count<1 || $Chapter_Sequence==1) {
			$Captcha_need = "Y";
		}
	}

}
*/
//########################################################################


##### 오늘 첫수강, 8차시 단위 인증 추가 (1,9,17...차시) #####
if($ServiceType==1 || $ServiceType==4){	//환급과정 체크
	if(empty($_SESSION['CAPTCHA_'.$Study_Seq.$Chapter_Seq])){	//해당 차시를 인증 안한경우
		
		//오늘 첫수강인지 체크
		$Sql = "SELECT COUNT(*) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND DATE(RegDate)='".date('Y-m-d')."'";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);
		$Today_Progress_count2 = $Row[0];
		if($Today_Progress_count2<1){
			$Captcha_need = "Y";
		}

		//1,9,17...차시인경우
		if($Chapter_Number % 8 == 1){
			//최초 수강인지 체크
			$Sql = "SELECT COUNT(*) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Chapter_Number='$Chapter_Number' AND Study_Seq=$Study_Seq";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$Progress_count = $Row[0];
			
			if($Progress_count<1){
				$Captcha_need = "Y";
			}
		}
	}
}

//##########################

## 회원 정보 구하기 ########################################################################
$Sql = "SELECT *, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID' AND MemberOut='N' AND UseYN='Y'";
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
## 회원 정보 구하기 ########################################################################


## 플레쉬 또는 동영상 정보 구하기 ########################################################################
//하부 컨테츠 수 구하기
$Sql = "SELECT COUNT(*) FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$ContentsDetail_count = $Row[0];

if($mode=="S") { //수강하기의 경우, 처음부터 나오게--------------------------------------------------------------------------------

$Sql = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND UseYN='Y' AND MobileURL <> '' AND (ContentsType='A' OR ContentsType='B') ORDER BY OrderByNum ASC, Seq ASC LIMIT 0,1";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsDetail_Seq = $Row['Seq'];
	$ContentsType = $Row['ContentsType'];
	$ContentsURLSelect = html_quote($Row['ContentsURLSelect']); //주, 예비 선택
	$MobileURL = html_quote($Row['MobileURL']); //모바일 URL
	$MobileURL2 = html_quote($Row['MobileURL2']); //모바일 URL 예비
	$ContentsMobilePage = html_quote($Row['ContentsMobilePage']); //모바일 페이지수

	if($ContentsURLSelect=="A") {
		$PlayPath = $MovieServerURL.$MobileURL;
		$PlayerFunction = "<video id='mPlayer' width='100%' controls autoplay><source src='".$PlayPath."' type='video/mp4'></video>";
	}else{
		$PlayPath = $MobileURL2;
		$PlayerFunction = "<iframe name='mPlayer' id='mPlayer' src='".$PlayPath."' width='100%' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";
	}


}else{
?>
<script type="text/javascript">
<!--
alert("강의 정보에 오류가 발생했습니다.");
location.href="lecture.php";
//-->
</script>
<?
exit;
}

} //수강하기의 경우, 처음부터 나오게--------------------------------------------------------------------------------



## 플레쉬 또는 동영상 정보 구하기 ########################################################################
?>

        <!-- Content -->
        <div id="Content">
        
        	<!-- h2 -->
        	<h2>모바일 학습실</h2>
        
        	<!-- info Area -->
            <div class="contentArea">
        		<!-- content Area -->

				<div class="playZone">

				<input type="hidden" name="Chapter_Number" id="Chapter_Number" value="<?=$Chapter_Number?>">
				<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
				<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
				<input type="hidden" name="Chapter_Seq" id="Chapter_Seq" value="<?=$Chapter_Seq?>">
				<input type="hidden" name="Contents_idx" id="Contents_idx" value="<?=$Contents_idx?>">
				<input type="hidden" name="ContentsDetail_Seq" id="ContentsDetail_Seq" value="<?=$ContentsDetail_Seq?>">
				<input type="hidden" name="CompleteTime" id="CompleteTime" value="<?=$CompleteTime?>">
				<input type='hidden' name='ContentsType' id='ContentsType' value='B'>
				<?if($ContentsDetail_count>1) {?>
				<input type="hidden" name="ContentsURL" id="ContentsURL" value="0">
				<?}else{?>
				<input type="hidden" name="ContentsURL" id="ContentsURL" value="<?=$ContentsURL?>">
				<?}?>
				<input type='hidden' name='mode' id='mode' value='<?=$mode?>'>
                
                	<!-- title -->
                    <div class="titleArea">
                    	<p class="title"><?=$ContentsName?></p>
                    	<p class="subTitle"><?=$Chapter_Number?>. <strong><?=$ContentsTitle?></strong></p>
                	</div>
                    <!-- title -->
                    <?
                    if($MobileAuth_need=="Y" || $Captcha_need=="Y") { //본인인증이 필요한 경우
                        include "./player_cert_motp.php";
                    }
                    else {
                        include "./player_view.php";
                    }

                    /*
                    if($OptInit=="Y") {//OPT 초기화의 경우
                        include "./player_otp_init.php";
                    }else if($MobileAuth_need=="Y") { //본인인증이 필요한 경우
                        include "./player_cert.php";
                    }else if($Captcha_need=="Y") { //OTP 캡차 인증이 필요한 경우
                        include "./player_otp_captcha.php";
                    }else{
                        include "./player_view.php";
                    }
                    */
					?>

                </div>
        		
                <!-- content Area // -->
            </div>
            <!-- info Area // -->

        </div>
        <!-- Content // -->


<?
if($Captcha_need == "N") {
?>
<script type="text/javascript">
<!--
$(window).load(function() {

	StudyProgressCheck('Start','N'); //시작 진도 - Progress(차시진도), Study(수강내역) 모두 업데이트(트리거 통해 이몬에 등록)

	//60초 마다 진도 체크 
	setInterval(function(){
		StudyProgressCheck('Middle','N'); //Progress(차시진도)만 업데이트
	},60000);

	//수강 시간 초단위로 보여주는 부분
	setInterval(function(){
		StudyTimeCheck();
	},1000);

});
//-->
</script>
<?
}
?>

<?
include "./include/include_bottom.php";
?>