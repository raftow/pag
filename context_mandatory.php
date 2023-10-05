<?php
        
        if(!$objme)
        {
                AfwSession::pushError("الرجاء تسجيل الدخول أولا");
        	header("Location: login.php");
        	exit();
        }
        
        include_once "module_context.php";        
        
        if(!$objme->contextObjId)
        {
                AfwSession::pushError("يجب أولا ".$contextLabel[$lang]);
        	header("Location: index.php");
        	exit();
        }
        
        if($SUB_CONTEXT_MANDATORY and (!$objme->subContextId))
        {
                AfwSession::pushError(" subContextId not defined for context : ".$objme->contextObjName[$lang]);
        	header("Location: index.php");
        	exit();
        }
?>