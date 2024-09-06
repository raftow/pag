<?php
    $command_to_help = $command_line_words[1];
    $command_to_help = ClineUtils::formatCommand($command_to_help);
    $command_line_result_arr[] = hzm_attribute_command_line("info", "header", "COMMAND", "DESCRIPTION", "en", "info");
    if(ClineUtils::similarCommand($command_to_help, "curr_mod")) $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "curr @module", "to change the current module", "en", "log");
    if(ClineUtils::similarCommand($command_to_help, "curr_tbl")) $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "curt @table[.@module]", "to change the current table", "en", "log");
    if(ClineUtils::similarCommand($command_to_help, "curr_fld")) $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "curf @field[.@table][.@module]", "to change the current field", "en", "log");
    
    if(ClineUtils::similarCommand($command_to_help, "find")) 
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "find @table[.@module] filter find-method find-param", "to find an object into a specific module", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example : find module all like app");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        The command line kernal try to be intelligent to find the object into the correct module if it fail it looks for into the current module");
    }    

    if(ClineUtils::similarCommand($command_to_help, "reverse"))  
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "reverse [@field][.@table][.@module]", "to do a reverse engineering on a specific module or table or field", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1 : reverse pag");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 2 : reverse cmn.city");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 3 : reverse cmn.city.country_id");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        this command make the @module @table @field provided as current work objects");

        $command_line_result_arr[] = hzm_format_command_line("warning", "        for a module The reverse engineering is based on content of files @module/module_config.php and @module_code/ini.php");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        for a table The reverse engineering is based on content of files @module/models/@table.php and @module/struct/@table_afw_structure.php and @module/tr/trad_@lang_@table.php");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        for a field The reverse engineering is based on structure definition of this field in structure file : @module/struct/@table_afw_structure.php and translate file : @module/tr/trad_@lang_@table.php");
    }

    $command_done = true;
    $command_finished = true;