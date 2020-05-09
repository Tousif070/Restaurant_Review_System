<?php

    require "dbconnect.php";

    $accountID="";
    $id=$_GET["id"];

    $query="select username from login where id=$id";

    createDatabaseConnection();

    $result=executeAndGetQuery($query);
    $profileUsername=$result[0]["username"];

    if(isset($_COOKIE["userID"]))
    {
        $accountID=$_COOKIE["userID"];
    }
    else if(isset($_COOKIE["restaurantID"]))
    {
        $accountID=$_COOKIE["restaurantID"];
    }

    if($_GET["value"] == 1)
    {
        $query="insert into following (account_id, following_id) values ($accountID, $id)";
        executeQuery($query);
        closeDatabaseConnection();

        echo "<span style='font-size: 18px;'>You Are Following </span>";
        echo "<span class='post-username'>".$profileUsername."</span><br>";
        echo "<input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='followProcess(0, $id)' value='Unfollow'>";
    }
    else if($_GET["value"] == 0)
    {
        $query="delete from following where account_id=$accountID and following_id=$id";
        executeQuery($query);
        closeDatabaseConnection();

        echo "<span style='font-size: 18px;'>You Are Not Following </span>";
        echo "<span class='post-username'>".$profileUsername."</span><br>";
        echo "<input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='followProcess(1, $id)' value='Follow'>";
    }
?>
