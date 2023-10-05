<?php
	$FK_CONSTRAINTS["atable"] = array(
			"id_module" => array("DEL-ACTION" => 'not-allow')
	); 
	$FK_CONSTRAINTS["gfield"] = array(
			"parent_module_id" => array("DEL-ACTION" => 'not-allow'),
			"module_id" => array("DEL-ACTION" => 'not-allow')
	); 
	$FK_CONSTRAINTS["module"] = array(
			"id_module_parent" => array("DEL-ACTION" => 'not-avail')
	); 
	$FK_CONSTRAINTS["module_sh"] = array(
			"id_module" => array("DEL-ACTION" => 'not-allow')
	); 
	$FK_CONSTRAINTS["ptext"] = array(
			"module_id" => array("DEL-ACTION" => 'not-allow')
	); 
?>