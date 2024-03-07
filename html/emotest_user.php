<?php
include'melon/core.php';

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
ini_set("display_errors", 1);




//$data =getListQuery('show tables');

if($param['type']==''){
//	echo 'api key missing';
//	exit;
}

$param['mode']= 'send';
$param['type']='a';

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
    $emon_agentPk = "hrde1746";
    $emon_API_KEY = "W1rnJsN9K1E4rHuK7UN0kb+u99D9pdOSl+mdQuA1zSQ=";

}


//exit;


// 전송할 아이디
$USER_AGENT_PK = "
";

$USER_AGENT_PK_ARR = explode("\r\n",$USER_AGENT_PK);

/*
score_hist
*/

$tot_no =0;
$requestArr = array();
$paramArr = array();
foreach ($USER_AGENT_PK_ARR as $id) {

    $data=getList('TB_USER_HIST_V2_ENC',"USER_AGENT_PK='$id' ",1,'','','
    *,
    aes_decrypt(UNHEX(EMAIL),"ek3434!") AS EMAIL_DEC,
    aes_decrypt(UNHEX(RES_NO),"ek3434!")  AS RES_NO_DEC,
    aes_decrypt(UNHEX(MOBILE),"ek3434!")  AS MOBILE_DEC,
    aes_decrypt(UNHEX(TEL),"ek3434!")  AS TEL_DEC');

    foreach($data['list'] as $item){

        $check=getItem('TB_USER_HIST_V2_ENC_RESULT','SEQ='.$item['SEQ']);
        if($check){
  //          continue;
        }

        $paramArr[$tot_no]['agentPk']=$emon_agentPk;
        $paramArr[$tot_no]['seq']=$item['SEQ'];
        $paramArr[$tot_no]['classAgentPk']=$item['CLASS_AGENT_PK'];
        $paramArr[$tot_no]['courseAgentPk']=$item['COURSE_AGENT_PK'];
        $paramArr[$tot_no]['userAgentPk']=$item['USER_AGENT_PK'];

        $paramArr[$tot_no]['userName'] = $item['USER_NAME'];
        $paramArr[$tot_no]['resNo'] = $item['RES_NO_DEC'];
        $paramArr[$tot_no]['encResNo'] = $item['ENC_RES_NO'];
        $paramArr[$tot_no]['email'] = $item['EMAIL_DEC'];
        $paramArr[$tot_no]['mobile'] = $item['MOBILE_DEC'];
        $paramArr[$tot_no]['nwIno'] = $item['NW_INO'];
        $paramArr[$tot_no]['trneeSe'] = $item['TRNEE_SE'];
        $paramArr[$tot_no]['irglbrSe'] = $item['IRGLBR_SE'];

        
        if($paramArr[$tot_no]['nwIno']=='0'){
            $paramArr[$tot_no]['nwIno'] = '';
        }

        $paramArr[$tot_no]['changeState']=$item['CHANGE_STATE'];

        $paramArr[$tot_no]['regDate']=$item['REG_DATE'];

		$tot_no++;

		//insertItem('TB_USER_HIST_V2_ENC_RESULT',$item);

	}
}

$requestArr["dataList"] = $paramArr;

//배열을 JSON 데이터로 생성
$data = jsonEncode($requestArr);
print_x($requestArr);
flush();
//exit;

//URL 및 헤더 설정
$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/user_hist";
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
echo $response;
curl_close($ch);
flush();
//sleep(40);
	

dbConnect();
$json_result_arr = json_decode($response, true);
$result_code = $json_result_arr['code'];
$result_msg = $json_result_arr['msg'];
$result_cnt = $json_result_arr['data_cnt'];

if(!$result_cnt) {
	$result_cnt = 0;
}
