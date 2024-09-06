<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code with params ".var_export($command_line_words, true));
    if(count($command_line_words)>3) 
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "command line $command_code does'nt need all these params, see help.");$nb_errors++;
        $command_mode = "";
    }    
    else $command_mode = $command_code;
    
    if($command_code=="show") $command_mode="SHOW";
    if($command_code=="view") $command_mode="RETRIEVE";
    if($command_code=="more") $command_mode="MINIBOX";
    
    if(!$command_mode)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "can't complete display command, template not found");$nb_errors++;
    }
    
    list($object_class_file, $object_module) = parse_table_and_module($command_line_words[1]);
    
    
    if(!$object_module) $object_module = $currmod;
    
    $object_codeOrId = $command_line_words[2];
    $object_code = is_numeric($object_codeOrId) ? "" : $object_codeOrId;
    $object_id   = is_numeric($object_codeOrId) ? intval($object_codeOrId) : "";
    
    $objToShow = null;
    if(file_exists("$file_dir_name/../$object_module/$object_class_file.php"))
    {
            require_once("$file_dir_name/../$object_module/$object_class_file.php");
            $object_class = AfwStringHelper::tableToClass($object_class_file);
            
            if($object_code and (!$object_id)) 
            {
                if($loadByCodeArr[$object_class_file])
                {
                        $object_code_arr = explode("-",$object_code);
                        $objToShow = $object_class::loadByCodes($object_code_arr);
                }
                else
                {
                        $command_line_result_arr[] = hzm_format_command_line("error", "load $object_class by code still not implemented in Momken framework comand line");$nb_errors++;
                }
                
            }
            if($object_id)
            {
                $objToShow = $object_class::loadById($object_id); 
            }
    }
    else
    {
            $command_line_result_arr[] = hzm_format_command_line("error", "3.please check that class $object_class_file file exists in module '$object_module'");$nb_errors++;
    }
    
    if($objToShow and (!$objToShow->isEmpty()))
    {
        $arrAttributes = $objToShow->getColsByMode($command_mode);
        $module_translated = $objToShow->translate("module.single",$lang);
        $command_line_result_arr[] = hzm_format_command_line("success", $module_translated." : ".$objToShow->getDisplay($lang), $lang);
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
        $command_line_result_arr[] = hzm_format_command_line("error", "object $object_class [$object_codeOrId] not found");$nb_errors++;
    }
    $command_done = true;
    $command_finished = true;