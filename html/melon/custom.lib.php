<?php
//===================================================================================//
// NAME		: custom.lib.php
// MEMO		: 프로젝트 별 커스텀 함수 모음
// AUTHOR	: DECODE
// EMAIL	: decode@decodelab.co.kr
// Copyright (c) 2012, DECODE Co., Ltd. All rights reserved.
//===================================================================================//

function sendSMS($number,$message){


	
   /******************** 인증정보 ********************/
    $sms_url = "http://sslsms.cafe24.com/sms_sender.php"; // 전송요청 URL
	// $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // HTTPS 전송요청 URL
   $sms['user_id'] = base64_encode("decodesms"); //SMS 아이디.
	$sms['secure'] = base64_encode("7980f9ccbb2848867d8f6b81b65e47ef ") ;//인증키


    $sms['msg'] = base64_encode(stripslashes($message));
     $sms['rphone'] = base64_encode($number);
    $sms['sphone1'] = base64_encode('031');//$param['sphone1']);
    $sms['sphone2'] = base64_encode('732');//$param['sphone1']);
    $sms['sphone3'] = base64_encode('0349');//$param['sphone1']);
    $sms['rdate'] = base64_encode($param['rdate']);
    $sms['rtime'] = base64_encode($param['rtime']);
    $sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
    $sms['returnurl'] = base64_encode($param['returnurl']);
    $sms['testflag'] = base64_encode($param['testflag']);
    $sms['destination'] = base64_encode($param['destination']);
    $returnurl = $param['returnurl'];
    $sms['repeatFlag'] = base64_encode($param['repeatFlag']);
    $sms['repeatNum'] = base64_encode($param['repeatNum']);
    $sms['repeatTime'] = base64_encode($param['repeatTime']);
    $nointeractive = $param['nointeractive']; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

    $host_info = explode("/", $sms_url);
    $host = $host_info[2];
    $path = $host_info[3]."/".$host_info[4];

    srand((double)microtime()*1000000);
    $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
    //print_r($sms);

    // 헤더 생성
    $header = "POST /".$path ." HTTP/1.0\r\n";
    $header .= "Host: ".$host."\r\n";
    $header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

    // 본문 생성
    foreach($sms AS $index => $value){
        $data .="--$boundary\r\n";
        $data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
        $data .= "\r\n".$value."\r\n";
        $data .="--$boundary\r\n";
    }
    $header .= "Content-length: " . strlen($data) . "\r\n\r\n";

    $fp = fsockopen($host, 80);

    if ($fp) {
        fputs($fp, $header.$data);
        $rsp = '';
        while(!feof($fp)) {
            $rsp .= fgets($fp,8192);
        }
        fclose($fp);
        $msg = explode("\r\n\r\n",trim($rsp));
        $rMsg = explode(",", $msg[1]);
        $Result= $rMsg[0]; //발송결과
        $Count= $rMsg[1]; //잔여건수

        //발송결과 알림
        if($Result=="success"){ 
            $alert =  $_SESSION['certif_code'];
			$param["tel"]=$param["sphone1"].$param["sphone2"].$param["sphone3"];
			if(strlen($param["birth_month"])==1){
				$param["birth_month"]="0".$param["birth_month"];
			}
			if(strlen($param["birth_date"])==1){
				$param["birth_date"]="0".$param["birth_date"];
			}
			$param["birth"]=$param["birth_year"].$param["birth_month"].$param["birth_date"];
	
		
		
			//아이라이크클릭 실적 저장 끝
        }
        else if($Result=="reserved") {
			
            $alert = "성공적으로 예약되었습니다.";
            $alert .= " 잔여건수는 ".$Count."건 입니다.";
        }
        else if($Result=="3205") {
            $alert = "잘못된 번호형식입니다.";
        }

		else if($Result=="0044") {
            $alert = "스팸문자는발송되지 않습니다.";
        }

        else {
			echo iconv('euc-kr','utf-8',$Result);
			exit;
            $alert = "정보를 모두 입력해주세요.";
        }
    }
    else {
        $alert = "Connection Failed";
    }

    if($nointeractive=="1" && ($Result!="success" && $Result!="Test Success!" && $Result!="reserved") ) {



	
    }
    else if($nointeractive!="1") {
		
    }
}


// 유튜브 ID 가져오기
function getYoutubeID($contents)
{
    if (!$contents)
        return false;

//'#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#'
//"/<iframe[^>]*src=\"[^\"]*youtu[.]?be.*<\\/iframe>/mi"
    preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $contents, $match);

    return $match[2];
}

// 유튜브 썸네일 링크
// http://webdir.tistory.com/472($thumb_str에 따른 썸네일 크기 및 설명)
function getYoutubeThumbnail($youtube_id, $thumb_str = "0")
{
    if (!$youtube_id)
        return false;

    return "https://img.youtube.com/vi/" . $youtube_id . "/" . $thumb_str . ".jpg";
}

function getVimeoID($url) {
    
        $regs = array();
    
        $id = '';
    
        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
            $id = $regs[3];
        }
    
        return $id;
    
    }

function getVimeoInfo($vimeo)
{
    $url = parse_url($vimeo);
    if($url['host'] !== 'vimeo.com' &&
            $url['host'] !== 'www.vimeo.com')
        return false;
   if (preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $vimeo, $match)) 
   {
       $id = $match[1];
   }
   else
   {
       $id = substr($link,10,strlen($link));
   }

   if (!function_exists('curl_init')) die('CURL is not installed!');
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 10);
   $output = unserialize(curl_exec($ch));
   $output = $output[0];
   curl_close($ch);
   return $output;
}


function getVimeoThumbnail( $id = '', $thumbType = 'medium' ) {

	$id = trim( $id );

	if ( $id == '' ) {
		return FALSE;
	}

	$apiData = unserialize( file_get_contents( "http://vimeo.com/api/v2/video/$id.php" ) );

	if ( is_array( $apiData ) && count( $apiData ) > 0 ) {

		$videoInfo = $apiData[ 0 ];

		switch ( $thumbType ) {
			case 'small':
				return $videoInfo[ 'thumbnail_small' ];
				break;
			case 'large':
				return $videoInfo[ 'thumbnail_large' ];
				break;
			case 'medium':
				return $videoInfo[ 'thumbnail_medium' ];
			default:
				break;
		}

	}

	return FALSE;

}
