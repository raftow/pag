<?php

class PagObject extends AfwMomkenObject
{
    public static $sciMatrix = [];

    /**
     * @param Atable $myTable
     *  */

    public static function getSciObjectOfAtable($myTable, $step_num)
    {
        if (!$myTable) return null;
        $myTableId = $myTable->id;

        if (!self::$sciMatrix[$myTableId][$step_num]) {
            list($objSci,) = $myTable->getRelation("scis")->resetWhere('step_num = ' . $step_num)->getFirst();
            if($objSci) self::$sciMatrix[$myTableId][$step_num] = $objSci;
            else self::$sciMatrix[$myTableId][$step_num] = "not-found";
        }

        if(self::$sciMatrix[$myTableId][$step_num] == "not-found") return null;

        return self::$sciMatrix[$myTableId][$step_num];
    }



    public function fld_CREATION_USER_ID()
    {
        return 'id_aut';
    }

    public function fld_CREATION_DATE()
    {
        return 'date_aut';
    }

    public function fld_UPDATE_USER_ID()
    {
        return 'id_mod';
    }

    public function fld_UPDATE_DATE()
    {
        return 'date_mod';
    }

    public function fld_VALIDATION_USER_ID()
    {
        return 'id_valid';
    }

    public function fld_VALIDATION_DATE()
    {
        return 'date_valid';
    }

    public function fld_VERSION()
    {
        return 'version';
    }

    public function fld_ACTIVE()
    {
        return 'avail';
    }



    public function getTimeStampFromRow($row, $context = 'update', $timestamp_field = '')
    {
        if (!$timestamp_field)
            return $row['synch_timestamp'];
        else
            return $row[$timestamp_field];
    }
}
