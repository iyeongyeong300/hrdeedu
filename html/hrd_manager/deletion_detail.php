<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$id = Replace_Check($id);
?>


	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>회원 데이터 삭제 기록</h2>
            <br><br>
            <div class="conZone">
            	<!-- ## START -->
                <form name="deletionDetailForm" method="post" action="delete_member_data.php">
                	<input type="hidden" name="id" id="id" value="<?=$id?>">
                	<input type="hidden" name="adminId" id="adminId" value="<?=$LoginAdminID?>">
                    <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                      <colgroup>
                        <col width="120px" />
                        <col width="" />
                      </colgroup>
    				  <tr>
                        <th>삭제될 회원</th>
                        <td><?=$id?> </td>
                      </tr>
                      <tr>
                        <th>삭제일</th>
                        <td><?=date('Y-m-d')?> </td>
                      </tr>
    				  <tr>
                        <th>삭제한 관리자</th>
                        <td><?=$LoginAdminID?></td>
                      </tr>                 
    				  <tr>
                        <th>삭제 사유</th>
                        <td><textarea name="reason" id="reason" style="width:600px;height:250px"><?=$reason?></textarea></td>
                      </tr>
                    </table>
                </form>
				<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td width="200" align="center"><input type="button" value="삭제하기" onclick="DeleteMemberData('<?=$id?>');" class="btn_inputLine01"></td>
						<td width="200" align="center"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
					</tr>
				</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
<?
mysqli_close($connect);
?>