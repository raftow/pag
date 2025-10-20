<?php
    phpinfo();
    "php_ini_loaded_file=".print php_ini_loaded_file()."<br>\n";
    "php_ini_scanned_files=<pre>".print_r(php_ini_scanned_files())."</pre><br>\n";
    $command_line_result_arr[] = hzm_attribute_command_line("info", "oven", "end", "", "en", "log");

    // ex  (explicit if not same code) 

    $command_done = true;
    $command_finished = true;