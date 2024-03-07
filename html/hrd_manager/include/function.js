if (location.protocol == 'http:') {
	location.href = location.href.replace('http://', 'https://');
}

function MM_swapImgRestore() {
	//v3.0
	var i,
		x,
		a = document.MM_sr;
	for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
}

function MM_preloadImages() {
	//v3.0
	var d = document;
	if (d.images) {
		if (!d.MM_p) d.MM_p = new Array();
		var i,
			j = d.MM_p.length,
			a = MM_preloadImages.arguments;
		for (i = 0; i < a.length; i++)
			if (a[i].indexOf('#') != 0) {
				d.MM_p[j] = new Image();
				d.MM_p[j++].src = a[i];
			}
	}
}

function MM_findObj(n, d) {
	//v4.01
	var p, i, x;
	if (!d) d = document;
	if ((p = n.indexOf('?')) > 0 && parent.frames.length) {
		d = parent.frames[n.substring(p + 1)].document;
		n = n.substring(0, p);
	}
	if (!(x = d[n]) && d.all) x = d.all[n];
	for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
	for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
	if (!x && d.getElementById) x = d.getElementById(n);
	return x;
}

function MM_swapImage() {
	//v3.0
	var i,
		j = 0,
		x,
		a = MM_swapImage.arguments;
	document.MM_sr = new Array();
	for (i = 0; i < a.length - 2; i += 3)
		if ((x = MM_findObj(a[i])) != null) {
			document.MM_sr[j++] = x;
			if (!x.oSrc) x.oSrc = x.src;
			x.src = a[i + 2];
		}
}

function MM_openBrWindow(theURL, winName, features) {
	//v2.0
	window.open(theURL, winName, features);
}

/*세자리마다 자릿수 찍기*/
function FormatNumber2(num) {
	if (isNaN(num)) {
		alert('문자는 사용할 수 없습니다.');
		return 0;
	}
	if (num == 0) return num;
	temp = new Array();
	fl = '';
	co = 3;
	if (num < 0) {
		num = num * -1;
		fl = '-';
	}
	num = new String(num);
	num_len = num.length;
	while (num_len > 0) {
		num_len = num_len - co;
		if (num_len < 0) {
			co = num_len + co;
			num_len = 0;
		}
		temp.unshift(num.substr(num_len, co));
	}
	return fl + temp.join(',');
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

function IsNumber2(num) {
	var x = num;
	var anum = /(^\d+$)|(^\d+\.\d+$)/;
	if (anum.test(x)) testresult = true;
	else {
		testresult = false;
	}
	return testresult;
}

//한글체크
function hanCheck(ID) {
	var digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var temp;
	for (i = 0; i < ID.length; i++) {
		temp = ID.substring(i, i + 1);
		if (digits.indexOf(temp) == -1) {
			return false;
		}
	}
	return true;
}

//과정코드체크
function LectureCodeCheck(LectureCode) {
	var digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	var temp;
	for (i = 0; i < LectureCode.length; i++) {
		temp = LectureCode.substring(i, i + 1);
		if (digits.indexOf(temp) == -1) {
			return false;
		}
	}
	return true;
}

/* 라이오 버튼 체크 */
function hasCheckedRadio(input) {
	if (input.length > 1) {
		for (var inx = 0; inx < input.length; inx++) {
			if (input[inx].checked) return true;
		}
	} else {
		if (input.checked) return true;
	}
	return false;
}

function fn_jumin_validate(num1, num2) {
	//내국인인 경우
	if (num2.substring(0, 1) == '1' || num2.substring(0, 1) == '2' || num2.substring(0, 1) == '3' || num2.substring(0, 1) == '4') {
		var arrNum1 = new Array(); // 주민번호 앞자리숫자 6개를 담을 배열
		var arrNum2 = new Array(); // 주민번호 뒷자리숫자 7개를 담을 배열

		// -------------- 주민번호 -------------
		for (var i = 0; i < num1.length; i++) {
			arrNum1[i] = num1.charAt(i);
		} // 주민번호 앞자리를 배열에 순서대로 담는다.

		for (var i = 0; i < num2.length; i++) {
			arrNum2[i] = num2.charAt(i);
		} // 주민번호 뒷자리를 배열에 순서대로 담는다.

		var tempSum = 0;

		for (var i = 0; i < num1.length; i++) {
			tempSum += arrNum1[i] * (2 + i);
		} // 주민번호 검사방법을 적용하여 앞 번호를 모두 계산하여 더함

		for (var i = 0; i < num2.length - 1; i++) {
			if (i >= 2) {
				tempSum += arrNum2[i] * i;
			} else {
				tempSum += arrNum2[i] * (8 + i);
			}
		} // 같은방식으로 앞 번호 계산한것의 합에 뒷번호 계산한것을 모두 더함

		if ((11 - (tempSum % 11)) % 10 != arrNum2[6]) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}

		//외국인인 경우
	} else {
		var fgnno = num1 + num2;
		var sum = 0;
		var odd = 0;

		buf = new Array(13);

		for (i = 0; i < 13; i++) {
			buf[i] = parseInt(fgnno.charAt(i));
		}

		odd = buf[7] * 10 + buf[8];

		if (odd % 2 != 0) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}

		if (buf[11] != 6 && buf[11] != 7 && buf[11] != 8 && buf[11] != 9) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}

		multipliers = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];

		for (i = 0, sum = 0; i < 12; i++) {
			sum += buf[i] *= multipliers[i];
		}

		sum = 11 - (sum % 11);

		if (sum >= 10) {
			sum -= 10;
		}

		sum += 2;

		if (sum >= 10) {
			sum -= 10;
		}

		if (sum != buf[12]) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}
	}

	return true;
}

String.prototype.trim = function () {
	return this.replace(/(^\s*)|(\s*$)/g, '');
};

function pageRun(num) {
	document.listScriptForm.pg.value = num;
	document.listScriptForm.submit();
}

function readRun(num) {
	document.ReadScriptForm.idx.value = num;
	document.ReadScriptForm.submit();
}

function MemberInfo(ID) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./member_info_pop.php', { ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show()
			.draggable();
	});
}

function CourseInfo(LectureCode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./course_info_pop.php', { LectureCode: LectureCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function CompanyInfo(CompanyCode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./company_info_pop.php', { CompanyCode: CompanyCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function ProgressInfo(ID, LectureCode, Study_Seq) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./progress_info_pop.php', { ID: ID, LectureCode: LectureCode, Study_Seq: Study_Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1000px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function ProgressInfoLog(i, ID, LectureCode, Study_Seq, Chapter_Seq, Contents_idx) {
	$("tr[id='ProgressDetail']:eq(" + i + ')').toggle();

	if ($("tr[id='ProgressDetail']:eq(" + i + ')').css('display') == 'none') {
	} else {
		$("div[id='Progress_log']:eq(" + i + ')').load(
			'./progress_info_pop_log.php',
			{ ID: ID, LectureCode: LectureCode, Study_Seq: Study_Seq, Chapter_Seq: Chapter_Seq, Contents_idx: Contents_idx },
			function () {}
		);
	}
}

function DeptAdd(Dept, idx, ParentCategory, Deep, DeptString, mode) {
	var url = './dept_category_reg.php?Dept=' + Dept + '&idx=' + idx + '&ParentCategory=' + ParentCategory + '&Deep=' + Deep + '&DeptString=' + DeptString + '&mode=' + mode;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=100, width=1300, height=700');
}

function DeptSubCategoryView(Dept, DivName, idx, Deep) {
	$('#' + DivName).load('./dept_category_sub.php', { idx: idx, Deep: Deep, Dept: Dept });

	$('#' + DivName).toggle();

	if ($('#' + DivName).css('display') == 'none') {
		$('#Folder' + idx).attr('src', 'images/Folder.gif');
	} else {
		$('#Folder' + idx).attr('src', 'images/OpenFolder.gif');
	}
}

function DeptSubCategoryViewSelect(Dept, DivName, idx, Deep) {
	$('#' + DivName).load('./dept_category_sub_select.php', { idx: idx, Deep: Deep, Dept: Dept });

	$('#' + DivName).toggle();

	if ($('#' + DivName).css('display') == 'none') {
		$('#Folder' + idx).attr('src', 'images/Folder.gif');
	} else {
		$('#Folder' + idx).attr('src', 'images/OpenFolder.gif');
	}
}

//아이디 유효성 검사
function ID_Validity(str) {
	if (str == '') {
		alert('아이디를 입력하세요.');
		return false;
	}
	if (str.length < 4 || str.length > 20) {
		alert('아이디는 4자이상 20자 이내로 입력하세요.');
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

	$("span[id='id_check_msg']").load('./id_check.php', { ID: ID }, function () {});
}

function DeptCategorySelect(Dept) {
	var url = './dept_category_select.php?Dept=' + Dept;
	window.open(url, 'ad', 'scrollbars=yes, resizable=no, left=400, width=800, height=600');
}

function PasswordInit() {
	if (confirm('비밀번호를 1111 으로 초기화 하시겠습니까?') == true) {
		PasswordForm.submit();
	}
}

function ManagerLoginSubmit(ID) {
	if (confirm('[' + ID + ']로 로그인 하시겠습니까?') == true) {
		LoginForm.submit();
	}
}

function MemberLoginSubmit(ID) {
	if (confirm('[' + ID + ']로 로그인 하시겠습니까?') == true) {
		LoginForm.submit();
	}
}

function MemberOut() {
	if (confirm('현재회원을 탈퇴처리 하시겠습니까?') == true) {
		OutForm.submit();
	}
}

function ChangeMemberUseYN(useYn) {
	var msg = '';
	if(useYn=="Y"){
		msg = '현재회원을 미사용처리 하시겠습니까?';
	}else{
		msg = '현재회원을 사용처리 하시겠습니까?';
	}
	if (confirm(msg) == true) {
		UseYnForm.submit();
	}
}

function deletionDetail(id){
	//로그아웃 시간 초기화
	$('#NowTime').val('0');
	
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
	$('#DataResult').load('./deletion_detail.php', { id:id }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '850px',
				left: body_width / 2 - 420,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function DeleteMemberData(id){
	if (document.deletionDetailForm.reason.value == '') {
		alert('사유를 입력하세요.');
		return;
	}
	if(confirm(id+' 회원의 데이터를 삭제하시겠습니까?') == true){
		document.deletionDetailForm.submit();
	}
}

function NoPermission() {
	location.href = 'logout.php';
}

//사업자번호 중복체크
function CompanyCodeCheck() {
	var CompanyCode = $('#CompanyCode').val();

	if (CompanyCode == '') {
		alert('사업자번호를 입력하세요.');
		return;
	}

	if (IsNumber(CompanyCode) == false) {
		alert('사업자번호는 숫자만 입력하세요.');
		return;
	}

	if (CompanyCode.length != 10) {
		alert('사업자번호는 10자리 숫자만 입력하세요.');
		return;
	}

	$("span[id='CompanyCode_check_msg']").load('./companycode_check.php', { CompanyCode: CompanyCode }, function () {});
}

//사업주 아이디 중복체크
function CompanyIDCheck() {
	var CompanyID = $('#CompanyID').val();

	if (ID_Validity(CompanyID) == false) {
		return;
	}

	$("span[id='CompanyID_check_msg']").load('./companyid_check.php', { CompanyID: CompanyID }, function () {});
}

//영업담당자 검색
function SalesManagerSearch() {
	var SalesName = $('#SalesName').val();
	/*
	if(SalesName=="") {
		alert("영업담당자명을 입력하세요.");
		return;
	}
	*/
	$("span[id='SalesManagerHtml']").load('./salesmanager_search.php', { SalesName: SalesName }, function () {});
}

//회원아이디 중복체크
function MemberIDCheck() {
	var ID = $('#ID').val();

	if (ID_Validity(ID) == false) {
		return;
	}

	$("span[id='id_check_msg']").load('./member_id_check.php', { ID: ID }, function () {});
}

//회원 기업정보 찾기
function MemberCompanySearch() {
	var CompanyName = $('#CompanyName').val();

	if (CompanyName == '') {
		alert('회사명을 입력하세요.');
		return;
	}

	$("span[id='company_search_result']").load('./member_company_search.php', { CompanyName: CompanyName }, function () {});
}

function MemberCompanySearchSelect() {
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

function ContentsDetail(mode, Seq, Contents_idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./contents_detail.php', { mode: mode, Seq: Seq, Contents_idx: Contents_idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1000px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function DataResultClose() {
	$("div[id='Roading']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();
	$("div[id='SysBg_Black_Click']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='DataResult2']").html('');
	$("div[id='DataResult2']").hide();
}

function DataResultClose2() {
	$("div[id='DataResult2']").html('');
	$("div[id='DataResult2']").hide();
}

function ContentsTypeSelected() {
	var checked_value = $(':radio[name="ContentsType"]:checked').val();

	if (checked_value == 'A') {
		$("tr[id='CommonTR']").show();
		$("tr[id='FlashTR']").show();
		$("tr[id='MovieTR']").hide();
		$("tr[id='ExamTR']").hide();
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='TeacherTR']").hide();
	}
	if (checked_value == 'B') {
		$("tr[id='CommonTR']").show();
		$("tr[id='FlashTR']").hide();
		$("tr[id='MovieTR']").show();
		$("tr[id='ExamTR']").hide();
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='TeacherTR']").hide();
	}
	if (checked_value == 'C') {
		$("tr[id='CommonTR']").hide();
		$("tr[id='FlashTR']").hide();
		$("tr[id='MovieTR']").hide();
		$("tr[id='ExamTR']").show();
		$("tr[id='ExamSelectTR']").show();
		$("tr[id='TeacherTR']").hide();
	}
	if (checked_value == 'D') {
		$("tr[id='CommonTR']").hide();
		$("tr[id='FlashTR']").hide();
		$("tr[id='MovieTR']").hide();
		$("tr[id='ExamTR']").show();
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='TeacherTR']").hide();
	}
	if (checked_value == 'E') {
		$("tr[id='CommonTR']").hide();
		$("tr[id='FlashTR']").hide();
		$("tr[id='MovieTR']").hide();
		$("tr[id='ExamTR']").hide();
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='TeacherTR']").hide();
	}
	if (checked_value == 'F') {
		$("tr[id='CommonTR']").hide();
		$("tr[id='FlashTR']").hide();
		$("tr[id='MovieTR']").hide();
		$("tr[id='ExamTR']").hide();
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='TeacherTR']").show();
	}
	if (checked_value == 'G') {
		$("tr[id='CommonTR']").hide();
		$("tr[id='FlashTR']").hide();
		$("tr[id='MovieTR']").hide();
		$("tr[id='ExamTR']").hide();
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='TeacherTR']").hide();
	}
}

function ContentsDetailSubmitOk() {
	val = document.Form1;

	var checked_value = $(':radio[name="ContentsType"]:checked').val();

	if (checked_value == '') {
		alert('컨텐츠 유형을 선택하세요.');
	}

	if (checked_value == 'A' || checked_value == 'B') {
		if ($('#ContentsURL').val() == '') {
			alert('컨텐츠 경로를 입력하세요.');
			$('#ContentsURL').focus();
			return;
		}
	}

	if (checked_value == 'C') {
		if ($('#Question').val() == '') {
			alert('질문 내용을 입력하세요.');
			$('#Question').focus();
			return;
		}
		if ($('#Example01').val() == '') {
			alert('보기1을 입력하세요.');
			$('#Example01').focus();
			return;
		}
		if ($('#Example02').val() == '') {
			alert('보기2를 입력하세요.');
			$('#Example02').focus();
			return;
		}
		if ($('#Example03').val() == '') {
			alert('보기3을 입력하세요.');
			$('#Example03').focus();
			return;
		}
		if ($('#Example04').val() == '') {
			alert('보기4를 입력하세요.');
			$('#Example04').focus();
			return;
		}
		/*
		if($("#Example05").val()=="") {
			alert("보기5를 입력하세요.");
			$("#Example05").focus();
			return;
		}
		*/

		if ($(':radio[name="Answer"]:checked').length < 1) {
			alert('보기중 정답을 선택하세요.');
			$(":radio[name='Answer']:eq(0)").focus();
			return;
		}
		if ($('#Comment').val() == '') {
			alert('해답 설명을 입력하세요.');
			$('#Comment').focus();
			return;
		}
	}

	if (checked_value == 'D') {
		if ($('#Question').val() == '') {
			alert('질문 내용을 입력하세요.');
			$('#Question').focus();
			return;
		}
		if ($('#Comment').val() == '') {
			alert('해답 설명을 입력하세요.');
			$('#Comment').focus();
			return;
		}
	}

	if (checked_value == 'F') {
		if ($('#Teacher').val() == '') {
			alert('강사를 선택하세요.');
			$('#Teacher').focus();
			return;
		}
	}

	if ($('#OrderByNum').val() == '') {
		alert('정렬순서를 입력하세요.');
		$('#OrderByNum').focus();
		return;
	}
	if (IsNumber($('#OrderByNum').val()) == false) {
		alert('정렬순서는 숫자만 입력하세요.');
		$('#OrderByNum').focus();
		return;
	}

	Yes = confirm('등록 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#Waiting').show();
		val.submit();
	}
}

function GubunSelected() {
	if ($('#GubunSelect option:selected').val() != '') {
		$('#Gubun').val($('#GubunSelect option:selected').val());
	}
}

function FlashPlayer(url) {
	var url = './flase_player.php?url=' + url;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=1060, height=750');
}

function MoviePlayer(url, sel) {
	var url = './movie_player.php?url=' + url + '&sel=' + sel;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=800, height=600');
}

function MobilePlayer(url, sel) {
	var url = './mobile_player.php?url=' + url + '&sel=' + sel;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=800, height=600');
}

function ExamTypeSelected() {
	var checked_value = $(':radio[name="ExamType"]:checked').val();

	if (checked_value == 'A') {
		$("tr[id='ExamSelectTR']").show();
		$("tr[id='ExamTR']").hide();
		$("tr[id='Answer2TR']").hide();
	}
	if (checked_value == 'B') {
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='ExamTR']").hide();
		$("tr[id='Answer2TR']").show();
	}
	if (checked_value == 'C') {
		$("tr[id='ExamSelectTR']").hide();
		$("tr[id='ExamTR']").show();
		$("tr[id='Answer2TR']").show();
	}
}

function CourseAdd(idx, ParentCategory, Deep, mode) {
	var url = './course_category_reg.php?idx=' + idx + '&ParentCategory=' + ParentCategory + '&Deep=' + Deep + '&mode=' + mode;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=600, height=450');
}

function CourseCategorySelect() {
	var Category1Selected = $('#Category1 option:selected').val();

	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1Selected }, function () {});
}

function CourseCategorySelectAfter(Category1, Category2) {
	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1, Category2: Category2 }, function () {});
}

function UploadFile(Ele, EleArea, FileType) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./upload_file.php', { Ele: Ele, EleArea: EleArea, FileType: FileType }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				width: '800px',
				left: body_width / 2 - 550,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function UploadFileSubmitOk() {
	if ($('#file').val() == '') {
		alert('파일을 선택하세요.');
		$('#file').focus();
		return;
	}

	Yes = confirm('업로드 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn2').hide();
		$('#Waiting2').show();
		UploadForm1.submit();
	}
}

function UploadFileDelete(Ele, EleArea) {
	$('#' + Ele).val('');
	$('#' + EleArea).html('');
}

function CourseCopy() {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '750px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./course_copy.php', { t: '1111' }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 50 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1300px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function CourseCopyApply(LectureCode) {
	Yes = confirm('과정코드 [' + LectureCode + ']의 정보를 적용하시겠습니까?');
	if (Yes == true) {
		document.CourseCopyForm.LectureCode.value = LectureCode;
		document.CourseCopyForm.submit();
	}
}

function ChapterRegist(mode, LectureCode, Chapter_seq, ContentGubunOnly) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '750px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./chapter_regist.php', { mode: mode, LectureCode: LectureCode, Chapter_seq: Chapter_seq, ContentGubunOnly: ContentGubunOnly }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 750 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '750px',
				width: '1100px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function ChapterRegistReload(mode, LectureCode, Chapter_seq) {
	if ($("input:checkbox[id='ContentGubunOnly']").is(':checked') == true) {
		ContentGubunOnly_value = 'Y';
	} else {
		ContentGubunOnly_value = 'N';
	}

	ChapterRegist(mode, LectureCode, Chapter_seq, ContentGubunOnly_value);
}

function ChapterTypeSelected() {
	var checked_value = $(':radio[name="ChapterType"]:checked').val();

	if (checked_value == 'A') {
		$("tr[id='ContentsTR']").show();
		$("tr[id='ExamTR']").hide();
		$('select[id=ContentGubun] option:eq(0)').prop('selected', true);
		$('select[id=Content_idx] option').not("[value='']").remove();

	}else if (checked_value == 'E') {
	
		$("tr[id='ContentsTR']").hide();
		$("tr[id='ExamTR']").hide();
		$("tr[id='DiscussionTR']").show();
		$('select[id=ContentGubun] option:eq(0)').prop('selected', true);
		$('select[id=Content_idx] option').not("[value='']").remove();
	
	} else {
		$("tr[id='ContentsTR']").hide();
		$("tr[id='ExamTR']").show();
		$('select[id=ExamGubun] option:eq(0)').prop('selected', true);
		$('select[id=Exam_idx] option').not("[value='']").remove();
		$('#ChapterExamAddBtn').hide();
		$('select[id=Exam_idx]').css('width', '100%');
		jQuery('#ExamTable tr').remove();
	}
}

function ChapterContentsSelect(Sub_idx) {
	var ContentGubun = $('#ContentGubun').val();
	/*
	if(ContentGubun=="") {
		alert("차시 구분을 선택하세요.");
		return;
	}
	*/

	$("div[id='Content_idx_div']").load('./chapter_content_select.php', { ContentGubun: ContentGubun, Sub_idx: Sub_idx }, function () {});
}

function ChapterSubmitOk() {
	val = document.Form1;
	var checked_value = $(':radio[name="ChapterType"]:checked').val();

	if (checked_value == 'A') {
		if ($('#Content_idx').val() == '') {
			alert('기초 차시를 선택하세요.');
			return;
		}
	}

	if ($('#OrderByNum').val() == '') {
		alert('정렬순서를 입력하세요.');
		return;
	}

	if (IsNumber($('#OrderByNum').val()) == false) {
		alert('정렬순서를 숫자만 입력하세요.');
		return;
	}

	Yes = confirm('등록 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#Waiting').show();
		val.submit();
	}
}

function ChapterExamSelect() {
	var checked_value = $(':radio[name="ChapterType"]:checked').val();
	var ExamGubun = $('#ExamGubun').val();
	/*
	if(ExamGubun=="") {
		alert("차시 구분을 선택하세요.");
		return;
	}
	*/

	$("div[id='Exam_idx_div']").load('./chapter_exam_select.php', { ExamGubun: ExamGubun, ChapterType: checked_value }, function () {});
}

function ChapterExamAdd() {
	var Exam_idx_value = $('select[name=Exam_idx] option:selected').val();
	var Exam_idx_text = $('select[name=Exam_idx] option:selected').text();

	if (Exam_idx_value == '') {
		alert('평가 문제를 선택하세요.');
		return;
	}

	var Exam_idx_temp_count = $('input[id=Exam_idx_temp]').length;

	if (Exam_idx_temp_count > 0) {
		for (i = 0; i < Exam_idx_temp_count; i++) {
			if ($("input[id='Exam_idx_temp']:eq(" + i + ')').val() == Exam_idx_value) {
				alert('동일한 평가문제가 존재합니다.');
				return;
			}
		}
	}

	var row = '<tr><th><input type="hidden" name="Exam_idx_temp" id="Exam_idx_temp" value="' + Exam_idx_value + '" readonly>';
	row += '<input type="text" name="Exam_idx_text" style="width:100%" value="' + Exam_idx_text + '" readonly></th>';
	row += '<th><input type="button" value="삭제" onclick="Javascript:ChapterExamDelRow(this);" class="btn_inputSm01"></th></tr>';
	$(row).appendTo('#ExamTable');

	ChapterExamValueCheck();
}

function ChapterExamDelRow(obj) {
	if (jQuery('#ExamTable tr').length < 1) {
		alert('더이상 삭제 할 수 없습니다.');
		return false;
	}

	if (confirm('선택한 문제를 삭제 하시겠습니까?')) {
		jQuery(obj).parent().parent().remove();
		ChapterExamValueCheck();
	}
}

function ChapterListMoveUp(el) {
	var $tr = $(el).parent().parent(); // 클릭한 버튼이 속한 tr 요소
	$tr.prev().before($tr); // 현재 tr 의 이전 tr 앞에 선택한 tr 넣기
}

function ChapterListMoveDown(el) {
	var $tr = $(el).parent().parent(); // 클릭한 버튼이 속한 tr 요소
	$tr.next().after($tr); // 현재 tr 의 다음 tr 뒤에 선택한 tr 넣기
}

function ChapterExamValueCheck() {
	var Exam_idx_arrary = '';
	var Exam_idx_temp_count = $("input[id='Exam_idx_temp']").length;

	for (i = 0; i < Exam_idx_temp_count; i++) {
		if (Exam_idx_arrary == '') {
			Exam_idx_arrary = $("input[id='Exam_idx_temp']:eq(" + i + ')').val();
		} else {
			Exam_idx_arrary = Exam_idx_arrary + '|' + $("input[id='Exam_idx_temp']:eq(" + i + ')').val();
		}
	}

	$("input[id='Exam_idx_arrary']").val(Exam_idx_arrary);
}

function ChapterListRoading() {
	$("div[id='ChapterList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');

	var LectureCodeValue = $('#LectureCodeValue').val();

	$("div[id='ChapterList']").load('./course_read_list.php', { LectureCode: LectureCodeValue }, function () {});
}

function ChapterOrderByGo() {
	var Chapter_seq_array = '';
	var Chapter_seq_count = $("input[id='Chapter_seq_value']").length;

	if (Chapter_seq_count < 2) {
		alert('차시 구성을 정렬하려면 2개 이상 등록되어 있어야 합니다.');
		return;
	}

	for (i = 0; i < Chapter_seq_count; i++) {
		if (Chapter_seq_array == '') {
			Chapter_seq_array = $("input[id='Chapter_seq_value']:eq(" + i + ')').val();
		} else {
			Chapter_seq_array = Chapter_seq_array + '|' + $("input[id='Chapter_seq_value']:eq(" + i + ')').val();
		}
	}

	$("input[id='Chapter_seq_array']").val(Chapter_seq_array);

	Yes = confirm('차시 구성을 정렬하시겠습니까?');
	if (Yes == true) {
		OrderByForm.submit();
	}
}

function ChapterContentsBatch() {
	var ContentGubun_value = $('select[id=ContentGubun] option:selected').val();
	var ContentGubun_value_text = $('select[id=ContentGubun] option:selected').text();

	if (ContentGubun_value == '') {
		alert('차시 구분을 선택하세요.');
		return;
	}

	var Content_idx_option_count = eval($('select[id=Content_idx] option').size());

	if (Content_idx_option_count < 2) {
		alert('선택한 차시구분에 등록된 기초차시가 없습니다.');
		return;
	}

	Yes = confirm('선택한 차시구분에 등록된 ' + (Content_idx_option_count - 1) + '개의 기초차시를\n\n모두 등록하시겠습니까?');
	if (Yes == true) {
		document.Form1.action = 'chapter_regist_batch.php';
		Form1.submit();
	}
}

function ChapterExamBatch() {
	var ExamGubun_value = $('select[id=ExamGubun] option:selected').val();
	var ExamGubun_value_text = $('select[id=ExamGubun] option:selected').text();

	if (ExamGubun_value == '') {
		alert('차시 구분을 선택하세요.');
		return;
	}

	var Exam_idx_option_count = eval($('select[id=Exam_idx] option').size());

	if (Exam_idx_option_count < 2) {
		alert('선택한 차시구분에 등록된 평가문제가 없습니다.');
		return;
	}

	Yes = confirm('선택한 차시구분에 등록된 ' + (Exam_idx_option_count - 1) + '개의 평가문제를\n\n모두 추가하시겠습니까?');
	if (Yes == true) {
		for (i = 1; i < Exam_idx_option_count; i++) {
			$('select[id=Exam_idx] option:eq(' + i + ')').text();

			var row = '<tr><th><input type="hidden" name="Exam_idx_temp" id="Exam_idx_temp" value="' + $('select[id=Exam_idx] option:eq(' + i + ')').val() + '" readonly>';
			row += '<input type="text" name="Exam_idx_text" style="width:100%" value="' + $('select[id=Exam_idx] option:eq(' + i + ')').text() + '" readonly></th>';
			row += '<th><input type="button" value="삭제" onclick="Javascript:ChapterExamDelRow(this);" class="btn_inputSm01"></th></tr>';
			$(row).appendTo('#ExamTable');
		}
	}

	ChapterExamValueCheck();
}

function ChapterCopy(TargetLectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '750px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./chapter_copy.php', { TargetLectureCode: TargetLectureCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 50 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1200px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function ChapterCopyApply(LectureCode) {
	Yes = confirm('과정코드 [' + LectureCode + ']의 차시정보를 적용하시겠습니까?');
	if (Yes == true) {
		document.ChapterCopyForm.LectureCode.value = LectureCode;
		document.ChapterCopyForm.submit();
	}
}

function PackageSearch() {
	$("span[id='PackageSearchResult']").html('<center><img src="/images/loader.gif" alt="로딩중" /></center>');

	var ContentsName = $('#ContentsName').val();

	$("span[id='PackageSearchResult']").load('./package_search.php', { ContentsName: ContentsName }, function () {});
}

function PackageSearchSelect() {
	var PackageCoursevalue = $('select[id=PackageCourse] option:selected').val();
	var PackageCourse_value_text = $('select[id=PackageCourse] option:selected').text();

	if (PackageCoursevalue == '') {
		alert('과정을 선택하세요.');
		return;
	}

	var LectureCode_value_temp_count = $('input[id=LectureCode_value_temp]').length;

	if (LectureCode_value_temp_count > 0) {
		for (i = 0; i < LectureCode_value_temp_count; i++) {
			if ($("input[id='LectureCode_value_temp']:eq(" + i + ')').val() == PackageCoursevalue) {
				alert('동일한 과정이 존재합니다.');
				return;
			}
		}
	}

	PackageCourse_value_text_array = PackageCourse_value_text.split('|');

	LectureCode_value_temp_count2 = LectureCode_value_temp_count + 1;
	var row = '<tr>';
	row += '<td align="center">' + LectureCode_value_temp_count2 + '</td>';
	row += '<td align="center"><input type="hidden" name="LectureCode_value_temp" id="LectureCode_value_temp" value="' + PackageCoursevalue + '">';
	row +=
		'<input type="button" value="▲" onclick="PackageChapterListMoveUp(this);" style="width:30px;"> <input type="button" value="▼" onclick="PackageChapterListMoveDown(this);" style="width:30px;"></td>';
	row += '<td align="center">' + PackageCoursevalue + '</td>';
	row += '<td align="left">' + PackageCourse_value_text_array[1].trim() + '</td>';
	row += '<td align="center">' + PackageCourse_value_text_array[2].trim() + '</td>';
	row += '<td align="center">' + PackageCourse_value_text_array[3].trim() + '</td>';
	row += '<td><input type="button" value="삭제" onclick="Javascript:PackageChapterExamDelRow(this);" class="btn_inputSm01"></td>';
	row += '</tr>';

	$(row).appendTo('#PackageCourseTable');
}

function PackageChapterExamDelRow(obj) {
	if (jQuery('#PackageCourseTable tr').length < 1) {
		alert('더이상 삭제 할 수 없습니다.');
		return false;
	}

	if (confirm('선택한 과정을 삭제 하시겠습니까?')) {
		jQuery(obj).parent().parent().remove();
	}
}

function PackageChapterListMoveUp(el) {
	var $tr = $(el).parent().parent(); // 클릭한 버튼이 속한 tr 요소
	$tr.prev().before($tr); // 현재 tr 의 이전 tr 앞에 선택한 tr 넣기
}

function PackageChapterListMoveDown(el) {
	var $tr = $(el).parent().parent(); // 클릭한 버튼이 속한 tr 요소
	$tr.next().after($tr); // 현재 tr 의 다음 tr 뒤에 선택한 tr 넣기
}

function PackageChapterSave() {
	var LectureCode_value_temp_array = '';
	var LectureCode_value_temp_count = $("input[id='LectureCode_value_temp']").length;

	if (LectureCode_value_temp_count < 1) {
		Yes = confirm('패키지로 선택한 단과 컨텐츠가 없습니다.\n\n저장 하시겠습니까?');
		if (Yes == true) {
			$("input[id='PackageLectureCode']").val('');
			Form1.submit();
		} else {
			return;
		}
	} else {
		for (i = 0; i < LectureCode_value_temp_count; i++) {
			if (LectureCode_value_temp_array == '') {
				LectureCode_value_temp_array = $("input[id='LectureCode_value_temp']:eq(" + i + ')').val();
			} else {
				LectureCode_value_temp_array = LectureCode_value_temp_array + '|' + $("input[id='LectureCode_value_temp']:eq(" + i + ')').val();
			}
		}

		$("input[id='PackageLectureCode']").val(LectureCode_value_temp_array);

		Yes = confirm('저장 하시겠습니까?');
		if (Yes == true) {
			Form1.submit();
		}
	}
}

function LectureRegIDSearch() {
	var TempSearchID = $('#TempSearchID').val();
	/*
	if(TempSearchID=="") {
		alert("수강생 아이디 또는 이름을 입력하세요.");
		return;
	}
	*/
	$("span[id='SearchIDResult']").load('./lecture_reg_id_search.php', { TempSearchID: TempSearchID }, function () {});
}

function LectureRegTutorSearch() {
	var TempSearchTutor = $('#TempSearchTutor').val();
	/*
	if(TempSearchTutor=="") {
		alert("첨삭강사의 아이디 또는 이름을 입력하세요.");
		return;
	}
	*/
	$("span[id='SearchTutorResult']").load('./lecture_reg_tutor_search.php', { TempSearchTutor: TempSearchTutor }, function () {});
}

function ExcelUploadListRoading(str) {
	$("div[id='ExcelUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');

	$("div[id='ExcelUploadList']").load('./lecture_reg_list.php', { str: str }, function () {});
}

function LectureRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./lecture_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 550 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				width: '1200px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

var LectureRegist_Seq_count = 0;

function LectureRegistSubmitOk() {
	LectureRegist_Seq_count = $("input[id='check_seq']").length;

	if (LectureRegist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 수강등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 수강등록 진행상황을 확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			LectureRegistProcess(0);
		}
	}
}

function LectureRegistProcess(i) {
	if (i < LectureRegist_Seq_count) {
		i2 = i + 1;
		$("span[id='LectureRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='LectureRegResult']:eq(" + i + ')').load('./lecture_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val() }, function () {
			setTimeout(function () {
				LectureRegistProcess(i2);
			}, 500);
		});
	} else {
		alert('수강등록 처리가 완료되었습니다.\n\n\n\n수강등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.ExcelUploadListRoading('C');
	}
}

function LectureRequestStatus(ID, idx, i) {
	var select_length = $("select[id='Status']").length;

	if (select_length < 2) {
		var Status = $("select[id='Status']").val();
		var Payment = $("select[id='Payment']").val();
	} else {
		var Status = $("select[id='Status']:eq(" + i + ')').val();
		var Payment = $("select[id='Payment']:eq(" + i + ')').val();
	}

	var mode = 'S';

	Yes = confirm('[' + ID + ']님의 학습신청 상태를 변경하시겠습니까?');
	if (Yes == true) {
		$.post('./lecture_request_change.php', { ID: ID, idx: idx, Status: Status, Payment: Payment, mode: mode }, function (data) {
			if (data == 'Success') {
				alert('변경되었습니다.');
			} else {
				alert('오류가 발생했습니다.');
			}

			location.reload();
		});
	}
}

function LectureRequestDelete(ID, idx, i) {
	var select_length = $("select[id='Status']").length;

	if (select_length < 2) {
		var Status = $("select[id='Status']").val();
		var Payment = $("select[id='Payment']").val();
	} else {
		var Status = $("select[id='Status']:eq(" + i + ')').val();
		var Payment = $("select[id='Payment']:eq(" + i + ')').val();
	}

	var mode = 'D';

	Yes = confirm('[' + ID + ']님의 학습신청 내역을 삭제하시겠습니까?');
	if (Yes == true) {
		$.post('./lecture_request_change.php', { ID: ID, idx: idx, Status: Status, Payment: Payment, mode: mode }, function (data) {
			if (data == 'Success') {
				alert('삭제되었습니다.');
			} else {
				alert('오류가 발생했습니다.');
			}

			location.reload();
		});
	}
}

function SearchGubunChange(str) {
	if (str == 'A') {
		$('#SearchGubunResult1').show();
		$('#SearchGubunResult2').hide();
		CompanySearchAutoCompleteClose();
		$('#CompanySearchLectureTermeResult').hide();
	}
	if (str == 'B') {
		$('#SearchGubunResult1').hide();
		$('#SearchGubunResult2').show();
		$('#CompanySearchLectureTermeResult').show();
	}
}

function LectureTermeSearch() {
	var SubmitFunction = $('#SubmitFunction').val();

	$("span[id='LectureTermeResult']").load(
		'./study_lectureterme.php',
		{ SearchYear: $('#SearchYear').val(), SearchMonth: $('#SearchMonth').val(), ctype: $('#ctype').val(), SubmitFunction: SubmitFunction },
		function () {
			$("#StudyPeriod").select2();
			changeSelect2Style();
		}
	);
}

function LectureCompanySearch() {
	var StudyPeriod = $('#StudyPeriod').val();
	var SubmitFunction = $('#SubmitFunction').val();

	if (StudyPeriod == '') {
		$("span[id='LectureCompanyResult']").html('&nbsp;&nbsp;<B>기간을 선택하세요.</B>');
	} else {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];

		$("span[id='LectureCompanyResult']").load(
			'./study_lectureterme_company.php',
			{ LectureStart: LectureStart, LectureEnd: LectureEnd, SubmitFunction: SubmitFunction },
			function () {
				$("div[id='SysBg_White']").hide();
				$("div[id='Roading']").hide();
			}
		);
	}
}

function StudySearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var OpenChapter = $('#OpenChapter').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var ReportCopy = $('#ReportCopy').val();
	var Tutor = $('#Tutor').val();
	var EduManager = $('#EduManager').val();
	var PageCount = $('#PageCount').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}else if((OpenChapter != '') && (OpenChapter<1)){
		alert('실시회차는 1이상 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	
	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

	if (TotalScore1 != '' || TotalScore2 != '') {
		if (IsNumber(TotalScore1) == false || IsNumber(TotalScore2) == false) {
			alert('총점은 숫자만 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			StudyPeriod2: StudyPeriod2,
			CompanyCode: CompanyCode,
			OpenChapter: OpenChapter,
			ID: ID,
			SalesID: SalesID,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			Tutor: Tutor,
			EduManager: EduManager,
			PageCount: PageCount,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudySearch2(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var ReportCopy = $('#ReportCopy').val();
	var Tutor = $('#Tutor').val();
	var EduManager = $('#EduManager').val();
	var PageCount = $('#PageCount').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

	if (TotalScore1 != '' || TotalScore2 != '') {
		if (IsNumber(TotalScore1) == false || IsNumber(TotalScore2) == false) {
			alert('총점은 숫자만 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study2_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			Tutor: Tutor,
			EduManager: EduManager,
			PageCount: PageCount,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function MidResetProcess(Name, Seq) {
	Yes = confirm(Name + '님의 중간평가를 재응시 가능하도록 처리하시겠습니까?');

	if (Yes == true) {
		$.post(
			'./study_test_reset.php',
			{
				Seq: Seq,
				sType: 'Mid',
			},
			function (data, status) {
				if (data == 'Y') {
					if ($('#ctype').val() == 'A') {
						StudySearch(1);
					} else {
						StudySearch2(1);
					}
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function TestResetProcess(Name, Seq) {
	Yes = confirm(Name + '님의 최종평가를 재응시 가능하도록 처리하시겠습니까?');

	if (Yes == true) {
		$.post(
			'./study_test_reset.php',
			{
				Seq: Seq,
				sType: 'Test',
			},
			function (data, status) {
				if (data == 'Y') {
					if ($('#ctype').val() == 'A') {
						StudySearch(1);
					} else {
						StudySearch2(1);
					}
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function ReportResetProcess(Name, Seq) {
	Yes = confirm(Name + '님의 과제를 재응시 가능하도록 처리하시겠습니까?');

	if (Yes == true) {
		$.post(
			'./study_test_reset.php',
			{
				Seq: Seq,
				sType: 'Report',
			},
			function (data, status) {
				if (data == 'Y') {
					if ($('#ctype').val() == 'A') {
						StudySearch(1);
					} else {
						StudySearch2(1);
					}
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function StudyExcel() {
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function Study2Excel() {
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study2_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function CheckBox_AllSelect(obj) {
	if ($("input:checkbox[name='AllCheck']").is(':checked') == true) {
		$("input:checkbox[name='" + obj + "']").prop('checked', true);
	} else {
		$("input:checkbox[name='" + obj + "']").prop('checked', false);
	}
}

function StudyCheckedDelete() {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('삭제하려는 항목을 선택하세요.');
		return;
	}

	Yes = confirm('선택한 항목을 정말 삭제하시겠습니까?\n\n삭제 후에는 되돌릴 수 없습니다.');

	if (Yes == true) {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./study_search_checked_delete.php',
			{
				seq_value: seq_value,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (data == 'Y') {
					if ($('#ctype').val() == 'A') {
						StudySearch(1);
					}
					if ($('#ctype').val() == 'B') {
						StudySearch2(1);
					}
					alert('삭제 되었습니다.');
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function StudyServiceTypeChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;
	var serviceTypeSelected = $('#ServiceType').val();
	var PackageYNSelected = $('#PackageYN').val();
	var contentsNameSelected = $('#LectureCode').val();

	if (!serviceTypeSelected) {
		alert('환급여부를 선택하세요.');
		$('#serviceType').focus();
		return;
	}
	if (!PackageYNSelected) {
		alert('과정구분을 선택하세요.');
		$('#PackageYN').focus();
		return;
	}
	if (!contentsNameSelected) {
		alert('변경하려는 과정을 선택하세요.');
		$('#contentsName').focus();
		return;
	}
	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	searchValue = $('#search').serialize();
	popupAddress = './study_servicetype_change_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function StudyIPSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	if (StudyPeriod != '') {
		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_ip_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyIPExcel() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyIPExcelDetail() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel_detail.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyIPExcelDetail2() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel_detail2.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyCorrectSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_correct_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyCorrectSearch2(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_correct2_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyCorrectExcel() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_correct_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyCorrectResult(Seq, TestType) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var SubmitFunction = $('#SubmitFunction').val();

	popupAddress = './study_correct_result.php?Seq=' + Seq + '&TestType=' + TestType + '&SubmitFunction=' + SubmitFunction;
	window.open(popupAddress, '채점', 'left=300, width=1200, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function ExamNoMove() {
	var MoveNo = $('#ExamNo_Move').val();
	$('#' + MoveNo).focus();
}

function StudyCorrectResultMark(mode) {
	var ExamA_Point = '';
	var ExamB_Point = '';
	var ExamC_Point = '';
	var TutorRemarkA = '';
	var TutorRemarkB = '';
	var TutorRemarkC = '';
	var MosaSelect = '';
	var ExamA_Point_len = $("input[id='ExamA_Point_Temp']").length;
	var ExamB_Point_len = $("input[id='ExamB_Point_Temp']").length;
	var ExamC_Point_len = $("input[id='ExamC_Point_Temp']").length;

	var TutorRemarkA_len = $("textarea[id='TutorRemarkA_Temp']").length;
	var TutorRemarkB_len = $("textarea[id='TutorRemarkB_Temp']").length;
	var TutorRemarkC_len = $("textarea[id='TutorRemarkC_Temp']").length;
	var Mosa_len 		 = $("select[id='Mosa' ]").length;
	alert(Mosa_len);
	//객관식 점수 정리
	if (ExamA_Point_len > 0) {
		for (i = 0; i < ExamA_Point_len; i++) {
			if (ExamA_Point == '') {
				ExamA_Point = $("input[id='ExamA_Point_Temp']:eq(" + i + ')').val();
			} else {
				ExamA_Point = ExamA_Point + '|' + $("input[id='ExamA_Point_Temp']:eq(" + i + ')').val();
			}
		}
	}

	//단답형 점수 정리
	if (ExamB_Point_len > 0) {
		for (i = 0; i < ExamB_Point_len; i++) {
			if ($("input[id='ExamB_Point_Temp']:eq(" + i + ')').val() == '') {
				alert('단답형 획득점수를 입력하세요.');
				$("input[id='ExamB_Point_Temp']:eq(" + i + ')').focus();
				return;
			}

			if (ExamB_Point == '') {
				ExamB_Point = $("input[id='ExamB_Point_Temp']:eq(" + i + ')').val();
			} else {
				ExamB_Point = ExamB_Point + '|' + $("input[id='ExamB_Point_Temp']:eq(" + i + ')').val();
			}
		}
	}

	//서술형 점수 정리
	if (ExamC_Point_len > 0) {
		for (i = 0; i < ExamC_Point_len; i++) {
			if ($("input[id='ExamC_Point_Temp']:eq(" + i + ')').val() == '') {
				alert('서술형 획득점수를 입력하세요.');
				$("input[id='ExamC_Point_Temp']:eq(" + i + ')').focus();
				return;
			}

			if (ExamC_Point == '') {
				ExamC_Point = $("input[id='ExamC_Point_Temp']:eq(" + i + ')').val();
			} else {
				ExamC_Point = ExamC_Point + '|' + $("input[id='ExamC_Point_Temp']:eq(" + i + ')').val();
			}
		}
	}

	//객관식 첨삭지도 정리
	if (TutorRemarkA_len > 0) {
		for (i = 0; i < TutorRemarkA_len; i++) {
			if (i < 1) {
				TutorRemarkA = $("textarea[id='TutorRemarkA_Temp']:eq(" + i + ')').val();
			} else {
				TutorRemarkA = TutorRemarkA + '|' + $("textarea[id='TutorRemarkA_Temp']:eq(" + i + ')').val();
			}
		}
	}

	//단답형 첨삭지도 정리
	if (TutorRemarkB_len > 0) {
		for (i = 0; i < TutorRemarkB_len; i++) {
			if (i < 1) {
				TutorRemarkB = $("textarea[id='TutorRemarkB_Temp']:eq(" + i + ')').val();
			} else {
				TutorRemarkB = TutorRemarkB + '|' + $("textarea[id='TutorRemarkB_Temp']:eq(" + i + ')').val();
			}
		}
	}

	//서술형 첨삭지도 정리
	if (TutorRemarkC_len > 0) {
		for (i = 0; i < TutorRemarkC_len; i++) {
			if (i < 1) {
				TutorRemarkC = $("textarea[id='TutorRemarkC_Temp']:eq(" + i + ')').val();
			} else {
				TutorRemarkC = TutorRemarkC + '|' + $("textarea[id='TutorRemarkC_Temp']:eq(" + i + ')').val();
			}
		}
	}
	
	//모사정보 저장
	if (Mosa_len > 0) {
		for (i = 0; i < Mosa_len; i++) {
			if (i < 1) {
				MosaSelect = $("select[id='Mosa'  ]:eq(" + i + ')').val();
			} else {
				MosaSelect = MosaSelect + '|' + $("select[id='Mosa' ]:eq(" + i + ')').val();
			}
		}
	}
//alert(MosaSelect);
	$('#ExamA_Point').val(ExamA_Point);
	$('#ExamB_Point').val(ExamB_Point);
	$('#ExamC_Point').val(ExamC_Point);
	$('#TutorRemarkA').val(TutorRemarkA);
	$('#TutorRemarkB').val(TutorRemarkB);
	$('#TutorRemarkC').val(TutorRemarkC);
	$('#MosaSelect').val(MosaSelect);
	
	$('#mode').val(mode);

	if (mode == 'Y') {
		msg = '평가결과를 반영하시겠습니까?';
	} else {
		msg = '평가결과를 임시저장 하시겠습니까?';
	}

	Yes = confirm(msg);
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#SubmitWait').show();
		Form1.submit();
	}
}

function StudyCorrectResultMarkCancel(mode) {
	$('#mode').val(mode);

	msg = '채점을 취소 하시겠습니까?';

	Yes = confirm(msg);
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#SubmitWait').show();
		Form1.submit();
	}
}

function StudyEndSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var LectureStart = $('#LectureStart').val();
	var LectureEnd = $('#LectureEnd').val();
	var ServiceType = $('#ServiceType').val();

	if((!LectureStart)&&(!LectureEnd)&&(!CompanyName)){
		alert('검색 조건을 입력하세요.');
		return;		
	}
	
	if(LectureStart){
		if(!LectureEnd){
			alert('수강종료일을 선택하세요.');
			return;
		}
	}
	
	if(LectureEnd){
		if(!LectureStart){
			alert('수강시작일을 선택하세요.');
			return;
		}
	}
	
	if(LectureStart > LectureEnd){
		alert('수강종료일이 수강시작일보다 이전입니다.\n수강기간을 다시 선택하세요.');
		return;
	}
	
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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_end_search_result.php',
		{
			CompanyName: CompanyName,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			ServiceType: ServiceType,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyFinish(LectureStart, LectureEnd, CompanyCode, CompanyName, ServiceType, ArrayCnt) {
	if(confirm("확인 전에 재수강 중인 수강생은 없나요? ")){	
		if (confirm('교육종료 하시겠습니까? 교육종료시 취소가 불가합니다.')) {
			$.post(
				'./study_finish.php',
				{
					LectureStart: LectureStart,
					LectureEnd  : LectureEnd,
					CompanyCode : CompanyCode,
					ServiceType : ServiceType,
					CompanyName  : CompanyName,
				},
				function (data, status) {
					if (data != 'Y') {
						alert('처리중 문제가 발생했습니다.');
					} else {
						StudyEndSearch(1);
					}
				}
			);
		}
	}
}

function StudyEndAllComplete(LectureStart, LectureEnd, CompanyName, ServiceType) {
	if(confirm("확인 전에 재수강 중인 수강생은 없나요? ")){	
		if (confirm('전체마감처 하시겠습니까? 마감처리시 취소가 불가합니다.')) {
			$.post(
				'./study_end_all_complete.php',
				{
					LectureStart: LectureStart,
					LectureEnd: LectureEnd,
					CompanyName : CompanyName,
					ServiceType : ServiceType,
				},
				function (data, status) {
					if (data != 'Y') {
						alert('처리중 문제가 발생했습니다.');
					} else {
						StudyEndSearch(1);
					}
				}
			);
		}
	}
}

function StudyEndComplete(CompanyCode, ServiceType, LectureCode, LectureStart, LectureEnd, mode) {
	if(confirm("확인 전에 재수강 중인 수강생은 없나요? ")){
	
		if (mode == 'StudyEnd') {
			msg = '마감처리';
		}else if (mode == 'StudyEndCancel') {
			msg = '마감처리취소';
		}

		/*
		if (mode == 'ResultView') {
			msg = '확인처리';
		} else if (mode == 'ResultViewCancel') {
			msg = '확인처리취소';
		} else if (mode == 'StudyEnd') {
			msg = '마감처리';
		} else if (mode == 'StudyEndCancel') {
			msg = '마감처리취소';
		}*/
		if (confirm('[' + msg + '] 하시겠습니까? 마감처리시 취소가 불가합니다.')) {
			$.post(
				'./study_end_complete.php',
				{
					CompanyCode: CompanyCode,
					mode: mode,
					LectureStart: LectureStart,
					LectureEnd: LectureEnd,
					ServiceType: ServiceType,
					LectureCode: LectureCode,
				},
				function (data, status) {
					if (data != 'Y') {
						alert('처리중 문제가 발생했습니다.');
					} else {
						StudyEndSearch(1);
					}
				}
			);
		}
	}
}

function ExamMosaCheck(MosaCheck01, MosaCheck02, MosaResult) {
	$('#' + MosaResult).html('<B>모사율을 확인중입니다.</B>');

	var MosaCheck01_value = $('#' + MosaCheck01).val();
	var MosaCheck02_value = $('#' + MosaCheck02).val();

	$.post(
		'./study_correct_mosa.php',
		{
			MosaCheck01_value: MosaCheck01_value,
			MosaCheck02_value: MosaCheck02_value,
		},
		function (data, status) {
			setTimeout(function () {
				if (data > 90) {
					msg = '<B>' + data + '%의 모사율이 의심됩니다.</B>';
				} else {
					msg = '<B>모사율이 의심되지 않습니다.</B>';
				}

				$('#' + MosaResult).html(msg);
			}, 1000);
		}
	);
}


function StudySmsSearch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var OpenChapter = $('#OpenChapter').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var EduManager = $('#EduManager').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var ReportCopy = $('#ReportCopy').val();

	if (StudyPeriod != '') {
		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}else if((OpenChapter != '') && (OpenChapter<1)){
		alert('실시회차는 1이상 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}


	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

	if (TotalScore1 != '' || TotalScore2 != '') {
		if (IsNumber(TotalScore1) == false || IsNumber(TotalScore2) == false) {
			alert('총점은 숫자만 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_sms_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			OpenChapter: OpenChapter,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			EduManager: EduManager,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

var totalcount = 0;
var batching = false;

function StudySmsSend(send_mode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	totalcount = $("input[name='check_seq']").length; //전체 건수
	var checked_value = $(':radio[name="MessageMode"]:checked').val();

	if (!checked_value) {
		alert('발송하려는 독려 내용 단계를 선택하세요.');
		return;
	}

	if (totalcount < 1) {
		alert('검색된 항목이 없습니다.');
		return;
	}

	switch (send_mode) {
		case 'sms':
			Msg = 'SMS를 발송합니다.';
			break;
		case 'email':
			Msg = '이메일을 발송합니다.';
			break;
	}

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#ProcesssRatio').show();

	Yes = confirm(
		'현재 검색 결과로 ' +
			Msg +
			'\n\n발송 작업은 처음부터 ' +
			totalcount +
			'번 항목까지 순차적으로 진행됩니다.\n\n작업이 완료 될 때 까지 기다려 주세요.\n\n\n\n작업을 진행하시려면 [확인]을 클릭하세요.'
	);
	if (Yes == true) {
		batching = true;
		StudySmsSendProcess(0, send_mode);
	} else {
		batching = false;
		$('#ProcesssRatio').hide();
		$("div[id='SysBg_White']").hide();
	}
}

function StudySmsSendProcess(i,send_mode) {

	ProcesssRatioCal = i / totalcount * 100;
	var newNum = new Number(ProcesssRatioCal);
	ProcesssRatioCal = newNum.toFixed(2);
	$("#ProcesssRatio").html("<br><br><span style='font-size:25px;'>진행률</span> "+ProcesssRatioCal+" %");

	var checked_value = $(':radio[name="MessageMode"]:checked').val();

	if(i<totalcount) {

		i2 = i + 1;

		if ($("input:checkbox[id='check_seq_"+i+"']").is(":checked") == false){

			$("div[id='status']:eq("+i+")").html('제외');
			setTimeout("StudySmsSendProcess("+i2+",'"+send_mode+"')", 200);

		}else{

			$("div[id='status']:eq("+i+")").load('./study_sms_batch_process.php',
			{ 'Seq': $("input[id='check_seq_"+i+"']").val(),
				'send_mode': send_mode,
				'MessageMode': checked_value
			});

			setTimeout(function(){
				StudySmsSendProcess(i2,send_mode);
			},200);
		}


	}else{
		batching = false;
		alert("발송처리가 완료되었습니다.");
		$("#ProcesssRatio").hide();
		$("div[id='SysBg_White']").hide();
	}


}

function StudySmsEASend(Seq, MessageMode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
 
	$('#DataResult').load('./study_sms_ea.php', { MessageMode: MessageMode, Seq: Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '630px',
				left: body_width / 2 - 260,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function StudyIPChapter(Seq) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./study_ip_chapter.php', { Seq: Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '100px',
				width: '1200px',
				left: body_width / 2 - 600,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function StudyPaymentSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();

	if (SearchGubun == 'A') {
		if (StudyPeriod == '') {
			alert('기간을 선택하세요.');
			return;
		}
	}

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_payment_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function PriceAutoCal(type, i) {
	var CalPrice = 0;
	var BasicPrice = $('input[id="BasicPrice"]:eq(' + i + ')').val();
	var BankPrice = $('input[id="BankPrice"]:eq(' + i + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + i + ')').val();

	if (type == '1') {
		//통장 입금액 수정시
		if (BankPrice != '') {
			if (IsNumber(BankPrice) == false) {
				alert('금액은 숫자만 입력하세요.');
				$('input[id="BankPrice"]:eq(' + i + ')').val('0');
				return false;
			}
			CalPrice = BasicPrice - BankPrice;
			$('input[id="CardPrice"]:eq(' + i + ')').val(CalPrice);
		}
	}

	if (type == '2') {
		//카드 결제금액 수정시
		if (CardPrice != '') {
			if (IsNumber(CardPrice) == false) {
				alert('금액은 숫자만 입력하세요.');
				$('input[id="BankPrice"]:eq(' + i + ')').val('0');
				$('input[id="CardPrice"]:eq(' + i + ')').val(BasicPrice);
				return false;
			}
			CalPrice = BasicPrice - CardPrice;
			$('input[id="BankPrice"]:eq(' + i + ')').val(CalPrice);
		}
	}
}

function PaymentSave(k, LectureStart, LectureEnd, CompanyCode) {
	var BankPrice = $('input[id="BankPrice"]:eq(' + k + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'AmountSave';

	if (parseInt(BankPrice) < 0 || parseInt(CardPrice) < 0) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '사업자번호 [' + CompanyCode + ']의 금액을 저장하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study_payment_progress.php',
			{
				CompanyCode: CompanyCode,
				LectureStart: LectureStart,
				LectureEnd: LectureEnd,
				mode: mode,
				BankPrice: BankPrice,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PayStatusSave(k, LectureStart, LectureEnd, CompanyCode) {
	var BankPrice = $('input[id="BankPrice"]:eq(' + k + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PayStatusSave';

	if (parseInt(BankPrice) < 0 || parseInt(CardPrice) < 1000) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '사업자번호 [' + CompanyCode + ']의 결제를 요청하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study_payment_progress.php',
			{
				CompanyCode: CompanyCode,
				LectureStart: LectureStart,
				LectureEnd: LectureEnd,
				mode: mode,
				BankPrice: BankPrice,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PayStatusComplete(k, LectureStart, LectureEnd, CompanyCode) {
	var BankPrice = $('input[id="BankPrice"]:eq(' + k + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PayStatusComplete';

	if (parseInt(BankPrice) < 0 || parseInt(CardPrice) < 0) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '사업자번호 [' + CompanyCode + ']를 결제완료로 처리하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study_payment_progress.php',
			{
				CompanyCode: CompanyCode,
				LectureStart: LectureStart,
				LectureEnd: LectureEnd,
				mode: mode,
				BankPrice: BankPrice,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PayStatusCancelSave(k, LectureStart, LectureEnd, CompanyCode) {
	var BankPrice = $('input[id="BankPrice"]:eq(' + k + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PayStatusCancelSave';

	if (parseInt(BankPrice) < 0 || parseInt(CardPrice) < 0) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '사업자번호 [' + CompanyCode + ']의 결제요청을 취소하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study_payment_progress.php',
			{
				CompanyCode: CompanyCode,
				LectureStart: LectureStart,
				LectureEnd: LectureEnd,
				mode: mode,
				BankPrice: BankPrice,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PaymentCancelSave(k, LectureStart, LectureEnd, CompanyCode) {
	var BankPrice = $('input[id="BankPrice"]:eq(' + k + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PaymentCancelSave';

	if (parseInt(BankPrice) < 0 || parseInt(CardPrice) < 0) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '사업자번호 [' + CompanyCode + ']의 결제취소(환불) 처리하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study_payment_progress.php',
			{
				CompanyCode: CompanyCode,
				LectureStart: LectureStart,
				LectureEnd: LectureEnd,
				mode: mode,
				BankPrice: BankPrice,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PaymentRemarkSave(k, LectureStart, LectureEnd, CompanyCode) {
	var BankPrice = $('input[id="BankPrice"]:eq(' + k + ')').val();
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var PaymentRemark = $('textarea[id="PaymentRemark"]:eq(' + k + ')').val();
	var mode = 'RemarkSave';

	if (parseInt(BankPrice) < 0 || parseInt(CardPrice) < 0) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '사업자번호 [' + CompanyCode + ']의 메모를 저장하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study_payment_progress.php',
			{
				CompanyCode: CompanyCode,
				LectureStart: LectureStart,
				LectureEnd: LectureEnd,
				mode: mode,
				BankPrice: BankPrice,
				CardPrice: CardPrice,
				PaymentRemark: PaymentRemark,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function ExamExcelUploadListRoading(str) {
	$("div[id='ExcelUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');

	$("div[id='ExcelUploadList']").load('./exam_bank_excel_list.php', { str: str }, function () {});
}

var ExamBank_Regist_Seq_count = 0;

function ExamBankRegistSubmitOk() {
	ExamBank_Regist_Seq_count = $("input[id='check_seq']").length;

	if (ExamBank_Regist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 문제은행 등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 문제은행 등록 진행상황을\n\n확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			ExamBankRegistProcess(0);
		}
	}
}

function ExamBankRegistProcess(i) {
	if (i < ExamBank_Regist_Seq_count) {
		i2 = i + 1;
		$("span[id='ExamBankRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='ExamBankRegResult']:eq(" + i + ')').load('./exam_bank_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val() }, function () {
			setTimeout(function () {
				ExamBankRegistProcess(i2);
			}, 500);
		});
	} else {
		alert('문제은행 등록 처리가 완료되었습니다.\n\n\n\n등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.ExamExcelUploadListRoading('C');
	}
}

function ExamBankRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./exam_bank_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 250 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1100px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function ExamBankCheckedDelete() {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 문제은행이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('삭제하려는 항목을 선택하세요.');
		return;
	}

	Yes = confirm('선택한 항목을 정말 삭제하시겠습니까?\n\n삭제 후에는 되돌릴 수 없습니다.');

	if (Yes == true) {
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
				top: ScrollPosition + 200,
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./exam_bank_checked_delete.php',
			{
				seq_value: seq_value,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (data == 'Y') {
					alert('삭제 되었습니다.');
					location.reload();
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function CompanyRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./company_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 250 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1100px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function TestIDCreat() {
	var CreatCount = $('#CreatCount').val();

	Yes = confirm('심사용 테스트 아이디를 ' + CreatCount + '건 생성하시겠습니까?');
	if (Yes == true) {
		TestIDForm.submit();
	}
}

function TestIDView(LectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./course_testid_view.php', { LectureCode: LectureCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1100px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function UserCertManual(ID) {
	var url = './user_cert_manual.php?ID=' + ID;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=600, height=300');
}

function StudyCheckedKakaoTalk(mode) {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('발송하려는 항목을 선택하세요.');
		return;
	}

	switch (mode) {
		case 'Start':
			msg = '[개강1일전 문자보내기]';
			break;
		case 'Auth':
			msg = '[본인인증문자보내기]';
			break;
	}

	Yes = confirm('선택한 항목에 ' + msg + '를 실행하시겠습니까?');

	if (Yes == true) {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./study_search_checked_kakaotalk.php',
			{
				seq_value: seq_value,
				mode: mode,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (!data || data == '0') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					alert(data + '건의 문자 보내기가 완료되었습니다.');
				}
			}
		);
	}
}
function StudyChangeStartEndPeriod() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	var serviceTypeSelected = $('#ServiceType').val();


	searchValue = $('#search').serialize();
	popupAddress = './study_change_startendperiod_batch.php?' + searchValue;
	window.open(popupAddress, '수강기간변경', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function StudyOpenChapterChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	var serviceTypeSelected = $('#ServiceType').val();

	if (!serviceTypeSelected) {
		alert('환급여부를 선택하세요.');
		$('#serviceType').focus();
		return;
	}

	searchValue = $('#search').serialize();
	popupAddress = './study_openchapter_change_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function StudyCheckedEduManagerMail() {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('발송하려는 항목을 선택하세요.');
		return;
	}

	Yes = confirm('선택한 항목에 교육담당자 안내 메일 발송을 실행하시겠습니까?');

	if (Yes == true) {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./study_search_checked_edumanager_mail.php',
			{
				seq_value: seq_value,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (!data || data == '0') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					alert(data + '건의 메일 보내기가 완료되었습니다.');
				}
			}
		);
	}
}

//수료증
function CertificatePrint(Seq) {
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

	$('#DataResult').load('./certificate_layer.php', { Seq: Seq }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 300);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 300,
				width: '650px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition + 30 }, 300);
	});
}

function CertificatePrintPage(Seq) {
	var url = '/mypage/certificate_print01.php?Seq=' + Seq;
	window.open(url, 'certi', 'scrollbars=yes, resizable=no, left=400, width=820, height=700');
}

function CertificatePrintPDF(Seq) {
	var url = '/mypage/certificate_pdf01.php?Seq=' + Seq;
	window.open(url, 'certi', 'scrollbars=yes, resizable=no, left=400, width=820, height=700');
}

function StudyEndCertificatePrintPage(CompanyCode, LectureStart, LectureEnd, ServiceTypeYN) {
	var url = '/mypage/certificate_print02.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceTypeYN=' + ServiceTypeYN;
	window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function StudyEndCertificatePrintAllPDF(LectureStart, LectureEnd, CompanyName, ServiceType) {
	if(!CompanyName) {
		alert('검색창에 사업주명을 입력해주시기 바랍니다.');
	}else {
		var url = '/mypage/certificate_all_pdf03.php?LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&CompanyName=' + CompanyName + '&ServiceType=' + ServiceType;
		window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
	}
}

function StudyEndCertificatePrintPDF(CompanyCode, LectureStart, LectureEnd, ServiceType, LectureCode) {
	if(ServiceType =="1"){
		var url = '/mypage/certificate_pdf02.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&LectureCode=' + LectureCode;
		window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');		
	}else{
		var url = '/mypage/certificate_pdf03.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&LectureCode=' + LectureCode;
		window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
	}
}

function StudyEndDocument(CompanyCode, LectureStart, LectureEnd, ServiceType, LectureCode) {
	var url = './study_end_doc.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&LectureCode=' + LectureCode;
	window.open(url, 'doc', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function StudyEndAllDocument02(LectureStart, LectureEnd, CompanyName, ServiceType) {
	var url = './study_end_all_doc02.php?LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&CompanyName=' + CompanyName;
	window.open(url, 'doc', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function StudyEndDocument02(CompanyCode, LectureStart, LectureEnd, ServiceType, LectureCode) {
	var url = './study_end_doc02.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&LectureCode=' + LectureCode;
	window.open(url, 'doc', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function StudyEndAllDocument03(LectureStart, LectureEnd, CompanyName, ServiceType) {
	if(!CompanyName) {
		alert('검색창에 사업주명을 입력해주시기 바랍니다.');
	}else {
		var url = './study_end_all_doc03.php?LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&CompanyName=' + CompanyName;
		window.open(url, 'doc', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');		
	}
}

function StudyEndDocument03(CompanyCode, LectureStart, LectureEnd, ServiceType, LectureCode) {
	var url = './study_end_doc03.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&ServiceType=' + ServiceType + '&LectureCode=' + LectureCode;
	window.open(url, 'doc', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function StudyEndDocumentPoll(CompanyCode, LectureStart, LectureEnd, LectureCode) {
	var url = './study_end_doc_poll.php?CompanyCode=' + CompanyCode + '&LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&LectureCode=' + LectureCode;
	window.open(url, 'doc', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

function MessageRegist(ID) {
	var url = './message_write.php?ID=' + ID;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=600, height=600');
}

function MessageView(ID, Seq) {
	var url = './message_view.php?ID=' + ID + '&Seq=' + Seq;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=600, height=600');
}

function CounselPhoneRegist(ID, mode, idx) {
	var url = './counsel_phone_write.php?ID=' + ID + '&mode=' + mode + '&idx=' + idx;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=660, height=650');
}

function StudySalesChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	searchValue = $('#search').serialize();
	popupAddress = './study_sales_change_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function CompanySearchAutoCompleteGo() {
	var str = $('#CompanyName').val();
	str2 = str.replace(/\s/gi, '');
	str_len = str2.length;

	if (str_len > 0) {
		$('#CompanyAutoCompleteResult').load('./study_company_search_autocomplete.php', { CompanyName: str }, function () {
			$('#CompanyAutoCompleteResult').show();
		});
	} else {
		$('#CompanyAutoCompleteResult').html('');
		$('#CompanyAutoCompleteResult').hide();
	}
}

function CompanySearchAutoCompleteApply(CompanyName, CompanyCode) {
	$('#CompanyName').val(CompanyName);
	//CompanySearchLectureTermeSearch(CompanyCode);
	CompanySearchAutoCompleteClose();
}

function CompanySearchAutoCompleteClose() {
	$('#CompanyAutoCompleteResult').html('');
	$('#CompanyAutoCompleteResult').hide();
}
/*
function CompanySearchLectureTermeSearch(CompanyCode) {
	var SubmitFunction = $('#SubmitFunction').val();

	$("span[id='CompanySearchLectureTermeResult']").load(
		'./study_company_lectureterme.php',
		{ CompanyCode: CompanyCode, ctype: $('#ctype').val(), SubmitFunction: SubmitFunction },
		function () {
			setTimeout(SubmitFunction, 0);
		}
	);
}
*/

function StudyTutorChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	searchValue = $('#search').serialize();
	popupAddress = './study_tutor_change_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function Study2CheckedEnd() {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('수강마감 처리하려는 항목을 선택하세요.');
		return;
	}

	popupAddress = './study2_end_batch.php?seq_value=' + seq_value;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function TaxBillPublisherEdit() {
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

	$('#DataResult').load('./taxbill_publisher_info.php', { t: 'bill' }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 300);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 300,
				width: '650px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.fadeIn();

		$("div[id='Roading']").hide();
	});
}

function TaxBillPublisherSubmit() {
	val = document.TaxBillPublisherForm;

	if ($('#T_Saupno').val() == '') {
		alert('사업자번호를 입력하세요.\n\nex) 123-45-67890');
		$('#T_Saupno').focus();
		return;
	}
	if ($('#T_Saupno').val().length != 12) {
		alert('사업자번호를 정확하게 입력하세요.\n\nex) 123-45-67890');
		$('#T_Saupno').focus();
		return;
	}
	if ($('#T_CompanyName').val() == '') {
		alert('상호명을 입력하세요.');
		$('#T_CompanyName').focus();
		return;
	}
	if ($('#T_Ceo').val() == '') {
		alert('대표자명을 입력하세요.');
		$('#T_Ceo').focus();
		return;
	}
	if ($('#T_Address').val() == '') {
		alert('주소를 입력하세요.');
		$('#T_Address').focus();
		return;
	}
	if ($('#T_Uptae').val() == '') {
		alert('업태를 입력하세요.');
		$('#T_Uptae').focus();
		return;
	}
	if ($('#T_Upjong').val() == '') {
		alert('업종을 입력하세요.');
		$('#T_Upjong').focus();
		return;
	}
	if ($('#T_Name').val() == '') {
		alert('담당자명을 입력하세요.');
		$('#T_Name').focus();
		return;
	}
	if ($('#T_Email').val() == '') {
		alert('이메일을 입력하세요.');
		$('#T_Email').focus();
		return;
	}
	if ($('#T_Tel').val() == '') {
		alert('연락처를 입력하세요.');
		$('#T_Tel').focus();
		return;
	}

	Yes = confirm('세금계산서 발행자 정보를 변경하시겠습니까?');
	if (Yes == true) {
		val.submit();
	}
}

function TaxBillPriceCal(obj) {
	if (obj.value.length > 0) {
		str = obj.value;
		str2 = str.replace(/,/gi, '');

		if (IsNumber(str2) == false) {
			alert('공급가액은 숫자만 입력 하세요.');
			obj.value = '';
			obj.focus();
			return;
		}

		obj.value = FormatNumber2(str2);

		Bill_tax_type2 = 'Y';

		if (document.BillForm.Bill_tax_type[0].checked == true) {
			Bill_tax_type2 = 'Y';
		}
		if (document.BillForm.Bill_tax_type[1].checked == true) {
			Bill_tax_type2 = 'N';
		}

		if (document.BillForm.EA1_SumPrice.value == '') {
			SumPrice1 = 0;
			TaxPrice1 = 0;
		} else {
			SumPrice1 = document.BillForm.EA1_SumPrice.value;
			SumPrice1 = parseInt(SumPrice1.replace(/,/gi, ''));
			if (Bill_tax_type2 == 'Y') {
				TaxPrice1 = parseInt(SumPrice1 / 10);
				document.BillForm.EA1_SumPriceTax.value = FormatNumber2(TaxPrice1);
			} else {
				TaxPrice1 = 0;
				document.BillForm.EA1_SumPriceTax.value = FormatNumber2(TaxPrice1);
			}
		}

		if (document.BillForm.EA2_SumPrice.value == '') {
			SumPrice2 = 0;
			TaxPrice2 = 0;
		} else {
			SumPrice2 = document.BillForm.EA2_SumPrice.value;
			SumPrice2 = parseInt(SumPrice2.replace(/,/gi, ''));
			if (Bill_tax_type2 == 'Y') {
				TaxPrice2 = parseInt(SumPrice2 / 10);
				document.BillForm.EA2_SumPriceTax.value = FormatNumber2(TaxPrice2);
			} else {
				TaxPrice2 = 0;
				document.BillForm.EA2_SumPriceTax.value = FormatNumber2(TaxPrice2);
			}
		}

		if (document.BillForm.EA3_SumPrice.value == '') {
			SumPrice3 = 0;
			TaxPrice3 = 0;
		} else {
			SumPrice3 = document.BillForm.EA3_SumPrice.value;
			SumPrice3 = parseInt(SumPrice3.replace(/,/gi, ''));
			if (Bill_tax_type2 == 'Y') {
				TaxPrice3 = parseInt(SumPrice3 / 10);
				document.BillForm.EA3_SumPriceTax.value = FormatNumber2(TaxPrice3);
			} else {
				TaxPrice3 = 0;
				document.BillForm.EA3_SumPriceTax.value = FormatNumber2(TaxPrice3);
			}
		}

		if (document.BillForm.EA4_SumPrice.value == '') {
			SumPrice4 = 0;
			TaxPrice4 = 0;
		} else {
			SumPrice4 = document.BillForm.EA4_SumPrice.value;
			SumPrice4 = parseInt(SumPrice4.replace(/,/gi, ''));
			if (Bill_tax_type2 == 'Y') {
				TaxPrice4 = parseInt(SumPrice4 / 10);
				document.BillForm.EA4_SumPriceTax.value = FormatNumber2(TaxPrice4);
			} else {
				TaxPrice4 = 0;
				document.BillForm.EA4_SumPriceTax.value = FormatNumber2(TaxPrice4);
			}
		}

		SumPrice = SumPrice1 + SumPrice2 + SumPrice3 + SumPrice4;
		TaxPrice = TaxPrice1 + TaxPrice2 + TaxPrice3 + TaxPrice4;

		document.BillForm.SumPrice.value = FormatNumber2(SumPrice);
		document.BillForm.SumPriceTax.value = FormatNumber2(TaxPrice);

		document.BillForm.SumPrice2.value = FormatNumber2(SumPrice + TaxPrice);
	}
}

function TaxBillPriceCal2(obj1, obj2, obj3) {
	obj1_str = obj1.value;
	obj1_str2 = obj1_str.replace(/,/gi, '');

	obj2_str = obj2.value;
	obj2_str2 = obj2_str.replace(/,/gi, '');

	obj1_len = obj1_str2.length;
	obj2_len = obj2_str2.length;
	obj1_num = IsNumber(obj1_str2);
	obj2_num = IsNumber(obj2_str2);

	if (obj1_len > 0 && obj1_num == true && obj2_len > 0 && obj2_num == true) {
		obj3_value = obj1_str2 * obj2_str2;
		obj3.value = FormatNumber2(obj3_value);

		TaxBillPriceCal(obj3);
	}
}

function TaxBillSubmit() {
	val = document.BillForm;

	if (val.Saupno.value == '') {
		alert("사업자 번호를 입력하세요. '-' 포함 등록");
		val.Saupno.focus();
		return;
	}
	if (val.Saupno.value.length != 12) {
		alert("사업자번호를 정확하게 입력하세요.\n\nex) 123-45-67890 '-' 포함 등록");
		val.Saupno.focus();
		return;
	}
	if (val.BUY_SO_ID.value != '') {
		if (IsNumber(val.BUY_SO_ID.value) == false) {
			alert('종사업장번호는 숫자 4자리 이하로 입력 하세요.');
			val.BUY_SO_ID.value = '';
			val.BUY_SO_ID.focus();
			return;
		}
	}
	if (val.CompanyName.value == '') {
		alert('상호명을 입력하세요.');
		val.CompanyName.focus();
		return;
	}
	if (val.Ceo.value == '') {
		alert('대표자명을 입력하세요.');
		val.Ceo.focus();
		return;
	}
	if (val.Address.value == '') {
		alert('주소를 입력하세요.');
		val.Address.focus();
		return;
	}
	if (val.Uptae.value == '') {
		alert('업태를 입력하세요.');
		val.Uptae.focus();
		return;
	}
	if (val.Upjong.value == '') {
		alert('업종을 입력하세요.');
		val.Upjong.focus();
		return;
	}
	if (val.Email.value == '') {
		alert('이메일을 입력하세요.');
		val.Email.focus();
		return;
	}

	if (val.BillDateYear.value == '' || val.BillDateMonth.value == '' || val.BillDateDay.value == '') {
		alert('작성일자를 입력하세요.');
		val.BillDateYear.focus();
		return;
	}
	if (val.SumPrice.value == '') {
		alert('공급가액을 입력하세요.');
		val.EA1_SumPrice.focus();
		return;
	}
	if (val.EA1_DateYear.value == '' || val.EA1_DateMonth.value == '' || val.EA1_DateDay.value == '') {
		alert('품목별 작성일자를 입력하세요.');
		val.EA1_DateMonth.focus();
		return;
	}
	if (val.EA1_Title.value == '') {
		alert('품목을 입력하세요.');
		val.EA1_Title.focus();
		return;
	}
	if (val.EA1_SumPrice.value == '') {
		alert('품목별 공급가액을 입력하세요.');
		val.EA1_SumPrice.focus();
		return;
	}

	var BasicDate = val.NowDate.value;

	//작성일자 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	var BillDate_check = val.BillDateYear.value + '-' + val.BillDateMonth.value + '-' + val.BillDateDay.value;

	BillDateDiff = parseInt(DateDiffCheck(BillDate_check, BasicDate));

	if (BillDateDiff > 0) {
		alert('계산서의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
		return;
	}

	if (BillDateDiff < 0) {
		BillDateDiff_Yes = confirm(
			'계산서의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n작성일자에 문제가 없는 경우 [확인]을, 작성일자를 수정하시려면 [취소]를 선택하세요.'
		);
		if (BillDateDiff_Yes == false) {
			return;
		}
	}

	//품목1 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	var EA1_Date_check = val.EA1_DateYear.value + '-' + val.EA1_DateMonth.value + '-' + val.EA1_DateDay.value;

	EA1_DateDiff = parseInt(DateDiffCheck(EA1_Date_check, BasicDate));

	if (EA1_DateDiff > 0) {
		alert('품목의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
		return;
	}

	if (EA1_DateDiff < 0) {
		EA1_DateDiff_Yes = confirm(
			'품목의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목의 작성일자에 문제가 없는 경우 [확인]을, 품목의 작성일자를 수정하시려면 [취소]를 선택하세요.'
		);
		if (EA1_DateDiff_Yes == false) {
			return;
		}
	}

	//품목2 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	if (val.EA2_DateYear.value != '') {
		var EA2_Date_check = val.EA2_DateYear.value + '-' + val.EA2_DateMonth.value + '-' + val.EA2_DateDay.value;

		EA2_DateDiff = parseInt(DateDiffCheck(EA2_Date_check, BasicDate));

		if (EA2_DateDiff > 0) {
			alert('품목2의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
			return;
		}

		if (EA2_DateDiff < 0) {
			EA2_DateDiff_Yes = confirm(
				'품목2의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목2의 작성일자에 문제가 없는 경우 [확인]을, 품목2의 작성일자를 수정하시려면 [취소]를 선택하세요.'
			);
			if (EA2_DateDiff_Yes == false) {
				return;
			}
		}
	}

	//품목3 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	if (val.EA3_DateYear.value != '') {
		var EA3_Date_check = val.EA3_DateYear.value + '-' + val.EA3_DateMonth.value + '-' + val.EA3_DateDay.value;

		EA3_DateDiff = parseInt(DateDiffCheck(EA3_Date_check, BasicDate));

		if (EA3_DateDiff > 0) {
			alert('품목3의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
			return;
		}

		if (EA3_DateDiff < 0) {
			EA3_DateDiff_Yes = confirm(
				'품목3의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목3의 작성일자에 문제가 없는 경우 [확인]을, 품목3의 작성일자를 수정하시려면 [취소]를 선택하세요.'
			);
			if (EA3_DateDiff_Yes == false) {
				return;
			}
		}
	}

	//품목4 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	if (val.EA4_DateYear.value != '') {
		var EA4_Date_check = val.EA4_DateYear.value + '-' + val.EA4_DateMonth.value + '-' + val.EA4_DateDay.value;

		EA4_DateDiff = parseInt(DateDiffCheck(EA4_Date_check, BasicDate));

		if (EA4_DateDiff > 0) {
			alert('품목4의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
			return;
		}

		if (EA4_DateDiff < 0) {
			EA4_DateDiff_Yes = confirm(
				'품목4의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목4의 작성일자에 문제가 없는 경우 [확인]을, 품목4의 작성일자를 수정하시려면 [취소]를 선택하세요.'
			);
			if (EA4_DateDiff_Yes == false) {
				return;
			}
		}
	}

	Yes = confirm('세금계산서를 정보확인 및 발행 하시겠습니까?');

	if (Yes == true) {
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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./taxbill_write_check.php',
			{
				Saupno: $('#Saupno').val(),
				BUY_SO_ID: $('#BUY_SO_ID').val(),
				CompanyName: $('#CompanyName').val(),
				Ceo: $('#Ceo').val(),
				Address: $('#Address').val(),
				Uptae: $('#Uptae').val(),
				Upjong: $('#Upjong').val(),
				Depart: $('#Depart').val(),
				Name: $('#Name').val(),
				Email: $('#Email').val(),
				Tel: $('#Tel').val(),
				BillDateYear: $('#BillDateYear').val(),
				BillDateMonth: $('#BillDateMonth').val(),
				BillDateDay: $('#BillDateDay').val(),
				BillDateTemp: $('#BillDateTemp').val(),
				SumPrice: $('#SumPrice').val(),
				SumPriceTax: $('#SumPriceTax').val(),
				TAX_BIGO: $('#TAX_BIGO').val(),
				EA1_DateYear: $('#EA1_DateYear').val(),
				EA1_DateMonth: $('#EA1_DateMonth').val(),
				EA1_DateDay: $('#EA1_DateDay').val(),
				EA1_DateTemp: $('#EA1_DateTemp').val(),
				EA1_Title: $('#EA1_Title').val(),
				EA1_Count: $('#EA1_Count').val(),
				EA1_Price: $('#EA1_Price').val(),
				EA1_SumPrice: $('#EA1_SumPrice').val(),
				EA1_SumPriceTax: $('#EA1_SumPriceTax').val(),
				EA1_Remark: $('#EA1_Remark').val(),
				EA2_DateYear: $('#EA2_DateYear').val(),
				EA2_DateMonth: $('#EA2_DateMonth').val(),
				EA2_DateDay: $('#EA2_DateDay').val(),
				EA2_DateTemp: $('#EA2_DateTemp').val(),
				EA2_Title: $('#EA2_Title').val(),
				EA2_Count: $('#EA2_Count').val(),
				EA2_Price: $('#EA2_Price').val(),
				EA2_SumPrice: $('#EA2_SumPrice').val(),
				EA2_SumPriceTax: $('#EA2_SumPriceTax').val(),
				EA2_Remark: $('#EA2_Remark').val(),
				EA3_DateYear: $('#EA3_DateYear').val(),
				EA3_DateMonth: $('#EA3_DateMonth').val(),
				EA3_DateDay: $('#EA3_DateDay').val(),
				EA3_DateTemp: $('#EA3_DateTemp').val(),
				EA3_Title: $('#EA3_Title').val(),
				EA3_Count: $('#EA3_Count').val(),
				EA3_Price: $('#EA3_Price').val(),
				EA3_SumPrice: $('#EA3_SumPrice').val(),
				EA3_SumPriceTax: $('#EA3_SumPriceTax').val(),
				EA3_Remark: $('#EA3_Remark').val(),
				EA4_DateYear: $('#EA4_DateYear').val(),
				EA4_DateMonth: $('#EA4_DateMonth').val(),
				EA4_DateDay: $('#EA4_DateDay').val(),
				EA4_DateTemp: $('#EA4_DateTemp').val(),
				EA4_Title: $('#EA4_Title').val(),
				EA4_Count: $('#EA4_Count').val(),
				EA4_Price: $('#EA4_Price').val(),
				EA4_SumPrice: $('#EA4_SumPrice').val(),
				EA4_SumPriceTax: $('#EA4_SumPriceTax').val(),
				EA4_Remark: $('#EA4_Remark').val(),
				SumPrice2: $('#SumPrice2').val(),
				PayType: $('#PayType').val(),
				BillType: $('#BillType').val(),
				CourseUniq: $('#CourseUniq').val(),
			},
			function (data, status) {
				if (!data || data == '0') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					$('#DataResult').html(data);
					$("div[id='Roading']").hide();

					$("div[id='DataResult']")
						.css({
							top: ScrollPosition + 50,
							left: body_width / 2 - 500,
							width: '1000px',
							opacity: '1.0',
							position: 'absolute',
							'z-index': '1000',
						})
						.show();
				}
			}
		);
	}
}

function TaxBillPublishSubmit() {
	Yes = confirm('계산서를 발행하시겠습니까?');
	if (Yes == true) {
		BillForm2.submit();
	}
}

function TaxBillCompanySearch() {
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

	$('#DataResult').load('./taxbill_company_search.php', { t: 'bill' }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 300);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 600,
				width: '1100px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.fadeIn();

		$("div[id='Roading']").hide();
	});
}

function TaxBillCompanySearchSubmit() {
	if ($('#StrCompanyName').val() == '') {
		alert('상호명을 입력하세요.');
		$('#StrCompanyName').focus();
		return;
	}

	$('#TaxBillCompanySearchResult').load('./taxbill_company_search_result.php', { CompanyName: $('#StrCompanyName').val() }, function () {});
}

function TaxBillCompanySearchSelect(TableType, StrCompanyCode) {
	Yes = confirm('선택한 업체정보를 적용하시겠습니까?');
	if (Yes == true) {
		$('#TableType').val(TableType);
		$('#StrCompanyCode').val(StrCompanyCode);
		TaxBillSearchSelectForm.submit();
	}
}

function TaxBillEditSubmit() {
	val = document.BillForm;

	if (val.Saupno.value == '') {
		alert("사업자 번호를 입력하세요. '-' 포함 등록");
		val.Saupno.focus();
		return;
	}
	if (val.Saupno.value.length != 12) {
		alert("사업자번호를 정확하게 입력하세요.\n\nex) 123-45-67890 '-' 포함 등록");
		val.Saupno.focus();
		return;
	}
	if (val.BUY_SO_ID.value != '') {
		if (IsNumber(val.BUY_SO_ID.value) == false) {
			alert('종사업장번호는 숫자 4자리 이하로 입력 하세요.');
			val.BUY_SO_ID.value = '';
			val.BUY_SO_ID.focus();
			return;
		}
	}
	if (val.CompanyName.value == '') {
		alert('상호명을 입력하세요.');
		val.CompanyName.focus();
		return;
	}
	if (val.Ceo.value == '') {
		alert('대표자명을 입력하세요.');
		val.Ceo.focus();
		return;
	}
	if (val.Address.value == '') {
		alert('주소를 입력하세요.');
		val.Address.focus();
		return;
	}
	if (val.Uptae.value == '') {
		alert('업태를 입력하세요.');
		val.Uptae.focus();
		return;
	}
	if (val.Upjong.value == '') {
		alert('업종을 입력하세요.');
		val.Upjong.focus();
		return;
	}
	if (val.Email.value == '') {
		alert('이메일을 입력하세요.');
		val.Email.focus();
		return;
	}

	if (val.BillDateYear.value == '' || val.BillDateMonth.value == '' || val.BillDateDay.value == '') {
		alert('작성일자를 입력하세요.');
		val.BillDateYear.focus();
		return;
	}
	if (val.SumPrice.value == '') {
		alert('공급가액을 입력하세요.');
		val.EA1_SumPrice.focus();
		return;
	}
	if (val.EA1_DateYear.value == '' || val.EA1_DateMonth.value == '' || val.EA1_DateDay.value == '') {
		alert('품목별 작성일자를 입력하세요.');
		val.EA1_DateMonth.focus();
		return;
	}
	if (val.EA1_Title.value == '') {
		alert('품목을 입력하세요.');
		val.EA1_Title.focus();
		return;
	}
	if (val.EA1_SumPrice.value == '') {
		alert('품목별 공급가액을 입력하세요.');
		val.EA1_SumPrice.focus();
		return;
	}

	var BasicDate = val.NowDate.value;

	//작성일자 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	var BillDate_check = val.BillDateYear.value + '-' + val.BillDateMonth.value + '-' + val.BillDateDay.value;

	BillDateDiff = parseInt(DateDiffCheck(BillDate_check, BasicDate));

	if (BillDateDiff > 0) {
		alert('계산서의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
		return;
	}

	if (BillDateDiff < 0) {
		BillDateDiff_Yes = confirm(
			'계산서의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n작성일자에 문제가 없는 경우 [확인]을, 작성일자를 수정하시려면 [취소]를 선택하세요.'
		);
		if (BillDateDiff_Yes == false) {
			return;
		}
	}

	//품목1 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	var EA1_Date_check = val.EA1_DateYear.value + '-' + val.EA1_DateMonth.value + '-' + val.EA1_DateDay.value;

	EA1_DateDiff = parseInt(DateDiffCheck(EA1_Date_check, BasicDate));

	if (EA1_DateDiff > 0) {
		alert('품목의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
		return;
	}

	if (EA1_DateDiff < 0) {
		EA1_DateDiff_Yes = confirm(
			'품목의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목의 작성일자에 문제가 없는 경우 [확인]을, 품목의 작성일자를 수정하시려면 [취소]를 선택하세요.'
		);
		if (EA1_DateDiff_Yes == false) {
			return;
		}
	}

	//품목2 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	if (val.EA2_DateYear.value != '') {
		var EA2_Date_check = val.EA2_DateYear.value + '-' + val.EA2_DateMonth.value + '-' + val.EA2_DateDay.value;

		EA2_DateDiff = parseInt(DateDiffCheck(EA2_Date_check, BasicDate));

		if (EA2_DateDiff > 0) {
			alert('품목2의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
			return;
		}

		if (EA2_DateDiff < 0) {
			EA2_DateDiff_Yes = confirm(
				'품목2의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목2의 작성일자에 문제가 없는 경우 [확인]을, 품목2의 작성일자를 수정하시려면 [취소]를 선택하세요.'
			);
			if (EA2_DateDiff_Yes == false) {
				return;
			}
		}
	}

	//품목3 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	if (val.EA3_DateYear.value != '') {
		var EA3_Date_check = val.EA3_DateYear.value + '-' + val.EA3_DateMonth.value + '-' + val.EA3_DateDay.value;

		EA3_DateDiff = parseInt(DateDiffCheck(EA3_Date_check, BasicDate));

		if (EA3_DateDiff > 0) {
			alert('품목3의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
			return;
		}

		if (EA3_DateDiff < 0) {
			EA3_DateDiff_Yes = confirm(
				'품목3의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목3의 작성일자에 문제가 없는 경우 [확인]을, 품목3의 작성일자를 수정하시려면 [취소]를 선택하세요.'
			);
			if (EA3_DateDiff_Yes == false) {
				return;
			}
		}
	}

	//품목4 날짜 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	if (val.EA4_DateYear.value != '') {
		var EA4_Date_check = val.EA4_DateYear.value + '-' + val.EA4_DateMonth.value + '-' + val.EA4_DateDay.value;

		EA4_DateDiff = parseInt(DateDiffCheck(EA4_Date_check, BasicDate));

		if (EA4_DateDiff > 0) {
			alert('품목4의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
			return;
		}

		if (EA4_DateDiff < 0) {
			EA4_DateDiff_Yes = confirm(
				'품목4의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우 가산세가 부과될 있습니다.\n\n품목4의 작성일자에 문제가 없는 경우 [확인]을, 품목4의 작성일자를 수정하시려면 [취소]를 선택하세요.'
			);
			if (EA4_DateDiff_Yes == false) {
				return;
			}
		}
	}

	Yes = confirm('수정 세금계산서를 정보확인 및 발행 하시겠습니까?');

	if (Yes == true) {
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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./taxbill_edit_check.php',
			{
				Saupno: $('#Saupno').val(),
				BUY_SO_ID: $('#BUY_SO_ID').val(),
				CompanyName: $('#CompanyName').val(),
				Ceo: $('#Ceo').val(),
				Address: $('#Address').val(),
				Uptae: $('#Uptae').val(),
				Upjong: $('#Upjong').val(),
				Depart: $('#Depart').val(),
				Name: $('#Name').val(),
				Email: $('#Email').val(),
				Tel: $('#Tel').val(),
				BillDateYear: $('#BillDateYear').val(),
				BillDateMonth: $('#BillDateMonth').val(),
				BillDateDay: $('#BillDateDay').val(),
				BillDateTemp: $('#BillDateTemp').val(),
				SumPrice: $('#SumPrice').val(),
				SumPriceTax: $('#SumPriceTax').val(),
				TAX_BIGO: $('#TAX_BIGO').val(),
				EA1_DateYear: $('#EA1_DateYear').val(),
				EA1_DateMonth: $('#EA1_DateMonth').val(),
				EA1_DateDay: $('#EA1_DateDay').val(),
				EA1_DateTemp: $('#EA1_DateTemp').val(),
				EA1_Title: $('#EA1_Title').val(),
				EA1_Count: $('#EA1_Count').val(),
				EA1_Price: $('#EA1_Price').val(),
				EA1_SumPrice: $('#EA1_SumPrice').val(),
				EA1_SumPriceTax: $('#EA1_SumPriceTax').val(),
				EA1_Remark: $('#EA1_Remark').val(),
				EA2_DateYear: $('#EA2_DateYear').val(),
				EA2_DateMonth: $('#EA2_DateMonth').val(),
				EA2_DateDay: $('#EA2_DateDay').val(),
				EA2_DateTemp: $('#EA2_DateTemp').val(),
				EA2_Title: $('#EA2_Title').val(),
				EA2_Count: $('#EA2_Count').val(),
				EA2_Price: $('#EA2_Price').val(),
				EA2_SumPrice: $('#EA2_SumPrice').val(),
				EA2_SumPriceTax: $('#EA2_SumPriceTax').val(),
				EA2_Remark: $('#EA2_Remark').val(),
				EA3_DateYear: $('#EA3_DateYear').val(),
				EA3_DateMonth: $('#EA3_DateMonth').val(),
				EA3_DateDay: $('#EA3_DateDay').val(),
				EA3_DateTemp: $('#EA3_DateTemp').val(),
				EA3_Title: $('#EA3_Title').val(),
				EA3_Count: $('#EA3_Count').val(),
				EA3_Price: $('#EA3_Price').val(),
				EA3_SumPrice: $('#EA3_SumPrice').val(),
				EA3_SumPriceTax: $('#EA3_SumPriceTax').val(),
				EA3_Remark: $('#EA3_Remark').val(),
				EA4_DateYear: $('#EA4_DateYear').val(),
				EA4_DateMonth: $('#EA4_DateMonth').val(),
				EA4_DateDay: $('#EA4_DateDay').val(),
				EA4_DateTemp: $('#EA4_DateTemp').val(),
				EA4_Title: $('#EA4_Title').val(),
				EA4_Count: $('#EA4_Count').val(),
				EA4_Price: $('#EA4_Price').val(),
				EA4_SumPrice: $('#EA4_SumPrice').val(),
				EA4_SumPriceTax: $('#EA4_SumPriceTax').val(),
				EA4_Remark: $('#EA4_Remark').val(),
				SumPrice2: $('#SumPrice2').val(),
				PayType: $('#PayType').val(),
				BillType: $('#BillType').val(),
				CourseUniq: $('#CourseUniq').val(),
				amendMentCode: $('#amendMentCode').val(),
				AMDT_TYPE: $('#AMDT_TYPE').val(),
				Basic_Seq: $('#Basic_Seq').val(),
				BASIC_DOC_NUMBER: $('#BASIC_DOC_NUMBER').val(),
				TAX_TYPE: $('#TAX_TYPE').val(),
				Bill_tax_type: $('#Bill_tax_type').val(),
				BillRemark: $('#BillRemark').val(),
				TX_ISSUE_ID: $('#TX_ISSUE_ID').val(),
			},
			function (data, status) {
				if (!data || data == '0') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					$('#DataResult').html(data);
					$("div[id='Roading']").hide();

					$("div[id='DataResult']")
						.css({
							top: '100px',
							left: body_width / 2 - 500,
							width: '1000px',
							opacity: '1.0',
							position: 'absolute',
							'z-index': '1000',
						})
						.show();
				}
			}
		);
	}
}

function TaxBillEditPublishSubmit() {
	Yes = confirm('수정 계산서를 발행하시겠습니까?');
	if (Yes == true) {
		BillForm2.submit();
	}
}

function TaxBillEduPublish(CompanyCode, Price, CourseUniq, LectureStart, LectureEnd) {
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

	$('#DataResult').load(
		'./taxbill_edu_publish.php',
		{ CompanyCode: CompanyCode, Price: Price, CourseUniq: CourseUniq, LectureStart: LectureStart, LectureEnd: LectureEnd },
		function () {
			$("div[id='DataResult']")
				.css({
					top: ScrollPosition + 20,
					left: body_width / 2 - 500,
					width: '800px',
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
					cursor: 'move',
				})
				.fadeIn();

			$("div[id='Roading']").hide();

			$("div[id='DataResult']").draggable();
		}
	);
}

function TaxBillEduPublishSubmit() {
	val = document.TaxBillEduPublisherForm;

	if (val.Saupno.value == '') {
		alert('사업자 번호가 없습니다.');
		DataResultClose();
		return;
	}
	if (val.Saupno.value.length != 12) {
		alert('사업자번호를 정확하지 않습니다.');
		vDataResultClose();
		return;
	}
	if (val.BUY_SO_ID.value != '') {
		if (IsNumber(val.BUY_SO_ID.value) == false) {
			alert('종사업장번호는 숫자 4자리 이하로 입력 하세요.');
			val.BUY_SO_ID.value = '';
			val.BUY_SO_ID.focus();
			return;
		}
	}
	if (val.CompanyName.value == '') {
		alert('상호명을 확인하세요.');
		DataResultClose();
		return;
	}
	if (val.Ceo.value == '') {
		alert('대표자명을 확인하세요.');
		DataResultClose();
		return;
	}
	if (val.Address.value == '') {
		alert('주소를 입력하세요.');
		val.Address.focus();
		return;
	}
	if (val.BUY_BIZCOND.value == '') {
		alert('업태를 입력하세요.');
		val.BUY_BIZCOND.focus();
		return;
	}
	if (val.BUY_BIZITEM.value == '') {
		alert('업종을 입력하세요.');
		val.BUY_BIZITEM.focus();
		return;
	}
	if (val.gen_tm.value == '') {
		alert('작성일자를 입력하세요.');
		val.gen_tm.focus();
		return;
	}
	if (val.Price.value == '') {
		alert('총공급가액을 입력하세요.');
		val.Price.focus();
		return;
	}
	if (IsNumber(val.Price.value) == false) {
		alert('총공급가액은 숫자만 입력하세요.');
		val.Price.focus();
		return;
	}
	if (val.Price.value < 1000) {
		alert('총공급가액이 1000원 미만입니다. 총공급가액을 확인하세요.');
		val.Price.focus();
		return;
	}
	if (val.Name.value == '') {
		alert('담당자명을 입력하세요.');
		val.Name.focus();
		return;
	}
	if (val.buy_empemail.value == '') {
		alert('이메일을 입력하세요.');
		val.buy_empemail.focus();
		return;
	}

	var EA1_Title = '';
	var EA1_Count = '';
	var EA1_Price = '';
	var EA1_SumPrice = '';

	var EA2_Title = '';
	var EA2_Count = '';
	var EA2_Price = '';
	var EA2_SumPrice = '';

	var EA3_Title = '';
	var EA3_Count = '';
	var EA3_Price = '';
	var EA3_SumPrice = '';

	var EA4_Title = '';
	var EA4_Count = '';
	var EA4_Price = '';
	var EA4_SumPrice = '';

	var EA1_Title_len = $('#EA1_Title').length;
	var EA2_Title_len = $('#EA2_Title').length;
	var EA3_Title_len = $('#EA3_Title').length;
	var EA4_Title_len = $('#EA4_Title').length;

	if (EA1_Title_len > 0) {
		EA1_Title = $('#EA1_Title').val();
		EA1_Count = $('#EA1_Count').val();
		EA1_Price = $('#EA1_Price').val();
		EA1_SumPrice = $('#EA1_SumPrice').val();

		if (EA1_Count == '') {
			alert('품목1의 수량을 입력하세요.');
			$('#EA1_Count').focus();
			return;
		}
		if (IsNumber(EA1_Count) == false) {
			alert('품목1의 수량은 숫자만 입력하세요.');
			$('#EA1_Count').focus();
			return;
		}
		if (EA1_Count < 1) {
			alert('품목1의 수량을 확인하세요.');
			$('#EA1_Count').focus();
			return;
		}
		if (EA1_Price == '') {
			alert('품목1의 단가를 입력하세요.');
			$('#EA1_Price').focus();
			return;
		}
		if (IsNumber(EA1_Price) == false) {
			alert('품목1의 단가는 숫자만 입력하세요.');
			$('#EA1_Price').focus();
			return;
		}
		if (EA1_Price < 1000) {
			alert('품목1의 단가가 1000원 이하입니다. 단가를 확인하세요.');
			$('#EA1_Price').focus();
			return;
		}
		if (EA1_SumPrice == '') {
			alert('품목1의 공급가액을 입력하세요.');
			$('#EA1_SumPrice').focus();
			return;
		}
		if (IsNumber(EA1_SumPrice) == false) {
			alert('품목1의 공급가액은 숫자만 입력하세요.');
			$('#EA1_SumPrice').focus();
			return;
		}
		if (EA1_SumPrice < 1000) {
			alert('품목1의 공급가액이 1000원 이하입니다. 공급가액을 확인하세요.');
			$('#EA1_SumPrice').focus();
			return;
		}
		if (EA1_SumPrice != EA1_Count * EA1_Price) {
			alert('품목1의 수량과 단가가 공급가액과 일치하지 않습니다.');
			$('#EA1_SumPrice').focus();
			return;
		}
	} else {
		EA1_Title = '';
		EA1_Count = 0;
		EA1_Price = 0;
		EA1_SumPrice = 0;
	}

	if (EA2_Title_len > 0) {
		EA2_Title = $('#EA2_Title').val();
		EA2_Count = $('#EA2_Count').val();
		EA2_Price = $('#EA2_Price').val();
		EA2_SumPrice = $('#EA2_SumPrice').val();

		if (EA2_Count == '') {
			alert('품목2의 수량을 입력하세요.');
			$('#EA2_Count').focus();
			return;
		}
		if (IsNumber(EA2_Count) == false) {
			alert('품목2의 수량은 숫자만 입력하세요.');
			$('#EA2_Count').focus();
			return;
		}
		if (EA2_Count < 1) {
			alert('품목2의 수량을 확인하세요.');
			$('#EA2_Count').focus();
			return;
		}
		if (EA2_Price == '') {
			alert('품목2의 단가를 입력하세요.');
			$('#EA2_Price').focus();
			return;
		}
		if (IsNumber(EA2_Price) == false) {
			alert('품목2의 단가는 숫자만 입력하세요.');
			$('#EA2_Price').focus();
			return;
		}
		if (EA2_Price < 1000) {
			alert('품목2의 단가가 1000원 이하입니다. 단가를 확인하세요.');
			$('#EA2_Price').focus();
			return;
		}
		if (EA2_SumPrice == '') {
			alert('품목2의 공급가액을 입력하세요.');
			$('#EA2_SumPrice').focus();
			return;
		}
		if (IsNumber(EA2_SumPrice) == false) {
			alert('품목2의 공급가액은 숫자만 입력하세요.');
			$('#EA2_SumPrice').focus();
			return;
		}
		if (EA2_SumPrice < 1000) {
			alert('품목2의 공급가액이 1000원 이하입니다. 공급가액을 확인하세요.');
			$('#EA2_SumPrice').focus();
			return;
		}
		if (EA2_SumPrice != EA2_Count * EA2_Price) {
			alert('품목2의 수량과 단가가 공급가액과 일치하지 않습니다.');
			$('#EA2_SumPrice').focus();
			return;
		}
	} else {
		EA2_Title = '';
		EA2_Count = 0;
		EA2_Price = 0;
		EA2_SumPrice = 0;
	}

	if (EA3_Title_len > 0) {
		EA3_Title = $('#EA3_Title').val();
		EA3_Count = $('#EA3_Count').val();
		EA3_Price = $('#EA3_Price').val();
		EA3_SumPrice = $('#EA3_SumPrice').val();

		if (EA3_Count == '') {
			alert('품목3의 수량을 입력하세요.');
			$('#EA3_Count').focus();
			return;
		}
		if (IsNumber(EA3_Count) == false) {
			alert('품목3의 수량은 숫자만 입력하세요.');
			$('#EA3_Count').focus();
			return;
		}
		if (EA3_Count < 1) {
			alert('품목3의 수량을 확인하세요.');
			$('#EA3_Count').focus();
			return;
		}
		if (EA3_Price == '') {
			alert('품목3의 단가를 입력하세요.');
			$('#EA3_Price').focus();
			return;
		}
		if (IsNumber(EA3_Price) == false) {
			alert('품목3의 단가는 숫자만 입력하세요.');
			$('#EA3_Price').focus();
			return;
		}
		if (EA3_Price < 1000) {
			alert('품목3의 단가가 1000원 이하입니다. 단가를 확인하세요.');
			$('#EA3_Price').focus();
			return;
		}
		if (EA3_SumPrice == '') {
			alert('품목3의 공급가액을 입력하세요.');
			$('#EA3_SumPrice').focus();
			return;
		}
		if (IsNumber(EA3_SumPrice) == false) {
			alert('품목3의 공급가액은 숫자만 입력하세요.');
			$('#EA3_SumPrice').focus();
			return;
		}
		if (EA3_SumPrice < 1000) {
			alert('품목3의 공급가액이 1000원 이하입니다. 공급가액을 확인하세요.');
			$('#EA3_SumPrice').focus();
			return;
		}
		if (EA3_SumPrice != EA3_Count * EA3_Price) {
			alert('품목3의 수량과 단가가 공급가액과 일치하지 않습니다.');
			$('#EA3_SumPrice').focus();
			return;
		}
	} else {
		EA3_Title = '';
		EA3_Count = 0;
		EA3_Price = 0;
		EA3_SumPrice = 0;
	}

	if (EA4_Title_len > 0) {
		EA4_Title = $('#EA4_Title').val();
		EA4_Count = $('#EA4_Count').val();
		EA4_Price = $('#EA4_Price').val();
		EA4_SumPrice = $('#EA4_SumPrice').val();

		if (EA4_Count == '') {
			alert('품목4의 수량을 입력하세요.');
			$('#EA4_Count').focus();
			return;
		}
		if (IsNumber(EA4_Count) == false) {
			alert('품목4의 수량은 숫자만 입력하세요.');
			$('#EA4_Count').focus();
			return;
		}
		if (EA4_Count < 1) {
			alert('품목4의 수량을 확인하세요.');
			$('#EA4_Count').focus();
			return;
		}
		if (EA4_Price == '') {
			alert('품목4의 단가를 입력하세요.');
			$('#EA4_Price').focus();
			return;
		}
		if (IsNumber(EA4_Price) == false) {
			alert('품목4의 단가는 숫자만 입력하세요.');
			$('#EA4_Price').focus();
			return;
		}
		if (EA4_Price < 1000) {
			alert('품목4의 단가가 1000원 이하입니다. 단가를 확인하세요.');
			$('#EA4_Price').focus();
			return;
		}
		if (EA4_SumPrice == '') {
			alert('품목4의 공급가액을 입력하세요.');
			$('#EA4_SumPrice').focus();
			return;
		}
		if (IsNumber(EA4_SumPrice) == false) {
			alert('품목4의 공급가액은 숫자만 입력하세요.');
			$('#EA4_SumPrice').focus();
			return;
		}
		if (EA4_SumPrice < 1000) {
			alert('품목4의 공급가액이 1000원 이하입니다. 공급가액을 확인하세요.');
			$('#EA4_SumPrice').focus();
			return;
		}
		if (EA4_SumPrice != EA4_Count * EA4_Price) {
			alert('품목4의 수량과 단가가 공급가액과 일치하지 않습니다.');
			$('#EA4_SumPrice').focus();
			return;
		}
	} else {
		EA4_Title = '';
		EA4_Count = 0;
		EA4_Price = 0;
		EA4_SumPrice = 0;
	}

	var TempSumPrice = parseInt(EA1_SumPrice) + parseInt(EA2_SumPrice) + parseInt(EA3_SumPrice) + parseInt(EA4_SumPrice);

	if (val.Price.value != TempSumPrice) {
		alert('품목의 공급가액의 합이 총공급가액과 일치하지 않습니다.');
		return;
	}

	//작성일자 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------
	var BasicDate = val.NowDate.value;
	var BillDate_check = val.gen_tm.value;

	BillDateDiff = parseInt(DateDiffCheck(BillDate_check, BasicDate));

	if (BillDateDiff > 0) {
		alert('계산서의 작성일자가 미래 날짜입니다.\n\n미래 날짜로 계산서를 발행할 수 없습니다.\n\n작성일자를 확인하세요.');
		return;
	}

	if (BillDateDiff < 0) {
		BillDateDiff_Yes = confirm(
			'계산서의 작성일자가 과거 날짜입니다.\n\n과거일자로 계산서 발행시 이미 부가가치세 신고 기간이 지난 경우\n\n가산세가 부과될 있습니다.\n\n\n\n작성일자에 문제가 없는 경우 [확인]을,\n\n작성일자를 수정하시려면 [취소]를 선택하세요.'
		);
		if (BillDateDiff_Yes == false) {
			return;
		}
	}

	//작성일자 미래인지 과거 인지 확인하는 부분-----------------------------------------------------------------

	Yes = confirm('세금 계산서를 발행하시겠습니까?');
	if (Yes == true) {
		val.submit();
	}
}

function TaxBillEduPublishCal(Count, Price, SumPrice) {
	var EA_Count = $('#' + Count).val();
	var EA_Price = $('#' + Price).val();
	var EA_SumPrice = $('#' + SumPrice).val();

	if (EA_Count == '') {
		alert('품목의 수량을 입력하세요.');
		$('#' + Count).focus();
		return;
	}
	if (IsNumber(EA_Count) == false) {
		alert('품목의 수량은 숫자만 입력하세요.');
		$('#' + Count).focus();
		return;
	}
	if (EA_Count < 1) {
		alert('품목의 수량을 확인하세요.');
		$('#' + Count).focus();
		return;
	}

	if (EA_Price == '') {
		alert('품목의 단가를 입력하세요.');
		$('#' + Price).focus();
		return;
	}
	if (IsNumber(EA_Price) == false) {
		alert('품목의 단가는 숫자만 입력하세요.');
		$('#' + Price).focus();
		return;
	}
	/*
	if(EA_Price<1000) {
		alert("품목의 단가가 1000원 이하입니다  단가를 확인하세요.");
		$("#"+Price).focus();
		return;
	}
	*/

	$('#' + SumPrice).val(parseInt(EA_Count * EA_Price));
}

function DeptOrderBy() {
	var idx_arrary = '';
	var idx_temp_count = $("input[id='sales_idx']").length;

	for (i = 0; i < idx_temp_count; i++) {
		if (idx_arrary == '') {
			idx_arrary = $("input[id='sales_idx']:eq(" + i + ')').val();
		} else {
			idx_arrary = idx_arrary + '|' + $("input[id='sales_idx']:eq(" + i + ')').val();
		}
	}

	Yes = confirm('영업부서를 정렬하시겠습니까?');
	if (Yes == true) {
		$("input[id='idx_value']").val(idx_arrary);
		OrderByForm.submit();
	}
}

function SaleStaDeptSelect() {
	var url = './sale_sta_dept_select.php';
	window.open(url, 'ad', 'scrollbars=yes, resizable=no, left=400, width=800, height=600');
}

function SaleStaSearch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var Dept_idx = $('#Dept_idx').val();
	var DeptString = $('#DeptString').val();
	var StartColume = $('#StartColume').val();
	var EndColume = $('#EndColume').val();
	var LectureStart = $('#LectureStart').val();
	var LectureEnd = $('#LectureEnd').val();
	var SalesID = $('#SalesID').val();
	/*
	if(DeptString=="" && SalesID=="") {
		alert("영업자 또는 영업부서를 선택하세요.");
		return;
	}
	*/
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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./sale_sta_search_result.php',
		{
			Dept_idx: Dept_idx,
			DeptString: DeptString,
			StartColume: StartColume,
			EndColume: EndColume,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			SalesID: SalesID,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function SaleStaDeptExcel() {
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 통계자료가 없습니다.');
		return;
	}

	$('#TOT_NO').val($('#TotalCount').val());

	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'sale_sta_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function SaleStaDeptDetail(ID) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var Dept_idx = $('#Dept_idx').val();
	var DeptString = $('#DeptString').val();
	var StartColume = $('#StartColume').val();
	var EndColume = $('#EndColume').val();
	var LectureStart = $('#LectureStart').val();
	var LectureEnd = $('#LectureEnd').val();

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load(
		'./sale_sta_result_detail.php',
		{
			Dept_idx: Dept_idx,
			DeptString: DeptString,
			StartColume: StartColume,
			EndColume: EndColume,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			SalesID: ID,
		},
		function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 200 }, 500);
			$("div[id='DataResult']")
				.css({
					top: '250px',
					width: '1100px',
					left: body_width / 2 - 500,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();
		}
	);
}

function StudyPriceResettingBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	searchValue = $('#search').serialize();
	popupAddress = './study_price_resetting_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

function MainCourseAdd() {
	val = document.AddForm;

	if ($('#LectureCode').val() == '') {
		alert('추가하려는 과정을 선택하세요.');
		$('#LectureCode').focus();
		return;
	}

	Yes = confirm('추가하시겠습니까?');
	if (Yes == true) {
		val.submit();
	}
}

function MainCourseDelete(idx, LectureCode) {
	val = document.DeleteForm;

	Yes = confirm('삭제하시겠습니까?');
	if (Yes == true) {
		val.idx.value = idx;
		val.LectureCode.value = LectureCode;
		val.submit();
	}
}

function MainCourseOrderBy() {
	var idx_arrary = '';
	var idx_temp_count = $("input[id='course_idx']").length;

	for (i = 0; i < idx_temp_count; i++) {
		if (idx_arrary == '') {
			idx_arrary = $("input[id='course_idx']:eq(" + i + ')').val();
		} else {
			idx_arrary = idx_arrary + '|' + $("input[id='course_idx']:eq(" + i + ')').val();
		}
	}

	if (idx_arrary == '') {
		alert('등록된 과정이 없습니다.');
		return;
	}

	Yes = confirm('정렬하시겠습니까?');
	if (Yes == true) {
		$("input[id='idx_value']").val(idx_arrary);
		OrderByForm.submit();
	}
}

function ContentsExcelUploadListRoading(str) {
	$("div[id='ContentsUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');

	$("div[id='ContentsUploadList']").load('./contents_excel_list.php', { str: str }, function () {});
}

var Contents_Regist_Seq_count = 0;

function ContentsRegistSubmitOk() {
	Contents_Regist_Seq_count = $("input[id='check_seq']").length;

	if (Contents_Regist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 기초차시 등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 기초차시 등록 진행상황을\n\n확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			ContentsRegistProcess(0);
		}
	}
}

function ContentsRegistProcess(i) {
	if (i < Contents_Regist_Seq_count) {
		i2 = i + 1;
		$("span[id='ContentsRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='ContentsRegResult']:eq(" + i + ')').load('./contents_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val() }, function () {
			setTimeout(function () {
				ContentsRegistProcess(i2);
			}, 500);
		});
	} else {
		alert('기초차시 등록 처리가 완료되었습니다.\n\n\n\n등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.ContentsExcelUploadListRoading('C');
	}
}

function ContentsRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./contents_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 120 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1100px',
				left: body_width / 2 - 600,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function StudyPaymentSearch2(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var ReportCopy = $('#ReportCopy').val();
	var Tutor = $('#Tutor').val();
	var EduManager = $('#EduManager').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

	if (TotalScore1 != '' || TotalScore2 != '') {
		if (IsNumber(TotalScore1) == false || IsNumber(TotalScore2) == false) {
			alert('총점은 숫자만 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study2_payment_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			Tutor: Tutor,
			EduManager: EduManager,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function PaymentSave2(k, ID, Seq) {
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'AmountSave';

	if (IsNumber(CardPrice) == false) {
		alert('카드 결제 금액은 숫자만 입력하세요.');
		$('input[id="CardPrice"]:eq(' + i + ')').focus();
		return false;
	}

	if (parseInt(CardPrice) < 1000) {
		alert('카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '아이디 [' + ID + ']의 금액을 저장하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study2_payment_progress.php',
			{
				ID: ID,
				Seq: Seq,
				mode: mode,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch2(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PayStatusSave2(k, ID, Seq) {
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PayStatusSave';

	if (IsNumber(CardPrice) == false) {
		alert('카드 결제 금액은 숫자만 입력하세요.');
		$('input[id="CardPrice"]:eq(' + i + ')').focus();
		return false;
	}

	if (parseInt(CardPrice) < 1000) {
		alert('카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '아이디 [' + ID + ']의 결제를 요청하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study2_payment_progress.php',
			{
				ID: ID,
				Seq: Seq,
				mode: mode,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch2(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PayStatusComplete2(k, ID, Seq) {
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PayStatusComplete';

	if (IsNumber(CardPrice) == false) {
		alert('카드 결제 금액은 숫자만 입력하세요.');
		$('input[id="CardPrice"]:eq(' + i + ')').focus();
		return false;
	}

	if (parseInt(CardPrice) < 0) {
		alert('카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '아이디 [' + ID + ']를 결제완료로 처리하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study2_payment_progress.php',
			{
				ID: ID,
				Seq: Seq,
				mode: mode,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch2(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PayStatusCancelSave2(k, ID, Seq) {
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PayStatusCancelSave';

	if (IsNumber(CardPrice) == false) {
		alert('카드 결제 금액은 숫자만 입력하세요.');
		$('input[id="CardPrice"]:eq(' + i + ')').focus();
		return false;
	}

	if (parseInt(CardPrice) < 0) {
		alert('카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '아이디 [' + ID + ']의 결제요청을 취소하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study2_payment_progress.php',
			{
				ID: ID,
				Seq: Seq,
				mode: mode,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch2(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PaymentCancelSave2(k, ID, Seq) {
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var mode = 'PaymentCancelSave';

	if (IsNumber(CardPrice) == false) {
		alert('카드 결제 금액은 숫자만 입력하세요.');
		$('input[id="CardPrice"]:eq(' + i + ')').focus();
		return false;
	}

	if (parseInt(CardPrice) < 0) {
		alert('통장 입금액 또는 카드 결제금액이 정상적이지 않습니다.\n\n금액을 확인하세요.');
		return;
	}

	var msg = '아이디 [' + ID + ']의 결제취소(환불) 처리하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study2_payment_progress.php',
			{
				ID: ID,
				Seq: Seq,
				mode: mode,
				CardPrice: CardPrice,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch2(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function PaymentRemarkSave2(k, ID, Seq) {
	var CardPrice = $('input[id="CardPrice"]:eq(' + k + ')').val();
	var PaymentRemark = $('textarea[id="PaymentRemark"]:eq(' + k + ')').val();
	var mode = 'RemarkSave';

	if (IsNumber(CardPrice) == false) {
		alert('카드 결제 금액은 숫자만 입력하세요.');
		$('input[id="CardPrice"]:eq(' + i + ')').focus();
		return false;
	}

	var msg = '아이디 [' + ID + ']의 메모를 저장하시겠습니까?';

	Yes = confirm(msg);

	if (Yes == true) {
		$.post(
			'./study2_payment_progress.php',
			{
				ID: ID,
				Seq: Seq,
				mode: mode,
				CardPrice: CardPrice,
				PaymentRemark: PaymentRemark,
			},
			function (data, status) {
				if (data == 'Y') {
					StudyPaymentSearch2(1);
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

function InformationProtection(TB, Field, ele, ID, url, Exp) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$('#DataResult2').load('./Information_protection_regist.php', { TB: TB, Field: Field, ele: ele, ID: ID, url: url, Exp: Exp }, function () {
		//$("div[id='Roading']").hide();

		$("div[id='DataResult2']")
			.css({
				top: '250px',
				width: '700px',
				left: body_width / 2 - 400,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '10000',
			})
			.show();
	});
}

function InformationProtectionView(TB, Field, ele, ID) {
	$.post(
		'./Information_protection.php',
		{
			TB: TB,
			Field: Field,
			ele: ele,
			ID: ID,
		},
		function (data, status) {
			setTimeout(function () {
				//$("#"+ele).html(data);
				$("span[id='" + ele + "']").html(data);
				//$("div[id='SysBg_White']").hide();
			}, 100);
		}
	);
}

function InformationProtectionSubmitOk() {
	if (document.InformationProtectionForm.Content.value == '') {
		alert('사유를 입력하세요.');
		return;
	}

	Yes = confirm('개인정보 열람사유를 작성하시겠습니까?');
	if (Yes == true) {
		document.InformationProtectionForm.submit();
	}
}

function SimpleAskDelete(Name, idx) {
	var mode = 'D';

	Yes = confirm('[' + Name + ']님의 간편문의 내역을 삭제하시겠습니까?');
	if (Yes == true) {
		$.post('./simple_ask_change.php', { idx: idx, mode: mode }, function (data) {
			if (data == 'Success') {
				alert('삭제되었습니다.');
			} else {
				alert('오류가 발생했습니다.');
			}

			location.reload();
		});
	}
}

function SimpleAskDetail(idx) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./simple_ask_detail.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '850px',
				left: body_width / 2 - 420,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function SimpleAskDetailChange() {
	var mode = 'S';

	idx = $('#SimpleAsk_idx').val();
	Status = $('#SimpleAskStatus').val();

	Yes = confirm('상태를 변경 하시겠습니까?');
	if (Yes == true) {
		$.post('./simple_ask_change.php', { idx: idx, Status: Status, mode: mode }, function (data) {
			if (data == 'Success') {
				alert('변경되었습니다.');
			} else {
				alert('오류가 발생했습니다.');
			}

			location.reload();
		});
	}
}

function InformationProtectionUrl(TB, url, Exp, send_url, ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$('#DataResult2').load('./Information_protection_regist2.php', { TB: TB, url: url, Exp: Exp, send_url: send_url, ID: ID }, function () {
		//$("div[id='Roading']").hide();

		$("div[id='DataResult2']")
			.css({
				top: '250px',
				width: '700px',
				left: body_width / 2 - 400,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '10000',
			})
			.show();
	});
}

function InformationProtectionSubmitOk2() {
	if (document.InformationProtectionForm.Content.value == '') {
		alert('사유를 입력하세요.');
		return;
	}

	Yes = confirm('개인정보 열람사유를 작성하시겠습니까?');
	if (Yes == true) {
		document.InformationProtectionForm.submit();
	}
}

function CaptionUploadFile(Ele, EleArea) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$('#DataResult2').load('./caption_upload_file.php', { Ele: Ele, EleArea: EleArea }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult2']")
			.css({
				top: '600px',
				width: '800px',
				left: body_width / 2 - 650,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '10000',
			})
			.show();
	});
}

function CaptionUploadFileSubmitOk() {
	if ($('#file').val() == '') {
		alert('파일을 선택하세요.');
		$('#file').focus();
		return;
	}

	Yes = confirm('업로드 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn2').hide();
		$('#Waiting2').show();
		UploadForm1.submit();
	}
}

function CaptionUploadFileDelete(Ele, EleArea) {
	$('#' + Ele).val('');
	$('#' + EleArea).html('');
}

function LectureCodeSelected(){
	var lectureCodeText = $("#LectureCode option:selected").text();
	var serviceTypeSelected = lectureCodeText.split('|').pop().trim();
	if(serviceTypeSelected){
		if(serviceTypeSelected=="환급"){
			serviceTypeSelected = "사업주지원(환급)";
		}
		$(`#ServiceType option:contains(${serviceTypeSelected})`).prop("selected",true);
	}
}

function salesIdSelected(){
	var salesIdSelected = $("#SalesID").val();
	var salesIdText = $("#SalesID option:selected").text();
	var salesTeamText = "";
	if(salesIdSelected!=""){
		salesTeamText = salesIdText.split('|').pop().trim();
		$("#SalesTeam").val(salesTeamText).trigger('change');
	}
}

function salesTeamSelected(){
	var salesTeamSelected = $("#SalesTeam").val();
	var salesIdText = $("#SalesID option:selected").text();
	var salesTeamText = salesIdText.split('|').pop().trim();
	
	if((salesTeamSelected== "") || (salesTeamSelected != salesTeamText)){
		$("#SalesID").val('').trigger('change');
	}
}


function DiscussionListSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	 
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./discussion_list_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function DiscussionRemark(Seq) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
 
	$('#DataResult').load('./discuss_remark.php', { Seq: Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '630px',
				left: body_width / 2 - 260,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}
