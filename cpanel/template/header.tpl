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
                <?php
                require_once '../lib/Admin.php';
                if(Admin::isLoggedIn()){
                    echo '<p style="padding:0 10px; color:#fff">welcome mr/mrs '. $_SESSION['username'] . ' to logout ' .
                    '<a href="logout.php"> click here</a>
                    </p>';
                }
                ?>
            </div>