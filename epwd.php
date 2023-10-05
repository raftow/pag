<?php
// old require of afw_root 
$pwd = $_GET["pwd"];

echo AFWRoot::password_encrypt($pwd);