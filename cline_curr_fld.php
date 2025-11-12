<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);
    AfwLoadHelper::noCacheManagement("Module");
    AfwLoadHelper::noCacheManagement("Atable");
    AfwLoadHelper::noCacheManagement("Afield");
    
    list($field_name, $atable_name, $module_code) = explode(".",$command_line_words[1]);
    if(!$field_name) $field_name = $currfld;
    if(!$atable_name) $atable_name = $currtbl_code;
    if(!$module_code) $module_code = $currmod;
    if(!$field_name)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "no field specified");
        $nb_errors++;$command_finished = true;return;
    }
    elseif(!$atable_name)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "no table specified and current table not set (use curt command");
        $nb_errors++;$command_finished = true;return;
    }
    elseif(!$module_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "no module specified and current module not set (use curr command)");
        $nb_errors++;$command_finished = true;return;
    }
    else
    {
        $objModule = Module::getModuleByCode(0, $module_code);
        if(!$objModule)
        {
                $command_line_result_arr[] = hzm_format_command_line("error", "failed to load module with code = $module_code");
                $nb_errors++;$command_finished = true;return;
        }
        else
        {
                $idMod = $objModule->getId();            
                $objAtable = Atable::loadByMainIndex($idMod, $atable_name);
                if($objAtable and (!$objAtable->isEmpty()))
                {
                    $idTab = $objAtable->getId();
                    $objAfield = Afield::loadByMainIndex($idTab, $field_name);
                    if($objAfield and (!$objAfield->isEmpty()))
                    {
                        $currfld = $field_name;
                        $currfld_id = $objAfield->id;
                        $command_line_result_arr[] = hzm_format_command_line("info", "current field changed to $field_name");
                        $command_line_result_arr[] = hzm_format_command_line("success", "to genere sql use genere command see {help genere}", $lang);
                    }
                    else
                    {
                        $command_line_result_arr[] = hzm_format_command_line("error", "failed to load field $field_name from module = $module_code (id=$idMod), table = $atable_name (id=$idTab)");
                        $nb_errors++;$command_finished = true;return;
                    }

                    
                }
                else
                {
                    $command_line_result_arr[] = hzm_format_command_line("error", "table $atable_name not found in module $module_code");
                    $nb_errors++;$command_finished = true;return;
                }
        }
    }

    if($atable_name != $currtbl_code)
    {
            $command_code = "curr_tbl";
            $command_line_words[1] = $atable_name.".".$module_code;
    }
    else
    {
            // may be the module is not the current make it the current
            $command_code = "curr_mod";
            $command_line_words[1] = $module_code;
    }

    unset($command_line_words[2]);
    unset($command_line_words[3]);
    unset($command_line_words[4]);
    unset($command_line_words[5]);