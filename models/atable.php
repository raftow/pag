<?php
/*
 alter table ".$server_db_prefix."pag.atable add titre_u_s varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL after titre_u;
 alter table ".$server_db_prefix."pag.atable add titre_short_s varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL after titre_short;

 7/7/21
ALTER TABLE `atable` CHANGE `entity_name` `entity_name` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL; 
ALTER TABLE `atable` CHANGE `entity_name2` `entity_name2` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL; 

*/


$file_dir_name = dirname(__FILE__);
// old include of afw.php


class Atable extends AFWObject
{

    // SPECIAL_PROCESS_TABLE - جدول لحفظ بعض الاجراءات الخاصة  
    public static $TBOPTION_SPECIAL_PROCESS_TABLE = 2;

    // OPEN_ROLES_ON_FULL_SCREEN - فتح الصلاحيات على الشاشة ككل  
    public static $TBOPTION_OPEN_ROLES_ON_FULL_SCREEN = 6;

    // OPEN_ROLES_ON_SCREEN_TABS - فتح الصلاحيات على العلامات التبويبية  
    public static $TBOPTION_OPEN_ROLES_ON_SCREEN_TABS = 5;

    // OPEN_ROLES_ON_FIELD_GROUPS - فتح الصلاحيات على مجموعات الحقول  
    public static $TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS = 4;

    // DATA_IS_AUTO_GENERATED - يتم توليد البيانات آليا  
    public static $TBOPTION_DATA_IS_AUTO_GENERATED = 3;

    // DATA_CAN_BE_IMPORTED_FROM_OUTSID - يمكن استيراد البيانات من ملفات خارجية  
    public static $TBOPTION_DATA_CAN_BE_IMPORTED_FROM_OUTSID = 1;

    // FULL_DETAIL - بيانات الجدول محجوبة على غير الكيان الأب  
    public static $TBOPTION_FULL_DETAIL = 8;

    // OBJ_IS_VIEW - هذا الكيان هو رؤية فقط وليس بجدول حقيقي  
    public static $TBOPTION_OBJ_IS_VIEW = 7;

    // فرض وجود حقل الرمز المرجعي (lookup_code)-- force lookup_code field  creation  
    public static $TBOPTION_LOOKUPCODE = 9;

    //  INSERT INTO ".$server_db_prefix."pag.tboption SET id_aut = '1', id_mod = '1', id_valid = '0', avail = 'Y', sci_id = '0', foption_name_ar = _utf8'بيانات هذا الجدول بعد انشائها غير قابلة للتعديل السريع', foption_name_en = _utf8'data is readonly', lookup_code = 'DATA_IS_READONLY', date_aut = now(), date_mod = now()
    // DATA_IS_READONLY - بيانات هذا الجدول بعد انشائها غير قابلة للتعديل السريع  
    public static $TBOPTION_DATA_IS_READONLY = 11;

    // NEVER_GENERATED - لا يتم بحال توليد البيانات آليا  
    public static $TBOPTION_NEVER_GENERATED = 10;


    private $fieldListOriginal;
    private $fieldListVirtual;
    private $fieldListAdditional;

    private $table_category;

    public static $DATABASE        = "";
    public static $MODULE            = "pag";
    public static $TABLE            = "atable";
    public static $DB_STRUCTURE = null;


    public function __construct()
    {
        parent::__construct("atable", "id", "pag");
        PagAtableAfwStructure::initInstance($this);
    }

    public static function loadById($id)
    {
        $obj = new Atable();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByCodes($object_code_arr, $create_if_not_exists_with_name = "", $lang = "ar", $rename_if_exists = false)
    {
        if (count($object_code_arr) != 2) throw new AfwRuntimeException("Atable::loadByCodes : 2 params needed (module_code, table_name) : object_code_arr=" . var_export($object_code_arr, true));

        $file_dir_name = dirname(__FILE__);


        $module_code = $object_code_arr[0];
        $table_name = $object_code_arr[1];
        $objModule = Module::loadByMainIndex($module_code);
        if ((!$objModule) or $objModule->isEmpty()) throw new AfwRuntimeException("Atable::loadByCodes : can't find module by module_code = $module_code");


        $obj = self::loadByMainIndex($objModule->getId(), $table_name, $create_if_not_exists_with_name);
        if (($obj->is_new) or $rename_if_exists) {
            if ($lang == "ar") $obj->set("titre_short", $create_if_not_exists_with_name);
            if ($lang == "en") $obj->set("titre_short_en", $create_if_not_exists_with_name);
            $obj->commit();
        }

        return $obj;
    }

    /**
     * 
     * @return Atable
     */



    public static function loadByMainIndex($id_module, $atable_name, $create_obj_if_not_found = false)
    {


        $obj = new Atable();
        $obj->select("id_module", $id_module);
        $obj->select("atable_name", $atable_name);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("id_module", $id_module);
            $obj->set("atable_name", $atable_name);

            $obj->insert();
            $obj->is_new = true;
            return $obj;
        } else return null;
    }

    public function getJobrolesByCode($code)
    {
        if ($code == "djs") return $this->getDisplayJobroles();
        if ($code == "em") return $this->getEntityManagerJobroles();
        if ($code == "bm") return $this->getBusinessManagerJobroles();
        if ($code == "sm") return $this->getSystemManagerJobroles();
        if ($code == "mm") return $this->getMonitoringManagerJobroles();


        throw new AfwRuntimeException("not implemented jobrole code : $code");
    }

    public function getDisplayJobroles()
    {

        $jrlist = $this->hetDispJobs();

        if ((!$jrlist) or (!count($jrlist))) {
            $jobroleList = $this->getEntityManagerJobroles();
            foreach ($jobroleList as $jr) $jrlist[$jr->getId()] = $jr;

            $jobroleList = $this->getBusinessManagerJobroles();
            foreach ($jobroleList as $jr) $jrlist[$jr->getId()] = $jr;

            $jobroleList = $this->getSystemManagerJobroles();
            foreach ($jobroleList as $jr) $jrlist[$jr->getId()] = $jr;

            $jobroleList = $this->getMonitoringManagerJobroles();
            foreach ($jobroleList as $jr) $jrlist[$jr->getId()] = $jr;
        }

        return $jrlist;
    }

    public function getEntityManagerJobroles()
    {
        $master = $this->getMaster();
        if ($master and ($master->getId() > 0)) {
            return $master->getEntityManagerJobroles();
        }
        // مسؤولية التعديل
        $jr = $this->hetEMJob();
        $parent = $this->hetModule();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getSystemManagerJobrole();
        }

        $return_arr = array();
        if ($jr) $return_arr[$jr->getId()] = $jr;
        return $return_arr;
    }


    public function getBusinessManagerJobroles()
    {
        $jr = null;
        $parent = $this->hetModule();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getBusinessManagerJobrole();
        }

        $return_arr = array();
        if ($jr) $return_arr[$jr->getId()] = $jr;
        return $return_arr;
    }

    public function getSystemManagerJobroles()
    {
        $jr = null;
        $parent = $this->hetModule();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getSystemManagerJobrole();
        }

        $return_arr = array();
        if ($jr) $return_arr[$jr->getId()] = $jr;
        return $return_arr;
    }

    public function getMonitoringManagerJobroles()
    {
        $jr = null;
        $parent = $this->hetModule();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getMonitoringManagerJobrole();
        }

        $return_arr = array();
        if ($jr) $return_arr[$jr->getId()] = $jr;
        return $return_arr;
    }


    public function getPreviousAtable()
    {
        $my_mod = $this->get("id_module");
        // if($my_tab)
        return $my_mod->getAtableBefore($this, true);
        // else

    }

    public function getNextAtable()
    {
        $my_mod = $this->get("id_module");
        // if($my_tab)
        return $my_mod->getAtableAfter($this, true);
        // else

    }

    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        global $lang;
        $objme = AfwSession::getUserConnected();
        $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
        $my_atable_name = $this->getVal("atable_name");
        if ($this->getVal("id_module") <= 0) return $otherLinksArray;

        $my_module = $this->myModuleCode();
        $my_class = $this->getTableClass();
        $displ = $this->getDisplay($lang);

        $pf = $this->getPreviousAtable();
        $nf = $this->getNextAtable();


        if ($nf) $next_atable_id = $nf->getId();
        else $next_atable = 0;
        if ($pf) $previous_atable_id = $pf->getId();
        else $previous_atable_id = 0;

        if (($mode == "edit") and ($next_atable_id)) {
            $link = array();
            $link["URL"] = "main.php?Main_Page=afw_mode_display.php&cl=Atable&currmod=pag&id=$next_atable_id";
            $link["TITLE"] = "الجدول الموالي : " . $nf->getDisplay($lang);
            $link["COLOR"] = "yellow";
            $link["UGROUPS"] = array();
            // $link["STEP"] = 8;
            $otherLinksArray[] = $link;
        }

        if (($mode == "edit") and ($previous_atable_id)) {
            $link = array();
            $link["URL"] = "main.php?Main_Page=afw_mode_display.php&cl=Atable&currmod=pag&id=$previous_atable_id";
            $link["TITLE"] = "الجدول السابق : " . $pf->getDisplay($lang);
            $link["COLOR"] = "yellow";
            $link["UGROUPS"] = array();
            // $link["STEP"] = 8;
            $otherLinksArray[] = $link;
        }

        if ($this->isLookup() and ($mode == "mode_lookupValueList")) {
            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة المفردات ";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=LookupValue&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if ($this->_isEntity() and ($mode == "mode_scis")) {
            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة العلامات التبويبية ";
            $title_detailed = $title . "لجدول : " . $this->valTitre_short();;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=ScenarioItem&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if ($this->_isEntity() and ($mode == "mode_afieldGroupList")) {
            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة مجموعات الحقول ";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=AfieldGroup&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=10&limit=99&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if ($mode == "mode_origFieldList") {
            $link = array();
            $title = "إنشاء حقل جديد في  " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Afield&currmod=pag&sel_atable_id=" . $this->getId();
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $link["ADMIN-ONLY"] = true;
            $otherLinksArray[] = $link;

            $link = array();
            $title = "إدارة حقول الجدول : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&newo=7&limit=100&ids=all&fixmtit=$title&fixmdisable=1&fixm=atable_id=" . $this->getId() . "&sel_atable_id=" . $this->getId() . "&comfld=1&popup=";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $link["ADMIN-ONLY"] = true;
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة سياقات ظهور الحقول";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=modes_list&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة التبويب والمجموعة لحقول البيانات ";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=step_group&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة قواعد التثبت لحقول البيانات ";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=field_rules&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة المواصفات المتقدمة ";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=answer_props&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة نصوص المساعدة ";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=other_props&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة الرموز والمسميات ";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=general_props&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;


            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة الخيارات البرمجية";
            $title_detailed = $title . "/ الجدول : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&id_origin=$my_id&class_origin=Atable&module_origin=pag&newo=-1&limit=100&submode=FGROUP&fgroup=advanced_props&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=atable_id=$my_id&sel_atable_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }


        if (($mode == "edit") or ($mode == "display")) {


            unset($link);
            $link = array();
            $link["URL"] = "main.php?Main_Page=copytable.php&tab=" . $this->getId();
            $link["TITLE"] = "نسخ  الجدول : " . $this->valTitre_short();
            $link["UGROUPS"] = array();
            $link["ADMIN-ONLY"] = true;
            $otherLinksArray[] = $link;

            if ($this->isOriginal()) {
                $mod = $this->valId_module();
                $link = array();
                $link["URL"] = "dbgen.php?show_sql=1&sql=1&mod=$mod&tbl=" . $this->getId();
                $link["TITLE"] = "SQL of " . $this->valClass_name();
                $link["UGROUPS"] = array();
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;

                unset($link);
                $mod = $this->valId_module();
                $link = array();
                $link["URL"] = "dbgen.php?show_sql=1&sql=1&mod=$mod&tblsubm=1&tbl=" . $this->getId();
                $link["TITLE"] = "SQL of Submodel";
                $link["UGROUPS"] = array();
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;


                unset($link);
                $link = array();
                $link["URL"] = "dbgen.php?php=1&trad=1&struct_out=&mod=$mod&tbl=" . $this->getId();
                $link["TITLE"] = "PHP of " . $this->valClass_name();
                $link["UGROUPS"] = array();
                $link["COLOR"] = "red";
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;


                unset($link);
                $link = array();
                $link["URL"] = "dbgen.php?struct=1&mod=$mod&tbl=" . $this->getId();
                $link["TITLE"] = "Structure of " . $this->valClass_name();
                $link["UGROUPS"] = array();
                $link["COLOR"] = "red";
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;

                unset($link);
                $link = array();
                $link["URL"] = "dbgen.php?trad=1&mod=$mod&tbn=" . $my_atable_name;
                $link["TITLE"] = "Translations of " . $this->valClass_name();
                $link["UGROUPS"] = array();
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;

                if ($this->isLookup()) {
                    unset($link);
                    $link = array();
                    $link["URL"] = "dbgen.php?lookup=1&mod=$mod&tbl=" . $this->getId();
                    $link["TITLE"] = "Lookup file of " . $this->valClass_name();
                    $link["UGROUPS"] = array();
                    $link["ADMIN-ONLY"] = true;
                    $otherLinksArray[] = $link;
                }
                unset($link);
                $link = array();
                $link["URL"] = "dbgen.php?mod=$mod&tbn=" . $my_atable_name;
                $link["TITLE"] = "توليد كامل للكيان : " . $this->valTitre_short();
                $link["UGROUPS"] = array();
                $link["COLOR"] = "green";
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;

                unset($link);
                $link = array();
                $link["URL"] = "main.php?Main_Page=pag_me.php&cl=$my_class&currmod=$my_module&uie=1";
                $link["TITLE"] = "pag me with update";
                $link["UGROUPS"] = array();
                $link["COLOR"] = "red";
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;


                unset($link);
                $link = array();
                $link["URL"] = "main.php?Main_Page=struct_me.php&cl=$my_class&currmod=$my_module&uie=1";
                $link["TITLE"] = "struct me";
                $link["UGROUPS"] = array();
                $link["COLOR"] = "red";
                $link["ADMIN-ONLY"] = true;
                $otherLinksArray[] = $link;
            }
        }
        return $otherLinksArray;
    }



    public function getNbFieldsInMode($mode_name = "all")
    {
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        if ($mode_name != "all") $af->select($mode_name, 'Y');
        if ($mode_name == "all-except-auto-generated") {
            $af->where("field_name not in ('name_ar','name_en','desc_ar','desc_en')");
        }

        return $af->count();
    }

    public function forceDelete()
    {
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $this_id = $this->id;

        AfwDatabase::db_query("delete from ".$server_db_prefix."ums.bfunction where curr_class_atable_id = $this_id");
        AfwDatabase::db_query("delete from ".$server_db_prefix."pag.afield where atable_id = $this_id");
        AfwDatabase::db_query("delete from ".$server_db_prefix."ums.scenario_item where atable_id = $this_id");
        AfwDatabase::db_query("delete from ".$server_db_prefix."pag.atable where id = $this_id");
        return true;
        //return $this->delete();
    }

    public function getAFieldCount($only_reel = true)
    {
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        if ($only_reel) $af->select("reel", 'Y');

        return $af->count();
    }

    public function getAFieldNonAssignedToStepCount($only_reel = false)
    {
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("scenario_item_id", 0);
        if ($only_reel) $af->select("reel", 'Y');

        return $af->count();
    }




    public function getTablePriority()
    {
        // max_period unit = hour
        // 120 h = prio 1
        // 1 h = prio 10

        if ($this->getVal("max_period"))
            $max_period = $this->getVal("max_period");
        else
            $max_period = 80;  // by default      

        $prio = round((121.0 - $max_period) / 12.0) + 1;

        if ($prio < 0) $prio = 1;
        if ($prio > 10) $prio = 10;

        return $prio;
    }

    public function isDetailTableForOthers()
    {
        if (isset($this->debugg_is_detail_table_for_others)) return ($this->debugg_is_detail_table_for_others == "Y");
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        if ($this->isEmpty()) return false;

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 5);
        $af->select("entity_relation_type_id", 1);
        $af->where("answer_table_id != " . $this->getId());   // because if table is detail only of itself it is not detail (like bmu.event) 

        $this->debugg_is_detail_table_for_others = ($af->count() > 0) ? "Y" : "N";

        return ($this->debugg_is_detail_table_for_others == "Y");
    }

    public function getMaster()
    {
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $master = new Atable();

        if ($this->dataIsFullOwnedByMaster()) {
            $this_id = $this->getId();
            $master->where("id in (select answer_table_id from ".$server_db_prefix."pag.afield 
                                          where atable_id = $this_id 
                                            and avail='Y' 
                                            and reel='Y' 
                                            and afield_type_id = 5
                                            and entity_relation_type_id = 1)");
            if ($master->load()) {
                return $master;
            } else return $master;
        }

        return $master;
    }

    public function countMyMasterTables()
    {
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 5);
        $af->select("entity_relation_type_id", 1);

        return ($af->count("distinct answer_table_id"));
    }

    public function countDetailTables($entity_relation_type_id = 1, $atable_id_list_arr = null)
    {
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("answer_table_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 5);
        if ($entity_relation_type_id) $af->select("entity_relation_type_id", $entity_relation_type_id);
        if (($atable_id_list_arr) and (count($atable_id_list_arr) > 0)) {
            $atable_id_list_txt = implode(",", $atable_id_list_arr);
            $af->where("atable_id in ($atable_id_list_txt)");
        }

        return $af->count();
    }

    public function getAllTablesRelatedWithMeFields()
    {
        return $this->getDetailTablesRelationFields(0);
    }


    public function getDetailTablesRelationFields($entity_relation_type_id = 1, $atable_id_list_arr = null)
    {
        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("answer_table_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", AfwUmsPagHelper::$afield_type_list);   // LIST - اختيار من قائمة  
        if ($entity_relation_type_id) $af->select("entity_relation_type_id", $entity_relation_type_id);
        if (($atable_id_list_arr) and (count($atable_id_list_arr) > 0)) {
            $atable_id_list_txt = implode(",", $atable_id_list_arr);
            $af->where("atable_id in ($atable_id_list_txt)");
        }

        return $af->loadMany();
    }



    public function getFKPartOfMeNotDeletableRelationFields()
    {
        return $this->getFKPartOfMeTablesRelationFields("2", false);
    }

    public function getFKPartOfMeDeletableRelationFields()
    {
        return $this->getFKPartOfMeTablesRelationFields("2", true);
    }

    public function getFKPartOfMeTablesRelationFields($option = "", $option_doesnt_exist = false)
    {
        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("answer_table_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 5);
        // if field is mandatory it is like if it is part of Me
        $af->where("entity_relation_type_id in (1,4) or mandatory='Y'");
        if ($option) {
            if ($option_doesnt_exist) $af->where("foption_mfk is null or foption_mfk not like '%,$option,%'");
            else $af->where("foption_mfk like '%,$option,%'");
        }


        return $af->loadMany();
    }


    public function getFKNotPartOfMeTablesRelationFields($option = "", $option_doesnt_exist = false)
    {
        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("answer_table_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 5);
        $af->where("entity_relation_type_id not in (1,4) and mandatory != 'Y'");
        if ($option) {
            if ($option_doesnt_exist) $af->where("foption_mfk not like '%,$option,%'");
            else $af->where("foption_mfk like '%,$option,%'");
        }


        return $af->loadMany();
    }


    public function getMFKRelationFields($option = "", $option_doesnt_exist = false)
    {
        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("answer_table_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 6);

        if ($option) {
            if ($option_doesnt_exist) $af->where("foption_mfk not like '%,$option,%'");
            else $af->where("foption_mfk like '%,$option,%'");
        }


        return $af->loadMany();
    }

    public function getMyEnumFields()
    {
        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", AfwUmsPagHelper::$afield_type_enum);

        return $af->loadMany();
    }


    public function isStatTable()
    {
        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/afield.php");

        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("afield_type_id", 5);
        // $af->select("entity_relation_type_id", 1);

        return ($af->count() > 3);
    }

    public function getImportParams()
    {
        if ($this->isOriginal()) {
            $table = $this->valAtable_name() . "_import_config";
            if (!$this->getVal("id_module")) return null;
            $module = $this->myModuleCode();
            list($fileName, $className) = AfwStringHelper::getHisFactory($table, $module);
            if (file_exists($fileName)) {
                return [$fileName, $className];
            } else return [null, null, $fileName];
        } else {
            throw new AfwRuntimeException("getImportParams for virtual tables not implemented yet"); //@todo                  
        }
    }


    public function getFileAndClass()
    {
        $table = $this->valAtable_name();
        if (!$this->getVal("id_module")) throw new AfwRuntimeException("can not getFileAndClass, id_module is not defined for this table ");
        $module = $this->myModuleCode();
        return AfwStringHelper::getHisFactory($table, $module);
    }

    public function getRowCount($only_active = true)
    {
        if ($this->isOriginal()) {
            $table = $this->valAtable_name();
            if (!$this->getVal("id_module")) return "النظام لم يحدد بعد";
            $module = $this->myModuleCode();
            list($fileName, $className) = AfwStringHelper::getHisFactory($table, $module);
            /*
                        if(file_exists($fileName)) {
                                require_once $fileName;
                                
                                
                                //$aaa->select("atable_id", $this->getId());
                                
                        }
                        else return -1;*/


            $aaa = new $className();
            if ($only_active) $aaa->select($aaa->fld_ACTIVE(), 'Y');
            return $aaa->count(false);
        } else {
            /*
                     $tblid = $this->getId();
                     
                     $file_dir_name = dirname(__FILE__); 
                     require_once("$file_dir_name/../rfw/rfw.php");
                     require_once("$file_dir_name/../rfw/rfw_factory.php");
                     
                     $rfwFactoryObj = new RFWFactory();
                     $myRfw =& $rfwFactoryObj->getObject($tblid);
                     if($only_active) $myRfw->select("active", 'Y');
                     return $myRfw->count(); */

            return 0; //@todo debugg                 
        }
    }

    public function getAFieldListOriginal($reload = false)
    {

        if ((!$this->fieldListOriginal) or ($reload))
            $this->fieldListOriginal = &$this->getAFieldList();

        return $this->fieldListOriginal;
    }

    public function isOriginal()
    {
        return $this->is("real_table");
    }


    public function getAFieldListAdditional($reload = false)
    {
        if ((!$this->fieldListAdditional) or ($reload))
            $this->fieldListAdditional = $this->getAFieldList($virtual = false, $reel = true, $additional = true, $original = false);
        return $this->fieldListAdditional;
    }

    public function getAFieldListVirtual($reload = false)
    {
        if ((!$this->fieldListVirtual) or ($reload))
            $this->fieldListVirtual = $this->getAFieldList($virtual = true, $reel = false, $additional = true, $original = true);
        return $this->fieldListVirtual;
    }

    public function getAFieldByFieldName($field_name)
    {
        $this->getAFieldListOriginal();
        if ($this->fieldListOriginal[$field_name]) {
            return $this->fieldListOriginal[$field_name];
        } else {
            $this->getAFieldListAdditional();
            if ($this->fieldListAdditional[$field_name]) {
                return $this->fieldListAdditional[$field_name];
            } else {
                $this->getAFieldListVirtual();
                if ($this->fieldListVirtual[$field_name]) {
                    return $this->fieldListVirtual[$field_name];
                }
            }
        }
    }

    public function getAllFieldList($scenario_item_id = 0)
    {
        return $this->getAFieldList(true, true, true, true, $scenario_item_id);
    }

    public function getAFieldAfter($afield, $from_all_table = true)
    {
        $afield_order = $afield->getVal("field_order");
        if (!$from_all_table) $scenario_item_id = $afield->getVal("scenario_item_id");
        if (!$afield_order) return null;

        // require_once("afield.php");
        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("additional", 'N');
        if (!$from_all_table) $af->select("scenario_item_id", $scenario_item_id);
        $af->where("field_order > $afield_order");
        $af_list = $af->loadMany($limit = "1", $order_by = "field_order asc");

        if (count($af_list) > 0) {
            return current($af_list);
        } else return null;
    }

    public function getAFieldBefore($afield, $from_all_table = false)
    {
        $afield_order = $afield->getVal("field_order");
        if (!$from_all_table) $scenario_item_id = $afield->getVal("scenario_item_id");
        if (!$afield_order) return null;

        // require_once("afield.php");
        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("additional", 'N');
        if (!$from_all_table) $af->select("scenario_item_id", $scenario_item_id);
        $af->where("field_order < $afield_order");
        $af_list = $af->loadMany($limit = "1", $order_by = "field_order desc");

        if (count($af_list) > 0) {
            return current($af_list);
        } else return null;
    }


    public function getMyNameFieldList()
    {
        // require_once("afield.php");
        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("mode_name", 'Y');

        $af_list = $af->loadMany($limit = "", $order_by = "field_order asc");

        $af_list_arr = array();

        foreach ($af_list as $af_id => $af_item) $af_list_arr[] = $af_item->getVal("field_name");


        return array($af_list_arr, $af_list);
    }


    public function hasNameFields()
    {
        list($name_cols, $name_afield_list) = $this->getMyNameFieldList();

        return (count($name_cols) > 0);
    }

    public function getMainIndexFieldList()
    {
        // require_once("afield.php");
        $af = new Afield();

        $af->select("atable_id", $this->getId());
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("distinct_for_list", 'Y');
        $af->select("additional", 'N');

        $af_list = $af->loadMany($limit = "", $order_by = "field_order asc");

        $af_list_arr = array();

        foreach ($af_list as $af_id => $af_item) $af_list_arr[] = $af_item->getVal("field_name");


        return array($af_list_arr, $af_list);
    }


    public function getAFieldList($virtual = false, $reel = true, $additional = false, $original = true, $scenario_item_id = 0)
    {
        $flid = "TBLID" . $this->getId() . "VRAO";
        if ($virtual) $flid .= "Y";
        else $flid .= "N";
        if ($reel) $flid .= "Y";
        else $flid .= "N";
        if ($additional) $flid .= "Y";
        else $flid .= "N";
        if ($original) $flid .= "Y";
        else $flid .= "N";
        if ($scenario_item_id) $flid .= "STEP" . $scenario_item_id;

        $af_list_arr = $this->getStructureObject("AFIELD-LIST", $flid);
        //global $out_scr;
        //$out_scr .= "<br>\n -> returned AFIELD-LIST [$flid] = ".var_export($af_list_arr,true); 
        if (!is_array($af_list_arr)) {
            // require_once("afield.php");
            $af = new Afield();

            $af->select("atable_id", $this->getId());
            $af->select("avail", 'Y');
            if ($virtual and !$reel) $af->select("reel", 'N');
            if (!$virtual and $reel) $af->select("reel", 'Y');
            if (!$original and $additional) $af->select("additional", 'Y');
            if ($original and !$additional) $af->select("additional", 'N');
            if ($scenario_item_id) $af->select("scenario_item_id", $scenario_item_id);
            //if $af->select("additional", 'N');

            $af_list = $af->loadMany();

            $af_list_arr = array();

            foreach ($af_list as $af_id => $af_item) $af_list_arr[$af_item->getVal("field_name")] = $af_item;

            $this->setStructureObject("AFIELD-LIST", $flid, $af_list_arr);
            /*global $_SERVER;
                       
                       if(count($af_list_arr)>0)
                          die(var_export($_SERVER,true)."\n<br>\n".var_export($af_list_arr,true)); */
        }

        return $af_list_arr;
    }

    public function getMyInternalRelations()
    {

        $this_id = $this->getId();
        $this_id_module = $this->getVal("id_module");

        // require_once("afield.php");
        $af = new Afield();

        $af->select("atable_id", $this_id);
        $af->select("avail", 'Y');
        $af->select("reel", 'Y');
        $af->select("afield_type_id", 5);
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $af->where("answer_table_id in (select id from ${server_db_prefix}pag.atable where avail='Y' and id_module=$this_id_module)");

        $af_list = $af->loadMany();

        $relations_arr = array();
        foreach ($af_list as $af_id => $af_item) {
            $relations_arr[$af_id] = array("totable" => $af_item->getAnsTable(), "fromtable" => $af_item->getTable(), "field" => $af_item);
        }

        return $relations_arr;
    }

    public function getFormuleResult($attribute, $what = 'value')
    {
        global $images;
        $objme = AfwSession::getUserConnected();
        $file_dir_name = dirname(__FILE__);
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        switch ($attribute) {

            case "system_id":
                $modSystem = $this->hetModule();
                // if($this->getId()==1423) die(var_export($modSystem,true));
                if ($modSystem) {
                    if($what=='value')
                    {
                        return $modSystem->getVal("id_system");
                    }
                    else
                    {
                        $system = $modSystem->hetSys();
                        if ($system) return $system;
                        else return null;
                    }
                    
                } 
                else return ($what=='value') ? 0 : null;
                break;

            case "fieldcount":
                if (true)
                    $fn = $this->getAFieldCount(false);
                else
                    $fn = "<img src='../lib/images/fields.png' data-toggle='tooltip' data-placement='top' title='to see fields count please activate the compute stats option'  width='20' heigth='20'>";
                return $fn;
                break;

            case "rowcount":
                if (AfwSession::hasOption("STATS_COMPUTE"))
                    $fn = $this->getRowCount();
                else
                    $fn = "<img src='../lib/images/fields.png' data-toggle='tooltip' data-placement='top' title='to see rows count please activate the compute stats option'  width='20' heigth='20'>";
                return $fn;
                break;

            case "tome":
                $at = new Atable();
                $this_id = $this->getId();
                $this_id_module = $this->getVal("id_module");
                $at->where("id_module=$this_id_module 
                                    and id in (select distinct f1.atable_id from ${server_db_prefix}pag.afield f1 
                                            where f1.answer_table_id = '$this_id' 
                                              and f1.avail='Y'
                                              and f1.reel='Y'
                                              and f1.atable_id > 0
                                              and f1.afield_type_id in (5,12))");
                return $at->loadMany();
                break;

            case "ext_tome":
                $at = new Atable();
                $this_id = $this->getId();
                $this_id_module = $this->getVal("id_module");
                $at->where("id_module!=$this_id_module 
                                    and id in (select distinct f1.atable_id from ${server_db_prefix}pag.afield f1 
                                            where f1.answer_table_id = '$this_id' 
                                              and f1.avail='Y'
                                              and f1.reel='Y'
                                              and f1.atable_id > 0
                                              and f1.afield_type_id in (5,12))");
                return $at->loadMany();
                break;

            case "anst":
                $at = new Atable();
                $this_id = $this->getId();
                $this_id_module = $this->getVal("id_module");
                $at->where("id_module=$this_id_module 
                                    and id in (select distinct f1.answer_table_id from ${server_db_prefix}pag.afield f1 
                                            where f1.atable_id = '$this_id' 
                                              and f1.avail='Y'
                                              and f1.reel='Y'
                                              and f1.answer_table_id > 0
                                              and f1.afield_type_id in (5,12))");
                return $at->loadMany();
                break;

            case "ext_anst":
                $at = new Atable();
                $this_id = $this->getId();
                $this_id_module = $this->getVal("id_module");
                $at->where("id_module!=$this_id_module 
                                    and id in (select distinct f1.answer_table_id from ${server_db_prefix}pag.afield f1 
                                            where f1.atable_id = '$this_id' 
                                              and f1.avail='Y'
                                              and f1.reel='Y'
                                              and f1.answer_table_id > 0
                                              and f1.afield_type_id in (5,12))");
                return $at->loadMany();
                break;


            case "advise":
                $this_disp = $this->getVal("atable_name");
                $advise_html = "";
                if ($this->isActive() and (!$this->_isEnum())) //  1432 = BF_IF admin/qedit of atable
                {
                    if (($objme) and ($objme->iCanDoBF(1432))) {
                        $ext_anst_list = $this->get("ext_anst");
                        $anst_list = $this->get("anst");
                        $ext_tome_list = $this->get("ext_tome");
                        $tome_list = $this->get("tome");

                        if ((count($anst_list) == 0) and (count($tome_list) == 0)) {
                            if ((count($ext_anst_list) > 0) or (count($ext_tome_list) > 0)) {
                                $ext_mod_codes = array();
                                foreach ($ext_anst_list as $ext_anst_item) {
                                    $ext_mod_code = $ext_anst_item->myModuleCode();
                                    if ($ext_mod_code != "undefined-module") {
                                        $ext_mod_codes[$ext_mod_code] = $ext_mod_code;
                                    }
                                }

                                foreach ($ext_tome_list as $ext_tome_item) {
                                    $ext_mod_code = $ext_tome_item->myModuleCode();
                                    if ($ext_mod_code != "undefined-module") {
                                        $ext_mod_codes[$ext_mod_code] = $ext_mod_code;
                                    }
                                }

                                if (count($ext_mod_codes) > 1) {
                                    $advise_html .= "This table [$this_disp] can better be in one of modules : " . implode(",", $ext_mod_codes) . " or if needed create a new module for a new business capability an put it inside";
                                } elseif (count($ext_mod_codes) > 0) {
                                    $advise_html .= "This table [$this_disp] can better be in module : " . implode(",", $ext_mod_codes);
                                } else {
                                    $advise_html .= "Check if this table [$this_disp] is used and is in the correct module";
                                }
                            } else {
                                $advise_html .= "Check if this table [$this_disp] is used because has no relation with other tables";
                            }
                        }

                        if ($advise_html) $advise_html = "<div class='error'>$advise_html</div>";
                    } else {
                        $advise_html = "<img src='" . $images['locked_on_me'] . "' data-toggle='tooltip' data-placement='top' title='Available only for system analysts'>";
                    }
                }
                return $advise_html;
                break;
            case "is_enum":
                return ($this->_isLookup() and (!$this->_isEntity())) ? 'Y' : 'N';
                break;

            case "is_detail":
                return ($this->isDetailTableForOthers()) ? 'Y' : 'N';
                break;

            case "class_name":
                return $this->getTableClass();
                break;

            case "categ":
                return $this->tableCategory();
                break;

            case "mainGoal":
                return $this->getMyMainGoal();
                break;

            case "concernedGoalList":
                AfwAutoLoader::addModule('bau');
                if ($this->getId() > 0) $goalList = GoalConcern::getJobRoleGoalListUsingTable(0, $this->getId());
                else $goalList = array();
                return $goalList;
                break;

            default:
                $methodFormule = "get" . ucfirst($attribute);
                //die("methodFormule = $methodFormule");
                return $this->$methodFormule();
                break;
        }
    }

    public function getMyMainGoal()
    {
        $subMod = $this->het("id_sub_module");
        if ($subMod) return $subMod->getMyMainGoal();
        else return "";
    }

    public function myModuleCode()
    {
        if ($this->myModuleCode) return $this->myModuleCode;
        $this_id_module = $this->getVal("id_module");
        if ($this_id_module > 0) {

            $module = $this->getModule();
            if (!$module) die("module[$this_id_module] for table " . $this->getVal("atable_name") . " is : " . var_export($module));
            $code = $module->getVal("module_code");
            $this->myModuleCode = $code;
        } else  $code = "undefined-module";

        return $code;
    }

    public function disableMyBFsFromMenus($lang = "ar")
    {
        $bfunctionList = $this->get("bfunctionList");

        $info_arr = array();
        $err_arr = array();

        foreach ($bfunctionList as $bfunctionId => $bfunctionObj) {
            list($err, $info) = $bfunctionObj->disableMeFromMenus($lang);
            if ($info) $info_arr[] = $info;
            if ($err) $err_arr[] = $err;
        }


        return array(implode("<br>\n", $err_arr), implode("<br>\n", $info_arr));
    }

    public function getDisplay($lang = "ar")
    {

        $fn = trim($this->myModuleCode());
        $fn = trim($fn . "." . $this->valAtable_name());
        $fn = trim($fn . "-" . $this->valTitre_short());
        //$fn = trim($fn." (" . $this->getAFieldCount().")");

        return $fn;
    }

    public function __toString()
    {
        global $lang;

        return $this->getDisplay($lang);
    }

    public function getTableClass()
    {
        return AfwStringHelper::tableToClass($this->valAtable_name());
    }




    public function getDisplayField($lang = "ar")
    {
        /*
               rafik 15/9/2019 : cause problem to generate SQL of lookup and dont understand what is the interest of
               example 
               INSERT INTO ".$server_db_prefix."frz.participant_category (id, lookup_code, , , active, version) VALUES ....
               list($name_cols, $name_afield_list) = $this->getMyNameFieldList();
               
               if(count($name_cols)>0) return "";
               */

        $display_field = $this->getVal("display_field");
        if ($display_field == "id") $display_field = "";
        if (!$display_field) $display_field = $this->getVal("atable_name") . "_name";

        if (!$this->getAFieldByFieldName($display_field)) $display_field .= "_$lang";
        else return $display_field;
        if (!$this->getAFieldByFieldName($display_field)) $display_field = "titre_short_$lang";
        else return $display_field;
        if (!$this->getAFieldByFieldName($display_field)) $display_field = "name_$lang";
        else return $display_field;
        if (!$this->getAFieldByFieldName($display_field)) {
            //throw new AfwRuntimeException("fieldListOriginal not contain $display_field : ".var_export($this->fieldListOriginal,true));
            // return "$display_field not found";
            // require_once("afield.php");
            $af = new Afield();

            $af->select("atable_id", $this->getId());
            $af->select("avail", 'Y');
            $af->select("reel", 'Y');
            $af->select("afield_type_id", 10);
            $af->where("field_name like '%_$lang'");


            if ($af->load()) {
                $display_field = $af->getVal("field_name");
            } else {
                $display_field = "";
            }
        }

        // die("fld($display_field) : ".var_export($this->getAFieldByFieldName($display_field),true));

        return $display_field;
    }

    public static function generateAllMethodStepToSCI($module_id, $textArea = true)
    {
        $php_code = "";
        //if($textArea) $php_code .= "<textarea cols='120' rows='30' style='width:100% !important;direction:ltr;text-align:left'>";
        $obj = new Atable;
        $obj->select("id_module", $module_id);
        $tabList = $obj->loadMany();
        foreach ($tabList as $tabItem) {
            $table_name = $tabItem->getVal("atable_name");
            $php_code .= "// $table_name \n";
            $php_code .= $tabItem->generateMethodStepToSCI() . "\n\n";
        }
        //if($textArea) $php_code .= "</textarea>"; // 
        return $php_code;
    }

    public function generateMethodStepToSCI()
    {
        $myAtable_id = $this->id;

        $php_code_sci = "";

        if ($myAtable_id) {
            $sci = new ScenarioItem();
            $sci->select('atable_id', $myAtable_id);

            $sciList = $sci->loadMany();
            foreach ($sciList as $sciItem) {
                $step_num = $sciItem->getVal("step_num");
                $sci_id = $sciItem->id;
                $php_code_sci .= "  if(\$currstep == $step_num) return $sci_id;\n";
            }
        } else {
            AfwSession::pushWarning("Can't find atable id for this class, check to be sure that is pagged");
        }

        return "public function getScenarioItemId(\$currstep)
                {
                    $php_code_sci
                    return 0;
                }";
    }
    public function generatePhpStrcture()
    {
        return $this->generatePhpClass($dbstruct_only = true);
    }

    public function generatePhpClass($dbstruct_only = false, $dbstruct_outside = false)
    {
        global $lang;
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

        $this_id = $this->getId();

        $phpErrors = array();

        $tabName = $this->getVal("atable_name");
        $display_field = $this->getDisplayField($lang);
        $dbName = $moduleCode = $this->getModule()->getModuleCode();
        $prefixed_db_name = $server_db_prefix . $moduleCode;
        $fileName = AfwStringHelper::tableToFile($tabName);
        $className = AfwStringHelper::tableToClass($tabName);

        if (!file_exists($fileName)) {
            $new_php_file = "<b>new php class file";
            $new_php_file_end = "</b>";
            $old_struct = array();
        } else {
            $new_php_file = "";
            $new_php_file_end = "";
            include_once $fileName;
            $old_struct = $className::getDbStructure();
        }

        unset($tempTdesc);
        $tempTdesc = array();
        unset($newCols);
        $newCols = array();
        $this->reorderFields($lang);
        $scis = $this->get("scis");

        $scis_count = count($scis);
        if ($scis_count > 0) {
            /* obsolete : rafik
                     $start_order = 0;
                     foreach($scis as $sci_id => $sci_item)
                     {
                         $scis[$sci_id]->start = $start_order;
                         $scis[$sci_id]->end = $scis[$sci_id]->getVal("max_order");
                         $start_order = $scis[$sci_id]->end + 1;
                     }
                     */


            $edit_by_step_php = "\$obj->editByStep = true;
                \$obj->editNbSteps = $scis_count;";
        } else $edit_by_step_php = "";


        $edit_by_step_php .= "
                \$obj->showQeditErrors = true;
                \$obj->showRetrieveErrors = true;
                \$obj->general_check_errors = true;";


        // require_once("afield.php");

        $af_reel = new Afield();

        $af_reel->select("atable_id", $this_id);
        // rafik : desormais on genere le virtuel aussi
        //$af_reel->select("reel", 'Y');
        $af_reel->select("avail", 'Y');

        $af_reel_list = $af_reel->loadMany($limit = "", $order_by = "field_order asc, afield_type_id asc, field_name asc");

        foreach ($af_reel_list as $af_reel_id => $af_reel_obj) {
            $columnName  = $af_reel_obj->valfield_name();
            $field_order = $af_reel_obj->valfield_order();

            list($phpDesc, $phpError)  = $af_reel_obj->generePhpDesc($scis);



            if ($phpError) $phpErrors[] = $phpError;
            if ((!$new_php_file) and (!$old_struct[$columnName])) {
                $newCols[] = $columnName;
            }

            if (!$af_reel_obj->is("reel")) $tabulation_additionelle = "\t";
            else $tabulation_additionelle = "";

            $RDesc = $tabulation_additionelle . $af_reel_obj->getPhpAfwAttribute();
            array_push($tempTdesc, $RDesc);
        }
        $TDesc = "";


        if ($this->isLookup() and ((!$this->hasManyData()) or ($this->hasOption(self::$TBOPTION_LOOKUPCODE)))) {
            $TDesc .= "\n\t\t" . '\'lookup_code\' => array("TYPE" => "TEXT", "SHOW" => true, "RETRIEVE"=>true, "EDIT" => true, "SIZE" => 64, "QEDIT" => true, "SHORTNAME"=>"code"),' . "\n";
            $UNIQUE_KEY = "\$obj->UNIQUE_KEY = array(\"lookup_code\");";
            $indx_cols = array("lookup_code");
            $mandatory_indx_cols["lookup_code"] = true;

            if (true) //($this->_isEnum()) 
            {

                $loadAll_method = "public static function loadAll()
        {
           \$obj = new $className();
           \$obj->select(\"active\",'Y');

           \$objList = \$obj->loadMany();
           
           return \$objList;
        }
";
            }
        } else {
            $loadAll_method = "";
            list($indx_cols, $indx_afield_list) = $this->getMainIndexFieldList();
            $mandatory_indx_cols = array();
            foreach ($indx_afield_list as $indx_afield_id => $indx_afield_obj) {
                if ($indx_afield_obj->_isMandatory()) $mandatory_indx_cols[$indx_afield_obj->getVal("field_name")] = true;
            }
        }

        $stepToSCI_method = $this->generateMethodStepToSCI();

        $TDesc .= "\n\t\t" . implode("\n\t\t", $tempTdesc);




        $UNIQUE_KEY = "";        
        if (count($indx_cols) > 0) {
            $UNIQUE_KEY = "\$obj->UNIQUE_KEY = array('" . implode("','", $indx_cols) . "');";
        }
        else
        {
            $UNIQUE_KEY = "// \$obj->UNIQUE_KEY = array('XXX', 'YYY');";
        }
        //else  $UNIQUE_KEY = "no unique key(UNIQUE_KEY=$UNIQUE_KEY) and indx_cols=".var_export($indx_cols,true);

        if ($this->isLookup()) {
            $clause_ignore_insert_doublon = "\$obj->ignore_insert_doublon = true;";
            $IS_LOOKUP = "\$obj->IS_LOOKUP = true;\$obj->public_display = true;\$obj->ENABLE_DISPLAY_MODE_IN_QEDIT = true;\$obj->showQeditErrors = true;";
            $fld_active_qedit = "true";
            $fld_active_edit = "true";
        } else {
            $clause_ignore_insert_doublon = "";
            $IS_LOOKUP = "";
            $fld_active_qedit = "false";
            $fld_active_edit = "false";
        }

        if ($this->estAuditable()) {
            $AUDIT_DATA = "\$obj->AUDIT_DATA = true;";
        } else {
            $AUDIT_DATA = "";
        }

        $dollar = "\$";

        $file_dir_name = dirname(__FILE__);
        $module = strtolower($this->myModuleCode());
        include("$file_dir_name/../../$module/module_config.php");
        $fld_creation_user_id   = $TECH_FIELDS[$module]["CREATION_USER_ID_FIELD"];
        $fld_creation_date      = $TECH_FIELDS[$module]["CREATION_DATE_FIELD"];
        $fld_update_user_id     = $TECH_FIELDS[$module]["UPDATE_USER_ID_FIELD"];
        $fld_update_date        = $TECH_FIELDS[$module]["UPDATE_DATE_FIELD"];
        $fld_validation_user_id = $TECH_FIELDS[$module]["VALIDATION_USER_ID_FIELD"];
        $fld_validation_date    = $TECH_FIELDS[$module]["VALIDATION_DATE_FIELD"];
        $fld_active             = $TECH_FIELDS[$module]["ACTIVE_FIELD"];
        $fld_version            = $TECH_FIELDS[$module]["VERSION_FIELD"];

        if (!$fld_creation_user_id) {
            throw new AfwRuntimeException("creation_user_id is not defined, check that $file_dir_name/../../$module/module_config.php exists and contain correct data");
        }


        $php_one_to_many_relations = "";
        $php_one_to_many_relations_links = "";

        $omr_field_arr = $this->getDetailTablesRelationFields();
        //AfwRunHelper::safeDie("omr_field_arr => ".var_export($omr_field_arr,true));
        foreach ($omr_field_arr as $omr_field_id => $omr_field_obj) {
            $omr_table_obj = $omr_field_obj->getTable();
            $omr_module = $omr_table_obj->getModule();
            $omr_field_name = $omr_field_obj->getVal("field_name");
            $omr_ans_tab_name = $omr_table_obj->getVal("atable_name");
            $omr_ans_tab_abrev = $omr_table_obj->getVal("abrev");
            $omr_short_name = AfwStringHelper::hzmNaming($omr_ans_tab_name);
            // if($omr_ans_tab_name=="training_unit") 
            // AfwRunHelper::safeDie("$omr_short_name = AfwStringHelper::hzmNaming($omr_ans_tab_name)");
            if ((strlen($omr_ans_tab_abrev) > 7) and (strlen($omr_short_name) > 20)) $omr_short_abrev = $omr_ans_tab_abrev;
            else $omr_short_abrev = $omr_short_name;

            if (strlen($omr_short_abrev) > 14) $vfield_shortname = "";
            else $vfield_shortname = $omr_short_abrev . "s";

            $omr_ans_tab_titre_short = $omr_table_obj->getVal("titre_short");
            $omr_ans_tab_titre_short_en = $omr_table_obj->getVal("titre_short_en");
            $omr_ans_tab_titre = $omr_table_obj->getVal("titre");
            $omr_ans_tab_titre_u = $omr_table_obj->valTitre_u();
            $omr_ans_tab_class = $omr_table_obj->getTableClass();
            $omr_ans_tab_module = $omr_table_obj->myModuleCode();

            $virtual_field_name = $omr_short_abrev . "List";

            $virtual_field = Afield::loadByMainIndex($this_id, $virtual_field_name, $create_obj_if_not_found = true);

            $virtual_field->set("afield_type_id", AfwUmsPagHelper::$afield_type_items);
            $virtual_field->set("answer_module_id", $omr_module->getId());
            $virtual_field->set("answer_table_id", $omr_table_obj->getId());
            $virtual_field->set("reel", "N");
            $virtual_field->set("foption_mfk", ",4,");
            $virtual_field->set("mode_edit", "N");
            $virtual_field->set("mode_search", "N");
            $virtual_field->set("mode_qsearch", "N");
            $virtual_field->set("mode_retrieve", "N");
            $virtual_field->set("readonly", "Y");
            $virtual_field->set("specification", "ITEMS/ITEM=$omr_field_name");

            if ($vfield_shortname) $virtual_field->set("shortname", $vfield_shortname);

            //if($virtual_field->is_new)
            {

                $virtual_field->set("titre_short", "قائمة " . $omr_ans_tab_titre_short);
                $virtual_field->set("titre_short_en", "List of " . $omr_ans_tab_titre_short_en);
            }

            $virtual_field->commit();
            if ($virtual_field->is_new) {
                if ($php_one_to_many_relations) $php_one_to_many_relations .= "                ";
                $php_one_to_many_relations .= "'$virtual_field_name' => array('TYPE' => 'FK', 'ANSWER' => '$omr_ans_tab_name', 'ANSMODULE' => '$omr_ans_tab_module', 
                                                                                                'CATEGORY' => 'ITEMS', 'ITEM' => '$omr_field_name', 
                                                                                                // 'WHERE'=>'xxx = §xxx§', 'HIDE_COLS' => array(),
                                                                                                'SHOW' => true, 'FORMAT'=>'retrieve', 'EDIT' => false, 'READONLY' => true, 
                                                                                                'ICONS'=>true, 'DELETE-ICON'=>true, 'BUTTONS'=>true, 'NO-LABEL'=>false),\n";
                //echo "<br>omr $omr_field_id => ".$php_one_to_many_relations;
            }


            if (($omr_table_obj->hasOption(self::$TBOPTION_FULL_DETAIL)) and (!$omr_table_obj->hasOption(self::$TBOPTION_DATA_IS_READONLY))) {

                $php_one_to_many_relations_links .= "if(\$mode==\"mode_${omr_short_abrev}List\")
             {
                   unset(\$link);
                   \$link = array();
                   \$title = \"إدارة $omr_ans_tab_titre \";
                   \$title_detailed = \$title .\"لـ : \". \$displ;
                   \$link[\"URL\"] = \"main.php?Main_Page=afw_mode_qedit.php&cl=$omr_ans_tab_class&currmod=$omr_ans_tab_module&id_origin=\$my_id&class_origin=$className&module_origin=$dbName&newo=-1&limit=30&ids=all&fixmtit=\$title_detailed&fixmdisable=1&fixm=$omr_field_name=\$my_id&sel_$omr_field_name=\$my_id&return_mode=1\";
                   \$link[\"TITLE\"] = \$title;
                   \$link[\"UGROUPS\"] = array();
                   \$otherLinksArray[] = \$link;
             }
             
             ";
            }

            if (!$omr_table_obj->hasOption(self::$TBOPTION_DATA_IS_AUTO_GENERATED)) {

                $php_one_to_many_relations_links .= "if(\$mode==\"mode_${omr_short_abrev}List\")
             {
                   unset(\$link);
                   \$link = array();
                   \$title = \"إضافة $omr_ans_tab_titre_u جديد\";
                   \$title_detailed = \$title .\"لـ : \". \$displ;
                   \$link[\"URL\"] = \"main.php?Main_Page=afw_mode_edit.php&cl=$omr_ans_tab_class&currmod=$omr_ans_tab_module&sel_$omr_field_name=\$my_id\";
                   \$link[\"TITLE\"] = \$title;
                   \$link[\"UGROUPS\"] = array();
                   \$otherLinksArray[] = \$link;
             }
             
             ";
            }
        }
        //die();

        $php_display_method = "";
        $php_loadByMainIndex_method =  "";
        $display_field_return = "";
        $display_field_not_empty_so_display_it = "";

        if ($display_field) {
            str_replace("[DB_NAME]", $prefixed_db_name, $column_comment_model);
            str_replace("[TABLE_NAME]", $table_name, $column_comment_model);
            $display_field_lang = str_replace("_ar//", "_\$lang", $display_field . "//");
            $display_field_lang = str_replace("//", "", $display_field_lang);
            $display_field_not_empty_so_display_it = "if(\$this->getVal(\"$display_field_lang\")) return \$this->getVal(\"$display_field_lang\");";
            $display_field_return = "return \$this->getVal(\"$display_field_lang\");";
        }

        list($name_cols, $name_afield_list) = $this->getMyNameFieldList();
        // die("name_cols".var_export($name_cols,true));




        $names_are_with_language = false;

        foreach ($name_cols as $i => $name_col) {
            $name_with_language = "";
            if (AfwStringHelper::stringStartsWith($name_col, "_ar")) $name_with_language = "ar";
            if (AfwStringHelper::stringStartsWith($name_col, "_fr")) $name_with_language = "fr";
            if (AfwStringHelper::stringStartsWith($name_col, "_en")) $name_with_language = "en";
            if ($name_with_language) {
                $displayAttribute_list .= "               list(\$data[\"$name_with_language\"],\$link[\"$name_with_language\"]) = \$this->displayAttribute(\"$name_col\",false, \$lang);\n";
                $names_are_with_language = true;
                $display_field_not_empty_so_display_it = "";
            } else {
                $displayAttribute_list .= "               list(\$data[$i],\$link[$i]) = \$this->displayAttribute(\"$name_col\",false, \$lang);\n";
            }
        }


        if (count($indx_cols) > 0) {

            $obj_select_list = "";
            $obj_mandatory_list = "";
            $obj_set_list = "";

            foreach ($indx_cols as $i => $indx_col) {
                // $displayAttribute_list .= "               list(\$data[$i],\$link[$i]) = \$this->displayAttribute(\"$indx_col\",false, \$lang);\n";
                $obj_select_list .= "           \$obj->select(\"$indx_col\",\$$indx_col);\n";
                $obj_set_list    .= "                \$obj->set(\"$indx_col\",\$$indx_col);\n";
                if ($mandatory_indx_cols[$indx_col]) {
                    $obj_mandatory_list .= "           if(!\$$indx_col) throw new AfwRuntimeException(\"loadByMainIndex : $indx_col is mandatory field\");\n";
                }
            }


            $main_index_params = "\$" . implode(", \$", $indx_cols) . ",\$create_obj_if_not_found=false";
            $php_loadByMainIndex_method .= "public static function loadByMainIndex($main_index_params)\n        {\n";
            $php_loadByMainIndex_method .= "$obj_mandatory_list\n\n";
            $php_loadByMainIndex_method .= "           \$obj = new $className();\n";
            $php_loadByMainIndex_method .= "$obj_select_list\n";
            $php_loadByMainIndex_method .= "           if(\$obj->load())\n";
            $php_loadByMainIndex_method .= "           {\n";
            $php_loadByMainIndex_method .= "                if(\$create_obj_if_not_found) \$obj->activate();\n";
            $php_loadByMainIndex_method .= "                return \$obj;\n";
            $php_loadByMainIndex_method .= "           }\n";
            $php_loadByMainIndex_method .= "           elseif(\$create_obj_if_not_found)\n";
            $php_loadByMainIndex_method .= "           {\n";
            $php_loadByMainIndex_method .= "$obj_set_list\n";
            $php_loadByMainIndex_method .= "                \$obj->insertNew();\n";
            $php_loadByMainIndex_method .= "                if(!\$obj->id) return null; // means beforeInsert rejected insert operation\n";
            $php_loadByMainIndex_method .= "                \$obj->is_new = true;\n";
            $php_loadByMainIndex_method .= "                return \$obj;\n";
            $php_loadByMainIndex_method .= "           }\n";
            $php_loadByMainIndex_method .= "           else return null;\n";
            $php_loadByMainIndex_method .= "           \n";
            $php_loadByMainIndex_method .= "        }\n\n";






            $order_by_fields = implode(", ", $indx_cols);



            if (true) {
                if ($names_are_with_language) {
                    $return_sentence = "return \$data[\$lang];";
                } else {
                    $return_sentence = "return implode(\" - \",\$data);";
                }
                $php_display_method = "public function getDisplay(\$lang=\"ar\")
        {
               $display_field_not_empty_so_display_it
               \$data = array();
               \$link = array();
               

$displayAttribute_list
               
               $return_sentence
        }
        
        ";
            }
        } else {
            if (true) {
                $php_display_method = "public function getDisplay(\$lang=\"ar\")
        {
               $display_field_return
        }
        
        ";
            }

            $order_by_fields = $display_field;
        }

        $static_constants = "public static \$MY_ATABLE_ID=$this_id; \n";

        $bfunctionList = $this->get("bfunctionList");

        foreach ($bfunctionList as $bfunctionId => $bfunctionObj) {
            $bfunctionDesc = $bfunctionObj->getVal("titre_short");
            $bfunctionPhpCode = $bfunctionObj->getPhpCode();
            $static_constants .= "        // $bfunctionDesc \n";
            $static_constants .= "        public static \$$bfunctionPhpCode = $bfunctionId; \n";
        }

        $table_name = strtoupper($tabName);

        $enumFieldsArr = $this->getMyEnumFields();
        $enumAtable_functions = "";

        foreach ($enumFieldsArr as $enumField) {
            $enumFieldName = $enumField->getVal("field_name");
            $enumAtable = null;
            if ($enumField->needAnswerTable()) {
                $enumAtable = $enumField->hetAnstable();
            }

            $lookupValueListPhp = "";

            if ($enumAtable) {
                $lookupValueListPhpBefore = "";
                $lookupValueList = $enumAtable->get("lookupValueList");
                foreach ($lookupValueList as $lookupValueObj) {
                    $pkey =  $lookupValueObj->getVal("pkey");
                    $vcode = strtoupper($lookupValueObj->getVal("vcode"));
                    $value = $lookupValueObj->getVal("value");
                    $lookupValueListPhp .= "            \$list_of_items[$pkey] = \"$value\";  //     code : $vcode \n";
                }
                $lookupValueListPhpAfter = "";
            } else {
                $lookupValueListPhpBefore = "/*";
                $specs = $enumField->getVal("specification");
                $lookupData = AfwStringHelper::afw_explode($specs);
                foreach ($lookupData as $lk_key => $lk_val) {
                    $lookupValueListPhp .= "            \$list_of_items[$lk_key] = \"$lk_val\";  //     code : ... not defined ... \n";
                }
                $lookupValueListPhpAfter = "*/";
            }

            $enumAtable_functions .= $lookupValueListPhpBefore;
            $enumAtable_functions .= "        public function list_of_$enumFieldName() { \n";
            $enumAtable_functions .= "            \$list_of_items = array(); \n";

            $enumAtable_functions .= $lookupValueListPhp;

            $enumAtable_functions .= "           return  \$list_of_items;\n";
            $enumAtable_functions .= "        } \n\n\n";
            $enumAtable_functions .= $lookupValueListPhpAfter;
        }

        if ($this->isLookup()) {
            $lookupValueList = $this->get("lookupValueList");
            $static_constants .= "\n\n // lookup Value List codes \n";
            foreach ($lookupValueList as $lookupValueObj) {
                $pkey =  $lookupValueObj->getVal("pkey");
                $vcode = strtoupper($lookupValueObj->getVal("vcode"));
                $value = $lookupValueObj->getVal("value");
                $static_constants .= "        // $vcode - $value  \n";
                $static_constants .= "        public static \$${table_name}_${vcode} = $pkey; \n\n";
            }
        }


        $listFKPartOfMeNotDeletable = $this->getFKPartOfMeNotDeletableRelationFields();
        $listFKPartOfMeDeletable = $this->getFKPartOfMeDeletableRelationFields();
        $listFKNotPartOfMe = $this->getFKNotPartOfMeTablesRelationFields();
        $listMFKRelations = $this->getMFKRelationFields();

        // FK part of me - not deletable 
        $check_list_fk_part_of_me_not_deletable = "";

        $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - deletable 
        $delete_list_fk_part_of_me_deletable = "";

        // FK not part of me - replaceable 
        $replace_list_fk_not_part_of_me_replaceable = "";

        $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK on me 
        $replace_val_in_list_of_fk = "";


        // MFK
        $remove_val_from_list_of_mfk = "";
        $replace_val_in_list_of_mfk = "";


        foreach ($listFKPartOfMeNotDeletable as $fk_afield) {
            $ert = $fk_afield->hetERType();
            $fk_afield_tableObj = $fk_afield->getTable();
            $fk_afield_moduleObj = $fk_afield_tableObj->getModule();
            $fk_afield_moduleCode = $fk_afield_moduleObj->getVal("module_code");
            $fk_afield_className = $fk_afield_tableObj->valClass_name();
            $fk_afield_table_name = $fk_afield_tableObj->valAtable_name();
            $fk_afield_table_title = $fk_afield_tableObj->getVal("titre_short");
            $fk_afield_table_title_en = $fk_afield_tableObj->getVal("titre_short_en");
            $fk_afield_name = $fk_afield->getVal("field_name");
            $fk_afield_title_ar = $fk_afield->getVal("titre_short");
            $fk_afield_title_en = $fk_afield->getVal("titre_short_en");

            $check_list_fk_part_of_me_not_deletable .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert (required field)
                        // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                        \$obj = new $fk_afield_className();
                        \$obj->where(\"$fk_afield_name = '\$id' and $fld_active='Y' \");
                        \$nbRecords = \$obj->count();
                        // check if there's no record that block the delete operation
                        if(\$nbRecords>0)
                        {
                            \$this->deleteNotAllowedReason = \"Used in some $fk_afield_table_title_en(s) as $fk_afield_title_en\";
                            return false;
                        }
                        // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                        if(!\$simul) \$obj->deleteWhere(\"$fk_afield_name = '\$id' and $fld_active='N'\");

";

            $replace_val_in_list_of_fk .= " 

                        // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert (required field)
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::updateWhere(array('$fk_afield_name'=>\$id_replace), \"$fk_afield_name='\$id'\");
                            // \$this->execQuery(\"update \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name set $fk_afield_name='\$id_replace' where $fk_afield_name='\$id' \");
                            
                        } 
                        

";
        }

        foreach ($listFKPartOfMeDeletable as $fk_afield) {
            $ert = $fk_afield->hetERType();
            $fk_afield_tableObj = $fk_afield->getTable();
            $fk_afield_moduleObj = $fk_afield_tableObj->getModule();
            $fk_afield_moduleCode = $fk_afield_moduleObj->getVal("module_code");
            $fk_afield_className = $fk_afield_tableObj->valClass_name();
            $fk_afield_table_name = $fk_afield_tableObj->valAtable_name();
            $fk_afield_name = $fk_afield->getVal("field_name");
            $fk_afield_title_ar = $fk_afield->getVal("titre_short");
            $fk_afield_title_en = $fk_afield->getVal("titre_short_en");


            $delete_list_fk_part_of_me_deletable .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::removeWhere(\"$fk_afield_name='\$id'\");
                            // \$this->execQuery(\"delete from \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name where $fk_afield_name = '\$id' \");
                            
                        } 
                        
                        
";


            $replace_val_in_list_of_fk .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::updateWhere(array('$fk_afield_name'=>\$id_replace), \"$fk_afield_name='\$id'\");
                            // \$this->execQuery(\"update \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name set $fk_afield_name='\$id_replace' where $fk_afield_name='\$id' \");
                            
                        }
                        
";
        }

        foreach ($listFKNotPartOfMe as $fk_afield) {
            $ert = $fk_afield->hetERType();
            $fk_afield_tableObj = $fk_afield->getTable();
            $fk_afield_moduleObj = $fk_afield_tableObj->getModule();
            $fk_afield_moduleCode = $fk_afield_moduleObj->getVal("module_code");
            $fk_afield_className = $fk_afield_tableObj->valClass_name();
            $fk_afield_table_name = $fk_afield_tableObj->valAtable_name();
            $fk_afield_name = $fk_afield->getVal("field_name");
            $fk_afield_title_ar = $fk_afield->getVal("titre_short");
            $fk_afield_title_en = $fk_afield->getVal("titre_short_en");

            $replace_list_fk_not_part_of_me_replaceable .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::updateWhere(array('$fk_afield_name'=>\$id_replace), \"$fk_afield_name='\$id'\");
                            // \$this->execQuery(\"update \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name set $fk_afield_name='\$id_replace' where $fk_afield_name='\$id' \");
                        }
";

            $replace_val_in_list_of_fk .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::updateWhere(array('$fk_afield_name'=>\$id_replace), \"$fk_afield_name='\$id'\");
                            // \$this->execQuery(\"update \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name set $fk_afield_name='\$id_replace' where $fk_afield_name='\$id' \");
                        }
";
        }

        foreach ($listMFKRelations as $fk_afield) {
            $ert = $fk_afield->hetERType();
            $fk_afield_tableObj = $fk_afield->getTable();
            $fk_afield_moduleObj = $fk_afield_tableObj->getModule();
            $fk_afield_moduleCode = $fk_afield_moduleObj->getVal("module_code");
            $fk_afield_className = $fk_afield_tableObj->valClass_name();
            $fk_afield_table_name = $fk_afield_tableObj->valAtable_name();
            $fk_afield_name = $fk_afield->getVal("field_name");
            $fk_afield_title_ar = $fk_afield->getVal("titre_short");
            $fk_afield_title_en = $fk_afield->getVal("titre_short_en");

            $replace_val_in_list_of_mfk .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::updateWhere(array('$fk_afield_name'=>\"REPLACE($fk_afield_name, ',\$id,', ',\$id_replace,')\"), \"$fk_afield_name like '%,\$id,%'\");
                            // \$this->execQuery(\"update \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name set $fk_afield_name=REPLACE($fk_afield_name, ',\$id,', ',\$id_replace,') where $fk_afield_name like '%,\$id,%' \");
                        }
";

            $remove_val_from_list_of_mfk .=
                "                       // $fk_afield_moduleCode.$fk_afield_table_name-$fk_afield_title_ar	$fk_afield_name  $ert
                        if(!\$simul)
                        {
                            // require_once \"../$fk_afield_moduleCode/$fk_afield_table_name.php\";
                            $fk_afield_className::updateWhere(array('$fk_afield_name'=>\"REPLACE($fk_afield_name, ',\$id,', ',')\"), \"$fk_afield_name like '%,\$id,%'\");
                            // \$this->execQuery(\"update \${server_db_prefix}$fk_afield_moduleCode.$fk_afield_table_name set $fk_afield_name=REPLACE($fk_afield_name, ',\$id,', ',') where $fk_afield_name like '%,\$id,%' \");
                        }
                        
";
        }

        $moduleCodeFU = ucfirst($moduleCode);


        $php_class_code = "
                
${dollar}file_dir_name = dirname(__FILE__); 
                
// require_once(\"${dollar}file_dir_name/../afw/afw.php\");

class $className extends AFWObject{

        $static_constants  ";
        $structClass = $moduleCodeFU . $className . "AfwStructure";

        if (!$dbstruct_outside) {
            $dbstruct_open = "/*";
            $dbstruct_close = "*/";
        } else {

            $arTranslateClass = $className . "ArTranslator";
            $enTranslateClass = $className . "EnTranslator";
            $dbstruct_open = "
        class $structClass
        {
                // token separator = §
                public static function initInstance(&\$obj)
                {
                        if (\$obj instanceof $className ) 
                        {
                                \$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                                \$obj->DISPLAY_FIELD = \"$display_field\";
                                
                                // \$obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                                \$obj->ORDER_BY_FIELDS = \"$order_by_fields\";
                                $IS_LOOKUP 
                                $AUDIT_DATA
                                $clause_ignore_insert_doublon
                                $UNIQUE_KEY
                                $edit_by_step_php
                                // \$obj->after_save_edit = array(\"class\"=>'Road',\"attribute\"=>'road_id', \"currmod\"=>'btb',\"currstep\"=>9);
                                \$obj->after_save_edit = array(\"mode\"=>\"qsearch\", \"currmod\"=>'adm', \"class\"=>'$className',\"submit\"=>true);
                        }
                        else 
                        {
                                $arTranslateClass::initData();
                                $enTranslateClass::initData();
                        }
                }
                
                
                public static \$DB_STRUCTURE = ";
            $dbstruct_close = "     }";
        }


        $dbstruct_code = "
     $dbstruct_open 
     array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

		" . $TDesc . "
                " . $php_one_to_many_relations . "
                '$fld_creation_user_id'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, \"TECH_FIELDS-RETRIEVE\" => true, 'RETRIEVE' => false,  'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                '$fld_creation_date'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, \"TECH_FIELDS-RETRIEVE\" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                '$fld_update_user_id'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, \"TECH_FIELDS-RETRIEVE\" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                '$fld_update_date'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, \"TECH_FIELDS-RETRIEVE\" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                '$fld_validation_user_id'       => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                '$fld_validation_date'       => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                '$fld_active'             => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => $fld_active_edit, 'QEDIT' => $fld_active_qedit, \"DEFAULT\" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                '$fld_version'            => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),
                'draft'             => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => $fld_active_edit, 'QEDIT' => $fld_active_qedit, \"DEFAULT\" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'update_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'delete_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'display_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'sci_id'            => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'tech_notes' 	      => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', \"SHOW-ADMIN\" => true, 'TOKEN_SEP'=>\"§\", 'READONLY' =>true, \"NO-ERROR-CHECK\"=>true, 'FGROUP' => 'tech_fields'),
	);  
    
    $dbstruct_close
    ";



        if (!$dbstruct_outside) {
            $php_class_code .= $dbstruct_code;
        }

        if ($dbstruct_only) return array($dbstruct_code, $phpErrors, "");


        $php_class_code .= "
        public static \$DATABASE		= \"$prefixed_db_name\";
        public static \$MODULE		        = \"$moduleCode\";        
        public static \$TABLE			= \"$tabName\";

	    public static \$DB_STRUCTURE = null;
	
	    public function __construct(){
		parent::__construct(\"$tabName\",\"id\",\"$dbName\");
            $structClass::initInstance(\$this);    
	    }
        
        public static function loadById(\$id)
        {
           \$obj = new $className();
           \$obj->select_visibilite_horizontale();
           if(\$obj->load(\$id))
           {
                return \$obj;
           }
           else return null;
        }
        
        $loadAll_method

        $stepToSCI_method
        
        $php_loadByMainIndex_method
        $php_display_method
        
$enumAtable_functions
        
        protected function getOtherLinksArray(\$mode,\$genereLog=false,\$step=\"all\")      
        {
             global \$lang;
             // \$objme = AfwSession::getUserConnected();
             // \$me = (\$objme) ? \$objme->id : 0;

             \$otherLinksArray = \$this->getOtherLinksArrayStandard(\$mode,\$genereLog,\$step);
             \$my_id = \$this->getId();
             \$displ = \$this->getDisplay(\$lang);
             
             $php_one_to_many_relations_links
             
             // check errors on all steps (by default no for optimization)
             // rafik don't know why this : \// $obj->general_check_errors = false;
             
             return \$otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            \$pbms = array();
            
            \$color = \"green\";
            \$title_ar = \"xxxxxxxxxxxxxxxxxxxx\"; 
            \$methodName = \"mmmmmmmmmmmmmmmmmmmmmmm\";
            //\$pbms[AfwStringHelper::hzmEncode(\$methodName)] = array(\"METHOD\"=>\$methodName,\"COLOR\"=>\$color, \"LABEL_AR\"=>\$title_ar, \"ADMIN-ONLY\"=>true, \"BF-ID\"=>\"\", 'STEP' =>\$this->stepOfAttribute(\"xxyy\"));
            
            
            
            return \$pbms;
        }
        
        public function fld_CREATION_USER_ID()
        {
                return \"$fld_creation_user_id\";
        }

        public function fld_CREATION_DATE()
        {
                return \"$fld_creation_date\";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return \"$fld_update_user_id\";
        }

        public function fld_UPDATE_DATE()
        {
        	return \"$fld_update_date\";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return \"$fld_validation_user_id\";
        }

        public function fld_VALIDATION_DATE()
        {
                return \"$fld_validation_date\";
        }
        
        public function fld_VERSION()
        {
        	return \"$fld_version\";
        }

        public function fld_ACTIVE()
        {
        	return  \"$fld_active\";
        }
        
        public function isTechField(\$attribute) {
            return ((\$attribute==\"$fld_creation_user_id\") or (\$attribute==\"$fld_creation_date\") or (\$attribute==\"$fld_update_user_id\") or (\$attribute==\"$fld_update_date\") or (\$attribute==\"$fld_validation_user_id\") or (\$attribute==\"$fld_validation_date\") or (\$attribute==\"$fld_version\"));  
        }
        
        
        public function beforeDelete(\$id,\$id_replace) 
        {
            \$server_db_prefix = AfwSession::config(\"db_prefix\",\"".$server_db_prefix."\");
            
            if(!\$id)
            {
                \$id = \$this->getId();
                \$simul = true;
            }
            else
            {
                \$simul = false;
            }
            
            if(\$id)
            {   
               if(\$id_replace==0)
               {
                   // FK part of me - not deletable 
$check_list_fk_part_of_me_not_deletable
                        
                   // FK part of me - deletable 
$delete_list_fk_part_of_me_deletable
                   
                   // FK not part of me - replaceable 
$replace_list_fk_not_part_of_me_replaceable
                        
                   
                   // MFK
$remove_val_from_list_of_mfk
               }
               else
               {
                        // FK on me 
$replace_val_in_list_of_fk
                        
                        // MFK
$replace_val_in_list_of_mfk
                   
               } 
               return true;
            }    
	}
             
}
";

        //$list_php_files_to_copy = "";

        if ((!$new_php_file) and (count($newCols))) {
            $new_php_file = "<b><i>old php class but with new cols :(" . implode(",", $newCols) . ") ";
            $new_php_file_end = "</i></b>";
        } else {
            //if($new_php_file) $list_php_files_to_copy .= "copy $dir\\$fileName $prod_dir\\$fileName \n   copy $dir\\trad_ar_$fileName $prod_dir\\trad_ar_$fileName \n";
        }

        //echo "$new_php_file $fileName generated under $dir $new_php_file_end<br>";*/


        return array($php_class_code, $phpErrors, $new_php_file . $new_php_file_end);
    }

    public function generateSQLStructure()
    {

        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $dbName = $this->getModule()->getModuleCode();
        $prefixed_db_name = $server_db_prefix . $dbName;

        $module = $this->getModule();
        if ($module) {
            $dbsystem_id = $module->getVal("dbsystem_id");
            $dbengine_id = $module->getVal("dbengine_id");
            $dbsystem = Dbsystem::loadById($dbsystem_id);
            $dbengine = Dbengine::loadById($dbengine_id);
        } else {
            $dbsystem = null;
            $dbengine = null;
        }

        $dbms = "";

        if ($dbsystem) $dbms = strtolower($dbsystem->getVal("dbsystem_code"));
        if ($dbms == "mysql") $dbms = "sql";
        if ((!$dbms) or (!$dbsystem) or (!$dbengine)) return "Please define db system and engine of module [$module] for the table [$this]";

        $syntax_values = $dbsystem->loadSyntax();


        $tables_naming_uc = ($dbengine->getVal("tables_naming_uc") == 'Y');
        $fields_naming_uc = ($dbengine->getVal("fields_naming_uc") == 'Y');

        $table_autoinc_after = ($this->getVal("id_auto_increment") == "Y") ? $syntax_values["AUTO_INCREMENT_OPTION"] : "";

        $engine_code = $this->get("dbengine_id")->valDbengine_code();
        $table_utf8 = ($this->getVal("utf8") == "Y");

        $utf8_charset_syntax = $syntax_values["UTF8_CHARSET_SYNTAX"];
        $latin_charset_syntax = $syntax_values["LATIN_CHARSET_SYNTAX"];


        if ($this->isLookup() and ((!$this->hasManyData()) or ($this->hasOption(self::$TBOPTION_LOOKUPCODE))))
            $lkp_column = $syntax_values["LOOKUP_CODE_COLUMN"];
        else
            $lkp_column = "";

        $table_charset = $table_utf8 ?  $utf8_charset_syntax : $latin_charset_syntax;


        $syntax_values["LOOKUP_CODE_SENTENCE"] = $table_charset;
        $syntax_values["TABLE_CHARSET"] = $table_charset;
        $syntax_values["TABLE_AUTOINC_AFTER"] = $table_autoinc_after;
        $syntax_values["ENGINE_CODE"] = $engine_code;
        $syntax_values["TABLE_AUTOINC_AFTER"] = $table_autoinc_after;
        $syntax_values["LOOKUP_CODE_COL"] = $lkp_column;

        $table_name = $this->valAtable_name();
        if ($tables_naming_uc) $table_name = strtoupper($table_name);

        $syntax_values["TABLE_NAME"] = $table_name;
        $syntax_values["DB_NAME"] = $prefixed_db_name;

        $table_titre_u = $this->valTitre_u();



        //$utf8_syntax["sql"] = "CHARACTER SET utf8 COLLATE utf8_unicode_ci";
        //$null_syntax["sql"] = "DEFAULT NULL";
        //$notnull_syntax["sql"] = "NOT NULL";

        $file_dir_name = dirname(__FILE__);
        $module = $this->myModuleCode();

        $module_config_file = "$file_dir_name/../../$module/module_config.php";
        if (!file_exists($module_config_file)) {
            throw new AfwRuntimeException("file $module_config_file not found");
        } else {
            include($module_config_file);
            $fld_creation_user_id   = $TECH_FIELDS[$module]["CREATION_USER_ID_FIELD"];
            $fld_creation_date      = $TECH_FIELDS[$module]["CREATION_DATE_FIELD"];
            $fld_update_user_id     = $TECH_FIELDS[$module]["UPDATE_USER_ID_FIELD"];
            $fld_update_date        = $TECH_FIELDS[$module]["UPDATE_DATE_FIELD"];
            $fld_validation_user_id = $TECH_FIELDS[$module]["VALIDATION_USER_ID_FIELD"];
            $fld_validation_date    = $TECH_FIELDS[$module]["VALIDATION_DATE_FIELD"];
            $fld_active             = $TECH_FIELDS[$module]["ACTIVE_FIELD"];
            $fld_version            = $TECH_FIELDS[$module]["VERSION_FIELD"];
        }

        if ($fields_naming_uc) {
            $fld_creation_user_id   = strtoupper($fld_creation_user_id);
            $fld_creation_date      = strtoupper($fld_creation_date);
            $fld_update_user_id     = strtoupper($fld_update_user_id);
            $fld_update_date        = strtoupper($fld_update_date);
            $fld_validation_user_id = strtoupper($fld_validation_user_id);
            $fld_validation_date    = strtoupper($fld_validation_date);
            $fld_active             = strtoupper($fld_active);
            $fld_version            = strtoupper($fld_version);
        }

        $syntax_values["FLD_CREATION_USER_ID"] = $fld_creation_user_id;
        $syntax_values["FLD_CREATION_DATE"] = $fld_creation_date;
        $syntax_values["FLD_UPDATE_USER_ID"] = $fld_update_user_id;
        $syntax_values["FLD_UPDATE_DATE"] = $fld_update_date;
        $syntax_values["FLD_VALIDATION_USER_ID"] = $fld_validation_user_id;
        $syntax_values["FLD_VALIDATION_DATE"] = $fld_validation_date;
        $syntax_values["FLD_ACTIVE"] = $fld_active;
        $syntax_values["FLD_VERSION"] = $fld_version;






        $columns_sql = "";

        // require_once("afield.php");

        $af_reel = new Afield();

        $af_reel->select("atable_id", $this->getId());
        $af_reel->select("avail", 'Y');
        $af_reel->select("reel", 'Y');

        $af_reel_list = $af_reel->loadMany($limit = "", $order_by = "field_order asc, afield_type_id asc, field_name asc");

        if (count($af_reel_list) == 0) {
            $af_new = new Afield();
            $af_new->set("atable_id", $this->getId());
            $af_new->set("reel", 'Y');
            $af_new->set("utf8", 'Y');
            $af_new->set("mandatory", 'Y');
            $af_new->set("afield_type_id", 10);
            $af_new->set("field_name", $table_name . "_name");
            $af_new->set("titre", "مسمى " . $table_titre_u);
            $af_new->set("field_size", 32);

            $af_new->insert();
            $af_reel_list[$af_new->getId()] = $af_new;
        }


        $column_comment_model = $syntax_values["COLUMN_COMMENT"];    // ex oracle : comment on column [TABLE_NAME].[COL1] is '[COL1_DESC]'

        $alter_table_add_field_arr = array();

        foreach ($af_reel_list as $af_reel_id => $af_reel_obj) {
            $af_field_name = $af_reel_obj->getVal("field_name");
            if ($fields_naming_uc) $af_field_name = strtoupper($af_field_name);

            $af_field_desc = $af_reel_obj->getVal("titre_short");

            $column_comment = str_replace("[TABLE_NAME]", $table_name, $column_comment_model);
            $column_comment = str_replace("[DB_NAME]", $prefixed_db_name, $column_comment);
            $column_comment = str_replace("[COL1]", $af_field_name, $column_comment);
            $column_comment = str_replace("[COL1_DESC]", $af_field_desc, $column_comment);
            $column_comment_sentence_arr[] = $column_comment;

            $columns_sql .= $af_reel_obj->getGeneraltedSQL($dbms, $syntax_values, $fields_naming_uc);
            $alter_table_add_field_arr[] = $af_reel_obj->calc("sql");
        }

        $sql_column_comment_sentence_items = implode(";\n", $column_comment_sentence_arr);

        $table_body = "";

        $syntax_values["COLUMNS"] = $columns_sql;
        $syntax_values["COLUMN_COMMENTS"] = $sql_column_comment_sentence_items;


        $table_body = $syntax_values["DROP_TABLE_SENTENCE"] . "\n\n" . $syntax_values["CREATE_TABLE_SENTENCE"];

        unset($syntax_values["DROP_TABLE_SENTENCE"]);
        unset($syntax_values["CREATE_TABLE_SENTENCE"]);

        foreach ($syntax_values as $syntax_code => $syntax_value) {
            $table_body = str_replace("[$syntax_code]", $syntax_value, $table_body);
        }


        // 

        // $alter_table_sentence_model = $syntax_values["ALTER_TABLE_ADD"];     // ex oracle : alter table [TABLE_NAME] add ([ALTER_TABLE_ADDS]);
        $foreign_key_sentence_model = $syntax_values["FOREIGN_KEY"];


        $af_fk = new Afield();

        $af_fk->select("atable_id", $this->getId());
        $af_fk->select("avail", 'Y');
        $af_fk->select("reel", 'Y');
        $af_fk->select("afield_type_id", 5);
        $af_fk->where("answer_table_id > 0");

        $af_fk_list = $af_fk->loadMany($limit = "", $order_by = "field_order asc, afield_type_id asc, field_name asc");

        $foreign_key_sentence_arr = array();

        foreach ($af_fk_list as $af_fk_id => $af_fk_obj) {
            $fk_table = $af_fk_obj->getAnsTable();
            // fk table and table should be in the same system module to create a FK
            if ($fk_table->getVal("id_module") == $this->getVal("id_module")) {
                $fk_table_pk = "id";
                $fk_field_name = $af_fk_obj->getVal("field_name");
                if ($fields_naming_uc) $fk_field_name = strtoupper($fk_field_name);
                if ($fields_naming_uc) $fk_table_pk = strtoupper($fk_table_pk);

                $fk_table_name = $fk_table->valAtable_name();
                if ($tables_naming_uc) $fk_table_name = strtoupper($fk_table_name);
                // ex for oracle : constraint FK_[TABLE1]_[COL1]_RF_[TABLE2] foreign key ([COL1]) references [TABLE2] ([PK2])
                $foreign_key_sentence = str_replace("[TABLE1]", $table_name, $foreign_key_sentence_model);
                $foreign_key_sentence = str_replace("[TABLE2]", $fk_table_name, $foreign_key_sentence);
                $foreign_key_sentence = str_replace("[PK2]", $fk_table_pk, $foreign_key_sentence);
                $foreign_key_sentence = str_replace("[COL1]", $fk_field_name, $foreign_key_sentence);
                $foreign_key_sentence_arr[] = $foreign_key_sentence;
            }
        }
        // die(var_export($foreign_key_sentence_arr,true));
        $sql_foreign_key_sentence_items = implode("\n", $foreign_key_sentence_arr);

        $sql_foreign_key_sentence_items .= implode("\n", $alter_table_add_field_arr);
        /*
               if($this->isLookup() and ((!$this->hasManyData()) or ($this->hasOption(self::$TBOPTION_LOOKUPCODE)))) 
               {
                    $indx_cols = array("lookup_code");
               }
               else
               {
                    list($indx_cols, $indx_afield_list) = $this->getMainIndexFieldList();
               }*/


        list($indx_cols, $indx_afield_list) = $this->getMainIndexFieldList();

        $unique_index_sentence = "";
        if (count($indx_cols) > 0) {
            $unique_index_sentence_model = $syntax_values["UNIQUE_INDEX"];
            $unique_index_sentence = $unique_index_sentence_model;
            $unique_index_sentence = str_replace("[TABLE_NAME]", $table_name, $unique_index_sentence);
            $unique_index_sentence = str_replace("[DB_NAME]", $prefixed_db_name, $unique_index_sentence);
            $unique_index_sentence = str_replace("[LISTE_COL_U_INDEX]", implode(",", $indx_cols), $unique_index_sentence);
        }

        if ($unique_index_sentence) $sql_foreign_key_sentence_items .= "\n\n-- unique index : \n" . $unique_index_sentence . "\n\n";


        //die(var_export($sql_foreign_key_sentence_items,true));
        // $alter_table_foreign_keys_sentence = str_replace("[TABLE_NAME]",$table_name,$alter_table_sentence_model);
        // $alter_table_foreign_keys_sentence = str_replace("[ALTER_TABLE_ADDS]",$sql_foreign_key_sentence_items,$alter_table_foreign_keys_sentence);

        // $table_body = str_replace("[FOREIGN_KEYS]",$alter_table_foreign_keys_sentence,$table_body);
        if ($this->isLookup() and ((!$this->hasManyData()) or ($this->hasOption(self::$TBOPTION_LOOKUPCODE)))) {
            $lookupValueList = $this->get("lookupValueList");
            $table_body .= "\n\n -- lookupValueList\n";
            // $active_col = $this->fld_ACTIVE();
            // $version_col = $this->fld_VERSION();
            foreach ($lookupValueList as $lookupValueObj) {
                $pkey =  $lookupValueObj->getVal("pkey");
                $vcode = $lookupValueObj->getVal("vcode");
                $value = $lookupValueObj->getVal("value");

                $display_field_ar = $this->getDisplayField("ar");
                $display_field_en = $this->getDisplayField("en");

                $table_body .= "   insert into $prefixed_db_name.$table_name (id, lookup_code, $display_field_ar, $display_field_en, $fld_active, $fld_version) values ('$pkey','$vcode','$value','$vcode', 'Y', 0);\n";
            }
        }

        if ($this->estAuditable()) {
            $auditFieldList = $this->get("auditFieldList");
            foreach ($auditFieldList as $auditFieldItem) {
                $field_name = $auditFieldItem->getVal("field_name");
                $haudit_table_name = "${table_name}_${field_name}_haudit";
                $table_body .= "\n\n\n

-- audit table for ${table_name}.${field_name} field

DROP TABLE IF EXISTS $prefixed_db_name.`$haudit_table_name`;

CREATE TABLE IF NOT EXISTS $prefixed_db_name.`$haudit_table_name` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `version` INT(4) NOT NULL,
  `val` VARCHAR(255) DEFAULT NULL,
  `update_date` datetime NOT NULL,
  `update_auser_id` INT(11) NOT NULL,
  `update_context` VARCHAR(255) DEFAULT NULL,
 
 
  PRIMARY KEY (`id`, `version`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;\n";
            }
        }

        return array($table_body, $sql_foreign_key_sentence_items);
    }

    public function select_visibilite_horizontale($dropdown = false)
    {
        $me = AfwSession::getUserIdActing();
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
        $this->select_visibilite_horizontale_default();

        $this->where("(me.id_aut = '$me' or me.id_module in (select mu.id_module from ${server_db_prefix}ums.module_auser mu where mu.id_auser = '$me' and mu.avail='Y'))");
    }

    public function afterInsert($id, $fields_updated)
    {
        return $this->createDefaultFields();
    }


    public function beforeMaj($id, $fields_updated)
    {
        //if(!$this->getVal("atable_name")) return false;

        //$this->createDefaultFields();

        if ($this->getVal("system_id") == 1) {
            if (!$this->getVal("id")) {
                $this->where("id < 10000");
                $new_id = $this->func("max(id)+1");
                if ($new_id < 100000) $this->set("id", $new_id);
            }
        }


        $this_table_name = $this->getVal("atable_name");
        $single_en = AfwStringHelper::toEnglishText(strtolower($this_table_name));
        $plural_en = $single_en."s";
        if (
            AfwStringHelper::stringStartsWith($this->getVal("titre_short_en"), "--") or
            AfwStringHelper::stringStartsWith($this->getVal("titre_short_en"), "??")
        ) {
            $this->set("titre_short_en", "");
        }

        if (
            AfwStringHelper::stringStartsWith($this->getVal("titre_u_en"), "--") or
            AfwStringHelper::stringStartsWith($this->getVal("titre_u_en"), "??")
        ) {
            $this->set("titre_u_en", "");
        }

        if (
            AfwStringHelper::stringStartsWith($this->getVal("titre_en"), "--") or
            AfwStringHelper::stringStartsWith($this->getVal("titre_en"), "??")
        ) {
            $this->set("titre_en", "");
        }

        if (!trim($this->getVal("titre_u_en"))) {
            $this->set("titre_u_en", $single_en);
        }

        if (!trim($this->getVal("titre_short_en"))) {
            $this->set("titre_short_en", $this->getVal("titre_u_en") . "s");
        }


        if (!trim($this->getVal("titre_short"))) {
            $this->set("titre_short", $this->getVal("titre"));
        }

        if (!trim($this->getVal("titre"))) {
            $this->set("titre", $this->getVal("titre_short"));
        }

        if (!$this->getVal("titre_en")) {
            $this->set("titre_en", $this->getVal("titre_short_en"));
        }

        if (!$this->getVal("titre_short_en")) {
            $this->set("titre_short_en", $this->getVal("titre_en"));
        }

        

        if (!$this->getVal("titre_en")) {
            $this->set("titre_en", $plural_en);
        }

        if (!$this->getVal("titre_short_en")) {
            $this->set("titre_short_en", $plural_en);
        }

        if (!$this->getVal("titre_en")) {
            $this->set("titre_en", $plural_en);
        }

        if (!$this->getVal("dbengine_id")) {
            $this->set("dbengine_id", 2);
        }

        /*
                Module and Sub-module should be different in new version of hazm framework
                if(!$this->getVal("id_sub_module")) {
                           $this->set("id_sub_module",$this->getVal("id_module"));
                }*/

        if ($this->getVal("display_field") == "--") {
            $this->set("display_field", "");
        }

        if (!$this->getVal("display_field")) {
            $this->set("display_field", $this->getDisplayField());
        }

        if ($this->isLookup()) {
            $module = $this->hetModule();
            if ($module) $module->updateLookupGoal();

            if (!$this->getVal("jobrole_id")) {
                $jr_lookup = null;
                if ($module) list($jr_lookup, $goal_lookup) = $module->getLookupJobResp(true, true);

                if ($jr_lookup) $this->set("jobrole_id", $jr_lookup->getId());
            }
        }

        /*
                bau-v2
                
                
                if(!$this->getVal("jobrole_mfk"))
                {         
                      if($this->getVal("jobrole_id"))
                      {
                           $this->set("jobrole_mfk",",".$this->getVal("jobrole_id").",");
                      }
                      else
                      {    $subMod = $this->hetSubModule();
                           if($subMod) $this->set("jobrole_mfk",$subMod->getVal("jobrole_mfk"));
                      }                                 
                }
                */


        return true;
    }
    /* rafik / 22-06-2020 : I am afraid this cause error out of memory when table is big, to be studied : 
        public function getLookupData($lookup_col="lookup_code",$display_col="") {

               $lookup_arr = array();
                   
               if($this->isOriginal()) 
               {
                       $table = $this->valAtable_name();
                       $module = $this->myModuleCode();
                       list($fileName,$className) = AfwStringHelper::getHisFactory($table, $module);
                       
                       require_once $fileName;
                       
                       $aaa = new $className();
                       
                       $aaa->select($aaa->fld_ACTIVE(), 'Y');
                       $aaa_arr = $aaa->loadMany();
                       foreach($aaa_arr as $aaa_id => $aaa_item) {
                            $lookup_code = $aaa_item->getVal($lookup_col);
                            if($display_col) $lookup_val = $aaa_item->getVal($display_col);
                            else $lookup_val = $aaa_item->getDisplay();
                            $lookup_arr[$lookup_code] = $lookup_val; 
                       }
                       
                       return $lookup_arr;
               }
               else {
                     $tblid = $this->getId();
                     
                     $file_dir_name = dirname(__FILE__); 
                     //require_once("$file_dir_name/../rfw/rfw.php");
                     require_once("$file_dir_name/../rfw/rfw_factory.php");
                                                                                                                                                                                                                  22
                     $rfwFactoryObj = new RFWFactory();
                     $myRfw =& $rfwFactoryObj->getObject($tblid);
                     $myRfw->select("active", 'Y');
                     return array("todo"=>"to implement getLookupData for rfw ");                  
               }
        
        }
        */

    public function getLookupEnum($lookup_col = "lookup_code")
    {

        $lookup_arr = array();
        /*    
               if($this->isOriginal()) 
               {
                       $table = $this->valAtable_name();
                       $module = $this->myModuleCode();
                       list($fileName,$className) = AfwStringHelper::getHisFactory($table, $module);
                       
                       require_once $fileName;
                       
                       $aaa = new $className();
                       
                       $aaa->select($aaa->fld_ACTIVE(), 'Y');
                       $aaa_arr = $aaa->loadMany();
                       
                       //if($className=="Genre") die(var_export(array("aaaa_arr"=>$aaa_arr, "aaa" => $aaa),true));
                       
                       foreach($aaa_arr as $aaa_id => $aaa_item) {
                            $lookup_code = $aaa_item->getVal($lookup_col);
                            $lookup_id = $aaa_item->getId();
                            
                            $lookup_arr[$lookup_id] = $lookup_code; 
                       }
                       
                       return $lookup_arr;
               }
               else {
                     $tblid = $this->getId();
                     
                     $file_dir_name = dirname(__FILE__); 
                     //require_once("$file_dir_name/../rfw/rfw.php");
                     require_once("$file_dir_name/../rfw/rfw_factory.php");
                     
                     $rfwFactoryObj = new RFWFactory();
                     $myRfw =& $rfwFactoryObj->getObject($tblid);
                     $myRfw->select("active", 'Y');
                     return array("todo"=>"to implement getLookupEnum for rfw ");                  
               }
               */
    }
    /*
    public function beforeDelete($id, $id_replace)
    {
        if ($id_replace == 0) {
            // require_once("afield.php");
            $af = new Afield();
            $af->deleteWhere("atable_id = $id");
        } else {
            // require_once("afield.php");
            $af = new Afield();
            $af->select("atable_id", $id);
            $af->set("atable_id", $id_replace);
            $af->update(false);
        }
        return true;
    }*/

    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

        if (!$id) {
            $id = $this->getId();
            $simul = true;
        } else {
            $simul = false;
        }

        if ($id) {
            if ($id_replace == 0) {
                // FK part of me - not deletable 
                // ums.bfunction-الجدول	curr_class_atable_id  OneToMany (required field)
                // require_once "../ums/bfunction.php";
                $obj = new Bfunction();
                $obj->where("curr_class_atable_id = '$id' and avail='Y' ");
                $nbRecords = $obj->count();
                // check if there's no record that block the delete operation
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some business functions(s) as Curr class atable";
                    return false;
                }
                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                if (!$simul) $obj->deleteWhere("curr_class_atable_id = '$id' and avail='N'");

                // pag.afield-الجدول	atable_id  OneToMany (required field)
                // require_once "../pag/afield.php";
                $obj = new Afield();
                $obj->where("atable_id = '$id' and avail='Y' ");
                $nbRecords = $obj->count();
                // check if there's no record that block the delete operation
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Afields(s) as Atable";
                    return false;
                }
                // if there's no record that block the delete operation perform the delete of the other records linked with me and deletable
                if (!$simul) $obj->deleteWhere("atable_id = '$id' and avail='N'");



                // FK part of me - deletable 
                // bau.ptext-متعلق بـــالكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/ptext.php";
                    Ptext::removeWhere("id_atable='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}bau.ptext where id_atable = '$id' ");

                }


                // pag.scenario_item-الجدول	atable_id  OneToMany
                if (!$simul) {
                    // require_once "../pag/scenario_item.php";
                    ScenarioItem::removeWhere("atable_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}pag.scenario_item where atable_id = '$id' ");

                }


                // pag.db_link-الجدول المنادي	tab1_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::removeWhere("tab1_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}pag.db_link where tab1_id = '$id' ");

                }


                // pag.db_link-الجدول المنادى عليه	tab2_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::removeWhere("tab2_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}pag.db_link where tab2_id = '$id' ");

                }


                // pag.pmessage-متعلق بالكيان	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/pmessage.php";
                    Pmessage::removeWhere("atable_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}pag.pmessage where atable_id = '$id' ");

                }


                // bau.theme-الكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/theme.php";
                    Theme::removeWhere("id_atable='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}bau.theme where id_atable = '$id' ");

                }





                // pag.lookup_value-الجدول/الكيان	atable_id  OneToMany
                if (!$simul) {
                    // require_once "../pag/lookup_value.php";
                    LookupValue::removeWhere("atable_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}pag.lookup_value where atable_id = '$id' ");

                }


                // pag.afield_group-الجدول	atable_id  OneToMany
                if (!$simul) {
                    // require_once "../pag/afield_group.php";
                    AfieldGroup::removeWhere("atable_id='$id'");
                    // $this->execQuery("delete from ${server_db_prefix}pag.afield_group where atable_id = '$id' ");

                }




                // FK not part of me - replaceable 
                // pag.afield-جدول قائمة الإختيارات	answer_table_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/afield.php";
                    Afield::updateWhere(array('answer_table_id' => $id_replace), "answer_table_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.afield set answer_table_id='$id_replace' where answer_table_id='$id' ");
                }
                // bau.ptext-متعلق بـــالكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/ptext.php";
                    Ptext::updateWhere(array('id_atable' => $id_replace), "id_atable='$id'");
                    // $this->execQuery("update ${server_db_prefix}bau.ptext set id_atable='$id_replace' where id_atable='$id' ");
                }
                // pag.db_link-الجدول المنادي	tab1_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::updateWhere(array('tab1_id' => $id_replace), "tab1_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.db_link set tab1_id='$id_replace' where tab1_id='$id' ");
                }
                // pag.db_link-الجدول المنادى عليه	tab2_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::updateWhere(array('tab2_id' => $id_replace), "tab2_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.db_link set tab2_id='$id_replace' where tab2_id='$id' ");
                }
                // pag.pmessage-متعلق بالكيان	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/pmessage.php";
                    Pmessage::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.pmessage set atable_id='$id_replace' where atable_id='$id' ");
                }
                // bau.theme-الكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/theme.php";
                    Theme::updateWhere(array('id_atable' => $id_replace), "id_atable='$id'");
                    // $this->execQuery("update ${server_db_prefix}bau.theme set id_atable='$id_replace' where id_atable='$id' ");
                }
                // pag.eimport-الكيان المتعلق	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/eimport.php";
                    Eimport::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.eimport set atable_id='$id_replace' where atable_id='$id' ");
                }
                // pag.several_option-الكيان الذي يقع عليه الإجراء	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/several_option.php";
                    SeveralOption::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.several_option set atable_id='$id_replace' where atable_id='$id' ");
                }
                // pag.several_option-كيان الإجراء نفسه	option_table_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/several_option.php";
                    SeveralOption::updateWhere(array('option_table_id' => $id_replace), "option_table_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.several_option set option_table_id='$id_replace' where option_table_id='$id' ");
                }
                // pag.eimport_record-الجدول الذي احتوى السجل المستورد	record_atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/eimport_record.php";
                    EimportRecord::updateWhere(array('record_atable_id' => $id_replace), "record_atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.eimport_record set record_atable_id='$id_replace' where record_atable_id='$id' ");
                }




                // MFK
                // bau.gfield-البيانات الاضافية المتعلقة بالمعلومة	atable_mfk  
                if (!$simul) {
                    // require_once "../bau/gfield.php";
                    Gfield::updateWhere(array('atable_mfk' => "REPLACE(atable_mfk, ',$id,', ',')"), "atable_mfk like '%,$id,%'");
                    // $this->execQuery("update ${server_db_prefix}bau.gfield set atable_mfk=REPLACE(atable_mfk, ',$id,', ',') where atable_mfk like '%,$id,%' ");
                }

                // bau.goal-الكيانات المستعملة	atable_mfk  
                if (!$simul) {
                    // require_once "../bau/goal.php";
                    Goal::updateWhere(array('atable_mfk' => "REPLACE(atable_mfk, ',$id,', ',')"), "atable_mfk like '%,$id,%'");
                    // $this->execQuery("update ${server_db_prefix}bau.goal set atable_mfk=REPLACE(atable_mfk, ',$id,', ',') where atable_mfk like '%,$id,%' ");
                }

                // bau.goal_concern-الكيانات المستعملة	atable_mfk  
                if (!$simul) {
                    // require_once "../bau/goal_concern.php";
                    GoalConcern::updateWhere(array('atable_mfk' => "REPLACE(atable_mfk, ',$id,', ',')"), "atable_mfk like '%,$id,%'");
                    // $this->execQuery("update ${server_db_prefix}bau.goal_concern set atable_mfk=REPLACE(atable_mfk, ',$id,', ',') where atable_mfk like '%,$id,%' ");
                }
            } else {
                // FK on me 


                // ums.bfunction-الجدول	curr_class_atable_id  OneToMany (required field)
                if (!$simul) {
                    // require_once "../ums/bfunction.php";
                    Bfunction::updateWhere(array('curr_class_atable_id' => $id_replace), "curr_class_atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}ums.bfunction set curr_class_atable_id='$id_replace' where curr_class_atable_id='$id' ");

                }




                // pag.afield-الجدول	atable_id  OneToMany (required field)
                if (!$simul) {
                    // require_once "../pag/afield.php";
                    Afield::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.afield set atable_id='$id_replace' where atable_id='$id' ");

                }


                // bau.ptext-متعلق بـــالكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/ptext.php";
                    Ptext::updateWhere(array('id_atable' => $id_replace), "id_atable='$id'");
                    // $this->execQuery("update ${server_db_prefix}bau.ptext set id_atable='$id_replace' where id_atable='$id' ");

                }

                // pag.scenario_item-الجدول	atable_id  OneToMany
                if (!$simul) {
                    // require_once "../pag/scenario_item.php";
                    ScenarioItem::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.scenario_item set atable_id='$id_replace' where atable_id='$id' ");

                }

                // pag.db_link-الجدول المنادي	tab1_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::updateWhere(array('tab1_id' => $id_replace), "tab1_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.db_link set tab1_id='$id_replace' where tab1_id='$id' ");

                }

                // pag.db_link-الجدول المنادى عليه	tab2_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::updateWhere(array('tab2_id' => $id_replace), "tab2_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.db_link set tab2_id='$id_replace' where tab2_id='$id' ");

                }

                // pag.pmessage-متعلق بالكيان	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/pmessage.php";
                    Pmessage::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.pmessage set atable_id='$id_replace' where atable_id='$id' ");

                }

                // bau.theme-الكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/theme.php";
                    Theme::updateWhere(array('id_atable' => $id_replace), "id_atable='$id'");
                    // $this->execQuery("update ${server_db_prefix}bau.theme set id_atable='$id_replace' where id_atable='$id' ");

                }



                // pag.lookup_value-الجدول/الكيان	atable_id  OneToMany
                if (!$simul) {
                    // require_once "../pag/lookup_value.php";
                    LookupValue::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.lookup_value set atable_id='$id_replace' where atable_id='$id' ");

                }

                // pag.afield_group-الجدول	atable_id  OneToMany
                if (!$simul) {
                    // require_once "../pag/afield_group.php";
                    AfieldGroup::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.afield_group set atable_id='$id_replace' where atable_id='$id' ");

                }

                // pag.afield-جدول قائمة الإختيارات	answer_table_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/afield.php";
                    Afield::updateWhere(array('answer_table_id' => $id_replace), "answer_table_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.afield set answer_table_id='$id_replace' where answer_table_id='$id' ");
                }
                // bau.ptext-متعلق بـــالكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/ptext.php";
                    Ptext::updateWhere(array('id_atable' => $id_replace), "id_atable='$id'");
                    // $this->execQuery("update ${server_db_prefix}bau.ptext set id_atable='$id_replace' where id_atable='$id' ");
                }
                // pag.db_link-الجدول المنادي	tab1_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::updateWhere(array('tab1_id' => $id_replace), "tab1_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.db_link set tab1_id='$id_replace' where tab1_id='$id' ");
                }
                // pag.db_link-الجدول المنادى عليه	tab2_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/db_link.php";
                    DbLink::updateWhere(array('tab2_id' => $id_replace), "tab2_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.db_link set tab2_id='$id_replace' where tab2_id='$id' ");
                }
                // pag.pmessage-متعلق بالكيان	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/pmessage.php";
                    Pmessage::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.pmessage set atable_id='$id_replace' where atable_id='$id' ");
                }
                // bau.theme-الكيان	id_atable  ManyToOne
                if (!$simul) {
                    // require_once "../bau/theme.php";
                    Theme::updateWhere(array('id_atable' => $id_replace), "id_atable='$id'");
                    // $this->execQuery("update ${server_db_prefix}bau.theme set id_atable='$id_replace' where id_atable='$id' ");
                }
                // pag.eimport-الكيان المتعلق	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/eimport.php";
                    Eimport::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.eimport set atable_id='$id_replace' where atable_id='$id' ");
                }
                // pag.several_option-الكيان الذي يقع عليه الإجراء	atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/several_option.php";
                    SeveralOption::updateWhere(array('atable_id' => $id_replace), "atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.several_option set atable_id='$id_replace' where atable_id='$id' ");
                }
                // pag.several_option-كيان الإجراء نفسه	option_table_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/several_option.php";
                    SeveralOption::updateWhere(array('option_table_id' => $id_replace), "option_table_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.several_option set option_table_id='$id_replace' where option_table_id='$id' ");
                }
                // pag.eimport_record-الجدول الذي احتوى السجل المستورد	record_atable_id  ManyToOne
                if (!$simul) {
                    // require_once "../pag/eimport_record.php";
                    EimportRecord::updateWhere(array('record_atable_id' => $id_replace), "record_atable_id='$id'");
                    // $this->execQuery("update ${server_db_prefix}pag.eimport_record set record_atable_id='$id_replace' where record_atable_id='$id' ");
                }



                // MFK
                // bau.gfield-البيانات الاضافية المتعلقة بالمعلومة	atable_mfk  
                if (!$simul) {
                    // require_once "../bau/gfield.php";
                    Gfield::updateWhere(array('atable_mfk' => "REPLACE(atable_mfk, ',$id,', ',$id_replace,')"), "atable_mfk like '%,$id,%'");
                    // $this->execQuery("update ${server_db_prefix}bau.gfield set atable_mfk=REPLACE(atable_mfk, ',$id,', ',$id_replace,') where atable_mfk like '%,$id,%' ");
                }
                // bau.goal-الكيانات المستعملة	atable_mfk  
                if (!$simul) {
                    // require_once "../bau/goal.php";
                    Goal::updateWhere(array('atable_mfk' => "REPLACE(atable_mfk, ',$id,', ',$id_replace,')"), "atable_mfk like '%,$id,%'");
                    // $this->execQuery("update ${server_db_prefix}bau.goal set atable_mfk=REPLACE(atable_mfk, ',$id,', ',$id_replace,') where atable_mfk like '%,$id,%' ");
                }
                // bau.goal_concern-الكيانات المستعملة	atable_mfk  
                if (!$simul) {
                    // require_once "../bau/goal_concern.php";
                    GoalConcern::updateWhere(array('atable_mfk' => "REPLACE(atable_mfk, ',$id,', ',$id_replace,')"), "atable_mfk like '%,$id,%'");
                    // $this->execQuery("update ${server_db_prefix}bau.goal_concern set atable_mfk=REPLACE(atable_mfk, ',$id,', ',$id_replace,') where atable_mfk like '%,$id,%' ");
                }
            }
            return true;
        }
    }

    public function isLookup()
    {
        return ($this->is("is_lookup"));
    }


    public static function getAtableByName($id_module, $atable_name)
    {
        global $cacheSys;
        if ($cacheSys) {
            $atab = $cacheSys->getFromCache("pag", "atable", "$id_module-/-$atable_name", $context = "atable::getAtableByName($id_module, $atable_name)");
        } else $atab = null;
        if (!$atab) {
            $atab = new Atable();
            $atab->select("id_module", $id_module);
            $atab->select("atable_name", $atable_name);
            if ($atab->load()) {
                // as it is the key (id_module, atable_name) is the unique index we dont need to put in cache it is automatic put by unique index
            } else {
                $atab = null;
            }
        }

        return $atab;
    }


    public static function getAtableById($id)
    {

        $atab = new Atable();
        if ($atab->load($id)) {
            return $atab;
        } else {
            return null;
        }
    }


    public function createMyTranslation($field_name_ar, $to_lang = "en")
    {
        $field_name_ar .= "#";
        $my_field_name = str_replace('_ar#', '', $field_name_ar);
        $my_field_name_trans = $my_field_name . "_$to_lang";

        $af_trans = $this->getAFieldByFieldName($my_field_name_trans);
        if (!$af_trans) {
            $afar = $this->getAFieldByFieldName($field_name_ar);
            if ($afar->isText()) {
                $afar->resetAsCopy();
                $afar->set("field_name", $my_field_name_trans);
                $afar->set("titre_short", $afar->getVal("titre_short") . " بالانجليزي");
                $afar->set("titre", $afar->getVal("titre") . " بالانجليزي");
                $afar->set("utf8", 'N');
                $afar->insert();
            } else throw new AfwRuntimeException("$field_name_ar is not a text field");
        }
        return $afar;
    }

    public function hasManyData()
    {
        return ($this->getVal("exp_u_records") > 50);
    }

    public function repareMe($lang="ar")
    {
        $afList = $this->getAllFieldList();
        //die($this->getVal("atable_name")." ".var_export($afList, true));
        $cnt = 0;
        /**
         * @var Afield $afItem
         */
        foreach ($afList as $afItem) {
            $cnt += $afItem->repareMe($lang);
        }

        return $cnt;
    }


    public function reorderFields($lang)
    {
        $scis = $this->getScis();

        $lastorder = 10;

        if (count($scis) == 0) {
            $scis[0] = null;
        }

        foreach ($scis as $sci_id => $sci) {
            $afList = $this->getAllFieldList($sci_id);

            foreach ($afList as $afItem) {
                $afItem->set("field_order", $lastorder);
                $afItem->commit();
                $lastorder += 10;
            }
        }

        $lastorder -= 10;

        return array("", "fields reordered from 10 to $lastorder");
    }

    public function createTranslationFieldsToEnglish($lang)
    {
        return $this->createTranslationFieldsTo("en");
    }

    public function createTranslationFieldsTo($lang = "en", $in_lang_name_ar = "بالانجليزية", $lang_name_en = "")
    {
        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $table_titre_u = $this->valTitre_u();
        $table_titre_u_en = $this->valTitre_u_en();

        $af_tes = new Afield();
        $af_tes->select("atable_id", $this->getId());
        $af_tes->select("reel", 'Y');
        $af_tes->select("avail", 'Y');
        $af_tes->select("afield_type_id", 10);
        $af_tes->where("field_name like '%_$lang'");

        $field_exists_count = $af_tes->count();
        if ((!$this->ignore_initial_translation_fields) and ($field_exists_count == 0)) {
            if ($this->_isEnum() or $this->_isLookup()) {
                $display_field = $this->getVal("display_field");
                $my_atable_name = $this->getVal("atable_name");
                if (!$display_field) $display_field = $my_atable_name . "_name";
                $af_new = new Afield();

                $af_new->set("atable_id", $this->getId());
                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'Y');
                $af_new->set("mandatory", 'Y');
                $af_new->set("afield_type_id", 10);
                $af_new->set("field_name", $display_field . "_" . $lang);
                $af_new->set("titre", "مسمى " . $table_titre_u . " $in_lang_name_ar");
                $af_new->set("titre_en", $table_titre_u_en . " name $lang_name_en");
                $af_new->set("field_size", 64);
                $af_new->set("field_order", 15);

                $af_new->insert();

                return array("", "");
            } else {
                $af_new = new Afield();

                $af_new->set("atable_id", $this->getId());
                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'Y');
                $af_new->set("mandatory", 'Y');
                $af_new->set("afield_type_id", 10);
                $af_new->set("field_name", "titre_short_$lang");
                $af_new->set("titre", "مسمى " . $table_titre_u . " $in_lang_name_ar");
                $af_new->set("titre_en", $table_titre_u_en . " name $lang_name_en");
                $af_new->set("field_size", 64);
                $af_new->set("field_order", 15);

                $af_new->insert();

                unset($af_new);
                $af_new = new Afield();

                $af_new->set("atable_id", $this->getId());
                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'N');
                $af_new->set("mandatory", 'Y');
                $af_new->set("afield_type_id", 10);
                $af_new->set("field_name", "titre_$lang");
                $af_new->set("titre", "وصف " . $table_titre_u . " $in_lang_name_ar");
                $af_new->set("titre_en",  $table_titre_u_en . " description " . $lang_name_en);
                $af_new->set("field_size", 255);
                $af_new->set("field_order", 25);

                $af_new->insert();
                return array("", "");
            }
        }
        return array("لا يمكن انشاء حقول الترجمة على جدول فيه حقول سابقة بنفس اللغة. قم بذلك يدويا", "");
    }

    public function cloneMe($new_module_id = 0, $new_sub_module_id = 0, $new_atable_name = "")
    {
        $orig_atable_name = $this->getVal("atable_name");
        $orig_module_id = $this->getVal("id_module");
        if ((!$new_module_id) or ($orig_module_id == $new_module_id)) {
            $new_module_id = $orig_module_id;
            if (!$new_module_id) {
                $new_sub_module_id = $this->getVal("id_sub_module");
            }
            if (!$new_atable_name) $new_atable_name = "clone_of_$orig_atable_name";
        } else {
            if (!$new_atable_name) $new_atable_name = $orig_atable_name;
        }

        $tab = clone $this;

        $tab->resetAsCopy();
        $tab->set("atable_name", $new_atable_name);
        $tab->set("id_module", $new_module_id);
        $tab->set("id_sub_module", $new_sub_module_id);
        $tab->no_default_fields = true;
        $tab->insert();

        $nb_fields_copied = $this->copyMyFieldsTo($tab);

        return array($tab, $nb_fields_copied);
    }

    public function getTableObj($dest)
    {
        if (is_object($dest)) {
            $destObj = $dest;
        } else {
            $destObj = new Atable();
            if (!$destObj->load($dest)) {
                throw new AfwRuntimeException("can't load destination table $dest to copy fields into");
            }
        }

        return $destObj;
    }

    public function copyMyFieldsTo($dest)
    {
        if (!$dest) {
            throw new AfwRuntimeException("specify destination table to copy fields into !");
        }

        $destObj = $this->getTableObj($dest);

        if ($destObj->getAFieldCount(false) > 0) {
            $destObj_name = $destObj->getVal("atable_name");
            $destObj_id = $destObj->getId();
            $source_name = $this->getVal("atable_name");
            $source_id = $this->getId();
            throw new AfwRuntimeException("source table $source_name($source_id) say :destination table $destObj_name($destObj_id) already contain fields, how to copy new fields in it ??!!");
        }

        // require_once("afield.php");

        $fld = new Afield();
        $fld->select("atable_id", $this->getId());
        $fld->select("avail", 'Y');
        $fld_list = $fld->loadMany();
        $nb_fields_copied = 0;
        foreach ($fld_list as $fld_id => $fld_item) {
            $fld_list[$fld_id]->resetAsCopy();
            $fld_list[$fld_id]->set("atable_id", $destObj->getId());
            if ($fld_list[$fld_id]->insert()) $nb_fields_copied++;
        }

        return $nb_fields_copied;
    }



    public function createDefaultFields($lang = "ar")
    {
        $atable_id = $this->getId();
        if (empty($atable_id)) return;

        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");

        $fieldcount = intval($this->getVal("fieldcount"));

        if ($fieldcount < 3) {
            if ((!$this->no_default_fields) /* and ($this->isLookup())*/) {
                $this_table_name = $this->getVal("atable_name");
                $table_titre_u = $this->valTitre_u();
                $table_titre_u_en = trim(trim(trim($this->valTitre_u_en(), "?"), "؟"));
                if (!$table_titre_u_en) $table_titre_u_en = AfwStringHelper::toEnglishText($this_table_name);
                $atable_id = $this->getId();

                $field_name = "name_ar";  // ${this_table_name}_
                $af_new = Afield::loadByMainIndex($atable_id, $field_name, $create_obj_if_not_found = true);

                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'Y');
                $af_new->set("mandatory", 'Y');
                $af_new->set("mode_qedit", 'Y');
                $af_new->set("afield_type_id", 10);
                $af_new->set("titre_short", "مسمى " . $table_titre_u . " بالعربية");
                $af_new->set("titre_short_en", "Arabic " . $table_titre_u_en . " name");

                $af_new->set("titre", "مسمى " . $table_titre_u . " بالعربية");
                $af_new->set("titre_en", "Arabic " . $table_titre_u_en . " name");
                $af_new->set("field_size", 128);
                $af_new->set("field_min_size", 5);
                $af_new->set("char_group_men", ',2,7,');
                $af_new->commit();

                unset($af_new);
                $field_name = "desc_ar";  // ${this_table_name}_
                $af_new = Afield::loadByMainIndex($atable_id, $field_name, $create_obj_if_not_found = true);

                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'Y');
                $af_new->set("mandatory", 'N');
                $af_new->set("afield_type_id", 11);
                $af_new->set("titre", "وصف " . $table_titre_u . " بالعربية");
                $af_new->set("titre_en", "Arabic " . $table_titre_u_en . " description");
                $af_new->set("titre_short", "وصف " . $table_titre_u . " بالعربية");
                $af_new->set("titre_short_en", "Arabic " . $table_titre_u_en . " description");
                $af_new->commit();

                unset($af_new);
                $field_name = "name_en"; // ${this_table_name}_
                $af_new = Afield::loadByMainIndex($atable_id, $field_name, $create_obj_if_not_found = true);

                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'N');
                $af_new->set("mandatory", 'Y');
                $af_new->set("mode_qedit", 'Y');
                $af_new->set("afield_type_id", 10);
                $af_new->set("titre", "مسمى " . $table_titre_u . " بالانجليزية");
                $af_new->set("titre_en", "English " . $table_titre_u_en . " name");
                $af_new->set("titre_short", "مسمى " . $table_titre_u . " بالانجليزية");
                $af_new->set("titre_short_en", "English " . $table_titre_u_en . " name");
                $af_new->set("field_size", 128);
                $af_new->set("field_min_size", 5);
                $af_new->set("char_group_men", ',1,7,');
                $af_new->commit();


                unset($af_new);
                $field_name = "desc_en";   // ${this_table_name}_
                $af_new = Afield::loadByMainIndex($atable_id, $field_name, $create_obj_if_not_found = true);

                $af_new->set("reel", 'Y');
                $af_new->set("utf8", 'N');
                $af_new->set("mandatory", 'N');
                $af_new->set("afield_type_id", 11);
                $af_new->set("titre", "وصف " . $table_titre_u . " بالانجليزية");
                $af_new->set("titre_en", "English " . $table_titre_u_en . " description");
                $af_new->set("titre_short", "وصف " . $table_titre_u . " بالانجليزية");
                $af_new->set("titre_short_en", "English " . $table_titre_u_en . " description");
                $af_new->commit();

                return array("", "");
            } else return array("لا يسمح بانشاء الحقول المبدئية لمثل هذه الجداول", "");
        }
        return array("لا يمكن انشاء الحقول المبدئية على جدول فيه حقول سابقة. قم بذلك يدويا", "");
    }

    public function createUpdateMySteps($lang = "ar")
    {
        $tabName = $this->getVal("atable_name");
        $className = AfwStringHelper::tableToClass($tabName);
        $module = strtolower($this->getModule()->getModuleCode());

        $rows_updated = 0;
        $rows_inserted = 0;
        $file_dir_name = dirname(__FILE__);
        // require_once ("$file_dir_name/../lib/afw/afw_autoloader.php");
        if ($module) AfwAutoLoader::addModule($module);

        $objClass = new $className();
        $nbSteps = $objClass->editNbSteps;
        if (!$nbSteps) return;

        $cum_steps = array();

        for ($i = 1; $i <= $nbSteps; $i++) {
            $stepcode = "step$i";
            $stepname_ar = $objClass->translate($stepcode, "ar");
            $stepname_en = $objClass->translate($stepcode, "en");

            $cum_steps[$i] = array("stepname_ar" => $stepname_ar, "stepname_en" => $stepname_en, "done" => false,);
        }

        $sci_list = $this->get("scis");

        // require_once("scenario_item.php");
        foreach ($sci_list as $sci_item) {
            $step_num = $sci_item->valstep_num();
            $stepcode = "step$step_num";
            if ($cum_steps[$step_num]["stepname_ar"] != $stepcode) $sci_item->set("step_name_ar", $cum_steps[$step_num]["stepname_ar"]);
            if (($cum_steps[$step_num]["stepname_en"] != $stepcode) or (!$sci_item->valstep_name_en())) $sci_item->set("step_name_en", $cum_steps[$step_num]["stepname_en"]);
            $cum_steps[$step_num]["done"] = true;
            if ($sci_item->update())  $rows_updated++;
        }

        for ($i = 1; $i <= $nbSteps; $i++) {
            if (!$cum_steps[$i]["done"]) {
                unset($sci);
                $sci = ScenarioItem::loadByMainIndex($this->getId(), $i, $cum_steps[$i]["stepname_ar"], $create_obj_if_not_found = true);

                $sci->set("step_name_en", $cum_steps[$i]["stepname_en"]);
                $sci->commit();

                if ($sci->is_new)  $rows_inserted++;
                $cum_steps[$i]["done"] = true;
            }
        }
        return array("", "inserted : $rows_inserted, updated : $rows_updated");
    }

    public function hasOption($option)
    {
        return $this->findInMfk("tboption_mfk", $option, false);
    }

    public function tableCategory()
    {
        if ($this->table_category) return $this->table_category;

        if (!$this->is("real_table")) {
            if ($this->findInMfk("tboption_mfk", self::$TBOPTION_OBJ_IS_VIEW, false)) $this->table_category = "view";
            else $this->table_category = "vobj";
        } elseif ($this->_isEnum()) $this->table_category = "enum";
        elseif ($this->_isLookup()) {
            //die("is lookup");
            if ($this->hasManyData()) $this->table_category = "blookup";
            else $this->table_category = "lookup";
        } elseif ($this->findInMfk("tboption_mfk", self::$TBOPTION_DATA_IS_AUTO_GENERATED, false)) {
            $this->table_category = "detail_generated";
        } elseif ($this->findInMfk("tboption_mfk", self::$TBOPTION_FULL_DETAIL, false)) {
            $this->table_category = "detail_owned";
        } elseif ($this->isDetailTableForOthers()) {
            $this->table_category = "detail";
        } elseif ($this->_isEntity()) $this->table_category = "entity";
        else $this->table_category = "relation";

        return $this->table_category;
    }


    public function disableMyAutoGeneratedBFs($lang = "ar")
    {
        $this_id = $this->getId();
        $server_db_prefix = AfwSession::config("db_prefix","default_db_");
        $framework_id = AfwSession::config("framework_id", 1);
        $file_dir_name = dirname(__FILE__);
        include("$file_dir_name/../../lib/framework_$framework_id" . "_specification.php");

        if ($framework_screens_bfcode_starts_with) $bf_code_starts_with = $framework_screens_bfcode_starts_with . "-";
        else $bf_code_starts_with = "";

        if ((!$this_id) or (!$bf_code_starts_with)) {
            throw new AfwRuntimeException("param [bf_code_starts_with] used to disable auto generated BFs for table [$this_id] not found in framework $framework_id specification file.");
        }







        $rbf = new AroleBf();

        $rbf->where("bfunction_id in (select id from ".$server_db_prefix."ums.bfunction 
                                                where curr_class_atable_id='$this_id' 
                                                  and bfunction_code like '$bf_code_starts_with%') 
                            and (source='auto-generated' or source='' or source is null)");

        $rbf->set($rbf->fld_ACTIVE(), 'N');
        $nb_rbf = $rbf->update(false);

        $bf = new Bfunction();

        $bf->select("curr_class_atable_id", $this_id);
        $bf->where("bfunction_code like '$bf_code_starts_with%'");

        $bf->set($bf->fld_ACTIVE(), 'N');
        $nb_bf = $bf->update(false);

        return array("", "$nb_rbf rbf(s) disabled, $nb_bf bf(s) disabled");
    }

    public function genereUserBFs($lang = "ar")
    {
        $framework_id = AfwSession::config("framework_id", 1);
        list($err0, $inf0) = $this->disableMyAutoGeneratedBFs($lang);
        $bf_arr = $this->createFrameWorkScreens($framework_id);
        $bf_arr_count = count($bf_arr);
        $error = "";
        $info = "";
        if (($bf_arr_count == 1) and ($bf_arr[-1])) $error = "Error happened : some categories/modes are not defined in framework specification file " . var_export($bf_arr, true);
        else $info = "$inf0<br>treated : $bf_arr_count bf(s)";

        return array($error, $info);
    }

    public function createModeScreen($framework_mode, $framework_id = 0, $resetUS = false)
    {
        global $lang;
        if (!$framework_id) $framework_id = AfwSession::config("framework_id", 1);
        // for heavy processes allow bigger seuil
        // $_sql_analysis_seuil_calls = 250;

        $file_dir_name = dirname(__FILE__);

        require("$file_dir_name/../../lib/framework_$framework_id" . "_specification.php");

        $this_id = $this->getId();
        $cat = $this->tableCategory();
        $system_id = $this->calc("system_id");
        if (!$system_id) throw new AfwRuntimeException("failed $this --> createFrameWorkScreens($framework_id,$resetAll) system is not defined for this table (id=$this_id)");

        $direct_access = "N";
        $public = "N";

        $bf_row = array();

        $bf_row_empty = true;
        $framework_mode_item = $framework_mode_list[$framework_mode];

        $atable_name = $this->getVal("atable_name");
        if ($framework_mode_item) {
            $bf_type_code = $framework_mode_item["bf_type"][$cat];
            if (!$bf_type_code) $bf_type_code = $framework_mode_item["bf_type"]["all"];
            if ($bf_type_code) $bf_type = Bfunction::${"BFUNCTION_TYPE_$bf_type_code"};
            else $bf_type = "";
            if (!$bf_type) {
                throw new AfwRuntimeException("Working on $atable_name using framework config [framework_$framework_id], no bf type defined for category : $cat mode $framework_mode");
            }


            if ($framework_mode_item["categories"][$cat]) {
                $titre = $this->decodeTpl($framework_mode_item["titre"]);
                $titre_en = $this->decodeTpl($framework_mode_item["titre_en"]);
                $file_name = $framework_mode;
                $bf_spec = $this->decodeTpl($framework_mode_item["bf_spec"]);
                $bf_code = $this->decodeTpl($framework_mode_item["bf_code"]);
                $id_module = $this->getVal("id_module");

                list($bf, $bf_new) = Bfunction::getOrCreateBF($system_id, $file_name, $id_module, $this_id, $bf_spec, $titre, $titre_en, $titre, $titre_en, $direct_access, $public, $bf_type, $bf_code, 0, 0, $resetUS);
                if (is_object($bf) and ($bf->getId() > 0)) {
                    $bf_row = array("id" => $bf->getId(), "mode" => $framework_mode, "bf" => $bf, "bf_new" => $bf_new, "menu" => $framework_mode_item["menu"][$cat]);
                    $bf_row_empty = false;
                } else {
                    throw new AfwRuntimeException("failed Bfunction::getOrCreateBF($system_id, $file_name, $id_module, $this_id, $bf_spec, $titre, $titre_en, $titre, $titre_en, $direct_access, $public, $bf_type, $bf_code) : " . var_export($bf, true));
                }
            } else {
                throw new AfwRuntimeException("Working on $atable_name using framework config [framework_$framework_id], no category : $cat in mode $framework_mode");
            };
        } else {
            throw new AfwRuntimeException("Working on $atable_name using framework config [framework_$framework_id], no mode $framework_mode");
        }

        if (($bf_row_empty) and (!$no_screen[$cat])) {
            throw new AfwRuntimeException("atable_id = $this, no screen created for mode $framework_mode, cat=$cat framework_id=$framework_id, system=$system_id : " . var_export($bf_row, true));
        }
        return $bf_row;
    }

    public function createFrameWorkScreens($framework_id = 0, $resetAll = true, $resetUS = true)
    {
        global $lang, $_sql_analysis_seuil_calls;
        if (!$framework_id) $framework_id = AfwSession::config("framework_id", 1);
        // for heavy processes allow bigger seuil
        $_sql_analysis_seuil_calls = 250;

        $file_dir_name = dirname(__FILE__);

        require("$file_dir_name/../../lib/framework_$framework_id" . "_specification.php");
        // include_once("$file_dir_name/../ums/bfunction.php");

        $this_id = $this->getId();
        $cat = $this->tableCategory();
        $system_id = $this->calc("system_id");
        if (!$system_id) throw new AfwRuntimeException("failed $this --> createFrameWorkScreens($framework_id,$resetAll) system is not defined for this table (id=$this_id)");




        $direct_access = "N";
        $public = "N";

        $bf_arr = array();

        $bf_arr_empty = true;

        foreach ($framework_mode_list as $framework_mode => $framework_mode_item) {
            $bf_type_code = $framework_mode_item["bf_type"][$cat];
            if (!$bf_type_code) $bf_type_code = $framework_mode_item["bf_type"]["all"];
            if ($bf_type_code) $bf_type = Bfunction::${"BFUNCTION_TYPE_$bf_type_code"};
            else $bf_type = "";
            if (!$bf_type) {
                throw new AfwRuntimeException("no bf type defined for category : $cat mode $framework_mode");
            }


            if ($framework_mode_item["categories"][$cat]) {
                $titre = $this->decodeTpl($framework_mode_item["titre"]);
                $titre_en = $this->decodeTpl($framework_mode_item["titre_en"]);
                $file_name = $framework_mode;
                $bf_spec = $this->decodeTpl($framework_mode_item["bf_spec"]);
                $bf_code = $this->decodeTpl($framework_mode_item["bf_code"]);
                $id_module = $this->getVal("id_module");

                list($bf, $bf_new) = Bfunction::getOrCreateBF($system_id, $file_name, $id_module, $this_id, $bf_spec, $titre, $titre_en, $titre, $titre_en, $direct_access, $public, $bf_type, $bf_code, 0, 0, $resetUS);
                if (is_object($bf) and ($bf->getId() > 0)) {
                    $bf->generateUserStory($lang, $framework_id);
                    $bf_arr[$bf->getId()] = array("mode" => $framework_mode, "bf" => $bf, "bf_new" => $bf_new, "menu" => $framework_mode_item["menu"][$cat]);
                    if ($bf) $bf_arr_empty = false;
                } else throw new AfwRuntimeException("failed Bfunction::getOrCreateBF($system_id, $file_name, $id_module, $this_id, $bf_spec, $titre, $titre_en, $titre, $titre_en, $direct_access, $public, $bf_type, $bf_code) : " . var_export($bf, true));
            } else $bf_arr[-1]["$framework_mode.$cat"]++;
        }
        if (($bf_arr_empty) and (!$no_screen[$cat])) throw new AfwRuntimeException("atable_id = $this, no frame work screen created, cat=$cat framework_id=$framework_id, system=$system_id : " . var_export($bf_arr, true));
        //else throw new AfwRuntimeException("frame work screens created for cat=$cat framework_id=$framework_id: ".var_export($bf_arr,true));
        return $bf_arr;
    }



    public function copyFieldsToTableAsShortcuts($tab, $shortcut_path, $shortcut_prefix)
    {
        if (!$tab) return;

        $file_dir_name = dirname(__FILE__);
        // // require_once("$file_dir_name/afield.php");
        // require_once("$file_dir_name/scenario_item.php");

        $tab_id = $tab->getId();

        $origFieldList = $this->get("origFieldList");

        foreach ($origFieldList as $origFieldItem) {
            $field_name = $origFieldItem->getVal("field_name");
            $afld = Afield::loadByMainIndex($tab_id, $shortcut_prefix . $field_name, $create_obj_if_not_found = true);

            $except_fields = array();
            $except_fields["atable_id"] = true;
            $except_fields["field_name"] = true;

            $except_if_filled_fields = array();
            //$afld->is_new = true;
            if (!$afld->is_new) {
                $except_if_filled_fields["titre_short"] = true;
                $except_if_filled_fields["titre_short_en"] = true;
                $except_if_filled_fields["titre"] = true;
                $except_if_filled_fields["titre_en"] = true;
            }
            $afld->copyDataFrom($origFieldItem, $except_fields, $except_if_filled_fields);
            $afld->set("reel", "N");
            $afld->set("specification", "SHORTCUT/${shortcut_path}$field_name");

            $origSciItem = $origFieldItem->het("scenario_item_id");
            if ($origSciItem) {
                $sciItem = ScenarioItem::loadByMainIndex($tab_id, $origSciItem->getVal("step_name_ar"), $create_obj_if_not_found = false);
                if ($sciItem) {
                    $afld->set("scenario_item_id", $sciItem->getId());
                }
            }
            $afld->commit();
        }
    }

    public function copyStepsToTable($tab, $fromStep = 1)
    {
        if (!$tab) return array(0, 0, 0, 0);

        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/scenario_item.php");


        $tab_scis = $this->get("scis");
        $tab_id = $tab->getId();

        $scis = $this->get("scis");
        $scis_count = count($scis);

        if ($scis_count > 0) {
            $added_scis = 0;
            $updated_scis = 0;
            $moved_scis = 0;
            $keeped_scis = 0;

            $currStep = $fromStep;
            foreach ($scis as $sci_id => $sci_item) {
                unset($sc);
                $sc = ScenarioItem::loadByMainIndex($tab_id, $sci_item->getVal("step_name_ar"), $create_obj_if_not_found = true);
                $sc->set("step_num", $currStep);
                $sc->set("step_name_en", $sci_item->getVal("step_name_en"));
                $sc->set("help_text", $sci_item->getVal("help_text"));
                //$sc->set("help_text_en",$sci_item->getVal("help_text_en"));
                $sc->commit();
                if ($sc->is_new) $added_scis++;
                else $updated_scis++;

                $currStep++;
            }

            foreach ($tab_scis as $tab_sci_id => $tab_sci_item) {
                if ($tab_sci_item->valstep_num() >= $fromStep) {
                    $tab_sci_item->set("step_num", $tab_sci_item->valstep_num() + $added_scis);
                    $tab_sci_item->commit();
                    $moved_scis++;
                } else  $keeped_scis++;
            }
        }

        return array($added_scis, $updated_scis, $moved_scis, $keeped_scis);
    }


    protected function getPublicMethods()
    {

        $pbms = array();

        $color = "green";
        $title_ar = "تحديث عكسي لخطوات إدخال البيانات";
        $pbms["xc123B"] = array(
            "METHOD" => "createUpdateMySteps",
            "COLOR" => $color,
            "LABEL_AR" => $title_ar,
            "ADMIN-ONLY" => true,
            'MODE' => array("mode_scis" => true),
        );





        $color = "red";
        $title_ar = "إنشاء الحقول المبدئية";
        $pbms["23Byc1"] = array(
            "METHOD" => "createDefaultFields",
            "COLOR" => $color,
            "LABEL_AR" => $title_ar,
            "ADMIN-ONLY" => true,
            'MODE' => array("mode_origFieldList" => true),
        );


        $color = "blue";
        $title_ar = "إنشاء حقول الترجمة للانجليزية";
        $pbms["66Av41"] = array(
            "METHOD" => "createTranslationFieldsToEnglish",
            "COLOR" => $color,
            "LABEL_AR" => $title_ar,
            "ADMIN-ONLY" => true,
            'MODE' => array("mode_origFieldList" => true),
        );

        $color = "green";
        $title_ar = "إعادة ترقيم ترتيب الحقول";
        $pbms["7316Bv"] = array(
            "METHOD" => "reorderFields",
            "COLOR" => $color,
            "LABEL_AR" => $title_ar,
            "ADMIN-ONLY" => true,
            'MODE' => array("mode_origFieldList" => true),
        );



        if ($this->isLookup()) {
            $color = "yellow";
            $title_ar = "استيراد البيانات المرجعية من قاعدة البيانات";
            $pbms["55Ay31"] = array(
                'METHOD' => "getLookupValuesFromDB",
                'COLOR' => $color,
                'LABEL_AR' => $title_ar,
                "ADMIN-ONLY" => true,
                'MODE' => array("mode_lookupValueList" => true),
            );
        }

        if ($this->_isEntity()) {
            $color = "red";
            $title_ar = "تعطيل وظائف المستخدم";
            $pbms["5a1hJ5"] = array("METHOD" => "disableMyAutoGeneratedBFs", "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, 'MODE' => array("mode_bfunctionList" => true),);

            $color = "green";
            $title_ar = "تحديث وظائف المستخدم";
            $pbms["5av231"] = array("METHOD" => "genereUserBFs", "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, 'MODE' => array("mode_bfunctionList" => true),);


            $color = "yellow";
            $title_ar = "تعطيل جميع الوظائف من جميع القوائم";
            $pbms["hhJ5o1"] = array("METHOD" => "disableMyBFsFromMenus", "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, 'MODE' => array("mode_bfunctionList" => true),);

            $color = "yellow";
            $title_ar = "تصفير سياقات الاستعمال";
            $pbms["hav781"] = array("METHOD" => "resetDefaultModes", "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, 'MODE' => array("mode_origFieldList" => true),);
        }

        return $pbms;
    }

    public function resetDefaultModes($lang = "ar", $commit = true)
    {
        $origFieldList = $this->get("origFieldList");
        $nb_upd = 0;
        foreach ($origFieldList as $origFieldItem) {
            $nb_upd += $origFieldItem->resetDefaultModes($commit, $this);
        }

        return array("", "$nb_upd fields updated");
    }



    public function getLookupValuesFromDB($lang = "ar")
    {
        //$lookupValueList = $this->get("lookupValueList");
        //if(count($lookupValueList)==0)
        if (true) {
            $my_atable_name = $this->getVal("atable_name");
            $my_module = $this->myModuleCode();
            $my_class = $this->getTableClass();

            $file_dir_name = dirname(__FILE__);

            // if afw autoloader not loaded load it
            if (!class_exists('AfwAutoLoader')) {
                require_once("$file_dir_name/../../lib/afw/afw_autoloader.php");
            }
            // add the $my_module module
            if ($my_module) AfwAutoLoader::addModule($my_module);

            $obj = new $my_class();

            $obj->select($obj->fld_ACTIVE(), "Y");
            $obj_list = $obj->loadMany();
            $nbAdded = 0;
            $nbUpdated = 0;
            $countObjs = count($obj_list);
            foreach ($obj_list as $obj_item) {
                $lookup_code = $obj_item->getVal("lookup_code");
                if (!$lookup_code) $lookup_code = $obj_item->snv("lookup_code");
                if (!$lookup_code) $lookup_code = get_class($obj_item) . "-" . $obj_item->id;
                if ($lookup_code) {
                    $lkpVal = LookupValue::loadByMainIndex($this->getId(), $lookup_code, true);

                    if ($lkpVal) {
                        if ($lkpVal->is_new)  $nbAdded++;

                        $lkpVal->set("pkey", $obj_item->getId());
                        $lkpVal->set("value", $obj_item->getDisplay("ar"));
                        if ($lkpVal->update()) $nbUpdated++;
                    }
                }
            }

            return array("", "تم استيراد $countObjs سجل تم إضافة  $nbAdded  سجل و تعديل $nbUpdated سجل من الكيان  $my_class : $file_dir_name/../$my_module/$my_atable_name ");
        }
        return array("", "lookupValueList already filled");
    }

    public function attributeIsApplicable($attribute)
    {

        $categ = $this->tableCategory();

        if ($attribute == "lookupValueList") {
            return ($this->isLookup());
        }

        if (($attribute == "data_auser_mfk")) {

            return ($this->_isEntity() and
                $this->isOriginal() and
                ($categ != "lookup") and
                ($categ != "view") and
                ($categ != "vobj"));
        }

        if (($attribute == "indexFieldList")) {
            // die(" attribute = $attribute the categ = $categ");
            return ($this->_isEntity() and
                $this->isOriginal() and
                // ($categ != "lookup") and
                ($categ != "view") and
                ($categ != "vobj"));
        }

        if ($attribute == "origFieldList") {
            return (
                ($this->isOriginal()) and
                ($categ != "vobj")
            );
        }

        if ($attribute == "max_period") {
            return ($this->_isEntity());
        }

        if ($attribute == "exp_period") {
            return ($this->_isEntity());
        }

        if ($attribute == "min_u_records") {
            return ($this->_isEntity());
        }

        if ($attribute == "exp_u_records") {
            return ($this->_isEntity());
        }

        if ($attribute == "scis") {
            return ($this->_isEntity());
        }

        if (($attribute == "tboption_mfk")) {
            return ($this->_isEntity());
        }

        if ($attribute == "jobrole_id") {

            return (($categ == "blookup") or ($categ == "lookup"));
        }

        /*
                    bau-v2

                if($attribute=="jobrole_id")
                {
                    
                    return ($this->_isEntity() and 
                            $this->isOriginal() and 
                            (!$this->dataIsAutoGenerated()) and
                            (!$this->dataIsFullOwnedByMaster()) and
                            ($categ != "view") and 
                            ($categ != "vobj")
                            );  //  and (count($this->get("scis"))==0) : @todo rafik may be we need to add option for this in tboption 
                }
                
                if($attribute=="jobrole_mfk")
                {
                    return ($this->_isEntity() and (!$this->dataIsAutoGenerated()));  //  and (count($this->get("scis"))==0) : @todo rafik may be we need to add option for this in tboption 
                }
                
                */

        /*
                1 : المسؤوليات التي تحتاج صلاحية التعديل
                3 : المسؤوليات التي تحتاج صلاحية المسح
                5 : المسؤوليات التي تحتاج صلاحية التعديل السريع
                */

        if (($attribute == "goalConcernList1") or ($attribute == "goalConcernList3") or ($attribute == "goalConcernList5")) {

            return ($this->_isEntity() and
                $this->isOriginal() and
                (!$this->dataIsAutoGenerated()) and
                (!$this->dataIsFullOwnedByMaster()) and
                ($categ != "view") and
                ($categ != "vobj")
            );  //  and (count($this->get("scis"))==0) : @todo rafik may be we need to add option for this in tboption 
        }

        // المسؤوليات التي تحتاج صلاحية الإستعلام                
        if ($attribute == "goalConcernList2") {
            return (($categ != "detail_owned") and $this->_isEntity() and (!$this->dataIsAutoGenerated()));  //  and (count($this->get("scis"))==0) : @todo rafik may be we need to add option for this in tboption 
        }

        // المسؤوليات التي تحتاج إجراء إحصائيات على هذا الجدول
        if ($attribute == "goalConcernList4") {
            return ($categ == "entity");
        }

        if ($attribute == "concernedGoalList") {

            return ($this->_isEntity() and
                $this->isOriginal() and
                (!$this->dataIsAutoGenerated()) and
                (!$this->dataIsFullOwnedByMaster()) and
                ($categ != "lookup") and
                ($categ != "blookup") and
                ($categ != "view") and
                ($categ != "vobj")
            );  //  and (count($this->get("scis"))==0) : @todo rafik may be we need to add option for this in tboption 
        }


        if ($attribute == "exp_u_records") {
            return true; //($this->_isLookup());
        }

        if ($attribute == "display_field") {
            return ($this->_isLookup() or (!$this->hasNameFields()));
        }

        if ($attribute == "master") {
            return ($this->dataIsFullOwnedByMaster());
        }




        return true;
    }


    public function dataIsAutoGenerated()
    {
        return $this->findInMfk("tboption_mfk", self::$TBOPTION_DATA_IS_AUTO_GENERATED, $mfk_empty_so_found = false);
    }




    public function dataIsFullOwnedByMaster()
    {
        return $this->findInMfk("tboption_mfk", self::$TBOPTION_FULL_DETAIL, $mfk_empty_so_found = false);
    }


    protected function getSpecificDataErrors($lang = "ar", $show_val = true, $step = "all", $erroned_attribute = null, $stop_on_first_error = false, $start_step = null, $end_step = null)
    {
        /*
              global $boucle_getSpecificDataErrors, $boucle_getSpecificDataErrors_arr;
                
                if(!$boucle_getSpecificDataErrors)
                {
                   $boucle_getSpecificDataErrors = 0;
                   $boucle_getSpecificDataErrors_arr = array();
                }
                
                $this_getId = $this->getId();
                $this_table = "Atable";                
                $boucle_getSpecificDataErrors_arr[$boucle_getSpecificDataErrors] = "getId from object [$this_table,$this_getId]";
                $boucle_getSpecificDataErrors++;
                
                if($boucle_getSpecificDataErrors > 500)
                {
                      throw new AfwRuntimeException("heavy page halted after $boucle_getSpecificDataErrors enter to getSpecificDataErrors method in one request, ".var_export($boucle_getSpecificDataErrors_arr,true));
                }*/

        $sp_errors = array();

        if ($this->stepContainAttribute($step, "id_sub_module")) {
            if ($this->getVal("id_sub_module") == $this->getVal("id_module")) $sp_errors["id_sub_module"] = "Module and Sub-module should be different in new version of hazm framework";
        }
        $system = $this->het("system_id");
        $application = $this->het("id_module");
        if ($this->stepContainAttribute($step, "system_id")) {
            if (!$system) $sp_errors["system_id"] = "System not defined !!";
        }
        if ($this->stepContainAttribute($step, "id_module")) {
            if (!$application) $sp_errors["id_module"] = "Application not defined !!";
            if ($application) {
                if ($system) {
                    if ($application->getVal("id_system") != $system->getId()) $sp_errors["id_module"] = "Application should belong to system $system";
                }
            }
        }



        if ($this->stepContainAttribute($step, "id_sub_module") and $this->getVal("id_sub_module")) {
            $sub_module = $this->het("id_sub_module");
            if (!$sub_module) $sp_errors["id_sub_module"] = "Sub-module is mandatory";
            else {
                if ($system) {
                    if ($sub_module->getVal("id_system") != $system->getId()) $sp_errors["id_sub_module"] = "Sub-module should be from system $system";
                }

                if ($application) {
                    $parentAppl = $sub_module->getParentApplication();
                    if ((!$parentAppl) or ($parentAppl->getId() != $application->getId())) $sp_errors["id_sub_module"] = "Sub-module should be from application $application";
                }
            }
        }

        $categ = $this->tableCategory();

        /*
              bau-v2
              if($this->stepContainAttribute($step, "jobrole_id"))
              {
                      if($this->attributeIsApplicable("jobrole_id"))
                      {
                          if(!$this->getVal("jobrole_id")) $sp_errors["jobrole_id"] = "Edit job role is mandatory for this category of tables : $categ";
                      }
              }
              */

        if ($this->stepContainAttribute($step, "indexFieldList")) {
            if ($this->attributeIsApplicable("indexFieldList")) {
                list($index_af_name_arr, $index_af_obj_list) = $this->getMainIndexFieldList();
                if (!$this->hasOption(self::$TBOPTION_NEVER_GENERATED)) {
                    $indexCount = count($index_af_name_arr);
                    if (!$indexCount) $sp_errors["indexFieldList"] = "for this category of table : $categ, index fields are mandatory to define or option 'never generated' should be checked";
                }

                $all_index_fields_in_step1 = true;
                foreach ($index_af_obj_list as $afObj) {
                    $sciObj = $afObj->het("scenario_item_id");
                    $field_name = $afObj->getVal("field_name");
                    if (!$sciObj) {
                        $all_index_fields_in_step1 = false;
                        break;
                    }
                    if ($sciObj and ($sciObj->getVal("step_num") != 1)) {
                        $all_index_fields_in_step1 = false;
                        break;
                    }
                }

                if (!$all_index_fields_in_step1) {
                    $sp_errors["indexFieldList"] = "all unique index fields should be in step 1, $field_name is not";
                }
            }
        }


        if ($this->stepContainAttribute($step, "scis") and $this->attributeIsApplicable("scis")) {
            $scis = $this->get("scis");
            $scis_count = count($scis);

            $need_tabs = $this->hasOption(self::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS);
            $afCount = $this->getAFieldCount(true);

            if (($afCount > 17) or (($afCount > 10) and (!$this->hasOption(self::$TBOPTION_OPEN_ROLES_ON_FULL_SCREEN)))) {
                $need_tabs = true;
                if (!$scis_count) $sp_errors["scis"] = "For this category of tables : $categ, when field count exceed 10 we need to broke screen into tabs or define only one screen option";
            }

            $max_count = 17;
            if ($afCount > $max_count) {
                $need_tabs = true;
                $scis = $this->get("scis");
                $scis_count = count($scis);
                if (!$scis_count) $sp_errors["scis"] = "For this category of tables : $categ, when field count exceed $max_count we need to broke screen into tabs";
            }

            if (($scis_count) and ($need_tabs)) {
                $afNonAssignedToStepCount = $this->getAFieldNonAssignedToStepCount();
                if ($afNonAssignedToStepCount > 0) $sp_errors["scis"] = "Still $afNonAssignedToStepCount fields non assigned to their step";
            }
        }



        return $sp_errors;
    }

    public function isEnumOrLookup()
    {
        $categ = $this->tableCategory();
        return (($categ == "enum") or ($categ == "lookup"));
    }

    public function getRAMObjectData()
    {
        $category_id = 7;

        $file_dir_name = dirname(__FILE__);
        // require_once("$file_dir_name/../bau/r_a_m_object_type.php");
        $lookup_code = $this->tableCategory();
        $typeObj = RAMObjectType::loadByMainIndex($lookup_code);
        $type_id = $typeObj->getId();

        $code = $this->getVal("atable_name");
        if (!$code) throw new AfwRuntimeException("this table is without table name");
        $name_ar = $this->getVal("titre_short");
        $name_en = $this->getVal("titre_short_en");
        $specification = $this->getVal("titre");

        $childs = array();

        $childs[12] =  $this->get("concernedGoalList");
        $childs[6]  =  $this->get("bfunctionList");
        $childs[10] =  $this->get("afieldGroupList");
        $childs[8]  =  $this->get("origFieldList");


        return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
    }


    public function fld_CREATION_USER_ID()
    {
        return "id_aut";
    }

    public function fld_CREATION_DATE()
    {
        return "date_aut";
    }

    public function fld_UPDATE_USER_ID()
    {
        return "id_mod";
    }

    public function fld_UPDATE_DATE()
    {
        return "date_mod";
    }

    public function fld_VALIDATION_USER_ID()
    {
        return "id_valid";
    }

    public function fld_VALIDATION_DATE()
    {
        return "date_valid";
    }

    public function fld_VERSION()
    {
        return "version";
    }

    public function fld_ACTIVE()
    {
        return  "avail";
    }

    public function isTechField($attribute)
    {
        return (($attribute == "id_aut") or ($attribute == "date_aut") or ($attribute == "id_mod") or ($attribute == "date_mod") or ($attribute == "id_valid") or ($attribute == "date_valid") or ($attribute == "version"));
    }

    public function getGoalConcernList($oper_id)
    {
        return $this->get("goalConcernList$oper_id");
    }


    public function getFieldGroupInfos($fgroup)
    {
        if ($fgroup == "scis") return array("name" => $fgroup, "css" => "pct_100");
        return $this->getFieldGroupDefaultInfos($fgroup);
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    /*
        public function getImportantFields($nbColsMax)
        {
               $file_dir_name = dirname(__FILE__); 
               // require_once("$file_dir_name/afield.php");
               
               if($this->isEmpty()) return false;
               
               $af = new Afield();
               
               $af->select("atable_id", $this->getId());
               $af->select("avail", 'Y');
               $af->select("reel", 'Y');
               $afList = $af->loadMany($limit = "", $order_by="aprio_id desc, mandatory desc, field_order asc");
               
               $listFields = array();
               $otherFields = array();
               foreach($afList as $afObj)
               {
                   $afTypeObj = $afObj->het("afield_type_id");
                   if($afTypeObj) $afwType = $afTypeObj->getAfwType();
                   else $afwType = "???";
                   if(count($listFields)<$nbColsMax)
                   {
                        $listFields[] = array('name' => $afObj->getVal("field_name"), type=>$afwType, 'title' => $afObj->getVal("titre_short_en"));
                   }
                   else
                   {
                        $otherFields[] = array('name' => $afObj->getVal("field_name"), type=>$afwType, 'title' => $afObj->getVal("titre_short_en"));
                   }
                   
                   
               }
             
             
             return array($listFields, $otherFields);
        }            
        */

    public function shouldBeCalculatedField($attribute)
    {
        if ($attribute == "id_domain") return true;
        return false;
    }

    public function myShortNameToAttributeName($attribute)
    {
        if ($attribute == "sys") return "system_id";
        if ($attribute == "domain") return "id_domain";
        if ($attribute == "module") return "id_module";
        if ($attribute == "original") return "real_table";
        if ($attribute == "name") return "atable_name";
        if ($attribute == "lookup") return "is_lookup";
        if ($attribute == "entity") return "is_entity";
        if ($attribute == "enum") return "is_enum";
        if ($attribute == "detail") return "is_detail";
        if ($attribute == "pluraltitle") return "titre_short";
        if ($attribute == "pluraltitleshort") return "titre_short_s";
        if ($attribute == "singletitle") return "titre_u";
        if ($attribute == "singletitleshort") return "titre_u_s";
        if ($attribute == "description") return "titre";
        if ($attribute == "submodule") return "id_sub_module";
        if ($attribute == "icon") return "vh";
        if ($attribute == "pluraltitle_en") return "titre_short_en";
        if ($attribute == "singletitle_en") return "titre_u_en";
        if ($attribute == "description_en") return "titre_en";
        if ($attribute == "original_fields") return "origFieldList";
        if ($attribute == "audit_fields") return "auditFieldList";
        if ($attribute == "index_fields") return "indexFieldList";
        if ($attribute == "name_fields") return "nameFieldList";
        if ($attribute == "virtual_fields") return "virtFieldList";
        if ($attribute == "additional_fields") return "addiFieldList";
        if ($attribute == "emjob") return "jobrole_id";
        if ($attribute == "maxper") return "max_period";
        if ($attribute == "expper") return "exp_period";
        if ($attribute == "minrows") return "min_u_records";
        if ($attribute == "exprows") return "exp_u_records";
        return $attribute;
    }

    
    public static function addByCodes($object_code_arr, $object_name_en, $object_name_ar, $object_title_en, $object_title_ar, $update_if_exists=false)
    {
        if (count($object_code_arr) != 2) throw new AfwRuntimeException("Atable::addByCodes : 2 params are needed module and table, given : " . var_export($object_code_arr, true));        
        $table_name = $object_code_arr[0];
        $module_code = $object_code_arr[1];
        if (!$module_code or !$table_name) throw new AfwRuntimeException("Atable::addByCodes : module and table are needed, given : module=$module_code and table=$table_name");
        if (!$object_name_en or !$object_name_ar or !$object_title_en or !$object_title_ar) throw new AfwRuntimeException("Atable::addByCodes : names and titles are required");
        $objModule = Module::loadByMainIndex($module_code);
        if (!$objModule or (!$objModule->id)) throw new AfwRuntimeException("addByCodes : module $module_code not found");

        $objModule_id = $objModule->id;
        $objTable = Atable::loadByMainIndex($objModule_id, $table_name, true);
        if(!$objTable) $message = "Strange Error happened because Atable::loadByMainIndex($objModule_id, $table_name) failed !!";
        else
        {
            if((!$objTable->is_new) and (!$update_if_exists))
            {
                throw new AfwRuntimeException("This table already exists");
            }
            $objTable->set("titre_short_en", $object_name_en);
            $objTable->set("titre_short", $object_name_ar);
            if($object_title_en) $objTable->set("titre_u_en", $object_title_en);
            if($object_title_ar) $objTable->set("titre_u", $object_title_ar);
            $objTable->commit();

            $message = "successfully done";
        }
        

        return [$objTable, $message];
    }

    /**
     * function reverseByCodes do a reverse engineering on this table
     * 
     */

    public static function reverseByCodes($object_code_arr, $doReverse=true)
    {
        if (count($object_code_arr) != 2) throw new AfwRuntimeException("reverseByCodes : 2 params are needed module and table, given : " . var_export($object_code_arr, true));
        $table_name = $object_code_arr[0];
        $module_code = $object_code_arr[1];
        if (!$module_code or !$table_name) throw new AfwRuntimeException("reverseByCodes : module and table are needed, given : module=$module_code and table=$table_name");
        $objModule = Module::loadByMainIndex($module_code);
        if (!$objModule or (!$objModule->id)) throw new AfwRuntimeException("reverseByCodes : module $module_code not found");
        $objModule_id = $objModule->id;
        $message = "";

        if($doReverse)
        {
            $message .= self::reverseTable($module_code, $table_name);            
        }
        $objTable = Atable::loadByMainIndex($objModule_id, $table_name);
        if(!$objTable) $message.= " Strange Error happened because Atable::loadByMainIndex($objModule_id, $table_name) returned empty, may be table need reverse engineering !!";
        else $message .= " Table $table_name loaded successfully";

        return [$objTable, $message];
    }


    public static function repareByCodes($object_code_arr, $restriction)
    {
        list($objTable, $message) = self::reverseByCodes($object_code_arr, ($restriction=="reverse"));
        if($objTable) 
        {
            $cnt = $objTable->repareMe('en');
            $message .= "\n and $cnt attributes have been repared";
        }

        return [$objTable  , $message];
    }

    public static function reverseTable($module_code, $table_name)
    {
        $tableClass = AfwStringHelper::tableToClass($table_name);
        AfwAutoLoader::addModule($module_code);
        /**
         * @var AFWObject $objToPag 
         */
        $objToPag = new $tableClass();

        list($fld_i, $fld_u, $mdl_new, $tbl_new, $mdl, $tbl) = $objToPag->pagMe($sh = 3, $update_if_exists = true);
        $return = "$fld_i fields inserted, $fld_u fields updated";
        if($mdl_new) $return .= ", new module created : ";
        else $return .= ", module used : ";
        if($mdl) $return .= $mdl->getDisplay("en")."/id=".$mdl->id;
        
        if($tbl_new) $return .= ", new table created : ".$tbl->getDisplay("en");

        return $return;
        
    }

    public function reverseMe($module_code = "")
    {
        if (!$module_code) {
            $objModule = $this->het("id_module");
            if (!$objModule) return ["no valid module", ""];
            $module_code = $objModule->getVal("module_code");
        }
        $table_name = $this->getVal("atable_name");

        $message = self::reverseTable($module_code, $table_name);

        return ["", $message];
    }

    public function getTableRightsMatrice($objectRole, $framework, $subModId = 0)
    {
        global $file_dir_name;

        $this_id = $objectRole->getId();
        $matriceArr = array();
        $moduleObj = $objectRole->hetModule();
        if ($moduleObj) {
            $moduleId = $moduleObj->getId();
            $moduleCode = $moduleObj->getVal("module_code");

            $at = new Atable();
            $at->select("id_module", $moduleId);
            if ($subModId) $at->select("id_sub_module", $subModId);
            $at->select("avail", 'Y');
            $atableList = $at->loadMany($limit = "", $order_by = "id_sub_module asc, titre_short asc");

            foreach ($atableList as $atableId => $atableObj) {
                $matriceArr[$atableId]["obj"] = $atableObj;

                $tbl_name = $atableObj->getVal("atable_name");
                $cat = $atableObj->tableCategory();
                $bf_arr = $atableObj->createFrameWorkScreens($framework, false);

                foreach ($bf_arr as $bf_id => $bf_data) {
                    if ($bf_id > 0) {
                        $bf = $bf_data["bf"];
                        $bf_new = $bf_data["bf_new"];
                        $menu = $bf_data["menu"];
                        $framework_mode = $bf_data["mode"];
                        if ($menu) $arole_id = -1;
                        else $arole_id = $objectRole->getId();
                        if (!$bf) {
                            throw new AfwRuntimeException("role:$this_id, module:$moduleCode($moduleId), table($tbl_name/id=$atableId/cat=$cat) : createFrameWorkScreens has created null BF for framework mode : $framework_mode");
                        }
                        $matriceArr[$atableId][$framework_mode] = array("bf" => $bf, "arole_id" => $arole_id, "menu" => $menu);
                    }
                }
            }
        } else $matriceArr["error"] = "module not defined for role : $objectRole";

        return  $matriceArr;
    }


    public function saveTableRightsMatrice($objectRole, $framework, $data_posted, $subModId)
    {
        global $file_dir_name;

        $framework = AfwSession::config("framework_id", 1);
        include("$file_dir_name/../lib/framework_${framework}_specification.php");
        $removed_count = 0;
        $added_count = 0;
        $menu_removed_count = 0;
        $menu_added_count = 0;

        $moduleObj = $objectRole->hetModule();
        if ($moduleObj) {
            $moduleId = $moduleObj->getId();
            $moduleCode = $moduleObj->getVal("module_code");

            $at = new Atable();
            $at->select("id_module", $moduleId);
            $at->select("id_sub_module", $subModId);
            $at->select("avail", 'Y');
            $atableList = $at->loadMany($limit = "", $order_by = "id_sub_module asc, titre_short asc");

            foreach ($atableList as $atableId => $atableObj) {
                $cat = $atableObj->tableCategory();

                foreach ($framework_mode_list as $framework_mode => $framework_mode_item) {
                    $checkbox_name = "chk_" . $framework_mode . "_" . $atableId;
                    $bf_id_input_name = "bf_id_" . $framework_mode . "_" . $atableId;

                    $bf_old_checked = $data_posted["old_" . $checkbox_name];
                    $bf_checked = $data_posted[$checkbox_name];
                    $bf_id = $data_posted[$bf_id_input_name];

                    //if($checkbox_name == "chk_qsearch_25") die("old:$bf_old_checked != new:$bf_checked");

                    if (($bf_old_checked != $bf_checked) and ($bf_id > 0)) {
                        if ($bf_checked) {
                            $menu_added = $objectRole->addBF($bf_id);
                            $added_count++;
                            if ($menu_added) $menu_added_count++;
                        } else {
                            $menu_removed = $objectRole->removeBF($bf_id);
                            $removed_count++;
                            if ($menu_removed) $menu_removed_count++;
                        }
                    }
                }
            }
        } else throw new AfwRuntimeException("module not defined for role : $objectRole");

        return array($added_count, $removed_count, $menu_added_count, $menu_removed_count);
    }


    public function genereTranslation($lang)
    {
        $tabDesc = $this->getAllFieldList();
        $tabScis = $this->getScis();
        $tabName = $this->getVal("atable_name");
        // $tbl_list_txt .= $tabName . ", ";

        
        $langUC = AfwStringHelper::firstCharUpper($lang);
        $fileName = "trad_".$lang."_" . strtolower($tabName) . ".php";
        $className = AfwStringHelper::tableToClass($tabName);
        $classNameLower = strtolower($className);

        $trad_arr = array();

        if ($lang == "ar") {
            $trad_arr["$classNameLower.single"] = $this->getVal("titre_u");
            $trad_arr["$classNameLower.new"] = "جديد(ة)";
            $trad_arr[$tabName] = $this->valTitre_short();
        } else {
            $trad_arr["$classNameLower.single"] = $this->getVal("titre_u_en");
            $trad_arr["$classNameLower.new"] = "new";
            $trad_arr[$tabName] = $this->valTitre_short_en();
        }


        unset($tempTdesc);
        $tempTdesc = array();

        foreach ($trad_arr as $nom_col => $try_trad) {
            if ($try_trad) {
                $RDesc = "\t\t\$trad[\"$tabName\"][\"$nom_col\"] = \"$try_trad\";";
                array_push($tempTdesc, $RDesc);
            }
        }


        foreach ($tabDesc as $nom_col => $rowDesc) {
            if (!$this->isTechField($nom_col)) 
            {
                $help_trad = "";
                $try_trad = "";
                if ($this->getId()) 
                {
                    $afld = new Afield();
                    $afld->select("atable_id", $this->getId());
                    $afld->select("field_name", $nom_col);
                    if ($afld->load()) {
                        $try_trad = $afld->getShortDisplay($lang);
                        if ($lang == "ar") $help_text_field = "help_text";
                        else $help_text_field = "help_text_en";
                        $help_trad = $afld->getVal($help_text_field);

                        if ($lang == "ar") $unit_field = "unit";
                        else $unit_field = "unit_en";

                        $unit_trad = $afld->getVal($unit_field);

                        if ((!$try_trad) and ($lang == "en")) {
                            $afld->set("titre_short_en", "--");
                            $afld->update();
                        }
                    } 
                    else $try_trad = "table $tabName need to be reverse engineeredm because can't find column [$nom_col]";
                }

                if ((!$try_trad) || ($try_trad == $nom_col)) {
                    $try_trad = AfwLanguageHelper::tarjem($nom_col, $lang, null, $tabName);
                }

                if ((!$try_trad) || ($try_trad == $nom_col)) {
                    if ($trad_arr[$nom_col]) {
                        $try_trad = $trad_arr[$nom_col];
                    } else $try_trad = "";
                }


                if ($try_trad) {
                    $RDesc = "\t\t\$trad[\"$tabName\"][\"$nom_col\"] = \"$try_trad\";";
                    array_push($tempTdesc, $RDesc);
                }

                if ($help_trad) {
                    $RDesc = "\t\t\$trad[\"$tabName\"][\"${nom_col}_help\"] = \"$help_trad\";";
                    array_push($tempTdesc, $RDesc);
                }

                if ($unit_trad) {
                    $RDesc = "\t\t\$trad[\"$tabName\"][\"${nom_col}_unit\"] = \"$unit_trad\";";
                    array_push($tempTdesc, $RDesc);
                }
            }
        }

        array_push($tempTdesc, "        // steps");

        foreach ($tabScis as $tabSci_id => $tabSci_item) {
            $step_num = $tabSci_item->getVal("step_num");
            $step_name = $tabSci_item->getVal("step_name_$lang");

            $RDesc = "\t\t\$trad[\"$tabName\"][\"step$step_num\"] = \"$step_name\";";
            array_push($tempTdesc, $RDesc);
        }

        $TDesc = implode("\n", $tempTdesc);
        $php_code = 
        
"<?php

class ".$className.$langUC."Translator{
    public static function initData()
    {
        \$trad = [];

$TDesc
        return \$trad;
    }

    public static function getInstance()
	{
		return new $className();
	}
}";
        

        return $php_code;        
    }
}
