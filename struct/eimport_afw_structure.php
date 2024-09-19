<?php 
        class PagEimportAfwStructure
        {
                public static $DB_STRUCTURE = array(

                        
			'id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'PK',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'orgunit_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => false,  'EDIT' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  'DEFAUT' => 0,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'atable_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 40,  
				'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',  
				'WHERE' => "avail='Y' and tboption_mfk like '%,1,%'", 
				 'DEFAUT' => 0,  'AUTOCOMPLETE' => false,  'SEARCH-BY-ONE' => true,  'SHORTNAME' => 'table',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'overwrite_data' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'skip_error' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'always_commit' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'afile_id' => array('IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'afile',  
				'WHERE' => "(stakeholder_id=§orgunit_id§ or owner_id=§ME§) and doc_type_id in (14)", 
				 'DEFAUT' => 0,  'ANSMODULE' => 'pag',  'SHOW-AS-ROW' => true,  'MANDATORY' => true,  'SHORTNAME' => 'file',  'DISPLAY' => 'SHOW',  'STYLE' => 'width: 197px !important;   height: 240px !important;',  'PILLAR-PART' => true,  'SEARCH-BY-ONE' => '',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'curr_page' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'UTF8' => false,  
				'TYPE' => 'INT',  'READONLY' => false,  'DEFAUT' => 1,  'SEARCH-BY-ONE' => false,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'preview' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'STEP' => 2,  'READONLY' => true,  'FORM_HEIGHT' => '600px',  'SIZE' => 255,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'option_mfk' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'SHORTNAME' => 'options',  
				'TYPE' => 'MFK',  'ANSWER' => 'several_option',  'ANSMODULE' => 'pag',  
				'WHERE' => "(atable_id=§atable_id§ or atable_id=0 or atable_id is null) and option_table_id = 3604", 
				 'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'analysis' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'STEP' => 3,  'READONLY' => true,  'FORM_HEIGHT' => '200px',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'date_format' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'STEP' => 3,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'hdate_format' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'STEP' => 3,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'lang' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'STEP' => 3,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'UTF8' => true,  'SIZE' => 255,  
				'TYPE' => 'TEXT',  'TITLE_AFTER' => '',  'HELP' => 'next step will be the import execution',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'executed' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'STEP' => 4,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'succeeded' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'STEP' => 4,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'exec_date' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'STEP' => 4,  'READONLY' => true,  
				'TYPE' => 'DATE',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'exec_start_time' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
				'TYPE' => 'TIME',  'STEP' => 4,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'exec_end_time' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  
				'TYPE' => 'TIME',  'STEP' => 4,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'result' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'STEP' => 4,  'READONLY' => true,  'FORM_HEIGHT' => '500px',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'records_processed' => array(
				'CATEGORY' => 'FORMULA',  'EDIT' => true,  'SHOW' => true,  'RETRIEVE' => true,  'READONLY' => true,  
				'TYPE' => 'INT',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'records_updated' => array(
				'CATEGORY' => 'FORMULA',  'EDIT' => true,  'SHOW' => true,  'RETRIEVE' => true,  'READONLY' => true,  
				'TYPE' => 'INT',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'records_new' => array(
				'CATEGORY' => 'FORMULA',  'EDIT' => true,  'SHOW' => true,  'RETRIEVE' => true,  'READONLY' => true,  
				'TYPE' => 'INT',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'records_erroned' => array(
				'CATEGORY' => 'FORMULA',  'EDIT' => true,  'SHOW' => true,  'RETRIEVE' => true,  'READONLY' => true,  
				'TYPE' => 'INT',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'records' => array(
				'TYPE' => 'FK',  'ANSWER' => 'eimport_record',  'ANSMODULE' => 'pag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'eimport_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => true,  'READONLY' => true,  'DATA_TABLE' => 'eimport_records',  'FORM_HEIGHT' => '900px',  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => true,  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'avail' => array('IMPORTANT' => 'IN',  'SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  'DEFAUT' => 'Y',  'EDIT-ADMIN' => true,  
				'TYPE' => 'YN',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '',  'STEP' => 1,  
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