<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with params ".var_export($command_line_words, true));
    if(count($command_line_words)>3) 
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "command line $command_code does'nt need all these params, see help."); $nb_errors++;$command_finished = true;return;
        $command_mode = "";
    }    
    else $command_mode = $original_command_code;
    
    if($original_command_code=="show") $command_mode="SHOW";
    if($original_command_code=="view") $command_mode="RETRIEVE";
    if($original_command_code=="more") $command_mode="MINIBOX";
    
    if(!$command_mode)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "can't complete display command, template not found"); $nb_errors++;$command_finished = true;return;
    }
    
    list($object_table, $object_module) = ClineUtils::parse_table_and_module($command_line_words[1]);
    $object_codeOrId = $command_line_words[2];
    if(!$object_table)
    {
        // $command_line_result_arr[] = hzm_format_command_line("warning", "object table to generate is empty");
        if ($currmod) 
        {
            $object_module = "ums";
            $object_table = "module";
            $object_codeOrId = $currmod;
        }
        if ($currtbl_code) 
        {
            $object_module = "pag";
            $object_table = "atable";
            $object_codeOrId = "$currmod.$currtbl_code";
        }
        if ($currfld) 
        {
            $object_module = "pag";
            $object_table = "afield";
            $object_codeOrId = "$currmod.$currtbl_code.$currfld";
        }        
    }

    if(($object_table == "module") and (!$object_codeOrId)) $object_codeOrId = $currmod;
    if(($object_table == "atable") and (!$object_codeOrId)) $object_codeOrId = "$currmod.$currtbl_code";
    if(($object_table == "afield") and (!$object_codeOrId)) $object_codeOrId = "$currmod.$currtbl_code.$currfld";
    
    if(!$object_module) $object_module = $currmod;
    
    
    $object_code = is_numeric($object_codeOrId) ? "" : $object_codeOrId;
    $object_id   = is_numeric($object_codeOrId) ? intval($object_codeOrId) : "";
    
    $objToShow = null;
    if(file_exists("$file_dir_name/../$object_module/models/$object_table.php"))
    {
            require_once("$file_dir_name/../$object_module/models/$object_table.php");
            $object_class = AfwStringHelper::tableToClass($object_table);
            
            if($object_code and (!$object_id)) 
            {
                if(method_exists($object_class, "loadByCodes"))
                {
                        $object_code_arr = explode(".",$object_code);
                        $objToShow = $object_class::loadByCodes($object_code_arr);
                }
                else
                {
                        $command_line_result_arr[] = hzm_format_command_line("error", "load $object_class by code still not implemented in Momken framework comand line"); $nb_errors++;$command_finished = true;return;
                }
                
            }
            if($object_id)
            {
                $objToShow = $object_class::loadById($object_id); 
            }
    }
    else
    {
            $command_line_result_arr[] = hzm_format_command_line("error", "3.please check that class $object_table file exists in module '$object_module'"); $nb_errors++;$command_finished = true;return;
    }
    /**
     * @var AFWObject $objToShow
     */
    if($objToShow and (!$objToShow->isEmpty()))
    {
        $arrAttributes = AfwFrameworkHelper::getColsByMode($objToShow, $command_mode);
        $module_translated = $objToShow->translate("module.single",$lang);
        $myDisplayAndLink = $module_translated ." : ".$objToShow->getDisplay($lang)." => ".$objToShow->showMyLink();
        $command_line_result_arr[] = hzm_format_command_line("success", $myDisplayAndLink, $lang,false,true);
        $odd_oven = "odd";
        foreach($arrAttributes as $attribute)
        {
            $val_att = $objToShow->previewAttribute($attribute);
            
            $name_att = $attribute." - ".$objToShow->translate($attribute,$lang);
            
            $command_line_result_arr[] = hzm_attribute_command_line("info", $odd_oven, $name_att, $val_att, $lang);
            if($odd_oven != "odd") $odd_oven = "odd";
            else $odd_oven = "oven";
        }
    }
    else
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "object $object_class [$object_codeOrId] not found"); $nb_errors++;$command_finished = true;return;
    }
    $command_done = true;
    $command_finished = true;