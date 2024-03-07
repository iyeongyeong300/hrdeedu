//공통 함수 ------------------------------------------------------------------------------------------------------

if(location.protocol == "http:")
{
	location.href = location.href.replace("http://","https://");
}


if(location.hostname != "m.hrdeedu.com")
{
	location.href = location.href.replace(location.hostname,"m.hrdeedu.com");
}


function MenuOpen() {

	if($('#AllMenu').css("display") == "none" ) {
		//$("#MenuBtn").prop('src','/images/common/header_sitemenu_close.png');
		//$("#MenuBtn").prop('alt','메뉴닫기');
		$('#AllMenu').show('slide', {direction : 'left'}, 200);
	}else{
		//$("#MenuBtn").prop('src','/images/common/header_sitemenu.png');
		//$("#MenuBtn").prop('alt','전체메뉴');
		$('#AllMenu').hide('slide', {direction : 'left'}, 200);
	}

}



function TopMove() {
	$('html, body').animate({ scrollTop : 0 }, 300);
}


function BoardSearch() {
	if($("#sw").val()=="") {
		alert("검색어를 입력하세요.");
		$("#sw").focus();
		return;
	}

	BoardSearchForm.submit();
}

//페이지 이동 관련
function pageRun(num)
{
	document.listScriptForm.pg.value = num;
	document.listScriptForm.submit();
}

function readRun(idx)
{
	document.ReadScriptForm.idx.value = idx;
	document.ReadScriptForm.submit();
}

function LoginSubmit() {

	var checked_value = $(":radio[name='MemberType']:checked").val();

	if(checked_value==undefined) {
		checked_value = "";
	}

	if(checked_value=="") {
		alert("회원구분을 선택하세요.");
		return;
	}

	if($("#ID").val()=="") {
		alert("아이디를 입력하세요.");
		$("#ID").focus();
		return;
	}

	if($("#Pwd").val()=="") {
		alert("비밀번호를 입력하세요.");
		$("#Pwd").focus();
		return;
	}

	LoginForm.submit();

}

//나의 강의실 강의 상세정보 확장하기
function LectureDetailToggle(i) {

	$("ul[id='LectureDetail']:eq("+i+")").toggle();
		
	if($("ul[id='LectureDetail']:eq("+i+")").css("display") == "none" ) {
		$("img[id='LectureDetailOpenImg']:eq("+i+")").prop("src","images/common/btnbul_lecture_open.png");
		$("img[id='LectureDetailOpenImg']:eq("+i+")").prop("alt","열기");
		$("ul[id='LectureDetailUL']:eq("+i+")").removeClass("show");
		$("li[id='LectureDetailLI']:eq("+i+")").removeClass("btnArea_close");
		$("li[id='LectureDetailLI']:eq("+i+")").addClass("btnArea_open");
	}else{
		$("img[id='LectureDetailOpenImg']:eq("+i+")").prop("src","images/common/btnbul_lecture_close.png");
		$("img[id='LectureDetailOpenImg']:eq("+i+")").prop("alt","닫기");
		$("ul[id='LectureDetailUL']:eq("+i+")").addClass("show");
		$("li[id='LectureDetailLI']:eq("+i+")").removeClass("btnArea_open");
		$("li[id='LectureDetailLI']:eq("+i+")").addClass("btnArea_close");
	}

}

function PlayNext() {

	var Player = document.getElementById("mPlayer");

	var ContentsMobilePage = $("#ContentsMobilePage").val();
	var ContentsMobileNowPage = $("#ContentsMobileNowPage").val();
	var PlayPath = $("#PlayPath").val();
	var ContentsMobileNextPage = parseInt(ContentsMobileNowPage) + 1;

	PlayPath_array = PlayPath.split('/'); //경로와 파일명을 분리하기 위해

	var FileName = PlayPath_array[PlayPath_array.length-1]; //배열의 마지막 부분이 파일명

	FileNameSplit = FileName.split('.'); //확장자 제거를 위해

	var FileNameSplit_First = FileNameSplit[0]; //확장자를 제거(.mp4)한 순수 파일명

	var FileNameSplit_First_length = FileNameSplit_First.length; //파일명의 길이

	var FileNameSplit_First_Left = FileNameSplit_First.substr(0,FileNameSplit_First_length-2);

	if(ContentsMobileNextPage>9) {
		NextFileName = FileNameSplit_First_Left + ContentsMobileNextPage + ".mp4";
	}else{
		NextFileName = FileNameSplit_First_Left + "0" + ContentsMobileNextPage + ".mp4";
	}

	var NextPlayPath = PlayPath.replace(FileName,"") + NextFileName;

	$("#ContentsMobileNowPage").val(ContentsMobileNextPage);
	$("#PlayPath").val(NextPlayPath);

	Player.setAttribute("src", NextPlayPath);

	if(ContentsMobileNextPage>1) {
		$("#PrevBtn").show();
	}else{
		$("#PrevBtn").hide();
	}

	if(ContentsMobileNextPage==ContentsMobilePage) {
		$("#NextBtn").hide();
	}else{
		$("#NextBtn").show();
	}

	$("#PageDisplay").html(ContentsMobileNextPage);


}

function PlayPrev() {

	var Player = document.getElementById("mPlayer");

	var ContentsMobilePage = $("#ContentsMobilePage").val();
	var ContentsMobileNowPage = $("#ContentsMobileNowPage").val();
	var PlayPath = $("#PlayPath").val();
	var ContentsMobilePrevPage = parseInt(ContentsMobileNowPage) - 1;

	PlayPath_array = PlayPath.split('/'); //경로와 파일명을 분리하기 위해

	var FileName = PlayPath_array[PlayPath_array.length-1]; //배열의 마지막 부분이 파일명

	FileNameSplit = FileName.split('.'); //확장자 제거를 위해

	var FileNameSplit_First = FileNameSplit[0]; //확장자를 제거(.mp4)한 순수 파일명

	var FileNameSplit_First_length = FileNameSplit_First.length; //파일명의 길이

	var FileNameSplit_First_Left = FileNameSplit_First.substr(0,FileNameSplit_First_length-2);

	if(ContentsMobilePrevPage>9) {
		NextFileName = FileNameSplit_First_Left + ContentsMobilePrevPage + ".mp4";
	}else{
		NextFileName = FileNameSplit_First_Left + "0" + ContentsMobilePrevPage + ".mp4";
	}

	var NextPlayPath = PlayPath.replace(FileName,"") + NextFileName;

	$("#ContentsMobileNowPage").val(ContentsMobilePrevPage);
	$("#PlayPath").val(NextPlayPath);

	Player.setAttribute("src", NextPlayPath);

	if(ContentsMobilePrevPage>1) {
		$("#PrevBtn").show();
	}else{
		$("#PrevBtn").hide();
	}

	if(ContentsMobilePrevPage==ContentsMobilePage) {
		$("#NextBtn").hide();
	}else{
		$("#NextBtn").show();
	}

	$("#PageDisplay").html(ContentsMobilePrevPage);

}

//초단위로 수강시간 보여주는 부분
function StudyTimeCheck() {

	var AddTime = parseInt($("#StartTime").val()) + 1;

	$("#StartTime").val(AddTime);

	StudyTimeDisplay();

}

function StudyTimeDisplay() {

	var StudyTime = parseInt($("#StartTime").val());

	curmin=Math.floor(StudyTime/60);
	cursec=StudyTime%60;
	curhour = Math.floor(curmin/60);
	curmin = curmin%60;

	if(curhour<10) {
		curhour2 = "0" + curhour;
	}else{
		curhour2 = curhour;
	}

	if(curmin<10) {
		curmin2 = "0" + curmin;
	}else{
		curmin2 = curmin;
	}

	if(cursec<10) {
		cursec2 = "0" + cursec;
	}else{
		cursec2 = cursec;
	}

	curtime = curhour2+":"+curmin2+":"+cursec2;

	$("#StudyTimeNow").val(curtime);

	if(curhour>2) { //수강 시간이 2시간을 초과하면 강의창 종료
		self.close();
	}

}

//tok2 로그인을 위한 부분 form은 include_bottom.php에 있음
function tok2Submit() {

	Yes = confirm("[다음 강의] 법정필수강의로 이동하시겠습니까?");
	if(Yes==true) {
		tok2Form.submit();
	}

}

function LogInCheck() {

	$.post("./login_status.php",
		{
			't': '1'
		},function(data,status){
				if(data=="O") {
					//var Player = document.getElementById("mPlayer");
					//Player.pause();
					alert("세션이 만료되어 로그아웃 처리됩니다.");
					location.href="./logout.php";
				}
				if(data=="N") {
					//var Player = document.getElementById("mPlayer");
					//Player.pause();
					alert("다른 기기에서 로그인하여 로그아웃 처리됩니다.");
					location.href="./logout.php";
				}
		});

}

//진도체크하는 부분
function StudyProgressCheck(ProgressStep,CloseYN) {

	var LastStudy = $("#ContentsURL").val();
	var Chapter_Number = $("#Chapter_Number").val();
	var LectureCode = $("#LectureCode").val();
	var Study_Seq = $("#Study_Seq").val();
	var Chapter_Seq = $("#Chapter_Seq").val();
	var Contents_idx = $("#Contents_idx").val();
	var ContentsDetail_Seq = $("#ContentsDetail_Seq").val();
	var ProgressTime = $("#StartTime").val();
	var CompleteTime = $("#CompleteTime").val();

	$.post("./lecture_progress.php",
	{ 'Chapter_Number': Chapter_Number,
		'LectureCode': LectureCode,
		'Study_Seq': Study_Seq,
		'Chapter_Seq': Chapter_Seq,
		'Contents_idx': Contents_idx,
		'ContentsDetail_Seq': ContentsDetail_Seq,
		'ProgressTime': ProgressTime,
		'LastStudy': LastStudy,
		'CompleteTime': CompleteTime,
		'ProgressStep': ProgressStep
	},function(data){

		var parseData = $.parseJSON(data);

		if(CloseYN=="Y") {
			location.href="lecture.php";
		}
		
	});

}


function CounselSubmit() {

	if($("#Name").val()=="") {
		alert("이름을 입력하세요.");
		$("#Name").focus();
		return;
	}
	if($("#Category").val()=="") {
		alert("문의종류를 선택하세요.");
		$("#Category").focus();
		return;
	}
	/*
	if($("#Mobile01").val()=="") {
		alert("연락처를 입력하세요.");
		$("#Mobile01").focus();
		return;
	}
	if($("#Mobile02").val()=="") {
		alert("연락처를 입력하세요.");
		$("#Mobile02").focus();
		return;
	}
	if($("#Mobile03").val()=="") {
		alert("연락처를 입력하세요.");
		$("#Mobile03").focus();
		return;
	}
	if(IsNumber($("#Mobile02").val())==false) {
		alert("휴대폰은 숫자만 입력하세요.");
		$("#Mobile02").focus();
		return;
	}
	if(IsNumber($("#Mobile03").val())==false) {
		alert("휴대폰은 숫자만 입력하세요.");
		$("#Mobile03").focus();
		return;
	}
	if($("#Email01").val()=="") {
		alert("이메일을 입력하세요.");
		$("#Email01").focus();
		return;
	}
	if($("#Email02").val()=="") {
		alert("이메일을 입력하세요.");
		$("#Email02").focus();
		return;
	}
	*/
	if($("#Title").val()=="") {
		alert("제목을 입력하세요.");
		$("#Title").focus();
		return;
	}
	if($("#Contents").val()=="") {
		alert("내용을 입력하세요.");
		$("#Contents").focus();
		return;
	}
	if($("#SecurityCode").val()=="") {
		alert("보안코드를 입력하세요.");
		$("#SecurityCode").focus();
		return;
	}

	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		CounselForm.submit();
	}

}