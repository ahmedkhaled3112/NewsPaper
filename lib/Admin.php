<?php
if(file_exists('config.php')){
    require 'config.php';
}else{
    require_once '../config.php';
}
class Admin
{
    public static function isSessionStart()
    {
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
    }
    public static function login($username, $password)
    {
       // get connection 
        global $dbh;
        // encrypte your password by md5()
        $password = md5($password);
        // prepare query before execute
        $sql = $dbh->prepare("SELECT id FROM admin WHERE username = '$username' AND password = '$password'");
        // execute sql query
        $sql->execute();
        if($sql->rowCount() == 1){
            // session start 
            self::isSessionStart();
            // create new session 
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $username;
            return true;
        } else {
            return false;
        }
    }
    
    public static function isLoggedIn()
    {
        // session start 
        self::isSessionStart();
        if(isset($_SESSION['isLoggedIn'], $_SESSION['username'])){
            return true;
        }else {
            return false;
        }
    }
    
    public static function logout()
    {
        if(self::isLoggedIn()){
            unset($_SESSION['isLoggedIn']);
            unset($_SESSION['username']);
            return true;
        }else{
            return false;
        }
    }
}