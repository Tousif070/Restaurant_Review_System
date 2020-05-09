<?php

    require "dbconnect.php";

    $id=$_GET["id"];
    $followingID="";

    $query1="select following_id from following where account_id=$id";

    createDatabaseConnection();

    $result=executeAndGetQuery($query1);

    if(count($result) == 0)
    {
        echo "<div style='font-size: 18px; padding: 20px; height: 500px;'>Follow Food Bloggers & Restaurants To See Their Posts/Activity !</div>";
        closeDatabaseConnection();
        exit;
    }

    $followingID=$result[0]["following_id"];
    for($i=1; $i<count($result); $i++)
    {
        $followingID=$followingID.", ".$result[$i]["following_id"];
    }

    $query2="select login.username as 'username', account_id, post_text, DATE_FORMAT(date_and_time, '%d-%b-%y &nbsp %h:%i %p') as 'datetime', photo_id, restaurant_id from posts join login on login.id=account_id where account_id in ($followingID) order by DATE_FORMAT(date_and_time, '%d-%b-%y %T') desc";

    $newsfeedResults=executeAndGetQuery($query2);

    for($i=0; $i<count($newsfeedResults); $i++)
    {
        $rs=$newsfeedResults[$i];

        $profileID=$rs["account_id"];

        echo "<table>";

        if($rs["restaurant_id"] == null)
        {
            echo "<tr><td class='post-username-heading'>";
            echo "<a href='control_logic/profileviewredirection.php?profileID=$profileID' class='post-username'>".$rs['username']."</a>";
            echo "</td></tr>";
        }
        else
        {
            $restaurantID=$rs["restaurant_id"];
            $query="select restaurant_name from restaurants where id=$restaurantID";
            $result=executeAndGetQuery($query);
            $restaurantName=$result[0]["restaurant_name"];

            echo "<tr><td class='post-username-heading'>";
            echo "<a href='control_logic/profileviewredirection.php?profileID=$profileID' class='post-username'>".$rs['username']."</a> mentioned <a href='control_logic/profileviewredirection.php?profileID=$restaurantID' class='post-restaurant'>".$restaurantName."</a>";
            echo "</td></tr>";
        }

        echo "<tr><td class='post-datetime'>";
        echo $rs["datetime"];
        echo "</td></tr>";

        echo "<tr><td class='post-text'>";
        echo $rs["post_text"];
        echo "</td></tr>";

        if($rs["photo_id"] != null)
        {
            $photoID=$rs["photo_id"];
            $query="select storage_location, width, height from photos where id=$photoID";
            $result=executeAndGetQuery($query);
            $directory=$result[0]["storage_location"];
            $width=$result[0]["width"];
            $height=$result[0]["height"];

            echo "<tr><td class='post-images'>";
            echo "<img src='$directory' width='$width', height='$height', alt='Associated Image For This Post'>";
            echo "</td></tr>";
        }

        echo "</table>";
        echo "<hr class='post-hr'>";
    }

    closeDatabaseConnection();
?>
