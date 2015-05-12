<?php

#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

/*
 * class name : ExtendedMySQLi
 * developed by : Md. Shahadat Hossain Khan Razon
 * version : 1.01
 * create date : October 26, 2013
 * update date : November 15, 2013
 * dependency : MySQLi
 * homepage : http://www.shahadathossain.com/
 * email : razonklnbd@yahoo.com
 */

/*
 *
 * ############## about
 *
 * this is a mysqli wrapper class. provide some handy method to make your regular sql task easy and organized
 *
 * ############## features
 *
 * - handy functions for preserve tables for easy maintenance [setTable / setTables / setTablesFromCSV / getTable]
 * - special sqlInit method for other configuration option set just after constructor invoced. handy if you plan to make your own class by inheriting this class!
 * - get primary column name of a table (if connected user support) [getPrimaryKey]
 * - check if a table exist into database [isTableExists]
 * - automatically insert and update operation for one record by passing key value paired array [sqlCreateUpdate]
 * - implementing popular CRUD model [create, read, update, delete]
 * - get total number of rows of a specific table (with or without extra sql condition) [getNumberOfRows]
 * - get insert/update sql statement by providing a key value paired array [getInsertSQL/getUpdateSQL]
 * - get sql condition statement for like operator for a specific column of multiple csv values [getSqlForLikeOperator]
 * - get one record by primary value as associative array [getRecordAssoc]
 * - get one record from sql statement as associative array [getRecordAssocFromSQL]
 * - get formated data & time to insert into database as datetime data type, date data type or time data type [getMysqlFormatedDateTime / getMysqlFormatedDate / getMysqlFormatedTime]
 * - check if a vlaue exists into database by passing value, column name etc [isValueExists]
 * - get strip slashed data after execute query by passing just executed query's returned array [getFetchedSafeRowArray]
 * - fetch as row, array, assoc, object [wrapper handy for getting strip slashed data] [sqlFetchAssoc, sqlFetchRow, sqlFetchArray, sqlFetchObject]
 * - get array of data from sql statement by three different handy method
 * -- getAllRows: return array of all records by incremented value as index (this array's index is not related with data)
 * -- getRows: return array of all records by specific column value as index. please note, that column must select through that sql statement
 * -- getArrWithIdAsKey: return key value pared (one dimensssional array). user must select only two column. first column will use as index
 * - get sql safe string to prevent sql injection [getSQLSafeString]
 * - check if the date provided is compiled with mysql datetime data type and its valid. its can check datetime, date and time [isValidDateTime]
 *
 * please see usage at the bottom of this file to learn how to use this wrapper
 *
 */


/*
 * change log
 *
 * 20140228: fix piculiar problem of aes encrypt & decrypt. for details see comment of aesEncrypt and aesDecrypt method
 * 20140227: add aesEncrypt & aesDecrypt methods
 * 20131231: fix getTimeStamp method
 * 20131201: fix read method
 * 20131115: fix some error reporting issue
 * 20131112: fix some minor bug and remove all notice by checking E_ALL flag of error of php (thanks to Maykonn Welington Candido)
 * 20131110: modify constructor
 * 20131107: implement CRUD functionality
 * 20131101: class name changed
 * 20131026: journey begin
 *
 */

if(class_exists('ExtendedMySQLi', false)) return;

if(!defined('no')) define('no', 0, true);
if(!defined('yes')) define('yes', 1, true);

class ExtendedMySQLi extends MySQLi{
	protected $defaultdb=NULL;
	protected $dbhost=NULL;
	protected $dbuser=NULL;
	protected $dbpass=NULL;
	protected $dbname=NULL; # database name set through conn2db function
	protected $dbport=NULL;
	protected $socket=NULL;
	private $curtable='';
	private $myrs;
	#private $thisdb=false;
	private $ensureSafeData=true;
	#private $dbSafeOpenFl=false;
	protected $myTables;

	static $curSystemTime=NULL;

	protected $error_level=1; # 0: no error output at all - just save error into class variable, 1: no error is shows to bowser but with comment (default), 2: error shows and halt process
	private $errors;
	private $error_fl=false;


/*
	
	created date		: 20131026
	last modified date	: 20131110
*/
	public function __construct($dbhost=NULL, $dbuser=NULL, $dbpass=NULL, $dbname=NULL, $dbport=NULL, $p_socket=NULL, $p_flag=NULL) {
		parent::__construct();
		$this->connstatus=false;
		parent::init();
		if(isset($dbhost) && isset($dbuser)) $this->conn2db($dbhost, $dbuser, $dbpass, $dbname, $dbport, $p_socket, $p_flag);
		$this->ensureSafeData=true;
		$this->sqlInit();
	}
	protected function sqlInit(){ /* this method used as abstract function. extended class should define tis method if required! */ }

	protected $connstatus;
	public function isConnected(){ return $this->connstatus; }
	public function notConnected(){ return !$this->connstatus; }
	protected function conn2db($dbhost=NULL, $dbuser=NULL, $dbpass=NULL, $dbname=NULL, $dbport=NULL, $p_socket=NULL, $p_flag=NULL){
		if(isset($dbhost) && isset($dbuser)){
			$connstatus=$this->real_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport, $p_socket, $p_flag);
			if(true==$connstatus){
				$this->connstatus=true;
				$this->dbhost=$dbhost;
				$this->dbuser=$dbuser;
				$this->dbpass=$dbpass;
				if(isset($dbname) && strlen($dbname)>0) $this->dbname=$this->defaultdb=$dbname;
				$this->dbport=$dbport;
				$this->socket=$p_socket;
			}elseif(!empty($this->connect_error)){
				$this->showSQLError('Connect Error (' . $this->connect_errno . ') '
					. $this->connect_error);
			}else{
				$this->showSQLError('sorry unknown connection error! at '.__FILE__.' line # '.__LINE__.' | ERROR: '.$this->error);
			}
		}
		return $connstatus;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	protected function showSQLError($p_err_msg, $p_error_type=E_USER_ERROR){
		$this->error_fl=true;
		$err_msg=$p_err_msg.' [Error Type # '.$p_error_type.']';
		$errlvl=$this->error_level;
		$this->errors[]=array('message'=>$err_msg, 'debug_backtrace'=>debug_backtrace());
		switch($errlvl){
			case 0:
				/* do nothing. we just save error into array for further processing */
				break;
			case 1:
				echo '<!-- '.htmlentities($err_msg).'<pre>'.print_r(debug_backtrace(), true).'</pre>'.' -->';
				break;
			case 2:
			default:
				trigger_error($p_err_msg.'<pre>'.print_r(debug_backtrace(), true).'</pre>', $p_error_type);
		}
		return true;
	}
	public function getErrors($p_return_error=true){
		if(true!=$p_return_error) echo '<pre>'.print_r($this->errors, true).'</pre>';
		else return $this->errors;
	}


/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	//	Please use this function before every module running of this class
	public function setCurrentTable($p_table){
		if($this->isTableExists($p_table)) $this->curtable=trim($p_table);
	}
	public function getCurrentTable(){ return $this->curtable; }

	public function setTable($p_data1, $p_data2=NULL){
		$k=$v=$p_data1;
		if(isset($p_data2)) $v=$p_data2;
		$this->setTables(array($k=>$v));
	}
	public function setTables($p_data){
		if(is_array($p_data) && count($p_data)>0){
			foreach($p_data as $k=>$v) $this->myTables[$k]=$v;
		}
	}
	public function setTablesFromCSV($p_data_csv, $p_prefix=NULL){
		$tbls=explode(',', $p_data_csv);
		foreach($tbls as $t) $fnltbls[$t]=$p_prefix.trim($t);
		$this->setTables($fnltbls);
	}
	public function getTable($p_idx){ return $this->myTables[$p_idx]; }


/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function mysql_current_db(){
		$this->showSQLError('please use getCurrentDatabase() instead of this function', E_USER_DEPRECATED);
		return $this->getCurrentDatabase();
	}
	public function getCurrentDatabase(){
		$r=@$this->query('SELECT DATABASE()');
		if($r){
			$v=$r->fetch_row();
			return $v[0];
		}else $this->showSQLError('<h3>Cannot select database..</h3>'.$this->error);
	}
	public function setCurrentDatabase($p_dbname=NULL){
		if(!isset($p_dbname) && isset($this->dbname)) $p_dbname=$this->dbname;
		if(isset($p_dbname) && $this->select_db($p_dbname)) $this->defaultdb=$p_dbname;
		return ($this->defaultdb==$p_dbname);
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function isDbOpened($p_dbname=NULL){
		if(isset($this->defaultdb)) $f_dbname=$this->defaultdb;
		if(isset($p_dbname) && strlen(trim($p_dbname))>0) $f_dbname=trim($p_dbname);
		if(isset($f_dbname)){
			$v_dbname=$this->getCurrentDatabase();
			if(strtolower(trim($v_dbname))==strtolower(trim($f_dbname))) return true;
		}
		return false;
	}

/*
	created date		: 20131101
	last modified date	: 20131101
*/
	public function isTableExists($p_tablename){
		$bOk=false;
		if(isset($p_tablename) && strlen($p_tablename)>0) $tblnm=strtolower(trim($p_tablename));
		if(isset($tblnm)){
			$rs=$this->query('SHOW TABLES');
			while(list($tname)=$rs->fetch_row()){
				if(strtolower(trim($tname))==$p_tablename){
					$bOk=true;
					break;
				}
			}
		}
		return $bOk;
	}


/*
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getPrimaryKey($p_table=NULL){
		if(isset($this->curtable)) $f_table=$this->curtable;
		if(isset($p_table)) $f_table=trim($p_table);
		if(isset($f_table) && strlen($f_table)>0){
			$rs=$this->query('describe `'.$f_table.'`');
			if($rs && $rs->num_rows>0){
				while($rw=$rs->fetch_assoc()){
					if(strtolower($rw['Key'])=='pri'){
						$rtrn=$rw['Field'];
						break;
					}
				}
				return $rtrn;
			}
		}
	}


/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function create($p_fields, $p_table=NULL, $p_pk_remove=false, $p_pk_name=NULL){ return $this->sqlCreateUpdate($p_fields, NULL, $p_pk_name, $p_table, $p_pk_remove, 1); }
	public function insert($p_fields, $p_table=NULL, $p_pk_remove=false, $p_pk_name=NULL){ return $this->create($p_fields, $p_pk_name, $p_table, $p_pk_remove); }
	public function update($p_pk_value, $p_fields, $p_table=NULL, $p_pk_remove=false, $p_pk_name=NULL){
		# START: handling version compatibility issue for this method. this portion will delete after 20140331
		if(isset($p_fields) && is_array($p_fields)){
			$f_fields=$p_fields;
			if(isset($p_table)) $f_table=$p_table;
			if(isset($p_pk_name)) $f_pk_name=$p_pk_name;
		}else{
			$this->showSQLError('this methods parameter placement has been changed at 20131119. so please change your code accordingly!', E_USER_DEPRECATED);
			if(isset($p_fields) && is_string($p_fields) && strlen(trim($p_fields))>0) $f_pk_name=$p_fields;
			if(isset($p_table) && is_array($p_table) && count($p_table)>0) $f_fields=$p_table;
			if(isset($p_pk_name) && is_string($p_pk_name) && strlen(trim($p_pk_name))>0) $f_table=$p_pk_name;
		}
		# END: handling version compatibility issue for this method. this portion will delete after 20140331
		return $this->sqlCreateUpdate($f_fields, $p_pk_value, $f_pk_name, $f_table, $p_pk_remove, 2);
	}
	public function delete($p_pk_value, $p_table=NULL, $p_pk_name=NULL){
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(strlen($p_table)>0) $f_table=trim($p_table);
		if(isset($f_table)){
			$f_pk_id=$this->getPrimaryKeyX($p_pk_name, $f_table);
			if(strlen($f_pk_id)>0){
				if(strlen($this->defaultdb)>0) $f_dbname='`'.$this->defaultdb.'`.';
				$sql2del='delete from '.$f_dbname.'`'.$f_table.'` where `'.$f_pk_id.'`=\''.$p_pk_value.'\'';
				$rs=$this->query($sql2del);
				if($this->affected_rows>0) return true;
			}
		}
		return false;
	}
	public function sqlInsertUpdate($p_fields, $p_pk_value=NULL, $p_pk_name=NULL, $p_table=NULL, $p_pk_remove=true, $p_type=0){
		$this->showSQLError('please use sqlCreateUpdate instead of this method/function', E_USER_DEPRECATED);
		return $this->sqlCreateUpdate($p_fields, $p_pk_value, $p_pk_name, $p_table, $p_pk_remove, $p_type);
	}
	private function getPrimaryKeyX($p_pk_name=NULL, $p_pk_table=NULL){
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(isset($p_pk_table) && strlen($p_pk_table)>0) $f_table=trim($p_pk_table);
		if(isset($f_table)){
			if(!isset($p_pk_name) || strlen(trim($p_pk_name))<=0) $f_pk_id=$this->getPrimaryKey($f_table);
			$f_pk_name1=((isset($p_pk_name) && strlen(trim($p_pk_name))>0)?trim($p_pk_name):((isset($f_pk_id) && strlen(trim($f_pk_id))>0)?$f_pk_id:''));
			if(strlen($f_pk_name1)>0) return $f_pk_name1;
		}
	}
	/*
	 * $p_type=0	: unspecified or dynamic
	 * $p_type=1	: only insert operation
	 * $p_type=2	: only update operation
	 */
	public function sqlCreateUpdate($p_fields, $p_pk_value=NULL, $p_pk_name=NULL, $p_table=NULL, $p_pk_remove=true, $p_type=0){
		$f_return=false;
		$f_update=false;
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(strlen($p_table)>0) $f_table=trim($p_table);
		if(isset($f_table) && isset($p_fields) && is_array($p_fields) && count($p_fields)>0){
			$f_pk_id=$this->getPrimaryKeyX($p_pk_name, $f_table);
			if(strlen($f_pk_id)>0) $f_pk_name=$f_pk_id;
			if(true==$p_pk_remove && isset($f_pk_name) && isset($p_fields[$f_pk_name])) unset($p_fields[$f_pk_name]);
			$f_update=false;
			#if(1==$p_type) $f_update=false;
			if((2==$p_type || 0==$p_type) && isset($f_pk_name) && strlen(trim($p_pk_value))>0) $f_update=true;
			if(true==$f_update) $f_update=$this->isValueExists($p_pk_value, true, NULL, $f_pk_name, $f_table);
			#echo 'status of f_update $f_pk_name: '.$f_pk_name.', $p_pk_value: '.$p_pk_value.' .... '; var_dump($f_update);
			# fix fields array
			$f_fields=self::getFixedFieldsArray($p_fields);
			# handle if user provide primary key and value into fields array
			$proceed=true;
			if(isset($p_pk_value)) $f_pk_value=$p_pk_value;
			if(false==$f_update && isset($f_pk_name) && isset($f_fields[$f_pk_name]) && false==$p_pk_remove){
				if(isset($f_fields[$f_pk_name]['value']) && 'string'==$f_fields[$f_pk_name]['type'] && true==$this->isValueExists($f_fields[$f_pk_name]['value'], true, NULL, $f_pk_name, $f_table)){
					$f_update=true;
					$f_pk_value=$f_fields[$f_pk_name]['value'];
					unset($f_fields[$f_pk_name]);
					if($p_type==1){
						$proceed=false;
						$this->showSQLError('you provide primary key value into fields array, but didnot set primary key remove flag to true. and we found that key exist! also you ask for insert. but duplicate primary key will not accepted!! operation terminated...', E_USER_ERROR);
					}
				}else{
					if($p_type==2){
						$proceed=false;
						$this->showSQLError('you provide primary key value into fields array, but didnot set primary key remove flag to true. and we cannot found that key into database! and you ask for update operation. so, operation didnot complete due to non-existance primary key value!! operation terminated...', E_USER_ERROR);
					}
				}
			}
			if(true==$proceed && false==$f_update && isset($f_pk_name) && isset($p_pk_value) && 2==$p_type){
				$proceed=false;
				$this->showSQLError('you asking for update but the record you looking for is not found into primary column ['.$f_pk_name.']. so, operation terminated...', E_USER_ERROR);
			}
			if(true==$proceed){
				$v_sql=$this->getInsSql($f_fields, $f_table);
				if(true==$f_update) $v_sql=$this->getUpdtSql($f_fields, '`'.$f_pk_name.'`=\''.$f_pk_value.'\'', $f_table);
				$v_rs=$this->query($v_sql);
				if($v_rs){
					$f_return=(true==$f_update?$f_pk_value:$this->insert_id);
					$this->curtable=trim($f_table);
				}else $this->showSQLError('system error or sql error: '.$v_sql, E_USER_ERROR);
			}
		}else $this->showSQLError('you must provide table name or set current table before use this method! also you have to provide fields array to run this method/function', E_USER_ERROR);
		return $f_return;
	}


/*
	usage				: total number of rows in value useing sql count() function
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getTotalRowsX($p_table=NULL, $p_condition=NULL){
		$this->showSQLError('please use "getNumberOfRows" function instead of this function. Please note, new function parameter placement has been changed.', E_USER_DEPRECATED);
		return $this->getNumberOfRows($p_condition, $p_table);
	}
	public function getNumberOfRows($p_condition=NULL, $p_table=NULL, $p_dbname=NULL){
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(strlen($p_table)>0) $f_table=$p_table;
		if(!isset($p_condition) || empty($p_condition) || strlen(trim($p_condition))<=0) $p_condition='1';
		$f_sql='select count(*) from '.$this->getDbNameSQL($p_dbname).'`'.$f_table.'` where '.trim($p_condition);
		$f_get=$this->getRowsResult($f_sql, 0, 0);
		$f_tot=(intval($f_get)>0?intval($f_get):0);
		return $f_tot;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
private static function getFixedFieldsArray($p_fields){
	if(isset($p_fields) && is_array($p_fields) && count($p_fields)>0){
		foreach($p_fields as $k=>$v){
			if(is_array($v)){
				$x['value']=$v['value'];
				$x['type']=strtolower(trim($v['type']));
				if('datetime'==$x['type']) $x['value']=self::getMysqlFormatedDateTime($v['value']);
				if('date'==$x['type']) $x['value']=self::getMysqlFormatedDate($v['value']);
				if('time'==$x['type']) $x['value']=self::getMysqlFormatedTime($v['value']);
				if('datetime'==$x['type'] || 'date'==$x['type'] || 'time'==$x['type']) $x['type']='string';
				if('now'==$x['type']) $x['value']='now()';
			}else $x=array('type'=>'string', 'value'=>$v);
			if(is_null($x['value']) || strlen($x['value'])<=0){
				$x['type']='null';
				$x['value']='NULL';
			}
			$f_fields[$k]=$x;
		}
		return $f_fields;
	}
}
	public function getInsSQL($p_fields, $p_table=NULL, $p_dbname=NULL){
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(strlen($p_table)>0) $f_table=$p_table;
		if(strlen($this->defaultdb)>0) $f_dbname=$this->defaultdb;
		if(strlen($p_dbname)>0) $f_dbname=$p_dbname;
		if(isset($f_table) && is_array($p_fields) && count($p_fields)>0) return self::getInsertSQL($p_fields, $f_table, $f_dbname);
	}
	public static function getInsertSQL($p_fields, $p_table, $p_dbname=NULL){
		$return_sql='';
		if(is_array($p_fields) && count($p_fields)>0){
			$sap=NULL;
			$f_fields=self::getFixedFieldsArray($p_fields);
			$keys_ins=$vals_ins='';
			while(list($key, $val) = each($f_fields)){
				$keys_ins.=$sap."`$key`";
				if('string'==$val['type']) $vals_ins.=$sap."'".self::getSQLSafeString($val['value'])."'";
				else $vals_ins.=$sap.$val['value'];
				$sap=', ';
			}
			return "insert into ".self::getDbNameSQLx($p_dbname)."`$p_table` ( $keys_ins ) values ( $vals_ins )";
		}
		return $return_sql;
	}
	
/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getUpdtSQL($p_fields, $p_condition=1, $p_table=NULL, $p_dbname=NULL){
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(strlen($p_table)>0) $f_table=$p_table;
		if(strlen($this->defaultdb)>0) $f_dbname=$this->defaultdb;
		if(strlen($p_dbname)>0) $f_dbname=$p_dbname;
		if(isset($f_table) && is_array($p_fields) && count($p_fields)>0) return self::getUpdateSQL($p_fields, $p_condition, $f_table, $f_dbname);
	}
	
/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public static function getUpdateSQL($p_fields, $p_condition, $p_table, $p_dbname=NULL){
		$return_sql='';
		if(is_array($p_fields) && count($p_fields)>0){
			$f_fields=self::getFixedFieldsArray($p_fields);
			$set_fields=$sap = "";
			while (list($key, $val)=each($p_fields)){
				$set_fields.=$sap.' `'.$key.'`=';
				if('string'==$val['type']) $set_fields.="'".self::getSQLSafeString($val['value'])."'";
				else $set_fields.=$val['value'];
				$sap = ', ';
			}
			$return_sql="update ".self::getDbNameSQLx($p_dbname)."`$p_table` set $set_fields where $p_condition";
		}
		return $return_sql;
	}
	
/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public static function getSqlForLikeOperator($p_fld, $p_val_csv, $p_condition='and', $p_condsap=','){
		if(strlen(trim($p_fld))>0 && strlen(trim($p_val_csv))>0 && strlen(trim($p_condition))>0){
			$vals=explode($p_condsap, trim($p_val_csv));
			if(is_array($vals) && count($vals)>0){
				foreach($vals as $valX){
					if(strlen(trim($valX))>0) $return_valX[]="lower(`".$p_fld."`) like '%".self::getSQLSafeString(strtolower(trim($valX)))."%'";
				}
				if(isset($return_valX) && is_array($return_valX)) return ' ('.implode(' '.strtoupper(trim($p_condition)).' ', $return_valX).') ';
			}
		}
	}
	
/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getRowsResult($p_sql, $p_row_idx=0, $fld=NULL){
		$fVal=false;
		$f_rs=$this->query($p_sql);
		if($f_rs){
			if($f_rs->num_rows>0){
				unset($fVal);
				$fValX=$f_rs->data_seek(intval($p_row_idx));
				$fVal=$fValZ=$this->sqlFetchAssoc($f_rs);
				if(isset($fld)){
					unset($fVal);
					if(is_numeric($fld)){
						$idx=0;
						foreach($fValZ as $k=>$v) $t[$idx++]=$v;
						$fVal=$t[$fld];
					}elseif(is_string($fld)) $fVal=$fValZ[$fld];
					else $fVal=false;
					
				}
			}else $fVal=true;
		}
		return $fVal;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getRowsVal($p_sql, $p_col_idx=-1){
		$this->showSQLError('pleas use $this->getRowsResult($p_sql, 0, $f_colidx); directly instead user this function, its deprecated', E_USER_DEPRECATED);
		$f_colidx=($p_col_idx>=0?$p_col_idx:NULL);
		return $this->getRowsResult($p_sql, 0, $f_colidx);
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
	
	usages				: return array fetch with assoc mode
*/
	public function read($p_id, $p_pk_name=NULL, $p_table=NULL, $p_dbname=NULL){ return $this->getRecordAssoc($p_id, $p_pk_name, NULL, true, $p_table, $p_dbname); }
	public function getRecordAssoc($p_id, $p_pk_name=NULL, $p_additional_cond=NULL, $p_case_ignored=true, $p_table=NULL, $p_dbname=NULL){
		if(strlen($this->curtable)>0) $f_table=$this->curtable;
		if(strlen($p_table)>0) $f_table=$p_table;
		if(isset($f_table)){
			if(!isset($p_pk_name) || strlen(trim($p_pk_name))<=0) $f_pk_id=$this->getPrimaryKey($f_table);
			$f_pk_name1=((isset($p_pk_name) && strlen(trim($p_pk_name))>0)?trim($p_pk_name):(isset($f_pk_id)?$f_pk_id:''));
			if(strlen($f_pk_name1)>0) $f_pk_name=$f_pk_name1;
			if(isset($f_pk_name)){
				$condition1="lower(`".$f_pk_name."`)='".strtolower($this->getSQLSafeStringX($p_id))."'";
				if($p_case_ignored==false) $condition1="`".$f_pk_name."` = '".$this->getSQLSafeStringX($p_id)."'";
				if(isset($p_additional_cond)) $f_additional_cond=' and ('.$p_additional_cond.')';
				if(!isset($f_extra_condition)) $f_extra_condition=' ';
				$f_sql="select * from ".$this->getDbNameSQL($p_dbname)."`".trim($f_table)."` where $condition1 $f_extra_condition limit 1";
				return $this->getRowsResult($f_sql, 0);
			}
		}
	}
	public function getRecordAssocFromSQL($p_sql){ return $this->getRowsResult($p_sql, 0); }
	public function getRowsValX($p_sql, $p_rwnum=0){
		# keep this function for historic reason...
		$this->showSQLError('please avoid to use this function. instead use getRecordAssocFromSQL OR getRowsResult function.', E_USER_DEPRECATED);
		return $this->getRowsResult($p_sql, $p_rwnum);
	}

/*
	
	created date		: 20131101
	last modified date	: 20131231
*/
	private static function getTimeStamp($p_dt=NULL){
		if(isset($p_dt) && is_string($p_dt) && !empty($p_dt)) $rtrn=strtotime($p_dt);
		elseif(isset($p_dt) && is_numeric($p_dt) && floatval($p_dt)>0) $rtrn=floatval($p_dt);
		else $rtrn=(isset(self::$curSystemTime)?self::$curSystemTime:time());
		return $rtrn;
	}
	public static function getMysqlFormatedDateTime($p_dt=NULL){ return date("Y-m-d H:i:s", self::getTimeStamp($p_dt)); }
	public static function getMysqlFormatedDate($p_dt=NULL){ return date("Y-m-d", self::getTimeStamp($p_dt)); }
	public static function getMysqlFormatedTime($p_dt=NULL){ return date("H:i:s", self::getTimeStamp($p_dt)); }
	# these three function here for commpatibility with sql.cls.php
	public function getMysqlDtTm($p_dt=NULL){ return self::getMysqlFormatedDateTime($p_dt); }
	public static function getMysqlDate($p_dt=NULL){ return self::getMysqlFormatedDate(); }
	public static function getMysqlTime($p_dt=NULL){ return self::getMysqlFormatedTime(); }


	public function runQuery($p_sql, $p_identifier=NULL){
		$this->showSQLError('please use $this->query() instead of this method. please note, new method parameter placement has some changes', E_USER_DEPRECATED);
		if(isset($p_identifier)) $this->showSQLError('this parameter has no effect on this method. it is here to use alternate method of sql.cls.php (http://www.phpclasses.org/package/3406/)', E_USER_WARNING);
		return $this->query($p_sql);
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
	
	usage: isValExist($kwrd, 'keyword', 'resume_keywords', true, "and `skcid`='$skcid'")
*/
	public function isValExist($p_value, $p_field_name=NULL, $p_table=NULL, $p_case_ignored = true, $p_extra_condition = NULL){
		$this->showSQLError('please use isValueExists instead of this method. please note, new method parameter placement has some changes', E_USER_DEPRECATED);
		return $this->isValueExists($p_value, $p_case_ignored, $p_extra_condition, $p_field_name, $p_table);
	}
	public function isValueExists($p_value, $p_case_ignored = true, $p_extra_condition = NULL, $p_field_name=NULL, $p_table=NULL, $p_dbname=NULL){
		$return_val=false;
		if(isset($this->curtable) && strlen($this->curtable)>0) $f_table_name=$p_table;
		if(isset($p_table) && strlen($p_table)>0) $f_table_name=$p_table;
		if(!isset($p_field_name)){
			$f_pk_id=$this->getPrimaryKey($f_table);
			if(strlen(trim($f_pk_id))>0) $f_field_name=$f_pk_id;
		}else $f_field_name=$p_field_name;
		if(!empty($p_value) && strlen(trim($p_value))>0 && isset($f_field_name) && isset($f_table_name)>0){
			$v_value=trim($p_value);
			$condition1="lower(`".$f_field_name."`)='".strtolower($this->getSQLSafeStringX($v_value))."'";
			if($p_case_ignored==false) $condition1="`".$f_field_name."` = '".$this->getSQLSafeStringX($v_value)."'";
			$v_sql = "select `".$p_field_name."` from ".$this->getDbNameSQL($p_dbname)."`".trim($f_table_name)."` where $condition1 $p_extra_condition limit 1";
			#echo '<h4>'.$v_sql.'</h4>';
			$v_rs = $this->query($v_sql);
			if($v_rs && $v_rs->num_rows>0) $return_val=true;
		}
		return $return_val;
	}
	protected function getDbNameSQL($p_dbname=NULL){
		if(strlen($this->defaultdb)>0) $f_dbnm=$this->defaultdb;
		if(strlen($p_dbname)>0) $f_dbnm=$p_dbname;
		return self::getDbNameSQLx($f_dbnm);
	}
	protected static function getDbNameSQLx($p_dbname){
		$rtrn=((isset($p_dbname) && !empty($p_dbname) && strlen($p_dbname)>0)?'`'.$p_dbname.'`.':' ');
		return $rtrn;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public static function getFetchedSafeRowArray($p_rw=NULL, $p_ensure_safe_data=true){
		if(true==$p_ensure_safe_data){
			if(is_array($p_rw) && isset($p_rw)){
				foreach($p_rw as $k=>$v) $f_rtrn[$k]=((is_null($v) || empty($v))?NULL:(is_array($v)?self::getFetchedSafeRowArray($v, $p_ensure_safe_data):stripslashes($v)));
			}elseif(!is_array($p_rw)) $f_rtrn=((is_null($p_rw) || empty($p_rw))?NULL:stripslashes($p_rw));
			else $f_rtrn=$p_rw;
		}else $f_rtrn=$p_rw;
		return $f_rtrn;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function sqlFetchAssoc($p_rs=NULL){
		if(isset($this->myrs)) $frs=$this->myrs;
		if(isset($p_rs)) $frs=$p_rs;
		if($frs){
			$r_rw=$frs->fetch_assoc();
			if(!isset($p_rs)) $this->myrs=$frs;
			return $this->getFetchedSafeRowArray($r_rw, $this->ensureSafeData);
		}
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function sqlFetchRow($p_rs=NULL){
		if(isset($this->myrs)) $frs=$this->myrs;
		if(isset($p_rs)) $frs=$p_rs;
		if($frs){
			$r_rw=$frs->fetch_row();
			if(!isset($p_rs)) $this->myrs=$frs;
			return $this->getFetchedSafeRowArray($r_rw, $this->ensureSafeData);
		}
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function sqlFetchArray($p_rs=NULL){
		if(isset($this->myrs)) $frs=$this->myrs;
		if(isset($p_rs)) $frs=$p_rs;
		if($frs){
			$r_rw=$frs->fetch_array();
			if(!isset($p_rs)) $this->myrs=$frs;
			$rtrn=$this->getFetchedSafeRowArray($r_rw, $this->ensureSafeData);
		}
		return $rtrn;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function sqlFetchObject($p_rs=NULL, $p_result_type=NULL){
		if(isset($this->myrs)) $frs=$this->myrs;
		if(isset($p_rs)) $frs=$p_rs;
		if($frs){
			$r_obj=$frs->fetch_object();
			if(!isset($p_rs)) $this->myrs=$frs;
			foreach($r_obj as $k=>$v) $r_rw[$k]=$v;
			$data=$this->getFetchedSafeRowArray($r_rw, $this->ensureSafeData);
			$rtrn=new stdClass();
			foreach($data as $k=>$v) $rtrn->$k=$v;
		}
		return $rtrn;
	}








/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getAllRows($p_sql){
		$cf_return=false;
		$rs=$this->query($p_sql);
		if($rs && $rs->num_rows>0){
			unset($cf_return); $ctr=0;
			while($rw=$this->sqlFetchAssoc($rs)) $cf_return[$ctr++]=$rw;
		}
		return $cf_return;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getRows($p_idfieldname, $p_sql){
		$cf_return=false;
		$alldata=$this->getAllRows($p_sql);
		if(is_array($alldata) && count($alldata)>0){
			unset($cf_return);
			foreach($alldata as $rw) $cf_return[$rw[$p_idfieldname]]=$rw;
		}
		return $cf_return;
	}

/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public function getArrWithIdAsKey($p_sql){
		$cf_return=false;
		$alldata=$this->getAllRows($p_sql);
		if(is_array($alldata) && count($alldata)>0){
			unset($cf_return);
			foreach($alldata as $rw){
				$rwX=array_values($rw);
				$cf_return[trim($rwX[0])]=$rwX[1];
			}
		}
		return $cf_return;
	}

/*
	real escaping or addslashes after checking magic quotes enable or not...
	for security measure of sql injection or sql hijeking..
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public static function sqlSafeString($p_val, $p_real_escaping_enabled=true, $p_mysqllink=NULL){ return self::getSQLSafeString($p_val, $p_mysqllink); }
/*
	addslashes before real escaping by checking magic quotes enable or not...
	for security measure of sql injection or sql hijeking..
	
	created date		: 20131101
	last modified date	: 20131101
*/
	protected function getSQLSafeStringX($p_val){ return self::getSQLSafeString($p_val, $this); }
	public static function getSQLSafeString($p_val, $pi_db=NULL){
		$rtrn=(get_magic_quotes_gpc()?$p_val:addslashes($p_val));
		$dbalive=((isset($pi_db) && is_resource($pi_db) && method_exists($pi_db, 'ping') && $pi_db->ping())?true:false);
		if(true==$dbalive && method_exists($pi_db, 'real_escape_string')) $rtrn=$pi_db->real_escape_string(stripslashes($rtrn));
		return $rtrn;
	}


/*
	
	created date		: 20131101
	last modified date	: 20131101
*/
	public static function isValidDateTime($dateTime, $p_check_date=true, $p_check_time=true){
		if(true==$p_check_date || true==$p_check_time){
			$f_check_time_only=false;
			if(true==$p_check_date && true==$p_check_time){
				$f_regex="/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/";
				$f_datalen=19;
			}
			if(true==$p_check_date && false==$p_check_time){
				$f_regex="/^(\d{4})-(\d{2})-(\d{2})$/";
				$f_datalen=10;
			}
			if(false==$p_check_date && true==$p_check_time){
				$f_regex="/^([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/";
				$f_datalen=8;
				$f_check_time_only=true;
			}
			if(strlen($dateTime)==$f_datalen && preg_match($f_regex, $dateTime, $matches)){
				if(true==$f_check_time_only) return true;
				elseif(checkdate($matches[2], $matches[3], $matches[1])) return true;
			}
		}
		return false;
	}



	/*
	 * cryptography
	 * dated: 20140227
	 * 
	 * piculiar problem:
	 * password like "654321" along with salt "razon" didn't encrypt properly so its didn't decrypt as well
	 * for this reason made a suggestion like feedback type isPassOKForEncAndDec
	 * 
	 */
	public function isPassOKForEncAndDec($p_pass2enc, $p_salt=null){
		$encrypted=$this->aesEncrypt($p_pass2enc, $p_salt);
		$original2test=$this->aesDecrypt($encrypted, $p_salt);
		return ($original2test==$p_pass2enc);
	}
	public function aesEncrypt($p_val2encrypt, $p_key=null){
		#if(!isset($p_key)) $p_key=md5('@wempro');
		# SELECT AES_DECRYPT(AES_ENCRYPT('mytext','mykeystring'), 'mykeystring'); 
		$f_sql='SELECT AES_ENCRYPT(\''.$p_val2encrypt.'\', \''.$p_key.'\')';
		return base64_encode($this->getRowsResult($f_sql, 0, 0));
		//$pad_value = 16-(strlen($p_val2encrypt) % 16);
		//$f_val = str_pad($p_val2encrypt, (16*(floor(strlen($p_val2encrypt) / 16)+1)), chr($pad_value));
		//return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $f_val, MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
	}
	public function aesDecrypt($p_encrypted_val, $p_key=null){
		#if(!isset($p_key)) $p_key=md5('@wempro');
		# SELECT AES_DECRYPT(AES_ENCRYPT('mytext','mykeystring'), 'mykeystring'); 
		$f_sql='SELECT AES_DECRYPT(\''.base64_decode($p_encrypted_val).'\', \''.$p_key.'\')';
		return $this->getRowsResult($f_sql, 0, 0);
		//$key = mysql_aes_key('Ralf_S_Engelschall__trainofthoughts');
		//$val = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $val, MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
		//return rtrim($val, "\0..\16");
	}




/*
	
	created date		: 20131101
	last modified date	: 20131101
	function delFromSingleTable($p_table, $p_cond_arr=NULL, $p_common_cond=NULL){
		$del_sql='delete from `'.$p_table.'`';
		if((isset($p_cond_arr) && is_array($p_cond_arr)) || isset($p_common_cond)){
			if(isset($p_cond_arr) && is_array($p_cond_arr)){
				if(isset($p_common_cond)) $p_common_cond_sql=' AND '.$p_common_cond;
				foreach($p_cond_arr as $idx=>$val){
					$opt=false;
					$opt_num=false;
					foreach($val as $idx2=>$val2){
						if(is_numeric($idx2) && false===$opt){
							$cond_sqlX.=$idx2_num_sap.' \''.$val2.'\'';
							$idx2_num_sap=', ';
							$opt_num=true;
						}elseif(false===$opt_num && !is_numeric($idx2)){
							$cond_sqlX.=$idx1_sap.' `'.$idx2.'`=\''.$val2.'\' ';
							$idx1_sap=' AND ';
							$opt=true;
						}
					}
					if(isset($cond_sql)){
						if(true===$opt) $cond_sql.=$idx_sap.' ('.$cond_sqlX.$p_common_cond_sql.') ';
						if(true==$opt_num) $cond_sql.=$idx_sap.' (`'.$idx.'` IN ('.$cond_sqlX.') '.$p_common_cond_sql.') ';
						if(true===$opt || true==$opt_num) $idx_sap=' OR ';
						unset($cond_sqlX);
					}
					if(!isset($cond_sql)) $cond_sql='1';
					$del_sql.=' where '.$cond_sql;
				}
			}else $del_sql.=' where '.$p_common_cond;
		}else $del_sql.=' where 1';
		return $this->runQuery($del_sql);
	}
*/


/*
	
	
	created date		: 20131101
	last modified date	: 20131101
	public function isDataNeedUpdate($p_source_sql, $p_comparing_array, $p_case_ignore=true) {
		$rtrn=false;
		if(is_array($p_comparing_array)){
			$rtrn=(count($p_comparing_array)>0?true:false);
			$source=$this->getAllRows($p_source_sql);
			if(is_array($source) && count($source)>0){
				$rtrn=true;
				if(count($source)==count($p_comparing_array)){
					$rtrn=false;
					foreach($source as $rw){
						$data=reset($rw);
						$found=false;
						foreach($p_comparing_array as $current){
							$found=((true==$p_case_ignore && strtolower($current)==strtolower($data)) || (false==$p_case_ignore && $current==$data))?true:false;
							if(true==$found) break;
						}
						if(false==$found){
							$rtrn=true;
							break;
						}
					}
				} //if(count($source)==count($p_comparing_array)){
			} //if(is_array($source) && count($source)>0){
		}
		return $rtrn;
	}
*/




}


/*
# usage
$db=new ExtendedMySQLi('localhost', 'root', '@wempro', 'rupshainventory');

echo '<h3>current selected database: '.$db->getCurrentDatabase().'</h3>';
$db->setCurrentTable('ri_customers');
echo '<h3>current selected table: '.$db->getCurrentTable().'</h3>';

$data['user_id_of_outlet_owner']='razon';
$data['user_id_of_customer']='sumon';
$data['customer_name']='razon khan ['.date('r').']';
$data['customer_address']='n/a';
$data['customer_contact1']='sonadanga';
$data['customer_contact2']='khulna';

$insertedid=$db->sqlCreateUpdate($data);
$customerdata=$db->read($insertedid);
#$customerdata=$db->getRecordAssoc($insertedid);
echo '<pre>'.print_r($customerdata, true).'</pre>';
$customerdata=$db->getRecordAssocFromSQL('select * from `ri_customers` where `customer_id`='.$insertedid);
echo '<pre>'.print_r($customerdata, true).'</pre>';

echo '<h3>total number of rows into '.$db->getCurrentTable().' - '.$db->getNumberOfRows().'</h3>';
echo '<h3>total number of rows into ri_products - '.$db->getNumberOfRows(NULL, 'ri_products').'</h3>';
echo '<h3>like operator sql test: '.ExtendedMySQLi::getSqlForLikeOperator('customer_name', 'razon,sumon, karim', 'or').'</h3>';
echo '<h3>today is - '.ExtendedMySQLi::getMysqlFormatedDateTime().', date part of today is - '.ExtendedMySQLi::getMysqlFormatedDate().', time part of today is - '.ExtendedMySQLi::getMysqlFormatedTime().'</h3>';
echo '<h3>is it valid date time format? '.(ExtendedMySQLi::isValidDateTime('2001-05-08 15:15:18')?'yes':'no').'</h3>';
echo '<h3>is it valid date format? '.(ExtendedMySQLi::isValidDateTime('2001-05-08', true, false)?'yes':'no').'</h3>';
echo '<h3>is it valid time format? '.(ExtendedMySQLi::isValidDateTime('25:15:18', false, true)?'yes':'no').'</h3>';

echo '<h3>Available Customers</h3><pre>'.print_r($db->getAllRows('select customer_id, user_id_of_outlet_owner, customer_name from ri_customers'), true).'</pre>';
echo '<h3>Available Customers</h3><pre>'.print_r($db->getRows('customer_id', 'select customer_id, user_id_of_outlet_owner, customer_name from ri_customers'), true).'</pre>';
echo '<h3>Available Customers</h3><pre>'.print_r($db->getArrWithIdAsKey('select customer_id, customer_name from ri_customers'), true).'</pre>';

$rs=$db->query('select * from `ri_customers` where `customer_id`='.$insertedid.' limit 1');
if($rs && $rs->num_rows>0){
	$customerdata=$db->sqlFetchArray($rs);
	echo '<pre>'.print_r($customerdata, true).'</pre>';
}else echo '<h3>data not found for id - '.$insertedid.'</h3>';

$rs=$db->query('select * from `ri_customers` where `customer_id`='.$insertedid.' limit 1');
if($rs && $rs->num_rows>0){
	$customerdata=$db->sqlFetchRow($rs);
	echo '<pre>'.print_r($customerdata, true).'</pre>';
}else echo '<h3>data not found for id - '.$insertedid.'</h3>';

$rs=$db->query('select * from `ri_customers` where `customer_id`='.$insertedid.' limit 1');
if($rs && $rs->num_rows>0){
	$customerdata=$db->sqlFetchAssoc($rs);
	echo '<pre>'.print_r($customerdata, true).'</pre>';
}else echo '<h3>data not found for id - '.$insertedid.'</h3>';

$rs=$db->query('select * from `ri_customers` where `customer_id`='.$insertedid.' limit 1');
if($rs && $rs->num_rows>0){
	$customerdata=$db->sqlFetchObject($rs);
	echo '<pre>'.print_r($customerdata, true).'</pre>';
}else echo '<h3>data not found for id - '.$insertedid.'</h3>';
#*/


