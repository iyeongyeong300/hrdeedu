<?
include "../../../../include/include_top.php";

include "../../../../include/include_function.php"; //DB연결 및 각종 함수 정의
?>
        
       
        <!-- Content -->
        <div id="Content">
        	<!-- left area -->
<?
include "./include_mylecture.php";
?>
            <!-- left area // -->
<script type="text/javascript">
	function cancelTid() {
		var form = document.frm;

		var win = window.open('', 'OnLine', 'scrollbars=no,status=no,toolbar=no,resizable=0,location=no,menu=no,width=600,height=400');
		win.focus();
		form.action = "http://walletpaydemo.inicis.com/stdpay/cancel/INIcancel_index.jsp";
		form.method = "post";
		form.target = "OnLine";
		form.submit();

	}
</script>
            <!-- content area -->
            <div class="contentArea">
            
            	<!-- h3 here -->
                <div class="h3Area">
                	<div class="here">홈 &gt; 나의 강의실 &gt; 결제관리</div>
                    <h3>결제관리</h3>
                </div>
                <!-- h3 here // -->
                
                <!-- content Info -->
<?php
        require_once('../libs/INIStdPayUtil.php');
        require_once('../libs/HttpClient.php');


        $util = new INIStdPayUtil();

        try {

            //#############################
            // 인증결과 파라미터 일괄 수신
            //#############################
            //		$var = $_REQUEST["data"];

            //#####################
            // 인증이 성공일 경우만
            //#####################
            if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

				

                //echo "####인증성공/승인요청####";
                //echo "<br/>";

                //############################################
                // 1.전문 필드 값 설정(***가맹점 개발수정***)
                //############################################;

                $mid 			= $_REQUEST["mid"];     					// 가맹점 ID 수신 받은 데이터로 설정
                //$signKey 		= "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; 		// 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
				$signKey 		= "MTF1aitmVDk0OTVrZG9UVkZrb1Rqdz09";
                $timestamp 		= $util->getTimestamp();   					// util에 의해서 자동생성
                $charset 		= "UTF-8";        							// 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
                $format 		= "JSON";        							// 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)
                $authToken 		= $_REQUEST["authToken"];   				// 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
                $authUrl 		= $_REQUEST["authUrl"];    					// 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
                $netCancel 		= $_REQUEST["netCancelUrl"];   				// 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)
                $mKey 			= hash("sha256", $signKey);					// 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
                $merchantData 	= $_REQUEST["merchantData"];     			// 가맹점 관리데이터 수신
                
                //#####################
                // 2.signature 생성
                //#####################
                $signParam["authToken"] 	= $authToken;  	// 필수
                $signParam["timestamp"] 	= $timestamp;  	// 필수
                // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
                $signature = $util->makeSignature($signParam);


                //#####################
                // 3.API 요청 전문 생성
                //#####################
                $authMap["mid"] 			= $mid;   		// 필수
                $authMap["authToken"] 		= $authToken; 	// 필수
                $authMap["signature"] 		= $signature; 	// 필수
                $authMap["timestamp"] 		= $timestamp; 	// 필수
                $authMap["charset"] 		= $charset;  	// default=UTF-8
                $authMap["format"] 			= $format;  	// default=XML


                try {

                    $httpUtil = new HttpClient();

                    //#####################
                    // 4.API 통신 시작
                    //#####################

                    $authResultString = "";
                    
                    if ($httpUtil->processHTTP($authUrl, $authMap)) {
                        $authResultString = $httpUtil->body;
                        //echo "<p><b>RESULT DATA :</b> $authResultString</p>";			//PRINT DATA
                    } else {
                        //echo "Http Connect Error\n";
                        //echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    //############################################################
                    //5.API 통신결과 처리(***가맹점 개발수정***)
                    //############################################################
                    //echo "## 승인 API 결과 ##";

                    $resultMap = json_decode($authResultString, true);
					
                    //echo "<pre>";
                    //echo "<table width='565' border='0' cellspacing='0' cellpadding='0'>";
                    
                    /*************************  결제보안 추가 2016-05-18 START ****************************/ 
                    $secureMap["mid"]		= $mid;							//mid
                    $secureMap["tstamp"]	= $timestamp;					//timestemp
                    $secureMap["MOID"]		= $resultMap["MOID"];			//MOID
                    $secureMap["TotPrice"]	= $resultMap["TotPrice"];		//TotPrice
                    
                    // signature 데이터 생성 
                    $secureSignature = $util->makeSignatureAuth($secureMap);
                    /*************************  결제보안 추가 2016-05-18 END ****************************/

					if ((strcmp("0000", $resultMap["resultCode"]) == 0) && (strcmp($secureSignature, $resultMap["authSignature"]) == 0) ){	//결제보안 추가 2016-05-18
					   /*****************************************************************************
				       * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다. 

						 [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
								처리중 에러 발생시 망취소를 한다.
				       ******************************************************************************/
					   //결제 성공시 업데이트-------------------------------------------------------------------------
						
						$PayMethod = $resultMap["payMethod"];
						$MOID = $resultMap["MOID"];
						$tid = $resultMap["tid"];
						$merchantData_array = explode('|',$merchantData);
						$CompanyCode = $merchantData_array[0];
						$LectureStart = $merchantData_array[1];
						$LectureEnd = $merchantData_array[2];

						$Sql = "UPDATE PaymentSheet SET PayStatus='Y', PayMethod='$PayMethod', MOID='$MOID', tid='$tid', PayDate=NOW() WHERE CompanyCode='".$CompanyCode."' AND LectureStart='".$LectureStart."' AND LectureEnd='".$LectureEnd."'";
						$Row = mysql_query($Sql);

?>
						<script type="text/javascript">
						<!--
							alert("결제가 완료되었습니다.");
							location.href="/mylecture/payment.php";
						//-->
						</script>
<?
						//결제 성공시 업데이트-------------------------------------------------------------------------

                        //echo "<tr><th class='td01'><p>거래 성공 여부</p></th>";
                        //echo "<td class='td02'><p>성공</p></td></tr>";
					} else {
                        //echo "<tr><th class='td01'><p>거래 성공 여부</p></th>";
                        //echo "<td class='td02'><p>실패</p></td></tr>";
						//echo "<tr><th class='line' colspan='2'><p></p></th></tr>
	                   //     <tr><th class='td01'><p>결과 코드</p></th>
	                    //    <td class='td02'><p>" . @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : "null" ) . "</p></td></tr>";
						
						//결제보안키가 다른 경우.
						if ((strcmp($secureSignature, $resultMap["authSignature"]) != 0) && (strcmp("0000", $resultMap["resultCode"]) == 0)) {
							//echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							//	<tr><th class='td01'><p>결과 내용</p></th>
							//	<td class='td02'><p>" . "* 데이터 위변조 체크 실패" . "</p></td></tr>";

							//망취소
							if(strcmp("0000", $resultMap["resultCode"]) == 0) {
								throw new Exception("데이터 위변조 체크 실패");
							}
						} else {
							//echo "<tr><th class='line' colspan='2'><p></p></th></tr>
							//	<tr><th class='td01'><p>결과 내용</p></th>
							//	<td class='td02'><p>" . @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : "null" ) . "</p></td></tr>";
						}
                        
                    }

 

                    // 수신결과를 파싱후 resultCode가 "0000"이면 승인성공 이외 실패
                    // 가맹점에서 스스로 파싱후 내부 DB 처리 후 화면에 결과 표시
                    // payViewType을 popup으로 해서 결제를 하셨을 경우
                    // 내부처리후 스크립트를 이용해 opener의 화면 전환처리를 하세요
                    //throw new Exception("강제 Exception");
                } catch (Exception $e) {
                    // $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    //####################################
                    // 실패시 처리(***가맹점 개발수정***)
                    //####################################
                    //---- db 저장 실패시 등 예외처리----//
                    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    echo $s;

                    //#####################
                    // 망취소 API
                    //#####################

                    $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
                    
                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

					//echo "<br/>## 망취소 API 결과 ##<br/>";
					
					/*##XML output##*/
					//$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
					//$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);
					
                    // 취소 결과 확인
                    //echo "<p>". $netcancelResultString . "</p>";
                }
            } else {

                //#############
                // 인증 실패시
                //#############
                //echo "<br/>";
                //echo "####인증실패####";
				
                //echo "<pre>" . var_dump($_REQUEST) . "</pre><BR><BR>";
				//echo "<pre>" . $_REQUEST['resultMsg'] . "</pre>";

				$FailReason = $_REQUEST['resultMsg'];
?>
<script type="text/javascript">
<!--
	alert("결제에 실패하였습니다.\n\n[ <?=$FailReason?> ]");
	location.href="/mylecture/payment.php";
//-->
</script>
<?
            }
        } catch (Exception $e) {
            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            echo $s;
        }
?>
                <!-- content Info // -->
            
            </div>
            <!-- content area // -->

        </div>
        <!-- Content // -->
         
<?
include "../../../../include/include_bottom.php";
?>