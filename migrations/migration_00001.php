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
