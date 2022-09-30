<?php
session_start();


require(dirname(__FILE__) . '/include/functions.php');
require(dirname(__FILE__) . '/include/connect.php');


if (!isset($_SESSION['user_id'])) {
    header("refresh:0;url=/index.php");
} else {


    $user_id = $_SESSION['user_id'];

    if (isset($_POST['change_password_new_password'], $_POST['change_password_repeat_password'])) {
        $new_password = $_POST['change_password_new_password'];
        $new_password_repeat = $_POST['change_password_repeat_password'];

        $error = false;

        $valid = filter_var($new_password, FILTER_DEFAULT);
        $valid = $valid && filter_var($new_password_repeat, FILTER_DEFAULT);
        
        if ($new_password != $new_password_repeat) {
            $valid = false;
        }
        $error = !$valid;

        
    } else {
        // Passwords not set, hence valid = false
        $valid = false;
    }
    if ($valid) {
        // ---------------- UPDATE USER ----------------

        $new_password = hashPass($new_password);

        updateUserFlag($bdd, $user_id, "user_pass", $new_password);
        session_destroy();
        header("refresh:5;url=/index.php");
        echo "Successfully updated password.";
    
    } else {

?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8" />

            <title>Change Password</title>

            <link rel="icon" type="image/png" href="css/icon.png">
            <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
            <link rel="stylesheet" href="vendor/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" type="text/css" />
            <link rel="stylesheet" href="vendor/bootstrap-table/dist/bootstrap-table.min.css" type="text/css" />
            <link rel="stylesheet" href="vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" type="text/css" />
            <link rel="stylesheet" href="vendor/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.css" type="text/css" />
            <link rel="stylesheet" href="css/index.css" type="text/css" />
        </head>

        <body class='container-fluid'>

    <?php

        echo strip_tags($content, '<img>');
        require(dirname(__FILE__) . '/include/html/form/change_password_confirm.php');
        if ($error) {
            printError("Passwords are not equal. Try again.");
        }
    }
}

    ?>
        </body>

        </html>