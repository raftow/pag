<?php
    $module_code = $object_code_arr[0];
    if($module_code)
    {
        $objModule = Module::loadByMainIndex($module_code);
    
    
        $command_line_result_arr[] = hzm_format_command_line("info", "generating ini.php file : ");
        $phpIni = $objModule->genereIniPhp();
        
        $command_line_result_arr[] = hzm_format_command_line("php", $phpIni, "en", "cline php struct");
        
        
        $command_line_result_arr[] = hzm_format_command_line("info", "generating [your project]/external/chsys/module_$module_code.php file : ");
        $php_code = $objModule->calcPhp_module(false);        
        $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline php");

    }
    elseif(!$module_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
        $nb_errors++;$command_finished = true;return;
    }