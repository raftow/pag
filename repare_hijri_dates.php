<?php
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);


 
if(!$action_page) $action_page = "login.php";

$logbl = substr(md5($_SERVER["HTTP_USER_AGENT"] . "-" . date("Y-m-d")),0,10);


if(!$lang) $lang = "ar";
$module_dir_name = $file_dir_name;
require_once("$file_dir_name/../lib/afw/afw_autoloader.php");
$uri_module = AfwUrlManager::currentURIModule();       

require_once("$file_dir_name/../$uri_module/ini.php");
require_once("$file_dir_name/../$uri_module/module_config.php");

include_once ("$file_dir_name/../$uri_module/application_config.php");
AfwSession::initConfig($config_arr);
AfwSession::startSession();

require_once ("$file_dir_name/../external/db.php");

include("$file_dir_name/../lib/hzm/web/hzm_header.php");

if($_POST["datelist"])
{
   $datelist = $_POST["datelist"];
   $datelist_arr = explode("\n",$datelist);
   
   $liclist = $_POST["liclist"];
   $liclist_arr = explode("\n",$liclist);
   
   
   $corsnolist = $_POST["corsnolist"];
   $corsnolist_arr = explode("\n",$corsnolist);
   
   $results = "";

   $field_name = $_POST["field_name"];
   // if(!$field_name) $field_name = "start_date";
   
   foreach($datelist_arr as $i => $dateItem)
   {
      $dateItemRepared = AfwDateHelper::repareGorbojHijriDate($dateItem,false);
      $cors_no = trim($corsnolist_arr[$i]); 
      $license = trim($liclist_arr[$i]);

      if($dateItemRepared and $cors_no and $license)
      {
           $results .= "update cors_tatwer set $field_name = '$dateItemRepared' where cors_no = $cors_no and license = $license; \n";
      }
      
   }
}
else 
{
   // $field_name = "start_date";
   $results = "";
}
?>


      <form action='repare_hijri_dates.php' method='POST'>
         <input type="TEXT" name="field_name" value="<?php echo $_POST["field_name"]; ?>">
         <table>
            <tr>
               <th>
                        date list
               </th>

               <th>
                        licence list
               </th>

               <th>
                        corsno list
               </th>
            </tr>
            <tr>
               <td>
                        <textarea name='datelist' rows='30' cols='16'><?php echo $_POST["datelist"]; ?> </textarea>
               </td>

               <td>
                        <textarea name='liclist' rows='30' cols='16'><?php echo $_POST["liclist"]; ?> </textarea>
               </td>

               <td>
                        <textarea name='corsnolist' rows='30' cols='16'><?php echo $_POST["corsnolist"]; ?> </textarea>
               </td>
            </tr>
         <table>
        <input type='submit' value='run'>
      </form>
        
        <hr>
        <textarea direction='ltr' style='direction:ltr;text-align:left' name='results' rows='140' cols='160'>
        <?php 
        echo $results
        ?>
        </textarea>
<?php

?>