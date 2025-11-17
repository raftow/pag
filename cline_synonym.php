<?php

// hzm_start_immediate_output();
$command_line_result_arr[] = hzm_format_command_line("info", "doing $command_code on ".$command_line_words[1]);

$action = $command_line_words[1];

$word_to_synonym = $command_line_words[2];

$the_synonyms = $command_line_words[3];

if($action == "add")
{
    if(!$word_to_synonym)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "synonym command need the wor to synonym !! try to see {help synonym}");
        $nb_errors++;$command_finished = true;return;    
    }

    if(!$the_synonyms)
    {
        $command_line_result_arr[] = hzm_format_command_line("error", "synonym command need the word synonyms !! try to see {help synonym}");
        $nb_errors++;$command_finished = true;return;    
    }

    PagSynonymHelper::addSynonyms($word_to_synonym, $the_synonyms);


    $action = "show";

}

if($action == "show")
{
    $arrSynonyms = PagSynonymHelper::getSynonyms($word_to_synonym, false);
    $command_line_result_arr[] = hzm_format_command_line("success", implode(" / ", $arrSynonyms), $lang,false,true);    
}

$command_code = "";

if(!$command_code) $command_finished = true;
