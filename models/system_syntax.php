<?php
// ------------------------------------------------------------------------------------
// UPDATE `system_syntax` SET `value_syntax` = 'CREATE TABLE IF NOT EXISTS [DB_NAME].`[TABLE_NAME]` (\r\n `id` int(11) NOT NULL AUTO_INCREMENT,\r\n `[FLD_CREATION_USER_ID]` int(11) NOT NULL,\r\n `[FLD_CREATION_DATE]` datetime NOT NULL,\r\n `[FLD_UPDATE_USER_ID]` int(11) NOT NULL,\r\n `[FLD_UPDATE_DATE]` datetime NOT NULL,\r\n `[FLD_VALIDATION_USER_ID]` int(11) DEFAULT NULL,\r\n `[FLD_VALIDATION_DATE]` datetime DEFAULT NULL,\r\n `[FLD_ACTIVE]` char(1) NOT NULL,\r\n `draft` char(1) NOT NULL default \'Y\' ,\r\n `[FLD_VERSION]` int(4) DEFAULT NULL,\r\n `update_groups_mfk` varchar(255) DEFAULT NULL,\r\n `delete_groups_mfk` varchar(255) DEFAULT NULL,\r\n `display_groups_mfk` varchar(255) DEFAULT NULL,\r\n `sci_id` int(11) DEFAULT NULL,\r\n \r\n [LOOKUP_CODE_COL] \r\n[COLUMNS]\r\n \r\n PRIMARY KEY (`id`)\r\n) ENGINE=[ENGINE_CODE] DEFAULT [TABLE_CHARSET] [TABLE_AUTOINC_AFTER];' WHERE `system_syntax`.`id` = 7;
// ------------------------------------------------------------------------------------


$file_dir_name = dirname(__FILE__);

// old include of afw.php

class SystemSyntax extends AFWObject
{

        public static $DATABASE                = "";
        public static $MODULE                    = "pag";
        public static $TABLE                        = "";
        public static $DB_STRUCTURE = null;
        public function __construct()
        {
                parent::__construct("system_syntax", "id", "pag");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "code_syntax";
                $this->ORDER_BY_FIELDS = "code_syntax";
        }
}
