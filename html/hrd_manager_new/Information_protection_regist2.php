<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$TB = Replace_Check($TB);
$url = Replace_Check($url);
$Exp = Replace_Check($Exp);
$send_url = Replace_Check($send_url);
$ID = Replace_Check($ID);
?>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>개인정보 열람사유 작성</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="InformationProtectionForm" method="post" action="Information_protection_regist2_ok.php" target="ScriptFrame">
				<INPUT TYPE="hidden" NAME="TB" id="TB" value="<?=$TB?>">
				<INPUT TYPE="hidden" NAME="url" id="url" value="<?=$url?>">
				<INPUT TYPE="hidden" NAME="Exp" id="Exp" value="<?=$Exp?>">
				<INPUT TYPE="hidden" NAME="send_url" id="send_url" value="<?=$send_url?>">
				<INPUT TYPE="hidden" NAME="ID" id="ID" value="<?=$ID?>">
				<INPUT TYPE="hidden" NAME="AdminID" id="AdminID" value="<?=$LoginAdminID?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>열람자</th>
                    <td><?=$LoginAdminName?> (<?=$LoginAdminID?>)</td>
                  </tr>
				  <tr>
                    <th>열람 항목</th>
                    <td><?=$Exp?></td>
                  </tr>
                  <tr>
                    <th>구분</th>
                    <td>
					<select name="Gubun" id="Gubun">
						<option value="학습자 관리">학습자 관리</option>
						<option value="학습자 요청">학습자 요청</option>
						<option value="기타 상담">기타 상담</option>
					</select>
					</td>
                  </tr>
				  <tr>
                    <th>사유</th>
                    <td><textarea name="Content" id="Content" style="width:450px; height:150px"><?=$Content?></textarea></td>
                  </tr>
                </table>
				</form>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center"><input type="button" value="등록 하기" onclick="InformationProtectionSubmitOk2();" class="btn_inputBlue01"></td>
						<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose2();" class="btn_inputLine01"></td>
					</tr>
				</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>