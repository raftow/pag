<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with params ".var_export($command_line_words, true));
    // ex find module all like app
    list($object_class_file, $object_module) = parse_table_and_module($command_line_words[1]);
    $filter_method = $command_line_words[2];
    $find_method = $command_line_words[3];
    $find_param = $command_line_words[4];
    $objMain = null;
    $module_path = "$file_dir_name/../$object_module/models";
    if(file_exists("$module_path/$object_class_file.php"))
    {
            require_once("$module_path/$object_class_file.php");
            $object_class = AfwStringHelper::tableToClass($object_class_file);
            
            $objMain = new $object_class();
    }
    else
    {
            $command_line_result_arr[] = hzm_format_command_line("error", "please check that the $object_class_file.php file exists in $object_module module path '$module_path'");$nb_errors++;
    }


    if($objMain)
    {
            $words = $find_param;
            if($filter_method != "all")
            {
                $objMain->applyFilter($filter_method);
            }
            if($find_method=="like") $liste_obj = AfwFrameworkHelper::qfind($objMain,$words);
            $command_code = "retrieve";
    }