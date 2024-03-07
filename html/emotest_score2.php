<?php
include "./include/include_function.php";

set_time_limit(0);

// ############################################################################
// 성적이력 API 전송 
// ProgressLog 사용 
// ############################################################################

//exit;
echo "<pre>";

#트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

// 사이트별 산인공 Key
$emon_agentPk = "hrde1746";
$emon_API_KEY = "W1rnJsN9K1E4rHuK7UN0kb+u99D9pdOSl+mdQuA1zSQ=";

$paramArr = array();
$requestArr = array();
$idxArr = array();
$error_count = 0;
$error_count2 = 0;
$i = 0;


// 전송할 데이터 엑셀에서 붙여넣기
$send_text = "
hrde1746	N차 평가 훈련생의 이전 평가 이력 없음	A02022309	A02022309,3231	B002278831111	이종석	(주)원바이오젠	NCS기반_일잘러의 슬기로운 직장생활 - 사무에서 회의까지	20230613	20230713	81	100	시험_1	2023-07-20 10:20	219.249.63.64	64	2023-07-20 10:20	
";


$send_id_arr = explode("\n",$send_text);
echo "<style>*{font-size:12px;}</style>";
echo "총 : " . count($send_id_arr) . " 명<br>";
flush();

foreach ($send_id_arr as $arr) {
    $send_arr = explode("	",$arr);
    $USER_AGENT_PK = $send_arr[4];
    $COURSE_AGENT_PK = $send_arr[2];
    $CLASS_AGENT_PK = $send_arr[3];
    $SUBMIT_DATE_S = $send_arr[8];
    $SUBMIT_DATE_E = $send_arr[9];
    if (!$USER_AGENT_PK) continue;

    $no++;
    echo "$no . " . $USER_AGENT_PK . " , " . $COURSE_AGENT_PK . " , " . $CLASS_AGENT_PK . " , " . $SUBMIT_DATE_S . " , " . $SUBMIT_DATE_E . "<br>";
    flush();

    $CLASS_AGENT_PK_Arr = explode(",",$CLASS_AGENT_PK);
    $LectureTerme_idx = $CLASS_AGENT_PK_Arr[1];

    $SQL2 = "SELECT LectureEnd FROM LectureTerme WHERE idx={$LectureTerme_idx} AND LectureCode='{$COURSE_AGENT_PK}'";
    $QUERY2 = mysqli_query($connect, $SQL2);
    if($QUERY2 && mysqli_num_rows($QUERY2)){
        $ROW2 = mysqli_fetch_array($QUERY2);
        $SUBMIT_DUE_DT = $ROW2['LectureEnd'];
        $SUBMIT_DUE_DT = str_replace("-","",$SUBMIT_DUE_DT);
    }

    $SQL = "SELECT * FROM ProgressLog WHERE 
    ID='$USER_AGENT_PK' AND LectureCode='$COURSE_AGENT_PK' AND substring(replace(RegDate,'-',''),1,8) BETWEEN '$SUBMIT_DATE_S' AND '$SUBMIT_DATE_E' 
    ORDER BY RegDate ASC LIMIT 25000";
    //echo $SQL. "<br>";
    $QUERY = mysqli_query($connect, $SQL);
    if($QUERY && mysqli_num_rows($QUERY)){
        while($ROW = mysqli_fetch_array($QUERY)) {
            $seq = $ROW['idx'];
            $ROW['SDATE'] = substr($ROW['RegDate'],0,10);

            $progress = 0;
            $Chapter_Number = $ROW['Chapter_Number'];

            $SQL2 = "SELECT Progress FROM Progress WHERE ID='".$ROW['ID']."' AND LectureCode='".$ROW['LectureCode']."' AND CHAPTER_NUMBER='".$Chapter_Number."'";
            $QUERY2 = mysqli_query($connect, $SQL2);
            if($QUERY2 && mysqli_num_rows($QUERY2)){
                $ROW2 = mysqli_fetch_array($QUERY2);
                $progress = $ROW2['Progress'];
            }
            //echo $SQL2 . " " . $progress . "\n";

            if($progress > 98){
                
                $idxArr[] = $seq;

                $SQL2 = "SELECT 
                MIN(TotalProgress) AS MIN_SCORE,                 MIN(RegDate) AS MIN_SUBMIT_DATE,                 MIN(RegDate) AS MIN_REG_DATE, 
                MAX(TotalProgress) AS MAX_SCORE,                 MAX(RegDate) AS MAX_SUBMIT_DATE,                 MAX(RegDate) AS MAX_REG_DATE
                FROM ProgressLog WHERE 
                ID='".$ROW['ID']."' AND  Chapter_Number='".$Chapter_Number."' AND LectureCode='".$ROW['LectureCode']."' AND substring(RegDate,1,10)='".$ROW['SDATE']."' 
                ORDER BY idx ASC LIMIT 1";
                $QUERY2 = mysqli_query($connect, $SQL2);
                $ROW_DATE = mysqli_fetch_array($QUERY2);
                //echo $SQL2 . "\n";

                $EVAL_TYPE = "진도_". $Chapter_Number;

                $paramArr[$i]['agentPk']=$emon_agentPk;
                $paramArr[$i]['seq']=$seq;
                $paramArr[$i]['userAgentPk'] = $ROW['ID'];
                $paramArr[$i]['courseAgentPk'] = $ROW['LectureCode'];
                $paramArr[$i]['classAgentPk'] = $CLASS_AGENT_PK;
                $paramArr[$i]['evalType'] = $EVAL_TYPE;
                $paramArr[$i]['accessIp'] = $ROW['UserIP'];
                $paramArr[$i]['submitDueDt'] = $SUBMIT_DUE_DT;
                $paramArr[$i]['isCopiedAnswer'] = "X";
                $paramArr[$i]['evalCd'] = "01";
                $paramArr[$i]['chasi'] = $Chapter_Number;
                $paramArr[$i]['changeState'] = "C";
                $paramArr[$i]['score'] = $ROW_DATE['MIN_SCORE'];
                $paramArr[$i]['submitDate'] = $ROW_DATE['MIN_SUBMIT_DATE'];
                $paramArr[$i]['regDate'] = $ROW_DATE['MIN_REG_DATE'];
                $paramArr[$i]['startEndFlag'] = "S";

                $i++;

                $paramArr[$i]['agentPk']=$emon_agentPk;
                $paramArr[$i]['seq']=$seq;
                $paramArr[$i]['userAgentPk'] = $ROW['ID'];
                $paramArr[$i]['courseAgentPk'] = $ROW['LectureCode'];
                $paramArr[$i]['classAgentPk'] = $CLASS_AGENT_PK;
                $paramArr[$i]['evalType'] = $EVAL_TYPE;
                $paramArr[$i]['accessIp'] = $ROW['UserIP'];
                $paramArr[$i]['submitDueDt'] = $SUBMIT_DUE_DT;
                $paramArr[$i]['isCopiedAnswer'] = "X";
                $paramArr[$i]['evalCd'] = "01";
                $paramArr[$i]['chasi'] = $Chapter_Number;
                $paramArr[$i]['changeState'] = "U";
                $paramArr[$i]['score'] = $ROW_DATE['MAX_SCORE'];
                $paramArr[$i]['submitDate'] = $ROW_DATE['MAX_SUBMIT_DATE'];
                $paramArr[$i]['regDate'] = $ROW_DATE['MAX_REG_DATE'];
                $paramArr[$i]['startEndFlag'] = "E";

                $i++;

            }
        }
    }
    //print_r($paramArr);  flush(); exit;

    if ($no % 10 ==0) {

        //print_r($paramArr);  flush(); exit;

        echo "<br/>error_count : " . $error_count . " , idxArr : " . count($idxArr) ."<br>";

        if($error_count<1 && count($idxArr)>0) {

            $requestArr["dataList"] = $paramArr;

            //배열을 JSON 데이터로 생성
            $data = json_encode($requestArr);

            //URL 및 헤더 설정
            $url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_hist";
            $headers = array (
                                    "Content-Type: application/json",
                                    "X-TQIAPI-HEADER: ".$emon_API_KEY, "X-TQIAPI-USER: ".$emon_agentPk
                                    );

            //CURL 함수 사용
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            //헤더 값 세팅
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            //POST 방식으로 넘길 JSON 데이터 세팅
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            curl_close($ch);

            $json_result_arr = json_decode($response, true);
            $result_code = $json_result_arr['code'];
            $result_msg = $json_result_arr['msg'];
            $result_cnt = $json_result_arr['data_cnt'];

            if(!$result_cnt) {
                $result_cnt = 0;
            }
            echo "result_code=".$result_code . "\n";
            echo "result_msg=".$result_msg . "\n";
            echo "result_cnt=".$result_cnt . "\n";
            flush();
        }

        //DB에러가 없고 전송결과가 정상인 경우
        if($error_count<1 && $result_code=="200") {
            mysqli_query($connect, "COMMIT");
        }else{
            mysqli_query($connect, "ROLLBACK");
        }


        //항목이 존재하고 전송결과가 실패인 경우 에러 상태 변경
        if(count($idxArr)>0 && $result_code!="200") {

            foreach($idxArr as $idx_value) {

                $Sql7 = "UPDATE HRDAGENT.TB_SCORE_HIST_V2 SET USE_YN='E' WHERE SEQ=$idx_value";
                $Row7 = mysqli_query($connect, $Sql7);
                if(!$Row7) { //쿼리 실패시 에러카운터 증가
                    $error_count2++;
                }
            }

        }
        //항목이 존재하고 전송결과가 실패인 경우 에러 상태 변경

        if($error_count2<1) {
            mysqli_query($connect, "COMMIT");
        }else{
            mysqli_query($connect, "ROLLBACK");
        }
        echo count($paramArr) . "개 완료<br/><br/><br/>";
        unset($paramArr);
        unset($requestArr);
        unset($idxArr);
        #6) 성적이력 API 전송 ##############################################################
        sleep(60);        

        // 배열 초기화.
        $paramArr = array();
        $requestArr = array();
        $idxArr = array();
        $error_count = 0;
        $error_count2 = 0;
        $i = 0;
    }
}

//print_r($paramArr);
flush();
exit;

echo "<br/>error_count : " . $error_count . " , idxArr : " . count($idxArr) ."<br>";

if($error_count<1 && count($idxArr)>0) {

    $requestArr["dataList"] = $paramArr;

    //배열을 JSON 데이터로 생성
    $data = json_encode($requestArr);

    //URL 및 헤더 설정
    $url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_hist";
    $headers = array (
                            "Content-Type: application/json",
                            "X-TQIAPI-HEADER: ".$emon_API_KEY, "X-TQIAPI-USER: ".$emon_agentPk
                            );

    //CURL 함수 사용
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);

    //헤더 값 세팅
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //POST 방식으로 넘길 JSON 데이터 세팅
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    curl_close($ch);

    $json_result_arr = json_decode($response, true);
    $result_code = $json_result_arr['code'];
    $result_msg = $json_result_arr['msg'];
    $result_cnt = $json_result_arr['data_cnt'];

    if(!$result_cnt) {
        $result_cnt = 0;
    }
    echo "result_code=".$result_code . "\n";
    echo "result_msg=".$result_msg . "\n";
    echo "result_cnt=".$result_cnt . "\n";
    flush();
}

//DB에러가 없고 전송결과가 정상인 경우
if($error_count<1 && $result_code=="200") {
    mysqli_query($connect, "COMMIT");
}else{
    mysqli_query($connect, "ROLLBACK");
}


//항목이 존재하고 전송결과가 실패인 경우 에러 상태 변경
if(count($idxArr)>0 && $result_code!="200") {

    foreach($idxArr as $idx_value) {

        $Sql7 = "UPDATE HRDAGENT.TB_SCORE_HIST_V2 SET USE_YN='E' WHERE SEQ=$idx_value";
        $Row7 = mysqli_query($connect, $Sql7);
        if(!$Row7) { //쿼리 실패시 에러카운터 증가
            $error_count2++;
        }
    }

}
//항목이 존재하고 전송결과가 실패인 경우 에러 상태 변경

if($error_count2<1) {
    mysqli_query($connect, "COMMIT");
}else{
    mysqli_query($connect, "ROLLBACK");
}
echo count($paramArr) . "개 완료<br/><br/><br/>";
unset($paramArr);
unset($requestArr);
unset($idxArr);
#6) 성적이력 API 전송 ##############################################################
sleep(5);        

// 배열 초기화.
$paramArr = array();
$requestArr = array();
$idxArr = array();
$error_count = 0;
$error_count2 = 0;
$i = 0;

mysqli_close($connect);
?>
