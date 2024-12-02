<?php
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);




$logbl = substr(md5($_SERVER["HTTP_USER_AGENT"] . "-" . date("Y-m-d")),0,10);


if(!$lang) $lang = "ar";
$module_dir_name = $file_dir_name;
require_once("$file_dir_name/../lib/afw/afw_autoloader.php");

AfwSession::startSession();

$objme = AfwSession::getUserConnected();
//if(!$objme) die("Not authenticated");
//if(!$objme->isAdmin()) die("Not authorized");

if($_GET["action"])
{
        if($_GET["action"]=="phpinfo")
        {
                phpinfo();
        }
        else
        {
                die("action should be in [phpinfo,]");
        }
}
elseif(!(($_POST["mail"]) and ($_POST["pwd"])))
{
?>
<div class="modal-body"><h1> من فضلك قم بتسجيل الدخول</h1><br>
                        <form id="formlogin0" name="formlogin0" method="post" action="conf_test.php" onsubmit="" dir="rtl" enctype="multipart/form-data">
                                <div class="form-group">
                                        <label>اسم المستخدم                                        </label>
                                        <input class="form-control" type="text" name="mail" value="" required="">
                                </div>
                                <div class="form-group">
                                        <label>كلمة المرور
                                        </label>
                                        <input type="password" class="form-control" name="pwd" value="" autocomplete="off" required="">                                        
                                </div>
                                <!-- logbl:06a444e396 -->
                                <input type="submit" class="btnbtsp btn-primary" value="تجربة الدليل النشط" name="loginGo">&nbsp;
                                                                
                                
                        </form>
                </div>
<?php
}
else
{
        $uri_module = AfwUrlManager::currentURIModule();       

        require_once("$file_dir_name/../$uri_module/ini.php");
        require_once("$file_dir_name/../$uri_module/module_config.php");

        include_once ("$file_dir_name/../$uri_module/application_config.php");
        AfwSession::initConfig($config_arr);



        require_once ("$file_dir_name/../external/db.php");
        // 

        $afw_debugg_in_file = $GET_["dbgfile"];
        $debugg_login = true;
        $debugg_login_die = true; 
        $debugg_after_login = true;
        $debugg_after_ldap = true;
        $debugg_after_golden_or_db = true;
        $debugg_after_session_created = true;
        $check_employee_from_external_system = true;

        $msg = "";
        if(($_POST["mail"]) and ($_POST["pwd"]))
        {
                echo "trying to login with ".$_POST["mail"];
                $dtm = date("YmdHis");
                $my_debug_file = "debugg_before_login_${logbl}_$dtm.log";
                
                if($afw_debugg_in_file) AFWDebugg::initialiser($DEBUGG_SQL_DIR,$my_debug_file);
                if($afw_debugg_in_file) 
                {
                        AFWDebugg::log("login process starting");
                        echo "debugg file created in $DEBUGG_SQL_DIR => $my_debug_file";
                }
                //AfwSession::resetSession();
        
                $user_name_c = AfwStringHelper::hardSecureCleanString(strtolower($_POST["mail"]));
                $pwd_c = $_POST["pwd"];
                $login_dbg = array();

                echo "<br>\ntrying to ldap connect with ".$user_name_c;
                // 1. try Active directory first (if enabled)
                list($user_connected, $user_not_connected_reason, $info, $login_dbg[]) = AfwLoginUtilities::ldap_login($user_name_c, $pwd_c);
                
                if(!$user_connected)                
                {
                        echo "<br>\nconf_test failed to make ldap connection with ".$user_name_c." with following report";
                        echo implode("<br><div class='error'>\n", $login_dbg);
                        echo "<br></div>";
                        $login_dbg = [];
                }

                // 2. try database or golden login after
                if(!$user_connected)
                {
                        $login_dbg[] = "try to db_or_golden_login";
                        list($user_connected, $user_not_connected_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_or_golden_login($user_name_c, $pwd_c);
                        $user_found = $user_connected;
                }
                else
                {
                        $user_name_ldap =  $info["samaccountname"][0];     
                        $login_dbg[] = "try to db_retrieve_user_info with ldap user name : $user_name_ldap"; 
                        list($user_found, $user_not_found_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_retrieve_user_info($user_name_ldap);
                }

                if($user_found and $user_infos)
                {
                        $username = $user_infos["username"];
                        $mobile = $user_infos["mobile"];
                        $email = $user_infos["email"];
                }
                
                
                if($debugg_login and $debugg_after_golden_or_db and (!$user_connected))
                {        
                        $login_dbg[] = "info = ".var_export($user_infos,true);
                        AfwStructureHelper::dd("ERROR : SQL/GOLDEN LOGIN FAILED :<br>\n".implode("<br>\n", $login_dbg), $debugg_login_die);
                }
                
                if($user_connected and (!$user_found))
                {        // load infos from HR
                        $emp_num = "00";
                        $hasseb_num = left_complete_len($emp_num, 7, "0");
                        
                        if($username)
                        {
                                if($check_employee_from_external_system)
                                {
                                        if($debugg_login) 
                                        {
                                                $log_sentence = "loading And Update Employee Object From External HR System : starting ...";
                                                $login_dbg[] = $log_sentence;    
                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);
                                        } 
                                        
                                        list($employee, $log_ehr) = Employee::loadAndUpdateFromExternalHRSystem($username, $hasseb_num);

                                        if($debugg_login) 
                                        {
                                                $log_sentence = "returned : ".$log_ehr;
                                                $login_dbg[] = $log_sentence;    
                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);
                                                
                                                $log_sentence = "employee = ".var_export($employee,true);
                                                $login_dbg[] = $log_sentence;    
                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);

                                                $log_sentence = "load And Update Employee Object From External HR System : end.";
                                                $login_dbg[] = $log_sentence;    
                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);
                                        
                                        } 
                                        if($employee and (!$employee->error) and ($employee->getId()>0))
                                        {
                                                if(true or $employee->is_new) 
                                                {
                                                        if($debugg_login) 
                                                        {
                                                                $log_sentence = "update My User Information : starting ...";
                                                                $login_dbg[] = $log_sentence;    
                                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);
                                                        }
                                                        $employee->updateMyUserInformation();
                                                        if($debugg_login) 
                                                        {
                                                                
                                                                $log_sentence = "update My User Information : end.";
                                                                $login_dbg[] = $log_sentence;    
                                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);
                                                        }
                                                }        
                                                
                                        }
                                        else 
                                        {
                                                
                                                if($debugg_login) 
                                                {
                                                $log_sentence = "<b>!!!!!!!!!!!!!!! USER LOGGED OUT because UKNKOWN IN HR SYSTEM --------------- </b>\n";
                                                $login_dbg[] = $log_sentence;    
                                                if($afw_debugg_in_file) AFWDebugg::log($log_sentence);    
                                                
                                                if($employee and $employee->error and $debugg_login_die) die("Employee::loadAndUpdateFromExternalHRSystem Error : ".$employee->error."\n");
                                                }
                                                $user_not_connected_reason = "Employee::loadAndUpdateFromExternalHRSystem($username, $hasseb_num) failed : employee : ".var_export($employee,true); 
                                                $user_connected = false;
                                        }
                                }
                                else
                                {
                                        $employee_org_id = 0;
                                        if($email)
                                        {
                                                if($x_module_means_company and ($MODULE != $uri_module))
                                                {
                                                        
                                                        // die("trying to find company with hrm code - $uri_module");
                                                        $employeeOrg = Orgunit::loadByHRMCode($uri_module);
                                                        if($employeeOrg) $employeeOrgId = $employeeOrg->getId();
                                                        else throw new AfwRuntimeException("unable to find company with hrm code [$uri_module] or it is not allowed to access the system");
                                                        $employee_org_id = $employeeOrgId;
                                                        // @todo disable temp : if((!$employee) or ($employee_org_id != $employeeOrgId)) $user_connected = false;
                                                }
                                                //die("email=$email");
                                                $employee = Employee::loadByEmail($employee_org_id, $email);
                                                if($employee) $employee_org_id = $employee->getVal("id_sh_org");        
                                        }
                                }
                                
                                if($user_connected)
                                {
                                        $user_infos = AfwDatabase::db_recup_row("select id, avail, firstname, email from ${server_db_prefix}ums.auser where avail = 'Y' and username='$username' limit 1");
                                                
                                        $after_login_dbg = "<b>------------------------------- AFTER LOGIN USER INFOS for $username ---------------------------</b>\n";
                                        $after_login_dbg .= var_export($user_infos,true);
                                        
                                        if($debugg_after_login)
                                        {        
                                                if($debugg_login) 
                                                {
                                                        if($afw_debugg_in_file) AFWDebugg::log($after_login_dbg);
                                                        echo $after_login_dbg;
                                                } 

                                        }
                                        
                                }
                                
                        }
                        else 
                        {
                                if($debugg_login and $debugg_login_die) 
                                {
                                       AfwStructureHelper::dd("ERROR : <b>!!!!!!!!!!!!!!! USER NAME EMPTY AND CONNECTED : SHOULD BE IMPOSSIBLE logged out--------------- </b>\n".implode("<br>\n", $login_dbg), $debugg_login_die);                                   
                                }
                                $user_connected = false;
                                $user_not_connected_reason = "user name not defined";
                        }
                
                        //die("s=$time_s  e=$time_e ");
                        if($user_connected)
                        {
                                /*
                                $last_page = AfwSession::getSessionVar("lastpage");
                                $lastget = AfwSession::getSessionVar("lastget");
                                if(count($lastget)>0)
                                {
                                        $last_page .= "?redir=1";
                                        foreach($lastget as $param => $paramval) $last_page .= "&$param=$paramval";
                                }
                
                                //effacer les var d'une eventuelle session précédente
                                
                                AfwSession::resetSession();
                        
                                foreach($user_infos as $col => $val) 
                                {
                                        AfwSession::setSessionVar("user_$col", $val);
                                }
                                
                                if(($last_page) and ($last_page!="login.php"))
                                {
                                if($debugg_after_session_created)
                                {
                                        if($debugg_login) 
                                        {
                                                $session_data = AfwSession::logSessionData($get_log=true);
                                                AFWDebugg::log("login success : before redirect to $last_page, session table : ".$session_data);
                                        }
                                }
                                
                                AfwStructureHelper::dd("******************* success to $last_page ****************** :<br>\n".implode("<br>\n", $login_dbg), $debugg_login_die);
                                }
                                else
                                { 
                                if($debugg_after_session_created)
                                {
                                        if($debugg_login) 
                                        {
                                                $session_data = AfwSession::logSessionData($get_log=true);
                                                AFWDebugg::log("login success : before redirect to the home page (index.php) this is session table : ".$session_data);
                                        }
                                }
                                
                                AfwStructureHelper::dd("******************* success to index ****************** :<br>\n".implode("<br>\n", $login_dbg), $debugg_login_die);
                                }
                                */
                                AfwStructureHelper::dd("!!!!!!!   ldap login succeeded !!!!!!!!", $debugg_login_die);    
                        }
                        else
                        {
                                if($debugg_login) 
                                {
                                                AFWDebugg::log("!!!!!!!   login failed  !!!!!!!!");
                                                AfwStructureHelper::dd("!!!!!!!   login failed  !!!!!!!!", $debugg_login_die);
                                }
                        }
                        
                } 
                
                if(!$user_connected) 
                {
                        die("يوجد خطأ في كلمة المرور أو اسم المستخدم. الرجاء التأكد من البيانات المدخلة : "."<br>".$user_not_connected_reason);
                }
        }
        else
        {
                die("specify mail and pwd");
        }
}
