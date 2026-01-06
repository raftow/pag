<?php

// hzm_start_immediate_output();
$command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "doing $command_code on " . $command_line_words[1]);
$addByCodeArr = array();
$addByCodeArr["module"] = true;
$addByCodeArr["atable"] = true;
$addByCodeArr["afield"] = true;
$addByCodeArr["goal"] = true;


$what_to_add = $command_line_words[1];

list($object_table, $object_module) = ClineUtils::parse_table_and_module($what_to_add);
// die("log rafik : ($object_table, $object_module) = ClineUtils::parse_table_and_module($what_to_add);");
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
}




$object_code = $command_line_words[2];
$object_code_nb_parts = count(explode(".", $object_code));

if ($object_table == "module") {
    $nb_parts_needed = 1;
} elseif ($object_table == "atable") {
    $nb_parts_needed = 2;
} elseif ($object_table == "afield") {
    $nb_parts_needed = 3;
}

$nb_parts_missed = $nb_parts_needed - $object_code_nb_parts;

$object_code_before = $object_code;

if ($nb_parts_missed == 1) {
    $object_code .= "." . $currmod;
}

if ($nb_parts_missed == 2) {
    $object_code .= "." . $currtbl_code;
    $object_code .= "." . $currmod;
}

// die("object_code=$object_code object_code_before=$object_code_before");

if (!$object_code) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "add command need the thing to add !! try to see {help add}");
    $nb_errors++;
    $command_finished = true;
    return;
}

$object_code_arr = explode(".", $object_code);

$object_name_ar = $command_line_words[3];
$object_title_ar = $command_line_words[4];
if ($object_title_ar == '-') $object_title_ar = $object_name_ar;

$object_name_en = $command_line_words[5];
$object_title_en = $command_line_words[6];
if ($object_title_en == '-') $object_title_en = $object_name_en;

$object_name_en = str_replace("-", " ", $object_name_en);
$object_name_ar = str_replace("-", " ", $object_name_ar);

$object_title_en = str_replace("-", " ", $object_title_en);
$object_title_ar = str_replace("-", " ", $object_title_ar);


$module_path = "$file_dir_name/../$object_module/models";
if (file_exists("$module_path/$object_table.php")) {
    AfwAutoLoader::addModule($object_module);

    $object_class = AfwStringHelper::tableToClass($object_table);

    if ($object_code) {
        if ($addByCodeArr[$object_table]) {
            [$objToShow, $message] = $object_class::addByCodes($object_code_arr, $object_name_en, $object_name_ar, $object_title_en, $object_title_ar, false, $command_code_option);
        } else {
            $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "add $object_class by code still not implemented in Momken framework comand line");
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
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "Error 0005 when adding. Please check that the file '$object_table.php' file exists in module path '$module_path'");
    $nb_errors++;
    $command_finished = true;
    return;
}

if ($object_table == "module") {
    include("cline_add_module.php");
}


if (!$objToShow) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "Error 0001 add $object_class by code failed with message $message");
    $nb_errors++;
    $command_finished = true;
    return;
} else {
    $messages_arr = explode("<br>\n", $message);
    foreach ($messages_arr as $message_item) {
        $typeMess = "success";
        if (AfwStringHelper::stringStartsWith($message_item, "Warning")) $typeMess = "warning";
        if (AfwStringHelper::stringStartsWith($message_item, "Error")) $typeMess = "error";
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line($typeMess, $message_item);
    }

    if (count($object_code_arr) == 3) {
        $command_code = "curr_fld";
        $command_line_words[1] = $object_code_arr[0] . "." . $object_code_arr[1] . "." . $object_code_arr[2];
    }

    if (count($object_code_arr) == 2) {
        $command_code = "curr_tbl";
        $command_line_words[1] = $object_code_arr[0] . "." . $object_code_arr[1];
    }

    if (count($object_code_arr) == 1) {
        $command_code = "curr_mod";
        $command_line_words[1] = $object_code_arr[0];
    }


    unset($command_line_words[2]);
    unset($command_line_words[3]);
    unset($command_line_words[4]);
    unset($command_line_words[5]);
}



if (!$command_code) $command_finished = true;
