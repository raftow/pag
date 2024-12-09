<?php
class PagAtableAfwStructure
{

	public static function initInstance(&$obj)
	{
		if ($obj instanceof Atable) 
		{
			$obj->CACHE_SCOPE = "server";
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
			$obj->ORDER_BY_FIELDS = "id_module, atable_name";
			$obj->UNIQUE_KEY = array("id_module","atable_name");
			$obj->DISPLAY_FIELD = "atable_name";
			$obj->AUTOCOMPLETE_FIELD = "concat(IF(ISNULL(atable_name), '', atable_name) , '/' , IF(ISNULL(titre_short), '', titre_short) , '/' , IF(ISNULL(titre_u), '', titre_u))"; 
			$obj->copypast = false;
			$obj->editByStep = true;
			$obj->editNbSteps = 9;
			$obj->showRetrieveErrors = true;
			$obj->showQeditErrors = true;
			//$obj->general_check_errors = true;
			//deprecated
			//$obj->hzm_vtab_body_height = "1030px";
			$obj->qedit_minibox = false;
			$obj->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
			
			$obj->styleStep[6] = array("width"=>"88%");
			/*$obj->after_save_edit = array("class"=>'Module',"attribute"=>'id_module', "currmod"=>'ums',"currstep"=>8);*/
		}
	}
		
	
	public static $DB_STRUCTURE = array(


		'id' => array(
			'TYPE' => 'PK',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => false,  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'system_id' => array(
			'SHOW' => true,  'SEARCH' => true,
			'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',
			'WHERE' => "id_module_type in (4,7)",

			'CATEGORY' => 'FORMULA',  'FORMULA_MODULE' => 'pag',  'SHORTNAME' => 'sys',  'SEARCH-BY-ONE' => true,  'CAN-BE-SETTED' => true,  'DIRECT_ACCESS' => true,
			'DEPENDENT_OFME' => array(0 => 'id_module', 1 => 'id_sub_module',),
			'FGROUP' => 'step1',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'id_domain' => array(
			'STEP' => 99,
			'TYPE' => 'FK',  'ANSWER' => 'domain',  'SHOW' => true,
			'CATEGORY' => 'SHORTCUT',  'SHORTCUT' => 'id_module.id_pm',  'SHORTNAME' => 'domain',  'ANSMODULE' => 'pag',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'id_module' => array(
			'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,
			'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',
			'WHERE' => "id_module_type=5",

			'WHERE-SEARCH' => "id_module_type=5",
			'QEDIT' => true,  'SHORTNAME' => 'module',  'SEARCH-BY-ONE' => true,
			'DEPENDENT_OFME' => array(0 => 'id_sub_module',),  'DEPENDENCY' => 'system_id',  'FGROUP' => 'step1',
			'RELATION' => 'OneToMany',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'real_table' => array(
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => true,  'DEFAUT' => 'Y',  'SHORTNAME' => 'original',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'atable_name' => array(
			'TYPE' => 'TEXT',  'SHORTNAME' => 'name',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'SIZE' => 32,  'QEDIT' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'QEDIT_ALL_FGROUP' => true,  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'is_lookup' => array(
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => true,  'DEFAUT' => 'N',  'SHORTNAME' => 'lookup',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'is_entity' => array(
			'SHORTNAME' => 'entity',
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => false,  'DEFAUT' => 'Y',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'avail' => array(
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'DEFAUT' => 'Y',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'class_name' => array(
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'is_enum' => array(
			'SHORTNAME' => 'enum',
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'SEARCH' => true,
			'CATEGORY' => 'FORMULA',  'FIELD-FORMULA' => 'fnIsEnum(is_entity,is_lookup)',  'FORMULA_MODULE' => 'pag',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'is_detail' => array(
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'SEARCH' => false,
			'CATEGORY' => 'FORMULA',  'SHORTNAME' => 'detail',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'categ' => array(
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'READONLY' => true,  'RETRIEVE' => true,  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_short' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => true,  'UTF8' => true,  'SIZE' => 48,  'SHORTNAME' => 'pluraltitle',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_short_s' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => true,  'UTF8' => true,  'SIZE' => 48,  'SHORTNAME' => 'pluraltitleshort',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_u' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'QEDIT_ALL_FGROUP' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH' => true,  'UTF8' => true,  'SIZE' => 48,  'SHORTNAME' => 'singletitle',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_u_s' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'QEDIT_ALL_FGROUP' => true,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'SEARCH' => true,  'UTF8' => true,  'SIZE' => 48,  'SHORTNAME' => 'singletitleshort',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => true,
			'SIZE' => 'AREA',  'SHORTNAME' => 'description',  'FGROUP' => 'step1',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_short_en' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE-EN' => true,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => true,  'SIZE' => 40,  'SHORTNAME' => 'pluraltitle_en',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_u_en' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE-EN' => false,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => true,  'SIZE' => 64,  'SHORTNAME' => 'singletitle_en',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'titre_en' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE-EN' => false,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => false,
			'SIZE' => 'AREA',  'SHORTNAME' => 'description_en',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'tboption_mfk' => array(
			'STEP' => 1,  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 255,  'MANDATORY' => true,  'UTF8' => false,
			'TYPE' => 'MFK',  'ANSWER' => 'tboption',  'ANSMODULE' => 'pag',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),

		'auditable' => array(
			'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'DEFAUT' => 'N',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'id_sub_module' => array(
			'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,
			'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'submodule',
			'WHERE' => "((id_module_parent = §id_module§) and (id_module_type in (6))) and id_system in (select id_system from §DBPREFIX§ums.module where id = §id_module§)  ",
			'QEDIT' => true,  'SEARCH-BY-ONE' => true,  'DEPENDENCY' => 'id_module',
			'RELATION' => 'OneToMany',  'STEP' => 2,  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'abrev' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => false,  'EDIT' => true,  'SEARCH' => false,  'SIZE' => 10,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'vh' => array(
			'SHORTNAME' => 'icon',
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => false,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		

		'look_from_field_id' => array(
			'TYPE' => 'FK',  'ANSWER' => 'afield',  'SHOW' => false,  'FORMAT' => '',  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'SEARCH' => false,
			'WHERE' => "atable_id = §id§ and afield_type_id = 5 and avail = 'Y'",
			'FGROUP' => 'index',  'ANSMODULE' => 'pag',  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'key_field' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => false,  'DEFAUT' => 'id',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'display_field' => array(
			'TYPE' => 'TEXT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'MANDATORY' => false,  'DEFAUT' => '',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'sql_gen' => array(
			'IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,
			'TYPE' => 'YN',  'QEDIT' => false,  'DEFAUT' => 'N',  'SEARCH' => false,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'id_auto_increment' => array(
			'IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,
			'TYPE' => 'YN',  'QEDIT' => false,  'DEFAUT' => 'Y',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'utf8' => array(
			'IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,
			'TYPE' => 'YN',  'QEDIT' => false,  'DEFAUT' => 'Y',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'partition_function' => array(
			'IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,
			'TYPE' => 'TEXT',  'QEDIT' => false,  'SEARCH' => false,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'dbengine_id' => array(
			'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,
			'TYPE' => 'FK',  'QEDIT' => false,  'ANSWER' => 'dbengine',  'ANSMODULE' => 'pag',
			'WHERE' => "",
			'DEFAUT' => 2,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'entity_name' => array(
			'TYPE' => 'TEXT',  'SHOW' => false,  'RETRIEVE' => false,  'EDIT' => false,  'SIZE' => 64,  'QEDIT' => false,  'SEARCH' => false,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'entity_name2' => array(
			'TYPE' => 'TEXT',  'SHOW' => false,  'RETRIEVE' => false,  'EDIT' => false,  'SIZE' => 64,  'QEDIT' => false,  'SEARCH' => false,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'fieldcount' => array(
			'TYPE' => 'INT',
			'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => true,
			'LINK-URL' => 'main.php?Main_Page=afw_mode_qedit.php&cl=Afield&currmod=pag&newo=7&limit=100&ids=all&fixmtit=حقول الجدول §titre_short§ - §atable_name§ &fixmdisable=1&fixm=atable_id=§id§&sel_atable_id=§id§&comfld=1',
			'LINK-CSS' => 'nice_link',  'FGROUP' => 'stats',  'STEP' => 9,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'origFieldList' => array(
			'TYPE' => 'FK',  'SHORTNAME' => 'original_fields',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "additional='N' and reel='Y' and avail='Y'",

			'RETRIEVE_GROUPS' => array(
				0 => 'display',
				1 => 'modes_list',
				2 => 'field_rules',
				3 => 'step_group',
				4 => 'answer_props',
				5 => 'other_props',
				6 => 'general_props',
			),  
			
			'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => true, 'READONLY'=>true,  'STEP' => 4,  'ICONS' => true,
			'DELETE-ICON' => true,  'BUTTONS' => true,  'FGROUP' => 'origFieldList',
			'NO-LABEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'FGROUP_BEHAVIOR' => 'collapsed',
		),

		'auditFieldList' => array(
			'TYPE' => 'FK',  'SHORTNAME' => 'audit_fields',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "additional='N' and reel='Y' and avail='Y' and mode_audit='Y'",

			'RETRIEVE_GROUPS' => array(
				0 => 'display',
				1 => 'modes_list',
				2 => 'field_rules',
				3 => 'step_group',
				4 => 'answer_props',
				5 => 'other_props',
				6 => 'general_props',
			),  
			'SHOW' => true,  'FORMAT' => 'retrieve', 'EDIT' => true, 'READONLY'=>true,  'STEP' => 9,  'ICONS' => true,  'DELETE-ICON' => true,
			'BUTTONS' => true,  'FGROUP' => 'auditFieldList', 'FGROUP_BEHAVIOR' => 'collapsed',
			'NO-LABEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		

		'indexFieldList' => array(
			'TYPE' => 'FK',  'SHORTNAME' => 'index_fields',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "additional='N' and reel='Y' and avail='Y' and distinct_for_list='Y'",

			'RETRIEVE_GROUPS' => array(
				0 => 'display',
				1 => 'modes_list',
				2 => 'field_rules',
				3 => 'step_group',
				4 => 'answer_props',
				5 => 'other_props',
				6 => 'general_props',
			),  
			'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => true, 'READONLY'=>true,  'STEP' => 9,  
			'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,
			'FGROUP' => 'indexFieldList', 'FGROUP_BEHAVIOR' => 'collapsed',
			'NO-LABEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		

		'nameFieldList' => array(
			'TYPE' => 'FK',  'SHORTNAME' => 'name_fields',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "mode_name='Y' and avail='Y'",

			'RETRIEVE_GROUPS' => array(
				0 => 'display',
				1 => 'modes_list',
				2 => 'field_rules',
				3 => 'step_group',
				4 => 'answer_props',
				5 => 'other_props',
				6 => 'general_props',
			),
			'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => true, 'READONLY'=>true,  'STEP' => 9,
			'REQUIRED' => true,  'ICONS' => true,  'DELETE-ICON' => true,
			'BUTTONS' => true,  'FGROUP' => 'nameFieldList', 'FGROUP_BEHAVIOR' => 'collapsed',
			'NO-LABEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'MANDATORY' => true,  'ERROR-CHECK' => true,
		),

		

		'virtFieldList' => array(
			'TYPE' => 'FK',  'SHORTNAME' => 'virtual_fields',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "additional='N' and reel='N' and avail='Y'",

			'RETRIEVE_GROUPS' => array(
				0 => 'display',
				1 => 'modes_list',
				2 => 'field_rules',
				3 => 'step_group',
				4 => 'answer_props',
				5 => 'other_props',
				6 => 'general_props',
			),  'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'STEP' => 9,
			'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,
			'FGROUP' => 'virtFieldList', 'FGROUP_BEHAVIOR' => 'collapsed',  'NO-LABEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		

		'addiFieldList' => array(
			'TYPE' => 'FK',  'SHORTNAME' => 'additional_fields',  'ANSWER' => 'afield',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "additional='Y' and avail='Y'",

			'RETRIEVE_GROUPS' => array(
				0 => 'display',
				1 => 'modes_list',
				2 => 'field_rules',
				3 => 'step_group',
				4 => 'answer_props',
				5 => 'other_props',
				6 => 'general_props',
			),  'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'STEP' => 9,  'ICONS' => true,
			'DELETE-ICON' => true,  'BUTTONS' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'FGROUP' => 'addiFieldList', 'FGROUP_BEHAVIOR' => 'collapsed',  'NO-LABEL' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'jobrole_id' => array(
			'IMPORTANT' => 'IN',  'SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => 'temporaire',  
			'EDIT' => true,  'QEDIT' => false,  'SIZE' => 40,  'UTF8' => false,
			'TYPE' => 'FK',  'ANSWER' => 'jobrole',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'emjob',  
			'MANDATORY' => false,  'POLE' => true,
			'WHERE' => "(id = 53 or id_domain in (1,§id_domain§))",
			'DEFAUT' => 0,  'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'roles_def',  
			'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),
		
		'goalConcernList1' => array(
			'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'bau',
			'CATEGORY' => 'ITEMS',  'ITEM' => '',  'FORMAT' => 'retrieve',
			'WHERE' => "application_id=§id_module§ and atable_mfk like '%,§id§,%' and operation_men like '%,1,%'",
			'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  
			'NO-LABEL' => false,  'MANDATORY' => true,  'FGROUP' => 'roles_def',  'STEP' => 5,  
			'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),

		'goalConcernList2' => array(
			'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'bau',
			'CATEGORY' => 'ITEMS',  'ITEM' => '',  'FORMAT' => 'retrieve',
			'WHERE' => "application_id=§id_module§ and atable_mfk like '%,§id§,%' and operation_men like '%,2,%'",
			'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  
			'NO-LABEL' => false,  'MANDATORY' => true,  'FGROUP' => 'roles_def',  'STEP' => 5,  
			'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),

		'goalConcernList3' => array(
			'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'bau',
			'CATEGORY' => 'ITEMS',  'ITEM' => '',  'FORMAT' => 'retrieve',
			'WHERE' => "application_id=§id_module§ and atable_mfk like '%,§id§,%' and operation_men like '%,3,%'",
			'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  
			'NO-LABEL' => false,  'MANDATORY' => true,  'FGROUP' => 'roles_def',  'STEP' => 5,  
			'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),

		'goalConcernList4' => array(
			'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'bau',
			'CATEGORY' => 'ITEMS',  'ITEM' => '',  'FORMAT' => 'retrieve',
			'WHERE' => "application_id=§id_module§ and atable_mfk like '%,§id§,%' and operation_men like '%,4,%'",
			'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  
			'NO-LABEL' => false,  'MANDATORY' => false,  'FGROUP' => 'roles_def',  'STEP' => 5,  
			'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'goalConcernList5' => array(
			'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'bau',
			'CATEGORY' => 'ITEMS',  'ITEM' => '',  'FORMAT' => 'retrieve',
			'WHERE' => "application_id=§id_module§ and atable_mfk like '%,§id§,%' and operation_men like '%,5,%'",
			'SHOW' => true,  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  
			'NO-LABEL' => false,  'MANDATORY' => false,  'FGROUP' => 'roles_def',  'STEP' => 5,  
			'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'master' => array(
			'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'lookupValueList' => array(
			'TYPE' => 'FK',  'ANSWER' => 'lookup_value',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "",
			'SHOW' => true,  'FORMAT' => 'retrieve',  'ICONS' => true,  'DELETE-ICON' => true,  'QEDIT' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 5,  'FGROUP' => 'lookupValueList',  'EDIT' => true,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'data_auser_mfk' => array(
			'TYPE' => 'MFK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',  'SHOW' => true,
			'FORMAT' => 'retrieve',  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,
			'WHERE' => "1=0",  // until we filter to avoid toomuch records in MFK field (no-autocomplete for MFK)
			'STEP' => 5,  'SEARCH-BY-ONE' => '',  'AUTOCOMPLETE' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'max_period' => array(
			'TYPE' => 'INT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => false,  'DEFAUT' => 80,  'SHORTNAME' => 'maxper',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'exp_period' => array(
			'TYPE' => 'INT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => false,  'DEFAUT' => 60,  'SHORTNAME' => 'expper',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'min_u_records' => array(
			'TYPE' => 'INT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SEARCH' => false,  'DEFAUT' => 0,  'SHORTNAME' => 'minrows',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'exp_u_records' => array(
			'TYPE' => 'INT',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SEARCH' => false,  'DEFAUT' => 0,  'SHORTNAME' => 'exprows',  'MANDATORY' => true,  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),

		'bfunctionList' => array(
			'TYPE' => 'FK',  'ANSWER' => 'bfunction',  'ANSMODULE' => 'ums',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'curr_class_atable_id',
			'WHERE' => "",
			'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => true,  'STEP' => 6,  'FGROUP' => 'bfunctionList',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'scis' => array(
			'TYPE' => 'FK',  'ANSWER' => 'scenario_item',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "",
			'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  'NO-LABEL' => true,  'STEP' => 6,  'BUTTONS' => true,  'FGROUP' => 'scis',  'ANSMODULE' => 'pag',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'afieldGroupList' => array(
			'TYPE' => 'FK',  'ANSWER' => 'afield_group',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'ITEMS',  'ITEM' => 'atable_id',
			'WHERE' => "",
			'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => true,  'STEP' => 6,  'FGROUP' => 'afieldGroupList',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'rowcount' => array(
			'TYPE' => 'INT',
			'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'anst' => array(
			'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'FORMULA',  'FORMAT' => 'RETRIEVE',  'INPUT_WIDE' => true,  'SHOW' => true,  'ROLES' => '',  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'RETRIEVE' => false,  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'ext_anst' => array(
			'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'FORMULA',  'FORMAT' => 'RETRIEVE',  'INPUT_WIDE' => true,  'SHOW' => true,  'ROLES' => '',  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'RETRIEVE' => false,  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'tome' => array(
			'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'FORMULA',  'FORMAT' => 'RETRIEVE',  'INPUT_WIDE' => true,  'SHOW' => true,  'ROLES' => '',  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'RETRIEVE' => false,  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'ext_tome' => array(
			'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',
			'CATEGORY' => 'FORMULA',  'FORMAT' => 'RETRIEVE',  'INPUT_WIDE' => true,  'SHOW' => true,  'ROLES' => '',  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'RETRIEVE' => false,  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'advise' => array(
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'SEARCH-RETRIEVE' => false,  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'concernedGoalList' => array(
			'TYPE' => 'MFK',  'ANSWER' => 'goal',  'ANSMODULE' => 'bau',
			'CATEGORY' => 'FORMULA',  'COLSPAN' => 4,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'MANDATORY' => true,  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,
		),

		'mainGoal' => array(
			'SHOW' => true,  'SIZE' => 40,
			'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'bau',  'NO-ERROR-CHECK' => true,
			'CATEGORY' => 'FORMULA',  'DEFAUT' => 0,  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',
		),

		'id_aut'         => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'
		),

		'date_aut'            => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'
		),

		'id_mod'           => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'
		),

		'date_mod'              => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'
		),

		'id_valid'       => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'
		),

		'date_valid'          => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false,
			'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'
		),

		/* 'avail'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

		'version'                  => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'
		),

		// 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
		//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

		'update_groups_mfk'             => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'
		),

		'delete_groups_mfk'             => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'
		),

		'display_groups_mfk'            => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false,
			'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'
		),

		'sci_id'                        => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false,
			'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'
		),

		'tech_notes' 	                => array(
			'STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true,
			'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'
		),
	);
}
