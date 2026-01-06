<?php
$module_code = $object_code_arr[1];
$table_code = $object_code_arr[0];

if ($module_code and $table_code) {
    $objModule = Module::loadByMainIndex($module_code);
    /**
     * @var Atable $objTable
     */
    $objTable = Atable::loadByMainIndex($objModule->id, $table_code);

    if ((!$restriction) or $restriction == "sql") {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating SQL of $table_code: ");
        list($sqlTable, $sqlFKs) = $objTable->generateSQLStructure();
        $sql = $sqlTable . "\n\n\n -- FKs\n\n" . $sqlFKs;
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("sql", $sql, "en", "cline sql");
    }

    $arr_cmd_lines = [];
    $mv_cmd_lines = [];

    if ((!$restriction) or $restriction == "model") {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating PHP-MODEL-CLASS $table_code.php: ");
        list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only = false, $dbstruct_outside = true);
        $php_code .= "\n\n\n// errors \n\n" . implode("\n", $phpErrors_arr);
        $php_code = "<" . "?" . "php \n" . $php_code;
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_code, "en", "cline php");
        // generate file
        $fileName = $table_code . ".php";
        list($arr_cmd_lines["models"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code, "models");
        $mv_cmd_lines[] = $mv_cmd;
    }

    if ((!$restriction) or $restriction == "struct") {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating PHP-STRUCT-CLASS $table_code" . "_afw_structure.php: ");
        list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only = true, $dbstruct_outside = true);
        $php_code .= "\n\n\n// errors \n\n" . implode("\n", $phpErrors_arr);
        $php_code = "<" . "?" . "php \n" . $php_code;
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_code, "en", "cline struct php");
        $fileName = $table_code . "_afw_structure.php";
        list($arr_cmd_lines["struct"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code, "struct");
        $mv_cmd_lines[] = $mv_cmd;
    }

    if ((!$restriction) or $restriction == "previleges") {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating previleges for $table_code : ");
        list($tbf_info_item, $tab_info_item, $fileName, $php_code, $mv_cmd) = UmsManager::genereTablePrevilegesFile($module_code, $objTable, true);
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generated : $fileName : ");
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_code, "en", "cline previleges php");
        $mv_cmd_lines[] = $mv_cmd;
    }

    if ((!$restriction) or $restriction == "tr") {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating TRANSLATION AR trad_ar_" . $table_code . ".php : ");
        $php_code_ar = $objTable->genereTranslation("ar");
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_code_ar, "ar", "cline tr ar php");
        $fileName = "trad_ar_" . $table_code . ".php";
        list($arr_cmd_lines["tr-ar"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code_ar, "tr");
        $mv_cmd_lines[] = $mv_cmd;

        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating TRANSLATION EN trad_en_" . $table_code . ".php : ");
        $php_code_en = $objTable->genereTranslation("en");
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("php", $php_code_en, "en", "cline tr en php");
        $fileName = "trad_en_" . $table_code . ".php";
        list($arr_cmd_lines["tr-en"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code_en, "tr");
        $mv_cmd_lines[] = $mv_cmd;
    }

    $all_cmd_mv_lines = implode("\n", $mv_cmd_lines);
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "generating mv-commands : ");
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("cmd", $all_cmd_mv_lines, "en", "cline cmd");
} elseif (!$module_code) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
    return;
} else {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "generate command need the table code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
    return;
}
