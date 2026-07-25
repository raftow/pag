<?php
    // ALTER TABLE `afield` CHANGE `field_name` `field_name` varchar(64) COLLATE 'latin1_swedish_ci' NOT NULL AFTER `shortname_en`;
    // ALTER TABLE `afield` CHANGE `field_size` `field_size` int NULL AFTER `field_name`;
    // alter table tvtc_pag.domain rename to tvtc_cmn.domain;

    /*
insert into  nauss_pag.afield_type me 
SET id = '18',
    id_aut = 1, 
    date_aut = '2026-06-26 13:17:05', 
    `version` = 1,  
    titre = _utf8'مصفوفة', 
    titre_short = _utf8'مصفوفة', 
    is_numeric='N', 
    sql_field_type='text', 
    oracle_field_type='varchar2(5000)';    

INSERT INTO `afield_type` (`id`, `titre`, `titre_short`, `afield_type_code`, `sql_field_type`, `oracle_field_type`, `is_numeric`, `id_aut`, `date_aut`, `id_mod`, `date_mod`, `id_valid`, `date_valid`, `avail`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`)
VALUES ('19', 'كيان صغير', 'كيان صغير', 'sobj', 'text', 'VARCHAR2(5000)', 'N', '1', '2026-05-11 11:30:39', '1', '2026-05-11 11:30:39', NULL, NULL, 'Y', '0', ',', ',', ',', '1');   

DROP TABLE IF EXISTS ttc_pag.synonyms_link;

DROP TABLE IF EXISTS ttc_pag.words;

CREATE TABLE ttc_pag.words ( 
    id INT AUTO_INCREMENT PRIMARY KEY,     
    word VARCHAR(100) NOT NULL, UNIQUE INDEX word_index(word)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1;



CREATE TABLE ttc_pag.synonyms_link (
         word_id INT NOT NULL,
         synonym_id INT NOT NULL,
         PRIMARY KEY (word_id, synonym_id),
         FOREIGN KEY (word_id) REFERENCES words(id) ON DELETE CASCADE,
         FOREIGN KEY (synonym_id) REFERENCES words(id) ON DELETE CASCADE
    );






*/
