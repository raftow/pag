<?php

$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

AfwSession::startSession();

require_once("$file_dir_name/../lib/afw/afw_autoloader.php");
$uri_module = AfwUrlManager::currentURIModule();       

if(!$lang) $lang = "ar";
$module_dir_name = $file_dir_name;


require_once("$file_dir_name/../$uri_module/ini.php");
require_once("$file_dir_name/../$uri_module/module_config.php");

include_once("$file_dir_name/../$uri_module/application_config.php");
AfwSession::initConfig($config_arr);

require_once("$file_dir_name/../external/db.php");
// 
require_once("$file_dir_name/../rea/parent_user.php"); 


$debug_name = "debugg_".$uri_module."_register";
 
$my_debug_file = "${debug_name}_".date("Ymd").".txt";
AFWDebugg::initialiser($DEBUGG_SQL_DIR,$my_debug_file);

foreach($_POST as $col => $val) ${$col} = $val;


if(!$next_step)
{
       include("$file_dir_name/../lib/hzm/web/hzm_header.php");
       include("$file_dir_name/../$uri_module/register_step0.php");
       include("$file_dir_name/../pag/footer.php");
}
elseif($next_step==1)
{
   $auser = null;
   
   $auser_error = "";
   // @todo : 
   // 1. check if the IDN is correct and deduce the idn type
   $idn_correct = true;
   $idn_type_id = 3; // ikama
   
   // 2. check if this user already exists
   $auser_exists = "";
   
   //2.0 delete aready disabled account with same idn or same 
   $old_disabled_auser_exists_obj = new Auser();
   $old_disabled_auser_exists_obj->select("avail","N");
   $old_disabled_auser_exists_obj->where("(idn = '$idn' and idn_type_id = $idn_type_id)");
   if($old_disabled_auser_exists_obj->load()) $old_disabled_auser_exists_obj->delete();
   
   unset($old_disabled_auser_exists_obj);
   
   $old_disabled_auser_exists_obj = new Auser();
   $old_disabled_auser_exists_obj->select("avail","N");
   $old_disabled_auser_exists_obj->where("mobile='$mobile'");
   if($old_disabled_auser_exists_obj->load()) $old_disabled_auser_exists_obj->delete();
   
   // 2.1 check if the IDN was already used
   $auser_exists_obj = new Auser();
   $auser_exists_obj->select("idn",$idn);
   $auser_exists_obj->select("idn_type_id",$idn_type_id);
   $auser_exists_obj->select("avail","Y");
   if($auser_exists_obj->load())
   {
       if($auser_exists_obj->getVal("mobile")==$mobile)
       {
            $auser_exists = AfwLanguageHelper::tarjemMessage("USER_EXISTS_SAME_IDN_SAME_MOBILE",$uri_module);;
       }
       else
       {
            $auser_exists_mobile = $auser_exists_obj->getVal("mobile");
            $mobile_last_3char = substr($auser_exists_mobile,strlen($auser_exists_mobile)-3);
            $auser_exists = AfwLanguageHelper::tarjemMessage("USER_EXISTS_SAME_IDN_WITH_MOBILE_ENDS_BY",$uri_module) . " ***$mobile_last_3char";
       }
       
   }
   else
   {
       // 2.1 check if the mobile was already used
       unset($auser_exists_obj);
       $auser_exists_obj = new Auser();
       $auser_exists_obj->select("mobile",$mobile);
       $auser_exists_obj->select("avail","Y");
       if($auser_exists_obj->load())
       {
            $auser_error = AfwLanguageHelper::tarjemMessage("USER_MOBILE_EXISTS",$uri_module);
       }
       else
       {
            // create user not activated 
            $auser = new Auser();
            $auser->set("avail","N");
            $auser->set("idn",$idn);
            $auser->set("idn_type_id",$idn_type_id);
            $auser->set("genre_id",$gender);
            $auser->set("mobile",$mobile);
            $auser->set("firstname",$first_name);
            $auser->set("lastname",$last_name);
            $user_pwd_crypted = md5($pwd1);
            $auser->set("pwd",$user_pwd_crypted);
            $mobile_activation_id = rand(1000,9999);
            $auser->set("mobile_activation_id",$mobile_activation_id);
            $auser->set("valide_mobile","W");
            $auser->insert();
            
            // @todo : send SMS to mobile with mobile_activation_id
            $iam_super_admin = true;
            $sms_sending_success = false;
            if($sms_sending_success)
            {
                AfwSession::pushSuccess(AfwLanguageHelper::tarjemMessage("SMS_SENT_TO_MOBILE",$uri_module)." $mobile");
            }
            else
            {
                AfwSession::pushWarning(AfwLanguageHelper::tarjemMessage("SMS_COULDNT_BE_SENT_TO_MOBILE",$uri_module)." $mobile ");
            }
            
            if($iam_super_admin) 
            {
                AfwSession::pushWarning(AfwLanguageHelper::tarjemMessage("MOBILE_ACTIVATION_ID",$uri_module) . " : ". $mobile_activation_id);
            }       
       }
   
   }
   
    if($auser_error or $auser_exists)
    {
        AfwSession::pushError($auser_error);
        AfwSession::pushInformation($auser_exists);
        include("$file_dir_name/../$uri_module/login.php");
    }
    elseif($auser)
    {
        include("$file_dir_name/../lib/hzm/web/hzm_header.php");
        include("$file_dir_name/../$uri_module/register_step1.php");
        include("$file_dir_name/../pag/footer.php");
    }
    else die("Error can not create user but error unknown"); // should never come here
}
elseif($next_step==2)
{
    $auser = new Auser();
    if($auser->load($auser_id))
    {
        if(($auser->getVal("mobile_activation_id") == $mobile_activation_id))
        {
            if($auser->getVal("avail") == "N")
            {
                    $auser->set("avail","Y");
                    $auser->set("valide_mobile","Y");
                    $auser->update();
            }
            
            AfwSession::setSessionVar("user_id", $auser->getId());
            
            if(!$objme) $objme = AfwSession::getUserConnected();
            if(!$me) $me = AfwSession::getSessionVar("user_id");
            
            AfwSession::pushSuccess(AfwLanguageHelper::tarjemMessage("ACCOUNT_ACTIVATED",$uri_module)." ($auser_id)");
        }
        else
        {
            AfwSession::pushError(AfwLanguageHelper::tarjemMessage("MOBILE_ACTIVATION_ID_ERRONED",$uri_module));
        }
    
    }
    else
    {
        AfwSession::pushError(AfwLanguageHelper::tarjemMessage("ACCOUNT_ID_NOT_FOUND",$uri_module)." $auser_id");
    }
    
    header("Location: index.php");
}

?>

<?
  
?>
