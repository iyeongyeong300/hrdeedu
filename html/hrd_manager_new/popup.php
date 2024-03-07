<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>팝업 관리</h2>
<?
##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 25;
$block_size = 10;


##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
	$where[] = "";
	}else{
	$where[] = "$col LIKE '%$sw%'";
	}
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건

if($orderby=="") {
$orderby2 = "ORDER BY RegDate DESC";
}else{
$orderby2 = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Popup $where";
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
<SCRIPT LANGUAGE="JavaScript">
<!--

function DelSend(idx) {

del_confirm = confirm("현재 팝업을 삭제 하시겠습니까?");
if(del_confirm==true) {
	document.DelForm.idx.value=idx;
	DelForm.submit();
}
}
//-->
</SCRIPT>
<script language="javascript">
/**
* 레이어 추가
*/
var layer;
var offsetX;
var offsetY;

function select(el)
{
	layer = el;
	selectedDiv = document.getElementById(layer).style;
	if (selectedDiv)
	{
		offsetX = window.event.offsetX;
		offsetY = window.event.offsetY;
	}
	else
	{
		release(evt);
	}
	document.onmousedown = selectRun;
	return false;
}

/**
* 레이어 이동 및 선택해재
*/
function selectRun()
{
	document.onmousemove = drag;
	document.onmouseup = release;
}

/**
* 레이어 이동
*/
function drag(evt)
{
	if (selectedDiv)
	{
		selectedDiv.pixelTop = (window.event.clientY - offsetY);
		selectedDiv.pixelLeft = (window.event.clientX - offsetX);
		return false
	}
}

/**
* 레이어 선택해제
*/
function release(evt)
{
	if (selectedDiv)
	{
		selectedDiv = null;
		document.onmousedown = null;
		document.onmousemove = null;
		document.onmouseup = null;
	}
}
</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function PreviewSend(ImgPath,Width,Height) {

	popup.style.visibility="hidden";
	popupimg.src="../upload/upload_popup/"+ImgPath;
	popupimg.width=Width;
	popupimg.Height=Height;
	popup.style.visibility="visible";
	}

	function CloseLayer() {

	 popup.style.visibility="hidden";
	}
//-->
</SCRIPT>
            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->

					<form name="DelForm" method="POST" action="popup_reg_script.php" enctype="multipart/form-data">
					<input type="hidden" name="idx">
					<input type="hidden" name="mode" value="del">
					</form>
                <!--목록 -->
				<div class="btnAreaTr02">
					<input type="button" name="Btn" id="Btn" value="팝업 등록" class="btn_inputBlue01" onclick="location.href='popup_reg.php?mode=new'">
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="40px" />
                    <col width="" />
                    <col width="140px" />
                    <col width="140px" />
                    <col width="80px" />
					<col width="80px" />
					<col width="100px" />
					<col width="80px" />
					<col width="60px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>제목</th>
					<th>이미지 사이즈</th>
					<th>팝업 위치</th>
					<th>마감일</th>
					<th>사용여부</th>
					<th>등록일</th>
					<th>미리보기</th>
					<th>삭제</th>
                  </tr>
					<?
					$SQL = "SELECT *, LEFT(RegDate,10) AS RegDate2 FROM Popup $where $orderby2 LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td style="text-align:left"><a href="popup_r.php?idx=<?=$idx?>&pg=<?=$pg?>&sw=<?=$sw?>&col=<?=$col?>" onFocus="blur()"><?=$Title?></a></td>
					<td><?=$ImgWidth?>(W) X <?=$ImgHeight?>(H)</td>
					<td>좌측:<?=$PopupLeft?>, 상단:<?=$PopupTop?></td>
					<td><?=$EndDate?></td>
					<td><?=$UseYN?></td>
					<td><?=$RegDate2?></td>
					<td><input type="button"  value="보기" class="btn_inputSm01" onclick="PreviewSend('<?=$ImgName?>',<?=$ImgWidth?>,<?=$ImgHeight?>);"></td>
					<td><input type="button"  value="삭제" class="btn_inputSm01" onclick="DelSend(<?=$idx?>);"></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="10">등록된 글이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>

                <div class="btnAreaTr02">
					<input type="button" name="Btn" id="Btn" value="팝업 등록" class="btn_inputBlue01" onclick="location.href='popup_reg.php?mode=new'">
              	</div>
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


<DIV style='BORDER-RIGHT: #a2a2a2 1px solid; PADDING-RIGHT: 5px; BORDER-TOP: #a2a2a2 1px solid; PADDING-LEFT: 5px; FILTER: alpha(opacity=100); PADDING-BOTTOM: 5px; BORDER-LEFT: #a2a2a2 1px solid; PADDING-TOP: 5px; BORDER-BOTTOM: #a2a2a2 1px solid; POSITION: absolute; BACKGROUND-COLOR: white; left:300px; top: 90px;z-index:100; visibility: hidden;' id='popup'><table border='0' align='center' cellpadding='0' cellspacing='0' onmousedown="select('popup')"><tr><td><img src='/popup/upload_popup/' border='0' name="popupimg"></td></tr><tr><td height='24' align='center' valign='top' bgcolor='707070'><table width='98%'  border='0' cellspacing='0' cellpadding='0'><tr><td align='right'><font color='#EAEAEA'>오늘 하루 창 열지 않기&nbsp;&nbsp;&nbsp;<a href='javascript:CloseLayer()'><img src='./images/close01.gif' border='0' align='absmiddle' ></a></font></td></tr></table></td></tr></table></div>