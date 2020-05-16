<?php

    require "dbconnect.php";

    $id=$username="";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_COOKIE["userID"]))
        {
            $id=$_COOKIE["userID"];
        }
        else if(isset($_COOKIE["restaurantID"]))
        {
            $id=$_COOKIE["restaurantID"];
        }

        $username=$_POST["newusername"];
        if($username == ""){
          header("Location:../settings.php?UsernameError=This field can not be empty !");
          exit;
        }

        $query="select username from login where username='$username'";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);
        closeDatabaseConnection();

        if(count($result) > 0)
        {
            header("Location:../settings.php?UsernameError=Username Already Exists !");
        }
        else{
          $query="update login set username='$username' where id=$id";

          createDatabaseConnection();
          executeQuery($query);
          closeDatabaseConnection();

          header("Location:../settings.php?usernameChangeSuccess=1");
        }
    }
?>
