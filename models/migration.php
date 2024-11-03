<?php
class Migration extends AFWObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "pag";
    public static $TABLE            = "migration";
    public static $DB_STRUCTURE = null;
    // public static $copypast = true;

    public function __construct()
    {
        parent::__construct("migration", "id", "pag");
        PagMigrationAfwStructure::initInstance($this);
    }

    

    public static function ignoreMigration($moduleId, $moduleCode, $migration_code, $title, $auser_id)
    {
        $error = "";
        $warning = "";
        $tech = "";
        $info = "";
        try
        {
            $migObj = self::migrating($moduleId, $migration_code, $title, $auser_id);
            $migObj->ignored();
            $info = "migration $migration_code ignored sucessfully";
        }
        catch(Exception $e)
        {
            $error .= $e->getMessage();
            $tech .= "The stack trace is : ";
            $tech .= $e->getTraceAsString();
        }
        catch(Error $e)
        {
            $error .= $e->__toString();
        }
        

        return [$error,
                $info,
                $warning,
                $tech];
    }

    public static function runMigration($moduleId, $moduleCode, $migration_code, $title, $auser_id)
    {
        $error = "";
        $warning = "";
        $tech = "";
        $info = "";
        $file_dir_name = dirname(__FILE__);
        $file_migration_name = "$file_dir_name/../../$moduleCode/migrations/migration_$migration_code.php";
        if(file_exists($file_migration_name))
        {
            try
            {
                $migObj = self::migrating($moduleId, $migration_code, $title, $auser_id);
                include($file_migration_name);
                $migObj->migrated();
                $info = "migration $migration_code done sucessfully";
            }
            catch(Exception $e)
            {
                $error .= $e->getMessage();
                $tech .= "The stack trace is : ";
                $tech .= $e->getTraceAsString();
            }
            catch(Error $e)
            {
                $error .= $e->__toString();
            }
        }
        else $error = "migration $migration_code has been ignored file not found";
        
        

        return [$error,
                $info,
                $warning,
                $tech];
    }

    public static function migrationReady($moduleCode, $migration_code)
    {
        $file_dir_name = dirname(__FILE__);
        $file_migration_name = "$file_dir_name/../../$moduleCode/migrations/migration_$migration_code.php";
        return (file_exists($file_migration_name));
    }

    public static function getMigrations($moduleId, $moduleCode, $migrationStatus="all")
    {
        $return = [];
        $file_dir_name = dirname(__FILE__);
        include("$file_dir_name/../../$moduleCode/migrations/booker.php");
        
        $all_migrations = $migrations;        
        if($migrationStatus!="all")
        {
            $allDoneMigrations = Migration::getAllDoneMigrationsByCode($moduleId);
        }
        $count = 0;
        foreach($all_migrations as $migration_code => $one_migration)
        {
            
            if($migrationStatus=="todo")
            {
                $selected = !$allDoneMigrations[$migration_code];
            }
            elseif($migrationStatus=="done")
            {
                $selected = $allDoneMigrations[$migration_code];
            }
            elseif($migrationStatus=="all") $selected = true;
            elseif($migrationStatus==$migration_code) $selected = true;
            else $selected = false;


            if($selected)
            {
                $return[$count] = $one_migration;
                $return[$count]['code'] = $migration_code;
                $return[$count]['obj'] = $allDoneMigrations[$migration_code];
                $return[$count]['by_id'] = $developers[$one_migration['by']];
                $return[$count]['error'] = '';
                if(!self::migrationReady($moduleCode, $migration_code))
                {
                    $return[$count]['error'] = 'not found';
                }
                $count++;
            }
        }

        return $return;
    
    }

    public static function getAllDoneMigrationsByCode($moduleId)
    {
        $returnList = [];
        $obj = new Migration();
        $obj->select("module_id",$moduleId);
        $obj->where("done_ind != 'N'");
        $objList = $obj->loadMany();
        foreach($objList as $objItem)
        {
            $returnList[$objItem->getVal("migration_code")] = $objItem;
        }

        return $returnList;
    }

    /**
     * 
     * @return Migration
     */
    public static function migrating($module_id, $migration_code, $title, $auser_id)
    {
        return self::loadByMainIndex($module_id, $migration_code, $title, $auser_id,true);
    }

    public function migrated()
    {
        $this->set("done_ind","Y");
        $this->commit();
    }

    public function ignored()
    {
        $this->set("done_ind","W");
        $this->commit();
    }

    public static function loadById($id)
    {
        $obj = new Migration();

        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public function getDisplay($lang = 'ar')
    {
        return $this->getNodeDisplay($lang);
    }

    public function getNodeDisplay($lang = 'ar')
    {
        return $this->getVal("migration_code") . "-" . $this->getDefaultDisplay($lang);
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    public function getScenarioItemId($currstep)
    {
        if ($currstep == 1) return 486;

        return 0;
    }

        public static function loadByMainIndex($module_id, $migration_code, $title, $auser_id, $create_obj_if_not_found=false)
        {
           if(!$module_id) throw new AfwRuntimeException("loadByMainIndex : module_id is mandatory field");
           if(!$migration_code) throw new AfwRuntimeException("loadByMainIndex : migration_code is mandatory field");


           $obj = new Migration();
           $obj->select("module_id",$module_id);
           $obj->select("migration_code",$migration_code);

           if($obj->load())
           {
                if($create_obj_if_not_found) 
                {
                    $obj->set("title",$title);
                    $obj->set("auser_id",$auser_id);
                    $obj->activate();
                }
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("module_id",$module_id);
                $obj->set("migration_code",$migration_code);
                $obj->set("title",$title);
                $obj->set("auser_id",$auser_id);
                

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }

        public function fld_CREATION_USER_ID()
        {
                return "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
        	return "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return "date_valid";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "avail";
        }
        
        public function isTechField($attribute) {
            return (($attribute=="id_aut") or ($attribute=="date_aut") or ($attribute=="id_mod") or ($attribute=="date_mod") or ($attribute=="id_valid") or ($attribute=="date_valid") or ($attribute=="version"));  
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","default_db_");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}

    
    
}
