<?
$MenuType = "C";
$PageName = "smsdata";
$ReadPage = "smsdat_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>문자/템플릿 관리 </h2>
<?
##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "$col LIKE '%$sw%'";
	}
}

$where[] = "Del='N'";
 

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY RegDate DESC, idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM SendMessage $where";
$Result = mysqli_query($connect, $Sql);
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
                            	<!-- ## START -->
                
				<table class="view_ty01 tl pt15">
					<tbody>
						<tr>
							<th colspan="3" class="tc" style="background:#e2e9ed;">아래 키워드를 사용하면 해당 메시지가 적용됩니다.</th> 
						</tr>
						<tr>
							<th><strong>{시작}</strong></th>
							<td>수강시작일</td>
							<td>예) 2019-01-01</td>
						</tr>
						<tr>
							<th><strong>{종료}</strong></th>
							<td>수강종료일</td>
							<td>예) 2019-01-31</td>
						</tr>
						<tr>
							<th><strong>{회사명}</strong></th>
							<td>발송 시 앞에 붙는 기관명</td>
							<td>예) ㅇㅇㅇ교육원</td>
						</tr>
						<tr>
							<th><strong>{소속업체명}</strong></th>
							<td>학습자가 소속된 업체명</td>
							<td>예) SK텔레콤</td>
						</tr>
						<tr>
							<th><strong>{도메인}</strong></th>
							<td>학습사이트주소</td>
							<td>예) http://abc.co.kr</td>
						</tr>
						<tr>
							<th><strong>{아이디}</strong></th>
							<td>학습자아이디</td>
							<td>예) aaa54789</td>
						</tr>
						<tr>
							<th><strong>{이름}</strong></th>
							<td>학습자이름</td>
							<td>예) 홍길동</td>
						</tr>
						<tr>
							<th><strong>{과정명}</strong></th>
							<td>수강중인 과정명</td>
							<td>예) 직무필수교육</td>
						</tr>
					</tbody>
				</table>
                <!--목록 --> 	
				<BR><BR>
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
					
						<option value="TemplateMessage" <?if($col=="TemplateMessage") { echo "selected";}?>>메시지</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
				<?}?>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="80px" />
                    <col width="100px" />
                    <col width="80px"/>
                    <col style="max-width:300px;" />
					<col width="120px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>모드</th>
                    <th>템플릿코드</th>
                 
					<th style="max-width:300px;" > 메시지</th>
					<th width="120px" >사용 유무</th>
                  </tr>
 
					<?
					$SQL = "SELECT * FROM SendMessage $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if($UseYN=="Y") {
								$UseYN_MSG = "<font color='blue'>사용</font>";
							}else{
								$UseYN_MSG = "<font color='red'>미사용</font>";
							}
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td> <?=$MessageMode?> </td>
					<td><?=$TemplateCode?></td>
			
					<td><?=$TemplateMessage?></td>
					<td>
						<a href="<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>">[수정]</a>						<a href="#" onClick="javascript:DelOk(<?=$idx?>);">[삭제]</a>
					
					</td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="6">등록된 내용이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
				<?}?>
              	</div>
            	<!-- 버튼 -->

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
	<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk(idx) {

	del_confirm = confirm("현재 글을 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.idx.value = idx;
		DeleteForm.submit();
	}
}

//-->
</SCRIPT>
<form name="DeleteForm" method="post" action="smsdata_script.php" enctype="multipart/form-data" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>