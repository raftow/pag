<?php

$command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "doing $command_code with restriction = [$restriction]");

$command_on_what = $command_line_words[1];

list($object_table, $object_module) = ClineUtils::parse_table_and_module($command_on_what);

if (!$object_table) {
    // $command_line_result_arr[] = AfwUtils::hzm_format_command_line("warning", "object table to generate is empty");
    if ($currmod) {
        $object_module = "ums";
        $object_table = "module";
        $command_on_what = "module";
    }
    if ($currtbl_code) {
        $object_module = "pag";
        $object_table = "atable";
        $command_on_what = "table";
    }
    if ($currfld) {
        $object_module = "pag";
        $object_table = "afield";
        $command_on_what = "field";
    }
}
$command_line_result_arr[] = AfwUtils::hzm_format_command_line("warning", "doing on $command_on_what");


$object_code = $command_line_words[2];
if (!$object_code) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("warning", "definition of $object_table to generate is empty");
    // current context is used
    if ($currmod) {
        $object_code = $currmod;
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("warning", "s1 > definition of $object_table to generate is set to $object_code");
    }
    if ($currtbl_code and (($object_table == "atable") or ($object_table == "afield"))) {
        if ($object_code) $object_code = "." . $object_code;
        $object_code = $currtbl_code . $object_code;
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("warning", "s2 > definition of $object_table to generate is set to $object_code");
    }
    if ($currfld and ($object_table == "afield")) {
        if ($object_code) $object_code = "." . $object_code;
        $object_code = $currfld . $object_code;
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("warning", "s3 > definition of $object_table to generate is set to $object_code");
    }
}

$command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "doing $command_code of $object_table.$object_module for " . $object_code);

if (!$object_code) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the thing to generate !! try to see {help generate}");
    $nb_errors++;
    $command_finished = true;
    return;
}

$object_code_arr = explode(".", $object_code);
// $module_path = "$file_dir_name/../$object_module/models";

if ($object_table == "afield") {
}

if ($object_table == "atable") {
    include("cline_gen_table.php");
}

if ($object_table == "module") {
    include("cline_gen_module.php");
}

if ($object_table == "goal") {
    include("cline_gen_goal.php");
}

$command_done = true;
$command_finished = true;
