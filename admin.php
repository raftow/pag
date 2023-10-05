<?php

require_once ("db.php");
require_once ("common.php");

$only_members = true;
$only_drh = true;
include("check_member.php");
//die(print_r($_POST));
$cl = $_GET["cl"];
$cl_tit = $adminClasses[$cl];
$in_mas =true;
include("hzm_header.php");
?>

............... ???????????????????

<?
include("footer.php");
?>