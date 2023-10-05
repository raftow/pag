<?php
   $bf = $_GET["bf"];
   
   $out_scr .= "i am ".$objme->getDisplay()."(id = " . $objme->getId() . ")<br>";
   
   if($objme)
   {
       if($objme->iCanDoBF($bf))
       {
            $out_scr .= "yes I can do $bf<br>";
       }
       else
       {
            $out_scr .= "no I can't do $bf !<br>";
       }
   }
   else
   {
       $out_scr .= "please connect before<br>";
   }               
?>