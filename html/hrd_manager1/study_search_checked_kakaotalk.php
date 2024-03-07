<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$mode = Replace_Check($mode); //발송 유형
$seq_value = Replace_Check($seq_value); //발송할 Study Seq값

$seq_array = explode('|',$seq_value);

$SendCount = 0;

if($mode=="Start") {

    foreach($seq_array as $seq) {

        $Sql = "SELECT a.ServiceType, AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS Mobile, b.Name, c.CompanyName, a.LectureStart, a.LectureEnd, c.CyberEnabled, c.CyberURL, a.ID, d.ContentsName FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			WHERE a.Seq=$seq";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);

		if($Row) {
			$ServiceType = $Row['ServiceType'];
			$Mobile = $Row['Mobile'];
			$Phone = str_replace("-","",$Mobile);
			$Name = $Row['Name'];
			$CompanyName = $Row['CompanyName'];
			$LectureName = $Row['ContentsName'];
			$LectureStart = $Row['LectureStart'];
			$LectureEnd = $Row['LectureEnd'];
			$CyberEnabled = $Row['CyberEnabled'];
			$CyberURL = $Row['CyberURL'];
			$ID = $Row['ID'];
			$DayCheckMsg = date("Y-m-d");
			$indate_str1 = strtotime($DayCheckMsg."1 day");
			$DayCheckMsg2 = date("Y-m-d",$indate_str1);

			if($CyberEnabled=="Y") {
				$LinkDomain = $Row["CyberURL"];
			}

                        if(empty($LinkDomain)) {
				$LinkDomain = "https://www.hrdassetedu.com"; 
			}

			$vars = [
				    "회사명" => $SiteName,
				    "소속업체명" => $CompanyName,
				    "도메인" => $LinkDomain,
				    "아이디" => $ID,
				    "시작" => $LectureStart,
				    "종료" => $LectureEnd,
				    "이름" => $Name,
				    "과정명" => $LectureName,
			];

			if($ServiceType=="1") {
				$msg_type = "cronStart2";
				$msg_var = $SiteName."|".$CompanyName."|".$LectureStart."|".$LinkDomain."|".$ID."|".$DayCheckMsg2."|".$MobileAuthURL;
			}else{
				$msg_type = "cronStart1";
				$msg_var = $SiteName."|".$CompanyName."|".$LectureStart."|".$LinkDomain."|".$ID."|".$DayCheckMsg."|".$MobileAuthURL;
			}

			if(!empty($Phone)) {

				$result = hrdtalk($msg_type, $Phone, $vars, "hrd001");

				if($result === "Y") {
					$SendCount++;
				}
			}
		}
	}
}


//본인인증문자보내기#######################################################################
if($mode=="Auth") {

	foreach($seq_array as $seq) {

		$Sql = "SELECT a.ID, a.ServiceType, a.LectureStart, a.LectureEnd, AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS Mobile, b.Name, DATEDIFF(NOW(),a.LectureStart) AS diff_day, c.CyberEnabled, c.CyberURL, d.ContentsName FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			WHERE a.Seq=$seq";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);

		if($Row) {
			$ServiceType = $Row['ServiceType'];
			$Mobile = $Row['Mobile'];
			$msg_type = "cronAuth";
			$msg_mobile = str_replace("-","",$Mobile);
			$Name = $Row['Name'];
			$diff_day = $Row['diff_day'];
			$CyberEnabled = $Row['CyberEnabled'];
			$CyberURL = $Row['CyberURL'];
			$LectureStart = $Row['LectureStart'];
			$LectureEnd = $Row['LectureEnd'];
			$ID = $Row['ID'];
			$LectureName = $Row['ContentsName'];

			$DayCheckMsg = date("Y-m-d");
			$LinkDomain = $MobileAuthURL;

			//$msg_var = $Name."|".$DayCheckMsg."|".$LinkDomain;

			$vars = [
				    "회사명" => $SiteName,
				    "소속업체명" => $CompanyName,
				    "도메인" => $LinkDomain,
				    "아이디" => $ID,
				    "시작" => $LectureStart,
				    "종료" => $LectureEnd,
				    "이름" => $Name,
				    "과정명" => $LectureName,
			];

			if($msg_mobile) {
				$result = hrdtalk($msg_type,$msg_mobile,$vars,"hrd010-1");

				if($result=="Y") {
					$SendCount++;
				}
			}
		}
	}
}

echo $SendCount;

mysqli_close($connect);
?>
