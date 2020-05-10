<?php

    require "dbconnect.php";

    $accountID="";
    $id=$_GET["id"];
    $profileUsername="";

    createDatabaseConnection();

    $query11="select firstname from general_users where id=$id";
    $query12="select restaurant_name, branch_name from restaurants where id=$id";

    $result11=executeAndGetQuery($query11);
    $result12=executeAndGetQuery($query12);

    if(count($result11) == 1)
    {
        $query1="select username from login where id=$id";
        $result1=executeAndGetQuery($query1);
        $profileUsername=$result1[0]["username"];
    }
    else if(count($result12) == 1)
    {
        $profileUsername=$result12[0]["restaurant_name"].", ".$result12[0]["branch_name"];
    }

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
