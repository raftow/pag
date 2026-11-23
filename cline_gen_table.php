<?php
/**
 * @var array $object_code_arr
 * @var array $generation_arr
 * @var array $command_line_result_arr
 * @var string $object_code
 */
$module_code = $object_code_arr[1];
$table_code = $object_code_arr[0];

$html_display_arr = [];
$group_label_arr = [];

$html_display_arr['generation'] =  implode("<br>\n", $command_line_result_arr);
$command_line_result_arr = [];
$html_display_arr['generation'] .=  implode("<br>\n", $generation_arr);
$group_label_arr['generation'] =  "Generation details";



$html_display_arr['commands'] =  "";
$group_label_arr['commands'] =  "System commands list";

if ($module_code and $table_code) {
    $objModule = Module::loadByMainIndex($module_code);
    /**
     * @var Atable $objTable
     */
    $objTable = Atable::loadByMainIndex($objModule->id, $table_code);



    if ((!$restriction) or $restriction == "sql") {
        $html_display_arr['sql'] =  "";
        $group_label_arr['sql'] =  "SQL Queries";
        $html_display_arr['sql'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating SQL of $table_code: ");
        list($sqlTable, $sqlFKs) = $objTable->generateSQLStructure();
        $sql = $sqlTable . "\n\n\n -- FKs\n\n" . $sqlFKs;
        $html_display_arr['sql'] .= "<br>\n" . UfwUtils::hzm_format_command_line("sql", $sql, "en", "cline sql");
    }

    $arr_cmd_lines = [];
    $mv_cmd_lines = [];



    if ((!$restriction) or $restriction == "model") {
        $html_display_arr['model'] =  "";
        $group_label_arr['model'] =  "Php model source code";
        $html_display_arr['model'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating PHP-MODEL-CLASS $table_code.php: ");
        list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only = false, $dbstruct_outside = true);
        $php_code .= "\n\n\n// errors \n\n" . implode("\n", $phpErrors_arr);
        $php_code = "<" . "?" . "php \n" . $php_code;
        $html_display_arr['model'] .= "<br>\n" . UfwUtils::hzm_format_command_line("php", $php_code, "en", "cline php");
        // generate file
        $fileName = $table_code . ".php";
        list($arr_cmd_lines["models"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code, "models");
        $mv_cmd_lines[] = $mv_cmd;
    }

    if ((!$restriction) or $restriction == "struct") {
        $html_display_arr['struct'] =  "";
        $group_label_arr['struct'] =  "Php structure source code";
        $html_display_arr['struct'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating PHP-STRUCT-CLASS $table_code" . "_afw_structure.php: ");
        list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only = true, $dbstruct_outside = true);
        $php_code .= "\n\n\n// errors \n\n" . implode("\n", $phpErrors_arr);
        $php_code = "<" . "?" . "php \n" . $php_code;
        $html_display_arr['struct'] .= "<br>\n" . UfwUtils::hzm_format_command_line("php", $php_code, "en", "cline struct php");
        $fileName = $table_code . "_afw_structure.php";
        list($arr_cmd_lines["struct"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code, "struct");
        $mv_cmd_lines[] = $mv_cmd;
    }

    if ((!$restriction) or $restriction == "previleges") {
        $html_display_arr['previleges'] =  "";
        $group_label_arr['previleges'] =  "Php previleges source code";
        $html_display_arr['previleges'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating previleges for $table_code : ");
        list($tbf_info_item, $tab_info_item, $fileName, $php_code, $mv_cmd) = UmsManager::genereTablePrevilegesFile($module_code, $objTable, true);
        $html_display_arr['previleges'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generated : $fileName : ");
        $html_display_arr['previleges'] .= "<br>\n" . UfwUtils::hzm_format_command_line("php", $php_code, "en", "cline previleges php");
        $mv_cmd_lines[] = $mv_cmd;
    }

    if ((!$restriction) or $restriction == "tr") {
        $html_display_arr['tr-ar'] =  "";
        $group_label_arr['tr-ar'] =  "Php Arabic Translation source code";
        $html_display_arr['tr-ar'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating TRANSLATION AR trad_ar_" . $table_code . ".php : ");
        $php_code_ar = $objTable->genereTranslation("ar");
        $html_display_arr['tr-ar'] .= "<br>\n" . UfwUtils::hzm_format_command_line("php", $php_code_ar, "ar", "cline tr ar php");
        $fileName = "trad_ar_" . $table_code . ".php";
        list($arr_cmd_lines["tr-ar"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code_ar, "tr");
        $mv_cmd_lines[] = $mv_cmd;

        $html_display_arr['tr-en'] =  "";
        $group_label_arr['tr-en'] =  "Php English Translation source code";
        $html_display_arr['tr-en'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating TRANSLATION EN trad_en_" . $table_code . ".php : ");
        $php_code_en = $objTable->genereTranslation("en");
        $html_display_arr['tr-en'] .= "<br>\n" . UfwUtils::hzm_format_command_line("php", $php_code_en, "en", "cline tr en php");
        $fileName = "trad_en_" . $table_code . ".php";
        list($arr_cmd_lines["tr-en"], $mv_cmd) = AfwCodeHelper::generatePhpFile($module_code, $fileName, $php_code_en, "tr");
        $mv_cmd_lines[] = $mv_cmd;
    }

    $all_cmd_mv_lines = implode("\n", $mv_cmd_lines);
    $html_display_arr['commands'] .= "<br>\n" . UfwUtils::hzm_format_command_line("info", "generating mv-commands : ");
    $html_display_arr['commands'] .= "<br>\n" . UfwUtils::hzm_format_command_line("cmd", $all_cmd_mv_lines, "en", "cline cmd");
} elseif (!$module_code) {
    $html_display_arr['commands'] .= "<br>\n" . UfwUtils::hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
} else {
    $html_display_arr['commands'] .= "<br>\n" . UfwUtils::hzm_format_command_line("error", "generate command need the table code !! object_code=$object_code");
    $nb_errors++;
    $command_finished = true;
}


$generation_html = AfwHtmlHelper::genereHtmlTabs("generate-table", $html_display_arr, $group_label_arr);
