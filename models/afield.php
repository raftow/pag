<?php
// 12/7/21
// ALTER TABLE `afield` CHANGE `titre_short` `titre_short` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
// ALTER TABLE `afield` CHANGE `titre_short_en` `titre_short_en` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 
// alter table afield add parent_module_id int(11) not null default 0 after atable_id;
// alter table afield add system_id int(11) not null default 0 after atable_id;
// update afield set parent_module_id = (select max(id_module) from atable tb where tb.id = atable_id);
// update afield set system_id = (select max(id_system) from ".$server_db_prefix."ums.module md where md.id = parent_module_id);
// 13-Nov-2022 :
// alter table afield add key afield_atable_id(atable_id);
// alter table afield add key afield_field_name(field_name);


global $enum_tables, $lookup_tables, $count_here;






class Afield extends AFWObject
{

        public function __construct()
        {
                parent::__construct("afield", "id", "pag");
                PagAfieldAfwStructure::initInstance($this);
        }

        

        // MANYTOONE - حقل يفلتر به-ManyToOne  
        public static $ENTITY_RELATION_TYPE_MANYTOONE = 2;

        // ONETOMANY - أنا تفاصيل لها-OneToMany  
        public static $ENTITY_RELATION_TYPE_ONETOMANY = 1;

        // ONETOONEBIDIRECTIONAL - جزء مني ولا يعمل إلا بي-OneToOneBidirectional  
        public static $ENTITY_RELATION_TYPE_ONETOONEBIDIRECTIONAL = 4;

        // ONETOONEUNIDIRECTIONAL - جزء مني ويعمل مستقلا-OneToOneUnidirectional  
        public static $ENTITY_RELATION_TYPE_ONETOONEUNIDIRECTIONAL = 5;

        // UNKN - غير معروفة-unkn  
        public static $ENTITY_RELATION_TYPE_UNKN = 3;


        public static $enum_tables;

        public static $lookup_tables;

        public static $DATABASE                = "";
        public static $MODULE                    = "pag";
        public static $TABLE                        = "";
        public static $DB_STRUCTURE = null;




        public static function loadById($id)
        {
                $obj = new Afield();
                $obj->select_visibilite_horizontale();
                if ($obj->load($id)) {
                        return $obj;
                } else return null;
        }

        public static function loadByMainIndex($atable_id, $field_name, $create_obj_if_not_found = false, $activate_obj_if_disabled = false)
        {
                $obj = new Afield();
                if (!$atable_id) throw new AfwRuntimeException("loadByMainIndex : atable_id is mandatory field");
                if (!$field_name) throw new AfwRuntimeException("loadByMainIndex : field_name is mandatory field");


                $obj->select("atable_id", $atable_id);
                $obj->select("field_name", $field_name);

                if ($obj->load()) {
                        if ($activate_obj_if_disabled) $obj->activate();
                        return $obj;
                } elseif ($create_obj_if_not_found) {
                        $obj->set("atable_id", $atable_id);
                        $obj->set("field_name", $field_name);

                        $obj->insert();
                        $obj->is_new = true;
                        return $obj;
                } else return null;
        }

        public static function loadByCodes($object_code_arr, $create_if_not_exists_with_name = "", $lang = "ar", $rename_if_exists = false)
        {
                if (count($object_code_arr) != 3) throw new AfwRuntimeException("Afield::loadByCodes : 3 params needed (module_code, table_name, field_name) : object_code_arr=" . var_export($object_code_arr, true));

                $file_dir_name = dirname(__FILE__);


                $module_code = $object_code_arr[0];
                $table_name = $object_code_arr[1];
                $field_name = $object_code_arr[2];

                $objModule = Module::loadByMainIndex($module_code);
                if ((!$objModule) or $objModule->isEmpty()) throw new AfwRuntimeException("Afield::loadByCodes : can't find module by module_code = $module_code");

                $objTable = Atable::loadByMainIndex($objModule->getId(), $table_name);
                if ((!$objTable) or $objTable->isEmpty()) throw new AfwRuntimeException("Afield::loadByCodes : can't find table by table_name = $table_name in module $module_code");


                $obj = self::loadByMainIndex($objTable->getId(), $field_name, $create_if_not_exists_with_name);
                if (($obj->is_new) or $rename_if_exists) {
                        if ($lang == "ar") $obj->set("titre_short", $create_if_not_exists_with_name);
                        if ($lang == "en") $obj->set("titre_short_en", $create_if_not_exists_with_name);
                        $obj->commit();
                }

                return $obj;
        }


        public function dynamicHelpCondition($attribute)
        {
                if ($attribute == "titre_short") return ($this->getVal("titre_short") != $this->getVal("titre"));

                return true;
        }

        public function select_visibilite_horizontale($dropdown = false)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");
                $objme = AfwSession::getUserConnected();
                $me = ($objme) ? $objme->id : 0;
                $this->select_visibilite_horizontale_default();
                if (!$objme->isSuperAdmin()) {
                        $this->where("(${server_db_prefix}pag.fnGetModuleId(id) in (select mu.id_module from ${server_db_prefix}ums.module_auser mu where mu.id_auser = '$me' and mu.avail='Y'))");
                }
        }


        public function hasOption($option)
        {
                return $this->findInMfk("foption_mfk", $option, false);
        }

        public function enumFieldAnswerTableIsPhpFunction()
        {
                // rafik 29/11/2024 : I don't understand the code below and for me it is obsolete 
                // any enum or menum Answer Table Is always Php Function and doesn't need answer table    
                // return $this->hasOption(114);

                return true;
        }

        public function needAnswerTable()
        {
                if (in_array($this->getVal("afield_type_id"), array(
                        AfwUmsPagHelper::$afield_type_menum,
                        AfwUmsPagHelper::$afield_type_enum
                ))) {
                        return (!$this->enumFieldAnswerTableIsPhpFunction());
                }


                return (in_array($this->getVal("afield_type_id"), array(
                        AfwUmsPagHelper::$afield_type_items,
                        AfwUmsPagHelper::$afield_type_mlst,
                        AfwUmsPagHelper::$afield_type_list
                )));
        }

        public function myAnswerTableName()
        {
                if ($this->needAnswerTable()) {
                        $anstab = $this->get("answer_table_id");
                        return $anstab->valAtable_name();
                } else {
                        return "";
                }
        }



        public function attributeIsApplicable($attribute)
        {
                $my_tab = $this->het("atable_id");

                if ($attribute == "answer_table_id") {
                        return $this->needAnswerTable();
                }

                if ($attribute == "answer_module_id") {
                        return $this->needAnswerTable();
                }

                if ($attribute == "field_where") {
                        return $this->needAnswerTable();
                }




                if ($attribute == "entity_relation_type_id") {
                        return (($this->getVal("afield_type_id") == 5) and ($this->may("reel")));
                }

                if ($attribute == "afield_category_id") {
                        return (!$this->may("reel"));
                }

                if (($attribute == "sql") or ($attribute == "sql_gen")
                        or ($attribute == "mode_qsearch")
                        or ($attribute == "mandatory")
                        or ($attribute == "distinct_for_list")
                ) {
                        return ($this->may("reel"));
                }



                if ($attribute == "foption_mfk") {
                        return true;
                }

                if ($attribute == "entity_relation_type_id_help") {
                        return ($this->getVal("afield_type_id") == 5);
                }

                if ($attribute == "utf8") {
                        return (in_array($this->getVal("afield_type_id"), array(10, 11)));
                }

                if (($attribute == "field_size") or ($attribute == "field_width")) {
                        return ($this->may("reel") and in_array($this->getVal("afield_type_id"), array(10, 11)));
                }

                if ($attribute == "field_min_size") {
                        return ($this->may("reel") and $this->may("mandatory") and in_array($this->getVal("afield_type_id"), array(10, 11)));
                }

                if ($attribute == "char_group_men") {
                        return ($this->may("reel") and in_array($this->getVal("afield_type_id"), array(10, 11)));
                }

                if ($attribute == "scenario_item_id") {
                        if ($my_tab) {
                                $roles_on_screen_tabs = $my_tab::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS;
                                if ($my_tab->hasOption($roles_on_screen_tabs)) {
                                        //if($my_tab->getVal("atable_name")=="travel_template_bus") die("my_tab->hasOption($roles_on_screen_tabs) = true");
                                        return true;
                                }
                                /*
                           $scis = $my_tab->get("scis");
                           $scis_count = count($scis);
                           if($scis_count>0)
                           {
                               //if($my_tab->getVal("atable_name")=="travel_template_bus") die("scis = ".var_export($scis,true));
                               return true;
                           }*/ else return false;

                                /* old code before changes 004
                           if($my_tab->hasOption($my_tab::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS)) return true;
                           $scis = $my_tab->get("scis");
                           $scis_count = count($scis);
                           if($scis_count>0)  return true;*/
                        }
                }



                return true;
        }



        public function getNextAdditionalFieldNum()
        {

                $this->select("atable_id", $this->getVal("atable_id"));
                $this->select("reel", 'Y');
                $this->select("additional", 'Y');
                $this->select("afield_type_id", $this->getVal("afield_type_id"));
                return $this->func("IF(ISNULL(max(field_num)), -1, max(field_num))+1", "", true, false);
        }

        public function getNextFieldOrder()
        {

                $this->select("atable_id", $this->getVal("atable_id"));
                $this->select("reel", 'Y');
                $this->select("avail", 'Y');
                return $this->func("IF(ISNULL(max(field_order)), 0, max(field_order))+10");
        }


        public function isFK()
        {
                return ($this->getVal("afield_type_id") == 5);
        }

        public function isMFK()
        {
                return ($this->getVal("afield_type_id") == 6);
        }

        public function getTypeInput()
        {
                switch ($this->getVal("afield_type_id")) {
                                // 5	اختيار من قائمة	list
                                // 6	اختيار متعدد من قائمة	mlst
                                // 8	نعم/لا	yn
                        case 5:
                        case 6:
                        case 8:
                                return "select";

                                // 1	قيمة عددية متوسطة	nmbr
                                // 2	تاريخ	date
                                // 3	مبلغ من المال	amnt
                                // 4	وقت	time
                                // 7	نسبة مائوية	pctg        
                                // 9	تاريخ ميلادي	gdat
                                // 10	نص قصير	text
                                // 11	نص طويل
                                // 13	قيمة عددية صغيرة
                                // 14	قيمة عددية كبيرة

                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 7:
                        case 9:
                        case 10:
                        case 11:
                        case 13:
                        case 14:
                                return "text";

                                // 12	إختيار من قائمة قصيرة
                                // 15	إختيار متعدد من قائمة قصيرة	menum
                        default:
                                return "???";
                }
        }

        private static function getFieldNameWork($field_name)
        {
                for ($i = 1; $i <= 20; $i++) {
                        $field_name = str_replace('[' . $i . ']', '', $field_name);
                }

                return $field_name;
        }

        private static function getFieldNameReel($field_name)
        {
                $field_name = str_replace('[', '', $field_name);
                $field_name = str_replace(']', '', $field_name);

                return $field_name;
        }

        public function repareMe($lang = "ar")
        {
                $this->repareMeBeforeUpdate();
                $ret = $this->isChanged();
                $this->commit();
                // if ($this->getVal("field_name")  == "page_id") die($this->getVal("field_name") . " changed : $ret");
                return $ret;
        }


        protected function repareMeBeforeUpdate()
        {
                // to be overridden if needed
                global $me, $mode_pag_me;

                $server_db_prefix = AfwSession::config('db_prefix', "default_db_");

                // @rafik 13/11/2022 : important optimisation for pagme process no need to repare
                if ($mode_pag_me) return true;
                /*
                if($this->getVal("system_id")==1)
                {
                    if(!$this->getVal("id"))
                    {
                        $this->where("id < 100000");
                        $new_id = $this->func("max(id)+1");
                        if($new_id<100000) $this->set("id",$new_id);
                    }
                
                }*/

                // if ($this->getVal("field_name")  == "page_id") die("repare titre_en=".$this->getVal("titre_en")." titre=".$this->getVal("titre"));

                if(trim($this->getVal("titre")) == trim($this->getVal("titre_en")))
                {
                        if(!AfwStringHelper::is_arabic($this->getVal("titre"))) $this->set("titre", "");
                        else $this->set("titre_en", "");                        
                }

                if($this->getVal("titre_short") == $this->getVal("titre_short_en"))
                {
                        if(!AfwStringHelper::is_arabic($this->getVal("titre_short"))) $this->set("titre_short", "");
                        else $this->set("titre_short_en", "");
                }

                if (trim($this->getVal("titre")) == "--") {
                        $this->set("titre", "");
                        $this->set("titre_short", "");
                        $this->set("titre_en", "");
                        $this->set("titre_short_en", "");
                }

                if (trim($this->getVal("titre_short")) == "--") {
                        $this->set("titre_short", "");
                        $this->set("titre", "");
                        $this->set("titre_en", "");
                        $this->set("titre_short_en", "");
                }

                if (!$this->getVal("titre")) {
                        $this->set("titre", $this->getVal("titre_short"));
                }

                if (!$this->getVal("titre_short")) {
                        $this->set("titre_short", $this->getVal("titre"));
                }

                if ($this->getVal("titre_short_en") == "--") $this->set("titre_short_en", "");
                if ($this->getVal("titre_en") == "--") $this->set("titre_en", "");

                if (!$this->getVal("titre_en")) {
                        $this->set("titre_en", $this->getVal("titre_short_en"));
                }

                if (!$this->getVal("titre_short_en")) {
                        $this->set("titre_short_en", $this->getVal("titre_en"));
                }

                $field_name = $this->getVal("field_name");

                $field_name_orig = $field_name;
                $field_name = self::getFieldNameWork($field_name_orig);
                $field_name_reel = self::getFieldNameReel($field_name_orig);

                //if($field_name_orig != $field_name) die("field_name_orig=$field_name_orig field_name=$field_name field_name_reel=$field_name_reel");

                if ((!$this->getVal("titre_short_en")) and ($field_name)) {
                        $field_titre = AfwStringHelper::toEnglishText($field_name);
                        $this->set("titre_short_en", $field_titre);
                        $this->set("titre_en", $field_titre);
                }


                $my_tab_id = $this->getVal("atable_id");

                if ((!$field_name) or (!$my_tab_id)) {
                        $error_0 = "field name [here:$field_name] and table id [here:$my_tab_id] of any field is mandatories informations";
                        $this->my_update_error_code = "field_name_atable_id_are_mandatory";
                        $this->my_update_error_msg = $error_0;

                        throw new AfwRuntimeException($error_0);
                        return false;
                }

                $my_tab = $this->get("atable_id");
                $my_tab_name = $my_tab->getVal("atable_name");
                $my_tab_tu = $my_tab->getVal("titre_u");
                $my_tab_tu_en = $my_tab->getVal("titre_u_en");
                $my_module = $my_tab->getVal("id_module");

                $my_system_id = $my_tab->getVal("system_id");

                if (!$this->getVal("system_id")) {
                        $this->set("system_id", $my_system_id);
                }

                if (!$this->getVal("parent_module_id")) {
                        $this->set("parent_module_id", $my_module);
                }

                if (!$this->getVal("additional")) {
                        if ($my_tab->isOriginal())
                                $this->set("additional", "N");
                        else
                                $this->set("additional", "Y");
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_en") or AfwStringHelper::stringEndsWith($field_name, "_ar")) {
                        if (!$this->getVal("afield_type_id"))
                        {
                                if(
                                        AfwStringHelper::stringStartsWith($field_name, "desc_") or
                                        AfwStringHelper::stringStartsWith($field_name, "description_") or
                                        AfwStringHelper::stringStartsWith($field_name, "body_") or
                                        AfwStringHelper::stringStartsWith($field_name, "html_") or
                                        AfwStringHelper::stringStartsWith($field_name, "summary_")
                                  )
                                {
                                        $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_mtxt);
                                }  
                                else
                                {
                                        $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_text);
                                }
                                
                        } 
                        if ($this->may("mandatory", true)) $this->set("mandatory", "Y");
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_mfk")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_mlst);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_fl")) {
                        if ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_UNKN) $this->set("entity_relation_type_id", 0);
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_list);
                        if (!$this->getVal("entity_relation_type_id")) {
                                $this->set("entity_relation_type_id", self::$ENTITY_RELATION_TYPE_MANYTOONE);
                        }
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_id")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_list);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_pk") or AfwStringHelper::stringEndsWith($field_name, "_ms"))   // ms as will be master of this record (the record will be its detail) (so one to many)
                {
                        if ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_UNKN) $this->set("entity_relation_type_id", 0);
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_list);
                        if (!$this->getVal("entity_relation_type_id")) $this->set("entity_relation_type_id", self::$ENTITY_RELATION_TYPE_ONETOMANY);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_ou")) {
                        if ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_UNKN) $this->set("entity_relation_type_id", 0);
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_list);
                        if (!$this->getVal("entity_relation_type_id")) $this->set("entity_relation_type_id", self::$ENTITY_RELATION_TYPE_ONETOONEUNIDIRECTIONAL);
                }


                if (AfwStringHelper::stringEndsWith($field_name, "_ob")) {
                        if ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_UNKN) $this->set("entity_relation_type_id", 0);
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_list);
                        if (!$this->getVal("entity_relation_type_id")) $this->set("entity_relation_type_id", self::$ENTITY_RELATION_TYPE_ONETOONEBIDIRECTIONAL);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_enm") or AfwStringHelper::stringEndsWith($field_name, "_enum")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_enum);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_men") or AfwStringHelper::stringEndsWith($field_name, "_menum")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_menum);
                }
                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mlst) or
                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_menum)
                ) {
                        $this->set("mode_name", "N");
                }

                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list) and
                        (
                                ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_ONETOMANY) or
                                ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_ONETOONEUNIDIRECTIONAL) or
                                ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_ONETOONEBIDIRECTIONAL)
                        )
                ) {
                        if ($this->may("mandatory", true)) $this->set("mandatory", "Y");
                        if ($this->may("mode_search", true)) $this->set("mode_search", "Y");
                        if ($this->may("mode_qsearch", true)) $this->set("mode_qsearch", "Y");
                        if ($this->may("mode_retrieve", false)) $this->set("mode_retrieve", "N");
                        if ($my_tab->hasOption($my_tab::$TBOPTION_DATA_IS_AUTO_GENERATED)) $this->set("readonly", "Y");


                        // فيه نظر
                        //if($this->may("mode_name",true)) $this->set("mode_name","Y");
                }


                
                //if ($this->getVal("field_name")  == "page_id") die($this->getVal("field_name") . " step 2 : afield_type_id=" . $this->getVal("afield_type_id"));

                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list) or
                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mlst) or
                        (
                                (!$this->enumFieldAnswerTableIsPhpFunction())
                                and
                                (
                                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_enum) or
                                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_menum)
                                )
                        )
                ) {
                        if (!$this->getVal("answer_table_id")) {

                                $exp_name = explode("_", $field_name);
                                unset($exp_name[count($exp_name) - 1]);
                                $atb = strtolower(implode("_", $exp_name));
                                // require_once("atable.php");
                                $anstab = new Atable();
                                $anstab->select("id_module", $my_module);
                                $anstab->select("atable_name", $atb);
                                //die("finding ans tab with name $atb in module $my_module");
                                if ($anstab->load()) {
                                        // die(var_export($anstab,true));
                                        $this->set("answer_table_id", $anstab->getId());
                                } else {
                                        unset($anstab);
                                }

                                if (!$anstab) {
                                        // die("anstab not found");
                                        $anstab = new Atable();
                                        $anstab->where("id_module in (select id from " . $server_db_prefix . "ums.module where id_module_type=5 and id_module_parent=1)");   // chercher dans pag
                                        $anstab->select("atable_name", $atb);
                                        if ($anstab->load()) {
                                                $this->set("answer_table_id", $anstab->getId());
                                        } else {
                                                unset($anstab);
                                        }
                                }

                                if (!$anstab) {
                                        // die("anstab not found");
                                        /*
                                      if($mySemplObj and $objme) 
                                      {
                                                $id_sh_org = $mySemplObj->getVal("id_sh_org");
                                                $id_sh_div = $mySemplObj->getVal("id_sh_div");
                                      }*/
                                        unset($anstab);
                                        $anstab = new Atable();
                                        // chercher dans mes modules dont je suis auteur ou qui me sont visibles
                                        $anstab->where("(id_aut = $me)"); // $id_sh_dep,   
                                        $anstab->select("atable_name", $atb);
                                        if ($anstab->load()) {
                                                // throw new AfwRuntimeException("")
                                                $this->set("answer_table_id", $anstab->getId());
                                        } else {
                                                unset($anstab);
                                        }
                                }
                        } else {
                                $anstab_id = $this->getVal("answer_table_id");
                                $anstab = $this->het("answer_table_id");
                                
                                if (!$anstab) throw new AfwRuntimeException("for field $field_name_orig this answer_table_id $anstab_id doesnt exist anymore ");
                        }

                        if ((!$this->getVal("entity_relation_type_id")) and ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list))  $this->set("entity_relation_type_id", 3);


                        if (AfwStringHelper::stringEndsWith($field_name, "_enm") or 
                            AfwStringHelper::stringEndsWith($field_name, "_enum") or 
                            AfwStringHelper::stringEndsWith($field_name, "_men") or 
                            AfwStringHelper::stringEndsWith($field_name, "_menum")) {
                                if ($this->enumFieldAnswerTableIsPhpFunction()) {
                                        $this->set("specification", 'FUNCTION');
                                } else {
                                        $this->set("specification", 'LOOKUP_TABLE');
                                }
                        }

                        //die(var_export($this,true));

                }


                if ($anstab and (!$this->getVal("answer_module_id"))) {
                        $this->set("answer_module_id", $anstab->getVal("id_module"));
                }



                if (($field_name == $my_tab_name . "_code") or
                        ($field_name == "code")
                ) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "رمز " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", $my_tab_tu_en . " code");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size")) $this->set("field_size", 16);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 3);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,3,9,');
                }

                if ($field_name== "lookup_code") {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "الرمز");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "Lookup code");
                        if ($this->may("mandatory", true)) $this->set("mandatory", "Y");
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_code")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "رمز .......");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "........ code");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size")) $this->set("field_size", 16);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 3);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,3,9,');
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_website")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "موقع .......");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "........ web site");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        $this->set("field_size", 255);
                        $this->set("field_min_size", 16);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,6,4,3,7,9,');
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_webpage")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "صفحة .......");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "........ web page");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        $this->set("field_size", 255);
                        $this->set("field_min_size", 16);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,6,4,3,7,9,');
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_link")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "رابط .......");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "........ web link");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        $this->set("field_size", 255);
                        $this->set("field_min_size", 16);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,6,4,3,7,9,');
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_location") or AfwStringHelper::stringEndsWith($field_name, "_gmap")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "رابط الموقع على الخرائط");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "google map location link");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        $this->set("field_size", 255);
                        $this->set("field_min_size", 16);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,6,4,3,7,9,');
                }


                if (($field_name == "${my_tab_name}_spec") or
                        ($field_name == "${my_tab_name}_specification") or
                        ($field_name == "specification") or
                        ($field_name == "spec")
                ) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "مواصفات " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", $my_tab_tu_en . " specification");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 11);
                        if (!$this->getVal("field_size")) $this->set("field_size", 255);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 30);
                }

                if (($field_name == "${my_tab_name}_name") or
                        ($field_name == "${my_tab_name}_name_ar") or
                        ($field_name == "titre_short") or
                        ($field_name == "titre") or
                        ($field_name == "title")
                ) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "مسمى " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "Arabic " . $my_tab_tu_en . " name");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size")) $this->set("field_size", 48);

                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 5);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',2,7,');
                }



                if (($field_name == "${my_tab_name}_name_en") or
                        ($field_name == "titre_short_en") or
                        ($field_name == "titre_en") or
                        ($field_name == "title_en")
                ) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "مسمى " . AfwStringHelper::arabicTaarif($my_tab_tu) . " بالانجليزي");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", $my_tab_tu_en . " name");
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size")) $this->set("field_size", 48);

                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 5);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,7,');
                }

                if (($field_name == "comment") or AfwStringHelper::stringEndsWith($field_name, "_comment")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "ملاحظات");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "Arabic comments");
                        $this->set("field_size", 255);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 10);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',11,');
                }

                if (($field_name == "comment_en") or AfwStringHelper::stringEndsWith($field_name, "_comment_en")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "ملاحظات بالانجليزي");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "comments");
                        $this->set("field_size", 255);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 10);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',11,');
                }


                if (($field_name == "comments") or AfwStringHelper::stringEndsWith($field_name, "_comments")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 11);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "ملاحظات");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "Arabic comments");
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',11,');
                }

                if (($field_name == "comments_en") or AfwStringHelper::stringEndsWith($field_name, "_comments_en")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 11);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "ملاحظات بالانجليزي");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "comments");
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',11,');
                }

                if ((AfwStringHelper::stringEndsWith($field_name, "_name") or (AfwStringHelper::stringEndsWith($field_name, "_name_en") or (AfwStringHelper::stringEndsWith($field_name, "_name_fr"))))) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size")) $this->set("field_size", 48);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 5);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,7,');
                }

                if ((AfwStringHelper::stringEndsWith($field_name, "_mobile") or (AfwStringHelper::stringEndsWith($field_name, "_phone") or (AfwStringHelper::stringEndsWith($field_name, "_telephone"))))) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size"))     $this->set("field_size", 20);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 5);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',5,4,3,7,');
                }


                if (
                        AfwStringHelper::stringEndsWith($field_name, "_title") or
                        AfwStringHelper::stringEndsWith($field_name, "_title_ar") or
                        AfwStringHelper::stringEndsWith($field_name, "_title_en") or
                        AfwStringHelper::stringEndsWith($field_name, "_title_fr")
                ) {
                        if (AfwStringHelper::stringEndsWith($field_name, "_title") or AfwStringHelper::stringEndsWith($field_name, "_title_ar")) {
                                if (!$this->getVal("titre_short")) $this->set("titre_short", "عنوان " . AfwStringHelper::arabicTaarif($my_tab_tu));
                                if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "Arabic " . $my_tab_tu_en . " title");
                        } elseif (AfwStringHelper::stringEndsWith($field_name, "_title_fr")) {
                                if (!$this->getVal("titre_short")) $this->set("titre_short", "عنوان " . AfwStringHelper::arabicTaarif($my_tab_tu) . " بالفرنسي");
                                if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "titre du " . $my_tab_tu_en);
                        } else {
                                if (!$this->getVal("titre_short")) $this->set("titre_short", "عنوان " . AfwStringHelper::arabicTaarif($my_tab_tu) . " بالانجليزي");
                                if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "titre du " . $my_tab_tu_en);
                        }
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 10);
                        if (!$this->getVal("field_size")) $this->set("field_size", 64);
                        if (!$this->getVal("field_min_size")) $this->set("field_min_size", 5);
                        if (!$this->getVal("char_group_men")) $this->set("char_group_men", ',1,7,');
                }

                if ((AfwStringHelper::stringEndsWith($field_name, "_desc")) or
                        (AfwStringHelper::stringEndsWith($field_name, "_desc_ar")) or
                        (AfwStringHelper::stringEndsWith($field_name, "_desc_en")) or
                        (AfwStringHelper::stringEndsWith($field_name, "_desc_fr"))
                ) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 11);
                }

                if (($field_name == "${my_tab_name}_desc") or
                        ($field_name == "${my_tab_name}_desc_ar") or
                        ($field_name == "description") or
                        ($field_name == "description_ar")
                ) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "وصف " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", "Arabic " . $my_tab_tu_en . " description");
                }

                if (($field_name == "${my_tab_name}_desc_en") or
                        ($field_name == "description_en")
                ) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "وصف " . AfwStringHelper::arabicTaarif($my_tab_tu) . " بالانجليزي");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short_en", $my_tab_tu_en . " description");
                }

                if (($field_name == "${my_tab_name}_date") or ($field_name == "${my_tab_name}_hdate")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "تاريخ " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("field_size")) $this->set("field_size", 10);
                }

                if ($field_name == "${my_tab_name}_time") {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "وقت " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("field_size")) $this->set("field_size", 8);
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 4);
                }

                if ($field_name == "${my_tab_name}_amount") {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "مبلغ " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("field_size")) $this->set("field_size", 10);
                }



                if (AfwStringHelper::stringEndsWith($field_name, "_hdate")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_date);                        
                }



                if (AfwStringHelper::stringEndsWith($field_name, "_date")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_date);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_gdat") or 
                    AfwStringHelper::stringEndsWith($field_name, "_gdate")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", AfwUmsPagHelper::$afield_type_Gdat);
                }


                if(($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_date) or
                   ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_Gdat))
                {
                        if (!$this->sureIs("mandatory")) $this->set("mandatory", "N");

                        if (!$this->getVal("titre_short") and (AfwStringHelper::stringEndsWith($field_name, "_start_hdate"))) $this->set("titre_short", "تاريخ بداية xxxxxx بالهجري");
                        if (!$this->getVal("titre_short") and (AfwStringHelper::stringEndsWith($field_name, "_end_hdate"))) $this->set("titre_short", "تاريخ نهاية xxxxxx بالهجري");
                        if (!$this->getVal("titre_short") and (AfwStringHelper::stringEndsWith($field_name, "_start_date"))) $this->set("titre_short", "تاريخ بداية xxxxxx بالهجري");
                        if (!$this->getVal("titre_short") and (AfwStringHelper::stringEndsWith($field_name, "_end_date"))) $this->set("titre_short", "تاريخ نهاية xxxxxx بالهجري");
                        if (!$this->getVal("titre_short") and (AfwStringHelper::stringEndsWith($field_name, "_start_gdat"))) $this->set("titre_short", "تاريخ بداية xxxxxx بالميلادي");
                        if (!$this->getVal("titre_short") and (AfwStringHelper::stringEndsWith($field_name, "_end_gdat"))) $this->set("titre_short", "تاريخ نهاية xxxxxx بالميلادي");
                        
                        if (!$this->getVal("field_size")) $this->set("field_size", 10);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_amount")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 3);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "مبلغ ");
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_time")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 4);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "وقت ");
                        if (!$this->getVal("field_size")) $this->set("field_size", 8);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "_num")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 13);
                }

                if (AfwStringHelper::stringEndsWith($field_name, "is_")) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 8);
                }

                if ((AfwStringHelper::stringEndsWith($this->getVal("titre_short"), "?"))
                        or (AfwStringHelper::stringEndsWith($this->getVal("titre_short"), "؟"))
                ) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 8);
                }


                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_date) or
                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_Gdat)
                ) {
                        if (!$this->getVal("field_size")) $this->set("field_size", 10);
                        if (!$this->may("mode_name", false)) $this->set("mode_name", "N");
                }

                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mtxt)) {
                        $this->set("mode_name", "N");
                }


                if (($field_name == "${my_tab_name}_date") or ($field_name == "${my_tab_name}_hdate")) {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "تاريخ " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short", $my_tab_tu_en . " date");
                }

                if ($field_name == "${my_tab_name}_amount") {
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "مبلغ " . AfwStringHelper::arabicTaarif($my_tab_tu));
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short", $my_tab_tu_en . " amount");
                }



                if (!$this->getVal("scenario_item_id")) {
                        $pf = $this->getPreviousAfield();
                        $nf = $this->getNextAfield();

                        $si_pf = 0;
                        $si_nf = 0;

                        if ($pf) $si_pf = $pf->getVal("scenario_item_id");
                        if ($nf) $si_nf = $nf->getVal("scenario_item_id");

                        if ($si_nf and ($si_nf == $si_pf)) {
                                $this->set("scenario_item_id", $si_nf);
                        }
                }

                if ($anstab) {
                        $titre = trim($this->getVal("titre"));
                        $titre_en = trim($this->getVal("titre_en"));
                        //if ($this->getVal("field_name")  == "page_id") die("will repare 1 titre_en=$titre_en titre=$titre");
                        if ((!$titre) or (!$titre_en) or ($titre==$titre_en)) {
                                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list)) {
                                        $titre_propose = $anstab->getVal("titre_u");
                                        $titre_propose_en = $anstab->getVal("titre_u_en");
                                        // if ($this->getVal("field_name")  == "page_id") die("will repare 2 titre_en=$titre_en titre=$titre titre_propose_en=$titre_propose_en titre_propose=$titre_propose anstab=".$anstab);
                                        if ($titre_propose) $titre_propose = AfwStringHelper::arabicTaarif($titre_propose);
                                        $this->set("titre", $titre_propose);
                                        $this->set("titre_en", $titre_propose_en);
                                        //die("titre_propose = $titre_propose, this = ".var_export($this,true));  
                                } elseif (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mlst)) {
                                    $titre_propose = $anstab->getVal("titre");
                                    $titre_propose_en = $anstab->getVal("titre_en");
                                    $this->set("titre", $titre_propose);
                                    $this->set("titre_en", $titre_propose_en);
                                    //die("titre_propose = $titre_propose, this = ".var_export($this,true));  
                                } else {
                                        $this->set("titre", $anstab->getVal("titre_short"));
                                        $this->set("titre_en", $anstab->getVal("titre_short_en"));
                                }
                        }

                        if (!trim($this->getVal("titre_short"))) {
                                $this->set("titre_short", $this->getVal("titre"));
                        }

                        if (!trim($this->getVal("titre_short_en"))) {
                                $this->set("titre_short_en", $this->getVal("titre_en"));
                        }
                }



                if (($field_name) and
                        (!trim($this->getVal("titre"))) and
                        (!trim($this->getVal("titre_short")))
                ) {
                        $my_id = $this->getId();
                        $afield_similar = self::get_similar_field($field_name, $my_id);

                        //die("this = ".var_export($this,true) . "<br>\n<br>\n<br>\n-------------------------------------<br>\n<br>\n<br>\n<br>\n afield_similar = " . var_export($afield_similar,true));
                        if ($afield_similar) 
                        {
                                if (!trim($this->getVal("afield_type_id"))) $this->set("afield_type_id", $afield_similar->getVal("afield_type_id"));
                                if (!trim($this->getVal("field_size"))) $this->set("field_size", $afield_similar->getVal("field_size"));
                                if(!$this->getVal("answer_table_id") or !$afield_similar->getVal("answer_module_id"))
                                {
                                        $this->set("answer_module_id", $afield_similar->getVal("answer_module_id"));
                                        $this->set("answer_table_id", $afield_similar->getVal("answer_table_id"));
                                }

                                $this->set("titre", $afield_similar->getVal("titre"));
                                $this->set("titre_en", $afield_similar->getVal("titre_en"));
                                $this->set("titre_short", $afield_similar->getVal("titre_short"));
                                $this->set("titre_short_en", $afield_similar->getVal("titre_short_en"));
                                $this->set("utf8", $afield_similar->getVal("utf8"));
                                $this->set("field_where", $afield_similar->getVal("field_where"));
                                $this->set("field_format", $afield_similar->getVal("field_format"));
                                $this->set("specification", $afield_similar->getVal("specification"));
                                $this->set("reel", $afield_similar->getVal("reel"));
                                $this->set("default_value", $afield_similar->getVal("default_value"));

                                $this->set("default_value_utf8", $afield_similar->getVal("default_value_utf8"));
                                $this->set("unit", $afield_similar->getVal("unit"));
                                $this->set("unit_en", $afield_similar->getVal("unit_en"));
                                $this->set("title_after", $afield_similar->getVal("title_after"));
                                $this->set("title_after_en", $afield_similar->getVal("title_after_en"));
                                $this->set("help_text", $afield_similar->getVal("help_text"));
                                $this->set("help_text_en", $afield_similar->getVal("help_text_en"));
                                $this->set("question_text", $afield_similar->getVal("question_text"));
                                $this->set("question_text_en", $afield_similar->getVal("question_text_en"));
                                $this->set("readonly", $afield_similar->getVal("readonly"));
                                $this->set("mode_search", $afield_similar->getVal("mode_search"));
                                $this->set("mode_qsearch", $afield_similar->getVal("mode_qsearch"));
                                $this->set("mode_retrieve", $afield_similar->getVal("mode_retrieve"));
                                $this->set("mode_edit", $afield_similar->getVal("mode_edit"));
                                $this->set("mode_qedit", $afield_similar->getVal("mode_qedit"));
                                $this->set("mode_show", $afield_similar->getVal("mode_show"));


                                $this->set("mode_audit", $afield_similar->getVal("mode_audit"));
                                $this->set("mode_edit_admin", $afield_similar->getVal("mode_edit_admin"));
                                $this->set("mode_qedit_admin", $afield_similar->getVal("mode_qedit_admin"));
                                $this->set("mode_name", $afield_similar->getVal("mode_name"));

                                $this->set("foption_mfk", $afield_similar->getVal("foption_mfk"));
                                
                                

                                
                        } else {
                                // $this->set("titre","-------");
                                // $this->set("titre_short","$field_name not found");


                        }
                }

                if ((AfwStringHelper::stringEndsWith($field_name, "_nb") or (AfwStringHelper::stringEndsWith($field_name, "_number")))) {
                        if (!$this->getVal("afield_type_id")) $this->set("afield_type_id", 1);
                        if (!$this->getVal("titre_short")) $this->set("titre_short", "عدد ");
                        if (!$this->getVal("titre_short_en")) $this->set("titre_short", "number ");
                }


                




                if (AfwStringHelper::stringEndsWith($field_name, "_date")) {
                        if (!$this->getVal("titre_short")) {
                                $this->set("titre_short", "تاريخ -------");
                        }

                        if (!$this->getVal("titre_short_en")) {
                                $this->set("titre_short_en", "---- date");
                        }
                }


                if ($this->getVal("field_num") == "") {

                        $this->set("field_num", $this->getNextAdditionalFieldNum());
                }

                if ($this->getVal("field_order") == "") {

                        $this->set("field_order", $this->getNextFieldOrder());
                }

                if (!$this->getVal("field_size")) $this->set("field_size", 32);

                if ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_items) {
                        if (!$this->may("mode_retrieve", false)) $this->set("mode_retrieve", "N");
                        if (!$this->may("mode_name", false)) $this->set("mode_name", "N");
                        if ($this->may("readonly", true)) $this->set("readonly", "Y");
                        if ($this->may("mandatory", true)) $this->set("mandatory", "Y");
                }


                if ($this->may("reel")) {
                        //if(!$this->may("readonly",false)) $this->set("readonly","N");
                } else {
                        if ($this->may("readonly", true)) $this->set("readonly", "Y");
                        if (!$this->getVal("afield_category_id")) {
                                require_once("afield_category.php");

                                $spec = $this->getVal("specification");
                                $spec_arr = explode("/", $spec);
                                if ($spec_arr[0]) {
                                        $afcObj = AfieldCategory::loadByMainIndex($spec_arr[0], false);
                                        if ($afcObj) $this->set("afield_category_id", $afcObj->getId());
                                }
                        }
                }
                if (!$this->getVal("field_width")) $this->set("field_width", $this->getVal("field_size"));

                $this->set("field_name", $field_name_reel);

                if($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_yn)
                {
                        if ($this->may("mandatory", true)) $this->set("mandatory", "Y");
                }

                
                

                return true;
        }

        public function resetDefaultModes($commit = false, $my_tab = null)
        {
                if (!$my_tab) $my_tab = $this->get("atable_id");
                $nb_mod_name = $my_tab->getNbFieldsInMode("mode_name");
                //$nb_mod_show = $my_tab->getNbFieldsInMode("mode_show");
                //$nb_mod_edit = $my_tab->getNbFieldsInMode("mode_edit");
                $nb_mod_qedit = $my_tab->getNbFieldsInMode("mode_qedit");
                $nb_mod_search = $my_tab->getNbFieldsInMode("mode_search");
                $nb_mod_qsearch = $my_tab->getNbFieldsInMode("mode_qsearch");
                $nb_mod_retrieve = $my_tab->getNbFieldsInMode("mode_retrieve");

                $cur_name = $this->getVal("mode_name");
                if ((!$cur_name) or ($cur_name == "W")) {
                        if ($nb_mod_name == 0) {
                                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text) and ($this->getVal("field_size") <= 128)) {
                                        $this->set("mode_name", "Y");
                                }
                        } else {
                                $this->set("mode_name", "N");
                        }
                }

                $cur_search = $this->getVal("search");
                if (($nb_mod_search < 5) or (!$cur_search) or ($cur_search == "W")) {
                        if (($this->getVal("afield_type_id") != AfwUmsPagHelper::$afield_type_list) or ($this->getVal("entity_relation_type_id") != self::$ENTITY_RELATION_TYPE_ONETOMANY)) {
                                $this->set("search", "Y");
                                $this->set("show", "Y");
                        }
                }

                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mtxt) or
                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text)
                ) {
                        $this->set("qsearch", "Y");
                }


                $cur_qsearch = $this->getVal("qsearch");
                if (($nb_mod_qsearch < 5) or (!$cur_qsearch) or ($cur_qsearch == "W")) {
                        if (
                                $this->_isSearch() and
                                (
                                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text) or
                                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mtxt) or
                                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_enum) or
                                        (
                                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list) and
                                                ($this->getVal("entity_relation_type_id") == self::$ENTITY_RELATION_TYPE_MANYTOONE) and
                                                ($this->isSmallLookup())
                                        )
                                )
                        ) {
                                $this->set("qsearch", "Y");
                                $this->set("show", "Y");
                        } else {
                                $this->set("qsearch", "N");
                        }
                } else {
                        $this->set("qsearch", "N");
                }

                $cur_retrieve = $this->getVal("retrieve");
                if (($nb_mod_retrieve < 5) or (!$cur_retrieve) or ($cur_retrieve == "W")) {
                        if (
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_enum) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_date) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_Gdat) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_nmbr) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_int) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_yn) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list) or
                                (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text) and ($this->getVal("field_size") <= 64))
                        ) {
                                $this->set("retrieve", "Y");
                                $this->set("show", "Y");
                        } else {
                                $this->set("retrieve", "N");
                        }
                } else {
                        $this->set("retrieve", "N");
                }



                $cur_qedit = $this->getVal("qedit");
                if (($nb_mod_qedit < 5) or (!$cur_qedit) or ($cur_qedit == "W")) {
                        if (
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_enum) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_date) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_Gdat) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_nmbr) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_int) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_yn) or
                                ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_list) or
                                (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text) and ($this->getVal("field_size") <= 64))
                        ) {
                                $this->set("qedit", "Y");
                                $this->set("edit", "Y");
                        }
                }

                if (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mtxt) or
                        (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text) and ($this->getVal("field_size") > 196))
                ) {
                        $this->set("retrieve", "N");
                        $this->set("qedit", "N");
                        $this->set("show", "Y");
                }

                if ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_items) {
                        $this->set("retrieve", "N");
                        $this->set("qedit", "N");
                        $this->set("show", "Y");
                        $this->set("readonly", "Y");
                        $this->set("edit", "N");
                        if ($this->may("mandatory", true)) $this->set("mandatory", "Y");
                }


                if ($commit) return $this->commit();
                else return 0;
        }

        public function afterInsert($id, $fields_updated)
        {
                $this->resetDefaultModes($commit = true);
        }



        public function beforeMaj($id, $fields_updated)
        {
                return $this->repareMeBeforeUpdate();
        }
        /*
        public function isText() {
             return $this->getFtype()->isText();   
        } */


        public static function get_similar_field($field_name, $my_id = 0)
        {
                $file_dir_name = dirname(__FILE__);
                require_once("$file_dir_name/afield.php");

                $af = new Afield();

                $af->select("field_name", $field_name);
                $af->where("titre_short != '' and titre_short is not null and id != '$my_id'");
                $af_list = $af->loadMany($limit = "1", $order_by = "date_aut desc");

                if (count($af_list) > 0) {
                        return current($af_list);
                } else return null;
        }

        public static function afield_field_to_prop()
        {
                $field_to_prop_arr = array();

                $field_to_prop_arr["afield_type_id"] = "TYPE";
                $field_to_prop_arr["utf8"] = "UTF8";
                $field_to_prop_arr["unit"] = "UNIT";
                $field_to_prop_arr["title_after"] = "TITLE_AFTER";

                $field_to_prop_arr["field_format"] = "FORMAT";
                $field_to_prop_arr["char_group_men"] = "CHAR_TEMPLATE";
                $field_to_prop_arr["field_min_size"] = "MIN-SIZE";
                $field_to_prop_arr["field_width"] = "SIZE";
                $field_to_prop_arr["field_size"] = "MAXLENGTH";
                $field_to_prop_arr["field_min_size"] = "MIN-SIZE";
                $field_to_prop_arr["mode_qedit"] = "QEDIT";
                $field_to_prop_arr["mode_edit"] = "EDIT";
                $field_to_prop_arr["mode_retrieve"] = "RETRIEVE";
                $field_to_prop_arr["mode_show"] = "SHOW";
                $field_to_prop_arr["mode_qsearch"] = "QSEARCH";
                $field_to_prop_arr["mode_search"] = "SEARCH";
                $field_to_prop_arr["mandatory"] = "MANDATORY";
                $field_to_prop_arr["readonly"] = "READONLY";
                $field_to_prop_arr["shortname"] = "SHORTNAME";
                $field_to_prop_arr["mode_display"] = "DISPLAY";  // virtual but exists property (ie=mode_show for the moment)
                $field_to_prop_arr["afield_category_id"] = "CATEGORY";
                $field_to_prop_arr["field_where"] = "WHERE";

                $field_to_prop_arr["scenario_item_id"] = "STEP";
                $field_to_prop_arr["afield_group_id"] = "FGROUP";
                $field_to_prop_arr["answer_table_id"] = "ANSWER";
                $field_to_prop_arr["answer_module_id"] = "ANSMODULE";


                $prop_to_field_arr = array();
                foreach ($field_to_prop_arr as $fld => $prop) {
                        $prop_to_field_arr[$prop] = $fld;
                }



                return array($field_to_prop_arr, $prop_to_field_arr);
        }


        public static function props_to_foptions($thisObject, $atableObject, $afieldObject, $create_foption_if_not_exists = false)
        {
                global $foptionArr;
                $file_dir_name = dirname(__FILE__);
                require_once("$file_dir_name/foption.php");
                require_once("$file_dir_name/foption_case.php");
                require_once("$file_dir_name/afield_option_value.php");

                $attribute = $afieldObject->getVal("field_name");
                $af_type_id = $afieldObject->getVal("afield_type_id");
                $af_catg_id = $afieldObject->getVal("afield_category_id");
                $strcut = AfwStructureHelper::getStructureOf($thisObject, $attribute);


                list($field_to_prop_arr, $prop_to_field_arr) = self::afield_field_to_prop();

                foreach ($strcut as $prop => $prop_value) {
                        if ($prop and (!$prop_to_field_arr[$prop])) {
                                $foptionObj = $foptionArr[$prop];
                                if (!$foptionObj) $foptionObj = Foption::loadByMainIndex($prop, $create_foption_if_not_exists);
                                if ($foptionObj) {
                                        $foptionArr[$prop] = $foptionObj;
                                        $foptionObj->set("foption_type", 1);

                                        $data_type_id = $foptionObj->getVal("data_type_id");
                                        if (!$data_type_id) {
                                                if (is_bool($prop_value)) {
                                                        $data_type_id = AfwUmsPagHelper::$afield_type_yn;
                                                }
                                                if (is_numeric($prop_value)) $data_type_id = AfwUmsPagHelper::$afield_type_nmbr;
                                                if (is_float($prop_value)) $data_type_id = AfwUmsPagHelper::$afield_type_float;
                                                if (!$data_type_id) $data_type_id = AfwUmsPagHelper::$afield_type_text;
                                                $foptionObj->set("data_type_id", $data_type_id);
                                        }

                                        if ($data_type_id == AfwUmsPagHelper::$afield_type_yn) {
                                                if ($prop_value) $prop_value = "true";
                                                else $prop_value = "false";
                                        }

                                        if ($af_type_id) $foptionObj->addRemoveInMfk("afield_type_mfk", array($af_type_id), array());
                                        if ($af_catg_id) $foptionObj->addRemoveInMfk("afield_category_mfk", array($af_catg_id), array());

                                        $foptionObj->commit();



                                        if ($prop_value or ($data_type_id == AfwUmsPagHelper::$afield_type_yn)) {
                                                if (is_string($prop_value)) //($data_type_id==AfwUmsPagHelper::$afield_type_list)
                                                {
                                                        $foc = FoptionCase::loadByMainIndex($foptionObj->getId(), $prop_value, $create_obj_if_not_found = true);
                                                        if ($foc) {
                                                                if ($af_type_id) $foc->addRemoveInMfk("afield_type_mfk", array($af_type_id), array());
                                                                if ($af_catg_id) $foc->addRemoveInMfk("afield_category_mfk", array($af_catg_id), array());

                                                                $foc->commit();
                                                        }

                                                        if (strlen($prop_value) <= 24) {
                                                                $fopval = AfieldOptionValue::loadByMainIndex($afieldObject->getId(), $foptionObj->getId(), $create_obj_if_not_found = true);
                                                                $fopval->set("option_value", $prop_value);
                                                                $fopval->commit();
                                                        }
                                                }
                                        }
                                }
                        }
                }
        }

        // row below is structure of attribute and more ...  (atable, obj)
        public static function to_afield_att($id_main_sh, $row)
        {

                $file_dir_name = dirname(__FILE__);
                $myTable = $row["atable"];
                $myObj = $row["obj"];
                $afield_att = array();
                //$afield_att["mode_name"] = "N";
                $afield_att["mandatory"] = "N";
                $afield_att["mode_search"] = ($row["SEARCH"]) ? "Y" : "N";
                $afield_att["mode_show"] = ($row["SHOW"]) ? "Y" : "N";
                $afield_att["mode_retrieve"] = ($row["RETRIEVE"]) ? "Y" : "N";
                $afield_att["mode_edit"] = ($row["EDIT"]) ? "Y" : "N";
                $afield_att["mode_qedit"] = ($row["QEDIT"]) ? "Y" : "N";
                $afield_att["field_size"] = ($row["MAXLENGTH"] > 0) ? $row["MAXLENGTH"] : 0;
                if (!is_numeric($row["SIZE"])) $afield_att["field_width"] = 9999;
                else $afield_att["field_width"] = ($row["SIZE"] > 0) ? $row["SIZE"] : 0;

                $afield_att["field_min_size"] = ($row["MIN-SIZE"]) ? $row["MIN-SIZE"] : 0;

                if ($row["RELATION"] == "ManyToOne") $afield_att["entity_relation_type_id"] = self::$ENTITY_RELATION_TYPE_MANYTOONE;
                if ($row["RELATION"] == "OneToMany") $afield_att["entity_relation_type_id"] = self::$ENTITY_RELATION_TYPE_ONETOMANY;
                if ($row["RELATION"] == "OneToOneB") $afield_att["entity_relation_type_id"] = self::$ENTITY_RELATION_TYPE_ONETOONEBIDIRECTIONAL;
                if ($row["RELATION"] == "OneToOneU") $afield_att["entity_relation_type_id"] = self::$ENTITY_RELATION_TYPE_ONETOONEUNIDIRECTIONAL;


                if ($row["CHAR_TEMPLATE"])  $afield_att["char_group_men"] = self::char_template_to_mfk($row["CHAR_TEMPLATE"]);

                $afield_att["mode_qsearch"] = ($row["QSEARCH"]) ? "Y" : "N";
                if ($row["REQUIRED"]) {
                        $row["MANDATORY"] = true;
                        $afield_att["applicable"] = "Y";
                } else {
                        $afield_att["applicable"] = "N";
                }

                if ($row["MANDATORY"])  $afield_att["mandatory"] = "Y";
                else $afield_att["mandatory"] = "N";
                /*
            if($row["ANSWER"]=="aparameter")
            {
                die("row[MANDATORY] = ".$row["MANDATORY"]." afield_att = ".var_export($afield_att,true));
            }
            */
                if ($row["READONLY"])  $afield_att["readonly"] = "Y";
                else $afield_att["readonly"] = "N";


                if ($row["DEFAULT"] and $row["UTF8"]) {
                        $afield_att["default_value_utf8"] = $row["DEFAULT"];
                }

                if ($row["DEFAULT"] and (!$row["UTF8"])) {
                        $afield_att["default_value"] = $row["DEFAULT"];
                }

                if ($row["CATEGORY"]) {
                        require_once("$file_dir_name/afield_category.php");
                        $afcObj = AfieldCategory::loadByMainIndex($row["CATEGORY"], false);
                        if ($afcObj) $afield_att["afield_category_id"] = $afcObj->getId();
                }

                // $afield_att["mode_retrieve_admin"] = ($row["SEARCH-ADMIN"]) ? "Y" : "N";
                // $afield_att["mode_edit_admin"] = ($row["SEARCH-ADMIN"]) ? "Y" : "N";
                // $afield_att["mode_qedit_admin"] = ($row["SEARCH-ADMIN"]) ? "Y" : "N";
                $afield_att["field_format"] = $row["FORMAT"];
                $afield_att["title_after"] = $row["TITLE_AFTER"];
                $afield_att["unit"] = $row["UNIT"];
                $afield_att["shortname"] = $row["SHORTNAME"];

                $afield_att["field_where"] = $row["WHERE"];



                $afield_att["utf8"] = ($row["UTF8"]) ? "Y" : "N";
                if (!$afield_att["afield_type_id"]) $afield_att["afield_type_id"] = ($row["TYPE"] == "FK") ? 5 : 0;
                if (!$afield_att["afield_type_id"]) $afield_att["afield_type_id"] = ($row["TYPE"] == "MFK") ? 6 : 0;

                if (!$afield_att["afield_type_id"]) $afield_att["afield_type_id"] = AfwUmsPagHelper::fromAFWtoAfieldType($row["TYPE"], $row["CATEGORY"], $row);

                if (($afield_att["afield_type_id"] == AfwUmsPagHelper::$afield_type_list) or ($afield_att["afield_type_id"] == AfwUmsPagHelper::$afield_type_mlst)) {
                        list($mdl, $tbl, $mdl_id, $tbl_id, $mdl_new, $tbl_new) = AfwUmsPagHelper::getMyModuleAndAtable($id_main_sh, $row["ANSMODULE"], $row["ANSWER"], true);
                        if (!$mdl_id) throw new AfwRuntimeException("ANSMODULE=" . $row["ANSMODULE"] . ", doesnt have module id");
                        if (!$tbl_id) throw new AfwRuntimeException("ANSMODULE=" . $row["ANSMODULE"] . ", ANSWER=" . $row["ANSWER"] . " doesnt have table id");
                        $afield_att["answer_module_id"] = $mdl_id;
                        $afield_att["answer_table_id"] = $tbl_id;
                        if (!$afield_att["entity_relation_type_id"]) $afield_att["entity_relation_type_id"] = self::$ENTITY_RELATION_TYPE_MANYTOONE;
                }

                if (($afield_att["afield_type_id"] == AfwUmsPagHelper::$afield_type_enum) or ($afield_att["afield_type_id"] == AfwUmsPagHelper::$afield_type_menum)) {
                        if ($row["ANSWER"] != 'LOOKUP_TABLE') {
                                $afield_att["specification"] = $row["ANSWER"];
                        }
                        //else $afield_att["specification"] = "";
                }

                $scenario_item_id = 0;
                $scenarioItemList = $myTable->getScis();
                foreach ($scenarioItemList as $scenarioItemObj) {
                        if ($scenarioItemObj->getVal("step_num") == $row["STEP"]) $scenario_item_id = $scenarioItemObj->getId();
                }

                if ($scenario_item_id) $afield_att["scenario_item_id"] = $scenario_item_id;



                $afield_group_id = 0;
                if ($row["FGROUP"] and $myTable) {
                        require_once("$file_dir_name/afield_group.php");
                        $fgroupObj = AfieldGroup::loadByMainIndex($myTable->getId(), $row["FGROUP"], $create_obj_if_not_found = true);
                        if ($myObj) {
                                $fgroupObj->set("fgroup_name_ar", $myObj->translate($row["FGROUP"], "ar"));
                                $fgroupObj->set("fgroup_name_en", $myObj->translate($row["FGROUP"], "en"));
                                $fgroupObj->update();
                        }
                        $afield_group_id = $fgroupObj->getId();
                        if ($afield_group_id) $afield_att["afield_group_id"] = $afield_group_id;
                }



                return $afield_att;
        }

        public function generePhpDesc($scis = null)
        {

                $scStep = $this->hetStep();



                $afield_type_id = $this->getVal("afield_type_id");
                $colname = $this->getVal("field_name");
                $field_order = $this->getVal("field_order");
                $php_errors = "";

                $row = array();
                if ($scStep) {
                        $scStepOrder = $scStep->getVal("step_num");
                        $row["STEP"] = $scStepOrder;
                }

                if (!$row["STEP"]) {
                        if ($scis and count($scis) > 0) {
                                $step = 0;
                                reset($scis);

                                foreach ($scis as $sci_id => $sci_item) {
                                        if (($field_order >= $sci_item->start) and ($field_order <= $sci_item->end)) $step =  $sci_item->valstep_num();
                                }

                                if ($step) {
                                        $row["STEP"] = $step;
                                }
                        }
                }

                $my_tab = $this->het("atable_id");
                if ($my_tab) $table_name = $my_tab->getVal("atable_name");
                else $table_name = "";

                if ($my_tab) $table_abrev = $my_tab->getVal("abrev");
                else $table_abrev = "";

                if ($this->getVal("shortname")) $row["SHORTNAME"] = $this->getVal("shortname");

                // $row["IMPORTANT"]="\"IN\"";
                if ((!$row["SHORTNAME"]) and
                        (strlen($colname) > 8) and
                        (
                                ($afield_type_id == AfwUmsPagHelper::$afield_type_list)
                                or ($afield_type_id == AfwUmsPagHelper::$afield_type_enum)
                                or ($afield_type_id == AfwUmsPagHelper::$afield_type_menum)
                                or ($afield_type_id == AfwUmsPagHelper::$afield_type_mlst)
                        )
                ) {
                        $colname_word_arr = explode("_", $colname);
                        $count_words = count($colname_word_arr);
                        if ($count_words > 1) {
                                $suggested_shortname = "";

                                if ($count_words == 4) {
                                        $colname_word_arr[1] = $colname_word_arr[1] . "_" . $colname_word_arr[2];
                                        $colname_word_arr[2] = $colname_word_arr[3];
                                        unset($colname_word_arr[3]);
                                        $count_words = 3;
                                }

                                if ($count_words > 4) {
                                        $count_words = 0;
                                }

                                for ($i = $count_words - 1; $i >= 0; $i--) {
                                        if (!$suggested_shortname) {
                                                $suggested_shortname = $colname_word_arr[$i];

                                                if (($suggested_shortname == $table_name) or
                                                        ($suggested_shortname == $table_abrev) or
                                                        ($suggested_shortname == "id") or
                                                        ($suggested_shortname == "mfk") or
                                                        ($suggested_shortname == "enum") or
                                                        ($suggested_shortname == "menum") or
                                                        ($suggested_shortname == "men") or
                                                        ($suggested_shortname == "pk") or
                                                        (strlen($suggested_shortname) > 15)
                                                ) {
                                                        $suggested_shortname = "";
                                                }
                                        }
                                }



                                if ($suggested_shortname) {
                                        if ($afield_type_id == AfwUmsPagHelper::$afield_type_list) $row["SHORTNAME"] = $suggested_shortname;
                                        if ($afield_type_id == AfwUmsPagHelper::$afield_type_enum) $row["SHORTNAME"] = $suggested_shortname;
                                        if ($afield_type_id == AfwUmsPagHelper::$afield_type_mlst) $row["SHORTNAME"] = $suggested_shortname . "s";
                                        if ($afield_type_id == AfwUmsPagHelper::$afield_type_menum) $row["SHORTNAME"] = $suggested_shortname . "s";
                                }
                        }
                }

                if ($this->getVal("unit")) {
                        $row["UNIT"] = '"' . $this->getVal("unit") . '"';
                }

                if ($this->getVal("unit_en")) {
                        $row["UNIT_EN"] = '"' . $this->getVal("unit_en") . '"';
                }

                if ($this->attributeIsApplicable("field_where")) {
                        $row["WHERE"] = $this->getVal("field_where");
                }

                if ($afield_type_id == AfwUmsPagHelper::$afield_type_items) {
                        $row["WHERE"] = "";
                        $row["SHOW"] = "true";
                        $row["FORMAT"] = "retrieve";
                        $row["ICONS"] = "true";
                        $row["DELETE-ICON"] = "true";
                        $row["BUTTONS"] = "true";
                }

                $row["SEARCH"] = ($this->getVal("mode_search") == "Y") ? "true" : "false";
                $row["QSEARCH"] = ($this->getVal("qsearch") == "Y") ? "true" : "false";
                $row["SHOW"] = ($this->getVal("mode_show") == "Y") ? "true" : "false";
                $row["AUDIT"] = ($this->getVal("mode_audit") == "Y") ? "true" : "false";
                $row["RETRIEVE"] = ($this->getVal("mode_retrieve") == "Y") ? "true" : "false";
                $row["EDIT"] = ($this->getVal("mode_edit") == "Y") ? "true" : "false";
                $row["QEDIT"] = ($this->getVal("mode_qedit") == "Y") ? "true" : "false";
                if ($this->getVal("field_width")) $row["SIZE"] = $this->getVal("field_width");
                if ($this->getVal("field_size")) $row["MAXLENGTH"] = $this->getVal("field_size");
                if ($this->getVal("field_min_size")) $row["MIN-SIZE"] = $this->getVal("field_min_size");
                if ($this->getVal("char_group_men")) $row["CHAR_TEMPLATE"] = "\"" . self::mfk_to_char_template($this->getVal("char_group_men")) . "\"";


                // if($this->getVal("mode_show_admin")=="Y") $row["SHOW-ADMIN"] = "true";
                // if($this->getVal("mode_retrieve_admin")=="Y") $row["RETRIEVE-ADMIN"] = "true";
                // if($this->getVal("mode_edit_admin")=="Y") $row["EDIT-ADMIN"] = "true";
                // if($this->getVal("mode_qedit_admin")=="Y") $row["QEDIT-ADMIN"] = "true";
                if ($this->getVal("mandatory") == "Y") {
                        if ($this->getVal("applicable") == "Y") {
                                $row["REQUIRED"] = "true";
                        } else {
                                $row["MANDATORY"] = "true";
                        }
                }

                if ($this->getVal("field_format")) $row["FORMAT"] = $this->getVal("field_format");
                if ($this->getVal("title_after")) $row["TITLE_AFTER"] = $this->getVal("title_after");


                $row["UTF8"] = ($this->getVal("utf8") == "Y" and $this->isText()) ? "true" : "false";;

                if ($colname == "titre") {
                        $row["UTF8"] = "true";
                        $row["SIZE"] = 255;
                }

                if ($colname == "titre_short") {
                        $row["UTF8"] = "true";
                        $row["SIZE"] = 40;
                        $row["SHORTNAME"] = "\"title\"";
                }

                if (AfwStringHelper::stringEndsWith($colname, "_ar")) {
                        $row["UTF8"] = "true";
                }

                if (AfwStringHelper::stringEndsWith($colname, "_fr")) {
                        $row["UTF8"] = "false";
                }

                if (AfwStringHelper::stringEndsWith($colname, "_en")) {
                        $row["UTF8"] = "false";
                }

                //$exp_name = explode("_", $colname);



                if ($afield_type_id == AfwUmsPagHelper::$afield_type_mtxt) {
                        $row["TYPE"] = "'TEXT'";
                        $row["SIZE"] = "'AREA'";
                } elseif ($afield_type_id == AfwUmsPagHelper::$afield_type_items) {
                        $row["TYPE"] = "'FK'";
                        $row["CATEGORY"] = "'ITEMS'";
                        if ($this->getVal("answer_table_id")) {
                                $row["ANSWER"] = "'" . $this->get("answer_table_id")->getVal("atable_name") . "'";
                                $row["ANSMODULE"] = "'" . $this->get("answer_module_id")->getVal("module_code") . "'";
                        }
                        if (!$row["ANSWER"]) {
                                $php_errors .= "no answer table defined for field $colname ";
                                $row["ANSWER"] = '"????"';
                        }
                } elseif ($afield_type_id == AfwUmsPagHelper::$afield_type_list) {
                        $row["TYPE"] = "'FK'";
                        if ($this->getVal("answer_table_id")) {
                                $ansTabObj = $this->get("answer_table_id");
                                $row["ANSWER"] = "'" . $ansTabObj->getVal("atable_name") . "'";
                                $at_module = $this->het("answer_module_id");
                                if (!$at_module) $at_module = $ansTabObj->het("id_module");
                                $row["ANSMODULE"] = "'" . $at_module->getVal("module_code") . "'";
                                if ($ansTabObj->hasManyData()) $row["AUTOCOMPLETE"] = "true";
                        }
                        if (!$row["ANSWER"]) {
                                $php_errors .= "no answer table defined for field $colname ";
                                $row["ANSWER"] = '"????"';
                        }

                        $ertype = $this->het("ertype");
                        if ($ertype) {
                                $ertype_code = $ertype->getVal("lookup_code");
                                $row["RELATION"] = "'" . $ertype_code . "'";
                        }
                } elseif ($afield_type_id == AfwUmsPagHelper::$afield_type_mlst) {
                        $row["TYPE"] = "'MFK'";
                        if ($this->getVal("answer_table_id")) {
                                $row["ANSWER"] = "'" . $this->get("answer_table_id")->getVal("atable_name") . "'";
                                $row["ANSMODULE"] = "'" . $this->get("answer_table_id")->getModule()->getVal("module_code") . "'";
                        }
                        if (!$row["ANSWER"]) {
                                $php_errors .= "no answer table defined for field $colname ";
                                $row["ANSWER"] = '"????"';
                        }
                } elseif ($afield_type_id == AfwUmsPagHelper::$afield_type_enum) {
                        $row["TYPE"] = "'ENUM'";
                        if ($this->getVal("answer_table_id")) {
                                $row["ANSWER"] = "'FUNCTION'";  // ".$this->get("answer_table_id")->getVal("atable_name")."
                                // $row["ANSMODULE"] = "'".$this->get("answer_module_id")->getVal("module_code")."'";
                        }
                        if (!$row["ANSWER"]) {
                                // $php_errors .= "no answer table defined for field $colname ";
                                $row["ANSWER"] = '"FUNCTION"';
                        }
                } elseif ($afield_type_id == AfwUmsPagHelper::$afield_type_menum) {
                        $row["TYPE"] = "'MENUM'";
                        if ($this->getVal("answer_table_id")) {
                                $row["ANSWER"] = "'" . $this->get("answer_table_id")->getVal("atable_name") . "'";
                                $row["ANSMODULE"] = "'" . $this->get("answer_table_id")->getModule()->getVal("module_code") . "'";
                        }
                        if (!$row["ANSWER"]) {
                                // $php_errors .= "no answer table defined for field $colname ";
                                $row["ANSWER"] = '"FUNCTION"';
                        }
                } elseif ($afield_type_id == AfwUmsPagHelper::$afield_type_pctg) {
                        $row["TYPE"] = "'PCTG'";
                        $row["UNIT"] = "'%'";
                } else {
                        if ($this->getVal("afield_type_id") <= 0) {
                                $php_errors .= "no field type defined for field $colname ";
                                $row["TYPE"] = 'no field type defined !!!!';
                        } else {
                                $type_res = $this->get("afield_type_id")->getAfwType();
                                $row["TYPE"] = "'" . $type_res . "'";
                        }
                }

                if ($row["TYPE"] == "'ENUM'") {
                        $row["ANSWER"] = "'" . $this->getVal("specification") . "'";
                }

                if ($row["TYPE"] == '"FK"') {
                        $row["SIZE"] = 40;
                        $row["DEFAUT"] = 0;
                }

                if ($this->getVal("default_value_utf8")) {
                        $row["DEFAUT"] = "'" . $this->getVal("default_value_utf8") . "'";
                }

                if ($this->getVal("default_value")) {
                        $row["DEFAULT"] = "'" . $this->getVal("default_value") . "'";
                }


                if ($afield_type_id == AfwUmsPagHelper::$afield_type_yn) {
                        if ($this->may("mandatory")) {
                                $row["CHECKBOX"] = "true";
                        }
                }

                if ($afield_type_id == AfwUmsPagHelper::$afield_type_date) {
                        $specification = $this->getVal("specification");
                        if ($specification) {
                                $specification_arr = explode(",", $specification);
                                for ($ii = 0; $ii < count($specification_arr); $ii++) {
                                        $category_prop = $specification_arr[$ii];
                                        $category_prop_parts = explode("=", $category_prop);
                                        if (($ii == 0) and (count($category_prop_parts) == 1)) {
                                                $category_prop_parts[1] = $category_prop_parts[0];
                                                $category_prop_parts[0] = "FORMAT";
                                        }
                                        $row[$category_prop_parts[0]] = "'" . $category_prop_parts[1] . "'";
                                }
                        } else {
                        }
                        if (!$row["FORMAT"]) $row["FORMAT"] = "'HIJRI_UNIT'";  // CONVERT_NASRANI_SIMPLE
                }

                if (!$this->may("reel")) {
                        $spec = $this->getVal("specification");

                        $spec_arr = explode("/", $spec);
                        if ($spec_arr[0]) $row["CATEGORY"] = $spec_arr[0];
                        if ($spec_arr[1] and $spec_arr[0]) {
                                $category_props_arr = explode(",", $spec_arr[1]);

                                for ($ii = 0; $ii < count($category_props_arr); $ii++) {
                                        $category_prop = $category_props_arr[$ii];
                                        $category_prop_parts = explode("=", $category_prop);
                                        if (($ii == 0) and (count($category_prop_parts) == 1)) {
                                                $category_prop_parts[1] = $category_prop_parts[0];
                                                $category_prop_parts[0] = $row["CATEGORY"];
                                        }
                                        if ($category_prop_parts[0] and $category_prop_parts[1]) {
                                                $row[$category_prop_parts[0]] = "'" . $category_prop_parts[1] . "'";
                                        }
                                }
                        }
                        if ($spec_arr[2]) $row["ANSWER"] = $spec_arr[2];

                        //$row["EDIT"] = "false"; rafik : No because virtual can be setted fields are editable 
                        $row["MANDATORY"] = "false";
                        if ($row["CATEGORY"] == "FORMULA") $row["READONLY"] = "true";
                        else $row["READONLY"] = ($this->getVal("readonly") == "Y") ? "true" : "false";
                } else {
                        $row["READONLY"] = ($this->getVal("readonly") == "Y") ? "true" : "false";
                }


                $foptionList = $this->get("foption_mfk");
                foreach ($foptionList as $foptionItem) {
                        if ($foptionItem->isHzm()) {
                                $row[$foptionItem->getVal("lookup_code")] = "true";
                        }
                }

                // DEPENDENT_OFME=>array("id_sub_module"), DEPENDENCY=>system_id

                $dependencyList = $this->get("dependencyList");
                $dependentList = $this->get("dependentList");

                if (count($dependencyList) > 0) {

                        $row["DEPENDENCIES"] = AfwStringHelper::hzmArrayStringFormat(AfwWizardHelper::listToArray($dependencyList, "field_name"));

                        $afieldDependencyList = $this->get("afieldDependencyList");

                        $where_dependencies = implode(" and ", AfwWizardHelper::listToArray($afieldDependencyList, "rule_params"));

                        if ($where_dependencies) {
                                if ($row["WHERE"]) $row["WHERE"] .= " and ";
                                $row["WHERE"] .= $where_dependencies;
                        }
                }
                if (count($dependentList) > 0) $row["DEPENDENT_OFME"] = AfwStringHelper::hzmArrayStringFormat(AfwWizardHelper::listToArray($dependentList, "field_name"));


                if ($row["WHERE"]) $row["WHERE"] = "\"" . $row["WHERE"] . "\"";
                else unset($row["WHERE"]);

                return array($row, $php_errors);
        }


        public function getNodeDisplay($lang = "ar")
        {
                //return $this->translateOperator("FIELD",$lang)." ".$this->getShortDisplay($lang);
                $return = $this->getVal("field_name") . " " . $this->getShortDisplay($lang);
                /*
                if ($this->getVal("atable_id") > 0) {
                        $return .= " " . $this->showAttribute("atable_id", null, true, $lang);
                }*/
                if($this->sureIs("distinct_for_list")) $return .= "<span class='sql key'>U</span>";

                return $return;
        }

        public function getShortDisplay($lang = "ar")
        {
                $lang = strtolower($lang);
                if (!$lang) $lang = "ar";
                if ($lang == "fr") $lang_suffix = "_en";
                elseif ($lang == "ar") $lang_suffix = "";
                else $lang_suffix = "_" . $lang;

                $fn = trim($this->getVal("titre_short$lang_suffix"));


                return $fn;
        }


        public function getDisplay($lang = "ar")
        {
                $lang = strtolower($lang);
                if ($lang == "fr") $lang_suffix = "_en";
                elseif ($lang == "ar") $lang_suffix = "";
                else $lang_suffix = "_" . $lang;

                $fn = $this->getShortDisplay($lang);
                if (!$fn) $fn = trim($this->getVal("titre$lang_suffix"));
                $id = $this->getId();
                if (!$fn) $fn = "afield.$id";

                return $fn;
        }

        public function getDropDownDisplay($lang = "ar")
        {
                $this_field_name = $this->getVal("field_name");
                $fn = $this->getShortDisplay($lang) . " " . $this_field_name;

                return $fn;
        }

        public function getFieldDim()
        {
                if ($this->getVal("field_width") > 10) return $this->getVal("field_width");
                else {
                        if ($this->getVal("afield_type_id") == 5) return 25;
                        if ($this->getVal("afield_type_id") == 6) return 25;
                        if ($this->getVal("afield_type_id") == 2) return 25;
                        if ($this->getVal("afield_type_id") == 9) return 25;
                }

                return intval($this->getVal("field_width")) + 2;
        }

        public function isHDate()
        {
                return ($this->getVal("afield_type_id") == 2);
        }

        public function isDate()
        {
                return ($this->getVal("afield_type_id") == 9);
        }

        public function getPreviousAfield()
        {
                $my_tab = $this->get("atable_id");
                // if($my_tab)
                return $my_tab->getAFieldBefore($this, true);
                // else

        }

        public function getNextAfield()
        {
                $my_tab = $this->get("atable_id");
                // if($my_tab)
                return $my_tab->getAFieldAfter($this, true);
                // else

        }



        public function myJavaName()
        {
                $this_field_id  = $this->getId();
                $this_field_name = $this->getVal("field_name");
                if ($this->getVal("afield_type_id") == 5) {
                        $atab = $this->het("atable_id");
                        $anstab = $this->het("answer_table_id");
                        if (!$atab) return "error : no table associated to $this_field_name($this_field_id) " . $this;
                        if (!$anstab) return "error : no answer table for $this_field_name($this_field_id) " . $this;
                        if ($atab->getVal("id_module") == $anstab->getVal("id_module")) {
                                if (AfwStringHelper::stringEndsWith(strtoupper($this_field_name), "_ID")) {
                                        $this_field_name = substr($this_field_name, 0, strlen($this_field_name) - 3);
                                }
                        }
                }

                return AfwStringHelper::javaNaming($this_field_name);
        }


        public function getGeneraltedSQL($dbms, $syntax_values, $fields_naming_uc, $alter_table = false)
        {
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

                $null_syntax = $syntax_values["NULL_SYNTAX"];
                $notnull_syntax = $syntax_values["NOTNULL_SYNTAX"];
                $utf8_syntax = $syntax_values["UTF8_SYNTAX"];


                if (!$this->getVal("atable_id")) return "no table";
                $my_tab = $this->get("atable_id");
                $field_name = $this->getVal("field_name");
                if ($fields_naming_uc) $field_name = strtoupper($field_name);

                $field_size = $this->getVal("field_size");
                $field_mandatory =  ($this->getVal("mandatory") == "Y");
                $field_utf8 = ($this->getVal("utf8") == "Y");
                $afield_type_id = $this->getVal("afield_type_id");
                if (!$afield_type_id) return "getSQL::Error not defined field type for field `$field_name` of table `" . $my_tab->getVal("atable_name") . "`\n";
                $afield_type_obj = $this->get("afield_type_id");
                $field_type = $afield_type_obj->getVal("${dbms}_field_type");
                if ($field_size) $field_type = str_replace("[SIZE]", $field_size, $field_type);
                $table_utf8 = ($my_tab->getVal("utf8") == "Y");
                if ((!$table_utf8) and $field_utf8) $field_type = str_replace("[UTF8]", $utf8_syntax, $field_type);
                else $field_type = str_replace("[UTF8]", "", $field_type);

                if (!$field_mandatory) {
                        $field_null = $null_syntax;
                } else {
                        $field_null = $notnull_syntax;
                }

                $table_name = $my_tab->getVal("atable_name");
                $mcode = $server_db_prefix . $my_tab->getModule()->getVal("module_code");
                if ($alter_table) $alter_table_sql = "-- ALTER TABLE $mcode.$table_name add";
                else $alter_table_sql = "";

                if ($alter_table) {
                        if ($dbms == "sql") {
                                $prev_af = $this->getPreviousAfield();
                                if ($prev_af) {
                                        $prev_col = $prev_af->getVal("field_name");
                                        $end_sql = " AFTER $prev_col;";
                                } else $end_sql = " AFTER id;";
                        } else $end_sql = ";";
                } else $end_sql = ", \n";

                return "$alter_table_sql   $field_name $field_type $field_null $end_sql";
        }

        public function getFormuleResult($attribute, $what = 'value')
        {
                global $lang;
                $this_id = $this->getId();
                $mytable = $this->hetTable();
                $fk_tab = $this->het("answer_table_id");
                if ($fk_tab) $fk_tab_id = $fk_tab->id;
                else $fk_tab_id = 0;

                if ($mytable) $module = $mytable->hetModule();
                else $module = null;
                switch ($attribute) {
                        case "fk_table_single":
                                $lang_suffix = "_$lang";
                                if ($lang_suffix == "_ar") $lang_suffix = "";
                                if ($fk_tab) return $fk_tab->getVal("singletitle" . $lang_suffix);
                                return "no fk tab for field " . $this . "($fk_tab_id)";

                                break;

                        case "fk_table_plural":
                                $lang_suffix = "_$lang";
                                if ($lang_suffix == "_ar") $lang_suffix = "";
                                if ($fk_tab) return $fk_tab->getVal("pluraltitle" . $lang_suffix);
                                return "no fk tab for field " . $this . "($fk_tab_id)";
                                break;

                        case "fld_table_single":
                                $lang_suffix = "_$lang";
                                if ($lang_suffix == "_ar") $lang_suffix = "";
                                if ($mytable) return $mytable->getVal("singletitle" . $lang_suffix);
                                else return "";

                                break;

                        case "fld_table_plural":
                                $lang_suffix = "_$lang";
                                if ($lang_suffix == "_ar") $lang_suffix = "";
                                if ($mytable) return $mytable->getVal("pluraltitle" . $lang_suffix);
                                else return "";

                                break;


                        case "system_id":
                                if ($module) {
                                        $system = $module->hetParent();
                                        if ($system) return $system;
                                        else return 0;
                                } else return 0;
                                break;

                        case "parent_module_id":
                                if ($module) return $module;
                                else return 0;
                                break;

                        case "answerclass":
                                $fn = $this->myAnswerClass();
                                break;
                        case "sql":
                                if ($mytable) $module = $mytable->hetModule();
                                else $module = null;

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

                                if ((!$dbms) or (!$dbsystem) or (!$dbengine)) return "Please define db system and engine of module [$module] for the table [$mytable] of the field [$this]";

                                $syntax_values = $dbsystem->loadSyntax();


                                $tables_naming_uc = ($dbengine->getVal("tables_naming_uc") == 'Y');
                                $fields_naming_uc = ($dbengine->getVal("fields_naming_uc") == 'Y');

                                $field_name = $this->getVal("field_name");
                                $fn0 = $this->getGeneraltedSQL($dbms, $syntax_values, $fields_naming_uc, true);
                                // die("$fn0 = this->getGeneraltedSQL($dbms,$syntax_values,$fields_naming_uc,true);");
                                $fn1 = str_replace(" add ", " change ", $fn0);
                                $fn1 = str_replace($field_name, $field_name . " " . $field_name, $fn1);

                                $fn = $fn0 . "\n" . $fn1;
                                break;

                        case "php_att":
                                $fn = $this->getPhpAfwAttribute();
                                $mytable = $this->hetTable();
                                $field_name = $this->getVal("field_name");
                                $field_trad_ar = $this->getVal("titre_short");
                                $field_trad_en = $this->getVal("titre_short_en");
                                if ($mytable) $tabName = $mytable->getVal("atable_name");

                                $fn .= "\n\n\tar : \$trad[\"$tabName\"][\"$field_name\"] = \"$field_trad_ar\";";
                                $fn .= "\n\n\ten : \$trad[\"$tabName\"][\"$field_name\"] = \"$field_trad_en\";";

                                break;
                        case "java_name":
                                $fn = $this->myJavaName();
                                break;
                }

                return $fn;
        }


        public function getPhpAfwAttribute()
        {
                global $lang;
                $this_id = $this->getId();
                $mytable = $this->hetTable();

                $field_name = $this->getVal("field_name");
                $field_trad = $this->getDisplay();
                if ($mytable) $tabName = $mytable->getVal("atable_name");
                else return "error : define table first";
                $scis = $mytable->get("scis");
                list($phpDesc, $php_errors) = $this->generePhpDesc($scis);
                $fn = "'" . $field_name . "' => array(";
                $tempRdesc = array();
                foreach ($phpDesc as $prop => $val) {

                        if (($val != "true")
                                and ($val != "false")
                                and (!is_numeric($val))
                                and (!is_bool($val))
                                and (!AfwStringHelper::stringStartsWith($val, "\""))
                                and (!AfwStringHelper::stringStartsWith($val, "'"))
                        ) {
                                $val = "'$val'";
                        }

                        if ($prop == "DEFAULT") $prop = "DEFAUT";

                        if (($prop == "TYPE") or ($prop == "EDIT") or ($prop == "RELATION") or ($prop == "SIZE") or ($prop == "CATEGORY"))
                                array_push($tempRdesc, "\n\t\t\t\t'$prop' => $val, ");
                        elseif (($prop == "TYPE") or ($prop == "WHERE") or ($prop == "DEPENDENCIES") or ($prop == "DEPENDENT_OFME"))
                                array_push($tempRdesc, "\n\t\t\t\t'$prop' => $val, \n\t\t\t\t");
                        elseif (AfwStringHelper::is_valid_code($prop))
                                array_push($tempRdesc, "'$prop' => $val, ");
                        else
                                array_push($tempRdesc, "'$prop' => $val, ");
                }
                $fn .= implode(" ", $tempRdesc) . "\n\t\t\t\t'CSS' => 'width_pct_50', ),\n";


                return $fn;
        }

        protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
        {
                global $lang;
                $objme = AfwSession::getUserConnected();
                $me = ($objme) ? $objme->id : 0;

                $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
                if ($this->getVal("atable_id") <= 0) return $otherLinksArray;
                $tbl = &$this->getTable();
                $tbl_id = $tbl->getId();
                $fld_id = $this->getId();

                $pf = $this->getPreviousAfield();
                $nf = $this->getNextAfield();
                $displ = $this->getDisplay($lang);


                if ($nf) $next_field_id = $nf->getId();
                else $next_field_id = 0;
                if ($pf) $previous_field_id = $pf->getId();
                else $previous_field_id = 0;

                if (($mode == "edit") and ($next_field_id)) {
                        $link = array();
                        $link["URL"] = "main.php?Main_Page=afw_mode_display.php&cl=Afield&currmod=pag&id=$next_field_id";
                        $link["TITLE"] = "الحقل الموالي : " . $nf->getDisplay($lang);
                        $link["COLOR"] = "yellow";
                        $link["UGROUPS"] = array();
                        // $link["STEP"] = 8;
                        $otherLinksArray[] = $link;
                }

                if (($mode == "edit") and ($previous_field_id)) {
                        $link = array();
                        $link["URL"] = "main.php?Main_Page=afw_mode_display.php&cl=Afield&currmod=pag&id=$previous_field_id";
                        $link["TITLE"] = "الحقل السابق : " . $pf->getDisplay($lang);
                        $link["COLOR"] = "yellow";
                        $link["UGROUPS"] = array();
                        // $link["STEP"] = 8;
                        $otherLinksArray[] = $link;
                }
                if ($mode == "qedit") {
                        $link = array();

                        $link["URL"] = "main.php?Main_Page=afw_mode_display.php&cl=Atable&currmod=pag&id=$tbl_id";
                        $link["TITLE"] = "خصائص الجدول " . $tbl->valTitre_short();
                        $link["COLOR"] = "yellow";
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        $mod = $tbl->valId_module();
                        $link = array();
                        $link["URL"] = "dbgen.php?sql=1&show_sql=1&mod=$mod&tbl=$tbl_id";
                        $link["TITLE"] = "SQL of " . $tbl->valClass_name();
                        $link["ADMIN-ONLY"] = true;
                        $link["COLOR"] = "green";
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        $link = array();
                        $link["URL"] = "dbgen.php?php=1&trad=1&mod=$mod&tbl=$tbl_id";
                        $link["TITLE"] = "PHP of " . $tbl->valClass_name();
                        $link["ADMIN-ONLY"] = true;
                        $link["COLOR"] = "blue";
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }


                if ($mode == "display") {
                        if ($this->isText() and (!$this->hasTranslation())) {

                                $link = array();
                                $link["URL"] = "main.php?Main_Page=translate_field.php&My_Module=pag&fld=$fld_id&tbl=$tbl_id&to_lang=en";
                                $link["TITLE"] = "انشاء حقل ترجمة بالانجليزي للحقل  : " . $this->valTitre_short();
                                $link["ADMIN-ONLY"] = true;
                                $link["COLOR"] = "blue";
                                $link["UGROUPS"] = array();
                                $otherLinksArray[] = $link;
                        }
                }

                if ($mode == "mode_afieldOptionValueList") {
                        unset($link);
                        $my_id = $this->getId();
                        $link = array();
                        $title = "إدارة قيمات الخيارات للحقول ";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=AfieldOptionValue&currmod=pag&id_origin=$my_id&class_origin=Afield&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=afield_id=$my_id&sel_afield_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }

                if ($mode == "mode_afieldRuleList") {
                        unset($link);
                        $my_id = $this->getId();
                        $link = array();
                        $title = "إدارة قواعد عمل الحقل ";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=AfieldRule&currmod=pag&id_origin=$my_id&class_origin=Afield&module_origin=pag&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=afield_id=$my_id&sel_afield_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }

                return $otherLinksArray;
        }



        // renommage d'une col : ALTER TABLE `bfunction` CHANGE `module_id` `curr_class_module_id` INT(11) NULL DEFAULT NULL;

        public function hasTranslation($from_lang = "ar", $to_lang = "en")
        {

                $field_name_ar = $this->getVal("field_name") . "#";
                $my_field_name = str_replace("_${from_lang}#", '', $field_name_ar);
                $my_field_name_trans = $my_field_name . "_$to_lang";

                $af_trans = $this->getTable()->getAFieldByFieldName($my_field_name_trans);
                return $af_trans;
        }


        public function isText()
        {
                return (($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_text) or
                        ($this->getVal("afield_type_id") == AfwUmsPagHelper::$afield_type_mtxt));
        }

        public function isInternalRelation()
        {
                $atab = $this->het("atable_id");
                $anstab = $this->het("answer_table_id");

                return (($atab and $anstab) and ($atab->getVal("id_module") == $anstab->getVal("id_module")));
        }


        public function getTableClass()
        {
                $anstab = $this->het("answer_table_id");
                if ($anstab)  return $anstab->getTableClass();
                else return "";
        }

        public function myAnswerClass()
        {
                if (!$this->getVal("answer_table_id")) {
                        return "not-defined";
                } else {
                        $anstab = $this->het("answer_table_id");
                        if ((!$this->isInternalRelation()) and (!$anstab->_isEnum()))
                                return "Long";
                        else
                                return $this->getTableClass();
                }
        }


        public function getRelationFromName($name)
        {
                $str = $name;
                $anstab = $this->het("answer_table_id");
                if ($anstab) $anstab_name = $anstab->getVal("atable_name");
                else $anstab_name = "";
                $tab = $this->het("answer_table_id");
                $tab_name = $tab->getVal("atable_name");
                $str = str_replace('_id', '', $str);
                if ($tab_name) $str = str_replace('_' . $tab_name, '', $str);
                if ($anstab_name) $str = str_replace('_' . $anstab_name, '', $str);

                return $str;
        }

        public function getShortHzmName()
        {
                if (!$this->getVal("shortname_en")) {
                        $short_name = AfwStringHelper::hzmNaming($this->getRelationFromName($this->getVal("field_name")));
                } else {
                        $short_name = AfwStringHelper::hzmNaming($this->getVal("shortname_en"));
                }

                return AfwStringHelper::inverseRelation($short_name);
        }

        public function getEnumTables()
        {
                global $enum_tables, $count_here;

                $this_id = $this->getId();

                if (!$count_here) $count_here = 1;
                else $count_here++;

                $parent_module_id = $this->getVal("parent_module_id");
                $answer_module_id = $this->getVal("answer_module_id");
                if (!$answer_module_id) $answer_module_id = $parent_module_id;

                if ($answer_module_id and (!$enum_tables[$answer_module_id])) {
                        /*
                             if($count_here>50)
                             {
                                throw new AfwRuntimeException("why I get here [afield::getLookupTables] $count_here time called  ??!!");
                             } */

                        // require_once("atable.php");
                        $anstab = new Atable();

                        $anstab->where("avail='Y' and id_module = $answer_module_id");
                        $anstab->where("is_entity='N' and is_lookup='Y'");

                        $enum_tables[$answer_module_id] = $anstab->loadMany();
                }


                return $enum_tables[$answer_module_id];
        }


        public function getLookupTables()
        {
                global $lookup_tables, $count_here;

                if (!$count_here) $count_here = 1;
                else $count_here++;



                $parent_module_id = $this->getVal("parent_module_id");
                $answer_module_id = $this->getVal("answer_module_id");
                if (!$answer_module_id) $answer_module_id = $parent_module_id;

                if ($answer_module_id and (!$lookup_tables[$answer_module_id])) {
                        /*
                             if($count_here>50)
                             {
                                throw new AfwRuntimeException("why I get here [afield::getLookupTables] $count_here once  ??!!");
                             }
                             */
                        // require_once("atable.php");
                        $anstab = new Atable();

                        $anstab->where("avail='Y' and id_module = $answer_module_id");
                        $anstab->where("is_entity='Y'");

                        $lookup_tables[$answer_module_id] = $anstab->loadMany();
                }

                return $lookup_tables[$answer_module_id];  // self::   
        }


        public function getAnswerTables()
        {

                if ((in_array($this->getVal("afield_type_id"), array(12, 15)))) {
                        return $this->getEnumTables();
                }

                if ((in_array($this->getVal("afield_type_id"), array(5, 6, 17)))) {
                        return $this->getLookupTables();
                }

                return array();
        }

        protected function getSpecificDataErrors($lang = "ar", $show_val = true, $step = "all", $erroned_attribute = null, $stop_on_first_error = false, $start_step = null, $end_step = null)
        {
                $sp_errors = array();

                if (!$this->getVal("afield_type_id")) {
                        $sp_errors["afield_type_id"] = "نوع الحقل مفقود";
                }

                if (!$this->getVal("field_name")) {
                        $sp_errors["field_name"] = "رمز الحقل مفقود";
                }

                if (!$this->getVal("titre_short")) {
                        $sp_errors["titre_short"] = "مسمى الحقل المختصر مفقود";
                }

                /*
              if(in_array($this->getVal("afield_type_id"),array(5,6,12,15,17)))
              {
                   if(!$this->getVal("answer_table_id")) $sp_errors["answer_table_id"] = "جدول الاختيارات مفقود";
                   elseif(!$this->getVal("answer_module_id")) $sp_errors["answer_module_id"] = "وحدة جدول الاختيارات مفقودة";
              }
              */

                if (($this->getVal("afield_type_id") == 5) and ($this->may("reel"))) {
                        if ((!$this->getVal("entity_relation_type_id")) or ($this->getVal("entity_relation_type_id") == 3)) $sp_errors["entity_relation_type_id"] = "لا بد من تحديد نوع العلاقة مع جدول الاختيارات";
                }


                return $sp_errors;
        }

        public function myCategory()
        {
                if (!$this->_isReel()) return 1;
                return 0;
        }

        public static function char_template_to_mfk($char_template)
        {
                $char_template = self::char_groups_template($char_template);
                $char_template_arr = explode(",", $char_template);
                $mfk_arr = array();
                foreach ($char_template_arr as $char_template_item) {
                        $mfk_arr[] = self::char_group_code_to_id($char_template_item);
                }

                if (count($mfk_arr) > 0) {
                        return "," . implode(",", $mfk_arr) . ",";
                } else return "";
        }

        public static function mfk_to_char_template($mfk)
        {
                $mfk_arr = explode(",", trim($mfk, ","));
                $temp_arr = array();

                foreach ($mfk_arr as $mfk_item) {
                        $temp_arr[] = self::char_group_id_to_code($mfk_item);
                }

                if (count($temp_arr) > 0) {
                        return implode(",", $temp_arr);
                } else return "";
        }


        public static function char_groups_template($char_template)
        {
                if ($char_template == "LOOKUP_CODE") $char_template = "ALPHABETIC,UNDERSCORE";
                if ($char_template == "TEXT_AR") $char_template = "ARABIC-CHARS,SPACE";
                if ($char_template == "TEXT_EN") $char_template = "ALPHABETIC,SPACE";

                return  $char_template;
        }

        public static function char_group_id_to_code($id)
        {
                $code = "";
                if ($id == 1) $code = "ALPHABETIC";
                if ($id == 2) $code = "ARABIC-CHARS";
                if ($id == 3) $code = "NUMERIC";
                if ($id == 4) $code = "MATH-SYMBOLS";
                if ($id == 5) $code = "BRACKETS";
                if ($id == 6) $code = "COMMAS";
                if ($id == 7) $code = "SPACE";
                if ($id == 8) $code = "MARKS";
                if ($id == 9) $code = "UNDERSCORE";
                if ($id == 10) $code = "OTHER-SYMBOLS";
                if ($id == 11) $code = "ALL";
                return  $code;
        }

        public static function char_group_code_to_id($code)
        {
                $id = "";
                if ($code == "ALPHABETIC")    $id = 1;
                if ($code == "ARABIC-CHARS")  $id = 2;
                if ($code == "NUMERIC")       $id = 3;
                if ($code == "MATH-SYMBOLS")  $id = 4;
                if ($code == "BRACKETS")      $id = 5;
                if ($code == "COMMAS")        $id = 6;
                if ($code == "SPACE")         $id = 7;
                if ($code == "MARKS")         $id = 8;
                if ($code == "UNDERSCORE")    $id = 9;
                if ($code == "OTHER-SYMBOLS") $id = 10;
                if ($code == "ALL")           $id = 11;
                return  $id;
        }

        public function list_of_char_group_men()
        {
                $list_of_items = array();
                $list_of_items[1] = "   a..z alphabetic";  //     code : ALPHABETIC 
                $list_of_items[2] = "أ..ي حروف عربية";  //     code : ARABIC-CHARS 
                $list_of_items[5] = "[]{}()     أقواس متنوعة";  //     code : BRACKETS 
                $list_of_items[6] = ":;,،  فواصل";  //     code : COMMAS 
                $list_of_items[8] = "\" '   علامات الاقتباس";  //     code : MARKS 
                $list_of_items[4] = "  +-*/  رموز حساب";  //     code : MATH-SYMBOLS 
                $list_of_items[3] = "0..9 الأرقام";  //     code : NUMERIC 
                $list_of_items[10] = "  كل الرموز الأخرى     $%#@...الخ";  //     code : OTHER-SYMBOLS 
                $list_of_items[7] = "فضاء";  //     code : SPACE 
                $list_of_items[9] = "مطة  اندرسكور  _";  //     code : UNDERSCORE\
                $list_of_items[11] = "الجميع";  //     code : OTHER-SYMBOLS 
                return  $list_of_items;
        }


        public function getRAMObjectData()
        {
                $category_id = 8;

                $file_dir_name = dirname(__FILE__);
                require_once("$file_dir_name/../bau/r_a_m_object_type.php");
                $fTypeObj = $this->getFType();
                $lookup_code = $fTypeObj->getVal("lookup_code");
                $typeObj = RAMObjectType::loadByMainIndex("field." . $lookup_code);
                $type_id = $typeObj->getId();

                $code = $this->getVal("field_name");
                if (!$code) throw new AfwRuntimeException("this field is without field name");
                $name_ar = $this->getVal("titre_short");
                $name_en = $this->getVal("titre_short_en");
                $specification = $this->getVal("titre");

                $childs = array();

                return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
        }

        public function beforeDelete($id, $id_replace)
        {


                if ($id) {
                        if ($id_replace == 0) {
                                $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - not deletable 


                                $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - deletable 


                                // FK not part of me - replaceable 
                                // pag.atable-ادارة السجلات عبر احتمالات الحقل	look_from_field_id  حقل يفلتر به-ManyToOne
                                $this->execQuery("update ${server_db_prefix}pag.atable set look_from_field_id='$id_replace' where look_from_field_id='$id' ");
                                // pag.db_link-الحقل سبب العلاقة	field_id  حقل يفلتر به-ManyToOne
                                $this->execQuery("update ${server_db_prefix}pag.db_link set field_id='$id_replace' where field_id='$id' ");
                                // sdd.acondition-حقل الشرط	afield_id  حقل يفلتر به-ManyToOne
                                // $this->execQuery("update ${server_db_prefix}sdd.acondition set afield_id='$id_replace' where afield_id='$id' ");
                                // sdd.acondition-حقل معيار الشرط	context_afield_id  حقل يفلتر به-ManyToOne
                                // $this->execQuery("update ${server_db_prefix}sdd.acondition set context_afield_id='$id_replace' where context_afield_id='$id' ");



                                // MFK
                                // pag.atable-الحقول الثابتة في التعديل السريع	qfim_fields_mfk  
                                $this->execQuery("update ${server_db_prefix}pag.atable set qfim_fields_mfk=REPLACE(qfim_fields_mfk, ',$id,', ',') where qfim_fields_mfk like '%,$id,%' ");
                        } else {
                                $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK on me 
                                // pag.atable-ادارة السجلات عبر احتمالات الحقل	look_from_field_id  حقل يفلتر به-ManyToOne
                                $this->execQuery("update ${server_db_prefix}pag.atable set look_from_field_id='$id_replace' where look_from_field_id='$id' ");
                                // pag.db_link-الحقل سبب العلاقة	field_id  حقل يفلتر به-ManyToOne
                                $this->execQuery("update ${server_db_prefix}pag.db_link set field_id='$id_replace' where field_id='$id' ");
                                // sdd.acondition-حقل الشرط	afield_id  حقل يفلتر به-ManyToOne
                                // $this->execQuery("update ${server_db_prefix}sdd.acondition set afield_id='$id_replace' where afield_id='$id' ");
                                // sdd.acondition-حقل معيار الشرط	context_afield_id  حقل يفلتر به-ManyToOne
                                // $this->execQuery("update ${server_db_prefix}sdd.acondition set context_afield_id='$id_replace' where context_afield_id='$id' ");


                                // MFK
                                // pag.atable-الحقول الثابتة في التعديل السريع	qfim_fields_mfk  
                                $this->execQuery("update ${server_db_prefix}pag.atable set qfim_fields_mfk=REPLACE(qfim_fields_mfk, ',$id,', ',$id_replace,') where qfim_fields_mfk like '%,$id,%' ");
                        }
                        return true;
                }
        }

        public function isSmallLookup()
        {
                $anstable = $this->het("anstable");

                if ($anstable) {
                        $expected_row_count = $anstable->getVal("exp_u_records");
                        $small = (($expected_row_count < 30) and ($anstable->getRowCount() < 30));
                        $tc = $anstable->tableCategory();

                        return (($tc == "enum") or ($tc == "lookup") or $small);
                }

                return null;
        }


        protected function getPublicMethods()
        {

                $pbms = array();

                $color = "red";
                $title_ar = "إنشاء الحقول المختصرة للكيان الجزئي";
                $pbms["xc123B"] = array(
                        "METHOD" => "createShortcutFieldsForOneToOneObject",
                        "COLOR" => $color,
                        "LABEL_AR" => $title_ar,
                        "ADMIN-ONLY" => true,
                        'MODE' => array("mode_scenario_item_id" => true),
                );

                /**/

                return $pbms;
        }


        public function createShortcutFieldsForOneToOneObject($lang = "ar")
        {

                $shortname = $this->getVal("shortname");

                if (!$shortname) $err_arr[] = "Error : please define shortname for this field";

                $anstable = $this->het("anstable");

                $info_arr = array();
                $err_arr = array();

                if (!$anstable) $err_arr[] = "Error : No Answer table for this field";


                $my_tab = $this->het("atable_id");

                if (!$my_tab) $err_arr[] = "Error : No owner table for this field";

                if ($anstable and $shortname) {
                        $shortcut_path = $shortname . ".";
                        $shortcut_prefix = $shortname . "_";

                        $scStep = $this->hetStep();
                        if ($scStep) $fromStep = $scStep->getVal("step_num");

                        if (!$fromStep) $fromStep = 1;

                        list($nbAddedSteps, $nbUpdatedSteps, $nbMovedSteps, $nbKeepedSteps) = $anstable->copyStepsToTable($my_tab, $fromStep);

                        //$nbUpdatedSteps = $nbAllSteps - $nbAddedSteps;

                        $info_arr[] = "Added $nbAddedSteps step(s), Updated $nbUpdatedSteps step(s), Moved $nbMovedSteps step(s), Keeped $nbKeepedSteps step(s)";


                        $anstable->copyFieldsToTableAsShortcuts($my_tab, $shortcut_path, $shortcut_prefix);
                }




                return array(implode("<br>\n", $err_arr), implode("<br>\n", $info_arr));
        }

        public function getParentObject()
        {
                return $this->het("atable_id");
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
                return (($attribute == "id_aut") or ($attribute == "date_aut") or ($attribute == "id_mod") or ($attribute == "date_mod")
                        or ($attribute == "id_valid") or ($attribute == "date_valid") or ($attribute == "version"));
        }

        protected function beforeSetAttribute($attribute, $newvalue)
        {
                $oldvalue = $this->getVal($attribute);
                if ($attribute == "titre_short") {
                        $old_titre_value = $this->getVal("titre");
                        if ($old_titre_value == $oldvalue) {
                                $this->set("titre", $newvalue);
                        }
                }

                return true;
        }

        public function getDefaultStep()
        {
                if ($this->isOk()) return 7;

                return 0;
        }

        public function getFieldGroupInfos($fgroup)
        {
                /*
           
           if($fgroup=="options") return array("name"=>$fgroup, "css"=>"pct30");
           if($fgroup=="bbooking") return array("name"=>$fgroup, "css"=>"pct100");
           */

                return array("name" => $fgroup, "css" => "pct_100 min_height_auto");
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        public function shouldBeCalculatedField($attribute)
        {
                if ($attribute == "atable_name_ar") return true;
                if ($attribute == "atable_name_en") return true;
                if ($attribute == "atable_name") return true;
                if ($attribute == "sql_field_type") return true;
                if ($attribute == "mask") return true;
                return false;
        }

        public function myShortNameToAttributeName($attribute)
        {
                if ($attribute == "name") return "field_name";
                if ($attribute == "table") return "atable_id";
                if ($attribute == "ftype") return "afield_type_id";
                if ($attribute == "title") return "titre_short_en";
                if ($attribute == "step") return "scenario_item_id";
                if ($attribute == "category") return "afield_category_id";
                if ($attribute == "anstable") return "answer_table_id";
                if ($attribute == "ertype") return "entity_relation_type_id";
                if ($attribute == "search") return "mode_search";
                if ($attribute == "qsearch") return "mode_qsearch";
                if ($attribute == "retrieve") return "mode_retrieve";
                if ($attribute == "audit") return "mode_audit";
                if ($attribute == "edit") return "mode_edit";
                if ($attribute == "qedit") return "mode_qedit";
                if ($attribute == "show") return "mode_show";
                if ($attribute == "myname") return "mode_name";
                if ($attribute == "char_group") return "char_group_men";
                if ($attribute == "php") return "php_att";
                return $attribute;
        }

        public static function addByCodes($object_code_arr, $object_name_en, $object_name_ar, $object_title_en, $object_title_ar, $update_if_exists = false)
        {
                if (count($object_code_arr) < 3) throw new AfwRuntimeException("addByCodes : 3 params are needed module and table and field name, given : " . var_export($object_code_arr, true));
                $module_code = $object_code_arr[2];
                $table_name = $object_code_arr[1];
                $field_name = $object_code_arr[0];

                list($afwType, $afwSize) = explode(".", strtoupper($object_code_arr[3]));

                if ($afwType) {
                        $structure = [];
                        $structure["SIZE"] = $afwSize;
                        $field_type = AfwUmsPagHelper::fromAFWtoAfieldType($afwType, "", $structure);
                } else $field_type = 0;


                AfwAutoLoader::addModule($module_code);

                if (!$module_code or !$table_name or !$field_name) throw new AfwRuntimeException("addByCodes : module and table name and field name are needed, given : module=$module_code and table=$table_name and field=$field_name , given array : " . var_export($object_code_arr, true));
                $objModule = Module::loadByMainIndex($module_code);
                if (!$objModule or (!$objModule->id)) throw new AfwRuntimeException("addByCodes : module $module_code not found");
                $objModule_id = $objModule->id;
                $objTable = Atable::loadByMainIndex($objModule_id, $table_name);
                if (!$objTable or (!$objTable->id)) throw new AfwRuntimeException("addByCodes : table $table_name not found in module  $module_code/$objModule_id");
                // $tableClass = AfwStringHelper::tableToClass($table_name);
                $objTable_id = $objTable->id;
                $afObj = Afield::loadByMainIndex($objTable_id, $field_name, true, true);

                if (!$afObj) $message = "Strange Error happened because Afield::loadByMainIndex($objTable_id, $field_name) failed !!";
                else {
                        if ((!$afObj->is_new) and (!$update_if_exists)) {
                                throw new AfwRuntimeException("This field already exists");
                        }
                        if ($field_type) $afObj->set("afield_type_id", $field_type);
                        $afObj->set("titre_short_en", $object_name_en);
                        $afObj->set("titre_short", $object_name_ar);
                        if ($object_title_en) $afObj->set("titre_en", $object_title_en);
                        if ($object_title_ar) $afObj->set("titre", $object_title_ar);
                        $afObj->commit();

                        $message = "successfully done";
                }


                return [$afObj, $message];
        }

        public static function reverseByCodes($object_code_arr, $doReverse=true)
        {
                if (count($object_code_arr) != 3) throw new AfwRuntimeException("reverseByCodes : 3 params are needed module and table and field name, given : " . var_export($object_code_arr, true));
                $module_code = $object_code_arr[2];
                $table_name = $object_code_arr[1];
                $field_name = $object_code_arr[0];

                if (!$module_code or !$table_name or !$field_name) throw new AfwRuntimeException("reverseByCodes : module and table field_name are needed, given : module=$module_code and table=$table_name and field=$field_name");
                $objModule = Module::loadByMainIndex($module_code);
                if (!$objModule or (!$objModule->id)) throw new AfwRuntimeException("reverseByCodes : module $module_code not found");
                $objModule_id = $objModule->id;
                $objTable = Atable::loadByMainIndex($objModule_id, $table_name);
                if (!$objTable or (!$objTable->id)) throw new AfwRuntimeException("reverseByCodes : table $table_name not found in module  $module_code/$objModule_id");
                $message = "";
                if($doReverse)
                {
                        $tableClass = AfwStringHelper::tableToClass($table_name);
                        AfwAutoLoader::addModule($module_code);
                        $objToPag = new $tableClass();
        
                        list($fld_i, $fld_u) = $objToPag->pagMe($sh = 3, $update_if_exists = true, $field_name);
                        $message .= "$fld_i fields inserted, $fld_u fields updated";
                }
                

                $objField = Afield::loadByMainIndex($objTable->id, $field_name);
                if($objField) $message .= " Field $field_name loaded successfully";
                else $message .= "Error Field $field_name load failed";

                return [$objField, $message];
        }

        public static function repareByCodes($object_code_arr, $restriction)
        {
                list($objField, $message) = self::reverseByCodes($object_code_arr, ($restriction=="reverse"));
                if($objField) 
                {
                        $cnt = $objField->repareMe('en');
                        $message .= "\n and $cnt attributes have been repared";
                }

                return [$objField, $message];
        }
}
