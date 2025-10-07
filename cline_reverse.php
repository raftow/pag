<?php

// hzm_start_immediate_output();
$command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);
$reverseByCodeArr = array();
$reverseByCodeArr["module"] = true;
$reverseByCodeArr["atable"] = true;
$reverseByCodeArr["afield"] = true;



$what_to_reverse = $command_line_words[1];

list($object_table, $object_module) = ClineUtils::parse_table_and_module($what_to_reverse);
// die("log rafik : ($object_table, $object_module) = ClineUtils::parse_table_and_module($what_to_reverse);");
if(!$object_table)
{
    if ($currmod) 
    {
        $object_module = "ums";
        $object_table = "module";
    }
    if ($currtbl_code) 
    {
        $object_module = "pag";
        $object_table = "atable";
    }
    if ($currfld) 
    {
        $object_module = "pag";
        $object_table = "afield";
    }
}


$object_code = $command_line_words[2];
if(!$object_code)
{
    // current context is used
    if($currmod) 
    {
        $object_code = $currmod;
    }
    if(($currtbl_code) and ($object_table != "module")) 
    {
        if($object_code) $object_code = ".".$object_code;
        $object_code = $currtbl_code.$object_code;
    }
    if($currfld and ($object_table == "afield"))  
    {
        if($object_code) $object_code = ".".$object_code;
        $object_code = $currfld.$object_code;
    }
}

if(!$object_code)
{
    $command_line_result_arr[] = hzm_format_command_line("error", "reverse command need the thing to reverse !! try to see {help reverse}");
    $nb_errors++;$command_finished = true;return;    
}

$object_code_arr = explode(".", $object_code);


$module_path = "$file_dir_name/../$object_module/models";
if (file_exists("$module_path/$object_table.php")) {
    AfwAutoLoader::addModule($object_module);

    include_once ("$file_dir_name/../$object_module/application_config.php");
    AfwSession::initConfig($config_arr, "system", "$file_dir_name/../$object_module/application_config.php");

    $reversableByCodeArr = AfwSession::config("reversable_by_code_arr", []);
    foreach($reversableByCodeArr as $reversableByCode) $reverseByCodeArr[$reversableByCode] = true;

    $object_class = AfwStringHelper::tableToClass($object_table);

    if ($object_code) {
        if ($reverseByCodeArr[$object_table]) {            
            list($objToShow, $message) = $object_class::reverseByCodes($object_code_arr);
        } else {
            $command_line_result_arr[] = hzm_format_command_line("error", "reverse $object_class by code still not implemented in Momken framework comand line");
            $nb_errors++;$command_finished = true;return;
        }
    }
    /*
          if($object_id)
          {
                  $objToShow = $object_class::loadById($object_id); 
          }*/
} 
else 
{
    $command_line_result_arr[] = hzm_format_command_line("error", "Error 0005 when reversing. Please check that the file '$object_table.php' file exists in module path '$module_path'");
    $nb_errors++;$command_finished = true;return;
}
// hzm_stop_immediate_output();
if(!$objToShow)
{
    $command_line_result_arr[] = hzm_format_command_line("error", "Error 0001 reverse $object_class by code failed with message $message");
    $nb_errors++;$command_finished = true;return;
}
else
{
    $messages_arr = explode("<br>\n",$message);
    foreach($messages_arr as $message_item)
    {
        $typeMess = "success";
        if(AfwStringHelper::stringStartsWith($message_item, "Warning")) $typeMess = "warning";
        if(AfwStringHelper::stringStartsWith($message_item, "Error")) $typeMess = "error";
        $command_line_result_arr[] = hzm_format_command_line($typeMess, $message_item);
    }
    
    if(count($object_code_arr)==3) 
    {
        $command_code = "curr_fld";
        $command_line_words[1] = $object_code_arr[0].".".$object_code_arr[1].".".$object_code_arr[2];
    }
    
    if(count($object_code_arr)==2) 
    {
        $command_code = "curr_tbl";
        $command_line_words[1] = $object_code_arr[0].".".$object_code_arr[1];
    }

    if(count($object_code_arr)==1) 
    {
        $command_code = "curr_mod";
        $command_line_words[1] = $object_code_arr[0];
    }

    
    unset($command_line_words[2]);
    unset($command_line_words[3]);
    unset($command_line_words[4]);
    unset($command_line_words[5]);
}

if(!$command_code) $command_finished = true;
