<?
header("content-type:text/html; charset=utf-8");
@extract($_POST);
@extract($_GET);

//ini_set('session.cache_limiter' ,'nocache, must-revalidate-revalidate');
//서브 도메인간에 세션 공유

$ServerDomain = $_SERVER['SERVER_NAME'];
$ServerDomain_array = explode(".",$ServerDomain);
$ServerDomain_Host = $ServerDomain_array[0];
$ServerDomain_length = strlen($ServerDomain);
$ServerDomain_Host_length = strlen($ServerDomain_Host);

$BasicServerDomain = substr($ServerDomain, $ServerDomain_Host_length, $ServerDomain_length);

session_set_cookie_params( 0, "/", $BasicServerDomain);
ini_set('session.cookie_domain', $BasicServerDomain); 

// 본인인증 또는 쇼핑몰 사용시에만 secure; SameSite=None 로 설정합니다.
// Chrome 80 버전부터 아래 이슈 대응
// https://developers-kr.googleblog.com/2020/01/developers-get-ready-for-new.html?fbclid=IwAR0wnJFGd6Fg9_WIbQPK3_FxSSpFLqDCr9bjicXdzy--CCLJhJgC9pJe5ss
if(!function_exists('session_start_samesite')) {
    function session_start_samesite($options = array())
    {
        $res = @session_start($options);

        // IE 브라우저 또는 엣지브라우저 일때는 secure; SameSite=None 을 설정하지 않습니다.
        if( preg_match('/Edge/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(; Touch)?; rv:11.0~',$_SERVER['HTTP_USER_AGENT']) ){
            return $res;
        }

        $headers = headers_list();
        krsort($headers);
        foreach ($headers as $header) {
            if (!preg_match('~^Set-Cookie: PHPSESSID=~', $header)) continue;
            $header = preg_replace('~; secure(; HttpOnly)?$~', '', $header) . '; secure; SameSite=None';
            header($header, false);
            break;
        }
        return $res;
    }
}
session_start_samesite();
//session_start();

## DB Connect

$db['host'] ="112.175.249.12";
$db['user'] = "hrd";
$db['pass'] = "qwer1234!@#$";
$db['db'] 	= "hrd";

$connect = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['db']);
mysqli_query($connect,"SET NAMES utf8");

if (!$connect) {
    echo "<BR>Error: Unable to connect to MySQL." . PHP_EOL;
    echo "<BR>Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "<BR>Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

## DB Connect

####################################################
// 변수 정의
####################################################
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $Protocol_SSL = "http://";
}else{
    $Protocol_SSL = "https://";
}

$SiteCode = "HRDe";

$SiteName = "HRDe평생교육원";
$CertSiteName = "HRDe평생교육원";
$CertSiteName2 = "HRDe평생교육원";
$CertSiteName3 = "근로자안전보건센터장";

$UPLOAD_DIR = "/home/hrd/html/upload";
$HomeDirectory = "/home/hrd/html";


$SiteURL 			= $Protocol_SSL."www.hrdeedu.com";
$MobileSiteURL 		= $Protocol_SSL."m.hrdeedu.com";

$MobileAuthURL 		= $Protocol_SSL."m.hrdeedu.com/"; //모바일 인증 도메인
$FlashServerURL 	= $Protocol_SSL."www.hrdeedu.com/contents";
$MovieServerURL		= $Protocol_SSL."www.hrdeedu.com/contents";
$MobileServerURL 	= $Protocol_SSL."www.hrdeedu.com/contents";

$Auth_Mobile_path 	= $HomeDirectory."/lib/CheckPlusSafe/64bit/CPClient_64bit"; //휴대폰 본인인증 모듈 경로
$Auth_IPIN_path 	= $HomeDirectory."/lib/NiceIPIN/64bit/IPIN2Client"; //아이핀 본인인증 모듈 경로

$CheckPlus_sitecode = "BY356";
$CheckPlus_sitepasswd = "n7G8wHWRYRoJ";

$IPIN_CheckPlus_sitecode = "GL08";
$IPIN_CheckPlus_sitepasswd = "00000000";

$DB_Enc_Key = "ek3434!";

$UserIP = $_SERVER['REMOTE_ADDR'];
$ServerIP = $_SERVER['SERVER_ADDR'];

$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

$MobileArray  = array("iphone","ipad","lgtelecom","skt","mobile","samsung","nokia","blackberry","opera Mini","android","sony","phone","windows ce");

$MobileAgent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

if(preg_match($MobileAgent, $_SERVER['HTTP_USER_AGENT'])){
    $UserDevice = "Mobile";
    $MobilecheckCount = 1; 
}else{
    $UserDevice = "PC";
    $MobilecheckCount = 0; 
}

$userAgent = $HTTP_USER_AGENT;

if(preg_match("/MSIE*/", $userAgent)) { // 익스플로러
    $browser = "Explorer";
}
if(preg_match("/Trident*/", $userAgent) && preg_match("/rv:11.0*/", $userAgent) && preg_match("/Gecko*/", $userAgent)) {
    $browser = "Explorer"; //IE11
}
if(preg_match("/Chrome*/", $userAgent)) { 
    $browser = "Chrome"; // 크롬
}
if(preg_match("/Edge*/", $userAgent)) { 
    $browser = "Edge"; // 엣지
}
if(!$browser) {
    $browser = "Other"; // 기타
}

//사이트 정보 ###############################################################

$Sql = "SELECT * FROM SiteInfomation ORDER BY RegDate DESC LIMIT 0,1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $SiteName = $Row['CompanyName'];
    $SiteCeo = $Row['Ceo'];
    $SiteCompanyNumber = $Row['CompanyNumber'];
    $SiteSalesReportNumber = $Row['SalesReportNumber'];
    $SitePhone = $Row['Phone'];
    $SiteFax = $Row['Fax'];
    $SiteEmail = $Row['Email'];
    $SitePersonalInformationManager = $Row['PersonalInformationManager'];
    $SiteAddress = $Row['Address'];
    $SiteCopyright = $Row['Copyright'];
}

mysqli_free_result($Result);

//사이트 정보 ###############################################################



//로그인 정보 ###############################################################
//echo "INCNLUDE_TOP-".	$_SESSION["LoginMemberID"]."<br>";
if(isset($_SESSION['LoginMemberID'])) {
    $LoginMemberID = $_SESSION['LoginMemberID'];
    $LoginName = $_SESSION['LoginName'];
    $LoginEduManager = $_SESSION['LoginEduManager'];
    $LoginMemberType = $_SESSION['LoginMemberType'];
    $LoginTestID = $_SESSION['LoginTestID'];
	
//	echo "INCNLUDE_TOP2-".	$_SESSION["LoginMemberID"]."<br>";
//	echo "INCNLUDE_TOP2-".	$LoginMemberID."<br>";

}

//CAPTCHA 인증
//$captcha_agent_id = "ekt3434";
$captcha_agent_id = "hrde1746";
//$captcha_process = true;
//$captcha_test_url = "/player/captcha_test.php";
//$captcha_class_url = "/player/captcha_class.php";


$Menu01ParentCategory = 1;
$Menu02ParentCategory = 3;
$Menu03ParentCategory = 4;


$pg = "";
$col = "";
$sw = "";
$StartDate = "";
$EndDate = "";
$orderby = "";
$FaqCate = "";
$Gubun = "";
$idx = "";
$ExamType = "";
$ServiceType = "";
$ParentCategory = "";
$Category = "";

//파라미터값 받기
$params = array_merge($_POST, $_GET, $_COOKIE,$_SESSION); 
foreach($params as $key => $value) { 
    global ${$key}; 
    ${$key} = $value; 
}



$CategoryType_array = array(
    "A" => "사업자 과정",
    "B" => "근로자 과정"
);

$Gender_array = array(
    "M" => "남성",
    "F" => "여성"
);
reset($Gender_array);

$UseYN_array = array(
    "Y" => "사용",
    "N" => "미사용"
);
reset($UseYN_array);

$Faq_array = array(
    "A" => "회원가입",
    "B" => "학습",
    "C" => "평가",
    "D" => "과제",
    "E" => "회원탈퇴",
    "F" => "기타"
);
reset($Faq_array);

$Counsel_array = array(
    "A" => "학습질의",
    "B" => "시스템 문의",
    "C" => "이의 제기"
);
reset($Counsel_array);

$CounselPhone_array = array(
    "A" => "학습 문의",
    "B" => "시스템 문의",
    "C" => "기타 문의"
);
reset($CounselPhone_array);

$CounselStatus_array = array(
    "A" => "대기",
    "B" => "완료"
);
reset($CounselStatus_array);

$CounselPhoneStatus_array = array(
    "A" => "처리중",
    "B" => "처리완료"
);
reset($CounselPhoneStatus_array);

$SimpleAskStatus_array = array(
    "A" => "접수",
    "B" => "처리중",
    "C" => "처리완료"
);
reset($SimpleAskStatus_array);

$Edudata_array = array(
    "A" => "경영·사무",
    "B" => "보건·의료",
    "C" => "보육",
    "D" => "4차 산업",
    "E" => "법정의무·기타"
);
reset($Edudata_array);

$CompanyScale_array = array(
    "C" => "우선지원대상",
    "A" => "대규모 1000인 이상",
    "B" => "대규모 1000인 미만"
);
reset($CompanyScale_array);

$CyberEnabled_array = array(
    "Y" => "사용",
    "N" => "사용안함"
);
reset($CyberEnabled_array);

$Bank_array = array(
    "국민은행" => "국민은행",
    "농협" => "농협",
    "우리은행" => "우리은행",
    "SC은행" => "SC은행",
    "기업은행" => "기업은행",
    "하나은행" => "하나은행",
    "수협중앙회" => "수협중앙회",
    "신한은행" => "신한은행",
    "한국씨티은행" => "한국씨티은행",
    "대구은행" => "대구은행",
    "부산은행" => "부산은행",
    "광주은행" => "광주은행",
    "제주은행" => "제주은행",
    "전북은행" => "전북은행",
    "경남은행" => "경남은행",
    "우체국" => "우체국",
    "새마을금고" => "새마을금고",
    "신협" => "신협",
    "KDB산업은행" => "KDB산업은행",
    "카카오뱅크" => "카카오뱅크"
);
reset($Bank_array);

$Card_array = array(
    "11" => "국민",
    "15" => "카카오뱅크",
    "21" => "하나(외환)",
    "30" => "KDB산업체크",
    "31" => "비씨",
    "32" => "하나",
    "33" => "우리(구.평화VISA)",
    "34" => "수협",
    "35" => "전북",
    "36" => "씨티",
    "37" => "우체국체크",
    "38" => "MG새마을금고체크",
    "39" => "저축은행체크",
    "41" => "신한(구.LG카드 포함)",
    "42" => "제주",
    "46" => "광주",
    "51" => "삼성",
    "61" => "현대",
    "62" => "신협체크",
    "71" => "롯데",
    "91" => "NH",
    "3C" => "중국은련",
    "4J" => "해외JCB",
    "4V" => "해외VISA",
    "4M" => "해외MASTER",
    "6D" => "해외DINERS",
    "6I" => "해외DISCOVER"
);
reset($Card_array);

$ContentsType_array = array(
    "E" => "강의 시작",
    "F" => "강사 소개",
    "A" => "Flash 강의",
    "B" => "mp4 영상강의",
    "C" => "문제풀이 객관식",
    "D" => "문제풀이 주관식",
    "G" => "강의 종료"
);
reset($ContentsType_array);

$ExamType_array = array(
    "A" => "객관식",
    "B" => "단답형",
    "C" => "서술형"
);
reset($ExamType_array);

$PollType_array = array(
    "A" => "객관식",
    "B" => "주관식"
);
reset($PollType_array);

$ClassGrade_array = array(
    "A" => "A등급",
    "B" => "B등급",
    "C" => "C등급"
);
reset($ClassGrade_array);

$ServiceTypeCourse_array = array(
    "1" => "환급",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)"
);
reset($ServiceTypeCourse_array);

$ServiceTypeCourse2_array = array(
    "4" => "근로자훈련"
);
reset($ServiceTypeCourse2_array);

$ServiceType_array = array(
    "1" => "사업주지원(환급)",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)",
    "9" => "테스트용",
    "4" => "근로자훈련"
);
reset($ServiceType_array);

$ServiceType1_array = array(
    "1" => "사업주지원(환급)",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)",
    "9" => "테스트용"
);
reset($ServiceType1_array);

$ServiceType2_array = array(
    "4" => "근로자훈련"
);
reset($ServiceType2_array);

//ExcelServiceType 추가
$ServiceType3_array = array(
    "1" => "사업주지원(환급)",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)"
);
reset($ServiceType3_array);

//ExcelQuaterType 추가
$QuaterType_array = array(
    "1" => "1분기",
    "2" => "2분기",
    "3" => "3분기",
    "4" => "4분기"
);
reset($QuaterType_array);

//ExcelUptae 추가
$UptaeType_array = array(
    "A" => "기타사업분야",
    "B" => "보건업",
    "C" => "제조업",
    "D" => "서비스업",
    "E" => "유통업",
    "F" => "건설업"
);
reset($UptaeType_array);

//ExcelJobType 추가
$JobType_array = array(
    "A" => "현장직",
    "B" => "사무직",
    "C" => "관리감독자",
    "D" => "신규입사자"
);
reset($JobType_array);

$CompleteTime_array = array(
    "1" => "1분",
    "5" => "5분",
    "10" => "10분",
    "13" => "13분",
    "15" => "15분",
    "20" => "20분",
    "25" => "25분",
    "30" => "30분",
    "35" => "35분",
    "40" => "40분",
    "45" => "45분",
    "50" => "50분",
    "55" => "55분",
    "60" => "60분"
);
reset($CompleteTime_array);

$ProgressCheck_array = array(
    "timeCheck" => "시간",
    "pageCheck" => "페이지"
);
reset($ProgressCheck_array);

$ChapterType_array = array(
    "A" => "강의 차시",
    "B" => "중간평가",
    "C" => "최종평가",
    "D" => "과제",
    "E" => "토론방"
);
reset($ChapterType_array);


$LectureRequestStatus_array = array(
    "A" => "승인대기",
    "B" => "결제승인",
    "C" => "결제취소"
);
reset($LectureRequestStatus_array);


$LectureRequestPayment_array = array(
    "A" => "카드",
    "B" => "무통장",
    "C" => "가상계좌"
);
reset($LectureRequestPayment_array);


$TRNEE_SE_array = array(
    "002" => "구직자",
    "003" => "채용예정자",
    "006" => "전직/이직예정자",
    "007" => "자사근로자",
    "008" => "타사근로자",
    "013" => "일용근로자",
    "983" => "취득예정자(일용포함)",
    "984" => "고용유지훈련",
    "985" => "적용제외근로자"
);
reset($TRNEE_SE_array);

$IRGLBR_SE_array = array(
    "000" => "비정규직해당없음",
    "012" => "파견근로자",
    "013" => "일용근로자",
    "014" => "기간제근로자",
    "020" => "단기간근로자",
    "021" => "무급휴업/휴직자",
    "022" => "임의가입자영업자",
    "987" => "분류불능"
);
reset($IRGLBR_SE_array);


$CompanySMS_array = array(
    "Y" => "수신허용",
    "N" => "수신거부"
);
reset($CompanySMS_array);


$SMS_ReturnCode_array = array(
    "0000" => "전송성공",
    "0001" => "접속에러",
    "0002" => "인증에러",
    "0003" => "잔여콜수 없음",
    "0004" => "메시지 형식에러",
    "0005" => "콜백번호 에러",
    "0006" => "수신번호 개수 에러",
    "0007" => "예약시간 에러",
    "0008" => "잔여콜수 부족",
    "0009" => "전송실패",
    "0010" => "MMS NO IMG (이미지없음)",
    "0011" => "MMS ERROR TRANSFER (이미지전송오류)",
    "0012" => "메시지 길이오류(2000바이트초과)",
    "0030" => "CALLBACK AUTH FAIL (발신번호 사전등록 미등록)",
    "0033" => "CALLBACK TYPE FAIL (발신번호 형식에러)",
    "0080" => "발송제한",
    "6666" => "일시차단",
    "9999" => "요금미납"
);
reset($SMS_ReturnCode_array);

$Email_ReturnCode_array = array(
    "Y" => "수신",
    "N" => "발송"
);
reset($Email_ReturnCode_array);

$ChapterLimit_array = array(
    "Y" => "차시제한 적용",
    "N" => "차시제한 미적용"
);
reset($ChapterLimit_array);

//tok2 연계여부
$tok2_array = array(
    "Y" => "연계",
    "N" => "미연계"
);
reset($tok2_array);

//kakaotalk 템플릿 리스트
$kakaotalk_list_array = array(
    "mtm" => "1:1문의 답변 등록",
    "cronStart1" => "개강안내 비환급",
    "cronStart2" => "개강안내 환급",
    "cronAuth" => "본인인증 안내"
);
reset($kakaotalk_list_array);

//kakaotalk 템플릿
$kakaotalk_array = array(
    "mtm" => "hrd01|[HRDe평생교육원] 1:1문의 답변이 등록되었습니다. 확인 부탁드립니다. (나의강의실-상담신청내역)", //1:1 문의 답변 등록 알림

    "cronAuth" => "hrd01|#{이름} 수강생님! 안녕하세요? HRDe평생교육원입니다.
법정의무교육 담당기관인 노동부 교육방침에 따라 본인인증 절차가 강화 되었습니다.
수강을 위한 필수사항이니 바쁘시더라도 #{날짜}까지 꼭 본인인증을 하셔야 합니다.
본인인증 방법은 아래 링크를 클릭하시면 바로 인증되며 본인인증 이후 수강 할 수 있습니다.
미인증시는 수강이 불가합니다.
#{인증URL}", //오전9시 10분 cron 자동발송 - 개강 다음날에 발송

    "cronStart1" => "hrd01|안녕하세요. HRDe평생교육원입니다. 신청하신 교육에 대한 개강 안내를 드립니다.

[#{회사명}] #{소속업체명} 인터넷교육이 #{시작일} 시작되었습니다!

접속 정보 : 학습사이트:#{도메인} 아이디:#{아이디} 초기비밀번호:1111 

(본 메세지는 #{소속업체명} 사업주께서 저희 교육기관에 인터넷교육을 신청하여 안내드리는 내용입니다.)", //오전9시 10분 cron 자동발송- 비환급, 개강 당일

    "cronStart2" => "hrd01|안녕하세요. HRDe평생교육원입니다. 신청하신 교육에 대한 개강 안내를 드립니다.
[#{회사명}] #{소속업체명} 인터넷교육이 #{시작일} 시작되었습니다!
접속 정보 : 학습사이트:#{도메인} 아이디:#{아이디} 초기비밀번호:1111 

또한 법정의무교육 담당기관인 노동부 교육방침에 따라 본인인증 절차가 강화 되었습니다.
수강을 위한 필수사항이니 바쁘시더라도 #{날짜}까지 꼭 본인인증을 하셔야 합니다.
본인인증 방법은 아래 링크를 클릭하시면 바로 인증되며 본인인증 이후 수강 할 수 있습니다.
미인증시는 수강이 불가합니다.
#{인증URL}

(본 메세지는 #{소속업체명} 사업주께서 저희 교육기관에 인터넷교육을 신청하여 안내드리는 내용입니다.)" //오전9시 10분 cron 자동발송- 환급, 개강 당일

);
reset($kakaotalk_array);

//근로자훈련과정 kakaotalk 템플릿
$Work_kakaotalk_array = array(
    "cronStart1" => "hrd-01|[HRDe평생교육원] 근로자 환급과정 HRD 개강시작 / 강의수강사이트 http://hrd.ek3434.com 휴대폰 본인인증 필요!!", //오전10시 근로자훈련과정 개강 당일

    "cronStart2" => "hrd-02|[HRDe평생교육원] 근로자 환급과정 HRD 수업시작 / 1일 최대8주차 수강가능 / 수강 시 휴대폰 본인인증 필수!!", //근로자훈련과정 개강 당일

    "cronProgress00" => "hrd-03|[HRDe평생교육원] HRD 0%미만 수강 중 /  http://hrd.ek3434.com 로그인 후 기간 확인하시어 수강 부탁드립니다.", //근로자훈련과정 ▶ 0% 미만 : 개강 후 7일차

    "cronProgress30" => "hrd-04|[HRDe평생교육원]현재 진도율 HRD 30%미만 / 기간 확인하시어 수강 부탁드립니다.", //근로자훈련과정 ▶ 30% 미만 : 개강 후 14일차

    "cronProgress50" => "hrd-05|[HRDe평생교육원]현재 진도율 HRD 50%미만 / 기간 확인하시어 수강 부탁드립니다. / 전체 진도율 50%이상 시 중간평가 응시 가능합니다.", //근로자훈련과정 ▶ 50% 미만 : 개강 후 28일차

    "cronProgress80" => "hrd-06|[HRDe평생교육원]현재 진도율 HRD 80%미만 / 수강종료일 확인하시어 수강부탁드립니다.", //근로자훈련과정 ▶ 80% 미만 : 개강 후 42일차

    "cronProgressLast" => "hrd-07|[HRDe평생교육원]전체 진도율 80% 이상 / 최종평가 응시가능 / 수강종료일 확인 후 최종평가 및 강의 수강 부탁드립니다.", //근로자훈련과정 ▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송

    "cronProgressEnd" => "hrd-09|[HRDe평생교육원] 금일 근로자 환급과정 HRD 수강이 종료되었습니다. 수고많으셨습니다. 감사합니다." //근로자훈련과정 ▶ 수강종료 : 60일차 ( 종강 당일 )

);
reset($Work_kakaotalk_array);

//관리자 메뉴 상단 권한별 링크
$Manager_Top_Link_array = array(
    "A1" => "company.php", //사업주 관리
    "A2" => "member.php", //수강생 관리
    "A3" => "lecture_reg.php", //수강 등록
    "A4" => "#", //휴면회원 관리
    "A5" => "member_out.php", //탈퇴회원 관리
    "A6" => "dept_category.php", //관리자/영업자/첨삭강사 카테고리
    "A7" => "staff01.php", //관리자 리스트
    "A8" => "staff02.php", //영업자 리스트
    "A9" => "staff03.php", //첨삭강사 리스트

    "B1" => "study.php", //학습관리
    "B2" => "lecture_request.php", //학습신청
    "B3" => "study_ip.php", //IP모니터링
    "B4" => "study_correct.php", //첨삭관리
    "B5" => "study_end.php", //수강마감
    "B6" => "study_payment.php", //결제관리
    "B7" => "blacklist.php", //블랙리스트 관리

    "C1" => "study_sms.php", //학습참여독려
    "C2" => "study_sms_log.php", //문자발송내역
    "C3" => "study_email_log.php", //메일발송내역
    "C4" => "study_sms_setting.php", //독려내용 관리

    "D1" => "teacher.php", //강사 관리
    "D2" => "exam_bank.php", //문제은행 관리
    "D3" => "course_category.php", //과정카테고리 관리
    "D4" => "contents.php", //기초차시 관리
    "D5" => "course.php", //단과 컨텐츠 관리
    "D6" => "course_package.php", //패키지 컨텐츠 관리
    "D7" => "poll_bank.php", //설문 관리

    "E1" => "notice.php", //공지사항
    "E2" => "faq.php", //자주 묻는 질문
    "E3" => "qna.php", //1:1 문의
    "E4" => "after.php", //수강후기
    "E5" => "edudata.php", //학습자료실
    "E6" => "simple_ask.php", //간편문의
    "E7" => "study_qna.php", //학습상담

    "F1" => "sta.php", //접속통계관리
    "F2" => "#", //수강생통계관리
    "F3" => "sale_sta", //영업통계관리

    "G1" => "popup.php", //팝업 관리
    "G2" => "main_course_list.php", //메인디자인 관리
    "G3" => "work_request.php", //작업 요청 게시판
    "G4" => "site_info.php", //사이트 정보 관리


    "X" => "" //
);
reset($Manager_Top_Link_array);


function FolderDetect($folder) {

    $REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
    $PageUrl = $REQUEST_URI[0];

    if(strpos($PageUrl,$folder)>-1) {
        return true;
    }else{
        return false;
    }

}

function hrdtalk($type, $phone_number, $vars, $template_code) {

    global $connect;

    if(empty($phone_number)) {
           return "N1";
    }

    if(empty($template_code)) {
           return "N1";
    }

    $sql = "SELECT Massage FROM SendMessage WHERE TemplateCode='".$template_code."' LIMIT 1";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);

    $TRAN_ORI = $row['Massage'];
    $TRAN_MSG = $TRAN_ORI;
    $TRAN_TMPL_CD = $template_code;

    foreach($vars as $key => $val) {
        $TRAN_MSG = str_replace("#{".$key."}",$val, $TRAN_MSG);            
    }
    
    // Brad : 알림톡 발신프로필키, 발신번호, 수신번호, MMS 문자제목, 전화타입 설정
    $TRAN_SENDER_KEY = "96c9bc7360b306643e9a588b76a6fe12dbf46b60"; //발신프로필키
    $TRAN_CALLBACK = "0312111333"; //발신번호
    $TRAN_PHONE = $phone_number; //수신번호
    $TRAN_SUBJECT = "HRDe평생교육원입니다"; //MMS전환시 문자 제목
    $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
    //-------------------------------------------------------------------------
    
    $query = "INSERT INTO MTS_ATALK_MSG (
        TRAN_SENDER_KEY,
        TRAN_TMPL_CD,
        TRAN_CALLBACK,
        TRAN_PHONE,
        TRAN_SUBJECT,
        TRAN_MSG,
        TRAN_DATE,
        TRAN_TYPE,
        TRAN_STATUS,
        TRAN_REPLACE_TYPE,
        TRAN_REPLACE_MSG
    ) VALUES (
        '$TRAN_SENDER_KEY',
        '$TRAN_TMPL_CD',
        '$TRAN_CALLBACK',
        '$TRAN_PHONE',
        '$TRAN_SUBJECT',
        '$TRAN_MSG',
         NOW(),
         5,
        '1',
        '$TRAN_REPLACE_TYPE',
        '$TRAN_ORI'
    )";
    echo $query;
    $result = mysqli_query($connect, $query);

    if($result) {
        return "Y";
    } else {
        return "N2";
    }
}

function kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date) {

    global $connect;
    global $kakaotalk_array;

    if($msg_mobile) {

        $msg_var_arrary = explode("|",$msg_var);

        $kakaotalk_template = $kakaotalk_array[$msg_type];
        $kakaotalk_template_arrary = explode("|",$kakaotalk_template);
        $TRAN_TMPL_CD = $kakaotalk_template_arrary[0];

        switch ($msg_type) {
            case "mtm": // 1:1 문의 답변 등록 알림
                $TRAN_MSG = $kakaotalk_template_arrary[1];
            break;
            case "cronAuth": // 본인인증 알림 : 개강 다음날에 발송
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{날짜}",$msg_var_arrary[1],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{인증URL}",$msg_var_arrary[2],$TRAN_MSG);
            break;
            case "cronStart1": // 학습시작(개강알림) :비환급, 개강 당일 발송
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$TemplateMessage);
                $TRAN_MSG = str_replace("#{소속업체명}",$msg_var_arrary[1],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{시작일}",$msg_var_arrary[2],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[3],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[4],$TRAN_MSG);
            break;
            case "cronStart2": // 학습시작(개강알림) :환급, 개강 당일 발송
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{소속업체명}",$msg_var_arrary[1],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{시작일}",$msg_var_arrary[2],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[3],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[4],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{날짜}",$msg_var_arrary[5],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{인증URL}",$msg_var_arrary[6],$TRAN_MSG);
            break;
        }

        $TRAN_SENDER_KEY = "96c9bc7360b306643e9a588b76a6fe12dbf46b60"; //발신프로필키
        $TRAN_CALLBACK = "18119530"; //발신번호
        $TRAN_PHONE = $msg_mobile; //수신번호
        $TRAN_SUBJECT = "HRDe평생교육원입니다"; //MMS전환시 문자 제목
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
		
		$maxno = max_number("idx","SmsSendLog");
		$etc1 = $maxno;

		$send = mts_mms_send($TRAN_PHONE, $TRAN_MSG, $TRAN_CALLBACK, $etc1);

		if($send=="Y") {
			$code = "0000";
			return $send;
		}else{
			$code = "0001";
			return "N2";
		}
		
		/*
        $query = "INSERT INTO MTS_ATALK_MSG(TRAN_SENDER_KEY,TRAN_TMPL_CD,TRAN_CALLBACK,TRAN_PHONE,
                    TRAN_SUBJECT,TRAN_MSG,TRAN_DATE,TRAN_TYPE,TRAN_STATUS,TRAN_REPLACE_TYPE,TRAN_REPLACE_MSG) VALUES(
                    '$TRAN_SENDER_KEY',
                    '$TRAN_TMPL_CD',
                    '$TRAN_CALLBACK',
                    '$TRAN_PHONE',
                    '$TRAN_SUBJECT',
                    '$TRAN_MSG',
                    '$send_date',
                    5,
                    '1',
                    '$TRAN_REPLACE_TYPE',
                    '$TRAN_MSG'
                    )";
        $result = mysqli_query($connect, $query);

        if($result) {
            return "Y";
        }else{
            return "N2";
        }*/


    }else{
        return "N1";
    }

}

function kakaotalk_send_before01($msg_type,$msg_mobile,$msg_var,$send_date) {

	global $connect;
	global $kakaotalk_array;

	if($msg_mobile) {
		$TRAN_TMPL_CD = $msg_type;


		$TRAN_MSG =$msg_var;
		$TRAN_SENDER_KEY = "96c9bc7360b306643e9a588b76a6fe12dbf46b60"; //발신프로필키
		$TRAN_CALLBACK = "18119530"; //발신번호
		$TRAN_PHONE = $msg_mobile; //수신번호
		$TRAN_SUBJECT = "HRDe평생교육원입니다"; //MMS전환시 문자 제목
		$TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음

		$maxno = max_number("idx","SmsSendLog");
		$etc1 = $maxno;

		$send = mts_mms_send($TRAN_PHONE, $TRAN_MSG, $TRAN_CALLBACK, $etc1, $TRAN_TMPL_CD);

		if($send=="Y") {
			$code = "0000";
			return $send;
		}else{
			$code = "0001";
			return "N2";
		}

	}else{
		return "N1";
	}

}

function kakaotalk_send2($msg_type,$msg_mobile,$msg_var,$send_date) {

    global $connect;
    global $kakaotalk_array;

    if($msg_mobile) {
		$TRAN_TMPL_CD = $msg_type;
  

		$TRAN_MSG =$msg_var;
        $TRAN_SENDER_KEY = "96c9bc7360b306643e9a588b76a6fe12dbf46b60"; //발신프로필키
        $TRAN_CALLBACK = "18119530"; //발신번호
        $TRAN_PHONE = $msg_mobile; //수신번호
        $TRAN_SUBJECT = "HRDe평생교육원입니다"; //MMS전환시 문자 제목
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음

        $query = "INSERT INTO MTS_ATALK_MSG(TRAN_SENDER_KEY,TRAN_TMPL_CD,TRAN_CALLBACK,TRAN_PHONE,
                    TRAN_SUBJECT,TRAN_MSG,TRAN_DATE,TRAN_TYPE,TRAN_STATUS,TRAN_REPLACE_TYPE,TRAN_REPLACE_MSG) VALUES(
                    '$TRAN_SENDER_KEY',
                    '$TRAN_TMPL_CD',
                    '$TRAN_CALLBACK',
                    '$TRAN_PHONE',
                    '$TRAN_SUBJECT',
                    '$TRAN_MSG',
                    '$send_date',
                    5,
                    '1',
                    '$TRAN_REPLACE_TYPE',
                    '$TRAN_MSG'
                    )";
        
        $result = mysqli_query($connect, $query);

        if($result) {
            return "Y";
        }else{
            return "N2";
        }


    }else{
        return "N1";
    }

}

function kakaotalk_send3($msg_type,$msg_mobile,$msg_var,$user_id,$input_id) {

    global $connect;
    global $kakaotalk_array;

    if($msg_mobile) {

        $Sql = "SELECT * FROM SendMessage WHERE MessageMode='$msg_type'";
        $Result = mysqli_query($connect, $Sql);
        $Row = mysqli_fetch_array($Result);
        if($Row) {
            $Message = $Row['Massage'];
            $TemplateCode 	= $Row['TemplateCode'];
            $TemplateMessage 	= $Row['TemplateMessage'];

            $TRAN_TMPL_CD = $TemplateCode;
			$UserID = $user_id;
            $InputID = $input_id;
            $msg_var_arrary = explode("|",$msg_var);

            if($msg_type == 'before01'){
                $study_seq = $msg_var_arrary[0];
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[1],$TemplateMessage);
                $TRAN_MSG = str_replace("#{소속업체명}",$msg_var_arrary[2],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[3],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[4],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{과정명}",$msg_var_arrary[5],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{시작}",$msg_var_arrary[6],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{종료}",$msg_var_arrary[7],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{회사명}",$SiteName,$TRAN_MSG);
            }else if($msg_type == 'find_id'){
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$TemplateMessage);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[1],$TRAN_MSG);
            }else if($msg_type == 'new_password'){
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$TemplateMessage);
                $TRAN_MSG = str_replace("#{임시비밀번호}",$msg_var_arrary[1],$TRAN_MSG);
            }else{		
                $TRAN_MSG = $TemplateMessage;
            }
			
            $TRAN_CALLBACK = "18119530"; //발신번호
            $TRAN_PHONE = $msg_mobile; //수신번호

            //발송 로그 기록
            $maxno = max_number("idx","SmsSendLog");
            $etc1 = $maxno;
			if($study_seq){
				$Sql = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate) VALUES($maxno, '$UserID', $study_seq, '$TRAN_MSG', '', '$msg_mobile', '$InputID', NOW())";
			}else{
				$Sql = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate) VALUES($maxno, '$UserID', 0, '$TRAN_MSG', '', '$msg_mobile', '$InputID', NOW())";
			}
			$Row = mysqli_query($connect, $Sql);
            $send = mts_mms_send($TRAN_PHONE, $TRAN_MSG, $TRAN_CALLBACK, $etc1, $TRAN_TMPL_CD);

            if($send=="Y"){
                $code = "0000";
            }else{
                $code = "0001";
            }

            $Sql2 = "UPDATE SmsSendLog SET Code='$code' WHERE idx=$maxno";
            $Row2 = mysqli_query($connect, $Sql2);

            if($send=="Y") {
                return "Y";
            }else{
                return "N2";
            }
        }else{
            return "N3";
        }
    }else{
        return "N1";
    }

}

//근로자훈련과정 발송
function Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date) {

    global $connect;
    global $Work_kakaotalk_array;

    if($msg_mobile) {

        $msg_var_arrary = explode("|",$msg_var);

        $kakaotalk_template = $Work_kakaotalk_array[$msg_type];
        $kakaotalk_template_arrary = explode("|",$kakaotalk_template);
        $TRAN_TMPL_CD = $kakaotalk_template_arrary[0];


        switch ($msg_type) {
            case "cronStart1": // ▶ 학습시작 : 개강당일
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[1],$TRAN_MSG);
            break;
            case "cronStart2": // ▶ 학습시작 : 개강당일
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
            break;
            case "cronProgress00": // ▶ 0% 미만 : 개강 후 7일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[1],$TRAN_MSG);
            break;
            case "cronProgress30": // ▶ 30% 미만 : 개강 후 14일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
            break;
            case "cronProgress50": // ▶ 50% 미만 : 개강 후 28일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
            break;
            case "cronProgress80": // ▶ 80% 미만 : 개강 후 42일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
            break;
            case "cronProgressLast": // ▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
            break;
            case "cronProgressEnd": // ▶ 수강종료 : 60일차 ( 종강 당일 ) 
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
            break;

        }


        $TRAN_SENDER_KEY = "96c9bc7360b306643e9a588b76a6fe12dbf46b60"; //발신프로필키
        $TRAN_CALLBACK = "0312111333"; //발신번호
        $TRAN_PHONE = $msg_mobile; //수신번호
        $TRAN_SUBJECT = "HRDe평생교육원입니다"; //MMS전환시 문자 제목
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음

        $query = "INSERT INTO MTS_ATALK_MSG(TRAN_SENDER_KEY,TRAN_TMPL_CD,TRAN_CALLBACK,TRAN_PHONE,
                    TRAN_SUBJECT,TRAN_MSG,TRAN_DATE,TRAN_TYPE,TRAN_STATUS,TRAN_REPLACE_TYPE,TRAN_REPLACE_MSG) VALUES(
                    '$TRAN_SENDER_KEY',
                    '$TRAN_TMPL_CD',
                    '$TRAN_CALLBACK',
                    '$TRAN_PHONE',
                    '$TRAN_SUBJECT',
                    '$TRAN_MSG',
                    '$send_date',
                    5,
                    '1',
                    '$TRAN_REPLACE_TYPE',
                    '$TRAN_MSG'
                    )";
        $result = mysqli_query($connect, $query);

        if($result) {
            return "Y";
        }else{
            return "N2";
            //return $query;
        }


    }else{
        return "N1";
    }

}

// 단순히 띄우는 경고메시지
    function alert($msg,$mode = 0) {
        echo "<script language=javascript>";
        echo "alert('$msg'); ";
        if($mode)
        {
            echo "self.close();";
            exit;
        }
        echo "</script>";
    }

// 이전페이지로 가는 함수.
// 메시지를 인자로 전달할 경우, 메시지를 출력하고 이전 페이지로 간다.
// go_back();
// go_back( $msg ); 메시지를 출력하고 이전 페이지로 감.
    function go_back( $msg = "", $exit = 1 ) {
        echo "<script language=javascript>";
        if( $msg ) echo "alert( \" $msg \" ); ";
        echo "history.back();";
        echo "</script>";
        if( $exit ) exit;
    }
// 현재 페이지를 $url 로 대체
// 현재 페이지는 history 상에 남지 않음
// go_url( $url, $msg ); $msg를 경고메시지로 출력하고 이동.
// go_url( $url, $msg, $target ); $msg 를 경고 메시지로 출력하고 $target의 프레임을 이동
    function go_url( $url, $msg = "", $target = "" ) {
        echo "<script language=javascript>\n";
        if( $msg ) echo "alert( \" $msg \" );\n";
        
        if( $target ) echo $target . ".";
        echo "location.replace('" . $url . "');\n";
        
        echo "</script>\n";
        exit;
    }

// TEXT 박스에서 value값에 "가 들어가 있으면 인식을 못하므로
// 인식할 수 있는 문자로 치환해준다.
    function html_quote( $str ) {
        $str = stripslashes($str);
        return str_replace( chr(34), "&#34", $str );
    }

// SELECT 의 옵션을 출력해주는 함수
// $data 는 키배열이다.
    function select_option_key( $data, $sel = "" ) {
        while( list( $key, $value ) = each( $data ) ) {
            if( $key == $sel ) echo "<option value=\"$key\" SELECTED> $value </option>";
            else echo "<option value=\"$key\"> $value </option>";
        }
    }


// SELECT 의 옵션을 출력해주는 함수
// $data 는 일반배열이다.
    function select_option_value( $data, $sel = "" ) {
        while( list( $key, $value ) = each( $data ) ) {
            if( $value == $sel ) echo "<option value=\"$value\" SELECTED> $value </option>";
            else echo "<option value=\"$value\"> $value </option>";
        }
    }

// 숫자를 넣으면 날짜,시간,분,초 로 돌려준다.
    function get_num_to_date( $number )
    {
        $pDate = floor($number / 86400); //--남은 날짜
        $pHour = floor( ($number - ($pDate * 86400) ) / 3600);//-- 시간
        $pMin = floor( ($number - ($pDate * 86400) - ($pHour * 3600) ) / 60);
        $pSec = $number - ($pDate * 86400) - ($pHour *  3600) - ($pMin * 60);
        if($pMin < 10 && $pMin) $pMin = "0" . $pMin;
        if($pSec < 10 && $pSec) $pSec = "0" . $pSec;
        $pAll = "";
        $pAll .= ($pDate) ? "{$pDate}일" : "";
        $pAll .= ($pHour) ? "{$pHour}:" : "";
        $pAll .= ($pMin) ? "{$pMin}:" : "00:";
        $pAll .= ($pSec) ? "{$pSec}" : "00";
        
        $dAll = "";
        $dAll .= ($pDate) ? " {$pDate}일" : "";
        $dAll .= ($pHour) ? " {$pHour}시간" : "";
        $dAll .= ($pMin) ? " {$pMin}분" : " 00분";
        $dAll .= ($pSec) ? " {$pSec}초" : " 00초";


        return array($pDate,$pHour,$pMin,$pSec,$pAll,$dAll);
    }

// 날짜,시간,분,초 로 돌려준다.
    function get_date_to_num( $D,$H,$M,$I )
    {
        $getNumD = $D * 86400;
        $getNumH = $H * 3600;
        $getNumM = $M * 60;
        $getNumI = $I;
        return $getNumD + $getNumH + $getNumM + $getNumI;
    }

// 파일 이름으로부터 확장자를 얻는 함수
    function get_file_ext( $filename ) {
        $pos = strrchr( $filename, "." );
        
        // 파일 이름이 name.exe. 같은 거라면 확장자에 아무 것도 걸리지 않으므로 . 을 한 번 더 빼준다
        if( trim( $pos ) == "." ) $pos = strrchr( substr( $filename, 0, strlen( $filename ) -1 ), "." );
        
        return substr( $pos, 1 );
    }

##    한글 자르기
    function cut_string( $text, $ori_length, $suffix = "...") {
        
        $length = $ori_length;
        while( $length > 0 && ord( $text[$length] ) > 128) $length--;
        
        if( $length <= 0 ) $length = 0;
        
        //한글이 연속해서 짤렸을때 영문부분부터 다시 처리
        if( $length < $ori_length-1 ) {
            $step = 0;
            $new_length = $length;
            while( $length < $ori_length ) {
                if( ord( $text[$length] ) > 128 ) {
                    if( $step == 0 ) $step = 1; //한글시작
                    else {
                        $step = 0; //한글끝
                        $new_length += 2;
                    }
                } else {
                    $new_length++;
                    $step = 0;
                }
                $length++;
            }
            $length = $new_length;
        }
        $result = substr( $text, 0, $length);
        //$result = iconv_substr($text,0,$length,"UTF-8");
        if( $suffix && strlen( $text ) > $length ) return $result.$suffix;
        return $result;
    }

function strcut_utf8($str, $len, $checkmb=false, $tail='...') { 
    /** 
     * UTF-8 Format 
     * 0xxxxxxx = ASCII, 110xxxxx 10xxxxxx or 1110xxxx 10xxxxxx 10xxxxxx 
     * latin, greek, cyrillic, coptic, armenian, hebrew, arab characters consist of 2bytes 
     * BMP(Basic Mulitilingual Plane) including Hangul, Japanese consist of 3bytes 
     **/
    preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP 
    $m = $match[0]; 
    $slen = strlen($str); // length of source string 
    $tlen = strlen($tail); // length of tail string 
    $mlen = count($m); // length of matched characters 
    if ($slen <= $len) return $str; 
    if (!$checkmb && $mlen <= $len) return $str; 
    $ret = array(); 
    $count = 0; 
    for ($i=0; $i < $len; $i++) { 
        $count += ($checkmb && strlen($m[$i]) > 1)?2:1; 
        if ($count + $tlen > $len) break; 
        $ret[] = $m[$i]; 
    } 
    return join('', $ret).$tail; 
}



 
    function get_new_file_name($file_path, $realfilename) {
        
        if(!$realfilename){
            return "";
        }
        else{
            $realfile_name = explode(".",$realfilename);
            if(count($realfile_name) > 1){
                
                for($i = 0; $i < count($realfile_name) - 1;$i++){
                    $file_name .= $realfile_name[$i];
                    if($i < count($realfile_name) - 2) $file_name .= ".";
                }
                $file_ext = $realfile_name[count($realfile_name) - 1];
            }
            else{
                $file_name = $realfilename;
                $file_ext = "";
            }
    
            
    
            $filename = "";
            $newFile = "";
            $fileExt = "";
            if ($file_ext) $fileExt = "." . $file_ext;
            $filename = $file_name . $fileExt;
    
            $bExist = true;
            $strFileName = $file_path . "/" . $filename;
            $countFileName = 0;
            $newFile = $filename;
            while ($bExist) {
                if (is_file ($strFileName) ) {
                    $countFileName++;
                    $newFile = $file_name . "_" . $countFileName . $fileExt;
                    $strFileName = $file_path . "/" .  $newFile;
                } else {
                    $bExist = false;
                }
            }                   
            return $newFile;
        }
    }

#############################################################################
##-- 매달 의 마지막날일
    function get_end_day($myyear, $mymonth)
    {
        $endday = array(31,29,31,30,31,30,31,31,30,31,30,31);
        $endday[1] = ($myyear % 4 != 0) ? 28 : ($myyear % 100 != 0) ? 29 : ($myyear % 400 != 0) ? 28 : 29;
        return $endday[$mymonth - 1];
    }

###################################################################################
##-- 사용법 imgThumbo(파일, 저장될이름, 가로 최대 크기,디렉토리명,세로 최대 크기,);
    //function img_thumbo($filePath, $saveName, $fWidth, $saveDir = "./", $fHeight = "0")
    function img_thumbo($filePath, $saveName, $fWidth, $saveDir, $fHeight)
    {
      if (!file_exists($saveDir))
      {
        @mkdir($saveDir);
        @chmod($saveDir, 0777);
      }
    
      $is_changeImage = false;
    
      $sz = @getimagesize($filePath); // 이미지 사이즈구함
      $imgW = $sz[0];
      $imgH = $sz[1];
    
      ##-- 가로 크기
      if($imgW  > $fWidth)
      {
        $per=$imgW/$fWidth;
        $imgW=ceil($imgW/$per);
        $imgH=ceil($imgH/$per);
        $is_changeImage = true;
      }
    
      ##-- 세로 크기 만약 있다면 줄인다.
      if($fHeignt > 0)
      {
        if($imgH > $fHeight)
        {
          $per=$imgH/$fHeight;
          $imgW=ceil($imgW/$per);
          $imgH=ceil($imgH/$per);
          $is_changeImage = true;
        }
      }
      
      ##-- 큰 이미지 일 경우에만 사이즈를 줄여서 넣는다.
      if($is_changeImage)
      {
          switch ($sz[2])
          {
            case 1:
              $src_img = imagecreatefromgif($filePath);//@imagecreatefromgif($filePath);
              $dst_img = imagecreate($imgW, $imgH);
              if($src_img)
              {
                  //$dst_img = imagecreatetruecolor($imgW, $imgH);
                  ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]);
                  ImageInterlace($dst_img);
                  imageGIF($dst_img, $saveDir.$saveName);
                  //ImageJPEG($dst_img, $saveDir.$saveName . ".jpg");
              }
              break;
    
            case 2:
              $src_img = imagecreatefromjpeg($filePath);//@imagecreatefromjpeg($filePath);
              $dst_img = imagecreatetruecolor($imgW, $imgH);
              if($src_img)
              {
                  ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]);
                  ImageInterlace($dst_img);
                  ImageJPEG($dst_img, $saveDir.$saveName,90);
              }
              break;
    
            case 3:
              $src_img = imagecreatefrompng($filePath);//@imagecreatefrompng($filePath);
              $dst_img = imagecreatetruecolor($imgW, $imgH);
              if($src_img)
              {
                ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]);
                ImageInterlace($dst_img);
                ImagePNG($dst_img, $saveDir.$saveName);
              }
              break;
    
            default:
              return false;
              break;
          }
          ##-- 원본 삭제 한다.
         // unlink($filePath);
      }
    
      ##-- 기준 이미지 보다 작다면 기냥 이동한다.
      else
      {
          copy($filePath,$saveDir.$saveName);
      }
    
      return array($saveDir, $saveName, $imgW, $imgH);
    }
##-- 사용법 imgThumbo(파일, 저장될이름, 가로 최대 크기,디렉토리명,세로 최대 크기,);
###################################################################################

###################################################################################
##-- 사용법 imgThumbo(파일, 저장될이름, 가로 최대 크기,디렉토리명,세로 최대 크기,);
    function img_user_size($fileName, $fWidth, $fHeight)
    {
      $sz = @getimagesize($fileName); // 이미지 사이즈구함
      $imgW = $sz['0'];
      $imgH = $sz['1'];
    
      ##-- 가로 크기
      if($imgW  > $fWidth)
      {
        $per=$imgW/$fWidth;
        $imgW=ceil($imgW/$per);
        $imgH=ceil($imgH/$per);
      }
    
      if($imgH > $fHeight)
      {
          $per=$imgH/$fHeight;
          $imgW=ceil($imgW/$per);
          $imgH=ceil($imgH/$per);
      }
      return array($imgW, $imgH);
    }

    function img_user_size2($fileName)
    {
      $sz = @getimagesize($fileName); // 이미지 사이즈구함
      $imgW = $sz[0];
      $imgH = $sz[1];
    
      return array($imgW, $imgH);
    }
##-- 사용법 imgThumbo(파일, 저장될이름, 가로 최대 크기,디렉토리명,세로 최대 크기,);
###################################################################################

#################################################
## 암호화
    function bytexor($a,$b)
    {
            $c="";
            for($i=0;$i<16;$i++)$c.=$a{$i}^$b{$i};
            return $c;
    }

    function decrypt_md5($msg,$key = "GSJOI")
    {
                    $string="";
            $buffer="";
            $key2="";
    
                    $msg = base64_decode($msg);
            while($msg)
            {
                    $key2=pack("H*",md5($key.$key2.$buffer));
                    $buffer=bytexor(substr($msg,0,16),$key2);
                    $string.=$buffer;
                    $msg=substr($msg,16);
            }
            return($string);
    }

    function encrypt_md5($msg,$key = "GSJOI")
    {
            $string="";
            $buffer="";
            $key2="";
    
            while($msg)
            {
                    $key2=pack("H*",md5($key.$key2.$buffer));
                    $buffer=substr($msg,0,16);
                    $string.=bytexor($buffer,$key2);
                    $msg=substr($msg,16);
            }
            return(base64_encode($string) );
    }

function encrypt_SHA256($str) {
    $planBytes = array_slice(unpack('c*',$str), 0); // 평문을 바이트 배열로 변환
    $ret = null;
    $bszChiperText = null;
    KISA_SEED_SHA256::SHA256_Encrypt($planBytes, count($planBytes), $bszChiperText);
    $r = count($bszChiperText);

    foreach($bszChiperText as $encryptedString) {
        $ret .= bin2hex(chr($encryptedString)); // 암호화된 16진수 스트링 추가 저장
    }
    return $ret;
}

## 암호화
#################################################

#################################################
## 파일 확장자로 이미지 가져오기
    function get_ext_image($inFilename){

    $reFile_name = strtolower(substr(strrchr($inFilename, "."), 1));

    Switch ($reFile_name) {
    case "":
        if($inFilename) {
        $iconimage = "icon_file_etc.gif";
        }else{
        $iconimage = "none.gif";
        }
    break;
    case "zip":
        $iconimage = "icon_file_zip.gif";
    break;
    case "alz":
        $iconimage = "icon_file_zip.gif";
    break;
    case "hwp":
        $iconimage = "icon_file_hwp.gif";
    break;
    case "xls":
        $iconimage = "icon_file_excel.gif";
    break;
    case "csv":
        $iconimage = "icon_file_excel.gif";
    break;
    case "doc":
        $iconimage = "icon_file_doc.gif";
    break;
    case "txt":
        $iconimage = "icon_file_doc.gif";
    break;
    case "jpg":
        $iconimage = "icon_file_img.gif";
    break;
    case "gif":
        $iconimage = "icon_file_img.gif";
    break;
    case "bmp":
        $iconimage = "icon_file_img.gif";
    break;
    case "jpeg":
        $iconimage = "icon_file_img.gif";
    break;
    case "pdf":
        $iconimage = "icon_file_pdf.gif";
    break;
    default :
        $iconimage = "icon_file_etc.gif";
}

        return $iconimage;
    }
## 파일 확장자로 이미지 가져오기
#################################################
## SQL INJECTION 체그 함수##############################

function Replace_Check($str) {

    $str = trim($str);
    $str = addslashes($str);
    //$str = trim(str_replace("'","\'",$str));
    $str = str_replace("--","",$str);
    //$str = str_replace("%","",$str);
    $str = str_replace(";","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);

    return $str;
}

function Replace_Check_XSS($str) {

    $str = trim($str);
    $str = addslashes($str);
    $str = strtolower($str);
    $str = trim(str_replace("&lt;","",$str));
    $str = trim(str_replace("&gt;","",$str));
    $str = trim(str_replace("<","",$str));
    $str = trim(str_replace(">","",$str));
    $str = str_replace("--","",$str);
    $str = str_replace("%","",$str);
    $str = str_replace(";","",$str);
    //$str = str_replace("error","",$str);
    $str = str_replace("script","",$str);
    $str = str_replace("document","",$str);
    $str = str_replace("form","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);

    return $str;
}

function Replace_Check_XSS2($str) {
    
    $str = addslashes($str);
    //$str = trim(str_replace("name","",$str));
    //$str = trim(str_replace("NAME","",$str));
    $str = trim(str_replace("<s","&lt;s",$str));
    $str = trim(str_replace("<S","&lt;S",$str));
    $str = trim(str_replace("type","",$str));
    $str = trim(str_replace("TYPE","",$str));
    $str = trim(str_replace("frame","",$str));
    $str = trim(str_replace("FRAME","",$str));
    $str = trim(str_replace("<f","&lt;f",$str));
    $str = trim(str_replace("<F","&lt;F",$str));
    $str = trim(str_replace("submit","",$str));
    $str = trim(str_replace("SUBMIT","",$str));
    $str = str_replace("--","",$str);
    $str = str_replace("error","",$str);
    $str = str_replace("script","",$str);
    $str = str_replace("SCRIPT","",$str);
    $str = str_replace("document","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);

    return $str;
}

function Replace_Check2($str) {
    
    $str = addslashes($str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);
    //$str = trim(str_replace("'","''",$str));

    return $str;
}

function Replace_Check_sms($str) {

    $str = trim($str);
    $str = addslashes($str);
    $str = str_replace("--","",$str);
    $str = str_replace(";","",$str);
    $str = str_replace("-","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);

    return $str;
}


################################################
//메일 발송========================================

function nmail($fromaddress, $toaddress, $subject, $body, $fromname) {

    //$headers .= "From: <$fromname;$fromaddress>\n"; //메일 보내는 사람 
    $headers .= "X-Sender: <$fromaddress>\n"; //보낸 곳 
    $headers .= "X-Mailer: PHP\n"; //메일 엔진 이름 
    //$headers .= "X-Priority: 1\n"; //긴급 메시지 표시 
    $headers .= "Return-Path: <$fromaddress>\n"; //메일보내기 실패했을경우 메일 받을 주소 
    $headers .= "Content-Type: text/html; charset=EUC-KR\n"; //HTML 메일 형태일경우에만 추가 
    $headers .= "\n\n"; //★★★ 이부분은반드시 추가

    $fp = popen('/usr/sbin/sendmail -t -f '.$fromaddress.' '.$toaddress,"w"); 
    if(!$fp){
        return false; 
    }else{
        fputs($fp, "From:$fromname<$fromaddress>\r\n"); 
        fputs($fp, "To: $toaddress\r\n"); 
        fputs($fp, "Subject: ".$subject."\r\n"); 
        fputs($fp, $headers."\r\n"); 
        fputs($fp, $body); 
        fputs($fp, "\r\n\r\n\r\n"); 
        pclose($fp); 
        return true; 
    }
}


// 문자메시지 발송함수
function mts_mms_send($phone, $msg, $callback, $etc1, $template_code="hrd01") {

    global $connect;

    if ($phone)  {
        // 발신번호 /로 여러개 들어가 있는 경우 수정.
        $callback_arr = explode("/",$callback);
        $callback = trim($callback_arr[0]);
    
        $data=array(
            //Brad : 변경필요 - auth_code, sender_key, template_code ...
            "auth_code"=>"Wk0Q7WMig7NbaIDL/Uj7VA==",
            "sender_key"=>"96c9bc7360b306643e9a588b76a6fe12dbf46b60",
            "send_date"=>date("YmdHis"),
            "callback_number"=>$callback,
            "nation_phone_number"=>"82",
            "phone_number"=>$phone,
            "template_code"=>$template_code,
            "message"=>stripslashes($msg),
            "tran_type"=>"L",
            "tran_message"=>$msg,
            "add_etc1"=>$etc1
        );
        //print_r($data);
        $data = json_encode($data);
         
        $url = "https://api.mtsco.co.kr";
        $url .= "/sndng/atk/sendMessage";

        $ch = curl_init();                                 //curl 초기화
        curl_setopt($ch,CURLOPT_URL, $url);               //URL 지정하기
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);       //POST data
        curl_setopt($ch,CURLOPT_POST, true);              //true시 post 전송 
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Accept: application/json","Content-Type: application/json"));
        $response = curl_exec($ch);
        
        curl_close($ch);
        
        $response = json_decode($response);
        if ($response->code != "0000") {
            $result_code = $response->code;
        }
        //print_r($data);
        //print_r($response);
        $report_date = $response->received_at;
        $result_date = $response->received_at;
		
        $TRAN_SUBJECT = $SiteName."입니다"; //MMS전환시 문자 제목

        //$query = "INSERT INTO MTS_MMS_MSG(TRAN_PHONE,TRAN_CALLBACK,TRAN_MSG,TRAN_DATE, TRAN_TYPE, TRAN_ETC1) VALUES ('$phone','$callback','$msg',now(), 4,'$etc1')";
        $query = "INSERT INTO MTS_MMS_MSG(TRAN_PHONE,TRAN_CALLBACK,TRAN_MSG,TRAN_DATE, TRAN_TYPE, TRAN_ETC1, TRAN_REPORTDATE, TRAN_RSLTDATE, TRAN_RSLT) ";
        $query .= "VALUES ('$phone','$callback','$msg',now(), 4,'$etc1', '$report_date', '$result_date', '$result_code')";
        if ($response->code != "0000") {
            $result = mysqli_query($connect, $query);
        }
        $result = $response->code;

        if ($result) {
            return "Y";
        } else if ($result == "0000") {
            return "Y";
        } else {
            return "N2";
        }


    }else{
        return "N1";
    }

}


//##########################################################


# UTF 로 무조건 변환 
function change_to_utf($utfStr) { 
  if (iconv("UTF-8","UTF-8",$utfStr) == $utfStr) { 
    return $utfStr; 
  } 
  else { 
    return iconv("EUC-KR","UTF-8",$utfStr); 
  } 
} 

function DateToStamp($NowDate="", $RtnType="DateTime")
    {
        if(empty($NowDate)) $NowDate = date("Y-m-d H:i:s",Mktime());
        $NowYear = date("Y",strtotime($NowDate));
        $NowMonth = date("m",strtotime($NowDate));
        $NowDay = date("d",strtotime($NowDate));
        $NowHour = date("H",strtotime($NowDate));
        $NowMinute = date("i",strtotime($NowDate));
        $NowSecond = date("s",strtotime($NowDate));
        switch($RtnType)
        {
            Case "Date": $NowStamp = mktime(0, 0, 0, $NowMonth, $NowDay, $NowYear); Break;
            Case "Time": $NowStamp = mktime($NowHour, $NowMinute, $NowSecond, $NowMonth, $NowDay, $NowYear) - mktime(0, 0, 0, $NowMonth, $NowDay, $NowYear); Break;
            Default: $NowStamp = mktime($NowHour, $NowMinute, $NowSecond, $NowMonth, $NowDay, $NowYear); Break;
        }
        return $NowStamp;
    }
    
    function StampToDate($NowStamp="", $RtnType="DateTime")
    {
        if(empty($NowStamp)) $NowStamp = Mktime();
        switch($RtnType)
        {
            Case "Date": $NowDate = date("Y-m-d",$NowStamp); Break;
            Case "Time": $NowDate = date("H:i:s",$NowStamp); Break;
            Default: $NowDate = date("Y-m-d H:i:s",$NowStamp); Break;
        }
        return $NowDate;
    }

function HistoryBack( $alert = "", $exit = 1 )
    {
        echo "<script language=javascript>\n";
        if( $alert )
        {
            $alert=AddSlashes($alert);
            echo "alert('".stripslashes($alert)."');\n";
        }
        echo "history.back();\n";
        echo "</script>";
        if( $exit ) exit;
    }


//업로드 파일 난수 생성
function makeRandUpload($len=8) { 
    if(!is_int($len) || ($len < 8)) { 
        $len = 8; 
    } 
    $arr = array_merge(range(1, 9)); 


    $rand = false;  
    for($i=0; $i<$len; $i++) {  
       $rand .= $arr[mt_rand(0,count($arr)-1)];  
    }  
    return $rand; 
 }

//난수 생성
function makeRand($len=20) { 
    if(!is_int($len) || ($len < 20)) { 
        $len = 20; 
    } 
    $arr = array_merge(range('A', 'Z'), range('z', 'a'), range(1, 9)); 


    $rand = false;  
    for($i=0; $i<$len; $i++) {  
       $rand .= $arr[mt_rand(0,count($arr)-1)];  
    }  
    return $rand; 
 }

 function makeRandOrderNum($len=3) { 
    if(!is_int($len) || ($len < 3)) { 
        $len = 3; 
    } 
    $arr = array_merge(range(0, 9)); 


    $rand = false;  
    for($i=0; $i<$len; $i++) {  
       $rand .= $arr[mt_rand(0,count($arr)-1)];  
    }  
    return $rand; 
 }



//초를 넣으면 시분초로 변환
function Sec_To_His($Sec) {

//일단 시간부분 추출
$Time_hour = $Sec / 3600;
$Time_hour = floor($Time_hour);
if(strlen($Time_hour) < 2) {
    $Time_hour = "0".$Time_hour;
}
//분 부분을 추출
$Time_minute = $Sec % 3600;
$Time_minute = $Time_minute / 60;
$Time_minute = floor($Time_minute);
if(strlen($Time_minute) < 2) {
    $Time_minute = "0".$Time_minute;
}

//초 부분을 추출
$Time_second = $Sec - (($Time_hour * 3600) + ($Time_minute * 60));
if(strlen($Time_second) < 2) {
    $Time_second = "0".$Time_second;
}

$Result = $Time_hour.":".$Time_minute.":".$Time_second."";

return $Result;
}

//초를 넣으면 분으로 변환
function Sec_To_m($Sec) {


    if($Sec<60) {
        $Result = $Sec."초";
    }else{
        $Result = $Sec / 60;
        $Result = (int)$Result."분";
    }

    return $Result;
}


//비밀번호 난수 생성
function Pwd_makeRand($len=8) { 
    if(!is_int($len) || ($len < 8)) { 
        $len = 8; 
    } 
    $arr = array_merge(range(0, 9));
    //$arr = array_merge(range(1, 9), range('a', 'z')); 


    $rand = false;  
    for($i=0; $i<$len; $i++) {  
       $rand .= $arr[mt_rand(0,count($arr)-1)];  
    }  
    return $rand; 
}

//5자리 숫자난수 생성
function makeRand5($len=5) { 
    if(!is_int($len) || ($len < 5)) { 
        $len = 5; 
    } 
    $arr = array_merge(range(0, 9));
    //$arr = array_merge(range(1, 9), range('a', 'z')); 

    $rand = false;  
    for($i=0; $i<$len; $i++) {  
       $rand .= $arr[mt_rand(0,count($arr)-1)];  
    }  
    return $rand; 
}

function max_number($mf,$tb){
    global $connect;

    $query_select = "SELECT MAX($mf) FROM $tb";
    $result_select = mysqli_query($connect, $query_select);
    $row_select = mysqli_fetch_array($result_select);
    $max_no = $row_select[0];

    return $max_no + 1;
}

function max_number_package(){
    global $connect;

    $query_select = "SELECT MAX(PackageRef) FROM Course WHERE PackageYN='Y'";
    $result_select = mysqli_query($connect, $query_select);
    $row_select = mysqli_fetch_array($result_select);
    $max_no = $row_select[0];

    return $max_no + 1;
}

function DeptStringNaming($DeptString) {

    global $connect;

    $DeptString_Array = explode("|",$DeptString);

    $DeptStringName = "";

    foreach($DeptString_Array as $DeptString_value) {

        $DeptString_value2 = trim($DeptString_value);

        if($DeptString_value2) {

            $Sql = "SELECT DeptName FROM DeptStructure WHERE idx=$DeptString_value2";
            $Result = mysqli_query($connect, $Sql);
            $Row = mysqli_fetch_array($Result);
            if($Row) {
                if(!$DeptStringName) {
                    $DeptStringName = $Row['DeptName'];
                }else{
                    $DeptStringName = $DeptStringName." > ".$Row['DeptName'];
                }
            }

        }

    }

    return $DeptStringName;

}

function PackageRefLeftString($PackageRef) {

    $Ref = str_pad($PackageRef,3,'0',STR_PAD_LEFT);

    return $Ref;

}

function ReviewIDView($ID,$len) {

    $ID = substr($ID,0,3);
    $IDView = str_pad($ID,$len,'*',STR_PAD_RIGHT);

    return $IDView;

}

function StarPointView($StarPoint) {

    $StarImgOn = "<img src='/images/common/icon_review_star03.png' alt='' />";
    $StarImgOff = "<img src='/images/common/icon_review_star01.png' alt='' />";

    $StarPoint2 = "";
    for($i=0;$i<$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }

    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);

    return $Star;

}

function StarPointAVG($StarPoint) {

    $StarImgOn = "<img src='/images/common/icon_review_star03.png' />";
    $StarImgHalf = "<img src='/images/common/icon_review_star02.png' />";
    $StarImgOff = "<img src='/images/common/icon_review_star01.png' />";

    $StarPoint2 = "";
    for($i=0;$i<(int)$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }

    if(($StarPoint-(int)$StarPoint)>0) {
        $StarPoint2 .= "^";
    }

    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("^",$StarImgHalf,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);

    return $Star;

}

function MakeOrderNum($len=3) { 

    if(!is_int($len) || ($len < 3)) { 
        $len = 3; 
    } 
    $arr = array_merge(range(0, 9)); 

    $rand = false;  
    for($i=0; $i<$len; $i++) {  
        $rand .= $arr[mt_rand(0,count($arr)-1)];  
    }
    return date('YmdHi').$rand; 

}

function InformationProtection($str,$data_type,$view_mode) {

    if($view_mode=="S") {

        if($str) {

            switch ($data_type) {
                case "Email":
                    $Email_Array = explode("@",$str);
                    $Email01 = $Email_Array[0];
                    $Email02 = $Email_Array[1];
                    $str = "*******@".$Email02;
                break;
                case "Mobile":
                    $Mobile_Array = explode("-",$str);
                    $Mobile01 = $Mobile_Array[0];
                    $Mobile02 = $Mobile_Array[1];
                    $Mobile03 = $Mobile_Array[2];
                    $str = $Mobile01."-****-".$Mobile03;
                break;
                case "Mobile2":
                    $Mobile01 = substr($str, 0,3);
                    $Mobile03 = substr($str, 7,4);
                    $str = $Mobile01."-****-".$Mobile03;
                break;
                case "BirthDay":
                    $BirthDay_Array = explode("-",$str);
                    $BirthDay01 = $BirthDay_Array[0];
                    $BirthDay02 = $BirthDay_Array[1];
                    $BirthDay03 = $BirthDay_Array[2];
                    $str = $BirthDay01."-****-".$BirthDay03;
                break;
                case "Tel":
                    $Tel_Array = explode("-",$str);
                    $Tel01 = $Tel_Array[0];
                    $Tel02 = $Tel_Array[1];
                    $Tel03 = $Tel_Array[2];
                    $str = $Tel01."-****-".$Tel03;
                break;
            }

        }else{
            $str = "";
        }

        return $str;

    }else{

        return $str;

    }

}


//function StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq,$CompleteTime) {
function StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq) {

    global $connect;
    global $LoginMemberID;

    $NowDate = date('Y-m-d');
    $Sql = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.TestStatus, a.Survey, a.PassOk, a.StudyEnd, 
            b.PreviewImage, b.ContentsName, b.idx AS Course_idx, b.Mobile, b.Chapter, b.Limited, b.PassProgress, b.TotalPassMid, b.MidRate, b.TotalPassTest, b.TestRate, b.TotalPassReport, b.ReportRate, b.PassScore, b.attachFile, b.ctype, b.Professor, 
            c.CategoryName AS Category1Name, c.idx AS Category1_idx, 
            d.CategoryName AS Category2Name, d.idx AS Category2_idx, 
            e.Name AS TutorName, 
            (SELECT COUNT(idx) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode=a.LectureCode AND Study_Seq=a.Seq) AS ProgressCount, 
            (SELECT COUNT(idx) FROM PaymentSheet WHERE CompanyCode=a.CompanyCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PayStatus='Y') AS PaymentCount 
            FROM Study AS a 
            LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
            LEFT OUTER JOIN CourseCategory AS c ON b.Category1=c.idx 
            LEFT OUTER JOIN CourseCategory AS d ON b.Category2=d.idx 
            LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
            WHERE a.ID='$LoginMemberID' AND a.Seq=$Study_Seq";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);

    if($Row) {

        $ContentsName = $Row['ContentsName'];
        $ProgressCount = $Row['ProgressCount'];
        $Chapter = $Row['Chapter'];
        $Progress = $Row['Progress'];
        $PassProgress = $Row['PassProgress'];
        $MidStatus = $Row['MidStatus'];
        $MidSaveTime = $Row['MidSaveTime'];
        $MidScore = $Row['MidScore'];
        $MidRate = $Row['MidRate'];
        $TestStatus = $Row['TestStatus'];
        $TestScore = $Row['TestScore'];
        $TestRate = $Row['TestRate'];
        $TestSaveTime = $Row['TestSaveTime'];
        $ReportStatus = $Row['ReportStatus'];
        $ReportScore = $Row['ReportScore'];
        $ReportRate = $Row['ReportRate'];
        $ReportSaveTime = $Row['ReportSaveTime'];
        $Survey = $Row['Survey'];
        $ResultView = $Row['ResultView'];
        $PassOk = $Row['PassOk'];
        $StudyEnd = $Row['StudyEnd'];

    }


    $LectureStudy = "Y"; //수강가능 초기값
    $MidTestOk = "N"; //중간평가 존재여부 초기값
    $TestOk = "N"; //최종평가 존재여부 초기값
    $ReportOk = "N"; //과제 존재여부 초기값
    $SurveyView = "N"; //설문조사 노출 초기값
    $SurveyStudy = "N"; //설문조사 가능여부 초기값
    $MidTestStudy = "N";
    $TestStudy = "N";
    $ReportStudy = "N";

    $Status_msg01 = "";
    $Status_msg02 = "";
    $Status_msg03 = "";

    if($ServiceType=="3") {
        $ServiceTypeWhere = " AND a.ChapterType='A' ";
    }

    $Sql = "SELECT COUNT(*) FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='A'";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    $ChapterCount = $Row[0];

    $k = $ChapterCount;

    // Brad(2021.12.19) : 쿼리 수정 - ChapterType='A' OR 추가
    $SQL2 = "SELECT a.Seq AS Chapter_Seq, a.ChapterType, a.OrderByNum, a.Sub_idx, 
                b.Gubun AS ContentGubun, b.ContentsTitle, b.idx AS Contents_idx, b.LectureTime,
                c.Progress AS ChapterProgress, c.UserIP AS ChapterUserIP, c.RegDate AS ChapterRegDate, c.StudyTime, c.Study_Seq, 
                (SELECT Seq FROM Chapter WHERE LectureCode='$LectureCode' AND (ChapterType='A' OR ChapterType='C' OR ChapterType='D') ORDER BY OrderByNum DESC LIMIT 0,1) AS Max_Seq 
                FROM Chapter AS a 
                LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
                LEFT OUTER JOIN Progress AS c ON a.Seq=c.Chapter_Seq AND b.idx=c.Contents_idx AND c.ID='$LoginMemberID' AND c.LectureCode='$LectureCode' AND c.Study_Seq=$Study_Seq 
                WHERE a.LectureCode='$LectureCode' $ServiceTypeWhere ORDER BY a.OrderByNum DESC";
    // echo $SQL2;
    $QUERY2 = mysqli_query($connect, $SQL2);
    if($QUERY2 && mysqli_num_rows($QUERY2))
    {
        while($ROW2 = mysqli_fetch_array($QUERY2))
        {

        //강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if($ROW2['ChapterType']=="A") {

            if($ROW2['StudyTime']<1) {
                $PlayMode = "S";
            }else{
                $PlayMode = "C";
            }

            if($ROW2['ChapterProgress']==0) {
                $Status_msg01 = $k."차시";
                $Status_msg02 = "수강대기중";
                $Status_msg03 = "A#".$k."#".$LectureCode."#".$Study_Seq."#".$ROW2['Chapter_Seq']."#".$ROW2['Contents_idx']."#".$PlayMode;
            }

            // Brad (2021.12.15) : 이어보기 수정
            // if (($ROW2['ChapterProgress']>0 && $ROW2['ChapterProgress']<100) || ($ROW2['LectureTime'] > $CompleteTime)) {
            if ($ROW2['ChapterProgress']>0 && $ROW2['ChapterProgress']<100) {
                $Status_msg01 = $k."차시";
                //$Status_msg02 = Sec_To_m($ROW2['StudyTime'])." 수강중";
                $Status_msg02 = Sec_To_His($ROW2['StudyTime'])."<br>수강중";
                $Status_msg03 = "A#".$k."#".$LectureCode."#".$Study_Seq."#".$ROW2['Chapter_Seq']."#".$ROW2['Contents_idx']."#".$PlayMode;

            }

            // 23.05.01. 차시수강시간 , 총수강시간(초)
            //echo "<!-- $Study_Seq == $ROW2[Study_Seq] , $ROW2[LectureCode] , $ROW2[StudyTime] , $ROW2[LectureTime] -->";
            if ($Status_msg04=="" && $Study_Seq == $ROW2["Study_Seq"]) {
                $Status_msg04 = $ROW2['StudyTime'] . "," . $ROW2['LectureTime']*60;
            }

            $k--;
        }

        //중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if($ROW2['ChapterType']=="B") {

            $MidTestOk = "Y"; //중간평가가 존재하는 경우 Y로 설정(최종평가와 과제 응시 체크를 위해)

            if($LectureCode=="W9500") { //중간평가를 볼수 있는 진도율
                $MidTestProgress = 47; //NCS기반 병원안내 실무2 만 47%
            }else{
                $MidTestProgress = 50;
            }

            if($Progress<$MidTestProgress) { //중간평가는 진도율 50%이상만 응시가능

                $MidTest_msg = "진도부족";
                $MidTestStudy = "N";
                $LectureStudy = "N";

            }else{

                switch($MidStatus) { //중간평가 상태
                    case "C": //채점 완료
                        $MidRatePercent = $MidScore * $MidRate / 100;
                        $MidTest_msg = $MidScore."점(".$MidRatePercent ."%)";
                        $MidTestStudy = "N";
                        $LectureStudy = "Y";
                    break;
                    case "N": //미응시
                        $MidTest_msg = "응시가능";
                        $MidTestStudy = "Y";
                        $LectureStudy = "N";
                    break;
                    case "Y": //응시완료
                        $MidTest_msg = "응시완료<BR>(채점중)";
                        $MidTestStudy = "N";
                        $LectureStudy = "Y";
                    break;
                }

            }

            if($MidTestStudy=="Y") {

                $Status_msg01 = "중간평가";
                $Status_msg02 = "미응시";
                $Status_msg03 = "B#".$Study_Seq."#".$LectureCode."#".$ROW2['Chapter_Seq'];

            }



        }

        //최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if($ROW2['ChapterType']=="C") {

            $TestOk = "Y"; //최종평가가 존재하는 경우 Y로 설정(과제 응시 체크를 위해)

            if($Progress<$PassProgress) { //최종평가는 진도율이 수료기준 진도율 이상만 응시가능

                $Test_msg = "진도부족";
                $TestStudy = "N";
                $LectureStudy = "N";

            }else{

                if($MidTestOk == "Y" && $MidStatus=="N") { //중간평가가 있고 미응시 했다면 최종평가 불가

                    $Test_msg = "중간평가 미응시";
                    $TestStudy = "N";
                    $LectureStudy = "N";

                }else{

                    switch($TestStatus) { //최종평가 상태
                        case "C": //채점완료
                            $TestRatePercent = $TestScore * $TestRate / 100;
                            $Test_msg = $TestScore."점(".$TestRatePercent ."%)";
                            $TestStudy = "N";
                            $LectureStudy = "Y";
                        break;
                        case "N": //미응시
                            $Test_msg = "응시가능";
                            $TestStudy = "Y";
                            $LectureStudy = "N";
                        break;
                        case "Y": //응시완료
                            $Test_msg = "응시완료<BR>(채점중)";
                            $TestStudy = "N";
                            $LectureStudy = "Y";
                        break;
                    }

                }

                //설문을 노출시키기 위한 조건
                if(($ROW2['Max_Seq']==$ROW2['Chapter_Seq']) && ($TestStatus=="C" || $TestStatus=="Y")) {
                    $SurveyView = "Y";
                }

            }

            if($TestStudy=="Y") {

                $Status_msg01 = "최종평가";
                $Status_msg02 = "미응시";
                $Status_msg03 = "C#".$Study_Seq."#".$LectureCode."#".$ROW2['Chapter_Seq'];

            }


        }

        //과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if($ROW2['ChapterType']=="D") {

            $ReportOk = "N"; //과제가 존재하는 경우 Y로 설정

            if($Progress<$PassProgress) { //과제는 진도율이 수료기준 진도율 이상만 응시가능

                $Report_msg = "진도부족";
                $ReportStudy = "N";
                $LectureStudy = "N";

            }else{

                if($TestOk == "Y" && $TestStatus=="N") { //최종평가가 있고 미응시 했다면 과제 불가

                    $Report_msg = "최종평가 미응시";
                    $ReportStudy = "N";
                    $LectureStudy = "N";

                }else{

                    switch($ReportStatus) {
                        case "C":
                            $ReportRatePercent = $ReportScore * $ReportRate / 100;
                            $Report_msg = $ReportScore."점(".$ReportRatePercent ."%)";
                            $ReportStudy = "N";
                            $LectureStudy = "Y";
                        break;
                        case "N":
                            $Report_msg = "응시가능";
                            $ReportStudy = "Y";
                            $LectureStudy = "N";
                        break;
                        case "Y":
                            $Report_msg = "제출완료<BR>(채점중)";
                            $ReportStudy = "N";
                            $LectureStudy = "Y";
                        break;
                    }

                }

                //설문을 노출시키기 위한 조건
                if(($ROW2['Max_Seq']==$ROW2['Chapter_Seq']) && ($ReportStatus=="C" || $ReportStatus=="Y")) {
                    $SurveyView = "Y";
                }

            }

            if($ReportStudy=="Y") {

                $Status_msg01 = "과제";
                $Status_msg02 = "미응시";
                $Status_msg03 = "D#".$Study_Seq."#".$LectureCode."#".$ROW2['Chapter_Seq'];

            }


        }



        }

    }

    if($SurveyView == "Y") {

        switch($Survey) {
            case "N":
                $Survey_msg = "(미작성)";
                $SurveyStudy = "Y";
            break;
            case "Y":
                $Survey_msg = "(채점대기중)";
                $SurveyStudy = "E";
            break;
        }

        if($SurveyStudy=="Y") {

            $Status_msg01 = "설문조사";
            $Status_msg02 = $Survey_msg;
            $Status_msg03 = "E#".$Study_Seq."#".$LectureCode;

        }

        if($SurveyStudy=="E") {

            $Status_msg01 = "학습완료";
            $Status_msg02 = $Survey_msg;
            $Status_msg03 = "F#";

        }

        if($ResultView=="Y") {

            if($PassOk=="Y") {
                $Status_msg01 = "수료";
                $Status_msg02 = "";
                $Status_msg03 = "G#".$Study_Seq;
            }else{
                $Status_msg01 = "미수료";
                $Status_msg02 = "";
                $Status_msg03 = "H#";
            }

        }



    }



    return $Status_msg01."|".$Status_msg02."|".$Status_msg03."|".$Status_msg04;
    //return $ChapterCount."|";

}

?>
