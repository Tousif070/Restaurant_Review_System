<?php

    require "dbconnect.php";

    $id=$flag="";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_COOKIE["userID"]))
        {
            $id=$_COOKIE["userID"];
            $flag = "1";
        }
        else if(isset($_COOKIE["restaurantID"]))
        {
            $id=$_COOKIE["restaurantID"];
            $flag = "2";
        }

        $email=$_POST["newemail"];

        if(empty($email))
        {
            header("Location:../settings.php?EmailError=Please Enter Your Email !");
        }
        else
        {
            $email=filter_var($email, FILTER_SANITIZE_EMAIL);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
              header("Location:../settings.php?EmailError=Please Enter A Valid Email !");
            }
            else{
              $query = "";
              if($flag == "1"){
                  $query="update general_users set email='$email' where id=$id";
                }
                else if($flag == "2"){
                  $query="update restaurants set email='$email' where id=$id";
                }

                createDatabaseConnection();
                executeQuery($query);
                closeDatabaseConnection();

                header("Location:../settings.php?emailChangeSuccess=1");
            }
        }
        // if($username == ""){
        //   header("Location:../settings.php?UsernameError=This field can not be empty !");
        // }


    }
?>
