<?php

    require "dbconnect.php";

    $postID=$_GET["id"];
    $accountID="";
    $likeButtonImageValue="images/likeoff.png";
    $dislikeButtonImageValue="images/dislikeoff.png";

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
        $query="select like_dislike from likes_dislikes where post_id=$postID and account_id=$accountID";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);

        if(count($result) == 0)
        {
            $query="insert into likes_dislikes (post_id, like_dislike, account_id) values ($postID, 1, $accountID)";
            executeQuery($query);
            $likeButtonImageValue="images/likeon.png";
        }
        else if(count($result) == 1)
        {
            if($result[0]["like_dislike"] == 1)
            {
                $query="delete from likes_dislikes where post_id=$postID and account_id=$accountID";
                executeQuery($query);
            }
            else if($result[0]["like_dislike"] == 0)
            {
                $query="update likes_dislikes set like_dislike=1 where post_id=$postID and account_id=$accountID";
                executeQuery($query);
                $likeButtonImageValue="images/likeon.png";
            }
        }
    }
    else if($_GET["value"] == 2)
    {
        $query="select like_dislike from likes_dislikes where post_id=$postID and account_id=$accountID";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);

        if(count($result) == 0)
        {
            $query="insert into likes_dislikes (post_id, like_dislike, account_id) values ($postID, 0, $accountID)";
            executeQuery($query);
            $dislikeButtonImageValue="images/dislikeon.png";
        }
        else if(count($result) == 1)
        {
            if($result[0]["like_dislike"] == 0)
            {
                $query="delete from likes_dislikes where post_id=$postID and account_id=$accountID";
                executeQuery($query);
            }
            else if($result[0]["like_dislike"] == 1)
            {
                $query="update likes_dislikes set like_dislike=0 where post_id=$postID and account_id=$accountID";
                executeQuery($query);
                $dislikeButtonImageValue="images/dislikeon.png";
            }
        }
    }

    $likes=$dislikes="0";

    $query52="select count(like_dislike) as 'likes' from likes_dislikes where post_id=$postID and like_dislike=1";
    $query53="select count(like_dislike) as 'dislikes' from likes_dislikes where post_id=$postID and like_dislike=0";

    $result52=executeAndGetQuery($query52);
    $result53=executeAndGetQuery($query53);

    $likes=$result52[0]["likes"];
    $dislikes=$result53[0]["dislikes"];

    closeDatabaseConnection();

    echo "<span style='display: inline-block;'>";
    echo "<img src=$likeButtonImageValue width='27' height='27' onclick='likeDislikeProcess(1, $postID)' style='cursor: pointer;' alt='Like Button Image'><br>";
    echo "<span style='font-family: arial; font-size: 11px; display: inline-block; margin: 10px 0 0 0;'>$likes</span>";
    echo "</span>";

    echo "<span style='display: inline-block;'>";
    echo "<img src=$dislikeButtonImageValue width='27' height='27' onclick='likeDislikeProcess(2, $postID)' style='margin-left: 40px; cursor: pointer;' alt='Dislike Button Image'><br>";
    echo "<span style='font-family: arial; font-size: 11px; display: inline-block; margin: 10px 0 0 40px;'>$dislikes</span>";
    echo "</span>";

?>
