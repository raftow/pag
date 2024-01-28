<?php
if($modtopag) $currmod = $modtopag;

if(!$currmod) die("currmod param required !");
// old include of afw.php
require_once("$file_dir_name/../$currmod/all_to_pag.php");

$log_pag_me = true;

foreach($arr_all_files as $topag_table)
{
     $cl = AfwStringHelper::tableToClass($topag_table);
     include "pag_me.php";
}



?>