<?
$MenuType = "C";
$PageName = "kakaotalk";
$ReadPage = "kakaotalk_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>알림톡 발송내역 | <span class="fs12 fcfff">알림톡 발송내역입니다.</span></h2>
<?
//mysqli_close($connect);
//include "../include/kakao_db.php";

##-- 검색 조건
$where = array();


if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "$col LIKE '%$sw%'";
	}
}

$where[] = "TRAN_PR <> 0";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
$str_orderby = "ORDER BY TRAN_PR DESC";

##-- 검색 등록수
$sql = "SELECT COUNT(*) FROM HRDTALK.MTS_ATALK_MSG_LOG $where";
//$Result = mysqli_query($connect_kakao, $Sql);
$Result = mysqli_query($connect, $sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
						<option value="tran_phone" <?if($col=="tran_phone") { echo "selected";}?>>휴대폰 번호</option>
						<option value="tran_msg" <?if($col=="tran_msg") { echo "selected";}?>>메세지 내용</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="80px" />
                    <col width="80px" />
                    <col width="120px" />
                    <col width="120px" />
					<col width="80px" />
					<col width="200px" />
					<col width="" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>수신번호</th>
                    <th>전송요청시간</th>
                    <th>수신한 시간</th>
					<th>결과 코드</th>
					<th>전송결과</th>
					<th>전송 메세지</th>
                  </tr>
					<?
					$SQL = "SELECT * FROM HRDTALK.MTS_ATALK_MSG_LOG ORDER BY TRAN_PR DESC LIMIT 100";
					$QUERY = mysqli_query($connect, $SQL);

					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							switch($TRAN_RSLT){ //전송결과
								case "1000":
									$tran_rslt_msg = "성공";
								break;
								case "1001":
									$tran_rslt_msg = "Request Body가 Json형식이 아님";
								break;
								case "1002":
									$tran_rslt_msg = "허브 파트너 키가 유효하지 않음";
								break;
								case "1003":
									$tran_rslt_msg = "발신 프로필 키가 유효하지 않음";
								break;
								case "1004":
									$tran_rslt_msg = "Request Body(Json)에서 name을 찾을 수 없음";
								break;
								case "1005":
									$tran_rslt_msg = "발신프로필을 찾을 수 없음";
								break;
								case "1006":
									$tran_rslt_msg = "삭제된 발신프로필. (메시지 사업 담당자에게 문의)";
								break;
								case "1007":
									$tran_rslt_msg = "차단 상태의 발신프로필. (메시지 사업 담당자에게 문의)";
								break;
								case "1008":
									$tran_rslt_msg = "차단 상태의 옐로아이디. (옐로아이디 홈에서 확인)";
								break;
								case "1009":
									$tran_rslt_msg = "닫힘 상태의 옐로아이디. (옐로아이디 홈에서 확인)";
								break;
								case "1010":
									$tran_rslt_msg = "삭제된 옐로아이디. (옐로아이디 홈에서 확인)";
								break;
								case "1011":
									$tran_rslt_msg = "계약정보를 찾을 수 없음. (메시지 사업 담당자에게 문의)";
								break;
								case "1012":
									$tran_rslt_msg = "잘못된 형식의 유저키 요청";
								break;
								case "1021":
									$tran_rslt_msg = "차단상태의 플러스친구";
								break;
								case "1022":
									$tran_rslt_msg = "삭제된 플러스 친구";
								break;
								case "1023":
									$tran_rslt_msg = "닫힘 상태의 플러스 친구";
								break;
								case "1024":
									$tran_rslt_msg = "삭제대기 상태의 플러스 친구";
								break;
								case "1030":
									$tran_rslt_msg = "잘못된 파라메터 요청";
								break;
								case "2003":
									$tran_rslt_msg = "메시지 전송 실패(테스트 서버에서 친구관계가 아닌 경우)";
								break;
								case "2004":
									$tran_rslt_msg = "템플릿 일치 확인시 오류 발생(내부 오류 발생)";
								break;
								case "3000":
									$tran_rslt_msg = "예기치 않은 오류 발생";
								break;
								case "3005":
									$tran_rslt_msg = "메시지를 발송했으나 수신확인 안됨 (성공불확실)";
								break;
								case "3006":
									$tran_rslt_msg = "내부 시스템 오류로 메시지 전송 실패";
								break;
								case "3008":
									$tran_rslt_msg = "전화번호 오류";
								break;
								case "3010":
									$tran_rslt_msg = "Json 파싱 오류";
								break;
								case "3011":
									$tran_rslt_msg = "메시지가 존재하지 않음";
								break;
								case "3012":
									$tran_rslt_msg = "메시지 일련번호가 중복됨";
								break;
								case "3013":
									$tran_rslt_msg = "메시지가 비어 있음";
								break;
								case "3014":
									$tran_rslt_msg = "메시지 길이 제한 오류";
								break;
								case "3015":
									$tran_rslt_msg = "템플릿을 찾을 수 없음";
								break;
								case "3016":
									$tran_rslt_msg = "메시지 내용이 템플릿과 일치하지 않음";
								break;
								case "3018":
									$tran_rslt_msg = "메시지를 전송할 수 없음(* 친구톡 : 친구 관계 아님)";
								break;
								case "3019":
									$tran_rslt_msg = "메시지가 발송되지 않은 상태";
								break;
								case "3020":
									$tran_rslt_msg = "메시지 확인 정보를 찾을 수 없음";
								break;
								case "3022":
									$tran_rslt_msg = "메시지 발송 가능한 시간이 아님";
								break;
								case "3024":
									$tran_rslt_msg = "메시지에 포함된 이미지를 전송할 수 없음";
								break;
								case "4000":
									$tran_rslt_msg = "메시지 전송 결과를 찾을 수 없음";
								break;
								case "4001":
									$tran_rslt_msg = "알 수 없는 메시지 상태";
								break;
								case "8001":
									$tran_rslt_msg = "카카오 서버로 전송 중 오류 발생";
								break;
								case "9001":
									$tran_rslt_msg = "G/W와의 네트워크 오류로 인하여 전송 실패";
								break;
								case "9998":
									$tran_rslt_msg = "시스템에 문제가 발생하여 담당자가 확인하고 있는 경우";
								break;
								case "9999":
									$tran_rslt_msg = "시스템에 문제가 발생하여 담당자가 확인하고 있는 경우";
								break;
							}

							if(strtoupper(mb_detect_encoding($TRAN_MSG))=="EUC-KR") $TRAN_MSG = iconv("EUC-KR","UTF-8",$TRAN_MSG);

							$TRAN_PHONE = InformationProtection($TRAN_PHONE,'Mobile2','S');
					?>
                  <tr>
					<td><?=$TRAN_PR?></td>
					<td><?=$TRAN_PHONE?></td>
					<td><?=$TRAN_DATE?></td>
					<td><?=$TRAN_REPORTDATE?></td>
					<td ><?=$TRAN_RSLT?></td>
					<td><?=$tran_rslt_msg?></td>
					<td align="left"><?=$TRAN_MSG?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 발송내역이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>

            	<!-- 버튼 -->

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>
