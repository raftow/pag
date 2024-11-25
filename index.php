<?php
$file_dir_name = dirname(__FILE__); 
include_once ("$file_dir_name/ini.php");
include_once ("$file_dir_name/module_config.php");


$Main_Page = "home.php";
$My_Module = "pag";

require("$file_dir_name/../lib/afw/afw_main_page.php"); 
AfwMainPage::echoMainPage($MODULE, $Main_Page, $file_dir_name);



?>