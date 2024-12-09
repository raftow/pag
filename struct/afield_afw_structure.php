<?php 
        class PagAfieldAfwStructure
        {
			// token separator = §
			public static function initInstance(&$obj)
                {
                        if ($obj instanceof Afield) 
                        {
                            $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
							$obj->CORRECT_IF_ERRORS = true;
							$obj->DISPLAY_FIELD = "titre_short";
							$obj->ORDER_BY_FIELDS = "atable_id, scenario_item_id, field_order, id";
							$obj->UNIQUE_KEY = array("atable_id","field_name");
							$obj->editByStep = true;
							$obj->editNbSteps = 8;
							$obj->showQeditErrors = true;
							$obj->showRetrieveErrors = true;
							$obj->nbQeditLinksByRow = 5;
							$obj->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
							$obj->OBJECT_CODE = "field_name";
							//$obj->qedit_minibox = true;    
                            // $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
                        }
                }
                public static $DB_STRUCTURE = array(

                        
			'id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'PK',  'FGROUP' => 'general_props',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_name' => array('IMPORTANT' => 'IN',  'SHORTNAME' => 'name',  'SHOW' => true,  'SEARCH' => true,  'RETRIEVE' => true,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 25,  'STYLE' => 'width:150px',  'FGROUP' => 'general_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  'ALL_FGROUP' => true,  'ALL-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'shortname' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => true,  'FGROUP' => 'general_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH' => true,  'RETRIEVE_FGROUP' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 15,  'GENERAL_PROPS-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'system_id' => array('SHOW' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'FGROUP' => 'general_props',  
				'WHERE' => "id_module_type in (4,7)", 
				 'READONLY' => true,  'SEARCH' => true,  'QSEARCH' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'parent_module_id' => array('SHOW' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'FGROUP' => 'general_props',  
				'WHERE' => "id_module_type=5", 
				 'EXCEL' => true,  'READONLY' => true,  'SEARCH' => true,  'QSEARCH' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'atable_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'ALL-RETRIEVE' => false,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',  'SIZE' => 40,  'DEFAUT' => 0,  'SHORTNAME' => 'table',  'FGROUP' => 'general_props',  'AUTOCOMPLETE' => true,  
				'WHERE' => "", 
				 
				'RELATION' => 'OneToMany',  'CONTEXT-ANSWER' => 'getContextTables',  'SEARCH' => true,  'SEARCH-BY-ONE' => true,  'QSEARCH' => true,  'AUTOCOMPLETE-SEARCH' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'atable_name_ar' => array('STEP' => 99,  
				'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  
				'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'atable_id.titre_short',  'UTF8' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'atable_name_en' => array('STEP' => 99,  
				'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  
				'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'atable_id.titre_short_en',  'UTF8' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'atable_name' => array('STEP' => 99,  
				'TYPE' => 'TEXT',  'SHOW' => true,  'ALL-RETRIEVE' => true,  'EXCEL' => true,  
				'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'atable_id.atable_name',  'UTF8' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'afield_type_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'QEDIT' => true,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'afield_type',  'ANSMODULE' => 'pag',  'SIZE' => 40,  'DEFAUT' => 0,  'STYLE' => 'width:150px',  'SHORTNAME' => 'ftype',  'FGROUP' => 'general_props',  'NO_KEEP_VAL' => true,  'LOAD_ALL' => true,  'NO-COTE' => true,  'SEARCH' => true,  'SEARCH-BY-ONE' => true,  'QSEARCH' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'sql_field_type' => array('STEP' => 99,  
				'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => true,  
				'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'afield_type_id.sql_field_type',  'UTF8' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'mask' => array('STEP' => 99,  
				'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => true,  
				'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'afield_type_id.mask',  'UTF8' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'answer_module_id' => array('SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => true,  'FGROUP' => 'general_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'EDIT' => true,  'SEARCH' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'MANDATORY' => true,  
				'WHERE' => "id_module_type=5 ", 
				 'SEARCH-BY-ONE' => true,  'QSEARCH' => false,  'DEFAUT' => 0,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'shortname_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'FGROUP' => 'general_props',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_short' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-AR' => true,  
				'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => true,  
				'EXCEL' => true,  'SIZE' => 40,  'SHORTNAME' => 'title',  
				'TYPE' => 'TEXT',  'FGROUP' => 'naming',  'EDIT_FGROUP' => true,  
				'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  'ALL_FGROUP' => true,  
				'DYNAMIC-HELP' => true,  'ALL-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50',
				),

			'titre_short_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-EN' => true,  
				'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 40,  'SHORTNAME' => 'title',  
				'TYPE' => 'TEXT',  'EXCEL' => false,  'FGROUP' => 'naming',  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50',
				),

			'titre' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-AR' => true,  
				'RETRIEVE-AR' => true,  'QEDIT' => false,  'EDIT' => true,  'UTF8' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',  'FGROUP' => 'naming',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50',
				),

			'titre_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH-EN' => true,  
				'RETRIEVE-EN' => true,  'QEDIT' => false,  'EDIT' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',  'FGROUP' => 'naming',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50',
				),

			'reel' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH' => true,  
				'QSEARCH' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'FGROUP' => 'step_group',  'EDIT_FGROUP' => true,  
				'QEDIT_FGROUP' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 3,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'scenario_item_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  
				'RETRIEVE' => false,  'EDIT' => true,  'RETRIEVE_FGROUP' => true,  'SIZE' => 40,  
				'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'scenario_item',  'ANSMODULE' => 'pag',  'SHORTNAME' => 'step',  
				'MANDATORY' => true,  'QEDIT' => false,  'FGROUP' => 'step_group',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'WHERE' => "atable_id = §atable_id§", 
				 'BUTTONS' => true,  'DEFAUT' => 0,  'STEP_GROUP-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'afield_group_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'RETRIEVE_FGROUP' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'afield_group',  'ANSMODULE' => 'pag',  'QEDIT' => false,  'FGROUP' => 'step_group',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'WHERE' => "atable_id = §atable_id§", 
				 'DEFAUT' => 0,  'STEP_GROUP-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'afield_category_id' => array('STEP' => 2,  'SHORTNAME' => 'category',  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'RETRIEVE_FGROUP' => true,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'MANDATORY' => true,  'UTF8' => false,  'FGROUP' => 'answer_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'afield_category',  'ANSMODULE' => 'pag',  
				'RELATION' => 'ManyToOne',  'READONLY' => false,  'ANSWER_PROPS-RETRIEVE' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'answer_table_id' => array('SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => false,  'EDIT' => true,  'RETRIEVE_FGROUP' => true,  'FGROUP' => 'answer_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'MANDATORY' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',  'SIZE' => 40,  'DEFAUT' => 0,  'SHORTNAME' => 'anstable',  'STEP' => 2,  
				'WHERE' => "id_module=§answer_module_id§ and avail='Y'", 'WHERE-SEARCH' => "id_module=§answer_module_id§ and avail='Y'", 
				 'AT_METHOD' => 'getAnswerTables',  'SEARCH-BY-ONE' => true,  'AUTOCOMPLETE-SEARCH' => true,  'QSEARCH' => false,  
				'RELATION' => 'OneToMany',  'ANSWER_PROPS-RETRIEVE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'entity_relation_type_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'RETRIEVE_FGROUP' => true,  'QEDIT' => false,  'FGROUP' => 'answer_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'DYNAMIC-HELP' => true,  'SHORTNAME' => 'ertype',  'STEP' => 2,  
				'TYPE' => 'FK',  'ANSWER' => 'entity_relation_type',  'ANSMODULE' => 'pag',  'DEFAUT' => 0,  
				'WHERE' => "'§afield_type_id§' in ('','0','5')", 
				 'NO_KEEP_VAL' => true,  'LOAD_ALL' => true,  'ANSWER_PROPS-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'specification' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'FGROUP' => 'answer_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  
				'CSS' => 'width_pct_100',  'SIZE' => 80,  
				'TYPE' => 'TEXT',  'INPUT-FORMATTING' => 'value-1-cote',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

		'entity_relation_type_id_help' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'FOR_HELP' => true,  'FGROUP' => 'answer_props',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'fk_table_single' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'fk_table_plural' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'fld_table_single' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'fld_table_plural' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_where' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'CSS' => 'width_pct_100',  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'FGROUP' => 'advanced_props',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

			'field_format' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'CSS' => 'width_pct_100',  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'FGROUP' => 'advanced_props',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

			'utf8' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'SEARCH' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'FGROUP' => 'advanced_props',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'default_value_utf8' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 255,  'MANDATORY' => false,  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'default_value' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'SIZE' => 255,  'MANDATORY' => false,  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'unit' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'SIZE' => 25,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'unit_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'SIZE' => 25,  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'title_after' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'title_after_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'help_text' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SIZE' => 80,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'help_text_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => false,  'QEDIT_FGROUP' => true,  'SIZE' => 80,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'question_text' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SIZE' => 80,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'question_text_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'UTF8' => false,  'FGROUP' => 'other_props',  'EDIT_FGROUP' => false,  'QEDIT_FGROUP' => true,  'SIZE' => 80,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'distinct_for_list' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  
				'TYPE' => 'YN',  'FGROUP' => 'other_props',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'mode_search' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'MANDATORY' => true,  'FGROUP' => 'modes_list',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'search',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_qsearch' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'W',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'qsearch',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_retrieve' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'W',  'MANDATORY' => true,  'FGROUP' => 'modes_list',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'retrieve',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_audit' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'audit',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_edit' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'edit',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_edit_admin' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'CHECKBOX' => true,  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_qedit' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'qedit',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_qedit_admin' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'CHECKBOX' => true,  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_show' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'show',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'mode_name' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'FGROUP' => 'modes_list',  'MANDATORY' => true,  'DEFAUT' => 'N',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => false,  'CHECKBOX' => true,  'RETRIEVE_FGROUP' => true,  'STEP' => 4,  'SHORTNAME' => 'myname',  'MODES_LIST-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

		'answerclass' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'java_name' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'ugroup_mfk' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'MFK',  'ANSWER' => 'ugroup',  'ANSMODULE' => 'ums',  'FGROUP' => 'advanced_props',  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'foption_mfk' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'FGROUP' => 'advanced_props',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'RETRIEVE_FGROUP' => true,  'SIZE' => 32,  'MEDIUM_DROPDOWN_WIDTH' => true,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  
				'TYPE' => 'MFK',  'ANSWER' => 'foption',  'ANSMODULE' => 'pag',  
				'WHERE' => "(afield_type_mfk like '%,§afield_type_id§,%' or afield_type_mfk='' or afield_type_mfk is null)", 
				 'STEP' => 6,  'ADVANCED_PROPS-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'afieldOptionValueList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'afield_option_value',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'afield_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'QEDIT' => false,  'EDIT' => true,  'READONLY' => true,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_order' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  
				'TYPE' => 'INT',  'FGROUP' => 'advanced_props',  'MANDATORY' => true,  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'field_num' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'INT',  'FGROUP' => 'advanced_props',  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'need_validation' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'advanced_props',  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'avail' => array('SHOW' => true,  'RETRIEVE' => true,  'EXCEL' => false,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => true,  'QSEARCH' => true,  'DEFAUT' => 'Y',  
				'TYPE' => 'YN',  'FGROUP' => 'technical_info',  'STEP' => 6,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 'Y', 
				),

		'afieldRuleList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'afield_rule',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'afield_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'QEDIT' => false,  'READONLY' => true,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'NO-LABEL' => false,  'FGROUP' => 'afieldRuleList',  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'afieldDependencyList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'afield_rule',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'afield_id',  
				'WHERE' => "afield_rule_type_id = 1", 
				 'FORMAT' => 'retrieve',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'dependencyList' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'PHP_FORMULA' => 'list_extract.afieldDependencyList.related_afield_id.',  'FGROUP' => 'afieldRuleList',  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'afieldDependentList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'afield_rule',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'related_afield_id',  'QEDIT' => false,  
				'WHERE' => "afield_rule_type_id = 1", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'READONLY' => true,  'NO-LABEL' => false,  'FGROUP' => 'afieldRuleList',  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'dependentList' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'PHP_FORMULA' => 'list_extract.afieldDependentList.afield_id.',  'FGROUP' => 'afieldRuleList',  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_size' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE_FGROUP' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'INT',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'STEP' => 7,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_width' => array('STEP' => 7,  'SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'SIZE' => 32,  'UTF8' => false,  
				'TYPE' => 'INT',  'READONLY' => false,  'SEARCH-BY-ONE' => false,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'field_min_size' => array('SEARCH' => false,  'SHOW' => true,  'RETRIEVE_FGROUP' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'MANDATORY' => true,  'UTF8' => false,  
				'TYPE' => 'INT',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'DEFAUT' => 1,  'STEP' => 7,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,  'DEFAUT' => 1, 
				),

			'char_group_men' => array('SHORTNAME' => 'char_group',  'SEARCH' => false,  'RETRIEVE_FGROUP' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'MANDATORY' => false,  'UTF8' => false,  
				'TYPE' => 'MENUM',  'ANSWER' => 'FUNCTION',  'DEFAUT' => ',1,7,',  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'STEP' => 7,  'ANSMODULE' => 'pag',  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => ',1,7,', 
				),

			'mandatory' => array('SHOW' => true,  'RETRIEVE_FGROUP' => true,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'W',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  
				'STEP' => 7,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'applicable' => array('STEP' => 7,  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'RETRIEVE_FGROUP' => true,  'EDIT' => true,  'QEDIT' => false,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'SIZE' => 32,  'UTF8' => false,  
				'TYPE' => 'YN',  'CHECKBOX' => true,  'READONLY' => false,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => false,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'readonly' => array('SHOW' => true,  'RETRIEVE_FGROUP' => true,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'MANDATORY' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'field_rules',  'STEP' => 7,  'FIELD_RULES-RETRIEVE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'additional' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'generation',  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'sql' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'RETRIEVE' => false,  'PRE' => true,  
				'CSS' => 'width_pct_100',  'TEXT-ALIGN' => 'left',  'FGROUP' => 'generation',  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

		'php_att' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'RETRIEVE' => false,  'PRE' => true,  
				'CSS' => 'width_pct_100',  'SHORTNAME' => 'php',  'TEXT-ALIGN' => 'left',  'FGROUP' => 'generation',  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

			'sql_gen' => array('IMPORTANT' => 'IN',  'SHOW' => false,  'RETRIEVE' => false,  'RETRIEVE-ADMIN' => false,  'QEDIT' => false,  'EDIT' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'generation',  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

                        'id_aut'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'date_aut'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        'id_mod'           => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'date_mod'              => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        'id_valid'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'date_valid'          => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        /* 'avail'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

                        'version'                  => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),

                        // 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

                        'update_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'delete_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'display_groups_mfk'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'sci_id'                        => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>