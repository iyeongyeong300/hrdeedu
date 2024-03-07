$(document).ready(function(){
	//화면 설명 음성
	//getVoice("explain");
	
	//캡차 이미지 생성
	getCaptcha();
	
	//화면 설명 클릭시
	$("#btnExplain").click(function(e){
		getVoice("explain");
	});
	
	//음성 클릭시
	$("#btnVoice").click(function(e){
		getVoice("captcha");
	});
	
	//새로고침 클릭시
	$("#btnRefresh").click(function(e){
		//입력창 Clear
		$("#user_input").val('');
		//캡차 이미지 새로 생성
		getCaptcha();
	});
	
	//확인 버튼 클릭시
	$("#btnConfirm").click(function(e){
		result();
	});
});

/*
 * Captcha Image 취득
 * 설명 : IMG 태그의 ID가 "captcha_img" 객체를 찾아서 src(경로)값을 변경시킨다
 */
function getCaptcha(){
	$("#captcha_img").attr("src", "https://capt.hrdkorea.or.kr/getCapchaData?agent_id="+$('#agent_id').val() +"&user_agent_pk=" + $('#user_agent_pk').val()+"&"+Math.random());
}

/*
 * 음성 파일 조회 및 실행
 * 파라메터 : voiceType -> "explain" or "captcha" or "correct" or "incorrect"
 * 설명 : 각 브라우저 따라 audio 또는 embed 객체를  생성하여 재생한다.
 */
  function getVoice(voiceType){
	//동적으로 삽입 될 태그
	var audioObject;
	var parameter = "voiceType="+voiceType+"&agent_id="+$('#agent_id').val()+"&user_agent_pk="+$('#user_agent_pk').val()+"&"+Math.random();
	
	var browserType = getBrowserType();
	
	if(browserType == "IE12" || browserType == "IE11" || browserType == "IE10" || browserType == "IE9" || browserType == "Chrome") {
	//if(getBrowserType().indexOf("IE") != -1){
		// console.log("embed tag");
		audioObject = '<embed id="'+voiceType+'" src="https://capt.hrdkorea.or.kr/getCapchaVoice?'+parameter+'" autoplay="true" hidden="true" volume="100" />';
	}else if(browserType == "IE8" || browserType == "IE7"){			  
		audioObject = '<object id="'+voiceType+'" type="audio/x-wav" data="https://capt.hrdkorea.or.kr/getCapchaVoice?'+parameter+'" width="200" height="20" style="display:none">'+
		  '<param name="src" value="https://capt.hrdkorea.or.kr/getCapchaVoice?'+parameter+'">'+
		  '<param name="autoplay" value="true">'+
		  '<param name="autoStart" value="1">'+
		'</object>';
	}else{
		// console.log("audio tag");
		audioObject = '<audio autoplay="autoplay"><source src="https://capt.hrdkorea.or.kr/getCapchaVoice?'+parameter+'" type="audio/wav" id="'+voiceType+'"></source></audio>';
	}
	//태그가 존재하면 삭제 
	if($("#audio").length)
		$("audio").remove();
	
	//이미지 태그 뒤에 오디오 삽입
	$("#captcha_img").after(audioObject);
};

/*
* 인증 결과 확인
* 설명 : 캡차 인증 처리
*/
function result(){
//유저 입력값 설정 (계산된 답)

$('#captchaInput').val($('#user_input').val());

	var befor_encode_eval_type = $('#eval_type').val();   // eval_type은  훈련기관에서 인코딩하여 보내줘야 한다.

$('#eval_type').val(encodeURIComponent(befor_encode_eval_type));  //  인코딩 하여 처리

	//크로스 도메인 AJAX 문제를 해결하기 위해 jsonp 를 사용 START
$.ajax({
	url : 'https://capt.hrdkorea.or.kr/result',
	dataType : "jsonp",
	jsonp: "jsonp_callback",
	type :"GET",
	data : $('#formAgent').serialize(),
	success : function(resultObj){
		//인증 결과를 재생
		getVoice(resultObj.result);
		
		if(resultObj.result == "correct"){
			//alert("인증 성공!") //do something(인증 성공 처리)
			$.post("/player/player_captcha_time.php",
			{
				'Study_Seq': $("#Study_Seq").val(),
				'StepType': $("#StepType").val()
			},function(data,status){
				//top.$("#OtpFrame").html("");
				top.$("#OTP").hide();
				top.$("#AgreeForm").show();
			});
			
			
		}else{
			alert("캡차인증에 실패했습니다.");
			$("#user_input").val('');
			//캡차 이미지 새로 생성
			getCaptcha();
		}
	},
	error : function(request, status, error){
			alert("AJAX ERROR");
			alert("code: "+request.status+"\n"+"message: "+ request.responseText + "\n" + "error :" + error);
		} 
	});
//인코딩 된 값 원복
$('#eval_type').val(befor_encode_eval_type);
};         //크로스 도메인 AJAX 문제를 해결하기 위해 jsonp 를 사용 END

  /*
 * 브라우저 타입을 리턴
 * 설명 : navigator.userAgent 값을 비교하여 브라우저를 판별한다
 * 리턴값 : (String) 브라우저 명
 */
function getBrowserType()
{
	var _ua = navigator.userAgent;
	
	//IE 버젼을 구분하기 위해 tradent를 판별
	var trident = _ua.match(/Trident\/(\d.\d)/i);
	//IE 11 ,10,  9,  8
	if(trident != null)
	{
		if( trident[1] == "7.0" ) return "IE11";
		if( trident[1] == "6.0" ) return "IE10";
		if( trident[1] == "5.0" ) return "IE9";
		if( trident[1] == "4.0" ) return "IE8";
	}
	//IE 7
	if(navigator.appName == 'Microsoft Internet Explorer') return "IE7";
 
	//OTHER
var agt = _ua.toLowerCase();
if (agt.indexOf("opera") != -1 || agt.indexOf("opr") != -1) return 'Opera';
if (agt.indexOf("chrome") != -1) return 'Chrome';
if (agt.indexOf("staroffice") != -1) return 'Star Office'; 
if (agt.indexOf("webtv") != -1) return 'WebTV'; 
if (agt.indexOf("beonex") != -1) return 'Beonex'; 
if (agt.indexOf("chimera") != -1) return 'Chimera'; 
if (agt.indexOf("netpositive") != -1) return 'NetPositive'; 
if (agt.indexOf("phoenix") != -1) return 'Phoenix'; 
if (agt.indexOf("firefox") != -1) return 'Firefox'; 
if (agt.indexOf("safari") != -1) return 'Safari'; 
if (agt.indexOf("skipstone") != -1) return 'SkipStone'; 
if (agt.indexOf("netscape") != -1) return 'Netscape'; 
if (agt.indexOf("mozilla/5.0") != -1) return 'Mozilla';
 
 return "Unknown";
}
//  * 브라우저 타입을 리턴   End

