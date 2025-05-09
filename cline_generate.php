<?php

    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with restriction = [$restriction]");

    $command_on_what = $command_line_words[1];

    list($object_table, $object_module) = ClineUtils::parse_table_and_module($command_on_what);

    if(!$object_table)
    {
        // $command_line_result_arr[] = hzm_format_command_line("warning", "object table to generate is empty");
        if ($currmod) 
        {
            $object_module = "ums";
            $object_table = "module";
            $command_on_what = "module";
        }
        if ($currtbl_code) 
        {
            $object_module = "pag";
            $object_table = "atable";
            $command_on_what = "table";
        }
        if ($currfld) 
        {
            $object_module = "pag";
            $object_table = "afield";
            $command_on_what = "field";
        }        
    }
    $command_line_result_arr[] = hzm_format_command_line("warning", "doing on $command_on_what");


    $object_code = $command_line_words[2];
    if(!$object_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("warning", "definition of $object_table to generate is empty");
        // current context is used
        if($currmod) 
        {
            $object_code = $currmod;
            $command_line_result_arr[] = hzm_format_command_line("warning", "s1 > definition of $object_table to generate is set to $object_code");
        }
        if($currtbl_code and (($object_table == "atable") or ($object_table == "afield"))) 
        {
            if($object_code) $object_code = ".".$object_code;
            $object_code = $currtbl_code.$object_code;
            $command_line_result_arr[] = hzm_format_command_line("warning", "s2 > definition of $object_table to generate is set to $object_code");
        }
        if($currfld and ($object_table == "afield")) 
        {
            if($object_code) $object_code = ".".$object_code;
            $object_code = $currfld.$object_code;
            $command_line_result_arr[] = hzm_format_command_line("warning", "s3 > definition of $object_table to generate is set to $object_code");
        }
        
    }

    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code of $object_table.$object_module for ".$object_code);

    if(!$object_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the thing to generate !! try to see {help generate}");
        $nb_errors++;$command_finished = true;return;    
    }

    $object_code_arr = explode(".", $object_code);
    // $module_path = "$file_dir_name/../$object_module/models";

    if($object_table == "afield")
    {
        $module_code = $object_code_arr[2];
        $table_code = $object_code_arr[1];
        $field_code = $object_code_arr[0];

        if($module_code and $table_code and $field_code)
        {
            $objModule = Module::loadByMainIndex($module_code);
            $objTable = Atable::loadByMainIndex($objModule->id, $table_code);
            $objField = Afield::loadByMainIndex($objTable->id, $field_code);
        
            if($objField)
            {
                $command_line_result_arr[] = hzm_format_command_line("info", "generating SQL : ");
                $sql = $objField->calc("sql");
                $command_line_result_arr[] = hzm_format_command_line("sql", $sql, "en", "cline sql");
                $command_line_result_arr[] = hzm_format_command_line("info", "generating PHP-STRUCT : ");
                $php_att = $objField->calc("php_att");
                $command_line_result_arr[] = hzm_format_command_line("php", $php_att, "en", "cline php");
            }
            
        }
        elseif(!$module_code)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }
        elseif(!$table_code)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the table code !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }
        else
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the field code !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }

        
    }

    if($object_table == "atable")
    {
        $module_code = $object_code_arr[1];
        $table_code = $object_code_arr[0];

        if($module_code and $table_code)
        {
            $objModule = Module::loadByMainIndex($module_code);
            /**
             * @var Atable $objTable
             */
            $objTable = Atable::loadByMainIndex($objModule->id, $table_code);
        
            if((!$restriction) or $restriction=="sql")
            {
                $command_line_result_arr[] = hzm_format_command_line("info", "generating SQL of $table_code: ");
                list($sqlTable, $sqlFKs) = $objTable->generateSQLStructure();
                $sql = $sqlTable . "\n\n\n -- FKs\n\n" . $sqlFKs;
                $command_line_result_arr[] = hzm_format_command_line("sql", $sql, "en", "cline sql");
            }

            $arr_cmd_lines = [];
            $mv_cmd_lines = [];
            
            if((!$restriction) or $restriction=="model")
            {
                $command_line_result_arr[] = hzm_format_command_line("info", "generating PHP-MODEL-CLASS $table_code.php: ");
                list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only=false, $dbstruct_outside=true);
                $php_code .= "\n\n\n// errors \n\n" . implode("\n",$phpErrors_arr);
                $php_code = "<"."?"."php \n".$php_code;
                $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline php");
                // generate file
                $fileName = $table_code . ".php";
                list($arr_cmd_lines["models"], $mv_cmd) = ClineUtils::generatePhpFile($module_code, $fileName, $php_code, "models");
                $mv_cmd_lines[] = $mv_cmd;
            }

            if((!$restriction) or $restriction=="struct")
            {
                $command_line_result_arr[] = hzm_format_command_line("info", "generating PHP-STRUCT-CLASS $table_code"."_afw_structure.php: ");
                list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only=true, $dbstruct_outside=true);
                $php_code .= "\n\n\n// errors \n\n" . implode("\n",$phpErrors_arr);
                $php_code = "<"."?"."php \n".$php_code;
                $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline struct php");
                $fileName = $table_code . "_afw_structure.php";
                list($arr_cmd_lines["struct"], $mv_cmd) = ClineUtils::generatePhpFile($module_code, $fileName, $php_code, "struct");
                $mv_cmd_lines[] = $mv_cmd;
            }

            if((!$restriction) or $restriction=="tr")
            {
                $command_line_result_arr[] = hzm_format_command_line("info", "generating TRANSLATION AR trad_ar_".$table_code.".php : ");
                $php_code_ar = $objTable->genereTranslation("ar");
                $command_line_result_arr[] = hzm_format_command_line("php", $php_code_ar, "ar", "cline tr ar php");
                $fileName = "trad_ar_".$table_code . ".php";
                list($arr_cmd_lines["tr-ar"], $mv_cmd) = ClineUtils::generatePhpFile($module_code, $fileName, $php_code_ar, "tr");
                $mv_cmd_lines[] = $mv_cmd;

                $command_line_result_arr[] = hzm_format_command_line("info", "generating TRANSLATION EN trad_en_".$table_code.".php : ");
                $php_code_en = $objTable->genereTranslation("en");
                $command_line_result_arr[] = hzm_format_command_line("php", $php_code_en, "en", "cline tr en php");
                $fileName = "trad_en_".$table_code . ".php";
                list($arr_cmd_lines["tr-en"], $mv_cmd) = ClineUtils::generatePhpFile($module_code, $fileName, $php_code_en, "tr");
                $mv_cmd_lines[] = $mv_cmd;
            }

            $all_cmd_mv_lines = implode("\n", $mv_cmd_lines);
            $command_line_result_arr[] = hzm_format_command_line("info", "generating mv-commands : ");
            $command_line_result_arr[] = hzm_format_command_line("cmd", $all_cmd_mv_lines, "en", "cline cmd");
        }
        elseif(!$module_code)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }
        else
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the table code !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }
    }

    if($object_table == "module")
    {
        include("cline_gen_module.php");
    }

    $command_done = true;
    $command_finished = true;