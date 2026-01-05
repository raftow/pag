<?php
$command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "doing $command_code on " . $command_line_words[1]);
$objModule = Module::getModuleByCode(0, $currmod);
if (!$objModule) {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "current module not set (use curr command)");
        $nb_errors++;
} else {
        $idMod = $objModule->getId();
        $atable_name = $command_line_words[1];

        $objAtable = Atable::loadByMainIndex($idMod, $atable_name);
        if ($objAtable and (!$objAtable->isEmpty())) {
                $atable_class = AfwStringHelper::tableToClass($atable_name);
                $idTab = $objAtable->getId();
                $nbFields = $objAtable->getVal("fieldcount");

                $atable_translated = $objAtable->translate("atable.single", $lang);
                $command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "current object class changed to $atable_class, id of entity is $idMod , it contain $nbFields field(s)");
                $command_line_result_arr[] = AfwUtils::hzm_format_command_line("success", $atable_translated . " : " . $objAtable->getDisplay($lang), $lang);
                $command_line_result_arr[] = AfwUtils::hzm_format_command_line("log", " to see the field(s) of this table : ", $lang);
                $command_line_result_arr[] = hzm_attribute_command_line("info", "header", "COMMAND", "DESCRIPTION", "en", "info");
                $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "list original fields from table $currmod-$atable_name", "to see the original fields", "en", "log");
                $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "list index fields from table $currmod-$atable_name", "to see the index fields", "en", "log");
                $command_line_result_arr[] = hzm_attribute_command_line("info", "odd", "list audit fields from table $currmod-$atable_name", "to see the audit fields", "en", "log");


                // ex  booking
                // ex list  fields from table travel 

        } else {
                $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "table $atable_name not found in module $currmod");
                $nb_errors++;
        }
}
$command_done = true;
$command_finished = true;
