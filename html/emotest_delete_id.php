<?php
include'melon/core.php';

//error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
//ini_set("display_errors", 1);

exit;


//$data =getListQuery('show tables');

//if($param['type']==''){
//echo 'api key missing';
//exit;
//}

$param['mode']= 'send';
$emon_agentPk = "hrde1746";
$emon_API_KEY = "W1rnJsN9K1E4rHuK7UN0kb+u99D9pdOSl+mdQuA1zSQ=";

$today=date('Y-m-d');

/*
Attend Hist
*/

// 특정 아이디
$send_text = "
A006019830203
";

$send_id_arr = explode("\n",$send_text);
echo "<style>*{font-size:12px;}</style>";

// 전체 묶어서 보내기
$requestArr = array();

$tot_no=0; $user_no=0;

// 회원
foreach ($send_id_arr as $id) {
    $id = trim($id);
    if (!$id) continue;

    $lecture_code = "A06012304"; // 임시고정

//    $data=getList('Study',"ID='{$id}' AND (ServiceType=1 OR ServiceType=4) AND LectureCode='$lecture_code' AND LectureTerme_idx='$lecture_terme_idx' AND LectureStart>='2022-08-02' ",5000,"","Seq desc");
    $data=getList('Study',"ID='{$id}' AND (ServiceType=1 OR ServiceType=4) AND LectureCode='$lecture_code' AND LectureStart>='2022-08-02' ",5000,"","Seq desc");
    if (!count($data["list"])) {
        $IP=getList('Study',"ID='{$id}' ",1);
        $StudyIP= $IP["list"][0]["StudyIP"];

        echo "<font color=red>NO_DATA " . $id . " , " . $item['LectureCode'] ." , ". $item['LectureTerme_idx'] . " , " . "</font> <br>";
        $data["list"][0] = Array("Seq"=>$seq, "ID"=>$id, "LectureCode"=>$lecture_code, "LectureTerme_idx"=>$lecture_terme_idx, "PASS_FLAG"=>$pass_flag, "InputDate"=>$input_date, "StudyIP"=>$StudyIP, "EMP_INS_FLAG"=>1, "Progress"=>$progressRate, "TotalScore"=>$TotalScore);
    } else {
//        continue;
    }

    $user_no++;
    echo "<br/><b><font color=red>{$user_no} . USER_AGENT_PK : $id $name</font></b><br>";

    $no=0;
    foreach($data['list'] as $item){

        // 진도율,총점 구하기
        $progressRate = $item["Progress"];
        if (!$progressRate) $progressRate = 0;
        if ($item["TotalScore"]) {
            $totalScore = $item["TotalScore"];
        } else {
            $totalScore = 0; 
        }

//        if ($progressRate == 0) continue;
        $classAgentPk = $item['LectureCode'].",".$item['LectureTerme_idx'];

        $no++;
        echo "{$user_no}-{$no} . USER_AGENT_PK : $item[ID] , COURSE_AGENT_PK : $item[LectureCode] , classAgentPk : $classAgentPk , progressRate : $progressRate , totalScore : $totalScore  <br>";

        if ($item["PassOK"] == "Y") $item['PASS_FLAG'] = 1; else $item['PASS_FLAG'] = 0; //수료여부
        $item['EMP_INS_FLAG'] = 1; // 사업주환급
        $item['CHANGE_STATE'] = "C";
//        $item['CHANGE_STATE'] = $changestate;
        

         // 임시 삭제
//        $item['Seq'] = $seq;
//        $item['InputDate'] = $input_date;
//        $item['PASS_FLAG'] = $pass_flag;
//        $progressRate = "0";
//        $totalScore = "0";

        $paramArr[$tot_no]['agentPk']=$emon_agentPk;
        $paramArr[$tot_no]['seq']= $item['Seq'];
        $paramArr[$tot_no]['userAgentPk']=$item['ID'];
        $paramArr[$tot_no]['courseAgentPk']=$item['LectureCode'];
        $paramArr[$tot_no]['classAgentPk']=$classAgentPk;
        $paramArr[$tot_no]['passFlag']=$item['PASS_FLAG'];
        $paramArr[$tot_no]['attendValidFlag']=1;
        $paramArr[$tot_no]['changeState']=$item['CHANGE_STATE'];
        $paramArr[$tot_no]['regDate']=$item['InputDate'];
        $paramArr[$tot_no]['empInsFlag']=$item['EMP_INS_FLAG'];
        $paramArr[$tot_no]['loginIp']=$item['StudyIP'];
        $paramArr[$tot_no]["progressRate"] = $progressRate;
        $paramArr[$tot_no]["totalScore"] = $totalScore;

print_r($paramArr[$tot_no]);
echo "<br>";
        flush();

        $tot_no++;
    }
} // for


echo "<br/><br/><b><font color=blue>최종 전송</font></b><br>";
$requestArr["dataList"] = $paramArr;
print_r($requestArr);
echo "<br>";
exit;


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
echo $response ."<br>";
curl_close($ch);
flush();
//sleep(4); // 4초 딜레이

dbConnect();
$json_result_arr = json_decode($response, true);
$result_code = $json_result_arr['code'];
$result_msg = $json_result_arr['msg'];
$result_cnt = $json_result_arr['data_cnt'];

if(!$result_cnt) {
$result_cnt = 0;
}

echo "<font color=blue>총 : $tot_no 건 </font>";

exit;
