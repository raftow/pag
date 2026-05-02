<?php
include("pag_start.php");


$Main_Page = "home.php";
$My_Module = "pag";

// require("$file_dir_name/../lib/afw/cms/cms_main_page.php"); 
CmsMainPage::echoMainPage($MODULE, $Main_Page, $file_dir_name);



?>