<?php
$objme = AfwSession::getUserConnected();
$bf = $_GET["bf"];
$module = $_GET["bf"];

$out_scr .= "i am " . $objme->getDisplay() . "(id = " . $objme->getId() . ")<br>";

if ($objme) {
    if ($objme->iCanDoBF($bf, $module)) {
        $out_scr .= "yes I can do $bf<br>";
    } else {
        $out_scr .= "no I can't do $bf !<br>";
    }
} else {
    $out_scr .= "please connect before<br>";
}
