<?php

require 'extendedmysqli.cls.php';
/*
 * depend extendedmysqli.cls.php
 * paging support using bootstrap
 */

/*
 * class name : PagingWithMySQLi
* developed by : Md. Shahadat Hossain Khan Razon
* version : 1.01
* create date : February 27, 2014
* update date : February 27, 2014
* dependency : MySQLi & ExtendedMySQLi
* homepage : http://www.shahadathossain.com/
* email : razonklnbd@yahoo.com
*/

/*
 * change log
*
* 20140227: journey begin
*
*/

if(class_exists('PagingWithMySQLi', false)) return;

class PagingWithMySQLi extends ExtendedMySQLi{

	const QRY_START = '?';
	const QRY_SEPARATOR = '&';
	const QRY_ASSIGNER = '=';

	public function getRowsWithPaging($p_from, $p_cur_pg_no = 1, $p_cur_pg_link=null, $p_where=null,
                                      $p_order_by=null, $p_select=null, $p_show_totpg = 9, $p_interval = 10,
                                      $p_show_all = 0, $p_qry_name = "_pno"){
		//Valores por defecto
        if(!isset($p_where)) $p_where='1';
		if(!isset($p_select)) $p_select='*';
		if(!isset($p_cur_pg_link)) $p_cur_pg_link=$_SERVER['PHP_SELF'];

        //Obtenemos los resultados de la base de datos en f_get
		$f_get=$this->getRowsResult('select count(*) from '.$p_from.' where '.$p_where, 0, 0);

        //Comprobamos que se han obtenido resultados
        $f_tot=(intval($f_get)>0?intval($f_get):0);

        //Creamos el objeto que sera devuelto
        $rtrn=new PagingWithMySQLiX();
		if($f_tot>0){ //Si f_get tiene resultados
			$p=self::getPagingStyleOne($p_cur_pg_link, $f_tot, $p_cur_pg_no, $p_show_totpg, $p_interval,
                $p_show_all, $p_qry_name);
			$rtrn->setPaging($p);
			$rtrn->set($this->getAllRows('select '.$p_select.' from '.$p_from.' where '.
                $p_where.(isset($p_order_by)?' order by '.$p_order_by:'').' '.$p['limit_sql']));
		}
		return $rtrn;
	}



	/*
	 created by			: Md. Shahadat Hossain Khan Razon (razonklnbd@yahoo.com)
	created date		: 20060517
	last modified date	: 20080116
	
	usage:
	$sqlcond='jid=\''.$_GET['jid'].'\'';
	$curpg=$core->replaceOnQuerystring(CURRENT_REFRESHED_PAGE, '_pno', NULL, true);
	$p=$core->getPagingStyleOne($curpg, $mysql->getTotalRowsX('applied', $sqlcond), $_GET['_pno']);
	$skrs=$mysql->runQuery("select * from `applied` where $sqlcond order by name $p[limit_sql]");
	
	
	
	*/
	private static function getPagingStyleOne($p_cur_pg_lnk, $p_tot, $p_cur_pg = 1, $p_show_totpg = 9,
                                              $p_interval = 10, $p_show_all = 0, $p_qry_name = "_pno"){
		$f_return["record_fl"] = false;
		$p_totrec = intval($p_tot);
		if($p_totrec > 0){
			if($p_interval < 1) $p_interval = 10;
			if($p_show_totpg < 1) $p_show_totpg = 9;
			if(strlen($p_qry_name)<1) $p_qry_name = "_pno";
			$f_return["query_name"] = $p_qry_name;
			$f_return["curent_page"] = $p_cur_pg_lnk;
			$f_return["page_interval"] = $p_interval;
			$f_curent_page = $p_cur_pg_lnk;
			if(!is_numeric($p_cur_pg)) $p_cur_pg = 1;
			if($p_cur_pg < 1) $p_cur_pg = 1;
			$f_first = false;
			$f_last = false;
			$f_qry_sap = self::QRY_START;
			if(preg_match("/[".self::QRY_START."]/", $p_cur_pg_lnk) > 0) $f_qry_sap = self::QRY_SEPARATOR;
			$p_cur_pg_lnk.=$f_qry_sap;
			//echo $p_cur_pg_lnk.self::QRY_START; exit();
	
			$f_totpg = ($p_totrec-($p_totrec%$p_interval))/$p_interval;
			if(($p_totrec%$p_interval) > 0) $f_totpg++;
			$f_return["total_page"] = $f_totpg;
	
			if($p_cur_pg>$f_totpg) $p_cur_pg = $f_totpg;
			$f_show_start = 1;
			if($f_totpg > $p_show_totpg && $p_cur_pg > ($p_show_totpg/2)){
				$f_show_start = intval($p_cur_pg - ($p_show_totpg/2))+1;
				if(($f_show_start+$p_show_totpg) > $f_totpg) $f_show_start = $f_totpg - $p_show_totpg + 1;
			}
			if($f_show_start < 1) $f_show_start = 1;
			$f_show_end = $f_totpg;
			if(($f_show_start+$p_show_totpg)<=$f_show_end) $f_show_end = $f_show_start + $p_show_totpg - 1;
			if($f_show_start > 1) $f_first = true;
			if($f_totpg >= ($f_show_start+$p_show_totpg)) $f_last = true;
	
			$start_index = 0;
			if($p_cur_pg > 1) $start_index = ($p_cur_pg - 1) * $p_interval;
			$f_return["limit_sql"] = "limit $start_index, $p_interval";
			if(intval($p_show_all) == 1) $f_return["limit_sql"] = " ";
	
			$f_return["prev"]["text"] = "Prev";
			$f_return["prev"]["link"] = "";
			$f_return["next"]["text"] = "Next";
			$f_return["next"]["link"] = "";
			if($f_show_end > 1) $f_return["record_fl"] = true;
			$f_return["first_enabled"] = $f_first;
			$f_return["last_enabled"] = $f_last;
			$f_return["first"]["text"] = "First";
			if($f_first == true){
				$f_return["first"]["linkNtext"] = "<a href='".$p_cur_pg_lnk.$p_qry_name.self::QRY_ASSIGNER."1'>First</a>";
				$f_return["first"]["link"] = $f_curent_page;
			}
			$f_return["last"]["text"] = "End";
			if($f_last == true){
				$f_return["last"]["linkNtext"] = "<a href='".$p_cur_pg_lnk.$p_qry_name.self::QRY_ASSIGNER.$f_totpg."'>End</a>";
				$f_return["last"]["link"] = $p_cur_pg_lnk.$p_qry_name."=".$f_totpg;
			}
			$f_ctr = 0;
			for($_i=$f_show_start;$_i<=$f_show_end;$_i++){
				$f_return["page"][$_i]["text"]="<strong>$_i</strong>";
				$f_return["page"][$_i]["link"]='';
				$f_return["page"][$_i][$p_qry_name]=$_i;
				if($p_cur_pg!=$_i){
					$f_return["page"][$_i]["text"]="<a href='".$p_cur_pg_lnk.$p_qry_name.self::QRY_ASSIGNER.$_i."'>".$_i."</a>";
					$f_return["page"][$_i]["link"]=$p_cur_pg_lnk.$p_qry_name."=".$_i;
				}else{
					$f_return["prev"][$p_qry_name] = $_i-1;
					$f_return["prev"]["link"] = $p_cur_pg_lnk.$p_qry_name.self::QRY_ASSIGNER.($_i-1);
					$f_return["next"][$p_qry_name] = $_i+1;
					$f_return["next"]["link"] = $p_cur_pg_lnk.$p_qry_name.self::QRY_ASSIGNER.($_i+1);
				}
				$f_ctr++;
			}
			$f_return["total_linked_page"] = $f_ctr;
			$f_return["all"]["text"] = "All";
			$f_return["all"]["link"] = $p_cur_pg_lnk.'_show_all'.self::QRY_ASSIGNER.'1';
		}
		return $f_return;
	}
	
}

class PagingWithMySQLiX{

	private $paging;
	private $data;

	/*function __construct($p_data, $p_paging){
		$this->data=$p_data;
		$this->paging=$p_paging;
	}*/
	public function setPaging($p_paging){ $this->paging=$p_paging; }
	public function set($p_data){ $this->data=$p_data; }

	public function isAnyDataAvailable(){
		return ((isset($this->data) && is_array($this->data) && count($this->data)>0)?true:false);
	}
	public function get(){ if($this->isAnyDataAvailable()) return $this->data; }

	public function isMoreThanOnePageAvailable(){
		if(isset($this->paging) && isset($this->paging['page']) && is_array($this->paging['page']) && count($this->paging['page'])>1) return true;
		return false;
	}
	public function text($p_align='center'){ return self::getDrawPagingText($this->paging, $p_align); }
	public function d1(){ return self::getDrawPagingOne($this->paging); }

	function __toString(){ return self::getDrawBootstrap($this->paging); }


	/*
	 created by			: Md. Shahadat Hossain Khan Razon (razonklnbd@yahoo.com)
	created date		: 20140227
	last modified date	: 20140227
	<ul class="pagination">
                <li class="disabled"><a href="#">&laquo;</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&raquo;</a></li>
              </ul>
	*/
	public static function getDrawBootstrap($p_arr){
		$f_return='&nbsp;';
		if(is_array($p_arr["page"]) && count($p_arr["page"])>1){
			$f_qry_name = $p_arr["query_name"];
			$f_return = '<ul class="pagination">';
			if($p_arr["first_enabled"] == true) $f_return .= '<li><a href="'.$p_arr["first"]["link"].'">&laquo;</a></li>';
			else $f_return .= '<li class="disabled"><a href="#" onClick="return false;">&laquo;</a></li>';
			foreach($p_arr["page"] as $pg) $f_return .= '<li'.(empty($pg['link'])?' class="active"':'').'><a href="'.$pg['link'].'">'.$pg[$f_qry_name].'</a></li>';
			if($p_arr["last_enabled"] == true) $f_return .= '<li><a href="'.$p_arr["last"]["link"].'">&raquo;</a></li>';
			else $f_return .= '<li class="disabled"><a href="#" onClick="return false;">&raquo;</a></li>';
			$f_return .= "</ul>";
		}
		return $f_return;
	}
	


	/*
	 created by			: Md. Shahadat Hossain Khan Razon (razonklnbd@yahoo.com)
	created date		: 20060517
	last modified date	: 20071030
	*/
	public static function getDrawPagingText($p_arr, $p_align='center'){
		$s = "";
		$f_return = '<div align="'.$p_align.'">';
		if($p_arr["first_enabled"] == true) $f_return .= '['.$p_arr["first"]["linkNtext"].']&nbsp;';
		if(is_array($p_arr["page"])){
			foreach($p_arr["page"] as $pg){
				$f_return .= $s.$pg["text"];
				$s = " | ";
			}
		}
		if($p_arr["last_enabled"] == true) $f_return .= '&nbsp;['.$p_arr["last"]["linkNtext"].']';
		$f_return .= "</div>";
		return $f_return;
	}
	
	/*
	 created by			: Md. Shahadat Hossain Khan Razon (razonklnbd@yahoo.com)
	created date		: 20060517
	last modified date	: 20071030
	*/
	public static function getDrawPagingOne($p_arr){
		$f_image_path = "http://www.squarepharma.com.bd/images/paging/one/";
		$f_qry_name = $p_arr["query_name"];
		$f_total_page = $p_arr["total_page"];
		$f_return = "<div align='center' style='background-image: url(".$f_image_path."bg.gif); background-repeat: repeat-x; height: 26px; padding: 0px; padding-top: 2px;'>";
		$f_return .= "<table width=".(20*$p_arr["total_linked_page"]+49*4)." height=20 cellpadding=0 cellspacing=0 border=0><tr><td>";
		$f_return .= "<div align='center' style='height: 17px; width: 98px; position: relative; float: left; padding: 0px; padding-top: 3px;'>";
		if($p_arr["first_enabled"]) $f_return .= "<a href='".$p_arr["first"]["link"]."' title='Goto First Page'><img src='".$f_image_path."first.gif' border=0 width=43 height=17 hspace=3 vspace=0></a>";
		else $f_return .= "<img src='".$f_image_path."first_dim.gif' border=0 width=43 height=17 hspace=3 vspace=0>";
		if($p_arr["prev"][$f_qry_name] > 0) $f_return .= "<a href='".$p_arr["prev"]["link"]."' title='Goto Prev $p_arr[page_interval]'><img src='".$f_image_path."prev.gif' border=0 width=43 height=17 hspace=3 vspace=0></a>";
		else $f_return .= "<img src='".$f_image_path."prev_dim.gif' border=0 width=43 height=17 hspace=3 vspace=0>";
		$f_return .= "</div>";
		if(is_array($p_arr["page"])){
			foreach($p_arr["page"] as $pg){
				if(strlen($pg["link"]) > 0) $f_return .= "<div align='center' style='background-image: url(".$f_image_path."n.gif); background-repeat: no-repeat; height: 20px; width: 20px; position: relative; float: left; font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; padding: 0px; padding-top: 3px;'><a href='$pg[link]' style='text-decoration: none; color: #FFFFFF;' title='Goto # $pg[$f_qry_name]'>$pg[$f_qry_name]</a></div>";
				else $f_return .= "<div align='center' style='background-image: url(".$f_image_path."d.gif); background-repeat: no-repeat; height: 20px; width: 20px; position: relative; float: left; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #000000; font-weight: bold; padding: 0px; padding-top: 3px;'>$pg[$f_qry_name]</div>";
			}
		}
		$f_return .= "<div align='center' style='height: 17px; width: 98px; position: relative; float: left; padding: 0px; padding-top: 3px;'>";
		if($p_arr["next"][$f_qry_name] <= $f_total_page) $f_return .= "<a href='".$p_arr["next"]["link"]."' title='Goto Next $p_arr[page_interval]'><img src='".$f_image_path."next.gif' border=0 width=43 height=17 hspace=3 vspace=0></a>";
		else $f_return .= "<img src='".$f_image_path."next_dim.gif' border=0 width=43 height=17 hspace=3 vspace=0>";
		if($p_arr["last_enabled"]) $f_return .= "<a href='".$p_arr["last"]["link"]."' title='Goto Last Page'><img src='".$f_image_path."last.gif' border=0 width=43 height=17 hspace=3 vspace=0></a>";
		else $f_return .= "<img src='".$f_image_path."last_dim.gif' border=0 width=43 height=17 hspace=3 vspace=0>";
		$f_return .= "</div>";
		$f_return .= "</td></tr></table>";
		$f_return .= "</div>";
		return $f_return;
	}








}

