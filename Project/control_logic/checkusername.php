<?php
    require "dbconnect.php";

    $username=$_GET["username"];

    $query="select username from login where username='$username'";

    createDatabaseConnection();
    $result=executeAndGetQuery($query);
    closeDatabaseConnection();

    $found=0;

    if(count($result) > 0)
    {
        $found=1;
    }

    echo $found;
?>
