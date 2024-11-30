<?php
class ClineUtils
{
    public static function systemCommandFormat($system_command, $vars)
    {
        $parent_project_path = AfwSession::config("parent_project_path", "");
        
        $system_command = str_replace("[project_path]", $parent_project_path, $system_command);
        foreach($vars as $var_name => $var_value)
        {
            $system_command = str_replace("[$var_name]", $var_value, $system_command);
        }
        


        return $system_command;
    }
    public static function systemCommand($system_command, $vars)
    {
        
        $system_command = ClineUtils::systemCommandFormat($system_command, $vars);
        // here to add some security to prevent bad developers to make catastrophe
        // @todo
        $output=null;
        $retval=null;
        $res = exec($system_command, $output, $retval);
        return [$res, $retval, $output];
    }

    public static function similarCommand($command_to_help, $command_similar)
    {
        return (!$command_to_help) or ($command_to_help == $command_similar);
    }

    public static function formatCommand($command_code)
    {
        if ($command_code == "help") {
            // nothing to do
        }

        if (($command_code == "curr") or ($command_code == "use") or ($command_code == "curm") or ($command_code == "currm")) {
            $command_code = "curr_mod";
        }

        if (($command_code == "curo") or ($command_code == "curro") or ($command_code == "curt") or ($command_code == "currt")) {
            $command_code = "curr_tbl";
        }

        if (($command_code == "curf") or ($command_code == "currf")) {
            $command_code = "curr_fld";
        }

        if ($command_code == "get") {
            $command_code = "list";
        }




        if ($command_code == "find") {
            // nothing to do
        }

        if ($command_code == "list") {
            // nothing to do
        }

        if ($command_code == "reverse") {
            // nothing to do
        }

        if (($command_code == "rev") or ($command_code == "r")) {
            $command_code = "reverse";
        }

        if (($command_code == "upgr") or ($command_code == "upg") or ($command_code == "up")or ($command_code == "u")) {
            $command_code = "upgrade";
        }

        

        if (($command_code == "show") or ($command_code == "view") or ($command_code == "more")) {
            $command_code = "show";
        }

        if (($command_code == "gen") or ($command_code == "genere") or ($command_code == "g")) {
            $command_code = "generate";
        }

        if ($command_code == "retrieve") {
            // nothing to do             
        }

        return $command_code;
    }

    public static function parse_table_and_module($object_module_table)
    {
        $object_module_table = strtolower($object_module_table);

        if ($object_module_table == "module") {
            $object_table = "module";
            $object_module = "ums";
        } elseif ($object_module_table == "m") {
            $object_table = "module";
            $object_module = "ums";
        } elseif ($object_module_table == "table") {
            $object_table = "atable";
            $object_module = "pag";
        } elseif ($object_module_table == "t") {
            $object_table = "atable";
            $object_module = "pag";
        } elseif ($object_module_table == "field") {
            $object_table = "afield";
            $object_module = "pag";
        } elseif ($object_module_table == "f") {
            $object_table = "afield";
            $object_module = "pag";
        } elseif ($object_module_table == "domain") {
            $object_table = "domain";
            $object_module = "pag";
        } elseif ($object_module_table == "d") {
            $object_table = "domain";
            $object_module = "pag";
        } else {
            list($object_table, $object_module) = explode(".", $object_module_table);
        }

        return array($object_table, $object_module);
    }
}
