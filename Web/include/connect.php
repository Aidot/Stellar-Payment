<?php
    require_once('safe.php');
    $sql_host = 'localhost';
    $sql_name = 'db_name';
    $sql_user = 'db_user';
    $sql_pass = 'db_pass';

    $dbConnect = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_name);

    if (mysqli_connect_errno($dbConnect)) {
        exit(mysqli_connect_error());
    }
    global $dbConnect;
?>
