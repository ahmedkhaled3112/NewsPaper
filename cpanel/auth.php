<?php
require_once '../lib/Admin.php';
if(!Admin::isLoggedIn()){
    // redirect to login page
    header("Location: login.php");
    // for security 
    exit();
}