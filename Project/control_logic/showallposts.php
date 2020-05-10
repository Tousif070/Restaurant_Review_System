<?php

    require "dbconnect.php";

    $id=$_GET["id"];
    $username="";

    $query2="select post_text, DATE_FORMAT(date_and_time, '%d-%b-%y &nbsp %h:%i %p') as 'datetime', photo_id, restaurant_id from posts where account_id=$id order by DATE_FORMAT(date_and_time, '%d-%b-%y %T') desc";

    createDatabaseConnection();

    $postResults=executeAndGetQuery($query2);

    if(count($postResults) == 0)
    {
        echo "<div style='font-size: 18px; padding: 20px;'>You Have Not Created Any Posts Yet !</div>";
        closeDatabaseConnection();
        exit;
    }



    $query11="select firstname from general_users where id=$id";
    $query12="select restaurant_name, branch_name from restaurants where id=$id";

    $result11=executeAndGetQuery($query11);
    $result12=executeAndGetQuery($query12);

    if(count($result11) == 1)
    {
        $query1="select username from login where id=$id";
        $result1=executeAndGetQuery($query1);
        $username=$result1[0]["username"];
    }
    else if(count($result12) == 1)
    {
        $username=$result12[0]["restaurant_name"].", ".$result12[0]["branch_name"];
    }




    for($i=0; $i<count($postResults); $i++)
    {
        $rs=$postResults[$i];

        echo "<table>";

        if($rs["restaurant_id"] == null)
        {
            echo "<tr><td class='post-username-heading'>";
            echo "<span class='post-username'>".$username."</span>";
            echo "</td></tr>";
        }
        else
        {
            $restaurantID=$rs["restaurant_id"];
            $query="select restaurant_name, branch_name from restaurants where id=$restaurantID";
            $result=executeAndGetQuery($query);
            $restaurantName=$result[0]["restaurant_name"];
            $branchName=$result[0]["branch_name"];

            echo "<tr><td class='post-username-heading'>";
            echo "<span class='post-username'>".$username."</span> mentioned <a href='control_logic/profileviewredirection.php?profileID=$restaurantID' class='post-restaurant'>".$restaurantName.", ".$branchName."</a>";
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
