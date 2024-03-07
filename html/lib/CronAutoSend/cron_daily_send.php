<?php

include "/home/LMS/public_html/include/include_function_cron.php";

// 본인인증 알림 : 개강 다음날 발송 ####

$SQL = "SELECT AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS PhoneNumber, b.Name, DATEDIFF(NOW(),a.LectureStart) AS diff_day, c.CyberEnabled, c.CyberURL, a.LectureStart, a.LectureEnd, c.CompanyName, d.ContentsName FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
                        LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode
			WHERE a.ServiceType=1 AND a.certCount<1 AND DATEDIFF(NOW(),a.LectureStart)=1 AND c.SendSMS='Y' AND b.ACS='Y' 
			ORDER BY a.Seq ASC
";

//echo $SQL;

$QUERY = mysqli_query($connect, $SQL);

$i = 0;
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{

		$Mobile = $ROW['PhoneNumber'];
		$msg_type = "cronAuth";
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];
		$diff_day = $ROW['diff_day'];
		$CyberEnabled = $ROW['CyberEnabled'];
		$CyberURL = $ROW['CyberURL'];
                $LectureStart = $ROW['LectureStart'];
                $LectureEnd = $ROW['LectureEnd'];
		$CompanyName = $ROW['CompanyName'];
		$LectureName = $ROW['ContentsName'];

		/*
		if($diff_day<1) {
			$DayCheckMsg = "내일";
		}else{
			$DayCheckMsg = "오늘";
		}
		*/

		$DayCheckMsg = date("Y-m-d");

		$LinkDomain = $MobileAuthURL;

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
                        $kakaotalk_result = hrdtalk($msg_type, $msg_mobile, $vars, "011");
                        echo " ". $msg_mobile . ",";
		}

                $i++;
	}
}

echo "\n" . $i . " identification check notification to student sent.";

sleep(1);

// 학습시작(개강알림) :비환급, 개강 당일 발송 ####

$SQL = "SELECT AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS PhoneNumber, b.Name, c.CompanyName, a.LectureStart, c.CyberEnabled, c.CyberURL, a.ID, d.ContentsName FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
                        LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode
			WHERE (a.ServiceType=3 OR a.ServiceType=5) AND DATEDIFF(NOW(),a.LectureStart)=0 AND c.SendSMS='Y' AND b.ACS='Y' 
			ORDER BY a.Seq ASC
			";

//echo $SQL;

$i = 0;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		$Mobile = $ROW['PhoneNumber'];
		$msg_type = "cronStart1";
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];
		$CompanyName = $ROW['CompanyName'];
		$LectureName = $ROW['ContentsName'];
		$LectureStart = $ROW['LectureStart'];
		$CyberEnabled = $ROW['CyberEnabled'];
		$CyberURL = $ROW['CyberURL'];
		$ID = $ROW['ID'];
		$DayCheckMsg = date("Y-m-d");

		if($CyberEnabled=="Y") {
			$LinkDomain = $CyberURL;
		}else{
			$LinkDomain = $SiteURL;
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

                if($msg_mobile) {
                        $kakaotalk_result = hrdtalk($msg_type, $msg_mobile, $vars, "001");
                }

                $i++;
	}
}

sleep(1);

// 학습시작(개강알림) :환급, 개강 당일 발송 ####

$SQL = "SELECT AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS PhoneNumber b.Name, c.CompanyName, a.LectureStart, c.CyberEnabled, c.CyberURL, a.ID, d.ContentsName FROM 
	Study AS a 
	LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
	LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
        LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode
	WHERE a.ServiceType=1 AND DATEDIFF(NOW(),a.LectureStart)=0 AND c.SendSMS='Y' AND b.ACS='Y' 
	ORDER BY a.Seq ASC
";

//echo $SQL;

$QUERY = mysqli_query($connect, $SQL);

if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		$Mobile = $ROW['PhoneNumber'];
		$msg_type = "cronStart2";
		$msg_mobile = str_replace("-","",$Mobile);
		$Name = $ROW['Name'];
		$CompanyName = $ROW['CompanyName'];
		$LectureName = $ROW['ContentsName'];
		$LectureStart = $ROW['LectureStart'];
		$CyberEnabled = $ROW['CyberEnabled'];
		$CyberURL = $ROW['CyberURL'];
		$ID = $ROW['ID'];
		$DayCheckMsg = date("Y-m-d");
		$indate_str1 = strtotime($DayCheckMsg."1 day");
		$DayCheckMsg2 = date("Y-m-d",$indate_str1);

		if($CyberEnabled=="Y") {
			$LinkDomain = $CyberURL;
		}else{
			$LinkDomain = $SiteURL;
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

                if($msg_mobile) {
                        $kakaotalk_result = hrdtalk($msg_type, $msg_mobile, $vars, "001");
                        echo " ". $msg_mobile . ",";
                }

                $i++;
	}
}

echo "\n" . $i . " class start notification sent.";

sleep(1);

// 교육담당자(개강알림) :교육담당자에게 메일 당일 발송####

// $SQL = "SELECT a.Seq, a.ID, a.CompanyCode, a.LectureStart, a.LectureEnd, a.LectureCode, 
// 			AES_DECRYPT(UNHEX(b.Email),'$DB_Enc_Key') AS EmailAddress, b.Name, 
// 			c.CompanyName,  c.CyberEnabled, c.CyberURL, c.CompanyID, 
// 			d.ContentsName, d.PassProgress, d.PassScore, d.MidRate, d.TestRate, d.ReportRate, d.TestTime 
// 			FROM Study AS a 
// 			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
// 			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
// 			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
// 			WHERE (a.ServiceType=1 OR a.ServiceType=3 OR a.ServiceType=5) AND DATEDIFF(NOW(),a.LectureStart)=0 AND c.SendSMS='Y' AND b.EduManager='Y' 
// 			ORDER BY a.Seq ASC
// ";
// Brad (2021.11.14) : 교육담당자 쿼리 수정
$SQL = "SELECT a.Seq, 
		a.ID, 
		a.CompanyCode, 
		a.LectureStart, 
		a.LectureEnd, 
		a.LectureCode,
		c.EduManagerEmail AS EmailAddress,
		c.EduManager,
		c.CompanyName,  c.CyberEnabled, c.CyberURL, c.CompanyID,
		d.ContentsName, d.PassProgress, d.PassScore, d.MidRate, d.TestRate, d.ReportRate, d.TestTime 
		FROM Study a 
		INNER JOIN Member b ON a.ID = b.ID
		INNER JOIN Company c ON a.CompanyCode = c.CompanyCode
		INNER JOIN Course AS d ON a.LectureCode =d.LectureCode 
		WHERE (a.ServiceType = 1 OR a.ServiceType =3 OR a.ServiceType  =5) 
		AND DATEDIFF(NOW(),a.LectureStart) = 0
		AND c.SendSMS = 'Y' 
		AND b.EduManager = 'Y' 
";

//echo $SQL;

$QUERY = mysqli_query($connect, $SQL);

$i = 0;
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		$Seq = $ROW['Seq'];
		$Email = $ROW['EmailAddress'];
		$Name = $ROW['Name'];
		$CompanyName = $ROW['CompanyName'];
		$CompanyID = $ROW['CompanyID'];
		$LectureStart = $ROW['LectureStart'];
		$CyberEnabled = $ROW['CyberEnabled'];
		$CyberURL = $ROW['CyberURL'];
		$ID = $ROW['ID'];
		$LectureStart = $ROW['LectureStart'];
		$LectureEnd = $ROW['LectureEnd'];
		$ContentsName = $ROW['ContentsName']; // #{강의명}
		$LectureCode = $ROW['LectureCode']; // #{강의코드}
		$PassProgress = $ROW['PassProgress']; // #{진도율}
		$PassScore = $ROW['PassScore']; // #{합격점}
		$MidRate = $ROW['MidRate'];
		$TestRate = $ROW['TestRate'];
		$ReportRate = $ROW['ReportRate'];
		$TestTime = $ROW['TestTime']; // #{강의시간}

		$LectureStart = str_replace("-",".",$LectureStart); // #{시작}
		$LectureEnd = str_replace("-",".",$LectureEnd); // #{종료}

		$MidRateView = $MidRate/100;
		$TestRateView = $TestRate/100;
		$TotalPointExp = (60*$MidRate/100) + (80*$TestRate/100);
		
		if($TotalPointExp>=$PassScore) $PassOkView = "수료";
		else $PassOkView = "미수료";

		$subject = "[교육담당자 안내 메일] 사이버학습센터 안내 메일입니다.";

		/* Brad (2021.11.14) : Message 내용 수정
    		$res = mysqli_query($connect, "SELECT Massage FROM SendMessage WHERE TemplateCode='hrd601' LIMIT 1");
    		$row = mysqli_fetch_array($res);

    		if (empty($row)) {
        		return "N2";
    		}	

                $vars = [
                    "강의명" => $ContentsName,
                    "강의코드" => $LectureCode,
                    "진도율" => $PassProgress,
                    "합격점" => $PassScore,
                    "시작" => $LectureStart,
                    "종료" => $LectureEnd,
                    "과정명" => $LectureName,
                    "시험시간" => $TestTime,
                ];

                $Mesage = $row['Massage'];
                foreach($vars as $key => $val) {
                    $Message = str_replace("#{".$key."}", $val, $Message);
                }
		*/
		$Massage = "<div style='width:800px; margin:0 auto; padding-bottom:40px;'>
					<p><img src='https://www.hrdassetedu.com/images/visual_img01.jpg' /></p>
					<p style='font-size:21px; font-weight:bold;'>안녕하세요!<br>HRD에셋평생교육원 교육운영팀입니다.</p>
					<div style='border:solid 2px #103a56; margin-top:30px; font-size:17px; font-weight:bold; line-height:1.8em;'>
						<ul>
							<li><span style='color:#059be3'>교 육 방 식 : </span>온라인교육 (인터넷강의 수강 후 평가 진행)</li>
							<li><span style='color:#059be3'>교 육 기 간 : </span><span style='color:#33F'>".$LectureStart." ~ ".$LectureEnd." 까지</span></li>
							<li><span style='color:#059be3'>교 육 대 상 : </span>근무하는 모든 임직원</li>
							<li><span style='color:#059be3'>수강 아이디 : </span>개별알림톡이나 문자 발송</li>
							<li><span style='color:#059be3'>비 밀 번 호 : </span>1111 <span style='color:#F60; font-size:15px;'>[최초 로그인 후 비밀번호 변경을 해주셔야 합니다.]</span></li>
						</ul>
					
					</div>
					<div style='margin-top:40px; font-size:16px; line-height:1.8em;'>
						<p style='font-size:21px; font-weight:bold;'>1. 수강방법 </p>
						<ul>
							<li>
								<a href='https://www.hrdassetedu.com'>https://www.hrdassetedu.com</a> 교육사이트를 통해 부여 받은 아이디/비밀번호로 로그인 후 교육 및 평가 진행<br>
								(휴대폰으로 아이디/비밀번호 전송예정) 자세한 내용은 첨부 자료 확인
							</li>
							<li><strong>PC로는 수강, 시험 모두 가능합니다 (노동부 고시 기준)</strong></li>
							<li><strong>스마트폰으로는 시험응시가 불가능하며 수강만 가능합니다 (노동부 고시 기준)</strong></li>
							<li><strong style='color:#F30;'>본인인증은 본인명의 휴대폰 또는 mOTP로 가능합니다.</strong></li>
						</ul>
						<p style='font-size:21px; font-weight:bold; margin-top:40px;'>2. 수료기준 안내</p>
						<ul>
							<li>수료기준은 <strong>진도율 ".$PassProgress."% 이상, 총점 ".$PassScore."점 이상</strong>입니다.</li>
							<li>과정의 종류에 따라 <strong>수료기준은 상이할 수 있으니 수강 시 확인 바랍니다.</li>
							<li><span style='color:#004ea6;'>산업안전보건교육은 수강후 평가가 있습니다. </li>
							<li>평가 항목이나 반영비율은 <strong>과정별 상이 할 수</strong>있습니다.</li>
						</ul>
						<p style='font-size:21px; font-weight:bold; margin-top:40px;'>3. 관리자모드 접속안내</p>
						<ul>
							<li>관리자아이디 : <strong>".$ID."</strong></li>
							<li>
								비밀번호 : <strong>1111</strong><br>
								(로그인하시면 전직원 수강현황 및 아이디 확인과 수료증 발급이 가능합니다.)
							</li>
						</ul>
						<p style='font-size:21px; font-weight:bold; margin-top:40px;'>4. 중간, 최종평가 안내</p>
						<ul>
						<li><strong>중간평가 : 50% 수강 후 응시가능</strong></li>
						<li><strong>최종평가 : 80% 수강 후 응시가능</strong></li>
						<li><strong>과제 : 80% 이상 수강 후 시행가능</strong></li>
						<li>진도율 80% 이상 수강시 시험 응시 가능.</li>
						<li><strong style='color:#F30;'>1일 최대 수강가능 강의는 8차시입니다.</strong></li>
						</ul>
						<p style='font-size:21px; font-weight:bold; margin-top:40px;'>5. 강의 진행시 주의사항</p>
					            <ul>
						<li>
							<strong style='color:#007868;'>시험중 정전 등 사유로 컴퓨터가 꺼지더라도 시험 시작후 ".$TestTime."분 이내면 재로그인 후 재응시 가능합니다.<br>
							(기존 저장한 답은 자동저장)</strong>
						</li>
						<li><strong style='color:#004ea6;'>시험은 시작 후 ".$TestTime."분 경과시 무조건 종료됩니다.</strong></li>
						<li><strong style='color:#F30;'>모든강의는 대리수강 및 대리평가 진행은 허용되지 않습니다.<br>
						위 내용 확인시 미수료처리 될 수 있는 점 유의바랍니다.</strong></li>
					             </ul>
						<p style='font-size:21px; font-weight:bold; margin-top:40px;'>6. 첨부파일 다운로드</p>
						<ul style='line-height:2.4em;'>
							<li><strong><a href='https://www.hrdassetedu.com/upload/교육담당자_매뉴얼.pdf' style='text-decoration:none; color:#000;'>교육담당자 매뉴얼 <span style=' margin-left:5px; background:#059be3; color:#fff; line-height:normal; padding:3px 10px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;'>다운로드</span></a></strong><br><br></li>
							<li><strong><a href='https://www.hrdassetedu.com/upload/학습자_매뉴얼.pdf' style='text-decoration:none; color:#000;'>학습자 매뉴얼 <span style=' margin-left:5px; background:#059be3; color:#fff; line-height:normal; padding:3px 10px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;'>다운로드</span></a></strong><br><br></li>
							<li><strong><a href='https://www.hrdassetedu.com/upload/본인인증_매뉴얼.pdf' style='text-decoration:none; color:#000;'>본인인증 매뉴얼 <span style=' margin-left:5px; background:#059be3; color:#fff; line-height:normal; padding:3px 10px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;'>다운로드</span></a></strong><br><br></li>
							<li><strong><a href='https://www.hrdassetedu.com/mylecture/lecture_download.php?LectureCode=".$LectureCode."' style='text-decoration:none; color:#000;'>[학습자료] ".$ContentsName." <span style=' margin-left:5px; background:#059be3; color:#fff; line-height:normal; padding:3px 10px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;'>다운로드</span></a></strong></li>
						</ul>
					</div>
				</div>";
				
		$Massage2 = addslashes($Massage);
		
		//발송로그
		$maxno = max_number("idx","EmailSendLog");
		//$Sql = "INSERT INTO EmailSendLog(idx, ID, Study_Seq, MassageTitle, Massage, Code, Email, InputID, RegDate) VALUES($maxno, '$ID', $Seq, '$subject', addslashes($Massage), 'N', '$Email', 'cron', NOW())";
		$Sql = "INSERT INTO EmailSendLog(idx, ID, Study_Seq, MassageTitle, Massage, Code, Email, InputID, RegDate) VALUES($maxno, '$ID', $Seq, '$subject', '$Massage2', 'N', '$Email', 'cron', NOW())";
		$Row = mysqli_query($connect, $Sql);

		/* Brad (2021.11.14) : 전송 파라메터 수정
		$fromaddress = $SiteEmail;
		$toaddress = $Email;
		$fromname = $SiteName;

		$subject = iconv("UTF-8","EUC-KR",$subject);
		$body = iconv("UTF-8","EUC-KR",$body);
		$fromname = iconv("UTF-8","EUC-KR",$fromname);

		$send = nmail($fromaddress, $toaddress, $subject, $Message, $fromname);
		*/
		$fromaddress = $SiteEmail;
		$toaddress = $Email;
		$body = $Massage;
		// $body = $Massage."<img src='".$SiteURL."/lib/EmailRecive/email_recive.php?num=".$maxno."' width='0' height='0'>";
		$fromname = $SiteName;

		$subject = iconv("UTF-8","EUC-KR",$subject);
		$body = iconv("UTF-8","EUC-KR",$body);
		$fromname = iconv("UTF-8","EUC-KR",$fromname);

		$send = nmail($fromaddress, $toaddress, $subject, $body, $fromname);

		echo " " . $toaddress . ",";

		$i++;
	}
}

echo "\n" . $i . " class start notification to manager sent.";

mysqli_close($connect);

echo "\n";
