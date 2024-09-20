<?php
    // clone @what @table[.@field] to @new-module[.@new-or-existing-table]
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);
    if(!$currmod)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "clone command need that you select the current module");
        $nb_errors++;$command_finished = true;return;
    }

    $command_what = $command_line_words[1];
    list($what_table, $what_module) = ClineUtils::parse_table_and_module($command_what);

    if(!$what_table)
    {
        $command_line_result_arr[] = hzm_format_command_line("warning", "object table to clone is empty");
        if ($currmod) 
        {
            $what_module = "ums";
            $what_table = "module";
        }
        if ($currtbl_code) 
        {
            $what_module = "pag";
            $what_table = "atable";
        }
        if ($currfld) 
        {
            $what_module = "pag";
            $what_table = "afield";
        }        
        $command_line_result_arr[] = hzm_format_command_line("warning", "the object-type to clone was empty and set = $what_module.$what_table");
    }
    else
    {
        $command_line_result_arr[] = hzm_format_command_line("info", "the object-type to clone is parsed as $what_module.$what_table");
    }
    


    $object_code = $command_line_words[2];
    

    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code of the ".$command_line_words[1]." : ".$object_code);

    if(!$object_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "clone command need the thing to clone !! try to see {help clone}");
        $nb_errors++;$command_finished = true;return;    
    }

    $object_code_arr = explode(".", $object_code);

    $action_clone_type = $command_line_words[3]; // = to or = simul-to for only simulating

    $new_object_code = $command_line_words[4];
    
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code into ".$new_object_code);

    if(!$new_object_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "clone command need the thing to clone into !! try to see {help clone}");
        $nb_errors++;$command_finished = true;return;    
    }

    $object_new_code_arr = explode(".", $new_object_code);
    
    // $module_path = "$file_dir_name/../$what_module/models";

    if(($what_table == "afield") or ($what_table == "atable"))
    {
        $table_code = $object_code_arr[0];
        $field_code = $object_code_arr[1];

        if($table_code and (($what_table != "afield") or $field_code))
        {
            $objModule = Module::loadByMainIndex($currmod);
            if(!$objModule)
            {
                $command_line_result_arr[] = hzm_format_command_line("error", "clone command need that you select a valid module as current module, $currmod not found");
                $nb_errors++;$command_finished = true;return;
            }
            else
            {
                $objModuleId = $objModule->id;
            }
        
            $objTable = Atable::loadByMainIndex($objModule->id, $table_code);
            if(!$objTable)
            {
                $command_line_result_arr[] = hzm_format_command_line("error", "clone command need a valid table name $table_code not found in module $currmod");
                $nb_errors++;$command_finished = true;return;
            }
            else
            {
                $objTableId = $objTable->id; 
            }
            $objField = null;
            if($objTableId and ($what_table == "afield") and $field_code)
            {
                $objField = Afield::loadByMainIndex($objTable->id, $field_code);
                if(!$objField)
                {
                    $command_line_result_arr[] = hzm_format_command_line("error", "clone command need a valid field name $table_code.$field_code not found in module $currmod");
                    $nb_errors++;$command_finished = true;return;
                }
                else $objFieldId = $objField->id;  
            }
        }
        elseif(!$table_code)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "clone command need the table name !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }
        else
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "clone command need the field name !! object_code=$object_code");
            $nb_errors++;$command_finished = true;return;
        }

        $module_new_code = $object_new_code_arr[0];
        $table_new_code = $object_new_code_arr[1];

        if($module_new_code and $table_new_code)
        {
            $objNewModule = Module::loadByMainIndex($module_new_code);
            if(!$objNewModule)
            {
                $command_line_result_arr[] = hzm_format_command_line("error", "clone command need that you select a the new module to clone into, $module_new_code not found");
                $nb_errors++;$command_finished = true;return;
            }
            else $objNewModuleId = $objNewModule->id;  

            $objNewTable = Atable::loadByMainIndex($objNewModule->id, $table_new_code);
            
            if((!$objNewTable) and ($what_table == "atable"))
            {
                $command_line_result_arr[] = hzm_format_command_line("info", "cloning from (m=$objModuleId t=$objTableId) to (m=$objNewModuleId t=$table_new_code to create)");
                list($objNewTable, $nb_fields_copied, $reason_fail) = $objTable->cloneMe($objNewModuleId,0,$table_new_code);
                if($objNewTable) $command_line_result_arr[] = hzm_format_command_line("success", "new table $table_new_code has been successfully created");
                else 
                {
                    $command_line_result_arr[] = hzm_format_command_line("error", "failed to create the new table $table_new_code reason : $reason_fail");
                    $nb_errors++;$command_finished = true;return;
                }
                $notification_of_fields_copied = "";
                if(!$nb_fields_copied)
                {
                    $command_line_result_arr[] = hzm_format_command_line("error", "No fields copied (nb_fields_copied=$nb_fields_copied)");
                    $nb_errors++;$command_finished = true;return;
                }
                else
                {
                    $command_line_result_arr[] = hzm_format_command_line("warning", "$nb_fields_copied fields copied");
                }
                
                
            }

            if(!$objNewTable)
            {
                $command_line_result_arr[] = hzm_format_command_line("error", "clone command need a valid new table object to clone into, $table_new_code not found in module $module_new_code");
                $nb_errors++;$command_finished = true;return;
            }
            else $objNewTableId = $objNewTable->id;
        
            
        }
        elseif(!$module_new_code)
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the new module code !! object_new_code=$object_new_code");
            $nb_errors++;$command_finished = true;return;
        }
        else
        {
            $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the new table name !! object_new_code=$object_new_code");
            $nb_errors++;$command_finished = true;return;
        }
        
        if($what_table == "afield")
        {
            $command_line_result_arr[] = hzm_format_command_line("info", "cloning from (m=$objModuleId t=$objTableId f=$objFieldId) to (m=$objNewModuleId t=$objNewTableId)");
        }

        
    }
    else
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "clone what ? !! what_table=$what_table");
        $nb_errors++;$command_finished = true;return;
    }
    

    

    $command_done = true;
    $command_finished = true;
