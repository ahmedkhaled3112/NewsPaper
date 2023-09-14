<?php
if(file_exists('config.php')){
    require 'config.php';
}else{
    require_once '../config.php';
}
class Editor
{
    // property
    private $id;
    private $name;
    private $salary;
    // methods
    public function __construct($name, $salary, $id="")
    {
        $this->name = $name;
        $this->salary = $salary;
        $this->id = $id;
    }
    public function addEditor()
    {
        // get connection 
        global $dbh;
        // prepare query before execute 
        $sql = $dbh->prepare("INSERT INTO editor(name, salary) VALUES('$this->name', '$this->salary')");
        //execute sql query 
        if($sql->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateEditor()
    {
        // get connection 
        global $dbh;
        // prepare query before execute 
        $sql = $dbh->prepare("UPDATE editor SET name='$this->name', salary = '$this->salary' WHERE  id = '$this->id'");
        // execute sql query
        if($sql->execute()){
            return true;
        }else{
            return false;
        }
    }
    public static function deleteEditor($id)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("DELETE FROM editor WHERE id = '$id' ");
        // execute sql query
        if($sql->execute()){
            return true;
        }else{
            return false;
        }
    }
    public static function retreiveEditorById($id)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT * FROM editor WHERE id = '$id' ");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $editor = $sql->fetch(PDO::FETCH_ASSOC);
        return $editor;
    }
    
    public static function retreiveEditorNameById($id)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT name FROM editor WHERE id = '$id' ");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $editor = $sql->fetch(PDO::FETCH_ASSOC);
        return $editor['name'];
    }
    public static function retreiveAllEditors()
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT * FROM editor");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $allEditors = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $allEditors;
    }
}