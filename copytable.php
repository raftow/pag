<?php

require_once("../config/global_config.php");

// require_once("afw_config.php");
// require_once("afw_shower.php");
if (!AfwSession::hasOption('CLINE-NO-DEFAULT-FIELDS')) AfwSession::toggleOption('CLINE-NO-DEFAULT-FIELDS');
$tab_id = $_REQUEST["tab"];
$tab2_id = $_REQUEST["tab2"];
$tab2_name = $_REQUEST["newname"];
$newmodule = $_REQUEST["newmodule"];
if (!$tab2_name) die("please set newname param, ex &newname=xxxx");
if (!$newmodule) die("please set newmodule param, ex &newmodule=yyyy");

if (is_integer($newmodule)) $newmodule_id = $newmodule;
else {
        $newmoduleObj = Module::getModuleByCode(0, $newmodule);
        if (!$newmoduleObj) die("please set correct newmodule, $newmodule not found ");
        $newmodule_id = $newmoduleObj->id;
        if (!$newmodule_id) die("please set correct newmodule, $newmodule not correct ");
}

// require_once "atable.php";
$tab = new Atable();
if (!$tab->load($tab_id)) {
        $out_scr .= "table source (id=$tab_id) not found";
} else {
        $orig_atable_name = $tab->getVal("atable_name");
        $tab2 = new Atable();

        if (!$tab2_id) {
                if (!$tab2_name) $tab2_name = "copy_of_$orig_atable_name";
                $tab2->select("id_module", $tab->getVal("id_module"));
                $tab2->select("atable_name", $tab2_name);
                if ($tab2->count() == 0) {
                        $tab->resetAsCopy();
                        $tab->set("atable_name", $tab2_name);
                        $tab->NO_DEFAULT_FIELDS = true;
                        $tab->insert();
                        $tab2 = $tab;
                } else {
                        $tab2->select("id_module", $tab->getVal("id_module"));
                        $tab2->select("atable_name", $tab2_name);
                        $tab2->load();
                }
                $tab2_id = $tab2->getId();
        } else {
                if (!$tab2->load($tab2_id)) {
                        $out_scr .= "table target (id=$tab2_id) not found";
                        $tab2 = null;
                }
        }
        if ($tab2) {
                $tab2->set("id_module", $newmodule_id);
                $tab2->commit();
                $tab2AFieldCount = $tab2->getAFieldCount();
                if ($tab2AFieldCount == 0) {
                        // require_once("afield.php");

                        $fld = new Afield();
                        $fld->select("atable_id", $tab_id);
                        $fld->where("avail = 'Y'");
                        // $fld->where("(field_name != 'name_ar' and field_name != 'name_en')");
                        /**
                         * @var array<Afield> $fld_list
                         */
                        $fld_list = $fld->loadMany();
                        $nb = 0;
                        foreach ($fld_list as $fld_id => $fld_item) {
                                $fld_list[$fld_id]->resetAsCopy(["atable_id" => $tab2_id], [$orig_atable_name => $tab2_name]);
                                $fld_list[$fld_id]->insert();
                                $nb++;
                        }



                        $out_scr .= "table $orig_atable_name (id=$tab_id) copied to new table $tab2_name (id=$tab2_id) ($nb fields copied)";
                } else
                        $out_scr .= "table merge not implemented yet ! table target $tab2_name (id=$tab2_id) already contain $tab2AFieldCount fields !!!!";
        }
}
