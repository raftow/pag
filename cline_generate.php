<?php

    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);

    list($object_table, $object_module) = parse_table_and_module($command_line_words[1]);

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
        if($currtbl_code and (($object_table == "atable") or ($object_table == "afield"))) 
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

    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code of ".$command_line_words[1]." for ".$object_code);

    if(!$object_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the thing to generate !! try to see {help generate}");
        $nb_errors++;$command_finished = true;return;    
    }

    $object_code_arr = explode(".", $object_code);
    $module_path = "$file_dir_name/../$object_module/models";

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
        
        
            $command_line_result_arr[] = hzm_format_command_line("info", "generating SQL : ");
            $sql = $objField->calc("sql");
            $command_line_result_arr[] = hzm_format_command_line("sql", $sql, "en", "cline sql");
            $command_line_result_arr[] = hzm_format_command_line("info", "generating PHP-STRUCT : ");
            $php_att = $objField->calc("php_att");
            $command_line_result_arr[] = hzm_format_command_line("php", $php_att, "en", "cline php");
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
            $objTable = Atable::loadByMainIndex($objModule->id, $table_code);
        
        
            $command_line_result_arr[] = hzm_format_command_line("info", "generating SQL : ");
            list($sqlTable, $sqlFKs) = $objTable->generateSQLStructure();
            $sql = $sqlTable . "\n\n\n -- FKs\n\n" . $sqlFKs;
            $command_line_result_arr[] = hzm_format_command_line("sql", $sql, "en", "cline sql");
            
            
            $command_line_result_arr[] = hzm_format_command_line("info", "generating PHP-MODEL-CLASS : ");
            list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only=false, $dbstruct_outside=true);
            $php_code .= "\n\n\n// errors \n\n" . implode("\n",$phpErrors_arr);
            $php_code = "<?php \n".$php_code;
            $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline php");


            $command_line_result_arr[] = hzm_format_command_line("info", "generating PHP-STRUCT-CLASS : ");
            list($php_code, $phpErrors_arr, $new_php_file) = $objTable->generatePhpClass($dbstruct_only=true, $dbstruct_outside=true);
            $php_code .= "\n\n\n// errors \n\n" . implode("\n",$phpErrors_arr);
            $php_code = "<?php \n".$php_code;
            $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline struct php");
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
    }

    $command_done = true;
    $command_finished = true;