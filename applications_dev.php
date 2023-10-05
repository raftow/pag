<?php

$file_dir_name = dirname(__FILE__);

require_once("$file_dir_name/../external/db.php");
// old include of afw.php
require_once("$file_dir_name/../lib/afw/modes/afw_config.php");

$datatable_on=1;
$cl = "Module";
$currmod = "ums";
$currdb = $server_db_prefix.$currmod;
$limite = 0;
$genere_xls = 0;
$done = $_REQUEST["done"];
if($done) $sql_not = "not";
else $sql_not = "";
$arr_sql_conds = array();


$arr_sql_conds[] = "me.avail='Y' and me.id_module_type = 5 and me.id_module_status $sql_not in (1,2)";
                          
$my_class = new $cl();
if($done) $result_page_title = "التطبيقات المنجزة";
else $result_page_title = "التطبيقات التي في طور الانجاز";

$actions_tpl_arr = array();

$actions_tpl_arr["view"] = true;
                          
if($datatable_on) {
	include "$file_dir_name/../lib/afw/modes/afw_handle_default_search.php";
        $collapse_in = "";
}
else $collapse_in = "in";

if($datatable_on) 
{
	$out_scr .= $search_result_html;
}        
                             
?>