<?php

    require "dbconnect.php";

    $profileID="";

    if(isset($_COOKIE["userID"]))
    {
        $profileID=$_GET["profileID"];

        $query1="select firstname from general_users where id=$profileID";
        $query2="select restaurant_name from restaurants where id=$profileID";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        closeDatabaseConnection();

        if(count($result1) == 1)
        {
            header("Location:../userprofileview.php?profileID=$profileID");
        }
        else if(count($result2) == 1)
        {
            header("Location:../restaurantprofileview.php?profileID=$profileID");
        }
    }
    else if(isset($_COOKIE["restaurantID"]))
    {

    }
?>
