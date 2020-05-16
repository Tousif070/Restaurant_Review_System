<?php

    require "dbconnect.php";

    $id=$_GET["id"];
    $username="";

    $query2="select id, post_text, DATE_FORMAT(date_and_time, '%d-%b-%y &nbsp %h:%i %p') as 'datetime', photo_id, restaurant_id from posts where account_id=$id order by DATE_FORMAT(date_and_time, '%d-%b-%y %T') desc";

    createDatabaseConnection();

    $postResults=executeAndGetQuery($query2);

    if(count($postResults) == 0)
    {
        if(isset($_COOKIE["userID"]))
        {
            if($id == $_COOKIE["userID"])
            {
                echo "<div style='font-size: 18px; padding: 20px;'>You Have Not Created Any Posts Yet !</div>";
            }
            else
            {
                echo "<div style='font-size: 18px; padding: 20px;'>No Posts Created Yet !</div>";
            }
        }
        else if(isset($_COOKIE["restaurantID"]))
        {
            if($id == $_COOKIE["restaurantID"])
            {
                echo "<div style='font-size: 18px; padding: 20px;'>You Have Not Created Any Posts Yet !</div>";
            }
            else
            {
                echo "<div style='font-size: 18px; padding: 20px;'>No Posts Created Yet !</div>";
            }
        }
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

        $postID=$rs["id"];

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




        $likeButtonImageValue="images/likeoff.png";
        $dislikeButtonImageValue="images/dislikeoff.png";



        $myID="";
        if(isset($_COOKIE["userID"]))
        {
            $myID=$_COOKIE["userID"];
        }
        else if(isset($_COOKIE["restaurantID"]))
        {
            $myID=$_COOKIE["restaurantID"];
        }



        if($myID == $id)
        {
            // THIS MEANS TO VIEW THE LIKES OR DISLIKES IN ONE'S OWN POSTS
            $query51="select like_dislike from likes_dislikes where post_id=$postID and account_id=$id";
            $result51=executeAndGetQuery($query51);

            if(count($result51) == 1)
            {
                if($result51[0]["like_dislike"] == 1)
                {
                    $likeButtonImageValue="images/likeon.png";
                }
                else if($result51[0]["like_dislike"] == 0)
                {
                    $dislikeButtonImageValue="images/dislikeon.png";
                }
            }
        }
        else
        {
            // THIS MEANS TO VIEW THE LIKES OR DISLIKES IN OTHERS' POSTS
            $query51="select like_dislike from likes_dislikes where post_id=$postID and account_id=$myID";
            $result51=executeAndGetQuery($query51);

            if(count($result51) == 1)
            {
                if($result51[0]["like_dislike"] == 1)
                {
                    $likeButtonImageValue="images/likeon.png";
                }
                else if($result51[0]["like_dislike"] == 0)
                {
                    $dislikeButtonImageValue="images/dislikeon.png";
                }
            }
        }




        // FINDING THE NUMBER OF LIKES & DISLIKES
        $likes=$dislikes="0";

        $query52="select count(like_dislike) as 'likes' from likes_dislikes where post_id=$postID and like_dislike=1";
        $query53="select count(like_dislike) as 'dislikes' from likes_dislikes where post_id=$postID and like_dislike=0";

        $result52=executeAndGetQuery($query52);
        $result53=executeAndGetQuery($query53);

        $likes=$result52[0]["likes"];
        $dislikes=$result53[0]["dislikes"];


        // DISPLAYING LIKES & DISLIKES
        echo "<tr><td id='$postID' style='padding: 10px 0 0 50px;'>";

        echo "<span style='display: inline-block;'>";
        echo "<img src=$likeButtonImageValue width='27' height='27' onclick='likeDislikeProcess(1, $postID)' style='cursor: pointer;' alt='Like Button Image'><br>";
        echo "<span style='font-family: arial; font-size: 11px; display: inline-block; margin: 10px 0 0 0;'>$likes</span>";
        echo "</span>";

        echo "<span style='display: inline-block;'>";
        echo "<img src=$dislikeButtonImageValue width='27' height='27' onclick='likeDislikeProcess(2, $postID)' style='margin-left: 40px; cursor: pointer;' alt='Dislike Button Image'><br>";
        echo "<span style='font-family: arial; font-size: 11px; display: inline-block; margin: 10px 0 0 40px;'>$dislikes</span>";
        echo "</span>";

        echo "</td></tr>";

        echo "</table>";
        echo "<hr class='post-hr'>";
    }

    closeDatabaseConnection();
?>
