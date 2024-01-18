<?php
        // obsolete
        /*
        if(!$_SESS ION["mySemplObj"])
        {
                if($objme)
                {
                    $my_org_unit_id = $objme->getMyOrganizationId("");
                    AFWDebugg::log("objme($me)->getMyOrganizationId() = $my_org_unit_id");
                    if($my_org_unit_id)
                    {
                        $mySemplObj = new Employee();
                        $mySemplObj->select("auser_id", $me);
                        $mySemplObj->select("id_sh_org", $my_org_unit_id);
                        
                        if($mySemplObj->load())
                        {
                             $_SE SSION["mySemplObj"] =& $mySemplObj;
                        }
                        else
                        {
                                $my_email = $objme->getVal("email");
                                if(!$my_email) throw new AfwRuntimeException("employee without email, how it can be ?"); //$objme->debuggObj($objme);
                                $mySemplObj->select("email", $my_email);
                                if($mySemplObj->load())
                                {
                                     $_SE SSION["mySemplObj"] =& $mySemplObj;
                                }
                                else
                                {
                                        $_SE SSION["error"] = "ليس لديك حساب موظف معروف الرجاء مراجعة مشرف التطبيق"; 

                                }
                        }
                        $my_employee_id = $mySemplObj->getId();
                    }
                    AFWDebugg::log("objme($me)->my_employee_id = $my_employee_id");    
                }
                else 
                {
                        $mySemplObj = null;
                        $my_org_unit_id = 0;
                        $my_employee_id = 0;
                        
                }
        }
        else
        {
                $mySemplObj =& $_SESS ION["mySemplObj"];
                $my_employee_id = $mySemplObj->getId();
                $my_org_unit_id = $mySemplObj->valId_sh_org();
        }*/
?>