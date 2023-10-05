<?php
if(!$objme) $objme = AfwSession::getUserConnected();
if($objme and $objme->isAdmin())
{
    $out_scr = AfwSession::logSessionData($get_log=true);
}
