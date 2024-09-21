<?php
    $module_code = $object_code_arr[0];
    if($module_code)
    {
        $objModule = Module::loadByMainIndex($module_code);
    
        if((!$restriction) or $restriction=="ini")
        {
            $command_line_result_arr[] = hzm_format_command_line("info", "generating ini.php file : ");
            $phpIni = $objModule->genereIniPhpFile();
            
            $command_line_result_arr[] = hzm_format_command_line("php", $phpIni, "en", "cline php struct");
        }
        
        if((!$restriction) or $restriction=="chsys")
        {
            $command_line_result_arr[] = hzm_format_command_line("info", "generating [your project]/external/chsys/module_$module_code.php file : ");
            $php_code = $objModule->calcPhp_module(false);        
            $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline php");
        }
        
        if((!$restriction) or $restriction=="scis")
        {
            $command_line_result_arr[] = hzm_format_command_line("info", "generating SCIS methods : ");
            $php_code = Atable::generateAllMethodStepToSCI($objModule->id);        
            $command_line_result_arr[] = hzm_format_command_line("php", $php_code, "en", "cline php scis");
        }
        

    }
    elseif(!$module_code)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "generate command need the module code !! object_code=$object_code");
        $nb_errors++;$command_finished = true;return;
    }