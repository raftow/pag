<?php
$file_dir_name = dirname(__FILE__); 
include_once("$file_dir_name/../external/db.php");
// 
require_once("$file_dir_name/../lib/afw/afw_debugg.php");
require_once("$file_dir_name/../lib/afw/afw_ini.php");


require_once("$file_dir_name/hday.php");

$only_admin = true;
$debug_name = "debugg_hijgen";
require_once("check_member.php");

include("hzm_header.php");
        
$from = $_GET["from"];
$to = $_GET["to"];

$nb = 0;

$arr_hij_days = genereHijriPeriod($from,$to); 
$first_hdate = "";

foreach($arr_hij_days as $gdate => $hij_row)
{
        if(!$first_hdate) $first_hdate = $hij_row["hdate"];
         $hd = new Hday();
         $hd->set("wday_id",$hij_row["wday"]);
         $hd->set("hday_gdat",$gdate);
         $hd->set("hday_date",$hij_row["hdate"]);
         $hd->set("hday_descr",$hij_row["descr"]);
         
         if($hij_row["free"]=="Y") $active = "N"; else $active = "Y";
         
         $hd->set("active",$active);
         
         if($hd->insert()) $nb++;
}

$last_hdate = $hij_row["hdate"];

echo "$nb hday(s) generated from $first_hdate to $last_hdate";


include("hzm_footer.php");

?>

