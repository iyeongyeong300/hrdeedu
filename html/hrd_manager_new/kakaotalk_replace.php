<?
$MenuType = "C";
$PageName = "kakaotalk_replace";
$ReadPage = "kakaotalk_replace_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>알림톡 전환전송 내역(LMS)<span class="fs12 description">알림톡 전환전송 내역(LMS) 입니다.</span></h2>
<?
mysqli_close($connect);

include "../include/kakao_db.php";


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
$Sql = "SELECT COUNT(*) FROM HRDTALK.MTS_MMS_MSG_LOG $where";
$Result = mysqli_query($connect_kakao, $Sql);
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
                    <button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
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
					$SQL = "SELECT * FROM HRDTALK.MTS_MMS_MSG_LOG $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					$QUERY = mysqli_query($connect_kakao, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							switch($TRAN_RSLT){ //전송결과
								case "10":
									$tran_rslt_msg = "한도초과 발신제한";
								break;
								case "11":
									$tran_rslt_msg = "수신번호 정합성 오류";
								break;
								case "40":
									$tran_rslt_msg = "발신번호세칙오류";
								break;
								case "50":
									$tran_rslt_msg = "사전미등록 발신번호사용";
								break;
								case "112":
									$tran_rslt_msg = "레포트수신시간만료";
								break;
								case "114":
									$tran_rslt_msg = "문자피싱미등록으로 인한 차단";
								break;
								case "116":
									$tran_rslt_msg = "발신번호 세칙 오류";
								break;
								case "202":
									$tran_rslt_msg = "착신가입자없음";
								break;
								case "203":
									$tran_rslt_msg = "비가입자, 결번, 서비스정지";
								break;
								case "1000":
									$tran_rslt_msg = "성공";
								break;
								case "1013":
									$tran_rslt_msg = "결번";
								break;
								case "1026":
									$tran_rslt_msg = "음영지역";
								break;
								case "2107":
									$tran_rslt_msg = "착신번호 오류";
								break;
								case "4005":
									$tran_rslt_msg = "기타에러";
								break;
								case "4007":
									$tran_rslt_msg = "서비스를 요청한 클라이언트가 permission이 없는 경우 ";
								break;
								case "4301":
									$tran_rslt_msg = "미 가입자 에러 오류";
								break;
								case "4305":
									$tran_rslt_msg = "비가용폰 오류";
								break;
								case "4307":
									$tran_rslt_msg = "일시정지 가입자 오류";
								break;
								case "8012":
									$tran_rslt_msg = "기타에러";
								break;
								case "8200":
									$tran_rslt_msg = "MMSC 전송 시 알 수 없는 오류";
								break;
								case "9999":
									$tran_rslt_msg = "패킷오류";
								break;
							}
							
							if(strtoupper(mb_detect_encoding($TRAN_MSG))=="EUC-KR") $TRAN_MSG = iconv("EUC-KR","UTF-8",$TRAN_MSG);

							$TRAN_PHONE = InformationProtection($TRAN_PHONE,'Mobile2','S');
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$TRAN_PHONE?></td>
					<td><?=$TRAN_DATE?></td>
					<td><?=$TRAN_REPORTDATE?></td>
					<td ><?=$TRAN_RSLT?></td>
					<td><?=$tran_rslt_msg?></td>
					<td class="tl"><?=$TRAN_MSG?></td>
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