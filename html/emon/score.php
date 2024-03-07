<?php
include'../melon/core.php';

set_time_limit(0);

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


$today=date('Y-m-d');

/*
score_hist
*/
	
//$data=getList('TB_SCORE_HIST_V2','submit_date LIKE "%'.$today.'%"',50000,'','SUBMIT_DATE ASC');
for ($z=0; $z < 6; $z++) {
	dbConnect();
    $page_size = 50000 * $z;
    echo $page_size . "<br><br>";
	$data=getList('TB_SCORE_HIST_V2',"substring(submit_date,1,10)='{$today}'",$page_size,50000,'SUBMIT_DATE ASC');

	$perv_score = 0;
	$requestArr = array();
	$requestArr["dataList"] =[];
	foreach($data['list'] as $item){
		$today2 = substr($item['SUBMIT_DATE'],0,10);
		$check=getItem('TB_SCORE_HIST_V2_RESULT','SEQ='.$item['SEQ'].' AND submit_date like "%'.$today2.'%"');
		if($check){
			continue;
		}


		$ITEM_EVAL_TYPE_ARRAY=explode('_',$item['EVAL_TYPE']);
		$CHAPTER_NUMBER = str_pad($ITEM_EVAL_TYPE_ARRAY[1],2,'0',STR_PAD_LEFT);


		$progress=getItem('Progress',"CHAPTER_NUMBER = ".$CHAPTER_NUMBER." AND ID='".$item['USER_AGENT_PK']."'
			AND LectureCode='".$item['COURSE_AGENT_PK']."'", '','', '',"");


		


		if($progress['Progress']==100){

			$check_chasi = getItem('TB_SCORE_HIST_V2_RESULT','EVAL_TYPE="'.$item['EVAL_TYPE'].'" AND COURSE_AGENT_PK="'.$item['COURSE_AGENT_PK'].'" AND CLASS_AGENT_PK="'.$item['CLASS_AGENT_PK'].'" AND USER_AGENT_PK="'.$item['USER_AGENT_PK'].'"');
			insertItem('TB_SCORE_HIST_V2_RESULT',$item);	
			if(!$check_chasi){//같은 차시 없을 때만 전송
				
			


			$start = getItem('TB_SCORE_HIST_V2','USER_AGENT_PK="'.$item['USER_AGENT_PK'].'" AND  EVAL_TYPE="'.$item['EVAL_TYPE'].'" AND COURSE_AGENT_PK="'.$progress['LectureCode'].'" AND submit_date like "%'.$today2.'%"','SUBMIT_DATE ASC');
			$end = getItem('TB_SCORE_HIST_V2','USER_AGENT_PK="'.$item['USER_AGENT_PK'].'" AND EVAL_TYPE="'.$item['EVAL_TYPE'].'" AND COURSE_AGENT_PK="'.$progress['LectureCode'].'" AND submit_date like "%'.$today2.'%"','SEQ DESC');
			

			$EVAL_TYPE_ARRAY=explode('_',$start['EVAL_TYPE']);
			$CHASI = str_pad($EVAL_TYPE_ARRAY[1],2,'0',STR_PAD_LEFT);
			$EVAL_CD = '01';

			if(strpos($start['EVAL_TYPE'],'시험')!==FALSE){
				$EVAL_CD = '02';
			}
			if(strpos($start['EVAL_TYPE'],'과제')!==FALSE){
				$EVAL_CD = '03';
			
			}
			if(strpos($start['EVAL_TYPE'],'진행평가')!==FALSE){
				$EVAL_CD = '04';
			}

				
	
			$paramArr['agentPk']=$emon_agentPk;
			$paramArr['seq']=$item['SEQ'];
			$paramArr['classAgentPk']=$item['CLASS_AGENT_PK'];
			$paramArr['courseAgentPk']=$item['COURSE_AGENT_PK'];
			$paramArr['userAgentPk']=$start['USER_AGENT_PK'];


			$paramArr['evalType'] = $item['EVAL_TYPE'];

			
			$paramArr['score'] = $start['SCORE'];
			$paramArr['accessIp'] = $item['ACCESS_IP'];
			$paramArr['submitDueDt'] = $item['SUBMIT_DUE_DT'];
			$paramArr['changeState'] = 'C';
			$paramArr['isCopiedAnswer'] = 'N';
			$paramArr['regDate'] = $start['REG_DATE'];

			$paramArr['submitDate']  = $start['SUBMIT_DATE'];
			
			$paramArr['evalCd'] = $EVAL_CD;
			$paramArr['chasi'] = $CHASI;
			$paramArr['startEndFlag'] ='S';

			if(strpos($paramArr['evalType'],'진도')!==FALSE){
				$paramArr['isCopiedAnswer'] = 'X';
			}


			

		//	$paramArr['regDate']=$item['REG_DATE'];
			array_push($requestArr["dataList"] ,$paramArr);
	////print_x($requestArr);
			//배열을 JSON 데이터로 생성
			echo '[ 유저명 :  '.$paramArr['userAgentPk'].'->SEND('.$paramArr['startEndFlag'].'/'.$paramArr['changeState'].') :  '.$paramArr['evalCd'].', '.$paramArr['score'].'/'.$paramArr['isCopiedAnswer'].$paramArr['evalType'].'('.$paramArr['submitDate'].'/'.$paramArr['regDate'].')]';
			$data = jsonEncode($requestArr);
            flush();
			
			dbConnect();
			$paramArr['startEndFlag']='E';
			$paramArr['score'] = $end['SCORE'];
			$paramArr['regDate'] = $end['REG_DATE'];
			
			$paramArr['submitDate']  = $end['SUBMIT_DATE'];
			$paramArr['changeState']='U';

			array_push($requestArr["dataList"] ,$paramArr);
			//print_x($requestArr);
			br();
			echo '[ 유저명 :  '.$paramArr['userAgentPk'].'->SEND('.$paramArr['startEndFlag'].'/'.$paramArr['changeState'].') :  '.$paramArr['evalCd'].','.$paramArr['score'].'/'.$paramArr['isCopiedAnswer'].$paramArr['evalType'].'('.$paramArr['submitDate'].'/'.$paramArr['regDate'].')]';
				//배열을 JSON 데이터로 생성

			br();
				
			}		
		}
	}

	if(count($requestArr["dataList"])>0){
		$data = jsonEncode($requestArr);
		echo $data;
		flush();

		//URL 및 헤더 설정
		$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_hist";
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
		if($param['mode']=='send'){
		$response = curl_exec($ch);
		}
		curl_close($ch);

		echo $response;
		flush();

		sleep(60);
		echo "<br>";
		echo "<br>";
	}


}

// 평가 첨삭일 기준 전송 추가 (제출일과 첨삭일이 다른경우 누락되서 개선)
$requestArr = array();
$requestArr["dataList"] =[];

dbConnect();

$data2=getList("TB_SCORE_HIST_V2","EVAL_TYPE IN ('진행평가_1','시험_1','과제_1') AND DATE(REG_DATE) > DATE(SUBMIT_DATE) AND DATE(REG_DATE) = '{$today}'",5000,"","REG_DATE ASC");

if(!empty($data2['list'])){
	foreach($data2['list'] as $item){
		$check=getItem('TB_SCORE_HIST_V2_RESULT','SEQ='.$item['SEQ']);
		if($check){
			continue;
		}
		
		$paramArr['agentPk']=$emon_agentPk;
		$paramArr['seq']=$item['SEQ'];
		$paramArr['userAgentPk']=$item['USER_AGENT_PK'];
		$paramArr['courseAgentPk']=$item['COURSE_AGENT_PK'];
		$paramArr['classAgentPk']=$item['CLASS_AGENT_PK'];
		$paramArr['evalType'] = $item['EVAL_TYPE'];
		$paramArr['submitDate']  = $item['SUBMIT_DATE'];
		$paramArr['score'] = $item['SCORE'];
		$paramArr['accessIp'] = $item['ACCESS_IP'];
		$paramArr['submitDueDt'] = $item['SUBMIT_DUE_DT'];
		$paramArr['changeState'] = $item['CHANGE_STATE'];
		$paramArr['isCopiedAnswer'] = $item['IS_COPIED_ANSWER']; // N: 비모사답안, X:판정불가, Y:모사답안
		$paramArr['regDate'] = $item['REG_DATE'];

		$paramArr['evalCd'] =  $item['EVAL_CD'];
		$evalTypeArray=explode('_',$item['EVAL_TYPE']);
		$chasi = str_pad($evalTypeArray[1],2,'0',STR_PAD_LEFT);
		
		$paramArr['chasi'] = $chasi;
		$paramArr['startEndFlag'] ='E';

		if($item['USER_AGENT_PK']!=''){
			array_push($requestArr["dataList"],$paramArr);
			insertItem('TB_SCORE_HIST_V2_RESULT',$item);
		}
	}

	if(count($requestArr["dataList"])>0){
		//배열을 JSON 데이터로 생성
		$data = jsonEncode($requestArr);

		//URL 및 헤더 설정
		$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_hist";
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

		curl_close($ch);

		echo $response;
	}
}
