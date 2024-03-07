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


$requestArr = array();
$requestArr["dataList"]=[];




/*
Attend Hist
*/
	


$data=getList('TB_CLASS_HIST_V2','',5000,'','seq desc');

foreach($data['list'] as $item){

	$check=getItem('TB_CLASS_HIST_V2_RESULT','SEQ='.$item['SEQ']);
	if($check){
		continue;
	}
	
	$paramArr['agentPk']=$emon_agentPk;
	$paramArr['seq']=$item['SEQ'];
	$paramArr['courseAgentPk']=$item['COURSE_AGENT_PK'];
	$paramArr['classAgentPk']=$item['CLASS_AGENT_PK'];
	$paramArr['fullScore']=$item['FULL_SCORE'];
	$paramArr['startDt']=$item['START_DT'];
	$paramArr['endDt']=$item['END_DT'];
	$paramArr['changeState']=$item['CHANGE_STATE'];
	$paramArr['regDate']=$item['REG_DATE'];
	$paramArr['tracseTme']=$item['TRACSE_TME'];

	array_push($requestArr["dataList"],$paramArr);




	if(!$result_cnt) {
		$result_cnt = 0;
	}
	

	insertItem('TB_CLASS_HIST_V2_RESULT',$item);
}





if(count($requestArr["dataList"])==0){
		echo '전송할 데이터가 없습니다.';
		exit;
	}

//배열을 JSON 데이터로 생성
$data = jsonEncode($requestArr);

	//URL 및 헤더 설정
	$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/class_hist";
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
