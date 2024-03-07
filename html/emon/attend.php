<?php
include'../melon/core.php';



ini_set('display_errors',1);
if($param['type']==''){
	echo 'api key missing';
	exit;
}

$param['mode']= 'send';
$param['type']='ed';

if($param['type']=='h'){
//emon API용 설정
$emon_agentPk = "hanaedu";
$emon_API_KEY = "hTsTv3XPFkbxJS/A4v9BrhWY3+h5TalFMKt8XdVrAcU=";

}
if($param['type']=='c'){
//emon API용 설정
$emon_agentPk = "ckpro1378";
$emon_API_KEY = "2z99jMgR5sPI6jXAJcavMXY+EVBwyvl0V43NrVSz7v0=";

}
if($param['type']=='t'){
$emon_agentPk = "topplus1";
$emon_API_KEY = "kwzBJdg9GrdJa2X/7jA1WNyJgQ5Cl2S+gZv4XUHwHKQ=";

}


if($param['type']=='z'){
$emon_agentPk = "awesomeedu1";
$emon_API_KEY = "vzpr9c+BkZkPxo15Dr7dNsK3Q8Ol5EQ++JDd3twqkro=";


}
if($param['type']=='a'){
$emon_agentPk = "hrdasset1";
$emon_API_KEY = "ITW5ABXVgTBdNBa+1R/SC+m41NgTf7bNw1nvB0uQqyc=";

}

if($param['type']=='ed'){
    $emon_agentPk = "hrde1746";
    $emon_API_KEY = "W1rnJsN9K1E4rHuK7UN0kb+u99D9pdOSl+mdQuA1zSQ=";
}


//학습종료일+8일째 되는날 환급과정 TB_ATTEND_HIST_V2에 1회 INSERT처리
//매일 00:00시 부터 1시간 간격으로 API 전송되므로, 새벽 00시 30분 이전 1회 실행
if(date("H:i:s")<"00:30:00"){
    $today = date("Y-m-d");
    $data=getList("Study","ServiceType IN (1,4) AND DATE_ADD(LectureEnd, INTERVAL 8 DAY) = '{$today}' AND StudyEnd ='N'");
	
    foreach($data['list'] as $item) {     
        $afterReStudy = Array();
        $afterReStudy['USER_AGENT_PK']= $item['ID'];
        $afterReStudy['COURSE_AGENT_PK']= $item['LectureCode'];
        $afterReStudy['CLASS_AGENT_PK']= $item['LectureCode'] . ",". $item['LectureTerme_idx'];
		
		//REG_DATE 오늘 날짜 중복 체크
		$check=getItem('TB_ATTEND_HIST_V2',"USER_AGENT_PK='{$afterReStudy['USER_AGENT_PK']}' AND COURSE_AGENT_PK='{$afterReStudy['COURSE_AGENT_PK']}' AND CLASS_AGENT_PK='{$afterReStudy['CLASS_AGENT_PK']}' AND DATE(REG_DATE)='{$today}'");	
		if($check){
			continue;
		}

        if ($item['PassOK'] == "Y"){
            $item['PASS_FLAG'] = 1; 
        }else{
            $item['PASS_FLAG'] = 0;
        }
        
        if ($item['ServiceType'] == "1") {
            $item['EMP_INS_FLAG'] = 1;
        } else if ($item['ServiceType'] == "4") {
            $item['EMP_INS_FLAG'] = 4;
        } else {
            $item['EMP_INS_FLAG'] = 0;
        }
        
        $afterReStudy['PASS_FLAG']= $item['PASS_FLAG'];
        $afterReStudy['ATTEND_VALID_FLAG']= 1;
        $afterReStudy['BOOK_ISBN']= NULL;
        $afterReStudy['CHANGE_STATE']= "U";
        $afterReStudy['REG_DATE']= date("Y-m-d H:i:s");
        $afterReStudy['EMP_INS_FLAG'] = $item['EMP_INS_FLAG'];	

		$SQL = "INSERT INTO TB_ATTEND_HIST_V2 (
			USER_AGENT_PK,
			COURSE_AGENT_PK,
			CLASS_AGENT_PK,
			PASS_FLAG,
			ATTEND_VALID_FLAG,
			BOOK_ISBN,
			CHANGE_STATE,
			REG_DATE,
			EMP_INS_FLAG
			) VALUES (
			'{$afterReStudy['USER_AGENT_PK']}',
			'{$afterReStudy['COURSE_AGENT_PK']}',
			'{$afterReStudy['CLASS_AGENT_PK']}',
			{$afterReStudy['PASS_FLAG']},
			1,
			NULL,
			'U',
			NOW(),
			{$afterReStudy['EMP_INS_FLAG']}
		)";
		
		sqlQuery($SQL);
    }
}


$requestArr = array();
$requestArr["dataList"]=[];

/*
Attend Hist
*/
	

$data=getList('TB_ATTEND_HIST_V2','',5000,'','seq desc');
//$data=getList('TB_ATTEND_HIST_V2',"substring(REG_DATE,1,10) >= '2023-07-02'",50000, "",'seq asc');

foreach($data['list'] as $item){

	$check=getItem('TB_ATTEND_HIST_V2_RESULT','SEQ='.$item['SEQ']);
	if($check){

		continue;
	}
	
    // 진도율,총점 구하기
    $CLASS_AGENT_PK = explode(",",$item['CLASS_AGENT_PK']);
    $study=getItem('Study',"ID='".$item['USER_AGENT_PK']."' AND LectureCode='".$item['COURSE_AGENT_PK']."'  AND LectureTerme_idx='{$CLASS_AGENT_PK[1]}'  ");
    $progressRate = $study["Progress"];
	
    if (!$progressRate) {
		$progressRate = 0;
	}
	
    if (!$study["TotalScore"]) {
		$totalScore =0;
	} else {
		$totalScore = $study["TotalScore"];
	}
	
	if($item['CHANGE_STATE']=="C"){
		$progressRate = 0;
		$totalScore = 0;
	}

	$paramArr['agentPk']=$emon_agentPk;
	$paramArr['seq']=$item['SEQ'];
	$paramArr['userAgentPk']=$item['USER_AGENT_PK'];
	$paramArr['courseAgentPk']=$item['COURSE_AGENT_PK'];
	$paramArr['classAgentPk']=$item['CLASS_AGENT_PK'];
	$paramArr['passFlag']=$item['PASS_FLAG'];
	$paramArr['attendValidFlag']=1;
	$paramArr['changeState']=$item['CHANGE_STATE'];
	$paramArr['regDate']=$item['REG_DATE'];
	$paramArr['empInsFlag']=$item['EMP_INS_FLAG'];
	$paramArr["progressRate"] = $progressRate;
	$paramArr["totalScore"] = $totalScore;

	array_push($requestArr["dataList"],$paramArr);

	$item['PASS_FLAG']= intval($item['PASS_FLAG']);
	$item['ATTEND_VALID_FLAG']= intval($item['ATTEND_VALID_FLAG']);

	insertItem('TB_ATTEND_HIST_V2_RESULT',$item);
}




if(count($requestArr["dataList"])==0){
		echo '전송할 데이터가 없습니다.';
		exit;
	}

//배열을 JSON 데이터로 생성
$data = jsonEncode($requestArr);

//URL 및 헤더 설정
$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/attend_hist";
//$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/user_login_hist_test";
$headers = array (
"Content-Type: application/json",
"X-TQIAPI-HEADER: ".$emon_API_KEY, "X-TQIAPI-USER: ".$emon_agentPk
);



$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);

$json_result_arr = json_decode($response, true);
$result_code = $json_result_arr['code'];
$result_msg = $json_result_arr['msg'];
$result_cnt = $json_result_arr['data_cnt'];


if(!$result_cnt) {
	$result_cnt = 0;
}



echo $data;

curl_close($ch);
echo $response;
