<?php

require __DIR__. "/config.php";
require __DIR__. "/common.php";

header("content-type:text/html; charset=utf-8");


## DB Connect

$db['host'] ="222.239.103.77";
$db['user'] = "assetlms";
$db['pass'] = "assetlms#59";
$db['db'] = "HRDLMS";

$DB_Enc_Key = "ek3434!";

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

$SiteCode = "HRD";

$SiteName = "HRD에셋";
$CertSiteName = "HRD에셋교육원";
$UPLOAD_DIR = "/home/LMS/upload";

$SiteEmail = "info@ek3434.com";
$SitePhone = "1644-3434";
$SiteFax = "0505-309-9090";
$SiteAddress = "서울시 금천구 가산디지털1로 219 벽산디지털밸리 6차 303~6호";

$SiteURL = $Protocol_SSL."www.hrdassetedu.com";
$MobileSiteURL = $Protocol_SSL."m.hrdassetedu.com";

$MobileAuthURL = $Protocol_SSL."m.hrdassetedu.com/"; //모바일 인증 도메인
$FlashServerURL = $Protocol_SSL."www.hrdassetedu.com/contents";
$MovieServerURL = $Protocol_SSL."www.hrdassetedu.com/contents";
$MobileServerURL = $Protocol_SSL."www.hrdassetedu.com/contents";


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
$headers = "";

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
	"D" => "과제"
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
	"mtm" => "T20190131-6|[이엘에듀] 1:1문의 답변이 등록되었습니다. 확인 부탁드립니다. (나의강의실-상담신청내역)", //1:1 문의 답변 등록 알림

	"cronAuth" => "T20190131-4|#{이름} 수강생님! 안녕하세요? 이엘에듀입니다.
법정의무교육 담당기관인 노동부 교육방침에 따라 본인인증 절차가 강화 되었습니다.
수강을 위한 필수사항이니 바쁘시더라도 #{날짜}까지 꼭 본인인증을 하셔야 합니다.
본인인증 방법은 아래 링크를 클릭하시면 바로 인증되며 본인인증 이후 수강 할 수 있습니다.
미인증시는 수강이 불가합니다.
#{인증URL}", //오전9시 10분 cron 자동발송 - 개강 다음날에 발송

	"cronStart1" => "T20190131-1|안녕하세요. 이엘에듀입니다. 신청하신 교육에 대한 개강 안내를 드립니다.

[#{회사명}] #{소속업체명} 인터넷교육이 #{시작일} 시작되었습니다!

접속 정보 : 학습사이트:#{도메인} 아이디:#{아이디} 초기비밀번호:1111 

(본 메세지는 #{소속업체명} 사업주께서 저희 교육기관에 인터넷교육을 신청하여 안내드리는 내용입니다.)", //오전9시 10분 cron 자동발송- 비환급, 개강 당일

	"cronStart2" => "T20190131-3|안녕하세요. 이엘에듀입니다. 신청하신 교육에 대한 개강 안내를 드립니다.
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
	"cronStart1" => "hrd-01|[EK티쳐] 근로자 환급과정 HRD 개강시작 / 강의수강사이트 http://hrd.ek3434.com 휴대폰 본인인증 필요!!", //오전10시 근로자훈련과정 개강 당일

	"cronStart2" => "hrd-02|[EK티쳐] 근로자 환급과정 HRD 수업시작 / 1일 최대8주차 수강가능 / 수강 시 휴대폰 본인인증 필수!!", //근로자훈련과정 개강 당일

	"cronProgress00" => "hrd-03|[EK티쳐] HRD 0%미만 수강 중 /  http://hrd.ek3434.com 로그인 후 기간 확인하시어 수강 부탁드립니다.", //근로자훈련과정 ▶ 0% 미만 : 개강 후 7일차

	"cronProgress30" => "hrd-04|[EK티쳐]현재 진도율 HRD 30%미만 / 기간 확인하시어 수강 부탁드립니다.", //근로자훈련과정 ▶ 30% 미만 : 개강 후 14일차

	"cronProgress50" => "hrd-05|[EK티쳐]현재 진도율 HRD 50%미만 / 기간 확인하시어 수강 부탁드립니다. / 전체 진도율 50%이상 시 중간평가 응시 가능합니다.", //근로자훈련과정 ▶ 50% 미만 : 개강 후 28일차

	"cronProgress80" => "hrd-06|[EK티쳐]현재 진도율 HRD 80%미만 / 수강종료일 확인하시어 수강부탁드립니다.", //근로자훈련과정 ▶ 80% 미만 : 개강 후 42일차

	"cronProgressLast" => "hrd-07|[EK티쳐]전체 진도율 80% 이상 / 최종평가 응시가능 / 수강종료일 확인 후 최종평가 및 강의 수강 부탁드립니다.", //근로자훈련과정 ▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송

	"cronProgressEnd" => "hrd-09|[EK티쳐] 금일 근로자 환급과정 HRD 수강이 종료되었습니다. 수고많으셨습니다. 감사합니다." //근로자훈련과정 ▶ 수강종료 : 60일차 ( 종강 당일 )

);
reset($Work_kakaotalk_array);

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
				$TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
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


		$TRAN_SENDER_KEY = "bc54308732b7789e673004d47b4e6a5ce75110b1"; //발신프로필키
		$TRAN_CALLBACK = "18116552"; //발신번호
		$TRAN_PHONE = $msg_mobile; //수신번호
		$TRAN_SUBJECT = "이엘에듀입니다"; //MMS전환시 문자 제목
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


		$TRAN_SENDER_KEY = "bc54308732b7789e673004d47b4e6a5ce75110b1"; //발신프로필키
		$TRAN_CALLBACK = "18116552"; //발신번호
		$TRAN_PHONE = $msg_mobile; //수신번호
		$TRAN_SUBJECT = "EK티쳐입니다"; //MMS전환시 문자 제목
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

	global $headers;

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
function mts_mms_send($phone,$msg,$callback,$etc1) {

	global $connect;

	if($phone) {

		$query = "INSERT INTO MTS_MMS_MSG(TRAN_PHONE,TRAN_CALLBACK,TRAN_MSG,TRAN_DATE, TRAN_TYPE, TRAN_ETC1) VALUES ('$phone','$callback','$msg',now(), 4,'$etc1')";
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


//##########################################################


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
?>
