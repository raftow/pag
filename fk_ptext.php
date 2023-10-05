<?php
	$FK_CONSTRAINTS["comm"] = array(
			"id_ptext" => array("DEL-ACTION" => 'not-avail')
	); 
	$FK_CONSTRAINTS["ptext"] = array(
			"pdocument_id" => array("DEL-ACTION" => 'not-avail'),
			"parent_ptext_id" => array("DEL-ACTION" => 'not-avail'),
			"related_ptext_id" => array("DEL-ACTION" => 'not-avail')
	); 
?>