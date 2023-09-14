<?php
require_once '../lib/Admin.php';
if(Admin::isLoggedIn()){
    // unset session 
    Admin::logout();
    // redirect to login page
    header("Location: login.php");
    // for security 
    exit();
}else{
    sleep(5);
    // redirect to login page
    header("Location: index.php");
    // for security 
    exit();
}