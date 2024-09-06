<?php
    $command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);
    $currmod_code = $command_line_words[1];    
    $objModule = Module::getModuleByCode(0, $currmod_code);
    if($objModule and (!$objModule->isEmpty()))
    {
        $currmod = $objModule->getVal("module_code");
        $idMod = $objModule->getId();
        $nbTables = $objModule->getVal("tablecount");
        
        $module_translated = $objModule->translate("module.single",$lang);
        $command_line_result_arr[] = hzm_format_command_line("info", "current module changed to $currmod, id of module is $idMod , it contain $nbTables table(s)");
        $command_line_result_arr[] = hzm_format_command_line("success", $module_translated." : ".$objModule->getDisplay($lang), $lang);
    }
    else
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "module $currmod_code not found");
        $nb_errors++;$command_finished = true;return;
    }
    $command_done = true;
    $command_finished = true;