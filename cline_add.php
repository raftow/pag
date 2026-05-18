<?php

/**
 * @var string $currmod
 * @var string $currfld
 * @var string $currtbl_code
 * @var string $command_code_option
 * @var string $command_line
 * @var array $command_line_words
 */

if (!isset($restriction)) {
    $restriction = "";
}

$restriction_desc = $restriction ? "with restriction = [$restriction]" : "without restriction";

// hzm_start_immediate_output();
$command_line_result_arr[] = UfwUtils::hzm_format_command_line("info", "doing $command_code $restriction_desc on " . $command_line_words[1]);
$addByCodeArr = array();
$otherSettingsMandatory = array();
$addByCodeArr["module"] = true;
$addByCodeArr["atable"] = true;
$addByCodeArr["afield"] = true;
$addByCodeArr["goal"] = true;
$otherSettingsMandatory["goal"] = true;
$addByCodeArr["arole"] = true;

$pag_dir_name = dirname(__FILE__);

$what_to_add = $command_line_words[1];

list($object_table, $object_module) = ClineUtils::parse_table_and_module($what_to_add);
// die("log rafik : ($object_table, $object_module) = ClineUtils::parse_table_and_module($what_to_add);");
/*
if (!$object_table) {
    if ($currmod) {
        $object_module = "ums";
        $object_table = "module";
    }
    if ($currtbl_code) {
        $object_module = "pag";
        $object_table = "atable";
    }
    if ($currfld) {
        $object_module = "pag";
        $object_table = "afield";
    }
}*/



$object_code = $command_line_words[2];
$object_code_nb_parts = count(explode(".", $object_code));




if ($object_table == "module") {
    $nb_parts_needed = 1;
} elseif ($object_table == "atable") {
    $nb_parts_needed = 2;
} elseif ($object_table == "afield") {
    $nb_parts_needed = 3;
} elseif ($object_table == "arole") {
    $nb_parts_needed = 3;
} elseif ($object_table == "goal") {
    $nb_parts_needed = 2;
}

$nb_parts_missed = $nb_parts_needed - $object_code_nb_parts;

$object_code_before = $object_code;




if ($nb_parts_missed == 1) {
    $object_code .= "." . $currmod;
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("warning", "object code miss 1 element will be the current module");
}

if ($nb_parts_missed == 2) {
    $object_code .= "." . $currtbl_code;
    $object_code .= "." . $currmod;
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("warning", "object code miss 2 elements will be the current module and table");
}

// die("object_code=$object_code object_code_before=$object_code_before");

if (!$object_code) {
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "add command need the thing to add !! try to see {help add}");
    $nb_errors++;
    $command_finished = true;
    return;
}

$object_code_arr = explode(".", $object_code);


$object_name_ar = $command_line_words[3];
$object_title_ar = $command_line_words[4];
if ($object_title_ar == '-') $object_title_ar = $object_name_ar;
if ($object_name_ar == '-') $object_name_ar = $object_title_ar;

$object_name_en = $command_line_words[5];
$object_title_en = $command_line_words[6];
$other_settings = $command_line_words[7];

if (!$object_name_ar) {
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "add command need the object_name_ar to add !! try to see {help add}");
    $nb_errors++;
    $command_finished = true;
    return;
}

if (!$object_name_en) {
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "add command need the object_name_en to add !! try to see {help add}");
    $nb_errors++;
    $command_finished = true;
    return;
}

if (!$other_settings and $otherSettingsMandatory[$object_table]) {
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "add command require the other_settings for this type of add : $object_table");
    $nb_errors++;
    $command_finished = true;
    return;
}


if ($object_title_en == '-') $object_title_en = $object_name_en;
if ($object_name_en == '-') $object_name_en = $object_title_en;

$object_name_en = str_replace("-", " ", $object_name_en);
$object_name_ar = str_replace("-", " ", $object_name_ar);

$object_title_en = str_replace("-", " ", $object_title_en);
$object_title_ar = str_replace("-", " ", $object_title_ar);


$module_path = "$pag_dir_name/../$object_module/models";
if (file_exists("$module_path/$object_table.php")) {
    AfwAutoLoader::addModule($object_module);

    $object_class = AfwStringHelper::tableToClass($object_table);




    if ($object_code) {
        if ($addByCodeArr[$object_table]) {
            if ((!$object_code_arr[1]) or (!$object_code_arr[0]))
                UfwUtils::dieWithVar("cline add analysis : ", [
                    'command_line_words' => $command_line_words,
                    'what_to_add' => $what_to_add,
                    'object_table' => $object_table,
                    'object_class' => $object_class,
                    'object_module' => $object_module,
                    'object_code' => $object_code,
                    'object_code_nb_parts' => $object_code_nb_parts,
                    'object_code_arr' => $object_code_arr,
                    'object_name_en' => $object_name_en,
                    'object_name_ar' => $object_name_ar,
                    'object_title_en' => $object_title_en,
                    'object_title_ar' => $object_title_ar,
                ]);
            // UfwUtils::dieWithVar("will call $object_class::addByCodes on object_code_arr : ", $object_code_arr);/**/
            $update_if_exists = (true or ($restriction == "update"));
            list($objToShow, $message, $error, $warning) = $object_class::addByCodes($object_code_arr, $object_name_en, $object_name_ar, $object_title_en, $object_title_ar, $other_settings, $update_if_exists, $command_code_option, $command_line . "[object_code=$object_code before=$object_code_before]");
            if ($warning) $message_arr[] = 'with warning : ' . $warning;
            if ($error) $message_arr[] = 'with error : ' . $error;
            
        } else {
            $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "add $object_class by code still not implemented in Momken framework comand line");
            $nb_errors++;
            $command_finished = true;
            return;
        }
    }
    /*
          if($object_id)
          {
                  $objToShow = $object_class::loadById($object_id); 
          }*/
} else {
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "Error 0005 when adding. Please check that the file '$object_table.php' file exists in module path '$module_path'");
    $nb_errors++;
    $command_finished = true;
    return;
}

if ($object_table == "module") {
    include("cline_add_module.php");
}


if (!$objToShow) {
    $command_line_result_arr[] = UfwUtils::hzm_format_command_line("error", "Error 0001 add $object_class by code failed with message $message");
    $nb_errors++;
    $command_finished = true;
    return;
} else {
    $messages_arr = explode("<br>\n", $message);
    foreach ($messages_arr as $message_item) {
        $typeMess = "success";
        if (AfwStringHelper::stringStartsWith($message_item, "Warning")) $typeMess = "warning";
        if (AfwStringHelper::stringStartsWith($message_item, "Error")) $typeMess = "error";
        $command_line_result_arr[] = UfwUtils::hzm_format_command_line($typeMess, $message_item);
    }

    if ($object_table == "afield") {
        $command_code = "curr_fld";
        $command_line_words[1] = $object_code_arr[0] . "." . $object_code_arr[1] . "." . $object_code_arr[2];
        unset($command_line_words[2]);
    } elseif ($object_table == "atable") {
        $command_code = "curr_tbl";
        $command_line_words[1] = $object_code_arr[0] . "." . $object_code_arr[1];
        unset($command_line_words[2]);
    } elseif ($object_table == "module") {
        $command_code = "curr_mod";
        $command_line_words[1] = $object_code_arr[0];
        unset($command_line_words[2]);
    } elseif ($object_table == "goal") {
        $command_code = $command_line_words[0] = "list";
        $command_line_words[1] = "all";
        $command_line_words[2] = "goals";
    } else {
        $command_code = "";
    }



    unset($command_line_words[3]);
    unset($command_line_words[4]);
    unset($command_line_words[5]);
}



if (!$command_code) $command_finished = true;
