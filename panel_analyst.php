<?php
require_once ("ini.php");
require_once ("db.php");
// require_once ("com mon.php");
$only_members = false;
include("check_member.php");


foreach($_GET as $col => $val) ${$col} = $val;
foreach($_POST as $col => $val) ${$col} = $val;

include("hzm_header.php");


include("analyst_menu.php");

include("footer.php");
?>