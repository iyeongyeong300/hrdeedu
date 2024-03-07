<?php
//===================================================================================//
// NAME		: helper.lib.php
// MEMO		: 헬퍼함수 모음
// AUTHOR	: DECODE
// EMAIL	: decode@decodelab.co.kr
// Copyright (c) 2012, DECODE Co., Ltd. All rights reserved.
//===================================================================================//






function downloadImage($image_url, $save_name='',$save_path=''){

	$parse_url = parse_url($image_url);
	//파일 이름이 있을 경우
	if($save_name!=''){
		//경로도 있을 경우
		if($save_path!=''){
		
			$path_info=pathinfo($parse_url['path']);

			$image_file = str_replace('[path]',$path_info['dirname'],$save_path).$save_name;
		}
		else{
			$image_file = $save_name;
		}
	}//파일 이름이 없는 경우
	else{
		//경로도 없을 경우
		$parse_url = parse_url($image_url);
		if($save_path==''){
			
			$image_file = $parse_url['path'];
		
		}//경로만 있을 경우
		else{
			$image_file = str_replace('[path]',$parse_url['path'],$save_path);

		}
		
	}
	
	$last_path_info = pathinfo($image_file);


	$path = $last_path_info['dirname'];

	/*
		디렉토리 자동생성
	*/
	$pathCheckTotal = '';
	$pathChecks = explode('/',$path);
	foreach($pathChecks as $key=> $pathCheck){
		if($pathCheck!=''){
			$pathCheckTotal = $pathCheckTotal.'/'.$pathCheck;
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$pathCheckTotal)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$pathCheckTotal,0707);
				
			}
		}
	}
	
	$image_file = str_replace('%','',$image_file);


	if(substr($image_file,0,1)=='/'){
		
		$image_file_path=$_SERVER["DOCUMENT_ROOT"].$image_file;
	}
	else{
		$image_file_path = $image_file;
	}





    $fp = fopen ($image_file_path, 'w+');              // open file handle
    $ch = curl_init($image_url);
   

// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // enable if you want
    curl_setopt($ch, CURLOPT_FILE, $fp);          // output to file
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);      // some large value to allow curl to run for a long time
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_VERBOSE, true);   // Enable this line to see debug prints
    curl_exec($ch);

    curl_close($ch);                              // closing curl handle
    fclose($fp);                                  // closing file handle
	return $image_file;
}






Class Date{
	private $date;
	function __construct($date=''){
		$this->date=new dateTime($date);
		//print_x($date);
	}
	public function set($date){
		$this->date=new dateTime($date);
		return $this;
	}
	public function format($format_string){
		if(strpos($format_string,'kw')!==FALSE){
		
		$week = array("일", "월", "화", "수", "목", "금", "토");
		$result = $week[date("w",strtotime($dateString))];
		$format_string =  str_replace('kw',$result,$format_string);
	}
		return $this->date->format($format_string);
	}
	public function interval($date2){
		$date1=$this->date;
		$date2=new DateTime($date2);
		return objectToArray($date1->diff($date2));
	}
	public function add($date_add_string){
		$prefix = 'P';
		if(strpos($date_add_string,'H')!==FALSE||strpos($date_add_string,'S')!==FALSE||strpos($date_add_string,'M')!==FALSE){
			 $prefix = 'PT';
		}
		
		if(strpos($date_add_string,'-')!==FALSE){
			$this->date->sub(new dateInterval(str_replace('-','',$prefix.strtoupper($date_add_string))));
		}
		else{
			$this->date->add(new dateInterval(str_replace('-','',$prefix.strtoupper($date_add_string))));
		}
		return $this;
		
	}
	public function sub($date_add_string){
		$prefix = 'P';
		if(strpos($date_add_string,'H')!==FALSE||strpos($date_add_string,'S')!==FALSE||strpos($date_add_string,'M')!==FALSE){
			 $prefix = 'PT';
		}
		
		if(strpos($date_add_string,'-')!==FALSE){
			$this->date->add(new dateInterval(str_replace('-','',$prefix.strtoupper($date_add_string))));
		}
		else{
			$this->date->sub(new dateInterval(str_replace('-','',$prefix.strtoupper($date_add_string))));
		}
		return $this;
	}
}



/**
 * 자주 쓰는 CURL 옵션을 사용한다. ex ) [url=>'https://www.naver.com',type=>'post']
 * 사용가능한 옵션  - url,header,type,data,referer,cookie(파일 경로),encoding(utf-8/euc-kr)
 * @param Array CURL 정보를 담을 배열
 * @return String/Array CURL 결과 문자열 또는 문자열을 담은 배열
 */

 Class Curl{
	private $ch;
	private $result;
	private $options;

	function __construct($url){
		$this->ch = curl_init();
		$headers = array();
		$headers[] = 'Connection: keep-alive';
		$headers[] = 'Pragma: no-cache';
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'Upgrade-Insecure-Requests: 1';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
		$headers[] = 'Accept-Language: ko,zh;q=0.9,en;q=0.8,en-US;q=0.7';
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($this->ch, CURLOPT_ENCODING, 'gzip, deflate');
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->ch, CURLOPT_SSLVERSION,1); 		
	}
	/*
	​- CURLINFO_HEADER_OUT​

TRUE로 설정하면 요청하는 헤더 정보를 나중에 curl_getinfo() 함수에서 CURLINFO_HEADER_OUT 옵션으로 읽어올 수 있다. CURLINFO_ 접두어는 의도적으로 다르게 붙인 것이라고 한다. (PHP 5.1.3 버전에서 추가됨) 

 

​​- CURLOPT_SSL_VERIFYPEER​​​

FALSE로 설정하면 원격 서버의 인증서가 유효한지 검사하지 않는다. CURLOPT_CAINFO 옵션으로 대체할 인증서를 지정하거나 CURLOPT_CAPATH 옵션으로 인증서 디렉토리를 지정할 수 있다. 기본값은 TRUE이다. (cURL 7.12.2 버전에서 추가됨) 

 

​​- CURLOPT_SSL_VERIFYHOST​​​

https 접속을 위해 인증서를 꺼주는 기능

​​- CURLOPT_SSLVERSION​​​ : SSL 버젼 (https 접속시에 필요)
	*/
	public function set_url($url){
		curl_setopt($this->ch, CURLOPT_URL, $url);
		return $this;
	}
	public function set_method($method){
		if($method=='post'||$method=='POST'){
			curl_setopt($this->ch, CURLOPT_POST, true);
		}
		else{
			curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method );
			
		}
	}
	public function set_data($data){	
		if(is_array($data)){
			$data=http_build_query($data);
		}
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);    	
	}
	public function set_header($header){
		curl_setopt($this->ch, CURLOPT_HTTPHEADER,$header);
		return $this;
	}
	public function display_header(){
		curl_setopt($this->ch, CURLOPT_HEADER, 1 );
		return $this;
	}

	public function set_cookie($cookie){
		if(substr($cookie,0,1)=='/'){
			$cookie=$_SERVER["DOCUMENT_ROOT"].$cookie;
		}
		curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookie);
		return $this;
	}
	public function set_referer($referer){
		curl_setopt($this->ch, CURLOPT_REFERER, $referer);
		return $this;
	}
	public function convert_encoding($encoding){
		$this->encoding = $encoding;
		return $this;
	}
	public function result(){
		$this->result=curl_exec($this->ch);

		if(strtolower($this->encoding)=='utf-8'){
			$this->result = iconv('EUC-KR','UTF-8//IGNORE',$this->result);
		}
		if(strtolower($this->encoding)=='euc-kr'){
			$this->result = iconv('UTF-8','EUC-KR//IGNORE',$this->result);
		}
	

		return $this->result;
	}
	public function close(){
		curl_close($this->ch);
	}


 }



function curl($curls){
	$ch = curl_init();
	$results = [];
	if($curls[0]==''){
		$curls=[$curls];
	}
	foreach ($curls as $curl ) {
		
		$options=$curl;

		curl_setopt($ch, CURLOPT_URL, $options['url']);
		if(strtolower($options['type'])=='post'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);    
			
		}


		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSLVERSION,4); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'User-Agent: Mozilla/5.0'

		));

		if($options['cookie']){
			curl_setopt($ch, CURLOPT_COOKIEJAR, $options['cookie']);
			curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie']);
		}
		if($options['referer']){
			curl_setopt($ch, CURLOPT_REFERER, $options['referer']);
		}
		if($options['header']){
			curl_setopt($ch, CURLOPT_HTTPHEADER,$options['header']);
		}
		$result=curl_exec($ch);
		if(strtolower($options['encoding'])=='utf-8'){
			$result = iconv('EUC-KR','UTF-8//IGNORE',$result);
		}
		if(strtolower($options['encoding'])=='euc-kr'){
			$result = iconv('UTF-8','EUC-KR//IGNORE',$result);
		}
		array_push($results,$result);
	}
	if(count($results)==1){
		$results=$results[0];
	}
	return $results;
}


/**
 * 파라미터 값에 따라 insert와 update를 분기하여 처리한다.
 * @param String $table_name 테이블명
 * @param Array $param 컬럼으로 집어넣을 데이터를 정의한다. key가 필드명, value가 해당 필드에 입력할 데이터
 * @param String $where 검색 조건
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return mixed 쿼리 결과
 */
function insertOrUpdate($table, &$param, $where, $db=null, $viewQuery=false){
	if($param['no']){
		return updateItem($table, $param, $where, $db, $viewQuery);
	}	
	else{
		return insertItem($table, $param, $db, $viewQuery);
	}
}


/**
 * 객체를 배열로 전환한다.
 * @param object $data PHP 객체
 * @return array 전환된 배열
 */

function objectToArray($data)
	{
		if (is_array($data) || is_object($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = objectToArray($value);
			}
			return $result;
		}
		return $data;
	}

/**
 * 두 날짜의 차이를 구한다.
 * @param String $date1 비교할 날짜 문자열1
 * @param String $date2 비교할 날짜 문자열2
 * @return array 연,월,일,시,분,초, 날짜 수를 담은 배열
 */
function dateInterval($date1='',$date2=''){
	$date1=new DateTime($date1);
	$date2=new DateTime($date2);
	return objectToArray($date1->diff($date2));
}


/**
 * 자주쓰는 날짜 형식을 채용한다.
 * 
 * @param String $dateString 날짜 형식의 문자열
 * @param String $format 출력할 날짜 포맷
 * @param String $interval 출력할 날짜에서 더하거나 뺄 날짜 
 * @return String 가공된 날짜 형식
 */

function dateFormat($dateString='',$format='',$interval=null){
	/*
		3S,3M,3H,3D,3M,3Y  등으로 입력

	*/
	$date = new dateTime($dateString);
	if(!$format){
		$format = 'Y-m-d';
	}

	
	
	if($interval){
		$prefix = 'P';
		if(strpos($interval,'H')!==FALSE||strpos($interval,'S')!==FALSE||strpos($interval,'M')!==FALSE){
			 $prefix = 'PT';
		}	
		$dateInterval = new dateInterval(str_replace('-','',$prefix.strtoupper($interval)));
		if(strpos($interval,'-')!==FALSE){
			$date->sub($dateInterval);
		}
		else{
			$date->add($dateInterval);
		}
	}

	if(strpos($format,'kw')!==FALSE){
		
		$week = array("일", "월", "화", "수", "목", "금", "토");
		$result = $week[date("w",strtotime($dateString))];
		$format =  str_replace('kw',$result,$format);
	}


	return $date->format($format);;
}



/**
 * 문자열에서 숫자만 남기고 제거한다.
 * @param string $number 숫자를 포함한 문자열
 * @return int 제거된 순수한 숫자
 */
function number_unformat($number) {
  return Intval(filter_var($number, FILTER_SANITIZE_NUMBER_INT));
}

/**
 * 데이터의 유효성을 검사한다.
 * @param array $target_array 데이터가 담긴 대상 배열
 * @param array $target_info_array 검증할 데이터 정보 


$target_info_array Sample 

array (
	'name'=>'empty,name|이름',
	'email'=>'email,empty|이메일',
	'website'=>'url,empty|사이트 주소'
	'phone'=>'phone,empty|휴대폰 번호',
	'amount'=>'number,empty|수량'
	'id'=>'id,empty|아이디'
)


 */


function validateData($target_array,$target_info_array,$url=''){
	if(is_empty_array($target_array)){
		return false;
	}
	foreach($target_array as $target_name=>$target_value){
		if(array_key_exists($target_name,$target_info_array)){

			//echo $target_name.'의 경우 값은 '.$target_value.', type은'.$target_info_array[$target_name];
			br();
			if($target_value==''&&indexOf($target_info_array[$target_name],'empty')!=-1){
				$target_info_array[$target_name]=explode('|',$target_info_array[$target_name]);
				$postposition='를';
				if(has_batchim($target_info_array[$target_name][1])){
					$postposition='을';
				}
				$message =  $target_info_array[$target_name][1].$postposition.' 입력해주세요.';
				echo $message;
				printMessage($message);
				exit;
				
			}

			if(!filter_var($target_value, FILTER_VALIDATE_EMAIL)&&indexOf($target_info_array[$target_name],'email')!=-1){
				$target_info_array[$target_name]=explode('|',$target_info_array[$target_name]);
			
				$message =  '올바른 이메일을 입력해주세요.';
				printMessage($message);
				echo $message;
				exit;
				
			}
			if(!filter_var($target_value, FILTER_VALIDATE_IP)&&indexOf($target_info_array[$target_name],'ip')!=-1){
				$message =  '올바른 아이피를 입력해주세요.';
				printMessage($message);
				exit;
				
			}
			if(!filter_var($target_value, FILTER_VALIDATE_URL)&&indexOf($target_info_array[$target_name],'url')!=-1){
				$message =  '올바른 URL을 입력해주세요.';
				printMessage($message);
				exit;
				
			}
			if(!is_numeric($target_value)&&indexOf($target_info_array[$target_name],'number')!=-1){
				$target_info_array[$target_name]=explode('|',$target_info_array[$target_name]);
				$postposition='는';
				if(has_batchim($target_info_array[$target_name][1])){
					$postposition='은';
				}
				
				$message =  $target_info_array[$target_name][1].$postposition.' 숫자 형식이어야 합니다';
				printMessage($message);
				echo $message;
				exit;
				
			}
			if(!preg_match("/^[a-zA-Z가-힣 ]*$/", $target_value)&&indexOf($target_info_array[$target_name],'name')!=-1){
				$target_info_array[$target_name]=explode('|',$target_info_array[$target_name]);
				$postposition='는';
				if(has_batchim($target_info_array[$target_name][1])){
					$postposition='은';
				}
				$message =  $target_info_array[$target_name][1].$postposition.' 영문과 한글로만 형식이어야 합니다';
				printMessage($message);
				exit;
				
			}
			if(!preg_match("/^01[0-9]{8,9}$/", str_replace('-','',$target_value))&&indexOf($target_info_array[$target_name],'phone')!=-1){
				$target_info_array[$target_name]=explode('|',$target_info_array[$target_name]);
				$postposition='는';
				if(has_batchim($target_info_array[$target_name][1])){
					$postposition='은';
				}
				$message = $target_info_array[$target_name][1].$postposition.' 핸드폰번호 형식이어야 합니다';
				printMessage($message);
				exit;
				
			}
			if(indexOf($target_info_array[$target_name],'id')!=-1){
				
				if(!preg_match("/^[a-z]/i", $target_value)) {
					$message = "아이디의 첫글자는 영문이어야 합니다.";
					printMessage($message);
					exit;
				}
				if(preg_match("/[^a-z0-9-_]/i", $target_value)) {
					$message = "아이디는 영문, 숫자, -, _ 만 사용할 수 있습니다.";
					printMessage($message);
					exit;
				}
			}
		}

	}
}

// License: Public Domain
//
// 마지막 글자에 받침이 있으면 0보다 큰 정수를 반환하고
// 받침이 없으면 0을 반환한다.
//
// 예:
// $word = '깃허브';
// echo $word . (has_batchim($word) ? '을' : '를');

function has_batchim($str, $charset = 'UTF-8') {
    $str = mb_convert_encoding($str, 'UTF-16BE', $charset);
    $str = str_split(substr($str, strlen($str) - 2));
    $code_point = (ord($str[0]) * 256) + ord($str[1]);
    if ($code_point < 44032 || $code_point > 55203) return 0;
    return ($code_point - 44032) % 28;
}


/*
	Make Condition
	@value [STRING]: 비교 할 원본 값
	@strings [STRING]: 비교 할 문자열
	@type [STRING] : 타입
*/

function makeCondition($value,$strings,$type='OR'){
	$strings = explode('|',$strings);
	if($type='OR'){
		$result= false;
		foreach($strings as $string){
			if($value==$string){
				$result= true;
			
			}

		}
	
	}
	if($type=='AND'){
		$result= true;
		foreach($strings as $string){
			if($value!=$string){
				$result= false;
			}
		}
	}
	return $result;
}
/*
	saveToLibrary
	@name [STRING]: DB에 저장할 파일이름
	@path [STRING]: DB에 저장할 파일 경로
	@type [STRING]: DB에 저장할 파일 유형
*/

function deleteInLibrary($no){
	 $file=getItem('files',$no);
	 unlink($_SERVER['DOCUMENT_ROOT'].$file['path']);
	 deleteItem('files',$no);
}
function saveToLibrary($name,$path='',$type='',$location='',$contents_no=''){

	if(is_array($name)){
			
		$path =$name['path'];		
		$type =$name['type'];		
		$location =$name['location'];		
		$contents_no =$name['contents_no'];	
		$name =$name['name'];	
	
	}

	$fileParam['name'] = $name;
	$fileParam['path'] = $path;
	$fileParam['type'] = $type;
	$fileParam['location'] = $location;
	$fileParam['contents_no'] = $contents_no;
	return insertItem('files',$fileParam);
}
/*
	form
	@type [STRING]: 폼 생성할 유형[text,radio,select,checkbox,editor,textarea]
 	@name [STRING]: 폼 한글명
	@fieldName [STRING]: 폼 필드명
	@value [STRING]: 폼 값
	@options [STRING]:옵션 필요 유무
*/
function form($type,$name,$fieldName,$value,$options=false){
	switch($type){
		case 'text' : 
		echo '<tr>
				<th>'.$name.'</th>
				<td>
					
					<input type="text" name="'.$fieldName.'" value="'.$value.'" '.$options['attr'].'>
				
				</td>
			</tr>';
		break;
		case 'select' : 
			$optionTemplate = '<option value="">'.$name.' 선택</option>';
			foreach($options['options'] as $option){
				$option = explode('|',$option);
				if($option[1]==$value){
					$selected='selected';
				}
				else{
					$selected = '';
				}
				$optionTemplate.='<option value="'.$option[1].'" '.$selected.'>'.$option[0].'</option>';
			}	
			echo '<tr>
					<th>'.$name.'</th>
					<td>
						<select name="'.$fieldName.'"  '.$options['attr'].'>
						'.$optionTemplate.'
						</select>
					</td>
				</div>';

		break;
		case 'radio' : 
			$optionTemplate ='';
			foreach($options['options'] as $option){
				$option = explode('|',$option);
				if($option[1]==$value){
					$checked='checked';
				}
				else{
					$checked = '';
				}
				$optionTemplate.='<label style="margin-right:15px;"><input type="radio" name="'.$fieldName.'"  value="'.$option[1].'" '.$checked.'> '.$option[0].'</label>';
			}	
			echo '<tr>
					<th>'.$name.'</th>
					<td>
						'.$optionTemplate.'
					</td>
				</tr>';

		break;
		case 'checkbox' : 
			$optionTemplate ='';
			foreach($options['options'] as $option){
				$option = explode('|',$option);
				
			
				if(indexOf(','.$value.',',$option[1].',')!=-1){
					$checked='checked';
				}
				else{
					$checked = '';
				}
				$optionTemplate.='<label style="margin-right:15px;"><input type="checkbox" name="'.$fieldName.'"  value="'.$option[1].'" '.$checked.'> '.$option[0].'</label>';
			}	
			echo '<tr>
					<th>'.$name.'</th>
					<td>
						'.$optionTemplate.'
					</td>
				</tr>';

		break;
		case 'textarea' : 
		
			echo '<tr >
					<th>'.$name.'</th>
					<td>
						<textarea name="'.$fieldName.'"  '.$options['attr'].'>'.$value.'</textarea>
					</td>
				</div>';

		break;
		case 'editor' : 
		
			echo '<tr >
					<th>'.$name.'</th>
					<td>
						<textarea name="'.$fieldName.'"  class="ckeditor" >'.$value.'</textarea>
					</td>
				</tr>';

		break;
	}
}
/*
	jS indexof
*/
function indexOf($string,$find){
	if(strpos($string,$find)!==FALSE){
		return strpos($string,$find);
	}
	else{
		return -1;
	}
}
/*
	Simple Upload
	@file [STRING]: PHP 파일 변수의 키 값
	@path [STRING]: 업로드 할 경로
	@container : 변수 담을 전역변수
*/



function simpleUpload($file,$path,&$container,&$container_name=null){
	if($_FILES[$file]['name']!=''){
		$uploaded =  uploadFile($_FILES[$file],$path,'','',$debug);
		$container = $uploaded['path'];
		$container_name = $uploaded['name'];

	}
	else{

		$container = null;
		$container_name = null;

	}
}

function destroySession($sessions){	
	GLOBAL $session;
	$sessions = explode(',',$sessions);
	foreach($sessions as $sessionName){
		unset($session[$sessionName]);

	}
}
/*
	2016.06.03 Updated.
	플러그인을 불러옴.
*/
function loadPlugin($name){
	GLOBAL $param;
	GLOBAL $melon;
	GLOBAL $session;
	$pluginPath = 'plugins/'.$name;
	include'plugins/'.$name.'/index.php';
}
function alignArray ( $arr,$index) {
	$len = count($arr);

	$arrayAligned = array();
	for  ($bora=0;$bora<$len;$bora++ ){
	
		if(!$arr[$bora][$index]){
			continue;
		}
		if($arrayAligned[$arr[$bora][$index][0]]){
			array_push($arrayAligned[$arr[$bora][$index]],$arr[$bora]);
		
		}
		else{
		
			if($arrayAligned[$arr[$bora][$index]]){
				
				$arrayAligned[$arr[$bora][$index]] = array($arrayAligned[$arr[$bora][$index]],$arr[$bora]);
			}
			else{

				$arrayAligned[$arr[$bora][$index]] = $arr[$bora];
			}
		}

	}
	return $arrayAligned;

}
function caseDisplay($caseArray,$result){
	echo $caseArray[$result];
}
function br(){
	echo '<br>';
}
/*
$data = pageList('board_gallery','',2,10,$param['page'],array('first'=>'<a href="/page/$page">&lt;&lt;</a>','prev'=>'<a href="/page/$page">&lt;</a>','number'=>'<a href="/page/$page">$page</a>','next'=>'<a href="/page/$page">&gt;</a>','last'=>'<a href="/page/$page">&gt;&gt;</a>'));
*/
function pageList($table,$where='',$order='',$itemNumber=10,$pageNumber=10,$currentPage='',$pagingTags='?page=[page]',$group=null, $db=null, $viewQuery=false){
	
	GLOBAL $melon;
	GLOBAL $param;

	if(is_array($table)){
		$where =$table['where'];		
		$order =$table['order'];		
		$itemNumber =$table['item_number'];		
		$pageNumber =$table['page_number'];		
		$currentPage =$table['current_page'];		
		$pagingTags =$table['paging_tags'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}
	if($where==''){
		$where='';
	}
	if($order==''){
		$order='';
	}
	if($itemNumber==''){
		$itemNumber=10;
	}
	if($pageNumber==''){
		$pageNumber=10;
	}
	if($currentPage==''){
		$currentPage='';
	}
	if($pagingTags==''){
		$pagingTags='?page=[page]';
	}


	if(!$currentPage){
		if($param['page']==''){
			$currentPage = 1;
		}
		else{
			$currentPage=$param['page'];
		}
	}

	$data=getList($table,$where,$itemNumber*($currentPage-1),$itemNumber,$order,$field,$group,$db,$viewQuery);
	
	$data['item_total']=getTotal($table,$where);
	$data['pageInfo'] = getPageInfo($data['item_total'],$itemNumber,$pageNumber,$currentPage);
	if(is_string($pagingTags)){
		$pagingTags = str_replace('[url]',$pagingTags,$melon['helper']['pagination']);
	}
	$pageInfo = $data['pageInfo'];
	$data['pagination'] = '';
	if($pagingTags['first']&&$pageInfo['isFirst']){
		$data['pagination'].=str_replace('[page]',$pageInfo['firstPage'],$pagingTags['first']);
	}
	if($pagingTags['prev']&&$pageInfo['isPrev']){
		$data['pagination'].=str_replace('[page]',$pageInfo['prevPage'],$pagingTags['prev']);
	}
	for($iu=$pageInfo['initPage'];$iu<=$pageInfo['finalPage'];$iu++){
		if($currentPage==$iu){
			$data['pagination'].=str_replace('[page]',$iu,$pagingTags['current']);
		}
		else{
			
			$data['pagination'].=str_replace('[page]',$iu,$pagingTags['number']);
		}
	}
	if($pagingTags['next']&&$pageInfo['isNext']){
		$data['pagination'].=str_replace('[page]',$pageInfo['nextPage'],$pagingTags['next']);
	}
	if($pagingTags['last']&&$pageInfo['isLast']){
		$data['pagination'].=str_replace('[page]',$pageInfo['lastPage'],$pagingTags['last']);
	}
	return $data;
}
function pageListJoin($table,$joins,$field,$where='',$order='',$itemNumber=10,$pageNumber=10,$currentPage='',$pagingTags='?page=[page]',$group=null, $db=null, $viewQuery=false){
	GLOBAL $melon;

	if(is_array($table)){
		$where =$table['where'];		
		$joins =$table['join'];		
		$order =$table['order'];		
		$itemNumber =$table['item_number'];		
		$pageNumber =$table['page_number'];		
		$currentPage =$table['current_page'];		
		$pagingTags =$table['paging_tags'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}

	if($where==''){
		$where='';
	}
	if($order==''){
		$order='';
	}
	if($itemNumber==''){
		$itemNumber=10;
	}
	if($pageNumber==''){
		$pageNumber=10;
	}
	if($currentPage==''){
		$currentPage=1;
	}
	if($pagingTags==''){
		$pagingTags='?page=[page]';
	}

	if(!$currentPage){
		if($param['page']==''){
			$currentPage = 1;
		}
		else{
			$currentPage=$param['page'];
		}
	}
	$data=getListJoin($table,$joins,$field,$where,$itemNumber*($currentPage-1),$itemNumber,$order,$group,$db,$viewQuery);


	/*
	 * 2021-10-21 14:20
	 * 수정버전 item_total
	 * 수정자 : 이원석
	 */
    $group_list=getListJoin($table,$joins,$field,$where,'','',$order,$group);

    $data['item_total']=$group_list['length'];

    /*
     * 2021-10-21 14:20
     * 이전버전 item_total
     */
	/*$data['item_total']=getTotal($table,$where,$joins,$group);*/
	$data['pageInfo'] = getPageInfo($data['item_total'],$itemNumber,$pageNumber,$currentPage);
	if(is_string($pagingTags)){
		$pagingTags = str_replace('[url]',$pagingTags,$melon['helper']['pagination']);
	}
	$pageInfo = $data['pageInfo'];
	$data['pagination'] = '';
	
	if($pagingTags['first']&&$pageInfo['isFirst']){

		$data['pagination'].=str_replace('[page]',$pageInfo['firstPage'],$pagingTags['first']);
	}
	if($pagingTags['prev']&&$pageInfo['isPrev']){
		$data['pagination'].=str_replace('[page]',$pageInfo['prevPage'],$pagingTags['prev']);
	}
	if($pagingTags['tag_start']){
		$data['pagination'].= $pagingTags['tag_start'];
	}
	for($iu=$pageInfo['initPage'];$iu<=$pageInfo['finalPage'];$iu++){
		if($currentPage==$iu){
			$data['pagination'].=str_replace('[page]',$iu,$pagingTags['current']);
		}
		else{
			
			$data['pagination'].=str_replace('[page]',$iu,$pagingTags['number']);
		}
	}
	if($pagingTags['tag_end']){
		$data['pagination'].=  $pagingTags['tag_end'];
	}
	if($pagingTags['next']&&$pageInfo['isNext']){
		$data['pagination'].=str_replace('[page]',$pageInfo['nextPage'],$pagingTags['next']);
	}
	if($pagingTags['last']&&$pageInfo['isLast']){
		$data['pagination'].=str_replace('[page]',$pageInfo['lastPage'],$pagingTags['last']);
	}
	return $data;
}
function generateCode($length,$options=''){  
	$characters  = "0123456789";  
	$characters .= "abcdefghijklmnopqrstuvwxyz";  
	//$characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
	if($options!=''){
		$characters='';
		if(strpos($options,'shorthand')!==false){
			if(strpos($options,'number')!==false){
				$characters.='0123456789';
			}
			if(strpos($options,'lowercase')!==false){
				$characters.='abcdefghijklmnopqrstuvwxyz';
			}
			if(strpos($options,'uppercase')!==false){
				$characters.='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			}
			if(strpos($options,'special')!==false){
				$characters.='!@#$%^&*()';
			}
		}
		else{
			$characters = $options;
		}
	}

	  
	$string_generated = "";  
	$nmr_loops = $length;  
	$characterLen = strlen($characters);
	while ($nmr_loops--)  
	{  
		$string_generated .= $characters[mt_rand(0, $characterLen-1)];  
	}  
	  
	return $string_generated;  
} 

function getDateInfo($year='',$month='',$date=''){
	$dateInfo = array();


	if($year){
		$dateInfo['year']=$year;
	}
	else{
		$dateInfo['year']=date('Y');
	}
	if($month){
		$dateInfo['month']=$month;
	}
	else{
		$dateInfo['month']=date('m');
	}
	if($date){
		$date=$date;
	}
	else{
		$date=date('d');
	}
	$dateInfo['date'] = $date;
	$dateInfo['today'] = $dateInfo['year'].'-'.$dateInfo['month'].'-'.$date;
	$prevDateTime=mktime(0, 0, 0, $dateInfo['month']-1, 1, $dateInfo['year']); //이전월 객체
	$dateInfo['prevYear']=date('Y',$prevDateTime);
	$dateInfo['prevMonth']=date('m',$prevDateTime);
	$nextDateTime=mktime(0, 0, 0, $dateInfo['month']+1, 1, $dateInfo['year']); //다음월 객체
	$dateInfo['nextYear']=date('Y',$nextDateTime);
	$dateInfo['nextMonth']=date('m',$nextDateTime);
	$firstDateTime=mktime(0, 0, 0, $dateInfo['month'], 1, $dateInfo['year']);//현재월 객체
	$dateInfo['firstDate']= date("w", $firstDateTime);
	$dateInfo['lastDate']=date('t',$firstDateTime);
	$dateInfo['validDate']=$dateInfo['lastDate']+$dateInfo['firstDate'];//유효한 총 일수
	$dateInfo['emptyLength'] = (7-($dateInfo['validDate'])%7)%7;
	return $dateInfo;
}
/*
(
    [year] => 2014
    [month] => 03
    [prevYear] => 2014
    [prevMonth] => 02
    [nextYear] => 2014
    [nextMonth] => 04
    [firstDate] => 6
    [lastDate] => 31
    [validDate] => 37
    [emptyLength] => 5
)
$dateInfo = extract (getDateInfo($param) );
		<div id="buttons">
		<a href="?year=<?=$prevYear?>&month=<?=$prevMonth?>" id="prev_button">이전 달</a>
<a href="?year=<?=$nextYear?>&month=<?=$nextMonth?>" id="next_button">다음 달</a>
		</div>
		
<table id="calendar" >
	<caption>
		<?=$year?>년 <?=$month?>월
	</caption>
	<tr>
		<th>일</th>
		<th>월</th>
		<th>화</th>
		<th>수</th>
		<th>목</th>
		<th>금</th>
		<th>토</th>
	</tr>
	<tr>
		<?php
			
	
			$block1='';
			for($iu=0;$iu<$firstDate;$iu++){
				$block1='<td></td>'.$block1;
			}
			$block2='';
			for($iu=0;$iu<$emptyLength;$iu++){
				$block2='<td></td>'.$block2;
			}
			echo $block1;
			for($iu=$firstDate;$iu<$validDate;$iu++){	
				$currentDate = $iu+1-$firstDate;

		?>
			<td  <?=attr($currentDate==$date,'class="today"')?><?=attr($iu%7==0,'class="sunday"')?> <?=attr($iu%7==6,'class="saturday"')?>><?=$currentDate?></td>
		<?php	
			if($iu%7==6){
				echo '</tr><tr>';
			}
		
		}
		echo $block2; //마지막 빈블럭 출력
		?>
	</tr>
</table>
<style type="text/css">
	table th,td{
		border:1px solid black;
	}
	.sunday{
		color:red;
	}
	.saturday{
		color:blue;
	}
	.today{
		background:red;
	}
	#calendar th{
		height:40px;
	}
		#calendar caption{
			line-height:69px;
			font-size:22px;
		}
	#calendar{
		width:100%;
	}
	#calendar td{
		height:100px;
		font-size:17px;
	}
	#prev_button{
		font-size:20px;
		float:left;
	}
	#next_button{
		font-size:20px;
		float:right;
	}

</style>
*/
function progressiveDate($startDate,$endDate,$currentDate=null){
   if(!$currentDate){
      $currentDate=date('Y-m-d');
   }
   if(gettype($startDate)=='integer'){
      $startDate=date('Y-m-d',$startDate);
   }
   if(gettype($endDate)=='integer'){
      $endDate=date('Y-m-d',$endDate);
   }
   if($startDate>$currentDate){ //시작일보다 현재일이 작을경우
      return 0;//진행전
   }
   if($endDate>$currentDate&&$startDate<$currentDate){ //시작일보단 크지만 완료일보다 작을경우
      return 1; //진행중
   }
   if($endDate<$currentDate){ //현재일이 끝일보다 클경우
      return 2;//진행완료
   }
   
}
/**
 * 
 * 파일이 있을 경우 스크립트 파일을 로드함.
 */
function loadScript($path){
	if(is_file($_SERVER['DOCUMENT_ROOT'].$path)){
		echo '<script type="text/javascript" src="'.$path.'"></script>';
	}
}
/**
 * 
 * 파일이 있을 경우 스타일 파일을 로드함.
 */
function loadStyle($path){
	if(is_file($_SERVER['DOCUMENT_ROOT'].$path)){
		echo '<link rel="stylesheet" href="'.$path.'">';
	}
}




/**
 * 
 * 자주쓰는 날짜형식을 차용함.

function dateFormat($dateString,$dateFormat=null){
   if(!$dateFormat){
      $dateString = substr($dateString,0,11);
   }
   else{
	   if(strpos($dateFormat,'kw')!==FALSE){

		  $week = array("일", "월", "화", "수", "목", "금", "토");
		  $result = $week[date("w",strtotime($dateString))];
			
		 $dateFormat =  str_replace('kw',$result,$dateFormat);
	   }
      $dateString = date($dateFormat,strtotime($dateString));
   }
   return $dateString;
}
 */
function benchmark($inittime=null,$endtime=null){
	GLOBAL $melon;
	if($inittime!=null && $endtime!=null){
		return getDifferenceMicrotime($inittime,$endtime);
	}else if($inittime!=null){
		$melon["benchmarktime"] = microtime();
		return getDifferenceMicrotime($inittime,$melon["benchmarktime"]);
	}else if(isset($melon["benchmarktime"])){
		$inittime = $melon["benchmarktime"];
		$melon["benchmarktime"] = microtime();
		return getDifferenceMicrotime($inittime,$melon["benchmarktime"]);
	}else{
		$melon["benchmarktime"] = microtime();
		return 0;
	}
}
/**
 * 입력한 시간 차이를 구합니다.
 * @param number $_start microtime()로 측정한 시작시간
 * @param number $_end microtime()로 측정한 끝시간
 * @return number 시간 차이를 계산해 반환합니다.
 */
function getDifferenceMicrotime($_start, $_end)
{
  $end = explode(' ', $_end);
  $start = explode(' ', $_start);

  return sprintf('%.4f', ($end[1]+$end[0])-($start[1]+$start[0]));
}


/**
 * 파일을 지정한 이름으로 다운로드하도록 강제합니다.
 * @param string $path 파일을 불러올 경로입니다.
 * @param string $name 강제로 다운로드하도록 지정할 이름입니다. 
 */

 function forceDownload($path,$name){
	if(substr($path,0,1)=='/'){
		$path=$_SERVER["DOCUMENT_ROOT"].$path;
	}
	$filesize = filesize($path);
	$filename = end(explode('/',$path));

	if(!isset($_SERVER['HTTP_USER_AGENT'])){
		$name = iconv("UTF-8","cp949//IGNORE", $name);
	}
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false){
		$name = iconv("UTF-8","cp949//IGNORE", $name);
	}
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false){
		$name = iconv("UTF-8","cp949//IGNORE", $name);
	}

	header("Pragma: public");
	header("Expires: 0");
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"$name\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: $filesize");
	readfile($path);
}
/*
function forceDownload($path,$name=null){
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',getBaseName($name)).";");
	if(substr($path,0,1)=='/'){
		$path=$_SERVER["DOCUMENT_ROOT"].$path;
	}
	readfile($path);
	flush();
}*/
/**
 * 운영체제가 윈도우일 경우 경로를 적절히 바꿔준다.
 * @param string $path 원래의 경로
 * @return string 변환된 경로
 */
function getBasename($path) { 
	$pattern = (strncasecmp(PHP_OS, 'WIN', 3) ? '/([^\/]+)[\/]*$/' : '/([^\/\\\\]+)[\/\\\\]*$/'); 
	if (preg_match($pattern, $path, $matches)){
		return $matches[1];
	} 
	return ''; 
}
/**
 * 문단의 요약을 구한다.
 * @param string 문단 문자열.
 * @param int 요약문의 글자 바이트수.
 * @param string 요약문 문미에 붙을 추임새.
 * @return string 요약된 문단
 */
function getSummary($text, $len,$suffix="…",$newLine=true){
	$text = strip_tags(htmlspecialchars_decode($text));// htmlspecialchars_decode(strip_tags($text));
	if($newLine){
		preg_replace('/\r\n|\r|\n/','',$text); //개행제거
	}
	if(strlen($text)<=$len) {
		return $text;
	} else {
		$text = mb_strcut($text, 0, $len, 'utf-8');
		return $text.$suffix;
	}
}

/**
 * 문자열 날짜를 이용해서 상대시간을 구한다.
 * @param string 날짜 형식의 문자열
 * @param string 상대시간이 20초 이하의 시간일 때 출력 될 문자열
 * @return string 계산된 상대시간
 */
function getRelativeDate($date,$current="지금 막") {
 $dtDiff = time() - strtotime($date);
 if($dtDiff < 20) $rs =$current;
 else if($dtDiff < 60) $rs = intval($dtDiff) . "초전";
 else if($dtDiff < 60*60) $rs = intval($dtDiff / (60)) . "분전";
 else if($dtDiff < 60*60*24) $rs = intval($dtDiff / (60*60)) . "시간전";
 else if($dtDiff < 60*60*24*7) $rs = intval($dtDiff / (60*60*24)) . "일전";
 else if($dtDiff < 60*60*24*30) $rs = intval($dtDiff / (60*60*24*7)) . "주전";
 else if($dtDiff < 60*60*24*365) $rs = intval($dtDiff / (60*60*24*30)) . "달전";
 else $rs = intval($dtDiff / (60*60*24*365)) . "년전";
 return $rs;
}
/**
 * 자바스크립트 변수를 출력한다.
 * @param string 출력 할 자바스크립트 변수명 / array 출력 할 자바스크립트 변수의 키, 값 쌍
 * @param string 출력 할 자바스크립트 변수 값
 */
function printJsVariable($key,$value=null){
	echo "<script>";
	$variable="";
	if(is_array($key)){
		foreach($key as $name=>$value){
			$variable.="var $name='$value';";
		}
	}
	else{
		$variable.="var $key='$value';";
	}
	echo "$variable</script>";
}
/**
 * 변수를 멜론 콘솔에 출력한다.
 * @param * 출력 할 변수.
 * @param boolean 함수 실행 만으로 출력 할지 아닐지 여부. false 일 경우 단축키 t를 이용해서 출력. 
 */
function console($data,$data2=null,$data3=null,$data4=null){
	$a=print_r($data,true);
	$b=print_r($data2,true);
	$c=print_r($data3,true);
	$d=print_r($data4,true);
	
		$display="block";

	echo "<meta charset='utf-8'><pre id='melon_trace' style='z-index:5001;border-top:5px solid pink;border-bottom:5px solid pink;font-family:malgun gothic;display:$display;padding-left:5px;position:fixed;top:0;left:0;background:white;width:100%;height:100%;overflow-y:scroll'><h3 style='border:1px solid black;padding:2px 5px;margin-left:5px;float:left;'>MELON CONSOLE</h3><div style='clear:both'></div>$a$b$c$d</pre><script src='http://code.jquery.com/jquery-1.8.3.min.js'></script><script>$('#melon_trace').appendTo('body');$(document).keydown(function(e){if(e.keyCode==84){\$('#melon_trace').fadeToggle();}});</script>";
}
/**
 * 조건에 부합 할 시 HTML 속성을 출력한다.
 * @param boolean 출력 하고자 하는 조건.
 * @param string 속성의 이름. 기본값은 "selected".
 * @param string 속성의 값.
 */
function attr($condition,$attr="selected",$attrOpponent=''){
	if($condition){
		return $attr;
	}
	else{
		return $attrOpponent;
	}
}
/**
 * 배열의 내용을 <xmp>태그를 이용하여 출력
 *
 * @param array print_array						출력 배열
 */
function print_x($print_array) {
	echo('<xmp>');
	print_r($print_array);
	echo('</xmp>');
}
/**
 * 입력된 배열 
 *
 * @param array check_array					implode를 체크할 함수
 * @return boolean							가능/불가능 반환값
 */
function is_empty_array($array) {

	if (is_array($array) === TRUE && count($array) > 0) {
		return FALSE;
	}

	return TRUE;

}


/**
 * 페이지를 이동시킨다.
 * @param string 이동 할 URL. 입력 하지 않을 시 브라우저의 history 이용하여 이전 페이지로 이동.
 */

function getBack($url="")
{
	$result = "<meta charset=\"utf-8\"><script type=\"text/javascript\">";
	if($url=="")
	{
		$result .= "history.back(-1);";
	}
	else
	{
		$result .= "location.replace('".$url."');";
	}
	$result .= "</script>";
	echo $result;
	exit;
}
/**
 * 변수가 비어있을 경우 채운다. 
 * @param * 변수명
 * @param * 비어있을 경우 채울 값. 기본 값은 1.
 */
function fillEmptyParam(&$value,$revised=1){
	if(empty($value)){
		$value=$revised;
	}
	return $value;
}
/**
 * 변수가 비어있을 경우 페이지를 이동시킨다.
 * @param * 변수명
 * @param * 이동시킬 페이지
 */
function emptyParam($value,$url="",$message="잘못된 접근입니다."){
	if(empty($value)){
		printMessage($message,$url);
		exit;
	}
}	
/**
 * 키, 값 쌍을 받아서 키를 값으로 전환한다.
 * @param * 변수명.
 * @param array 키에 대응되는 키, 값 쌍 배열.
 */
function stringFilter(&$item,$arr){
	$item=$arr[$item];
	return $item;
}
/**
 * 경로, 조건 문자열을 키 값 쌍에 알맞게 만든다.
 * @param String 경로 변수.
 * @param String 조건문 변수.
 * @param String 추가 할 key 값.
 * @param String 추가 할 value 값.
 * @param String 조건문에 사용 될 %의 위치. front, both, back,equal 중 하나 입력. 기본 값은 both.
 * @param String 추가 될 조건문의 성질. 이전에 작성 된 조건문과의 관계를 묻는다. AND, OR.
 * @param Boolean 앞에 붙을 문자를 강제로 &로
 * @param String 조건문 문자열 맨 앞에 추가 될 문자열. 괄호 등을 추가할수 있다.
 * @param String 조건문 문자열 맨 끝에 추가 될 문자열. 괄호 등을 추가할수 있다.
 * 사용 예)  
 * $where = ""
 * $path = "";
 * addCondition($where,$path,"name","enara");
 * $where-> "AND 
 */
/*function addCondition(&$path,&$where,$key,$value,$isLike="both",$whereType="AND",$absolute=null,$start="",$end=""){
	GLOBAL $melon;
	$parseURI=$melon['helper']['uri'];
	if($path==""&&!$absolute){
		$pathInitial="?";
	}
	else{
		$pathInitial='&';
	}
	
	if($where==""){
		$initial=$where;
	}
	else{
		if($whereType==""){
			$whereType="AND";
		}
		$initial=$whereType;
	}
		switch($isLike){
			default: $result="'%$value%'";break;
			case "both": $result="'%$value%'";break;
			case "front":$result="'%$value'";break;
			case "back": $result="'$value%'";break;
			case "equal":$result="'$value'";$equalType="=";break;
		}
	if($parseURI){
		$path.=('/'.$key.'/'.$value);
	}
	else{
		$path.=$pathInitial.$key.'='.$value;
	}
	$where.=(" $initial $start".$key." like ".$result.$end);
}*/
/**
 * 검색 조건을 위한 type, keyword를 이용한 경로, 조건 문자열을 만든다. 
 * @param String 경로 변수.
 * @param String 조건문 변수.
 * @param String 추가 할 type 값, 여러개 일 경우 ,(comma)를 통해 구분 가능.
 * @param String 추가 할 keyword 값.
 * @param String, Array 추가 할 type이 여러 개 일 경우 문자열하나로 치환 또는 배열을 이용해서 치환가능.
 * @param Boolean 경로에 무조건 &을 붙일지 여부. false 일 경우 이전 문자열을 보고 판단하여 ?인지 &인지 결정.
	ex)
			$where="";
			$path="";
			addKeywordPosition($path,$where,'이나라학생','name,contact',$return);
			

 */

 function addKeywordCondition(&$path,&$where,$searchType,$searchKeyword,$pathType=false){
	if($searchType&&$searchKeyword){
		if($pathType){
			$path.='/search_type/'.$searchType.'/search_keyword/'.$searchKeyword;
		}
		else{
			if($path==''){
				$path = '?';
			}
			else{
				$path .= '&';
			}
			$path.='search_type='.$searchType.'&search_keyword='.$searchKeyword;
		}
		if($where!=''){
			$where.=' AND ';
		}
		$where.=($searchType.' like "%'.$searchKeyword.'%"');
	}
}

// ※단순히 where문에 추가하는 것으로, $path 변경시 직접추가해주어야 한다.
function addCondition(&$where,$whereClause,$operator='AND'){
		if($where!=''){
			$where.=' '.$operator.' ';
		}
		$where.=$whereClause;
	}
/*
function addKeywordCondition(&$path,&$where,$type,$keyword,$return="all",$absolute=null){
	GLOBAL $melon;
	$parseURI=$melon['helper']['uri'];
	if(is_array($return)){
		$return=$return[$type];
	}
	if(strpos($type,",")){
		$type=explode(",",$type);
		$len=count($type);
		$multiple='(';
	}
	if($path==""){
		$pathInitial="?";
	}
	else{
		$pathInitial="&";
	}
	if($absolute){
		$pathInitial="&";
	}
	if($where==""){
		$initial=$multiple;
	}
	else{
		$initial=" AND ";
	}
	if($len>1){
		$count=0;
		$where=$where.$initial;
		for($iu=0;$iu<$len;$iu++){
			$typeEach=$type[$iu];
			if($count!=0){
				$where.=" OR ";
			}
			$where.="$typeEach like '%$keyword%'";
			$count++;
		}
		$where.=')';
		if($parseURI){
			$path.=('/type/'.$return.'/keyword/'.$keyword);
		}
		else{
			$path.=$pathInitial."type=$return&keyword=$keyword";
		}
	}
	else{
		if($parseURI){
			$path.=('/type/'.$type.'/keyword/'.$keyword);
		}
		else{
				$path.=$pathInitial."type=$type&keyword=$keyword";
		}
		$where.=$initial."$type like '%$keyword%'";
	}
}*/
/*
 * 현재 페이지에 대한 정보를 배열로 반환
 *
 * @param Integer $itemTotal 가져 오는 데이터의 총 갯수 (Essential)
 * @param Integer $itemNum 한 페이지 당 보여 줄 항목 갯수 (Essential)
 * @param Integer $pageNum 표시할 페이지네이션의 갯수 (Essential)
 * @param Integer $currentPage 현재 페이지의 값 (Essential)
 * @return Array 
	-currentPage - 현재 페이지
	-initPage - 페이지네이션의 시작 값
	-finalPage - 페이지네이션의 마지막 값
	-prevPage - 이전 페이지의 값
	-nextPage - 다음 페이지의 값
	-firstPage - 첫페이지의 값. 1
	-lastPage - 마지막 페이지의 값
	-isFirst - 첫 페이지로 가는 네비게이션 표시여부
	-isPrev - 이전페이지로 가는 네비게이션 표시여부
	-isNext- 다음 페이지로 가는 네비게이션 표시여부
	-isLast- 마지막 페이지로가는 네비게이션 표시여부
 */
function getPageInfo($itemTotal,$itemNum,$pageNum,$currentPage){
	$result = array(
		"currentPage"=>$currentPage,
		"initPage"=> (floor(($currentPage-1)/$pageNum)*$pageNum)+1,
		"finalPage"=>(floor(($currentPage-1)/$pageNum)+1)*$pageNum,
		"prevPage"=>((floor(($currentPage-1)/$pageNum))*$pageNum),
		"nextPage"=>(floor(($currentPage-1)/$pageNum)+1)*$pageNum+1,
		"firstPage"=>1,
		"lastPage"=>ceil($itemTotal/$itemNum)
	);
	if($result["currentPage"]<=$pageNum){
		$result["isPrev"]=false;
		$result["isFirst"]=false;
	}
	else{
		$result["isPrev"]=true;
		$result["isFirst"]=true;
	}
	if($result["currentPage"]>=floor(($result["lastPage"]-1)/$pageNum)*$pageNum+1){
		$result["isNext"]=false;
		$result["isLast"]=false;
	}
	else{
		$result["isNext"]=true;
		$result["isLast"]=true;
	}
	if($result["lastPage"]<=$result["finalPage"]){
		$result["finalPage"]=$result["lastPage"];
	}
	return $result;
}
/**
 * 브라우저 경고창에 문자열 출력후 페이지 이동.
 * @param String 출력 할 메세지.
 * @param String 이동 할 URL. 입력 하지 않을 시 브라우저의 history 이용하여 이전 페이지로 이동.
 */
 
function printMessage($message="",$url="")
{
	$result = "<meta charset=\"utf-8\"><script type=\"text/javascript\">";
	if($message!="")
	{
		$result .= "alert('".$message."');";
	}
	
	if($url=="")
	{
		$result .= "history.back(-1);";
	}
	else
	{
		$result .= "location.replace('".$url."');";
	}
	$result .= "</script>";
	
	echo $result;
	exit;
}
/**
 * 브라우저 경고창에 문자열 출력하거나 하지 않고 페이지 이동.

 * @param String 이동 할 URL. 입력 하지 않을 시 브라우저의 history 이용하여 이전 페이지로 이동.
 * @param String 출력 할 메세지.
 */
 
function redirect($url="",$message="")
{

	$result = "<meta charset=\"utf-8\"><script type=\"text/javascript\">";
	if($message!="")
	{
		$result .= "alert('".$message."');";
	}
	
	if($url=="")
	{
		$result .= "history.back(-1);";
	}
	else
	{
		$result .= "location.replace('".$url."');";
	}
	$result .= "</script>";
	
	echo $result;
	exit;
}
/**
 * 파일을 읽어들인다.
 * @param * 읽을 파일의 상대/절대 경로.
 * @return String 읽은 파일의 문자열.
 */
function readUTF8File($path){
	$fp = fopen($path,"r");
	$result = fread($fp,filesize($path));
	fclose($fp);
	
	return $result;
}
 /**
 * 파일을 열어서 작성한다.
 * @param String 쓸 파일의 상대/절대 경로.
 * @param String 작성 할 내용 문자열.
 */
function writeUTF8File($path,$content){
	if(substr($path,0,1)=='/'){
		$path=$_SERVER["DOCUMENT_ROOT"].$path;
	}
	$fp = fopen($path,"wb+");
	fwrite($fp,$content);
	fclose($fp);
}

function trace(){
	GLOBAL $melon;
	
	$result = "";
	if($melon['debug']=="DEBUG"){
		$trace = debug_backtrace();
		$len = count($trace);
		for($iu=$len-1;$iu>=0;$iu--){
			$item = $trace[$iu];
			if($item["function"]=="trace"){$item["function"]="";}
			else{$item["function"].="()";}
			$result .= " at ".$item["file"]." on <b>line ".$item["line"]."</b><br>".$item["function"];
		}
	}
	return $result;
}

/**
     * POST로 받은 $_FILES의 하나, 또는 복수를 저장한다.
     * @param Array $_FILES
	 * @param String 저장 경로, 루트절대경로로 입력한다. ex) /images/thumb
     * @return Array name=>원래 파일명, path=>저장된 파일명 
     */
//	 $data=array("table"=>"table_notice",array());

/*
	@file [STRING / OBJECT]: $_FILES 변수.
	@path [STRING]:업로드할 경로
	@whiteList [STRING] : 화이트리스트 사용시 기재, 컴마 등으로 구분 (ex : png,jpg)
	@message [STRING] : 화이트리스트 사용시 메세지.
	@debug [BOOLEAN] : 디버깅메세지 보기
*/
function uploadFile($file,$path,$whiteList='',$message='',$debug=false){
	GLOBAL $melon;
	$errors = array(
	 '','업로드한 파일이 php.ini upload_max_filesize 지시어보다 큽니다.',
		'업로드한 파일이 HTML 폼에서 지정한 MAX_FILE_SIZE 지시어보다 큽니다.',
		'파일이 일부분만 전송되었습니다.','파일이 전송되지 않았습니다.',
		'임시 폴더가 없습니다.','디스크에 파일 쓰기를 실패했습니다. ',
		'확장에 의해 파일 업로드가 중지되었습니다.');


	$result=array();

	if(gettype($file)=='string'){
		$file = $_FILES[$file];
	}

	
	/*
		디렉토리 자동생성
	*/
	$pathCheckTotal = $_SERVER['document_root'];
	$pathChecks = explode('/',$path);
	foreach($pathChecks as $key=> $pathCheck){
		if($pathCheck!=''){
			$pathCheckTotal = $pathCheckTotal.'/'.$pathCheck;
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$pathCheckTotal)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$pathCheckTotal,0707);
				
			}
		}
	}
	if($file['name']==''){
		return false;
	}
	

	if(is_array($file["name"])){
		
        $len=count($file["name"]);
		for($iu=0;$iu<$len;$iu++){
			$fileinfo = pathinfo($file['name'][$iu]);
			$extension=$fileinfo["extension"];
			
			if($file['name'][$iu]!=''){  //파일이 없으면 확장자 검사 할 필요 없음.
				if($whiteList&&strpos(strtolower($whiteList),strtolower($extension))===FALSE){
					if(!$message){
						$message=$whiteList.' 파일만 업로드 하실 수 있습니다.';
					}
					printMessage($message);
					exit;
				}
				if(strpos($melon['upload']['filter'],$extension)!==FALSE){
					printMessage($extension.'파일은 업로드 하실 수 없습니다.');
					exit;
				}
			}
			$filename = md5(time().$data['0']['Auto_increment'].rand(0,10000)).".".strtolower($fileinfo["extension"]);
			move_uploaded_file($file["tmp_name"][$iu],$_SERVER['DOCUMENT_ROOT'].$path."/".$filename);
			if($file['error'][$iu]){
				if($debug){
					echo '<div>[Melon Error] <br> Location: Upload <br>Comment : Upload No '.($iu+1).' Error '.$file['error'][$iu].'=>'.$errors[$file['error'][$iu]].'</div>';
				}
				$result[$iu] = null;
			}
			else if($file['name'][$iu]){
				$result[$iu]['name']=$file['name'][$iu];
				$result[$iu]['path']=$path.'/'.$filename;
				$result[$iu]['type']=$file['type'][$iu];
			}
		}
	}
	else{
		$fileinfo = pathinfo($file['name']);
		$extension=$fileinfo["extension"];
		if($file['name']!=''){ //파일이 없으면 확장자 검사 할 필요 없음.
			if($whiteList&&strpos(strtolower($whiteList),strtolower($extension))===FALSE){
				if(!$message){
					$message=$whiteList.' 파일만 업로드 하실 수 있습니다.';
				}
				printMessage($message);
				exit;
			}
			if(strpos($melon['upload']['filter'],$extension)!==FALSE){
				printMessage($extension.'파일은 업로드 하실 수 없습니다.');
				exit;
			}
		}
		$filename = md5(time().$data['0']['Auto_increment'].rand(0,10000)).".".strtolower($fileinfo["extension"]);
		move_uploaded_file($file["tmp_name"],$_SERVER['DOCUMENT_ROOT'].$path."/".$filename);

		if($file['error']&&$debug){
			echo '<div>[Melon Error] <br> Location: Upload <br>Comment : Upload Error '.$file['error'].'=>'.$errors[$file['error']].'</div>';
			return false;
		}
		/*if(isset($data)){
			if(isset($data[1])){
				$param[$data[1]]=$filename;
			}
			if(isset($data[2])){
				$param[$data[2]]=$file['name'];
			}
			$no=insertItem($data[0],$param);
			$result['no']=$no;
		}*/
		$result['name']=$file['name'];
		$result['path']=$path.'/'.$filename;
		$result['type']=$file['type'];
	}
	return $result;
}
//	createThumbnail("1.jpg",1500,1500,1,"images/3.jpg");
//$imageInfo=getImageInfo("1.jpg");
//stampImage($imageInfo[0],$imageInfo[1],$imageInfo[2],"test.jpg",8,100,150);
/**
 * 이미지 경로로부터 이미지의 리소스를 구한다.
 * @param 이미지의 경로
 * @return array 해당 이미지의 리소스, 넓이, 높이, 타입, 속성
 */
function getImageInfo ($path_file){
	if(substr($path_file,0,1)=='/'){
		$path_file=$_SERVER["DOCUMENT_ROOT"].$path_file;
	}
	$size = @getimagesize($path_file);
	switch($size[2]){//image type에 따라 이미지 리소스를 생성한다.
		case 1 : //gif
			$image = @imagecreatefromgif($path_file);
			break;
		case 2 : //jpg
			$image = @imagecreatefromjpeg($path_file);
			break;
		case 3 : //png
			$image = @imagecreatefrompng($path_file);
			break;
		case 18 : //webp
			$image = @imagecreatefromwebp($path_file);
			break;
	}
		$result = $size;
		$result[0] = $image;
		$result[1] = $size[0];//너비
		$result['width'] = $size[0];//너비
		$result[2] = $size[1];//높이
		$result['height'] = $size[1];//높이
		$result[3] = $size[2];//이미지타입
		$result['type'] = $size[2];//이미지타입
		$result[4] = $size[3];//이미지 attribute
		$result['attribute'] = $size[3];//이미지 attribute
		return $result;
}
/**
 * 이미지 리소스를 이용하여 이미지를 저장한다.
 * @param resource 이미지의 리소스
 * @param string 저장 하고자 하는 경로
 * @param string 이미지의 퀄리티. 기본 값은 100이다.
 * @return boolean 저장 성공 여부.
 */
function saveImage ($image, $path_save_file, $quality=100){

	/*
		디렉토리 자동생성
	*/
	$path_info =pathinfo ($path_save_file);
	
	$pathCheckTotal = $_SERVER['document_root'];
	$pathChecks = explode('/',$path_info['dirname']);
	foreach($pathChecks as $key=> $pathCheck){
		if($pathCheck!=''){
			$pathCheckTotal = $pathCheckTotal.'/'.$pathCheck;
			if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$pathCheckTotal)){
				mkdir($_SERVER['DOCUMENT_ROOT'].$pathCheckTotal,0707);
				
			}
		}
	}

	if(substr($path_save_file,0,1)=='/'){
		$path_save_file=$_SERVER["DOCUMENT_ROOT"].$path_save_file;
	}
	$path_save_dir = dirname($path_save_file);//저장 파일 경로에서 상위 디렉토리 경로를 가져옴
	if (!is_writable($path_save_dir)){//해당 디렉토리에 파일을 저장할 권한이 없다면
	   echo 'Permission denied.';
		return false;
	}
	if (is_file($path_save_file)){//같은 이름의 파일이 존재하면
		$result_unlink = @unlink($path_save_file);
		if ($result_unlink === false) {//기존 이미지 삭제에 실패
			echo "Delete Permisition denied.";
			return false;
		}
	}
	//파일명에서 마지막 . 을 기준으로 확장자를 가져와서 소문자로 변환
	$extension = strtolower(substr($path_save_file, strrpos($path_save_file, '.') + 1));

	switch($extension){//확장자에 따라 이미지 저장 처리
		case 'gif' :
			$result_save = @imagegif($image, $path_save_file);
			break;
		case 'jpg' :
		case 'jpeg' :
			$result_save = @imagejpeg($image, $path_save_file, $quality);
			break;
		default : //확장자 png 또는 확장자가 없는 경우, 정의되지 않는 확장자인 경우는 모두 png로 저장
			$result_save = @imagepng($image, $path_save_file);
	}
	if ($result_save === false) {//이미지 저장에 실패
		echo "failed";
		return false;
	}
	else {//이미지 저장에 성공
		return true;
	}
}	
/**
 * 이미지 리소스를 이용하여 썸네일을 생성한다.
 * @param resource 이미지의 리소스
 * @param int 원본 이미지의 넓이.
 * @param int 원본 이미지의 높이.
 * @param int 생성하려는 썸네일의 넓이.
 * @param int 생성하려는 썸네일의 높이.
 * @param int 썸네일 생성 방식. 0=자르기 사용안함, 1=상단(왼쪽) 자름 2=중간자름 3=하단(오른쪽) 자름
 * @return resource 이미지의 리소스.
 */
function getThumbnail($image,$width,$height,$thumbWidth,$thumbHeight,$cut){
	$thumb=imagecreatetruecolor($thumbWidth,$thumbHeight);
	$tempWidth=($height/$thumbHeight)*$thumbWidth; // 썸네일이 원본이었을 경우 가로 길이 계산.
	$tempHeight=($width/$thumbWidth)*$thumbHeight;//썸네일이 원본 이었을 경우 세로의 길이 계산.
	if($cut!=0){
		if($tempHeight>$height){ //임시 높이가 실 원본보다 큰 경우,  가로를 잘라야함.
			$y=0;
			switch($cut){
				case 1: $x=0;
						break;
				case 2:$x=($width-$tempWidth)/2;
						break;
				case 3:$x=$width-$tempWidth;
						break;
			}
			$thumbWidth=($thumbHeight/$height)*$width;
		}
		else if($tempHeight<$height){//임시높이가 실 원본보다 작은 경우, 세로를 잘라야함.
			$x=0;
			switch($cut){
				case 1: $y=0;
						break;
				case 2:$y=($height-$tempHeight)/2;
						break;
				case 3:$y=$height-$tempHeight;
						break;
			}
			$thumbHeight=($thumbWidth/$width)*$height;
		}
	}
	else{
		$x=0;
		$y=0;
	}
	$result = imagecopyresampled ($thumb , $image, 0 , 0 , $x , $y , $thumbWidth ,$thumbHeight, $width , $height);
	return $thumb;
}
/**

 * 이미지 리소스를 이용하여 워터마크를 찍는다.
 * @param Resource 원본 이미지 리소스.
 * @param int 원본 이미지의 넓이.
 * @param int 원본 이미지의 높이.
 * @param String 워터마크 이미지의 경로.
 * @param int 기준, 3,5,6,7,8의 경우 x좌표 및 y좌표는 하단부터 적용될수 있다.
 *            ┌───────┐
			  │ 1 2 3 │
			  │ 4 0 5 │
			  │ 6 7 8 │
			  └───────┘
 * @param int 기준으로부터의 x좌표.
 * @param int 기준으로부터의 y좌표.`
 * @return resource 워터마크 처리된 이미지의 리소스.
 */
function stampImage($image,$width,$height,$path,$standard,$x=0,$y=0){
	$mark=getImageInfo($path);
	list($mark,$markWidth,$markHeight)=$mark;
	switch($standard){
		case 0 :
			$x=$x+($width-$markWidth)/2;
			$y=$y+($height-$markHeight)/2;
			break;
		case 1 : break;
		case 2 : $x=$x+($width-$markWidth)/2;
				 break;
		case 3 : $x=$width-$markWidth-$x;
				 break;
		case 4 : $y=$y+($height-$markHeight)/2;
				 break;
		case 5 : $x=$width-$markWidth-$x;
				 $y=$y+($height-$markHeight)/2;
				 break;
		case 6 : $y=$height-$markHeight-$y;
				 break;
		case 7 : $x=$x+($width-$markWidth)/2;
				 $y=$height-$markHeight-$y;
				 break;
		case 8 : $x=$width-$markWidth-$x;
				 $y=$height-$markHeight-$y;
				 break;
		
	}
	imagecopymerge ( $image , $mark ,$x,$y, 0,0, $markWidth,$markHeight, 100);
	return $image;
}
/**
 * 경로, 넓이, 높이를 이용하여 썸네일을 저장한다.
 * @param String 원본 이미지의 경로.
 * @param int 썸네일의 넓이.
 * @param int 썸네일의 높이.
 * @param int 썸네일 생성 방식.  0=자르기 사용안함, 1=상단(왼쪽) 자름 2=중간자름 3=하단(오른쪽) 자름
 * @param String 저장 경로.
 * @return Boolean 저장 성공 여부.
 */
function createThumbnail($path,$width,$height,$type,$savePath){
	$imageInfo=getImageInfo($path);
	$image=getThumbnail($imageInfo[0],$imageInfo[1],$imageInfo[2],$width,$height,$type);
	return saveImage($image,$savePath);
}       
/**
 * 비율이 같은 작아진 썸네일을 저장한다.
 * @param String 원본 이미지의 경로.
 * @param string/float 줄이는 비율 또는 크기. 비율시 0.5 / 가로시 width = 500, 세로시 height =300 같은 식으로 사용.
 * @param String 저장 경로.
 * @return Boolean 저장 성공 여부.
 */
function createResizedImage($path,$size,$savePath){
	$imageInfo=getImageInfo($path);

	if(gettype($size)=='string'){
		if(strpos($size,'width')!==FALSE){
			$width = str_replace('width=','',$size);
			$height = $width*$imageInfo[2]/$imageInfo[1];
		
		}
		else{
			
			$height = str_replace('height=','',$size);
			$width = $height*$imageInfo[1]/$imageInfo[2];
		}
	}
	else{
		$width = $imageInfo[1] * $size;
		$height = $imageInfo[2] * $size;
	}
	$image=getThumbnail($imageInfo[0],$imageInfo[1],$imageInfo[2],$width,$height,0);
	return saveImage($image,$savePath);
}  
/**
 * JSON API 형태로 성공 메세지를 출력한다.
 * @param string $result 출력 메세지
 * @param string $message 메세지 유형
 * @return string 성공메세지를 JSON으로 엮은 문자열
 */
function jsonMessage($result,$message=null)
{
	if(isset($message)){
		echo "{\"result\":\"".$result."\",\"message\":\"".$message."\"}";
	}
	else{
		echo "{\"result\":\"".$result."\"}";
	}
	exit;
}
/**
 * 메일 발송
 *
 * @param string email							받는사람 email
 * @param string html							보낼 내용
 * @return bool									성공/실패
 */
function mailSend($title, $to_name, $to_email, $from_name, $from_email, $html) {

	//기본적으로 문자열을 UTF-8로 보냄
	$encode_title = "=?UTF-8?B?".base64_encode($title)."?=\n"; 
	$encode_to = "\"=?UTF-8?B?".base64_encode($to_name)."?=\" <".$to_email.">";
	$encode_from = "\"=?UTF-8?B?".base64_encode($from_name)."?=\" <".$from_email.">" ;
	$encode_header = "MIME-Version: 1.0\n"."Content-Type: text/html; charset=UTF-8; format=flowed\n"."To:".$encode_to."\n"."From:".$encode_from."\n"."Content-Transfer-Encoding: 8bit\n"; 

	$mail = mail($to_email, $encode_title, $html, $encode_header, '-f'.$from_email);
	return $mail;
}

/**
 * 입력받은 배열을 JSON으로 변환하여 출력한다.
 * @param mixed $data JSON으로 변환할 객체
 * @return string JSON 형태의 문자열
 */
function jsonEncode( &$data )
{
	$result = "";
	
	if(is_array($data))
	{

		$is_array = false;
		$is_object = false;

		if(is_empty_array($data)){
			$result = '[]';
		}
		foreach($data as $key=>$value)
		{
			if(!is_numeric($key) && $key!="length")
			{
				$is_object = true;
			}else{
				$is_array = true;
			}
		}
		
		if($is_object){
			foreach($data as $key=>$value){
				if(!is_numeric($key) && $key!="length"){
					if($result!=""){$result .= ",";}
					$result .= "\"".$key."\":".jsonEncode( $value );
				}
			}
			$result = "{".$result."}";
		}else if($is_array){
			foreach($data as $key=>$value){
				if(is_numeric($key)){
					if($result!=""){$result .= ",";}
					$result .= jsonEncode($value);
				}
			}
			$result = "[".$result."]";
		}
	}
	else
	{
		if(strlen($data)>0 && substr($data,0,1)=="{" && preg_match('/^\{([\'"][^\n\r]{0,}[\'"]:[\'"\{\[]{1,}[^\n\r]{0,}[\'"\}\]]{1,}){0,}\}$/', $data)){
			$result = $data;
		}else{
				$result = "\"".str_replace(array("\r","\n","\"",'','	',''),array("\\r","\\n","\\\"",'','',''), $data)."\"";
		}
	}
	
	return $result;
}

/**
 * JSON문자열을 PHP배열로 변환한다.
 * @param string $str 해석할 JSON 문자열
 * @return mixed 해석되면 array로 구성해서 반환, 해석안되면 받은 문자열 그대로 반환
 */

 function jsonDecode($json, $assoc = true, $depth = 512, $options = 0) {
    // search and remove comments like /* */ and //
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
    
    if(version_compare(phpversion(), '5.4.0', '>=')) {
        $json = json_decode($json, $assoc, $depth, $options);
    }
    elseif(version_compare(phpversion(), '5.3.0', '>=')) {
        $json = json_decode($json, $assoc, $depth);
    }
    else {
        $json = json_decode($json, $assoc);
    }

    return $json;
}


function jsonDecodeLegacy($str){
	if(!is_string($str)){return $str;}
	if(substr($str,0,1)=="{"){$str = substr($str,1,strlen($str)-2);}
	$str = trim($str);$strlen = strlen($str);
	$q_open = false;$dq_open = false;$comments_open = false;
	$comments = array();
	$ciu = 0;$object_depth = 0;$array_depth = 0;$s = 0;
	$result = array();
	$key = "";$value = "";
	for($iu=0;$iu<$strlen;$iu++){
		switch($str[$iu]){
		case "'":
			if($object_depth==0 && $array_depth==0){if(!$q_open){$s = $iu;$q_open = true;}else{$q_open = false;$value = substr($str,$s+1,$iu-$s-1);}}
		break;
		case "\"":
			if($object_depth==0 && $array_depth==0){if(!$dq_open){$s = $iu;$dq_open = true;}else{$dq_open = false;$value = substr($str,$s+1,$iu-$s-1);}}
		break;
		case "{":
			if($object_depth==0){$s = $iu;}$object_depth++;
		break;
		case "}":
			$object_depth--;if($object_depth==0){$value = jsonDecode(str_replace($comments,"",substr($str,$s+1,$iu-$s-1)));$s = $iu;}
		break;
		case "[":
			if($array_depth==0){$s = $iu;}$array_depth++;
		break;
		case "]":
			$array_depth--;if($array_depth==0){$value = jsonDecode(str_replace($comments,"",substr($str,$s+1,$iu-$s-1)));$s = $iu;}
		break;
		case ":":
			if(!$q_open && !$dq_open && $object_depth==0 && $array_depth==0){
				if($value==""){$value = substr($str,$s,$iu-$s);}
				$value = str_replace($comments,"",$value);
				$key = $value;$value = "";$s = $iu+1;
			}
		break;
		case ",":
			if(!$q_open && !$dq_open && $object_depth==0 && $array_depth==0){
				if($value==""){
					$value = substr($str,$s,$iu-$s);
					$value = str_replace($comments,"",$value);
					if(isset($GLOBALS[$value])){$value = &$GLOBALS[$value];}
				}else{$value = str_replace($comments,"",$value);}
				if($key==""){$key = count($result);}
				$result[$key] = $value;$value = "";$key = "";$s = $iu+1;
			}
		break;
		case "/":
			if(!$q_open && !$dq_open && $str[$iu+1]=="*"){
				$comments[$ciu] = $iu;
				$comments_open = true;
			}
		break;
		case "*":
			if(!$q_open && !$dq_open && $str[$iu+1]=="/"){
				$comments[$ciu] = substr($str,$comments[$ciu],$iu-$comments[$ciu]+2);
				$comments_open = false;
				$ciu++;
			}
		break;
		}
	}
	if($value==""){
		$value = substr($str,$s,$iu-$s);
		$value = str_replace($comments,"",$value);
		if(isset($GLOBALS[$value])){$value = &$GLOBALS[$value];}
	}else{$value = str_replace($comments,"",$value);}
	if($key==""){$key = count($result);}
	$result[$key] = $value;
	
	if(count($result)==1 && $key=="0"){$result = $str;}
	
	return $result;
}

function deleteFile($path){
    if(substr($path,0,1)=='/'){
        $path=$_SERVER["DOCUMENT_ROOT"].$path;
        @unlink($path);
    }
}
function errorMessage($severity,$title,$file,$line){
	echo '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>PHP 에러가 발생했습니다.</h4>

<p>타입: <br>
<b>'.$severity.'</b><br>
</p>
<p>메세지: <br>
<b>'.$title.'</b><br>
</p>

<p>발생위치: <br>
<b>'.$file.' (line : '.$line.')</b>
</p>


</div>';

}


function databaseErrorMessage($error,$query){
	GLOBAL $melon;
writeLog('[QUERY ERROR] '.$error.'  ' ."\n".'query :'.$query);
		if($melon['debug']=='OPERATION'){

return false;
		}
	echo '<html lang="en"><head></head><body><div style="padding-left:20px;margin:0 0 10px 0;">

<!--border:1px solid #990000;-->


<meta charset="utf-8">
<title>Database Error</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>


	<div id="container">
		<h1>데이터베이스 에러가 발생했습니다.</h1>
		<p>'.$error.'<br>query : '.$query.'</p><!--<p>Filename: core/CodeIgniter.php</p><p>Line Number: 532</p>-->	</div>
		
</div>
</body></html>';

}

function writeLog($var,$var2=null,$var3=null,$var4=null){
	$file_path = '/logs/log_'.date('Y-m-d').'.txt';

	$var=print_r($var,true);
	$var2=print_r($var2,true);
	$var3=print_r($var3,true);
	$var4=print_r($var4,true);
	$contents = '';
	if(is_file(ROOT.$file_path)){
		$contents = readUTF8File(ROOT.$file_path);

	}
	echo '<script>';
	echo 'console.log( '.json_encode( $var ).' , '.json_encode( $var2 ).' , '.json_encode( $var3 ).' , '.json_encode( $var4 ).' );';
	echo '</script>';

	writeUTF8file($file_path,$contents."\n[".date('Y-m-d H:i:s')."]\n".$var."\n".$var2."\n".$var3."\n".$var4);

}

function _log( $data )
	{
		echo '<script>';
		echo 'console.log( '.json_encode( $data ).' );';
		echo '</script>';
	}
?>