<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);
    list($atable_name, $module_code) = explode(".",$command_line_words[1]);
    if(!$atable_name) $atable_name = $currtbl_code;
    if(!$module_code) $module_code = $currmod;
    if(!$atable_name)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "no table specified");
        $nb_errors++;$command_finished = true;return;
    }
    elseif(!$module_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "no module specified");
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
                        $linkBtn = $objAtable->showMyLink($stepTB = 2, $target = 'table-pag');
                        if($currtbl_code != $atable_name)
                        {
                                $atable_class = AfwStringHelper::tableToClass($atable_name);
                                $idTab = $objAtable->getId();
                                $nbFields = $objAtable->getVal("fieldcount");
                                $currtbl_code = $atable_name;
                                $currtbl = $idTab;
                                
                                $atable_translated = $objAtable->translate("atable.single",$lang);
                                $command_line_result_arr[] = hzm_format_command_line("info", "current table changed to $atable_class id of table is $idTab, id of module is $idMod, it contain $nbFields field(s)");
                                
                                $command_line_result_arr[] = hzm_format_command_line("success", $atable_translated." : ".$objAtable->getDisplay($lang)."\n".$linkBtn, $lang);
                                list($isOk, $dataErr) = $objAtable->isOk(true,true);
                                if(!$isOk)
                                {
                                        $command_line_result_arr[] = hzm_format_command_line("warning", "There are warnings : ".var_export($dataErr,true), $lang);                                        
                                }
                                $currfld = '';
                        }
                        else
                        {
                                $command_line_result_arr[] = hzm_format_command_line("info", "current table is already $atable_name : ".$objAtable->getDisplay($lang)."\n".$linkBtn, $lang);
                        }
                }
                else
                {
                        $command_line_result_arr[] = hzm_format_command_line("error", "table $atable_name not found in module $module_code");
                        $nb_errors++;$command_finished = true;return;
                }
        }
        $command_done = true;
        // may be the module is not the current make it the current
        $command_code = "curr_mod";
        $command_line_words[1] = $module_code;
        unset($command_line_words[2]);
        unset($command_line_words[3]);
        unset($command_line_words[4]);
        unset($command_line_words[5]);
    }
    