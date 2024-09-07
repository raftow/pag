<?php
   class ClineUtils
   {

       public static function similarCommand($command_to_help, $command_similar)
       {
           return (!$command_to_help) or ($command_to_help==$command_similar);
       }

       public static function formatCommand($command_code)
       {
            if($command_code=="help")
            {
                // nothing to do
            }
            
            if(($command_code=="curr") or ($command_code=="curm") or ($command_code=="currm"))
            {
                $command_code = "curr_mod";
            }

            if(($command_code=="curo") or ($command_code=="curro") or ($command_code=="curt") or ($command_code=="currt"))
            {
                $command_code = "curr_tbl";
            }
            
            if(($command_code=="curf") or ($command_code=="currf"))
            {
                $command_code = "curr_fld";
            }
            
            
            if($command_code=="find")
            {
                // nothing to do
            }
            
            if($command_code=="list")
            {
                // nothing to do
            }
            
            if($command_code=="reverse")
            {
                // nothing to do
            }
            
            if(($command_code=="show") or ($command_code=="view") or ($command_code=="more"))
            {
                $command_code="show";
            }

            if(($command_code=="gen") or ($command_code=="genere") or ($command_code=="g"))
            {
                $command_code="generate";
            }
            
            if($command_code=="retrieve")
            {
                // nothing to do             
            }

            return $command_code;
       }
   }
   