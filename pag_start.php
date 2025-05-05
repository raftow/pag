<?php

$file_dir_name = dirname(__FILE__);


set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

require_once("$file_dir_name/../lib/afw/afw_autoloader.php");

require_once("$file_dir_name/../config/global_config.php");



AfwAutoLoader::addMainModule("pag");

include_once ("$file_dir_name/../pag/ini.php");
include_once ("$file_dir_name/../pag/module_config.php");

$cre_u_id = $TECH_FIELDS[$MODULE]["CREATION_USER_ID_FIELD"];
$cre_date = $TECH_FIELDS[$MODULE]["CREATION_DATE_FIELD"];
$mod_u_id = $TECH_FIELDS[$MODULE]["UPDATE_USER_ID_FIELD"];
$mod_date = $TECH_FIELDS[$MODULE]["UPDATE_DATE_FIELD"];
$val_u_id = $TECH_FIELDS[$MODULE]["VALIDATION_USER_ID_FIELD"];
$val_date = $TECH_FIELDS[$MODULE]["VALIDATION_DATE_FIELD"];
$ver_fld  = $TECH_FIELDS[$MODULE]["VERSION_FIELD"];
$actv_fld = $TECH_FIELDS[$MODULE]["ACTIVE_FIELD"];


include_once ("$file_dir_name/../pag/application_config.php");

include_once ("$file_dir_name/../lib/afw/afw_error_handler.php");

AfwSession::initConfig($config_arr, "system", "$file_dir_name/../pag/application_config.php");

AfwSession::startSession();