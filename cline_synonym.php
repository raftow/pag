<?php

// hzm_start_immediate_output();

$action = $command_line_words[1];

if (!$action) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "synonym command need the action ex add or show !! try to see {help synonym}");
    $nb_errors++;
    $command_finished = true;
    return;
}

$word_to_synonym = $command_line_words[2];

if (!$word_to_synonym) {
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "synonym command need the word to synonym !! try to see {help synonym}");
    $nb_errors++;
    $command_finished = true;
    return;
}

$the_synonyms = $command_line_words[3];


$command_line_result_arr[] = AfwUtils::hzm_format_command_line("info", "doing $command_code $action on $word_to_synonym");


if ($action == "add") {


    if (!$the_synonyms) {
        $command_line_result_arr[] = AfwUtils::hzm_format_command_line("error", "synonym command need the word synonyms !! try to see {help synonym}");
        $nb_errors++;
        $command_finished = true;
        return;
    }

    if (PagSynonymHelper::addSynonyms($word_to_synonym, $the_synonyms)) $command_done = true;

    $action = "show";
}

if ($action == "show") {
    $arrSynonyms = PagSynonymHelper::getSynonyms($word_to_synonym, false);
    $command_line_result_arr[] = AfwUtils::hzm_format_command_line("success", implode(" / ", $arrSynonyms), $lang, false, true);
    if ($command_line_words[2] == "show") $command_done = true;
}

$command_code = "";

if (!$command_code) $command_finished = true;
