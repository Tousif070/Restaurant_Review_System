<?php

    require "dbconnect.php";

    $id=$password="";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $id=$_COOKIE["userID"];
        $password=$_POST["password"];

        $password=filter_var($password, FILTER_SANITIZE_STRING);

        if(strlen($password) < 8)
        {
            header("Location:../usersettings.php?PasswordError=Password Should Be Minimum Of 8 Characters !");
        }
        else
        {
            $password=md5($password); // PASSWORD ENCRYPTION USING MD5 (MESSAGE DIGEST ALGORITHM - 5)

            $query="update login set password='$password' where id='$id'";

            createDatabaseConnection();
            executeQuery($query);
            closeDatabaseConnection();

            header("Location:../usersettings.php?passwordChangeSuccess=1");
        }
    }
?>
