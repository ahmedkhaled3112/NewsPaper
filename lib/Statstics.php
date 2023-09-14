<?php
if(file_exists('config.php')){
    require 'config.php';
}else{
    require_once '../config.php';
}
class Statstics
{
    public static function getNoOfRecords($tableName)
    {
       // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT id FROM $tableName");
        // execute sql query
        $sql->execute();
        return $sql->rowCount(); 
    }
}