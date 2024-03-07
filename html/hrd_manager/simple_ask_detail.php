<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT *, AES_DECRYPT(UNHEX(Phone),'$DB_Enc_Key') AS Phone, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email FROM SimpleAsk WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ID = $Row['ID'];
	$Name = $Row['Name'];
	$Phone = $Row['Phone'];
	$Email = $Row['Email'];
	$Contents = $Row['Contents'];
	$Status = $Row['Status'];
}

if(!$ID) {
	$ID = "비회원";
}

$Phone = InformationProtection($Phone,'Tel','S');
$Email = InformationProtection($Email,'Email','S');
?>


	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>간편문의 상세정보</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<INPUT TYPE="hidden" name="SimpleAsk_idx" id="SimpleAsk_idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
				  <tr>
                    <th>아이디</th>
                    <td><?=$ID?> </td>
                  </tr>
                  <tr>
                    <th>이름</th>
                    <td><?=$Name?> </td>
                  </tr>
				  <tr>
                    <th>연락처</th>
                    <td><span id="InfoProt_Phone"><a href="Javascript:InformationProtection('SimpleAsk','Phone','InfoProt_Phone','<?=$idx?>','<?=$_SERVER['PHP_SELF']?>','연락처');"><?=$Phone?></a></span></td>
                  </tr>
				   <tr>
                    <th>이메일</th>
                    <td><span id="InfoProt_Email"><a href="Javascript:InformationProtection('SimpleAsk','Email','InfoProt_Email','<?=$idx?>','<?=$_SERVER['PHP_SELF']?>','이메일');"><?=$Email?></a></span></td>
                  </tr>
				  <tr>
                    <th>상태</th>
                    <td>
					<select name="SimpleAskStatus" id="SimpleAskStatus">
						<?while (list($key,$value)=each($SimpleAskStatus_array)) {?>
						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
                  
				  <tr>
                    <th>메세지</th>
                    <td><textarea name="Contents" id="Contents" style="width:650px;height:300px"><?=$Contents?></textarea></td>
                  </tr>
                </table>
				</form>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center">
						<span id="SubmitBtn"><input type="button" value="상태 변경 하기" onclick="SimpleAskDetailChange()" class="btn_inputBlue01"></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
						</td>
						<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
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