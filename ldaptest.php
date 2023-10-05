<?php
$file_dir_name = dirname(__FILE__); 
require_once ("$file_dir_name/../afw/afw_autoloader.php");
// require_once("$file_dir_name/../external/db.php");        
$MODULE = "pag";
require_once ("$file_dir_name/../$MODULE/ini.php"); 
require_once ("$file_dir_name/../$MODULE/module_config.php");
require_once ("$file_dir_name/../$MODULE/application_config.php");
// die("DBG-begin of session start");
AfwSession::initConfig($config_arr);
AfwSession::startSession();

list($user_connected, $user_not_connected_reason, $info0, $ldap_dbg) = AfwLoginUtilities::ldap_login("rboubaker","Moa2021th");

echo "user_connected=$user_connected,<br> user_not_connected_reason=$user_not_connected_reason, <br>";
echo "info0=".var_export($info0,true).",<br> ldap_dbg=$ldap_dbg <br>";
?>