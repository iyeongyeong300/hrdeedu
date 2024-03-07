<?php
//===================================================================================//
// NAME		: db.lib.php
// MEMO		: 데이터베이스 기능
// AUTHOR	: DECODE
// EMAIL	: decode@decodelab.co.kr
// Copyright (c) 2012, DECODE Co., Ltd. All rights reserved.
//===================================================================================//



Class db{
	private $melon;
	private $table;
	private $where;
	private $join = array();
	private $order;
	private $group;
	private $start;
	private $length;
	private $query;
	private $db;
	
	function __construct(){
		GLOBAL $melon;
		$this->melon = $melon;
		
	}
	 private static $_instance = null;
	
	static function query($query){
        self::$_instance = new self;
		self::$_instance->query=$query;
        return self::$_instance;
	}
	static  function table($table){
        self::$_instance = new self;
		self::$_instance->table=$table;
        return self::$_instance;
	}
	public function db($db){
		if(is_string($db)){
			$db = $this->melon[$db];
		}
		$this->db = $db;
		return $this;
	}
	/**
	 * 데이터베이스에 접속
	 * @param mixed $db 데이터베이스 정보를 담은 객체
	 */
	public static function connect(&$db)
	{
	
		GLOBAL $melon;
	
		$db['connect'] = mysqli_connect($db['host'], $db['id'], $db['pw'], $db['name']);
		if (!$db['connect'] ) {
		   echo mysqli_connect_error();
		   return false;
		}
		mysqli_set_charset($db['connect'], str_replace("-","",$melon['charset']));
		
	}
	public function run()
	{
		$query = $this->query;
		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}

		$result = mysqli_query($db['connect'], $query);
		if($result == 0){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}
		$this->initialize();
		return $result;
		
	}
	private function initialize(){
		$this->where='';
		$this->join =array();
		$this->order='';
		$this->group='';
		$this->start='';
		$this->length='';
		$this->query='';
		$this->field='';
	}
	public function where($where,$value=false){
		if($this->where!=''){
			$this->where.=' AND ';
		}
		if(isset($value)&&$value){
		
			$where=explode(' ',$where);
			if($where[1]==''){
				$where[1]='=';
			}
			if($where[1]=='in'){
				if(is_array($value)){
					$value_string='';
					foreach($value as $in_item){
						if($value_string!=''){
							$value_string.=',';
						}
						if(gettype($in_item)=='integer'){
							$value_string.=$in_item;
						}
						else{
							$value_string.=('"'.$in_item.'"');
							
						}
						
					}
					$value=$value_string;
					
				}
				
				$value= '('.$value.')';
				$this->where.=($where[0].' '.$where[1].' '.$value);
			}
			else{

				if(gettype($value)=='integer'){

					$this->where.=($where[0].' '.$where[1].' '.$value);
				}
				else{

					$this->where.=($where[0].' '.$where[1].' "'.$value.'"');
				}
			}
		}
		else{

			$this->where .= $where;
		}

		return $this;
	}
	public function where_or($where,$value=false){
		if($this->where!=''){
			$this->where.=' OR ';
		}
		if($value){
			$where=explode(' ',$where);
			if($where[1]==''){
				$where[1]='=';
			}
			if($where[1]=='in'){
				if(is_array($value)){
					$value_string='';
					foreach($value as $in_item){
						if($value_string!=''){
							$value_string.=',';
						}
						if(gettype($in_item)=='integer'){
							$value_string.=$in_item;
						}
						else{
							$value_string.=('"'.$in_item.'"');
							
						}
						
					}
					$value=$value_string;
					
				}
				
				$value= '('.$value.')';
				$this->where.=($where[0].' '.$where[1].' '.$value);
			}
			else{
				if(gettype($value)=='integer'){
					$this->where.=($where[0].' '.$where[1].' '.$value);
				}
				else{
					$this->where.=($where[0].' '.$where[1].' "'.$value.'"');
				}
			}
		}
		else{
			$this->where .= $where;
		}
		return $this;
	}
	public function like($where,$value,$type='both'){
		if($this->where!=''){
			$this->where.=' AND ';
		}
		
		if($type=='both'){
			$this->where.=($where.' like "%'.$value.'%"');
		}
		if($type=='front'){
			$this->where.=($where.' like "%'.$value.'"');
		}
		if($type=='back'){
			$this->where.=($where.' like "'.$value.'%"');
		}
		
	
		return $this;
	}
	public function like_or($where,$value,$type='both'){
		if($this->where!=''){
			$this->where.=' OR ';
		}
		
		if($type=='both'){
			$this->where.=($where.' like "%'.$value.'%"');
		}
		if($type=='front'){
			$this->where.=($where.' like "%'.$value.'"');
		}
		if($type=='back'){
			$this->where.=($where.' like "'.$value.'%"');
		}
		return $this;
	}

	public function order($order){
		$this->order = $order;
		return $this;
	}
	public function select($field){
		$this->field = $field;
		return $this;
	}
	public function group($group){
		$this->group = $group;
		return $this;
	}
	public function join($table,$condition=false,$join='LEFT'){
		if($condition){
			$table=array($table,$condition,$join);
		}
		
		array_push($this->join , $table);
		return $this;
	}
	public function limit($start,$length=null){
		$this->start = $start;
		$this->length = $length;
		return $this;
	}

	public function insertOrUpdate($data,$condition=null,$viewQuery=false){
		if(is_null($condition)){
			$item = $condition;
		}
		else{

			$current_where=	$this->where;
			$item = $this->item($viewQuery);
			$this->where = $current_where;
		}
		if($item){
			return $this->update($data,$viewQuery);
		}
		else{
			return $this->insert($data,$viewQuery);
		}
	}

	public function insert($data,$viewQuery=false)
	{


		$table=$this->table; 
		$param=$data;

		if(is_string($param)){
			$param= json_decode($param,true);
		}

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}
	
		if($this->melon['column']['create']!="" && $param[$this->melon['column']['create']]==''){$param[$this->melon['column']['create']]="now()";}
		if($this->melon['column']['update']!="" && $param[$this->melon['column']['update']]==''){$param[$this->melon['column']['update']]="now()";}
		$set = $this->getSet($table, $param, $db);
		$query = "INSERT INTO ".$table." SET ".$set;
		
		if($viewQuery){echo $query;}

		mysqli_query($db['connect'], $query);
		$result =  mysqli_insert_id($db['connect']);
		if($result==0){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
			return 0;
		}
		$this->initialize();
		return $result;
	}

	public function update($data,$viewQuery=false)
	{
	

		$param =$data;
		$table=$this->table; 
		$where =  $this->where;



		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}

		try{
			if(!$where){
				 throw new Exception('Update,Delete,Calc 함수의 경우 Where 문이 필요합니다. <br> 전체를 갱신하려는 경우 \'*\'을 사용하세요.', 3);
			
			}
		}
		catch (exception $exception){
			errorMessage('fatal',$exception->getMessage(),$exception->getTrace()[0]['file'],$exception->getCode());
			exit;
		}
		if($where=="*"){
			$where='';
		}
		if($this->melon['column']['update']!=""){$param[$this->melon['column']['update']]="now()";}
		$set = $this->getSet($table, $param, $db);
		$query = "UPDATE ".$table." SET ".$set;
		$query .= $this->getWhere($where);
		
		if($viewQuery){echo $query;}
		$result = mysqli_query($db['connect'], $query);
		if($result == 0){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}
		$this->initialize();
		return $result;

	}
	

	public function delete($viewQuery=false)
	{

		$table=$this->table; 
		$where =  $this->where;



		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}
		try{
			if(!$where){
				 throw new Exception('Update,Delete,Calc 함수의 경우 Where 문이 필요합니다. <br> 전체를 갱신하려는 경우 \'*\'을 사용하세요.', 3);
			
			}
		}
		catch (exception $exception){
			errorMessage('fatal',$exception->getMessage(),$exception->getTrace()[0]['file'],$exception->getCode());
			exit;
		}
		if($where=="*"){
			$where='';
		}
		
		$query = "DELETE FROM ".$table;
		$query .= getWhere($where);
		
		if($viewQuery){echo $query;}
		$result =  mysqli_query($db['connect'], $query);
		if($result == 0){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}
		$this->initialize();
		return $result;

	}

	public function paging($currentPage,$item_number=10,$page_number=10,$paging_tags='?page=[page]',$viewQuery=false){
		
		$table = $this->table;
		$field = $this->field;
		$joins = $this->join;
		$where = $this->where;
		$order = $this->order;
		$group = $this->group;


		
		$result = pageListJoin($table,$joins,$field,$where,$order,$item_number,$page_number,$currentPage,$paging_tags,$group, $db, $viewQuery);
		$this->initialize();
		return $result;
	}

	public function sum($viewQuery=false)
	{


		$table = $this->table;
		$fields = $this->field;
		$joins = $this->join;
		$where = $this->where;
		



		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}
		
		$fields = explode(",", trim($fields));

		$fields_set = "";
		$len = count($fields);
		for($i=0;$i<$len;$i++)
		{
			$fields[$i] = explode(" as ", $fields[$i]);
			if($i>0){$fields_set .= ",";}
			$fields_set .= "sum(".$fields[$i][0].") as ".$fields[$i][count($fields[$i])>1?1:0];
		}
	
		$query = "select ".$fields_set." from ".$table;


		if(is_array($joins)){
			if(is_array($joins[0])){
				foreach ($joins as $join){
					$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
				}
			}
			else if($joins){
				$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
			}
		}

		$query .= getWhere($where);
		
		if($viewQuery){echo $query;}
		$this->initialize();
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);

			if($len==1){
				if(count($fields[0])==2){
					$data = $data [$fields[0][1]];
					
				}
				else{

					$data = $data [$fields[0][0]];
					
				}
				if(!$data){
					$data=0;
				}
			}
			else{
				foreach ($data as $sum_index=>$item ){
					if(!$item){
						$data[$sum_index]  = 0; 		
					}			
				}
			}
			return $data;
		}catch (Exception $e){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
			return array();
		}

	}

	public function average($viewQuery=false)
	{
		$table = $this->table;
		$fields = $this->field;
		$joins = $this->join;
		$where = $this->where;

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}

		$fields = explode(",", trim($fields));
		$fields_set = "";
		$len = count($fields);
		for($i=0;$i<$len;$i++)
		{
			$fields[$i] = explode(" as ", $fields[$i]);
			if($i>0){$fields_set .= ",";}
			$fields_set .= "avg(".$fields[$i][0].") as ".$fields[$i][count($fields[$i])>1?1:0];
		}
		$query = "select ".$fields_set." from ".$table;

		if(is_array($joins)){
			if(is_array($joins[0])){
				foreach ($joins as $join){
					$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
				}
			}
			else if($joins){
				$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
			}
		}


		$query .= getWhere($where);
		$this->initialize();
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);
			if($len==1){
				if(count($fields[0])==2){
					$data = $data [$fields[0][1]];
				}
				else{
					$data = $data [$fields[0][0]];
				}
				if(!$data){
					$data=0;
				}
			}
			else{
				foreach ($data as $sum_index=>$item ){
					if(!$item){
						$data[$sum_index]  = 0; 		
					}			
				}
			}
			return $data;
		}catch (Exception $e){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
			return array();
		}
	}

	public function min($viewQuery=false)
	{
		$table = $this->table;
		$fields = $this->field;
		$joins = $this->join;
		$where = $this->where;

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}

		$fields = explode(",", trim($fields));
		$fields_set = "";
		$len = count($fields);
		for($i=0;$i<$len;$i++)
		{
			$fields[$i] = explode(" as ", $fields[$i]);
			if($i>0){$fields_set .= ",";}
			$fields_set .= "min(".$fields[$i][0].") as ".$fields[$i][count($fields[$i])>1?1:0];
		}
		$query = "select ".$fields_set." from ".$table;

		if(is_array($joins)){
			if(is_array($joins[0])){
				foreach ($joins as $join){
					$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
				}
			}
			else if($joins){
				$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
			}
		}


		$query .= getWhere($where);
		$this->initialize();
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);
			if($len==1){
				if(count($fields[0])==2){
					$data = $data [$fields[0][1]];
				}
				else{
					$data = $data [$fields[0][0]];
				}
				if(!$data){
					$data=0;
				}
			}
			else{
				foreach ($data as $sum_index=>$item ){
					if(!$item){
						$data[$sum_index]  = 0; 		
					}			
				}
			}
			return $data;
		}catch (Exception $e){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
			return array();
		}
	}

	public function max($viewQuery=false)
	{
		$table = $this->table;
		$fields = $this->field;
		$joins = $this->join;
		$where = $this->where;

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}

		$fields = explode(",", trim($fields));
		$fields_set = "";
		$len = count($fields);
		for($i=0;$i<$len;$i++)
		{
			$fields[$i] = explode(" as ", $fields[$i]);
			if($i>0){$fields_set .= ",";}
			$fields_set .= "max(".$fields[$i][0].") as ".$fields[$i][count($fields[$i])>1?1:0];
		}
		$query = "select ".$fields_set." from ".$table;

		if(is_array($joins)){
			if(is_array($joins[0])){
				foreach ($joins as $join){
					$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
				}
			}
			else if($joins){
				$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
			}
		}


		$query .= getWhere($where);
		$this->initialize();
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);
			if($len==1){
				if(count($fields[0])==2){
					$data = $data [$fields[0][1]];
				}
				else{
					$data = $data [$fields[0][0]];
				}
				if(!$data){
					$data=0;
				}
			}
			else{
				foreach ($data as $sum_index=>$item ){
					if(!$item){
						$data[$sum_index]  = 0; 		
					}			
				}
			}
			return $data;
		}catch (Exception $e){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
			return array();
		}
	}

	
	public function nextIncrement($viewQuery=false){
		
		$table = $this->table;


		$query="SHOW TABLE STATUS LIKE '".$table."'";

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}

		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);
		}catch (Exception $e){
			$data = array();
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}
		$this->initialize();
		return $data['Auto_increment'];
		
		
	}

	public function copy($data,$viewQuery=false){
		
		$param =$data;
		$table=$this->table; 
		$where =  $this->where;

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(is_array($table)){
			$where=$table['where'];
			$param =$table['data'];		
			$db=$table['db'];
			$viewQuery=$table['view_query'];
			$table = $table['table'];
		}
		$columns=getListQuery('SHOW COLUMNS FROM '.$table);
		$item=getItem(array(
			table => $table,
			where =>$where,
			view_query=>$viewQuery
			));
		
		foreach($columns['list'] as $column){
			$field=$column['Field'];
			if($field==$this->melon['column']['index']){
				continue;
			}
			if(isset($data[$field])){
				$param[$field] =  $data[$field];
			}
			else{
				$param[$field] = $item[$field];
			}
		}
		$this->initialize();
		return insertItem(array(
			table=>$table,
			data=>$param,
			view_query=>$viewQuery
			));
	}



	public function calc($data)
	{
		$param =$data;
		$table=$this->table; 
		$where =  $this->where;

		if(is_array($table)){
			$where=$table['where'];
			$param =$table['data'];		
			$db=$table['db'];
			$viewQuery=$table['view_query'];
			$table = $table['table'];
		}

		if(is_string($param)){
			$param= json_decode($param,true);
		}


		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}

		try{
			if(!$where){
				 throw new Exception('Update,Delete,Calc 함수의 경우 Where 문이 필요합니다. <br> 전체를 갱신하려는 경우 \'*\'을 사용하세요.', 3);
			
			}
		}
		catch (exception $exception){
			errorMessage('fatal',$exception->getMessage(),$exception->getTrace()[0]['file'],$exception->getCode());
			exit;
		}
		
		if($where=="*"){
			$where='';
		}

		if($this->melon['column']['update']!=""){$param[$this->melon['column']['update']]="now()";}
		$set = getSetCalc($table, $param, $db);
		$query = "UPDATE ".$table." SET ".$set;
		$query .= getWhere($where);
		$this->initialize();
		if($viewQuery){echo $query;}
		$result = mysqli_query($db['connect'], $query);
		if($result==0){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}

	}

	public function total($viewQuery=false)
	{
		

		$table = $this->table;
		$joins = $this->join;
		$where = $this->where;
		$group = $this->group;

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}

		$query = "SELECT count(*) as total FROM ".$table;
		if(is_array($joins)){
			if(is_array($joins[0])){
				foreach ($joins as $join){
					$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
				}
			}
			else if($joins){
				$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
			}
		}
		$query .= getWhere($where, $table);

		if($group!=""){
			$query .= " GROUP BY ".$group;
		}

		$this->initialize();
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);
			return $data["total"];
		}catch (Exception $e){
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
			return false;
		}

	}



	public function item($viewQuery=false)
	{

		$table = $this->table;
		$fields = $this->field;
		$joins = $this->join;
		$where = $this->where;
		$order = $this->order;
		$group = $this->group;

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];

		}
		else{
			$db= $this->db;
		}
		

		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}
		
		$query = "SELECT ".getFieldSet($fields)." FROM ".$table;

		if(is_array($joins[0])){
			foreach ($joins as $join){
				$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
			}
		}
		else if($joins){
			$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
		}
		
		$query .= $this->getWhere($where);
		if(trim($order)==""){
			if($this->melon['column']['index']){
					$order = $table.'.'.$this->melon['column']['index']." DESC";
				$query.=' ORDER BY '.$order;
			}
		}
		else{
			$query .= " ORDER BY ".$order;
		}
		$query .= " LIMIT 1";
		
		if($this->query!=''){
			$query = $this->query;
		}
		if($viewQuery==true){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			$data = mysqli_fetch_assoc($result);
		}catch (Exception $e){
			$data = array();
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}
		$this->initialize();
		return $data;
	}
	public function list($viewQuery=false)
	{
	


	
		$table = $this->table;
		$joins = $this->join;
		$fields = $this->field;
		$where = $this->where;
		$order = $this->order;
		$group = $this->group;
		$start = $this->start;
		$length = $this->length;

		try{
			if(indexOf($table,' AS')!=-1){	
				 throw new Exception('액티브 레코드 사용시 테이블 이름에 별칭을 사용 할수 없습니다.', 3);
			}
		}
		catch (exception $exception){
			errorMessage('fatal',$exception->getMessage(),$exception->getTrace()[0]['file'],$exception->getCode());
			exit;
		}


		if(strpos($table,',viewQuery')){
			$table=str_replace(',viewQuery','',$table);
			$viewQuery=true;
		}
		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		if(!$db['connect']){
			echo '<strong>MySql Error</strong>: database is not connected.';
			return false;
		}
		$i=0;
		$query = "SELECT ".getFieldSet($fields)." FROM ".$table;

		if(is_array($joins[0])){
			foreach ($joins as $join){
				$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
			}
		}
		else if($joins){
			$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
		}


		$query .= $this->getWhere($where);
		if($group!=""){
			$query .= " GROUP BY ".$group;
		}
		if(trim($order)!=""){$query .= " ORDER BY ".$order;}
		else{
		
			if(!empty($this->melon["column"]["index"])){
				$order = $table.'.'.$this->melon['column']['index']." DESC";$query .= " ORDER BY ".$order;
			}
			else{
				$order="";
			}
		}
		if(isset($start)&&$start!==''){
			if($length==''){
				$query .= " LIMIT ".$start;
			}
			else{
				$query .= " LIMIT ".$start.",".$length;
			}
		}
		
		if($this->query!=''){
			$query = $this->query;
		}
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			
			$row['list'] = array();
			while($data = mysqli_fetch_assoc($result))
			{
				$row['list'][$i] = $data;
				$i++;
			}
			$row['length'] = $i;
		}catch (Exception $e){
			$row = array();
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}
		$this->initialize();
		return $row;
	}

	private function getFieldSet(&$param)
	{
		if(trim($param)==""){return "*";}
		else if(is_string($param)){return $param;}
		else if(is_array($param)){
			$result = "";
			foreach($param as $key=>$value)
			{
				if(!is_numeric($key))
				{
					if($result!=""){$result.=",";}
					if(trim($value)==""){
						$result.=$key;
					}else{
						$result.=$value." as ".$key;
					}
				}
			}
			
			return $result;
		}
		else{return "*";}
	}

	/**
	 * 입력한 문자열로 조건문에 대한 쿼리 문자열을 자동생성한다.
	 * @param String $where 검색 조건
	 * @return String 결과 쿼리
	 */
	private function getWhere(&$where,$table='')
	{
		

		if($table){
			$table=$table.'.';
		}

		
		$result = "";
		if(trim($where)==""){}
		else if(is_numeric($where)){$result .= " WHERE ".$table.$this->melon['column']['index']."='".$where."'";}
		else if(!preg_match('/[^0-9,]/i',$where)){$result .= " WHERE ".$table.$this->melon['column']['index']." in (".$where.")";}
		else if(!preg_match('/[^0-9a-zA-Z가-핳,]/i',$where))
		{$result .= " WHERE ".$table.$this->melon['column']['index']." in ('".preg_replace("/,/","','",$where)."')";}
		else{$result .= " WHERE ".$where;}
		
		return $result;
	}

	/**
	 * 입력한 문자열로 필드에 대한 쿼리 문자열을 자동생성한다.
	 * @param String $table_name 테이블명
	 * @param String $param 필드 정의
	 * @return String 결과 쿼리
	 */
	private function getSet($table, &$param, $db=null)
	{
		

		
		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}
		
		$columns = $this->getTableColumns($table, $db);
		$set = "";
		$j = 0;
		foreach($param as $key=>$value)
		{
		
			if(gettype($value)=='NULL'){
				continue;
			}
			if(array_key_exists($key, $columns) && $columns[$key]['name']!="" && !is_numeric($key))
			{
				
				if($j!=0){$set .= ",";}
				if($value=='now()'){
					$set .= $key."=".$value."";
				}
				else if(strpos($value,'PASSWORD(')!==FALSE||strpos($value,'SHA1(')!==FALSE||strpos($value,'MD5(')!==FALSE||strpos($value,'password(')!==FALSE||strpos($value,'sha1(')!==FALSE||strpos($value,'md5(')!==FALSE){
				$set .= $key."=".$value."";
				}
				else{
					$set .= $key."='".$value."'";
				}
				$j++;

			}
		
		}
		
		return $set;
	}


	/**
	 * 입력한 문자열로 필드에 대한 쿼리 문자열을 자동생성한다.
	 * @param String $table 테이블명
	 * @param String $param 필드 정의
	 * @return String 결과 쿼리
	 */
	private function getSetCalc($table, &$param, $db=null)
	{
	
		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}

		
		$columns = getTableColumns($table, $db);
		$set = "";
		$j = 0;
		
		foreach($param as $key=>$value)
		{
			if(array_key_exists($key, $columns) && $columns[$key]['name']!="" && !is_numeric($key))
			{
				if($j!=0){$set .= ",";}
				switch($key)
				{
				case $this->melon['column']['index']:
				case $this->melon['column']['create']:
				case $this->melon['column']['update']:
					$set .= $key."=".$value."";
				break;
				default:
					switch(substr($value,0,1)){
					case "+":
						$set .= $key."=".$key.$value;
					break;

					case "*":
					case "x";
					case "X";
						$set .= $key."=".$key."*".substr($value,1);
					break;

					case "/":
					case "÷";
						$set .= $key."=".$key."/".substr($value,1);
					break;
					case "." :
							$set .="$key = concat($key,'".substr($value,1)."')";
					break;
					default:
						if($value>=0){
							$set .= $key."=".$key."+".$value;
						}else{
							$set .= $key."=".$key.$value;
						}
					break;
					}
				break;
				}
				$j++;
			}
		}
		
		return $set;
	}

	private function getTableColumns($table, $db=null,$viewQuery=false)
	{

		if($this->db==null){
			
			$db = &$this->melon['db'];
		}
		else if(is_string($this->db)){
			
			$db = $this->melon[$this->db];
		}
		else{
			$db= $this->db;
		}

		
		if(isset($this->melon['table'][$table]))
		{
			$row = $this->melon['table'][$table];
		}
		else
		{
			$i = 0;

			$query = "SHOW COLUMNS FROM ".$table;
			
			if($viewQuery){echo $query;}
			try{
				$result = mysqli_query($db['connect'], $query);
				while($data = mysqli_fetch_assoc($result))
				{
					$row[$data['Field']]['name'] = $data['Field'];
					$i++;
				}
			}catch (Exception $e){
				$row = array();
				$mysqlError=  mysqli_error($db['connect']);
				if($mysqlError) {
					databaseErrorMessage($mysqlError,$query);

				}
			}

			
			$this->melon['table'][$table] = $row;
		}
		return $row;
	}
}


/**
 * 데이터베이스에 접속
 * @param mixed $db 데이터베이스 정보를 담은 객체
 */
function dbConnect(&$db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	else if(is_string($db)){$db = &$melon[$db];}
	$db['connect'] = mysqli_connect($db['host'], $db['id'], $db['pw'], $db['name']);
	if (!$db['connect'] ) {
	   echo mysqli_connect_error();
	   return false;
	}
	mysqli_set_charset($db['connect'], str_replace("-","",$melon['charset']));
}

/**
 * 데이터베이스 접속해제
 * @param mixed $db 데이터베이스 정보를 담은 객체
 */
function dbDisconnect($db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}
	
	if($db['connect']){mysqli_close($db['connect']);}
	unset($db['connect']);
	unset($db['select']);

}

/**
 * 단순하게 쿼리만 실행합니다. SELECT 문을 작성해도 결과 값은 반환하지 않습니다. 데이터베이스에 직접 정의한 PROCEDURE나 FUNCTION을 호출하는 용도로 주로 사용되며 서버 효율을 위해 updateItem 또는 insertItem을 사용하지 않고 쿼리를 직접 사용하기 위해 사용합니다.
 * @param String $query 실행할 쿼리문
 * @param mixed $db 데이터베이스 정보를 담은 객체
 */
function sqlQuery($query,$db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}

	$result = mysqli_query($db['connect'], $query);
	if($result == 0){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	return $result;
	
}




/**
 * select 쿼리로 한 컬럼의 객체를 가져온다.
 * @param String $query 실행할 쿼리문
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @param Boolean $viewQuery 실행한 쿼리를 출력할지 여부
 * @return array 결과
 */
function getItemQuery($query, $db=null, $viewQuery=false)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);
	}catch (Exception $e){
		$data = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	
	return $data;
}

/**
 * select 쿼리로 목록을 가져온다. 현재 가져온 컬럼의 수를 length로 결과배열에 포함해서 반환한다.
 * @param String $query 실행할 쿼리문
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @param Boolean $viewQuery 실행한 쿼리를 출력할지 여부
 * @return array 결과
 */
function getListQuery($query, $db=null, $viewQuery=false)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	
	$i = 0;
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		
		$row['list'] = array();
		while($data = mysqli_fetch_assoc($result))
		{
			$row['list'][$i] = $data;
			$i++;
		}
		$row['length'] = $i;
		
	}catch (Exception $e){
		$row = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}

	
	return $row;
}

/**
 * 한 컬럼의 객체를 가져온다.
 * @param String $table_name 테이블명
 * @param String $where 검색 조건
 * @param String $fields 가져올 데이터 필드 지정
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return array 결과
 */
function getItem($table, $where="", $order="",$fields="*", $join=null,$db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where=$table['where'];
		$order =$table['order'];
		$joins =$table['join'];
		$fields=$table['field'];
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
		if($fields==''){
			$fields='*';
		}
	}


	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	
	$query = "SELECT ".getFieldSet($fields)." FROM ".$table;

	if(is_array($joins[0])){
		foreach ($joins as $join){
			$query.=' '.$join[0].' JOIN '.$join[1].' ON '.$join[2];
		}
	}
	else if($joins){
		$query.=' '.$joins[0].' JOIN '.$joins[1].' ON '.$joins[2];
	}

	$query .= getWhere($where);
	if(trim($order)==""){
		if($melon['column']['index']){
			$order = $melon['column']['index']." DESC";
			$query.=' ORDER BY '.$order;
		}
	}
	else{
		$query .= " ORDER BY ".$order;
	}
	$query .= " LIMIT 1";
	
	if($viewQuery==true){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);
	}catch (Exception $e){
		$data = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	return $data;
}

/**
 * 한 컬럼의 객체를 가져온다.
 * @param String $table 테이블명
 * @param String $join Join 배열
 * @param String $where 검색 조건
 * @param String $fields 가져올 데이터 필드 지정
 * @param String $order 정렬 순서
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return array 결과
 */
function getItemJoin($table,$joins,$fields, $where="", $order="", $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where=$table['where'];
		$order =$table['order'];
		$joins =$table['join'];
		$fields=$table['field'];
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
		if($fields==''){
			$fields='*';
		}
	}


	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	
	$query = "SELECT ".getFieldSet($fields)." FROM ".$table;

	if(is_array($joins[0])){
		foreach ($joins as $join){
			$query.=' '.$join[0].' JOIN '.$join[1].' ON '.$join[2];
		}
	}
	else if($joins){
		$query.=' '.$joins[0].' JOIN '.$joins[1].' ON '.$joins[2];
	}

	$query .= getWhere($where,$table);
	if(trim($order)==""){
		if($melon['column']['index']){
			$order = $table.'.'.$melon['column']['index']." DESC";
			$query.=' ORDER BY '.$order;
		}
	}
	else{
		$query .= " ORDER BY ".$order;
	}
	$query .= " LIMIT 1";
	
	if($viewQuery==true){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);
	}catch (Exception $e){
		$data = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	return $data;
}

/**
 * 지정한 조건의 목록을 가져온다. 현재 가져온 컬럼의 수를 length로 결과배열에 포함해서 반환한다.
 * @param String $table_name 테이블명
 * @param String $where 검색 조건
 * @param String $fields 가져올 데이터 필드 지정
 * @param String $order 정렬 순서
 * @param Number $start 시작번호
 * @param Number $len 길이
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return mixed 결과
 */
function getList($table, $where="",  $start=null,$len="", $order="", $fields="*",$joins=null,$group=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where=$table['where'];
		$order =$table['order'];
		$start =$table['start'];
		$len =$table['length'];
		$fields=$table['field'];
		$joins=$table['join'];
		$group=$table['group'];
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
		if($fields==''){
			$fields='*';
		}
	}

	try{
		if(indexOf($table,' AS')!=-1){	
			 throw new Exception('액티브 레코드 사용시 테이블 이름에 별칭을 사용 할수 없습니다.', 3);
		}
	}
	catch (exception $exception){
		errorMessage('fatal',$exception->getMessage(),$exception->getTrace()[0]['file'],$exception->getCode());
		exit;
	}


	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	$i=0;
	$query = "SELECT ".getFieldSet($fields)." FROM ".$table;

	if(is_array($joins[0])){
		foreach ($joins as $join){
			$query.=' '.$join[0].' JOIN '.$join[1].' ON '.$join[2];
		}
	}
	else if($joins){
		$query.=' '.$joins[0].' JOIN '.$joins[1].' ON '.$joins[2];
	}


	$query .= getWhere($where);
	if($group!=""){$query .= " GROUP BY ".$group;}
	if(trim($order)!=""){$query .= " ORDER BY ".$order;}
	else{if(!empty($melon["column"]["index"])){$order = $table.'.'.$melon['column']['index']." DESC";$query .= " ORDER BY ".$order;}else{$order="";}}
	if(isset($start)&&$start!==''){
		if($len==''){
			$query .= " LIMIT ".$start;
		}
		else{
			$query .= " LIMIT ".$start.",".$len;
		}
	}
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		
		$row['list'] = array();
		while($data = mysqli_fetch_assoc($result))
		{
			$row['list'][$i] = $data;
			$i++;
		}
		$row['length'] = $i;
	}catch (Exception $e){
		$row = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	
	return $row;
}


/**
 * 지정한 조건의 목록을 가져온다. 현재 가져온 컬럼의 수를 length로 결과배열에 포함해서 반환한다.
 * @param String $table_name 테이블명
 * @param String $where 검색 조건
 * @param String $fields 가져올 데이터 필드 지정
 * @param String $order 정렬 순서
 * @param Number $start 시작번호
 * @param Number $len 길이
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return mixed 결과

 
 */


function getListJoin($table, $joins,$fields,$where="",  $start=null,$len="", $order="", $group=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where=$table['where'];
		$group =$table['group'];
		$order =$table['order'];
		$start =$table['start'];
		$len =$table['length'];
		$joins=$table['join'];
		$fields=$table['field'];
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
		if($fields==''){
			$fields='*';
		}
	}

	if($join[2]==''){
		$join[2] = 'LEFT';
	}



	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	$i=0;
	$query = "SELECT ".getFieldSet($fields)." FROM ".$table;
	if(is_array($joins[0])){
		foreach ($joins as $join){
			$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
		}
	}
	else if($joins){
		$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
	}
	$query .= getWhere($where,$table);

	if($group!=""){$query .= " GROUP BY ".$group;}
	if(trim($order)!=""){$query .= " ORDER BY ".$order;}
	else{if(!empty($melon["column"]["index"])){$order = $table.'.'.$melon['column']['index']." DESC";$query .= " ORDER BY ".$order;}else{$order="";}}

	if(isset($start)&&$start!==''){
		if($len==''){
			$query .= " LIMIT ".$start;
		}
		else{
			$query .= " LIMIT ".$start.",".$len;
		}
	}
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$row['list'] =array();
		while($data = mysqli_fetch_assoc($result))
		{
			$row['list'][$i] = $data;
			$i++;
		}
		$row['length'] = $i;
	}catch (Exception $e){
		$row = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	
	return $row;
}



/**
 * 테이블에 컬럼을 추가한다.
 * @param String $table_name 테이블명
 * @param Array $param 컬럼으로 집어넣을 데이터를 정의한다. key가 필드명, value가 해당 필드에 입력할 데이터
 * @return Number 입력한 컬럼의 시퀀스
 */
function insertItem($table, $param=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$param =$table['data'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}

	if(is_string($param)){
		$param= json_decode($param,true);
	}

	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	if(!$param){
		return false;
	}
	if($melon['column']['create']!="" && $param[$melon['column']['create']]==''){$param[$melon['column']['create']]="now()";}
	if($melon['column']['update']!="" && $param[$melon['column']['update']]==''){$param[$melon['column']['update']]="now()";}
	$set = getSet($table, $param, $db);
	$query = "INSERT INTO ".$table." SET ".$set;
	
	if($viewQuery){echo $query;}

	mysqli_query($db['connect'], $query);
	$result =  mysqli_insert_id($db['connect']);
	if($result==0){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
		return 0;
	}
	return $result;
}


/**
 * 지정한 검색 조건의 컬럼을 수정한다.
 * @param String $table_name 테이블명
 * @param Array $param 컬럼으로 집어넣을 데이터를 정의한다. key가 필드명, value가 해당 필드에 입력할 데이터
 * @param String $where 검색 조건
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return mixed 쿼리 결과
 */
function updateItem($table, $param=null, $where=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where=$table['where'];
		$param =$table['data'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}

	if(is_string($param)){
		$param= json_decode($param,true);
	}



	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	if(!$where){
		echo '<b>Query Error</b>: Undefined Where Clause';
		exit;
	}
	if($where=="*"){
		$where='';
	}
	if($melon['column']['update']!=""){$param[$melon['column']['update']]="now()";}
	$set = getSet($table, $param, $db);
	$query = "UPDATE ".$table." SET ".$set;
	$query .= getWhere($where);
	
	if($viewQuery){echo $query;}
	$result = mysqli_query($db['connect'], $query);
	if($result == 0){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	return $result;

}


/**
 * 지정한 검색 조건의 컬럼을 삭제한다.
 * @param String $table_name 테이블명
 * @param String $where 검색 조건
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return mixed 쿼리 결과
 */
function deleteItem($table, $where=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where =$table['where'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}


	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	if(!$where){
		echo "<b>Query Error</b>: Undefined Where Clause<br>";
		exit;
	}
	if($where=="*"){
		$where='';
	}
	
	$query = "DELETE FROM ".$table;
	$query .= getWhere($where);
	
	if($viewQuery){echo $query;}
	$result =  mysqli_query($db['connect'], $query);
	if($result == 0){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}
	return $result;

}





/**
 * 1개 열을 복사한다.
 * @param string $table 테이블 명
 * @return array 전환된 배열
 */

function copyItem($table,$data=null,$where=null,$db=null,$viewQuery=false){
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(is_array($table)){
		$where=$table['where'];
		$param =$table['data'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}
	$columns=getListQuery('SHOW COLUMNS FROM '.$table);
	$item=getItem(array(
		table => $table,
		where =>$where,
		view_query=>$viewQuery
		));
	
	foreach($columns['list'] as $column){
		$field=$column['Field'];
		if($field==$melon['column']['index']){
			continue;
		}
		if(isset($data[$field])){
			$param[$field] =  $data[$field];
		}
		else{
			$param[$field] = $item[$field];
		}
	}
	insertItem(array(
		table=>$table,
		data=>$param,
		view_query=>$viewQuery
		));
}
/**
 * 지정한 검색 조건의 컬럼에 지정한만큼 더한다.
 * @param String $table 테이블명
 * @param Array $param 컬럼으로 집어넣을 데이터를 정의한다. key가 필드명, value가 해당 필드에 입력할 데이터
 * @param String $where 검색 조건
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return mixed 쿼리 결과
 */
function calcItem($table, $param=null, $where=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where=$table['where'];
		$param =$table['data'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}

	if(is_string($param)){
		$param= json_decode($param,true);
	}


	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	if(!$where){
		echo "<b>Query Error</b>: Undefined Where Clause<br>";
		exit;
	}
	if($where=="*"){
		$where='';
	}

	if($melon['column']['update']!=""){$param[$melon['column']['update']]="now()";}
	$set = getSetCalc($table, $param, $db);
	$query = "UPDATE ".$table." SET ".$set;
	$query .= getWhere($where);
	
	if($viewQuery){echo $query;}
	$result = mysqli_query($db['connect'], $query);
	if($result==0){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}

}


/**
 * 지정한 조건의 목록의 총 수를 구한다.
 * @param String $table 테이블명
 * @param String $where 검색 조건
 * @param String $joins join 
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return Number 총 개수
 */
function getTotal($table,$where="", $joins=null, $group=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where =$table['where'];		
		$joins =$table['join'];		
		$group =$table['group'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}
	if($join[2]==''){
		$join[2] = 'LEFT';
	}



	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}

	$query = "SELECT count(*) as total FROM ".$table;
	if(is_array($joins[0])){
		foreach ($joins as $join){
			$query.=' '.$join[2].' JOIN '.$join[0].' ON '.$join[1];
		}
	}
	else if($joins){
		$query.=' '.$joins[2].' JOIN '.$joins[0].' ON '.$joins[1];
	}
	$query .= getWhere($where, $table);

	
	if($group!=""){
		$query .= " GROUP BY ".$group;
	}

	
	
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);
		return $data["total"];
	}catch (Exception $e){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
		return false;
	}

}

/**
 * 지정한 조건의 총합을 구한다.
 * @param String $table 테이블명
 * @param String $where 검색 조건
 * @param String $fields 총합을 구할 필드
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return Array 총 합 객체
 */
function getSum($table, $fields='',$where="", $joins=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	if(is_array($table)){
		$where =$table['where'];		
		$joins =$table['join'];		
		$fields =$table['field'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}



	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}
	
	$fields = explode(",", trim($fields));
	$fields_set = "";
	$len = count($fields);
	for($i=0;$i<$len;$i++)
	{
		$fields[$i] = explode(" as ", $fields[$i]);
		if($i>0){$fields_set .= ",";}
		$fields_set .= "sum(".$fields[$i][0].") as ".$fields[$i][count($fields[$i])>1?1:0];
	}
	$query = "select ".$fields_set." from ".$table;


	if(is_array($joins)){
		if(is_array($joins[0])){
			foreach ($joins as $join){
				$query.=' '.$join[0].' JOIN '.$join[1].' ON '.$join[2];
			}
		}
		else if($joins){
			$query.=' '.$joins[0].' JOIN '.$joins[1].' ON '.$joins[2];
		}
	}

	$query .= getWhere($where);
	
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);

		if($len==1){
			if(count($fields[0])==2){
				$data = $data [$fields[0][1]];
				
			}
			else{

				$data = $data [$fields[0][0]];
				
			}
			if(!$data){
				$data=0;
			}
		}
		else{
			foreach ($data as $sum_index=>$item ){
				if(!$item){
					$data[$sum_index]  = 0; 		
				}			
			}
		}
		return $data;
	}catch (Exception $e){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
		return array();
	}

}

/**
 * 지정한 조건의 평균을 구한다.
 * @param String $table 테이블명
 * @param String $where 검색 조건
 * @param String $fields 총합을 구할 필드
 * @param mixed $db 데이터베이스 정보를 담은 객체
 * @return Array 총 합 객체
 */
function getAverage($table, $fields='', $where="", $joins=null, $db=null, $viewQuery=false)
{
	GLOBAL $melon;

	
	if(is_array($table)){
		$where =$table['where'];		
		$joins =$table['join'];		
		$fields =$table['field'];		
		$db=$table['db'];
		$viewQuery=$table['view_query'];
		$table = $table['table'];
	}

	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if(strpos($table,',viewQuery')){
		$table=str_replace(',viewQuery','',$table);
		$viewQuery=true;
	}

	$fields = explode(",", trim($fields));
	$fields_set = "";
	$len = count($fields);
	for($i=0;$i<$len;$i++)
	{
		$fields[$i] = explode(" as ", $fields[$i]);
		if($i>0){$fields_set .= ",";}
		$fields_set .= "avg(".$fields[$i][0].") as ".$fields[$i][count($fields[$i])>1?1:0];
	}
	$query = "select ".$fields_set." from ".$table;

	if(is_array($joins)){
		if(is_array($joins[0])){
			foreach ($joins as $join){
				$query.=' '.$join[0].' JOIN '.$join[1].' ON '.$join[2];
			}
		}
		else if($joins){
			$query.=' '.$joins[0].' JOIN '.$joins[1].' ON '.$joins[2];
		}
	}


	$query .= getWhere($where);
	
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);
		if($len==1){
			if(count($fields[0])==2){
				$data = $data [$fields[0][1]];
			}
			else{
				$data = $data [$fields[0][0]];
			}
			if(!$data){
				$data=0;
			}
		}
		else{
			foreach ($data as $sum_index=>$item ){
				if(!$item){
					$data[$sum_index]  = 0; 		
				}			
			}
		}
		return $data;
	}catch (Exception $e){
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
		return array();
	}
}


/**
 * 테이블의 다음 Auto Increment 키를 구한다.
 * @param String $table 테이블명
 * @return Int Auto Increment 값
 */


function getNextIncrement($table, $db=null, $viewQuery=false){

	$query="SHOW TABLE STATUS LIKE '".$table."'";

	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	if($viewQuery){echo $query;}
	try{
		$result = mysqli_query($db['connect'], $query);
		$data = mysqli_fetch_assoc($result);
	}catch (Exception $e){
		$data = array();
		$mysqlError=  mysqli_error($db['connect']);
		if($mysqlError) {
			databaseErrorMessage($mysqlError,$query);

		}
	}

	return $data['Auto_increment'];
	
	
}


/**
 * 트랜잭션을 시작한다. 커밋을 하지않으면 자동으로 롤백된다.
 * @param mixed $db 데이터베이스 정보를 담은 객체
 */
function transaction($db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	mysqli_query($db['connect'], "SET AUTOCOMMIT=0");
	mysqli_query($db['connect'], "BEGIN");
}

/**
 * 트랜잭션을 시작 후 수행된 DB처리를 전부 커밋한다.
 * @param mixed $db 데이터베이스 정보를 담은 객체
 */
function commit($db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	mysqli_query($db['connect'], "COMMIT");	
}

/**
 * 트랜잭션을 시작 후 수행된 DB처리를 전부 취소한다.
 * @param mixed $db 데이터베이스 정보를 담은 객체
 */
function rollback($db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	if(!$db['connect']){
		echo '<strong>MySql Error</strong>: database is not connected.';
		return false;
	}
	mysqli_query($db['connect'], "ROLLBACK");
}
/**
 * 입력한 문자열로 필드에 대한 쿼리 문자열을 자동생성한다.
 * @param String $param 필드 정의
 * @return String 결과 쿼리
 */
function getFieldSet(&$param)
{
	if(trim($param)==""){return "*";}
	else if(is_string($param)){return $param;}
	else if(is_array($param)){
		$result = "";
		foreach($param as $key=>$value)
		{
			if(!is_numeric($key))
			{
				if($result!=""){$result.=",";}
				if(trim($value)==""){
					$result.=$key;
				}else{
					$result.=$value." as ".$key;
				}
			}
		}
		
		return $result;
	}
	else{return "*";}
}

/**
 * 입력한 문자열로 조건문에 대한 쿼리 문자열을 자동생성한다.
 * @param String $where 검색 조건
 * @return String 결과 쿼리
 */
function getWhere(&$where,$table='')
{
	GLOBAL $melon;

	if($table){
		$table=$table.'.';
	}

	
	$result = "";
	if(trim($where)==""){}
	else if(is_numeric($where)){$result .= " WHERE ".$table.$melon['column']['index']."='".$where."'";}
	else if(!preg_match('/[^0-9,]/i',$where)){$result .= " WHERE ".$table.$melon['column']['index']." in (".$where.")";}
	else if(!preg_match('/[^0-9a-zA-Z가-핳,]/i',$where))
	{$result .= " WHERE ".$table.$melon['column']['index']." in ('".preg_replace("/,/","','",$where)."')";}
	else{$result .= " WHERE ".$where;}
	
	return $result;
}

/**
 * 입력한 문자열로 필드에 대한 쿼리 문자열을 자동생성한다.
 * @param String $table_name 테이블명
 * @param String $param 필드 정의
 * @return String 결과 쿼리
 */
function getSet($table, &$param, $db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	else if(is_string($db)){$db = &$melon[$db];}
	
	$columns = getTableColumns($table, $db);
	$set = "";
	$j = 0;
	foreach($param as $key=>$value)
	{
		if(gettype($value)=='NULL'){
			continue;
		}
		if(array_key_exists($key, $columns) && $columns[$key]['name']!="" && !is_numeric($key))
		{
			
			if($j!=0){$set .= ",";}
			if($value=='now()'){
				$set .= $key."=".$value."";
			}
			else if(strpos($value,'PASSWORD(')!==FALSE||strpos($value,'SHA1(')!==FALSE||strpos($value,'MD5(')!==FALSE||strpos($value,'password(')!==FALSE||strpos($value,'sha1(')!==FALSE||strpos($value,'md5(')!==FALSE){
			$set .= $key."=".$value."";
			}
			else{
				$set .= $key."='".$value."'";
			}
			$j++;
		}
	}
	
	return $set;
}


/**
 * 입력한 문자열로 필드에 대한 쿼리 문자열을 자동생성한다.
 * @param String $table 테이블명
 * @param String $param 필드 정의
 * @return String 결과 쿼리
 */
function getSetCalc($table, &$param, $db=null)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	else if(is_string($db)){$db = &$melon[$db];}
	
	$columns = getTableColumns($table, $db);
	$set = "";
	$j = 0;
	
	foreach($param as $key=>$value)
	{
		if(array_key_exists($key, $columns) && $columns[$key]['name']!="" && !is_numeric($key))
		{
			if($j!=0){$set .= ",";}
			switch($key)
			{
			case $melon['column']['index']:
			case $melon['column']['create']:
			case $melon['column']['update']:
				$set .= $key."=".$value."";
			break;
			default:
				switch(substr($value,0,1)){
				case "+":
					$set .= $key."=".$key.$value;
				break;

				case "*":
				case "x";
				case "X";
					$set .= $key."=".$key."*".substr($value,1);
				break;

				case "/":
				case "÷";
					$set .= $key."=".$key."/".substr($value,1);
				break;
				case "." :
						$set .="$key = concat($key,'".substr($value,1)."')";
				break;
				default:
					if($value>=0){
						$set .= $key."=".$key."+".$value;
					}else{
						$set .= $key."=".$key.$value;
					}
				break;
				}
			break;
			}
			$j++;
		}
	}
	
	return $set;
}

function getTableColumns($table, $db=null,$viewQuery=false)
{
	GLOBAL $melon;
	if($db==null){$db = &$melon['db'];}else if(is_string($db)){$db = $melon[$db];}
	else if(is_string($db)){$db = &$melon[$db];}
	
	if(isset($melon['table'][$table]))
	{
		$row = $melon['table'][$table];
	}
	else
	{
		$i = 0;

		$query = "SHOW COLUMNS FROM ".$table;
		
		if($viewQuery){echo $query;}
		try{
			$result = mysqli_query($db['connect'], $query);
			while($data = mysqli_fetch_assoc($result))
			{
				$row[$data['Field']]['name'] = $data['Field'];
				$i++;
			}
		}catch (Exception $e){
			$row = array();
			$mysqlError=  mysqli_error($db['connect']);
			if($mysqlError) {
				databaseErrorMessage($mysqlError,$query);

			}
		}

		
		$melon['table'][$table] = $row;
	}
	return $row;
}

?>