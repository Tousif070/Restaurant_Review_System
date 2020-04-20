<?php

    require "dbconnect.php";

    $id=$password="";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $id=$_COOKIE["userID"];
        $password=$_POST["password"];

        $query="update login set password='$password' where id='$id'";

        createDatabaseConnection();
        executeQuery($query);
        closeDatabaseConnection();

        header("Location:usersettings.php?passwordChangeSuccess=1");
    }
?>
