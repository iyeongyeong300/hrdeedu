//공통 함수 ------------------------------------------------------------------------------------------------------

if (location.protocol == 'http:') {
	location.href = location.href.replace('http://', 'https://');
}

if (location.hostname == 'hrdeedu.com') {
 	location.href = location.href.replace(location.hostname, 'www.hrdeedu.com');
}

if (location.hostname == 'tutor.hrdeedu.com') {
 	location.href = 'https://tutor.hrdeedu.com/hrd_manager/';
}

 
if(location.hostname == "manager.hrdeedu.com")
{
	location.href = "https://manager.hrdeedu.com/hrd_manager/";
}
 

//사이트 로딩시 실행되는 함수들--------
$(document).ready(function () {
	//상단 주메뉴---------------------------------------------------------------------------
	var gnbHr = $("div[id='TopMenu']");

	gnbHr.find('>ul>li>h2').mouseover(function () {
		$("ul[id='SiteMenu1']").show();
		$("ul[id='SiteMenu2']").show();
		$("ul[id='SiteMenu3']").show();
		$("ul[id='SiteMenu4']").show();
		$("ul[id='SiteMenu5']").show();
	});

	gnbHr
		.find('>ul>li>h2>a')
		.focus(function () {
			$(this).mouseover();
		})

		.end();

	//상단 메뉴 위치에서 이탈시 메뉴 숨기기
	$("div[id='TopMenu']").mouseleave(function () {
		$("ul[id='SiteMenu1']").hide();
		$("ul[id='SiteMenu2']").hide();
		$("ul[id='SiteMenu3']").hide();
		$("ul[id='SiteMenu4']").hide();
		$("ul[id='SiteMenu5']").hide();
	});

	//상단 주메뉴-------------------------------------------------------------------------------
});
//사이트 로딩시 실행되는 함수들--------

function SiteMenuShow() {
	$("ul[id='SiteMenu1']").toggle();
	$("ul[id='SiteMenu2']").toggle();
	$("ul[id='SiteMenu3']").toggle();
	$("ul[id='SiteMenu4']").toggle();
	$("ul[id='SiteMenu5']").toggle();
}

function isMobile() {
	var filter = 'win16|win32|win64|mac|macintel';
	if (navigator.platform) {
		if (filter.indexOf(navigator.platform.toLowerCase()) < 0) {
			return true;
		} else {
			return false;
		}
	}
}

function BrowserVersionCheck() {
	var word;
	var versionOrType = 'another';

	var agent = navigator.userAgent.toLowerCase();
	var name = navigator.appName;

	/***********************************************
	 * IE인 경우 버전 체크
	 ***********************************************/
	// IE old version ( IE 10 or Lower )
	if (name == 'Microsoft Internet Explorer') {
		word = 'msie ';
		versionOrType = 'IE';
	} else {
		// IE 11
		if (agent.search('trident') > -1) {
			word = 'trident/.*rv:';
			versionOrType = 'IE';
			// IE 12  ( Microsoft Edge )
		} else if (agent.search('edge/') > -1) {
			word = 'edge/';
			versionOrType = 'Edge';
		}
	}

	/*
	var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" );
	if ( reg.exec( agent ) != null )
	versionOrType = RegExp.$1 + RegExp.$2;
	*/

	/***********************************************
	 * IE가 아닌 경우 브라우저의 종류 체크
	 ***********************************************/
	if (versionOrType == 'another') {
		if (agent.indexOf('chrome') != -1) versionOrType = 'Chrome';
		else if (agent.indexOf('opera') != -1) versionOrType = 'Opera';
		else if (agent.indexOf('firefox') != -1) versionOrType = 'Firefox';
		else if (agent.indexOf('safari') != -1) versionOrType = 'Safari';
	}

	return versionOrType;
}

/* 숫자체크*/
function IsNumber(num) {
	var x = num;
	//var anum=/(^\d+$)|(^\d+\.\d+$)/
	var anum = /(^\d+$)|(^\d+$)/;
	if (anum.test(x)) testresult = true;
	else {
		testresult = false;
	}
	return testresult;
}

function isContinuedValue(str, limit) {
	var o, d, p, n = 0, l = limit == null ? 4 : limit;
    for (var i = 0; i < str.length; i++) {
        var c = str.charCodeAt(i);
        if (i > 0 && (p = o - c) > -2 && p < 2 && (n = p == d ? n + 1 : 0) > l - 3) 
            return true;
            d = p, o = c;
    }
    return false;
	
	/*var intCnt1 = 0;
	var intCnt2 = 0;
	var temp0 = '';
	var temp1 = '';
	var temp2 = '';
	var temp3 = '';

	for (var i = 0; i < value.length - 3; i++) {
		temp0 = value.charAt(i);
		temp1 = value.charAt(i + 1);
		temp2 = value.charAt(i + 2);
		temp3 = value.charAt(i + 3);

		if (temp0.charCodeAt(0) - temp1.charCodeAt(0) == 1 && temp1.charCodeAt(0) - temp2.charCodeAt(0) == 1 && temp2.charCodeAt(0) - temp3.charCodeAt(0) == 1) {
			intCnt1 = intCnt1 + 1;
		}

		if (temp0.charCodeAt(0) - temp1.charCodeAt(0) == -1 && temp1.charCodeAt(0) - temp2.charCodeAt(0) == -1 && temp2.charCodeAt(0) - temp3.charCodeAt(0) == -1) {
			intCnt2 = intCnt2 + 1;
		}
	}

	return intCnt1 > 0 || intCnt2 > 0;
	*/
}

//한글체크
function hanCheck(ID) {
	var digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var temp;
	//alert(MemberID);
	for (i = 0; i < ID.length; i++) {
		temp = ID.substring(i, i + 1);
		if (digits.indexOf(temp) == -1) {
			return false;
		}
	}
	return true;
}

//이메일 체크
function chkEmail(str) {
	var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

	if (!reg_email.test(str)) {
		return false;
	}
	return true;
}

//페이지 이동 관련
function pageRun(num) {
	document.listScriptForm.pg.value = num;
	document.listScriptForm.submit();
}

function readRun(idx) {
	document.ReadScriptForm.idx.value = idx;
	document.ReadScriptForm.submit();
}

function MoveTop() {
	$('html, body').animate({ scrollTop: 0 }, 200);
}

//데이터 레이어 닫기
function DataResultClose() {
	$("div[id='Roading']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();
	$('html').css('overflow', '');
}

function DataResultCloseReload() {
	location.reload();
}

//로그 아웃 시간 처리
var TimeCheckNo = 'Y';

function LogOutTimeView() {
	parselimit = 7200 - parseInt(document.TimeCheckForm.NowTime.value);

	curmin = Math.floor(parselimit / 60);
	cursec = parselimit % 60;

	if (curmin < 10) {
		curmin2 = '0' + curmin;
	} else {
		curmin2 = curmin;
	}

	if (cursec < 10) {
		cursec2 = '0' + cursec;
	} else {
		cursec2 = cursec;
	}

	if (curmin != 0) {
		curtime = curmin2 + '분 ' + cursec2 + '초';
	} else {
		curtime = '00분 ' + cursec2 + '초';
	}

	//남은시간 : 145분 30초
	console.log('curtime: ', curtime);
	// $('#LogOutRemainTime').html(curtime);
}

function LogoutTimeCheck() {
	let oldTimeValue = 0;
	if (TimeCheckNo != 'N') {
		var $timer_display = $(
			"<div id='timer_display' style='position:fixed;z-index:100000;background-color:#ffffff;border:1px solid #000000;padding:10px;left:0;bottom:0;'></div>"
		);
		if (!$('#timer_display').length) $('body').append($timer_display);

		var time = document.TimeCheckForm.NowTime.value;

		var hour = Math.floor(time / 3600);
		if (!hour) hour = 0;

		var min = Math.floor(time / 60) - hour * 60;
		if (!min) min = 0; // Brad (2021.12.11) : 버그 수정

		var sec = time - min * 60 - hour * 3600;
		if (!sec) sec = 0;

		if (hour < 10) hour = '0' + hour;
		if (min < 10) min = '0' + min;
		if (sec < 10) sec = '0' + sec;

		time = hour + ':' + min + ':' + sec;

		$('#timer_display').text(time);

		if (document.TimeCheckForm.NowTime.value % 600 == 0) {
			//alert(`oldTimeValue : ${oldTimeValue}`);
			//console.log('document.TimeCheckForm.NowTime.value: ', document.TimeCheckForm.NowTime.value);
		}
		oldTimeValue = document.TimeCheckForm.NowTime.value;

		if (document.TimeCheckForm.NowTime.value > 7200) {
			location.href = '/member/logout.php';
		} else {
			document.TimeCheckForm.NowTime.value = parseInt(document.TimeCheckForm.NowTime.value) + 1;
			// LogOutTimeView(); Brad : (필요 없는 부분 주석 처리)
		}
	}
}
//공통 함수 ------------------------------------------------------------------------------------------------------

//회원가입 관련------------------------------------------------------------------------------------------------------

//전체 선택
function JoinAgreeAllCheck() {
	if ($('#AllCheck').is(':checked') == true) {
		$('#Agree01_01').prop('checked', true);
		$('#Agree01_02').prop('checked', false);
		//$('#Agree02_01').prop('checked',true);
		//$('#Agree02_02').prop('checked',false);
		$('#Agree03_01').prop('checked', true);
		$('#Agree03_02').prop('checked', false);
		$('#Agree04_01').prop('checked', true);
		$('#Agree04_02').prop('checked', false);
		$('#ACS').prop('checked', true);
		$('#Marketing').prop('checked', true);
	} else {
		$('#Agree01_01').prop('checked', false);
		$('#Agree01_02').prop('checked', false);
		//$('#Agree02_01').prop('checked',false);
		//$('#Agree02_02').prop('checked',false);
		$('#Agree03_01').prop('checked', false);
		$('#Agree03_02').prop('checked', false);
		$('#Agree04_01').prop('checked', false);
		$('#Agree04_02').prop('checked', false);
		$('#ACS').prop('checked', false);
		$('#Marketing').prop('checked', false);
	}
}

function JoinAgreeAllCheck2() {	
	if ($('#AllCheck').is(':checked') == true) {
		$('#Agree01').prop('checked', true);
		$('#Agree02').prop('checked', true);
		$('#Agree03').prop('checked', true);
		$('#Mailling').prop('checked', true);
		$('#Marketing').prop('checked', true);
	} else {
		$('#Agree01').prop('checked', false);
		$('#Agree02').prop('checked', false);
		$('#Agree03').prop('checked', false);
		$('#Mailling').prop('checked', false);
		$('#Marketing').prop('checked', false);
	}
}

function JoinAgreeCheck() {	
	if(($('#Agree01').is(':checked') == false)||($('#Agree02').is(':checked') == false)||($('#Agree03').is(':checked') == false)||($('#Mailling').is(':checked') == false)||($('#Marketing').is(':checked') == false)){
		$('#AllCheck').prop('checked', false);
	}else{
		$('#AllCheck').prop('checked', true);
	}
}


//이용약관
function JoinAgree01Check(str) {
	if (str == 'A') {
		$('#Agree01_02').prop('checked', false);
	}
	if (str == 'B') {
		$('#Agree01_01').prop('checked', false);
	}
}

//지적재산권 보호 안내
function JoinAgree02Check(str) {
	if (str == 'A') {
		$('#Agree02_02').prop('checked', false);
	}
	if (str == 'B') {
		$('#Agree02_01').prop('checked', false);
	}
}

//개인정보 수집 및 이용 동의
function JoinAgree03Check(str) {
	if (str == 'A') {
		$('#Agree03_02').prop('checked', false);
	}
	if (str == 'B') {
		$('#Agree03_01').prop('checked', false);
	}
}

//개인정보의 제3자 제공 동의
function JoinAgree04Check(str) {
	if (str == 'A') {
		$('#Agree04_02').prop('checked', false);
	}
	if (str == 'B') {
		$('#Agree04_01').prop('checked', false);
	}
}

function JoinStep(){
	
	if ($('#Agree01').is(':checked') == false) {
		alert('이용약관에 동의하여야 회원가입이 가능합니다.');
		return false;
	}
	
	if ($('#Agree02').is(':checked') == false) {
		alert('개인정보 수집 및 이용에 동의하여야 회원가입이 가능합니다.');
		return false;
	}
	if ($('#Agree03').is(':checked') == false) {
		alert('개인정보의 제3자 제공에 동의하여야 회원가입이 가능합니다.');
		return false;
	}
	
	if ($('#Mailling').is(':checked') == false) {
		alert('수강확인 SMS/알림톡/메일 발송에 동의하여야 회원가입이 가능합니다.');
		return false;
	}
	
	/*if ($('#Marketing').is(':checked') == false) {
		alert('마케팅 안내에 동의하여야 회원가입이 가능합니다.');
		return false;
	}*/
   
	return true;
}

function JoinStep01() {
	if ($('#Agree01_01').is(':checked') == false) {
		alert('이용약관에 동의하여야 회원가입이 가능합니다.');
		$('#Agree01_01').focus();
		return false;
	}
	/*
	if($("#Agree02_01").is(":checked")==false) {
		alert("지적재산권 보호 안내에 동의하여야 회원가입이 가능합니다.");
		$("#Agree02_01").focus();
		return;
	}
	*/
	if ($('#Agree03_01').is(':checked') == false) {
		alert('개인정보 수집 및 이용 동의에 동의하여야 회원가입이 가능합니다.');
		$('#Agree03_01').focus();
		return false;
	}
	if ($('#Agree04_01').is(':checked') == false) {
		alert('개인정보의 제3자 제공 동의에 동의하여야 회원가입이 가능합니다.');
		$('#Agree04_01').focus();
		return false;
	}
	if ($('#ACS').is(':checked') == false) {
		alert('수강확인 문자발송에 동의하여야 회원가입이 가능합니다.');
		$('#ACS').focus();
		return false;
	}

	return true;
}

function JoinStep02() {
	AgreeForm.submit();
}

//비밀번호 유효성 체크
//비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용해야합니다. 
function CheckPassword(str) {
	/*
	if (str.length < 8) {
		alert('비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.');
		return false;
	}

	var chk_num = str.search(/[0-9]/g);
	var chk_eng = str.search(/[a-z]/gi);
	var chk_spc = str.search(/[~!@#$%^&*]/);

	if ( (chk_num == -1 && chk_eng == -1 && chk_spc >= 0) || (chk_num > 0 && chk_eng == -1 && chk_spc == -1) || (chk_num == -1 &&chk_eng >= 0 && chk_spc == -1)) {
        alert('영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상을 사용해야 합니다.');
        return false;
	} else if ( (chk_num == -1 && chk_eng > 0 && chk_spc > 0) || (chk_num > 0 && chk_eng == -1 && chk_spc > 0) || (chk_num >= 0 &&chk_eng >= 0 && chk_spc == -1)) {
        if (str.length < 10) {
    		alert('영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상을 사용해야 합니다..');
    		return false;
        }
    } else {
        if (chk_num < 0 || chk_eng < 0 || chk_spc < 0) {
            if (str.length <= 8) {
                alert('영문, 숫자, 특수문자 3개 이상의 조합으로 8자 이상을 사용해야 합니다.');
                return false;
            }
        }
    }
	*/
	
	if (/(\w)\1\1\1\1\1/.test(str) || isContinuedValue(str, 6)) {
		alert('비밀번호에 6자 이상의 연속 또는 반복 문자 및 숫자를 사용하실 수 없습니다.');
		return false;
	}

	var pwRule1 = /^(?=.*[a-zA-Z])(?=.*[0-9]).{10,}$/;
    var pwRule2 = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-]).{10,}$/;
    var pwRule3 = /^(?=.*[0-9])(?=.*[!@#$%^*+=-]).{10,}$/;
    var pwRule4 = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,}$/;
	var pwVaild = false;

	if(str.length >= 10) {
		if(pwRule1.test(str) && (str.search(/[a-z]/ig) >= 0) && (str.search(/[0-9]/g) >= 0)) {
			pwVaild = true;
		}

		if(pwRule2.test(str) && (str.search(/[a-z]/ig) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
			pwVaild = true;
		}

		if(pwRule3.test(str) && (str.search(/[0-9]/g) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
			pwVaild = true;
		}
	} else if(str.length >= 8) {
		if(pwRule4.test(str)) {
			if((str.search(/[a-z]/ig) >= 0) && (str.search(/[0-9]/g) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
				pwVaild = true;
			}
		}
	}

	if(pwVaild==false){
		alert('비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.');
		return false;
	}
	
	return true;
}

function stck(str, limit) {
}


//아이디 유효성 검사
function ID_Validity(str) {
	if (str == '') {
		alert('아이디를 입력하세요.');
		return false;
	}
	if (str.length < 6 || str.length > 20) {
		alert('아이디는 6자이상 20자 이내로 입력하세요.');
		return false;
	}
	if (hanCheck(str) == false) {
		alert('아이디는 영문/숫자만 입력 가능합니다.');
		return false;
	}
}

//아이디 중복체크
function IDCheck() {
	var ID = $('#ID').val();

	if (ID_Validity(ID) == false) {
		return;
	}

	$("div[id='id_check_msg']").load('/member/id_check.php', { ID: ID }, function () {
		if ($('#ID_Check').val() == 'Y') {
			alert('사용 가능한 아이디입니다.');
		} else {
			alert('이미 사용중인 아이디입니다.');
		}
	});
}

function JoinCompanySearch() {
	var CompanyName = $('#CompanyName').val();

	if (CompanyName == '') {
		alert('회사명을 입력하세요.');
		return;
	}

	$("div[id='company_search_result']").load('/member/company_search.php', { CompanyName: CompanyName }, function () {});
}

function JoinCompanySearchSelect() {
	var CompanyResult = $('#CompanyResult').val();

	if (CompanyResult == '') {
		alert('소속된 회사를 선택하세요.');
		return;
	}

	CompanyResult_Arrary = CompanyResult.split('|');

	$('#CompanyCode').val(CompanyResult_Arrary[0]);
	$('#CompanyName').val(CompanyResult_Arrary[1]);

	$('#company_search_result').html('');
}

//회원가입
function MemberJoin() {
	
	if ($('#Name').val() == '') {
		alert('이름을 입력하세요.');
		$('#Name').focus();
		return;
	}

	if ($('#Mobile01').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile01').focus();
		return;
	}

	if ($('#Mobile02').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile02').focus();
		return;
	}

	if ($('#Mobile03').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile03').focus();
		return;
	}

	if (IsNumber($('#Mobile01').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile01').focus();
		return;
	}

	if (IsNumber($('#Mobile02').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile02').focus();
		return;
	}

	if (IsNumber($('#Mobile03').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile03').focus();
		return;
	}
	
	if ($('#ID').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID').focus();
		return;
	}

	if ($('#ID_Check').val() == 'N') {
		alert('아이디 중복 검색을 하세요.');
		return;
	}

	if ($('#Pwd').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd').focus();
		return;
	}

	if (CheckPassword($('#Pwd').val()) == false) {
		$('#Pwd').focus();
		return;
	}

	if ($('#Pwd2').val() == '') {
		alert('비밀번호 확인을 입력하세요.');
		$('#Pwd2').focus();
		return;
	}

	if ($('#Pwd').val() !== $('#Pwd2').val()) {
		alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
		$('#Pwd2').focus();
		return;
	}

	if ($('#Email').val() == '') {
		alert('이메일을 입력하세요.');
		$('#Email').focus();
		return;
	}

	if (chkEmail($('#Email').val()) == false) {
		alert('이메일을 정확하게 입력하세요.');
		return;
	}

	if ($('#SecurityCode').val() == '') {
		alert('보안코드를 입력하세요.');
		$('#SecurityCode').focus();
		return;
	}

	Yes = confirm('회원가입 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		JoinForm.submit();
	}
}

//회원가입 관련------------------------------------------------------------------------------------------------------

//로그인 및 아이디/비번찾기, 휴면계정 복구, 회원정보 수정-----------------------------------------------------------------------------

function LoginSubmit() {
	var checked_value = $(":radio[name='MemberType1']:checked").val();

	if (checked_value == undefined) {
		checked_value = '';
	}

	if (checked_value == '') {
		alert('회원구분을 선택하세요.');
		return;
	}

	if ($('#ID1').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID1').focus();
		return;
	}

	if ($('#Pwd1').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd1').focus();
		return;
	}

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '380px',
			left: LocWidth,
			opacity: '0.5',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	document.LoginForm.MemberType.value = checked_value;
	document.LoginForm.action = '/member/login_ok.php';
	document.LoginForm.submit();
}

function TopLoginSubmit() {
	var checked_value = $(":radio[name='MemberType']:checked").val();

	if (checked_value == undefined) {
		checked_value = '';
	}

	if (checked_value == '') {
		alert('회원구분을 선택하세요.');
		return;
	}

	if ($('#ID_top').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID_top').focus();
		return;
	}

	if ($('#Pwd_top').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd_top').focus();
		return;
	}

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '100px',
			left: LocWidth,
			opacity: '0.5',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	document.TopLoginForm.action = '/member/login_ok.php';
	document.TopLoginForm.submit();
}

//아이디 찾기
function ID_Find() {
	var checked_value = $(":radio[name='MemberType1']:checked").val();

	if (checked_value == undefined) {
		checked_value = '';
	}

	if (checked_value == '') {
		alert('회원구분을 선택하세요.');
		return;
	}

	if ($('#Name1').val() == '') {
		alert('이름을 입력하세요.');
		$('#Name1').focus();
		return;
	}

	if ($('#Mobile01_1').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile01_1').focus();
		return;
	}

	if ($('#Mobile01_2').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile01_2').focus();
		return;
	}

	if ($('#Mobile01_3').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile01_3').focus();
		return;
	}

	if (IsNumber($('#Mobile01_1').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile01_1').focus();
		return;
	}

	if (IsNumber($('#Mobile01_2').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile01_2').focus();
		return;
	}

	if (IsNumber($('#Mobile01_3').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile01_3').focus();
		return;
	}

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load(
		'/member/search_id_result.php',
		{ MemberType: checked_value, Name: $('#Name1').val(), Mobile01: $('#Mobile01_1').val(), Mobile02: $('#Mobile01_2').val(), Mobile03: $('#Mobile01_3').val() },
		function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 0 }, 500);
			$("div[id='DataResult']")
				.css({
					top: '300px',
					left: body_width / 2 - 250,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			$('html').css('overflow', 'hidden');
		}
	);
}

//비밀번호 찾기
function PWD_Find() {
	var checked_value = $(":radio[name='MemberType2']:checked").val();

	if (checked_value == undefined) {
		checked_value = '';
	}

	if (checked_value == '') {
		alert('회원구분을 선택하세요.');
		return;
	}

	if ($('#Name2').val() == '') {
		alert('이름을 입력하세요.');
		$('#Name2').focus();
		return;
	}

	if ($('#ID').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID').focus();
		return;
	}

	if ($('#Mobile02_1').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile02_1').focus();
		return;
	}

	if ($('#Mobile02_2').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile02_2').focus();
		return;
	}

	if ($('#Mobile02_3').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile02_3').focus();
		return;
	}

	if (IsNumber($('#Mobile02_1').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile02_1').focus();
		return;
	}

	if (IsNumber($('#Mobile02_2').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile02_2').focus();
		return;
	}

	if (IsNumber($('#Mobile02_3').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile02_3').focus();
		return;
	}

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '100',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load(
		'/member/search_pw_result.php',
		{
			ID: $('#ID').val(),
			MemberType: checked_value,
			Name: $('#Name2').val(),
			Mobile01: $('#Mobile02_1').val(),
			Mobile02: $('#Mobile02_2').val(),
			Mobile03: $('#Mobile02_3').val(),
		},
		function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 200 }, 500);
			$("div[id='DataResult']")
				.css({
					top: '600px',
					left: body_width / 2 - 250,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			$('html').css('overflow', 'hidden');
		}
	);
}

//휴면계정 복구
function SleepAccountRecovery() {}

//회원정보 수정
function MemberEdit() {
	if ($('#Pwd').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd').focus();
		return;
	}

	if (CheckPassword($('#Pwd').val()) == false) {
		return;
	}

	if ($('#Pwd2').val() == '') {
		alert('비밀번호 확인을 입력하세요.');
		$('#Pwd2').focus();
		return;
	}

	if ($('#Pwd').val() !== $('#Pwd2').val()) {
		alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
		$('#Pwd2').focus();
		return;
	}

	if ($('#Email').val() == '') {
		alert('이메일을 입력하세요.');
		$('#Email').focus();
		return;
	}

	if (chkEmail($('#Email').val()) == false) {
		alert('이메일을 정확하게 입력하세요.');
		return;
	}

	if ($('#Mobile01').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile01').focus();
		return;
	}

	if ($('#Mobile02').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile02').focus();
		return;
	}

	if ($('#Mobile03').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile03').focus();
		return;
	}

	if (IsNumber($('#Mobile01').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile01').focus();
		return;
	}

	if (IsNumber($('#Mobile02').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile02').focus();
		return;
	}

	if (IsNumber($('#Mobile03').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile03').focus();
		return;
	}

	Yes = confirm('회원정보를 수정하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		EditForm.submit();
	}
}

//로그인 및 아이디/비번찾기, 휴면계정 복구, 회원정보 수정-----------------------------------------------------------------------------

//게시판 관련----------------------------------------------------------------------------------------------------------------------

function BoardSearch() {
	if ($('#sw').val() == '') {
		alert('검색어를 입력하세요.');
		$('#sw').focus();
		return;
	}

	BoardSearchForm.submit();
}

function pageRun(num) {
	document.listScriptForm.pg.value = num;
	document.listScriptForm.submit();
}

function readRun(num) {
	document.ReadScriptForm.idx.value = num;
	document.ReadScriptForm.submit();
}

function FaqView(i) {
	$($("div[id='ContentElement']"))
		.not("div[id='ContentElement']:eq(" + i + ')')
		.hide();
	$("div[id='ContentElement']:eq(" + i + ')').show();
}

function CounselSubmit() {
	if ($('#Name').val() == '') {
		alert('이름을 입력하세요.');
		$('#Name').focus();
		return;
	}
	if ($('#Category').val() == '') {
		alert('문의종류를 선택하세요.');
		$('#Category').focus();
		return;
	}

	if ($('#Title').val() == '') {
		alert('제목을 입력하세요.');
		$('#Title').focus();
		return;
	}
	if ($('#Contents').val() == '') {
		alert('내용을 입력하세요.');
		$('#Contents').focus();
		return;
	}
	if ($('#SecurityCode').val() == '') {
		alert('보안코드를 입력하세요.');
		$('#SecurityCode').focus();
		return;
	}

	Yes = confirm('등록하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		CounselForm.submit();
	}
}

function SelectedEmailFn() {
	if ($('#SelectedEmail option:selected').val() == '') {
		$('#Email02').val('');
	} else {
		$('#Email02').val($('#SelectedEmail option:selected').val());
	}
}

function CounselStudySubmit() {
	if ($('#Category').val() == '') {
		alert('문의종류를 선택하세요.');
		$('#Category').focus();
		return;
	}
	if ($('#Title').val() == '') {
		alert('제목을 입력하세요.');
		$('#Title').focus();
		return;
	}
	if ($('#Contents').val() == '') {
		alert('내용을 입력하세요.');
		$('#Contents').focus();
		return;
	}

	Yes = confirm('등록하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		CounselForm.submit();
	}
}
//게시판 관련----------------------------------------------------------------------------------------------------------------------

//나의 강의실 강의 상세정보 확장하기
function LectureDetailToggle(i, OpenNotice) {
	if (OpenNotice == 'Y' && $("ul[id='LectureDetail']:eq(" + i + ')').css('display') == 'none') {
		LectureNoticeOpen(i);
	} else {
		$("ul[id='LectureDetail']:eq(" + i + ')').toggle();

		if ($("ul[id='LectureDetail']:eq(" + i + ')').css('display') == 'none') {
			$("ul[id='LectureList']:eq(" + i + ')').removeClass('show');
			$("a[id='LectureDetailOpen']:eq(" + i + ')').html('▼ 열기');
		} else {
			$("ul[id='LectureList']:eq(" + i + ')').addClass('show');
			$("a[id='LectureDetailOpen']:eq(" + i + ')').html('▲ 닫기');
		}
	}
}

function LectureNoticeOpen(i) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/lecture_notice.php', { t: i }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function LectureNoticeClose(i) {
	$("div[id='Roading']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();

	LectureDetailToggle(i, 'N');
}

//LectureList
//LectureDetail
//LectureDetailOpen

//강의 창 열기
function Play(Chapter_Number, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, mode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load(
		'/player/player.php',
		{ Chapter_Number: Chapter_Number, LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, Contents_idx: Contents_idx, mode: mode },
		function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 0 }, 100);
			$("div[id='DataResult']")
				.css({
					top: '0px',
					left: body_width / 2 - 550,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			//$('html').css("overflow","hidden");
		}
	);
}

function PlayStudyInfo(LectureCode, Contents_idx) {
	if (browser == 'Explorer') {
		top_position = 900;
		left_position = 100;
		scrollTop_position = 850;
	} else {
		top_position = 100;
		left_position = 50;
		scrollTop_position = 0;
	}

	$('#StudyInformation').load('/player/study_info.php', { LectureCode: LectureCode, Contents_idx: Contents_idx }, function () {
		$("div[id='StudyInformation']")
			.css({
				top: top_position,
				left: left_position,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2000',
			})
			.show();

		$('html, body').animate({ scrollTop: scrollTop_position }, 500);
	});
}

function PlayStudyCounsel(LectureCode, Study_Seq, Contents_idx) {
	if (browser == 'Explorer') {
		top_position = 900;
		left_position = 100;
		scrollTop_position = 850;
	} else {
		top_position = 100;
		left_position = 50;
		scrollTop_position = 0;
	}

	$('#StudyInformation').load('/player/study_counsel.php', { LectureCode: LectureCode, Study_Seq: Study_Seq, Contents_idx: Contents_idx }, function () {
		$("div[id='StudyInformation']")
			.css({
				top: top_position,
				left: left_position,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2000',
			})
			.show();

		$('html, body').animate({ scrollTop: scrollTop_position }, 500);
	});
}

function PlayStudyCounselSubmit() {
	if ($('#Category').val() == '') {
		alert('문의종류를 선택하세요.');
		$('#Category').focus();
		return;
	}
	if ($('#Title').val() == '') {
		alert('제목을 입력하세요.');
		$('#Title').focus();
		return;
	}
	if ($('#Contents').val() == '') {
		alert('내용을 입력하세요.');
		$('#Contents').focus();
		return;
	}

	Yes = confirm('등록하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		CounselForm.submit();
	}
}

function PlayInfoClose() {
	$('#StudyInformation').html('');
	$("div[id='StudyInformation']").hide();
	$('html, body').animate({ scrollTop: 0 }, 500);
}

//강의창 학습요점과 질문하기 구분
function PlayerTabView(i) {
	$($("a[id='PlayerTabLink']"))
		.not("a[id='PlayerTabLink']:eq(" + i + ')')
		.removeClass('show');
	$("a[id='PlayerTabLink']:eq(" + i + ')').addClass('show');

	$($("ul[id='PlayerTab']"))
		.not("ul[id='PlayerTab']:eq(" + i + ')')
		.hide();
	$("ul[id='PlayerTab']:eq(" + i + ')').show();
}

//종료과정 복습강의 창 열기
function RePlay(Chapter_Number, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, mode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load(
		'/player/replayer.php',
		{ Chapter_Number: Chapter_Number, LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, Contents_idx: Contents_idx, mode: mode },
		function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 0 }, 100);
			$("div[id='DataResult']")
				.css({
					top: '0px',
					left: body_width / 2 - 550,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			//$('html').css("overflow","hidden");
		}
	);
}

//강의 미리보기
function CoursePreview(LectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '100',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '400px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/player/preview_layer.php', { LectureCode: LectureCode }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 500);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.fadeIn()
			.draggable();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition + 30 }, 500);

		var CloseBtnLeft = 1200;
		CloseBtnLeft = CloseBtnLeft / 2 - 38;

		$("div[id='CloseBtn']").css({
			top: '20px',
			left: CloseBtnLeft,
			opacity: '1.0',
		});

		$('html').css('overflow', 'hidden');
	});
}

function CoursePreviewPopup(LectureCode) {
	var url = '/player/preview.php?LectureCode=' + LectureCode;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=1370, height=645');
}

function resizeIframe(fr) {
	var mPlayer_width = document.getElementById('mPlayer').contentWindow.document.body.scrollWidth;
	var mPlayer_height = document.getElementById('mPlayer').contentWindow.document.body.scrollHeight;

	if (mPlayer_width < 900) {
		mPlayer_width = 1200;
		mPlayer_height = 660;
	}

	if (mPlayer_height < 500) {
		mPlayer_height = 660;
	}

	$("iframe[id='mPlayer']").prop('width', mPlayer_width);
	$("iframe[id='mPlayer']").prop('height', mPlayer_height);

	var CloseBtnLeft = mPlayer_width;
	CloseBtnLeft = CloseBtnLeft / 2 - 38;

	$("div[id='CloseBtn']").css({
		top: '20px',
		left: CloseBtnLeft,
		opacity: '1.0',
	});
}

var PlayerFrameWidth;
var PlayerFrameHeight;

//강의창 사이즈 조절
function PlayerResize() {
	if ($('#RightWindow').css('display') == 'none') {
		PlayerWinWidth = PlayerFrameWidth + 350;
		PlayerWinHeight = PlayerFrameHeight + 60;
		resizeTo(PlayerWinWidth, PlayerWinHeight);
		$('#RightWindow').show();
		$('#PlayerResizeImg').prop('src', '../images/player/flash_btn_close.png');
		$('#PlayerResizeImg').prop('alt', '학습정보 닫기');
	} else {
		PlayerWinWidth = PlayerFrameWidth + 30;
		PlayerWinHeight = PlayerFrameHeight + 60;
		resizeTo(PlayerWinWidth, PlayerWinHeight);
		$('#RightWindow').hide();
		$('#PlayerResizeImg').prop('src', '../images/player/flash_btn_open.png');
		$('#PlayerResizeImg').prop('alt', '학습정보 보기');
	}
}

function PlayerResizeIframe(fr) {
	var mPlayer_width = document.getElementById('mPlayer').contentWindow.document.body.scrollWidth;
	var mPlayer_height = document.getElementById('mPlayer').contentWindow.document.body.scrollHeight;

	if (mPlayer_width < 900) {
		mPlayer_width = 1150;
		mPlayer_height = 660;
	}

	if (mPlayer_height < 500) {
		mPlayer_height = 660;
	}

	PlayerFrameWidth = mPlayer_width;
	PlayerFrameHeight = mPlayer_height;

	$("iframe[id='mPlayer']").prop('width', PlayerFrameWidth);
	$("iframe[id='mPlayer']").prop('height', PlayerFrameHeight);

	//PlayerWinWidth = PlayerFrameWidth + 350;
	//PlayerWinHeight = PlayerFrameHeight + 60;

	//resizeTo(PlayerWinWidth,PlayerWinHeight);
}

//초단위로 수강시간 보여주는 부분
function StudyTimeCheck() {
	var AddTime = parseInt($('#StartTime').val()) + 1;

	$('#StartTime').val(AddTime);

	StudyTimeDisplay();
}

function StudyTimeDisplay() {
	var StudyTime = parseInt($('#StartTime').val());

	curmin = Math.floor(StudyTime / 60);
	cursec = StudyTime % 60;
	curhour = Math.floor(curmin / 60);
	curmin = curmin % 60;

	if (curhour < 10) {
		curhour2 = '0' + curhour;
	} else {
		curhour2 = curhour;
	}

	if (curmin < 10) {
		curmin2 = '0' + curmin;
	} else {
		curmin2 = curmin;
	}

	if (cursec < 10) {
		cursec2 = '0' + cursec;
	} else {
		cursec2 = cursec;
	}

	curtime = curhour2 + ':' + curmin2 + ':' + cursec2;

	//$("#StudyTimeNow").val(curtime);
	$('#StudyTimeNow').html(curtime);

	//if(curhour>2) { //수강 시간이 2시간을 초과하면 강의창 종료
	//	self.close();
	//}
}

//진도체크하는 부분
function StudyProgressCheck(ProgressStep, CloseYN, ContentsURLSelect) {
	console.log('StudyProgressCheck: ', ProgressStep, CloseYN, ContentsURLSelect);
	var LastStudy = '';

	//현재 컨테츠의 위치 확인
	if ($('#MultiContentType').val() == 'N') {
		if ($('#ContentsType').val() == 'A') {
			//플레쉬인 경우
			//var page = window.frames['mPlayer'].location.pathname;
			var page = document.getElementById('mPlayer').contentWindow.location.pathname;
			LastStudy = page.replace('/contents', '');
		}
		if ($('#ContentsType').val() == 'B') {
			//동영상인 경우
			if (ContentsURLSelect == 'A') {
				LastStudy = parseInt(mPlayer.currentTime);
			} else {
				LastStudy = 30;
			}
		}
	} else {
		if (ProgressStep == 'Start') {
			LastStudy = '0';
		} else {
			LastStudy = $('#PlayNum').val();
		}
	}

	var Chapter_Number = $('#Chapter_Number').val();
	var LectureCode = $('#LectureCode').val();
	var Study_Seq = $('#Study_Seq').val();
	var Chapter_Seq = $('#Chapter_Seq').val();
	var Contents_idx = $('#Contents_idx').val();
	var ContentsDetail_Seq = $('#ContentsDetail_Seq').val();
	var ProgressTime = $('#StartTime').val();
	var CompleteTime = $('#CompleteTime').val();

	$.post(
		'/player/lecture_progress.php',
		{
			Chapter_Number: Chapter_Number,
			LectureCode: LectureCode,
			Study_Seq: Study_Seq,
			Chapter_Seq: Chapter_Seq,
			Contents_idx: Contents_idx,
			ContentsDetail_Seq: ContentsDetail_Seq,
			ProgressTime: ProgressTime,
			LastStudy: LastStudy,
			CompleteTime: CompleteTime,
			ProgressStep: ProgressStep,
		},
		function (data) {
			var parseData = $.parseJSON(data);

			//var ProgressCount_str = "Data_"+parseData.Study_Seq+"_ProgressCount";
			//var Total_Progress_str = "Data_"+parseData.Study_Seq+"_Progress";
			//var ChapterProgress_str = "Data_"+parseData.Study_Seq+"_ChapterProgress";
			//var ContinueBtn_str = "Data_"+parseData.Study_Seq+"_ContinueBtn";

			if (parseData.PassOk == 'Y') {
				//수료시 부모창 새로고침
				// location.reload(); Brad(2021.12.19) : 비환급 과정 강제 종료 수정
			}

			if (CloseYN == 'Y') {
				location.reload();
			}
		}
	);
}

//중간평가 시작
function ExamStart(Study_Seq, LectureCode, Chapter_Seq, TestType) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/player/exam_rule.php', { Study_Seq: Study_Seq, LectureCode: LectureCode, Chapter_Seq: Chapter_Seq, TestType: TestType }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 100);
		$("div[id='DataResult']")
			.css({
				top: '0px',
				left: body_width / 2 - 650,
				width: '1000px',
				height:'1000px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		//$('html').css("overflow","hidden");
	});
}


//토론방 참여
function DiscussionStart(Study_Seq, LectureCode, Chapter_Seq, TestType) {
	
	 
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
	
	$('#DataResult').load('/player/discussion_join.php', { Study_Seq: Study_Seq, LectureCode: LectureCode, Chapter_Seq: Chapter_Seq, TestType: TestType }, function () {
		$("div[id='Roading']").hide();		
		$('html, body').animate({ scrollTop: 0 }, 100);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				left: body_width / 2 - 650,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
		
		//$('html').css("overflow","hidden");
	}); 
}

function DiscussionJoin() {
	if ($('input:checkbox[id="Agree"]').is(':checked') == false) {
		alert('주의사항의 숙지여부에 체크하세요.');
		$('input:checkbox[id="Agree"]').focus();
		return;
	}

	var LectureCode = $('#LectureCode').val();
	var Study_Seq = $('#Study_Seq').val();
	var Chapter_Seq = $('#Chapter_Seq').val();
	var TestType = $('#TestType').val();
	var token = $('#token').val();

	$('#DataResult').load('/player/discussion.php', { LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, TestType: TestType, token: token }, function () {});
}
function ExamNotice() {
	if ($('input:checkbox[id="Agree"]').is(':checked') == false) {
		alert('주의사항의 숙지여부에 체크하세요.');
		$('input:checkbox[id="Agree"]').focus();
		return;
	}

	var LectureCode = $('#LectureCode').val();
	var Study_Seq = $('#Study_Seq').val();
	var Chapter_Seq = $('#Chapter_Seq').val();
	var TestType = $('#TestType').val();
	var token = $('#token').val();

	$('#DataResult').load('/player/exam.php', { LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, TestType: TestType, token: token }, function () {});
}

function SetCookieExam(sName, sValue) {
	var today = new Date();
	var expire = new Date(today.getTime() + 1000 * 60 * 60 * 2);

	document.cookie = sName + '=' + sValue + '; expires=' + expire.toGMTString() + '';
}

function GetCookieExam(sName) {
	var aCookie = document.cookie.split('; ');

	for (var i = 0; i < aCookie.length; i++) {
		var aCrumb = aCookie[i].split('=');
		if (sName == aCrumb[0]) return unescape(aCrumb[1]);
	}

	return null;
}

//평가 시간 체크
function ExamTimeView() {
	var parselimit = parseInt($('#NowExamTime').val()) - 1;
	$('#NowExamTime').val(parselimit);

	if (parselimit > -1) {
		curmin = Math.floor(parselimit / 60);
		cursec = parselimit % 60;

		if (curmin < 10) {
			curmin2 = '0' + curmin;
		} else {
			curmin2 = curmin;
		}

		if (cursec < 10) {
			cursec2 = '0' + cursec;
		} else {
			cursec2 = cursec;
		}

		if (curmin != 0) {
			curtime = curmin2 + ' : ' + cursec2;
		} else {
			curtime = '00 : ' + cursec2;
		}

		$('#ExamRemainTime').html(curtime);
	}

	if (parselimit == 0) {
		//평가시간 초과시 강제로 submit
		ExamOverTimeSubmit();
	}
}

//답안지 클릭시 해당 문제로 이동
function ExamMoveToQuestion(el) {
	$("a[id='" + el + "']").focus();
}

//객관식 문항 선택시 답안지에 표기
function Exam_ExamType_A(el) {
	var checked_value = $(":radio[name='AQ" + el + "']:checked").val();

	$('#Amark' + el).html(checked_value);

	//평가 데이타 임시 저장
	ExamTempSave();
}

function ExamTempSaveTest() {
	alert('test');
}

//단답형 문항 선택시 답안지에 표기
function Exam_ExamType_B(el) {
	var input_value = $("input[id='BQ" + el + "']").val();

	$('#Bmark' + el).html(input_value);
}

//서술형 문항 선택시 답안지에 표기
function Exam_ExamType_C(el) {
	var input_value = $("textarea[id='CQ" + el + "']").val();

	$('#Cmark' + el).html(input_value);
}

//시간 초과시 강제로 전송
function ExamOverTimeSubmit() {
	var ExamA_count = $('#ATypeEA').val(); //객관식문항수
	var ExamB_count = $('#BTypeEA').val(); //단답형 문항수
	var ExamC_count = $('#CTypeEA').val(); //서술형 문항수

	var ExamA_idx_value = '';
	var ExamB_idx_value = '';
	var ExamC_idx_value = '';
	var ExamA_answer = '';
	var ExamB_answer = '';
	var ExamC_answer = '';

	var checked_value = '';
	var input_value = '';

	k = 1;
	for (i = 1; i <= ExamA_count; i++) {
		//객관식 문항 체크

		checked_value = $(":radio[name='AQ" + i + "']:checked").val();

		if (checked_value == undefined) {
			checked_value = '';
		}

		if (ExamA_idx_value == '') {
			ExamA_idx_value = $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
			ExamA_answer = checked_value;
		} else {
			ExamA_idx_value = ExamA_idx_value + '|' + $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
			ExamA_answer = ExamA_answer + '|' + checked_value;
		}

		k++;
	}

	for (i = 1; i <= ExamB_count; i++) {
		//주관식 문항 체크

		input_value = $("textarea[name='BQ" + i + "']").val();

		if (ExamB_idx_value == '') {
			ExamB_idx_value = $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
			ExamB_answer = input_value;
		} else {
			ExamB_idx_value = ExamB_idx_value + '|' + $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
			ExamB_answer = ExamB_answer + '|' + input_value;
		}

		k++;
	}

	for (i = 1; i <= ExamC_count; i++) {
		//서술형 문항 체크

		input_value = $("textarea[name='CQ" + i + "']").val();

		if (ExamC_idx_value == '') {
			ExamC_idx_value = $("input[id='ExamC_idx']:eq(" + (i - 1) + ')').val();
			ExamC_answer = input_value;
		} else {
			ExamC_idx_value = ExamC_idx_value + '|' + $("input[id='ExamC_idx']:eq(" + (i - 1) + ')').val();
			ExamC_answer = ExamC_answer + '|' + input_value;
		}

		k++;
	}

	$('#ExamA_idx_value').val(ExamA_idx_value);
	$('#ExamB_idx_value').val(ExamB_idx_value);
	$('#ExamC_idx_value').val(ExamC_idx_value);
	$('#ExamA_answer').val(ExamA_answer);
	$('#ExamB_answer').val(ExamB_answer);
	$('#ExamC_answer').val(ExamC_answer);

	ExamForm1.submit();
}

function ExamSubmit() {
	$('#ExamBtn01').hide();
	$('#ExamBtn02').show();

	ExamForm1.submit();
}

function ExamSubmitCancel() {
	$("div[id='ResultConfirm']").hide();
}

//평가 제출하기
function ExamValueCheck() {
	var ExamA_count = $('#ATypeEA').val(); //객관식문항수
	var ExamB_count = $('#BTypeEA').val(); //단답형 문항수
	var ExamC_count = $('#CTypeEA').val(); //서술형 문항수

	var ExamA_idx_value = '';
	var ExamB_idx_value = '';
	var ExamC_idx_value = '';
	var ExamA_answer = '';
	var ExamB_answer = '';
	var ExamC_answer = '';

	var checked_value = '';
	var input_value = '';

	k = 1;
	for (i = 1; i <= ExamA_count; i++) {
		//객관식 문항 체크

		checked_value = $(":radio[name='AQ" + i + "']:checked").val();

		if (checked_value == undefined) {
			alert(k + '번 문제를 확인하세요.');
			$("a[id='Step" + k + "']").focus();
			return;
		} else {
			if (ExamA_idx_value == '') {
				ExamA_idx_value = $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
				ExamA_answer = checked_value;
			} else {
				ExamA_idx_value = ExamA_idx_value + '|' + $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
				ExamA_answer = ExamA_answer + '|' + checked_value;
			}
		}

		k++;
	}

	for (i = 1; i <= ExamB_count; i++) {
		//단답형 문항 체크

		input_value = $("input[name='BQ" + i + "']").val();

		if (input_value == '') {
			alert(k + '번 문제를 확인하세요.');
			$("a[id='Step" + k + "']").focus();
			return;
		} else {
			if (ExamB_idx_value == '') {
				ExamB_idx_value = $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
				ExamB_answer = input_value;
			} else {
				ExamB_idx_value = ExamB_idx_value + '|' + $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
				ExamB_answer = ExamB_answer + '|' + input_value;
			}
		}

		k++;
	}

	for (i = 1; i <= ExamC_count; i++) {
		//서술형 문항 체크

		input_value = $("textarea[name='CQ" + i + "']").val();

		if (input_value == '') {
			alert(k + '번 문제를 확인하세요.');
			$("a[id='Step" + k + "']").focus();
			return;
		} else {
			if (ExamC_idx_value == '') {
				ExamC_idx_value = $("input[id='ExamC_idx']:eq(" + (i - 1) + ')').val();
				ExamC_answer = input_value;
			} else {
				ExamC_idx_value = ExamC_idx_value + '|' + $("input[id='ExamC_idx']:eq(" + (i - 1) + ')').val();
				ExamC_answer = ExamC_answer + '|' + input_value;
			}
		}

		k++;
	}

	$('#ExamA_idx_value').val(ExamA_idx_value);
	$('#ExamB_idx_value').val(ExamB_idx_value);
	$('#ExamC_idx_value').val(ExamC_idx_value);
	$('#ExamA_answer').val(ExamA_answer);
	$('#ExamB_answer').val(ExamB_answer);
	$('#ExamC_answer').val(ExamC_answer);

	$("div[id='ResultConfirm']")
		.css({
			top: '400px',
			left: '400px',
			opacity: '1.0',
			position: 'absolute',
			'z-index': '2000',
		})
		.show();
}

//현재 평가 진행상황 임시 저장
function ExamTempSave() {
	var ExamA_count = $('#ATypeEA').val(); //객관식문항수
	var ExamB_count = $('#BTypeEA').val(); //단답형 문항수
	var ExamC_count = $('#CTypeEA').val(); //서술형 문항수

	var ExamA_idx_value = '';
	var ExamB_idx_value = '';
	var ExamC_idx_value = '';
	var ExamA_answer = '';
	var ExamB_answer = '';
	var ExamC_answer = '';

	var checked_value = '';
	var input_value = '';

	k = 1;
	for (i = 1; i <= ExamA_count; i++) {
		//객관식 문항 체크

		checked_value = $(":radio[name='AQ" + i + "']:checked").val();

		if (checked_value == undefined) {
			checked_value = '';
		}

		if (ExamA_idx_value == '') {
			ExamA_idx_value = $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
			ExamA_answer = checked_value;
		} else {
			ExamA_idx_value = ExamA_idx_value + '|' + $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
			ExamA_answer = ExamA_answer + '|' + checked_value;
		}

		k++;
	}

	for (i = 1; i <= ExamB_count; i++) {
		//주관식 문항 체크

		input_value = $("input[name='BQ" + i + "']").val();

		if (ExamB_idx_value == '') {
			ExamB_idx_value = $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
			ExamB_answer = input_value;
		} else {
			ExamB_idx_value = ExamB_idx_value + '|' + $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
			ExamB_answer = ExamB_answer + '|' + input_value;
		}

		k++;
	}

	for (i = 1; i <= ExamC_count; i++) {
		//서술형 문항 체크

		input_value = $("textarea[name='CQ" + i + "']").val();

		if (ExamC_idx_value == '') {
			ExamC_idx_value = $("input[id='ExamC_idx']:eq(" + (i - 1) + ')').val();
			ExamC_answer = input_value;
		} else {
			ExamC_idx_value = ExamC_idx_value + '|' + $("input[id='ExamC_idx']:eq(" + (i - 1) + ')').val();
			ExamC_answer = ExamC_answer + '|' + input_value;
		}

		k++;
	}

	$('#ExamA_idx_value').val(ExamA_idx_value);
	$('#ExamB_idx_value').val(ExamB_idx_value);
	$('#ExamC_idx_value').val(ExamC_idx_value);
	$('#ExamA_answer').val(ExamA_answer);
	$('#ExamB_answer').val(ExamB_answer);
	$('#ExamC_answer').val(ExamC_answer);

	var LectureCode = $('#LectureCode').val();
	var Study_Seq = $('#Study_Seq').val();
	var Chapter_Seq = $('#Chapter_Seq').val();
	var TestType = $('#TestType').val();
	var ATypeEA = $('#ATypeEA').val();
	var BTypeEA = $('#BTypeEA').val();
	var CTypeEA = $('#CTypeEA').val();

	$.post(
		'/player/exam_temp_save.php',
		{
			LectureCode: LectureCode,
			Study_Seq: Study_Seq,
			Chapter_Seq: Chapter_Seq,
			TestType: TestType,
			ATypeEA: ATypeEA,
			BTypeEA: BTypeEA,
			CTypeEA: CTypeEA,
			ExamA_idx_value: ExamA_idx_value,
			ExamB_idx_value: ExamB_idx_value,
			ExamC_idx_value: ExamC_idx_value,
			ExamA_answer: ExamA_answer,
			ExamB_answer: ExamB_answer,
			ExamC_answer: ExamC_answer,
		},
		function (data) {}
	);
}

//설문조사 참여
function SurveyStart(Study_Seq, LectureCode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/player/survey_take.php', { Study_Seq: Study_Seq, LectureCode: LectureCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 200);
		$("div[id='DataResult']")
			.css({
				top: '50px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		//$('html').css("overflow","hidden");
	});
}

//설문문항 체크
function SurveyValueCheck() {
	var ExamA_count = $('#ATypeEA').val(); //객관식문항수
	var ExamB_count = $('#BTypeEA').val(); //주관식 문항수

	var ExamA_idx_value = '';
	var ExamB_idx_value = '';
	var ExamA_answer = '';
	var ExamB_answer = '';

	var checked_value = '';
	var input_value = '';

	k = 1;
	for (i = 1; i <= ExamA_count; i++) {
		//객관식 문항 체크

		checked_value = $(":radio[name='AQ" + i + "']:checked").val();

		if (checked_value == undefined) {
			alert(k + '번 설문을 확인하세요.');
			return;
		} else {
			if (ExamA_idx_value == '') {
				ExamA_idx_value = $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
				ExamA_answer = checked_value;
			} else {
				ExamA_idx_value = ExamA_idx_value + '|' + $("input[id='ExamA_idx']:eq(" + (i - 1) + ')').val();
				ExamA_answer = ExamA_answer + '|' + checked_value;
			}
		}

		k++;
	}

	for (i = 1; i <= ExamB_count; i++) {
		//주관식 문항 체크

		input_value = $("textarea[name='BQ" + i + "']").val();

		if (input_value == '') {
			alert(k + '번 설문을 확인하세요.');
			return;
		} else {
			if (ExamB_idx_value == '') {
				ExamB_idx_value = $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
				ExamB_answer = input_value;
			} else {
				ExamB_idx_value = ExamB_idx_value + '|' + $("input[id='ExamB_idx']:eq(" + (i - 1) + ')').val();
				ExamB_answer = ExamB_answer + '|' + input_value;
			}
		}

		k++;
	}

	$('#ExamA_idx_value').val(ExamA_idx_value);
	$('#ExamB_idx_value').val(ExamB_idx_value);
	$('#ExamA_answer').val(ExamA_answer);
	$('#ExamB_answer').val(ExamB_answer);

	Yes = confirm('작성한 설문을 제출 하시겠습니까?');
	if (Yes == true) {
		$('#SurveyBtn01').hide();
		$('#SurveyBtn02').show();

		SurveyForm1.submit();
	}
}

function ReviewReg(Study_Seq, LectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/review_reg.php', { Study_Seq: Study_Seq, LectureCode: LectureCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function ReviewStarPoint(Point) {
	if (Point == 1) {
		$('#StarPoint1').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint2').prop('src', '/images/common/icon_review_star01.png');
		$('#StarPoint3').prop('src', '/images/common/icon_review_star01.png');
		$('#StarPoint4').prop('src', '/images/common/icon_review_star01.png');
		$('#StarPoint5').prop('src', '/images/common/icon_review_star01.png');
	}
	if (Point == 2) {
		$('#StarPoint1').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint2').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint3').prop('src', '/images/common/icon_review_star01.png');
		$('#StarPoint4').prop('src', '/images/common/icon_review_star01.png');
		$('#StarPoint5').prop('src', '/images/common/icon_review_star01.png');
	}
	if (Point == 3) {
		$('#StarPoint1').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint2').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint3').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint4').prop('src', '/images/common/icon_review_star01.png');
		$('#StarPoint5').prop('src', '/images/common/icon_review_star01.png');
	}
	if (Point == 4) {
		$('#StarPoint1').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint2').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint3').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint4').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint5').prop('src', '/images/common/icon_review_star01.png');
	}
	if (Point == 5) {
		$('#StarPoint1').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint2').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint3').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint4').prop('src', '/images/common/icon_review_star02.png');
		$('#StarPoint5').prop('src', '/images/common/icon_review_star02.png');
	}

	$('#StarPoint').val(Point);
}

function ReviewSubmitOk() {
	if ($('#StarPoint').val() == 0) {
		alert('별점을 선택하세요.');
		return;
	}
	if ($('#Contents').val() == '') {
		alert('수강후기를 작성하세요.');
		return;
	}
	if ($('#Contents').val().length > 250) {
		alert('수강후기는 250자 이내로 작성하세요.');
		return;
	}

	Yes = confirm('작성한 수강후기를 등록하시겠습니까?');
	if (Yes == true) {
		ReviewForm.submit();
	}
}

function LectureRequest(LectureCode, Price) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/include/lecture_request.php', { LectureCode: LectureCode, Price: Price }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 200,
				left: body_width / 2 - 20,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function LectureRequestCancel(idx) {
	Yes = confirm('수강 신청을 취소하시겠습니까?');
	if (Yes == true) {
		$.post('/mypage/lecture_request_cancel.php', { idx: idx }, function (data) {
			if (data == 'Login') {
				LoginYes = confirm('로그인후에 수강신청이 가능합니다.\n\n로그인 하시겠습니까?');
				if (LoginYes == true) {
					//location.href = '/member/login.php';
					location.href = '/new/member/login.html';
				}
			} else if (data == 'Success') {
				alert('수강 신청 취소가 완료되었습니다.');
				location.reload();
			} else {
				alert('수강 신청 취소중 오류가 발생했습니다.');
			}
		});
	}
}

function LectureRequestChange(idx, LectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/refund/lecture_request_change.php', { LectureCode: LectureCode, idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function LogInCheck() {
	$.post(
		'/member/login_check.php',
		{
			t: '1',
		},
		function (data, status) {
			if (data == 'O') {
				alert('세션이 만료되어 로그아웃 처리됩니다.');
				location.href = '/member/logout.php';
			}
			if (data == 'N') {
				alert('다른 기기에서 로그인하여 로그아웃 처리됩니다.');
				location.href = '/member/logout.php';
			}
		}
	);
}

function LogInCheckStudy() {
	$.post(
		'/member/login_check.php',
		{
			t: '1',
		},
		function (data, status) {
			if (data != 'Y') {
				alert('세션이 만료되어 로그아웃 처리됩니다.');
				location.href = '/member/logout.php';
			}
		}
	);
}

function MainNewsList(i) {
	if (i == 0) {
		$("div[id='NewsList']:eq(0)").show();
		$("div[id='NewsList']:eq(1)").hide();
	}

	if (i == 1) {
		$("div[id='NewsList']:eq(0)").hide();
		$("div[id='NewsList']:eq(1)").show();
	}
}

function MainLectureView(page) {
	$('#MainLecture').load('/main/main_lecture_list.php', { page: page }, function () {});
}

function PayMentOpen_LG(pay_idx, CompanyCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mypage/pay_request_lg.php', { pay_idx: pay_idx, CompanyCode: CompanyCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function ManagerCourseCheck(LectureStart, LectureEnd, LectureCode) {
	var currentWidth = $(window).width();
	var currentHeight = $(window).height();

	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var url = '/mypage/manager_trainee_list.php?LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&LectureCode=' + LectureCode;
	window.open(url, 'manager_check', 'scrollbars=yes, resizable=no, top=0, left=0, width=' + currentWidth + ', height=' + currentHeight);
}

function MarketingAgree(ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '400px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/marketing_agree.php', { ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 300 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '450px',
				left: body_width / 2 - 300,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function MarketingAgreeSubmit(Marketing, ID) {
	$('#DataResult').load('/mylecture/marketing_agree_script.php', { ID: ID, Marketing: Marketing }, function () {
		location.reload();
	});
}

//수료증
function CertificatePrint(Seq) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '400px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mypage/certificate_layer.php', { Seq: Seq }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 300);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 200,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.fadeIn();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition + 30 }, 300);

		$('html').css('overflow', 'hidden');
	});
}

function CertificatePrintPage(Seq) {
	var url = '/mypage/certificate_print01.php?Seq=' + Seq;
	window.open(url, 'certi', 'scrollbars=yes, resizable=no, left=400, width=820, height=700');
}

function StudyCorrectResult(Study_Seq, TestType) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/player/study_correct_result.php', { Study_Seq: Study_Seq, TestType: TestType }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 100);
		$("div[id='DataResult']")
			.css({
				top: '50px',
				left: body_width / 2 - 400,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		//$('html').css("overflow","hidden");
	});
}

function UploadFile(Expl, File) {
	$('#ExamEtc').load('/player/upload_file.php', { Expl: Expl, File: File }, function () {
		$("div[id='ExamEtc']")
			.css({
				top: '400px',
				left: '400px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2000',
			})
			.show();
	});
}

function UploadFileClose() {
	$("div[id='ExamEtc']").html('');
	$("div[id='ExamEtc']").hide();
}

function UploadFileSubmitOk() {
	if ($('#file').val() == '') {
		alert('파일을 선택하세요.');
		$('#file').focus();
		return;
	}

	Yes = confirm('업로드 하시겠습니까?');
	if (Yes == true) {
		$("p[id='UpBtn01']").hide();
		$("p[id='UpBtn02']").show();
		UploadForm1.submit();
	}
}

function UploadFileDelete(Expl, File) {
	$('#' + File).val('');
	$('#' + Expl).html('과제 제출에 필요한 파일을 업로드 하세요.');
	ExamTempSave();
}

function MemberRemark() {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/member_remark.php', { t: '1' }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function MemberRemarkSubmit() {
	Yes = confirm('저장하시겠습니까?');
	if (Yes == true) {
		RemarkForm.submit();
	}
}

function Message() {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/message.php', { t: '1' }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function Message2() {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/message2.php', { t: '1' }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function MessageRegist() {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/message_write.php', { t: '1' }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function MessageSubmit() {
	if ($('#Title').val() == '') {
		alert('쪽지 제목을 입력하세요.');
		$('#Title').focus();
		return;
	}
	if ($('#Message').val() == '') {
		alert('쪽지 내용을 입력하세요.');
		$('#Message').focus();
		return;
	}

	Yes = confirm('쪽지를 발송하시겠습니까?');
	if (Yes == true) {
		MessageForm.submit();
	}
}

function MessageView(Seq) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/message_view.php', { Seq: Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function MessageView2(Seq) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mylecture/message_view2.php', { Seq: Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function MessageDelete(Seq, DeleteType) {
	Yes = confirm('삭제하시겠습니까?');

	if (Yes == true) {
		$.post('/mylecture/message_delete.php', { Seq: Seq, DeleteType: DeleteType }, function (data) {
			if (data == 'Y') {
				if (DeleteType == 'ReciveDelete') {
					Message();
				}
				if (DeleteType == 'SendDelete') {
					Message2();
				}
			} else {
				alert('삭제에 실패하였습니다.\n\n잠시후 다시 이용하여 주세요.');
			}
		});
	}
}

function MultiContentsView(Chapter_Number, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, ContentsDetail_Seq, PlayNum) {
	$('#MultiContents').load(
		'/player/player_multi.php',
		{
			Chapter_Number: Chapter_Number,
			LectureCode: LectureCode,
			Study_Seq: Study_Seq,
			Chapter_Seq: Chapter_Seq,
			Contents_idx: Contents_idx,
			ContentsDetail_Seq: ContentsDetail_Seq,
			PlayNum: PlayNum,
		},
		function () {}
	);
}

function MultiPlayerExamType01Result() {
	var radioVal = $("input[name='Answer']:checked").val();

	if (radioVal == undefined) {
		alert('정답을 선택하세요.');
	} else {
		$('#MultiPlayerExamType01_01').hide();
		$('#MultiPlayerExamType01_02').show();
	}
}

function MultiPlayerExamType02Result() {
	if ($('#Answer2').val() == '') {
		alert('정답을 입력하세요.');
		$('#Answer2').focus();
		return;
	}

	$('#MultiPlayerExamType02_01').hide();
	$('#MultiPlayerExamType02_02').show();
}

function PayResult(pay_idx, CompanyCode) {
	var url = '/mypage/payment_result.php?pay_idx=' + pay_idx + '&CompanyCode=' + CompanyCode;
	window.open(url, 'result', 'scrollbars=no, resizable=no, left=400, width=550, height=600');
}

function PassFirstChange(ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '2000',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '200px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '2000',
		})
		.show();

	$('#DataResult').load('/mypage/pass_first_change.php', { ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				left: '250px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2100',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function PassFirstChangeSubmit() {
	if ($('#PwdChange').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#PwdChange').focus();
		return;
	}

	if (CheckPassword($('#PwdChange').val()) == false) {
		return;
	}

	if ($('#PwdChange2').val() == '') {
		alert('비밀번호 확인을 입력하세요.');
		$('#PwdChange2').focus();
		return;
	}

	if ($('#PwdChange').val() !== $('#PwdChange2').val()) {
		alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
		$('#PwdChange2').focus();
		return;
	}

	FirstPassForm.submit();
}

function PayResult2(pay_idx, ID) {
	var url = '/mypage/payment2_result.php?pay_idx=' + pay_idx + '&ID=' + ID;
	window.open(url, 'result', 'scrollbars=no, resizable=no, left=400, width=550, height=600');
}

function PayMentBankInfo2(pay_idx, ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/mypage/pay_bank_info2.php', { pay_idx: pay_idx, ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function PayMentOpen2_LG(pay_idx, ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1000;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	var pay_request_page = 'pay_request2_lg.php'; //LG유플러스 결제

	$('#DataResult').load('/mypage/' + pay_request_page, { pay_idx: pay_idx, ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '200px',
				left: body_width / 2 - 250,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function SimpleAsk() {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop() + 200;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load('/member/simple_ask.php', { t: '1' }, function () {
		//$('html, body').animate({ scrollTop : 0 }, 300);
		$("div[id='DataResult']")
			.css({
				top: ScrollPosition,
				left: body_width / 2 - 260,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function SimpleAskSubmit() {
	if ($('#Name').val() == '') {
		alert('이름을 입력하세요.');
		$('#Name').focus();
		return;
	}

	if ($('#Phone01').val() == '') {
		alert('전화번호를 입력하세요.');
		$('#Phone01').focus();
		return;
	}

	if ($('#Phone02').val() == '') {
		alert('전화번호를 입력하세요.');
		$('#Phone02').focus();
		return;
	}

	if ($('#Phone03').val() == '') {
		alert('전화번호를 입력하세요.');
		$('#Phone03').focus();
		return;
	}

	if (IsNumber($('#Phone01').val()) == false) {
		alert('전화번호는 숫자만 입력하세요.');
		$('#Phone01').focus();
		return;
	}

	if (IsNumber($('#Phone02').val()) == false) {
		alert('전화번호는 숫자만 입력하세요.');
		$('#Phone02').focus();
		return;
	}

	if (IsNumber($('#Phone03').val()) == false) {
		alert('전화번호는 숫자만 입력하세요.');
		$('#Phone03').focus();
		return;
	}

	if ($('#Email').val() == '') {
		alert('이메일을 입력하세요.');
		$('#Email').focus();
		return;
	}

	if ($('#Contents').val() == '') {
		alert('내용을 입력하세요.');
		$('#Contents').focus();
		return;
	}

	if ($('input:checkbox[id="privacy"]').is(':checked') == false) {
		alert('개인정보수집방침 동의에 체크하세요.');
		$('input:checkbox[id="privacy"]').focus();
		return;
	}

	if ($('#SecurityCode').val() == '') {
		alert('보안코드를 입력하세요.');
		$('#SecurityCode').focus();
		return;
	}

	Yes = confirm('등록하시겠습니까?');
	if (Yes == true) {
		SimpleAskForm.submit();
	}
}

function LoginCheck() {
	alert('로그인후 이용하세요.');
}

function StudyPDS_Scrap(idx, mode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	if (mode == 'Regist') {
		msg = '현재 학습자료를 찜 하시겠습니까?';
	} else {
		msg = '현재 학습자료를 찜 취소 하시겠습니까?';
	}

	Yes = confirm(msg);
	if (Yes == true) {
		$("div[id='SysBg_Black']")
			.css({
				width: body_width,
				height: body_height,
				opacity: '0.4',
				position: 'absolute',
				'z-index': '99',
			})
			.show();

		$("div[id='Roading']")
			.css({
				top: '350px',
				left: LocWidth,
				opacity: '0.6',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$('#DataResult').load('/support/edudata_scrap.php', { idx: idx, mode: mode }, function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 0 }, 500);
			$("div[id='DataResult']")
				.css({
					top: '200px',
					left: body_width / 2 - 250,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			$('html').css('overflow', 'hidden');
		});
	}
}

function CoursePriceDetail(LectureCode) {
	var y = $('#CoursePriceDetailA').offset().top - 100;

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load('/include/course_price.php', { LectureCode: LectureCode }, function () {
		$('html, body').animate({ scrollTop: 0 }, 300);
		$("div[id='DataResult']")
			.css({
				top: y,
				left: body_width / 2,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

function PlayDenyClose() {
	$("div[id='Roading']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();
	$('html').css('overflow', '');
}

function PlayStudyAuth(Chapter_Number, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, mode, EvalCd) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1500;
	var ScrollPosition = $(window).scrollTop() + 500;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load(
		'/player/play_study_auth.php',
		{ Chapter_Number: Chapter_Number, LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, Contents_idx: Contents_idx, mode: mode, EvalCd:EvalCd},
		function () {
			//$('html, body').animate({ scrollTop : 0 }, 300);
			$("div[id='DataResult']")
				.css({
					top: '300px',
					left: body_width / 2 - 260,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			//$('html').css("overflow","hidden");
		}
	);
}

function PlayStudyOTPAuth(Chapter_Number, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, mode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1500;
	var ScrollPosition = $(window).scrollTop() + 500;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load(
		'/player/player_otp_captcha_box.php',
		{ Chapter_Number: Chapter_Number, LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, Contents_idx: Contents_idx, mode: mode },
		function () {
			//$('html, body').animate({ scrollTop : 0 }, 300);
			$("div[id='DataResult']")
				.css({
					top: '100px',
					left: body_width / 2 - 500,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			//$('html').css("overflow","hidden");
		}
	);
}

//맞춤형 동영상 보충학습
function MidExamStudy(Study_Seq, LectureCode, Chapter_Seq, MovieNumber) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '400px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/player/mid_exm_study.php', { Study_Seq: Study_Seq, LectureCode: LectureCode, Chapter_Seq: Chapter_Seq, MovieNumber: MovieNumber }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 500);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 100,
				left: body_width / 2 - 500,
				height: '600px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.fadeIn();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition + 30 }, 500);
	});
}

function CertificatePrintMulti(CompanyCode, LectureStart, LectureEnd, LectureCode, ServiceTypeYN, CertificatePrintOK) {
	if (CertificatePrintOK == 'N') {
		alert('수강마감 이후에 수료증 출력이 가능합니다.');
		return;
	}

	var url =
		'/mypage/certificate_pdf02.php?CompanyCode=' +
		CompanyCode +
		'&LectureStart=' +
		LectureStart +
		'&LectureEnd=' +
		LectureEnd +
		'&ServiceTypeYN=' +
		ServiceTypeYN +
		'&LectureCode=' +
		LectureCode;
	window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function CertMethodView(str) {
	if (str == 'MobileCert') {
		$('#MobileCert').show();
		$('#IPINCert').hide();
		$('html, body').animate({ scrollTop: 700 }, 500);
	}
	if (str == 'IPINCert') {
		$('#MobileCert').hide();
		$('#IPINCert').show();
		$('html, body').animate({ scrollTop: 700 }, 500);
	}
}
