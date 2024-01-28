<?php
// old require of afw_root 
$pwd = $_GET["pwd"];

echo AfwEncryptionHelper::password_encrypt($pwd);