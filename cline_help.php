<?php
    $command_to_help = $command_line_words[1];
    $command_to_help = ClineUtils::formatCommand($command_to_help);
    $command_line_result_arr[] = hzm_attribute_command_line("info", "header", "COMMAND", "DESCRIPTION", "en", "info");
    if(ClineUtils::similarCommand($command_to_help, "curr_mod")) $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "curr @module", "to change the current module", "en", "log");
    if(ClineUtils::similarCommand($command_to_help, "curr_tbl")) $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "curt @table[.@module]", "to change the current table", "en", "log");
    if(ClineUtils::similarCommand($command_to_help, "curr_fld")) $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "curf @field[.@table][.@module]", "to change the current field", "en", "log");
    
    

    if(ClineUtils::similarCommand($command_to_help, "add")) 
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "add[or +] @what @table.@module @name-ar @title-ar @name-en @title-en @fieldType.SIZE", "to find an object into a specific module", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        examples: + table app.workflow التطبيقات تطبيق applications application");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        for @what parameter table or t is same field or f is same module or m is same, examples"); 
        $command_line_result_arr[] = hzm_format_command_line("warning", "                  + t content محتويات محتوى contents content");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        for @titles-en-and-ar if you put dash `-` it will be same as name, examples"); 
        $command_line_result_arr[] = hzm_format_command_line("warning", "                  + f content_type_enum نوع-المحتوى -");
        $command_line_result_arr[] = hzm_format_command_line("warning", "                  + f app_code رمز-التطبيق - application-code - text.16");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        when english title and name ar omitted it will be deduced from the code of object, example"); 
        $command_line_result_arr[] = hzm_format_command_line("warning", "                  + t page_section أقسام-الصفحات قسم-صفحة");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        is same as you do : ");
        $command_line_result_arr[] = hzm_format_command_line("warning", "                  + t page_section أقسام-الصفحات قسم-صفحة page-sections page-section");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        if the column to add is a FK on existing created table you don't need to add any props other than field name all the rest is intelligently deduced, example : ");
        $command_line_result_arr[] = hzm_format_command_line("warning", "                  + f section_template_id");
        
        
    }

    if(ClineUtils::similarCommand($command_to_help, "cron")) 
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "cron [erase/add/update/list/run] @bf-id @cron-sched", "to schedule an script BF into the crontab", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example : cron erase 158770 */15-*-*-*-*");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        Schedule the job defined in BF (id=158770) to be run each 15 minutes");
    }

    if(ClineUtils::similarCommand($command_to_help, "find")) 
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "find @table[.@module] @filter @find-method @find-param", "to find an object into a specific module", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example : find module all like app");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        The command line kernal try to be intelligent to find the object into the correct module if it fail it looks for into the current module");
    }  

    if(ClineUtils::similarCommand($command_to_help, "goal")) 
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "goal @goal_id @action @param1 @param2 ... ", "to manage the current module goals", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example : goal 180 +t app_model_api : to add table api_endpoint to the goal 180 (ie. settings management for example)");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        -> the impact is to find business functions such as quick search on api_endpoint in the menu role of this goal 180");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        ex goal 180 -t api_endpoint : to remove table api_endpoint from the goal 180");
    }

    if(ClineUtils::similarCommand($command_to_help, "reverse"))  
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "reverse @what [@field][.@table][.@module]", "to do a reverse engineering on a specific module or table or field", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1 : reverse pag");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 2 : reverse cmn.city");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 3 : reverse cmn.city.country_id");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        this command will make the @module @table @field provided as current work objects");

        $command_line_result_arr[] = hzm_format_command_line("warning", "        for a module The reverse engineering is based on content of files @module/module_config.php and @module_code/ini.php");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        for a table The reverse engineering is based on content of files @module/models/@table.php and @module/struct/@table_afw_structure.php and @module/tr/trad_@lang_@table.php");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        for a field The reverse engineering is based on structure definition of this field in structure file : @module/struct/@table_afw_structure.php and translate file : @module/tr/trad_@lang_@table.php");
    }

    if(ClineUtils::similarCommand($command_to_help, "clone"))  
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "clone @what @table[.@field] to @new-module[.@new-or-existing-table]", "to do a clone from current module a specific table or field into new module.table", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1 : clone table city to geo.the_city will clone city from current module table to geo and rename it as the_city");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 2 : clone field city.country_id to hrm.employer will clone country_id field to table hrm.employer at the end of columns (order = 9999)");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        this command will make the @new-module @new-or-existing-table provided as current work objects");
    }

    if(ClineUtils::similarCommand($command_to_help, "list"))  
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "list @filter @what [from @entity @code]", "to do a retrieve of list (load many) if @entity and @code are omitted it take the current work object", "en", "log");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1 : list all goals");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 2 : list original fields");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 3 : list index fields from table screen_model.adm");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 4 : list all goals from domain hr");
        
    }

    if(ClineUtils::similarCommand($command_to_help, "upgrade"))  
    {
        $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "upgrade [@action] [@what]", "@action-default is `show` @what-default is `all`", "en");
        $command_line_result_arr[] = hzm_format_command_line("success", " -> manage the migrations to upgrade the database of current module, see examples below", "en"); 
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1 : upgrade show [all] : show all migrations");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1.1 : upgrade show done : show done migrations");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 1.2 : upgrade show todo : show todo migrations");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 2 : upgrade run [all] : upgrade by running all the todo migrations");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 3 : upgrade run 00005 : run the migration 00005 if not already done");
        $command_line_result_arr[] = hzm_format_command_line("warning", "        example 4 : upgrade ignore 00005 : ignore the migration 00005 and make as it is already done manually");
    }

    // ex  (explicit if not same code) 

    $command_done = true;
    $command_finished = true;