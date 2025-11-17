<?php
class PagSynonymHelper {
    public static function getSynonyms($word, $meAlso=true) 
    {
        $synonyms = [];
        $server_db_prefix = AfwSession::currentDBPrefix();
        // Prepare the SQL query to prevent SQL injection
        $rows = AfwDatabase::db_recup_rows("SELECT w2.word as synonyme
                                        FROM $server_db_prefix"."pag.words AS w1
                                        INNER JOIN $server_db_prefix"."pag.synonyms_link AS sl ON w1.id = sl.word_id
                                        INNER JOIN $server_db_prefix"."pag.words AS w2 ON sl.synonym_id = w2.id
                                        WHERE w1.word = '$word'");
        
        if($meAlso) $synonyms[] = $word;
        foreach($rows as $row) {
                $synonyms[] = $row['synonyme'];
        }
        
        return $synonyms;
    }


    public static function addSynonyms($word, $synonyms) 
    {
        $synonyms_arr = explode(",", $synonyms);
        foreach($synonyms_arr as $synonym) {
            $synonym = trim($synonym);
            if($synonym) {
                self::linkWordsAsSynonyms($word, $synonym);
            }
        }

        return true;
    }

    public static function findOrCreateSynonymWord($word) 
    {
        $server_db_prefix = AfwSession::currentDBPrefix();

        // Check if the word exists, if not insert it
        $word_id = AfwDatabase::db_recup_value("SELECT id FROM $server_db_prefix"."pag.words WHERE word = '$word'");
        if(!$word_id) {
            list($result, $project_link_name) = AfwDatabase::db_query("INSERT INTO $server_db_prefix"."pag.words (word) VALUES ('$word')");
            $word_id = AfwDatabase::db_last_insert_id($project_link_name);
        }

        return $word_id;
    }

    public static function linkWordAndSynonym($word_id, $synonym_id)
    {
        $server_db_prefix = AfwSession::currentDBPrefix();
        // First check if the link already exists to avoid duplicates
        $existing_link = AfwDatabase::db_recup_value("SELECT COUNT(*) FROM $server_db_prefix"."pag.synonyms_link WHERE word_id = $word_id AND synonym_id = $synonym_id");
        if($existing_link == 0) {
            AfwDatabase::db_query("INSERT INTO $server_db_prefix"."pag.synonyms_link (word_id, synonym_id) VALUES ($word_id, $synonym_id)");
        }

        $existing_link = AfwDatabase::db_recup_value("SELECT COUNT(*) FROM $server_db_prefix"."pag.synonyms_link WHERE word_id = $synonym_id AND synonym_id = $word_id");
        if($existing_link == 0) {
            AfwDatabase::db_query("INSERT INTO $server_db_prefix"."pag.synonyms_link (word_id, synonym_id) VALUES ($synonym_id, $word_id)");
        }
    }

    public static function linkWordsAsSynonyms($word, $synonym)
    {
        // Check if the word exists, if not insert it
        $word_id = self::findOrCreateSynonymWord($word);

        // Check if the synonym exists, if not insert it
        $synonym_id = self::findOrCreateSynonymWord($synonym);

        // Link the word and synonym in the synonyms_link table
        self::linkWordAndSynonym($word_id, $synonym_id);
        
    }

}