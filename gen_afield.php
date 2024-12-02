obsolete 4
<?php
/*
require_once ("db.php");
require_once ("co mmon.php");
require_once ("oci_1.php"); 


include("hzm_header.php");

$key_f = "";
$text_warning = "";



      
 
$table_name = strtoupper($_POST["table_name"]);
$table_desc = $_POST["table_desc"];
$view = $_POST["view"];
$audit = $_POST["audit"];
$fields = $_POST["fields"];
if(!$audit) $fields = true;

$gen_atables_enum_java = false; 

function field_is_to_ignore($field_name)
{
    global $key_f;
    //if ($field_name==$key_f) return true;
    if ($field_name=="CREATION_DATE") return true;
    if ($field_name=="CREATION_USER_ID") return true;
    if ($field_name=="UPDATE_DATE") return true;
    if ($field_name=="UPDATE_USER_ID") return true;
    if ($field_name=="ACTIVE") return true;
    if ($field_name=="VERSION") return true;
    if ($field_name=="UPDATE_ROLES_MFK") return true;
    if ($field_name=="DELETE_ROLES_MFK") return true;
    if ($field_name=="DISPLAY_ROLES_MFK") return true;
    
    return false;
}

$sql_generated = "";

$atable_cols[] = "ATABLE_ID";
$atable_cols[] = "ATABLE_NAME";
$atable_cols[] = "TITLE";

$anstable_cols[] = "ANSWER_TABLE_ID";
$anstable_cols[] = "TITLE";
$anstable_cols[] = "TITLE_EN";
$anstable_cols[] = "TITLE_AFTER";


$tab_cols[] = "COLUMN_NAME";
$tab_cols[] = "DATA_TYPE";
$tab_cols[] = "DATA_LENGTH";
$tab_cols[] = "NULLABLE";
$tab_cols[] = "COMMENTS";

$data_all_tab = recup_data_oci($atable_cols, "select ATABLE_ID, ATABLE_NAME, TITLE from ATABLE where active = 'T'");

if ($gen_atables_enum_java)
{
       foreach($data_all_tab as $i => $row_tab)
       {
            	$atable_id = $row_tab["ATABLE_ID"];
            	$atable_name = $row_tab["ATABLE_NAME"];  
            	$title = $row_tab["TITLE"];
              
              $sql_generated .= "$atable_name(new BigDecimal($atable_id), \"$title\", \"$atable_name\"),\n";
       } 
}


if($audit)
{
      if(!$table_name)
      {
           $data_aud = recup_data_oci($atable_cols, "select ATABLE_ID, ATABLE_NAME, TITLE from atable atb where auditable = 'T' and atb.atable_name || '_AUDIT' in (select t.trigger_name from SYS.user_triggers t where t.trigger_name = atb.atable_name || '_AUDIT')"); 
           echo display_dataGrid("","",$data_aud);
      }
      else
      {
          
           
          $data_diff_audit = recup_data_oci($tab_cols, "select tab.COLUMN_NAME, tab.DATA_TYPE, tab.DATA_LENGTH,tab.NULLABLE from SYS.user_tab_columns tab
                        where tab.table_name = '$table_name'
                        and tab.COLUMN_NAME not in (select tab.COLUMN_NAME from SYS.user_tab_columns tab
                        where tab.table_name = '${table_name}_AUDIT')");
                if(count($data_diff_audit))
                {
                      foreach($data_diff_audit as $i => $row_audit)
                      {
                                  $column_name = $row_audit["COLUMN_NAME"];
                            	    $data_type = $row_audit["DATA_TYPE"]; 
                            	    $data_length = $row_audit["DATA_LENGTH"];
                                  if($data_length) $data_type .= "($data_length)"; 
                
                              
                                  $sql_generated .= "alter table ${table_name}_AUDIT add $column_name $data_type;\n";
                      }        
                }
                else
                {
                        
                       
                       $liste_cols = $data_diff_audit = recup_liste_oci_txt($tab_cols, "select tab.COLUMN_NAME, tab.DATA_TYPE, tab.DATA_LENGTH,tab.NULLABLE from SYS.user_tab_columns tab where tab.table_name = '$table_name'", ",");
                       
                       $liste_cols_old = str_replace(",",",:old.",$liste_cols);  
                
                       $sql_generated .= "CREATE OR REPLACE TRIGGER ${table_name}_UPDATED 
BEFORE UPDATE ON ${table_name}
FOR EACH ROW
BEGIN
  if :old.VERSION >= :new.VERSION then
       :new.VERSION := :old.VERSION + 1;
       :new.UPDATE_USER_ID := null;
  end if;
  :new.UPDATE_DATE := sysDate;
  
END;\n";
                  
                  
                      $sql_generated .= "\ncreate or replace 
trigger ${table_name}_AUDIT 
AFTER UPDATE ON ${table_name} 
FOR EACH ROW 
BEGIN
   insert into ${table_name}_AUDIT($liste_cols) values (:old.$liste_cols_old);
  
END;";    
                }      
      } 
        

      
  
}

   


if($table_name and $fields)
{
      
      $creation_user_id = 350;
      $creation_date = "to_date('".date("d-m-Y")."','DD-MM-RRRR')";
      
      
      

      
      $afield_cols[] = "AFIELD_CODE";
      $afield_cols[] = "AFIELD_ID";
      $afield_cols[] = "FIELD_NAME";
      $afield_cols[] = "ANSWER_TABLE_ID";
      $afield_cols[] = "TITLE";
      $afield_cols[] = "TITLE_EN";
      $afield_cols[] = "TITLE_AFTER";
      
      $atable_row = recup_row_oci($atable_cols,"select ATABLE_ID from ATABLE where ATABLE_NAME = '$table_name'");
      $atable_id = $atable_row["ATABLE_ID"];
      
      if(!$atable_id)
      {
         $sql_generated .= "\n Insert into ATABLE (ATABLE_NAME,TITLE,TITLE_EN,CREATION_USER_ID,CREATION_DATE,ACTIVE,DISPLAY_FIELD,VERSION,KEY_FIELD,AUDITABLE,VH) ";
         $sql_generated .= "values ('$table_name','$table_desc','$table_name',$creation_user_id,$creation_date,'T',null,0,null,'F','');";
      
         $sql_generated .= "\n select * from ATABLE where ATABLE_NAME = '$table_name';";
         
         // $sql_generated .= "\n";
         // $sql_generated .= "---------------------------------------------------\n\n";
         // $sql_generated .= "\n Insert into ATABLE (ATABLE_ID,ATABLE_NAME,TITLE,TITLE_EN,ACTIVE,DISPLAY_FIELD,VERSION,KEY_FIELD,AUDITABLE,VH) ";
         // $sql_generated .= "values (??,'$table_name','$table_desc','$table_name','T',null,0,null,'F','');";
         
      }
      
      
      $data_existing_afields = recup_data_oci($afield_cols, "select ATABLE_ID||'.'||FIELD_NAME as AFIELD_CODE,AFIELD_ID, FIELD_NAME, ANSWER_TABLE_ID, TITLE, TITLE_EN, TITLE_AFTER from AFIELD where ACTIVE = 'T'");
      $index_existing_afields = get_tableau_byid($data_existing_afields,"AFIELD_CODE");
      
      if(!$key_f) $key_f = "${table_name}_ID";
      
      
      
      
      if($atable_id)
      {
      
          
           if($view)   $reel_table_name = "TMP_$table_name";
           else $reel_table_name =  $table_name;
          
           $data_afield = $query = "select tab.COLUMN_NAME, tab.DATA_TYPE, tab.DATA_LENGTH,tab.NULLABLE, colc.COMMENTS from SYS.user_tab_columns tab
          left outer join SYS.user_col_comments colc on colc.table_name = tab.table_name and colc.column_name = tab.column_name
          where tab.table_name = '$reel_table_name'
            and tab.COLUMN_NAME not in ('CREATION_DATE','CREATION_USER_ID','UPDATE_DATE','UPDATE_USER_ID','ACTIVE','VERSION','UPDATE_ROLES_MFK','DELETE_ROLES_MFK','DISPLAY_ROLES_MFK')";
          
           $data_afield = recup_data_oci($tab_cols, $query);
           
           //$data_afield = recup_data("select COLUMN_NAME,DATA_TYPE,DATA_LENGTH,NULLABLE,COMMENTS from TABLE_STRUCT where 1");
           
           if(count($data_afield))
              echo display_dataGrid("","",$data_afield);
           else
              echo "<textarea rows='10' cols='120' dir='ltr'>".$query."</textarea>";
           
           foreach($data_afield as $i => $row_afield)
           {
                    	$field_name = $row_afield["COLUMN_NAME"];
                      $afield_code =  $atable_id . "." . $field_name; 
                    	$field_title = $row_afield["COMMENTS"];  
                    	$field_sql_type = $row_afield["DATA_TYPE"];
                      $field_sql_type_len = $row_afield["DATA_LENGTH"];
                      $field_sql_type_null = $row_afield["NULLABLE"];  
                    	
                              if(!field_is_to_ignore($field_name)) 
                              {
                              
                                   $reel = "T";
                                   $original = "F";
                                   $special = "F";
                                   $additional = "F";
                                   $title = $field_title;
                                   $title_en = "";
                                   $title_after = "";
                                   $mandatory = "F";
                                   $known_already = "F";
                                   $need_validation = "F";
                                   $entry_type_id = 1;
                                   if ((($field_sql_type=="VARCHAR2") or ($field_sql_type=="VARCHAR")) and ($field_sql_type_len==8) and (AfwStringHelper::stringStartsWith($field_name,"_DATE")))
                                       $afield_type_id = 2; // 2	date	تاريخ	Date
                                    elseif ($field_sql_type=="AMOUNT") 
                                       $afield_type_id = 3; // 3	amnt	مبلغ من المال	Amount
                                    elseif ($field_sql_type=="TIME") 
                                       $afield_type_id = 4;  // 4	time	وقت	Time
                                    elseif (($field_sql_type=="NUMBER") and (AfwStringHelper::stringStartsWith($field_name,"_ID")) and ($field_name!=$key_f)) 
                                       $afield_type_id = 5;  // 5	list	اختيار من قائمة	Choose from list
                                    elseif ((AfwStringHelper::stringStartsWith($field_sql_type,"NUMBER")) or (AfwStringHelper::stringStartsWith($field_sql_type,"FLOAT")))
                                       $afield_type_id = 1; // 1	nmbr	قيمة عددية	Numeric Value
                                    elseif (AfwStringHelper::stringStartsWith($field_sql_type,"VARCHAR") and (AfwStringHelper::stringStartsWith($field_name,"_MFK")))  
                                       $afield_type_id = 6; // 6	mlst	اختيار متعدد من قائمة	multiple choice from list
                                    elseif ($field_sql_type=="PCTG") 
                                       $afield_type_id = 7; // 7	pctg	نسبة مائوية	Percentage
                                    elseif ($field_sql_type=="DATE") 
                                       $afield_type_id = 9;  // 9	Gdat	تاريخ ميلادي	G. Date
                                    elseif (AfwStringHelper::stringStartsWith($field_sql_type,"VARCHAR"))
                                       $afield_type_id = 10;  // 10	text	نص قصير	Short text
                            //        elseif AfwStringHelper::stringStartsWith($field_sql_type,"VARCHAR") 
                            //           $afield_type_id = 11;  // 11	mtxt	نص طويل	Long text
                                    elseif (($field_sql_type=="CHAR") and ($field_sql_type_len==1)) 
                                       $afield_type_id = 8;  // 8	yn	نعم/لا	Yes/No
                            //        elseif ($field_sql_type=="DATE") 
                            //           $afield_type_id = 12;  // 12	enum	قائمة قصيرة	Short list
                                    else $afield_type_id = 11;
                                   $descr = $field_title;
                                   $active = "T";
                                   $answer_table_id = "";
                                   $answer_table_name = "";
                                   if($afield_type_id == 5)
                                   {
                                         $answer_table_name = substr($field_name,0,strlen($field_name)-3);
                                         
                                   }
                                   elseif($afield_type_id == 6)
                                   {
                                         $answer_table_name = substr($field_name,0,strlen($field_name)-4);
                                         
                                   }
                                   if($answer_table_name)
                                   {
                                         $answer_table_row = recup_row_oci($atable_cols,"select ATABLE_ID from ATABLE where ATABLE_NAME = '$answer_table_name'");
                                         $answer_table_id = $answer_table_row["ATABLE_ID"]; 
                                         if(!$answer_table_id)
                                         {
                                             $answer_table_row = recup_row_oci($anstable_cols,"select ANSWER_TABLE_ID from AFIELD where FIELD_NAME = '$field_name' and ANSWER_TABLE_ID is not null");
                                             $answer_table_id = $answer_table_row["ANSWER_TABLE_ID"];
                                         }
                                         
                                         if(!$answer_table_id)
                                         {
                                              $text_warning .= "\nfield $field_name of table $table_name has no defined answer table";
                                              $answer_table_id = "???";
                                         }                          
                                   
                                   }
                                   
                                   if(!$answer_table_id) $answer_table_id = "null";
                                   $version = 0;
                                   
                                   $similar_field_row = recup_row_oci($anstable_cols,"select ANSWER_TABLE_ID, TITLE, TITLE_EN, TITLE_AFTER from AFIELD where FIELD_NAME = '$field_name' and TITLE is not null");
                                   
                                   if(!$title) $title = $similar_field_row["TITLE"];
                                   if(!$title_en) $title_en = $similar_field_row["TITLE_EN"];
                                   if(!$title_en) $title_en = $title;
                                   if(!$title_after) $title_after = $similar_field_row["TITLE_AFTER"];
                                   if($answer_table_id=="???") 
                                   {
                                        $answer_table_id = $similar_field_row["ANSWER_TABLE_ID"];
                                        if(!$answer_table_id)  $answer_table_id="???";
                                   }     
    
                                   if(!$index_existing_afields[$afield_code])
                                   {    
                                          
                                          $sql_generated .= "\n Insert into AFIELD (ATABLE_ID,FIELD_NAME,REEL,ORIGINAL,SPECIAL,ADDITIONAL,TITLE,TITLE_EN,TITLE_AFTER,MANDATORY,KNOWN_ALREADY,NEED_VALIDATION,ENTRY_TYPE_ID,AFIELD_TYPE_ID,DESCR,CREATION_USER_ID,CREATION_DATE,ACTIVE,ANSWER_TABLE_ID,VERSION) values ";
                                          $sql_generated .= "($atable_id,'$field_name','$reel','$original','$special','$additional','$title','$title_en','$title_after','$mandatory','$known_already','$need_validation',$entry_type_id,$afield_type_id,'$descr',$creation_user_id,$creation_date,'$active',$answer_table_id,$version);";
                                   }
                                   else
                                   {
                                          $q_update_set = "";
                                          if(($title)&&($title != $index_existing_afields[$afield_code]["TITLE"])) $q_update_set .= "TITLE='$title',";
                                          if(($title_en)&&($title_en != $index_existing_afields[$afield_code]["TITLE_EN"])) $q_update_set .= "TITLE_EN='$title_en',";
                                          if(($title_after)&&($title_after != $index_existing_afields[$afield_code]["TITLE_AFTER"])) $q_update_set .= "TITLE_AFTER='$title_after',";
                                          if(($answer_table_id!="null")&&($answer_table_id != $index_existing_afields[$afield_code]["ANSWER_TABLE_ID"])) $q_update_set .= "ANSWER_TABLE_ID=$answer_table_id,";
                                          if($q_update_set)
                                          {
                                              $afield_id = $index_existing_afields[$afield_code]["AFIELD_ID"];
                                              $sql_generated .= "\n update AFIELD set  $q_update_set ACTIVE='T' where AFIELD_ID = $afield_id;";
                                              //$sql_generated .= "\n -----";
                                          }
                                          
                                   }
                            
                              }
                      
            
           }
      } 
}
if(!$table_name) $table_name = "TABLE"; 
if(!$table_desc) $table_desc = "descr";
?>
<center>
<form id="genSQL" name="genSQL" action="gen_afield.php" method="POST">
<table border='0' width='60%' height='100%' dir="ltr">
<tr>
<td align='center' valign='top'>
view <input type="checkbox" name="view" value="1" <? if($view) echo "checked"?>/>
fields <input type="checkbox" name="fields" value="1" <? if($fields) echo "checked"?>/>
audit <input type="checkbox" name="audit" value="1" <? if($audit) echo "checked"?>/>
<input type="text" name="table_name" value="<?=$table_name?>"/> 
<input type="text" name="table_desc" value="<?=$table_desc?>"/> 
tabID=<?=$atable_id?>
</td>
</tr>
<tr>
<td align='center' valign='top'>
	<table border='0'>
	<tr><td align='right' valign='top'><textarea rows='40' cols='130'  dir="ltr" style="background-color:rgb(38,44,153);color:rgb(149,153,236);">
<?php
   echo $sql_generated;
?>
  </textarea>	
	</td></tr>	
	</table>
</td>
</tr>
<tr>
<td align='center' valign='top'>
<input type="submit" name="btnGo" value="generate"/>  
</td>
</tr>
</table>
</form>
<?
if($text_warning)
{
?>
<textarea rows='40' cols='130'  dir="ltr" style="background-color:rgb(238,44,53);color:rgb(249,253,236);">
<?php
   echo $text_warning;
?>
  </textarea>	
<?
}
?>
</center>
<?php
include("footer.php");
*/
?>