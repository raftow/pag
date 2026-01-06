<?php
$module_code = $object_code_arr[2];
$table_code = $object_code_arr[1];
$field_code = $object_code_arr[0];

if ($module_code and $table_code and $field_code) {
    $objModule = Module::loadByMainIndex($module_code);
    $objTable = Atable::loadByMainIndex($objModule->id, $table_code);
    $objField = Afield::loadByMainIndex($objTable->id, $field_code);

    if ($objField) {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating SQL : ");
        $sql = $objField->calc("sql");
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("sql", $sql, "en", "cline sql");
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating PHP-STRUCT : ");
        $php_att = $objField->calc("php_att");
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_att, "en", "cline php");
    }
} elseif (!$module_code) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
    return;
} elseif (!$table_code) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the table code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
    return;
} else {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the field code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
    return;
}
