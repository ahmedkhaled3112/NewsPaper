<?php
require_once '../lib/Admin.php';
require_once '../helpers/output.php';
?>
<html>
    <head>
        <title>DASHBOARD</title>
        <link rel="styleSheet" type="text/css" href="template/css/bootstrap.min.css" />
        <link rel="styleSheet" type="text/css" href="template/css/base.css" />
    </head>
    <body>
        <div id="wrapper" class="container">
            <div id="header" class="row">
                <h1>DASHBOARD</h1>
            </div>
<div id="content" class="row">
    <h2>Admin Login</h2>
    <?php
        if(isset($_POST['login'])){
            // collect data 
            $username = $_POST['username'];
            $password = $_POST['password'];
            // check data valid or no 
            if($username == null){
                echo getNullMessage("Admin name");
            }else if($password == null){
                echo getNullMessage("Admin password");
            }else{
                // create object 
                if(Admin::login($username, $password)){
                    // redirect to home page 
                    header("Location: index.php");
                    // for security 
                    exit();
                }else{
                    echo getMessage("Invalid Login please enter valid data");
                }
            }
        }
    ?>
    <form action="login.php" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">username</label>
            <input type="text" name="username" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">password</label>
            <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <input type="submit" class="btn btn-danger" name="login" value="login"/>
    </form>
</div>
<?php
require_once 'template/footer.tpl';
?>

