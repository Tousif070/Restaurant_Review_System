<?php

    require "dbconnect.php";

    $accountID=$_COOKIE["userID"];
    $id=$_GET["id"];

    if($_GET["value"] != 0)
    {
        $rating=$_GET["value"];

        createDatabaseConnection();
        $query="insert into ratings (restaurant_id, rating, account_id) values ($id, $rating, $accountID)";
        executeQuery($query);
        closeDatabaseConnection();

        echo "<span style='font-family: arial; font-size: 18px;'>You Have Rated $rating</span>";
        for($i=0; $i<$rating; $i++) { echo "<img src='images/filledstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>"; }
        echo "<br><input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='ratingProcess(0, $id)' value='Undo'>";
    }
    else
    {
        createDatabaseConnection();
        $query="delete from ratings where restaurant_id=$id and account_id=$accountID";
        executeQuery($query);
        closeDatabaseConnection();

        echo "<span style='font-family: arial; font-size: 18px;'>Give A Rating:</span>";
        echo "<img id='star1' onmouseover='showFilledStars(1)' onmouseout='showHollowStars(1)' onclick='ratingProcess(1, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>";
        echo "<img id='star2' onmouseover='showFilledStars(2)' onmouseout='showHollowStars(2)' onclick='ratingProcess(2, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>";
        echo "<img id='star3' onmouseover='showFilledStars(3)' onmouseout='showHollowStars(3)' onclick='ratingProcess(3, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>";
        echo "<img id='star4' onmouseover='showFilledStars(4)' onmouseout='showHollowStars(4)' onclick='ratingProcess(4, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>";
        echo "<img id='star5' onmouseover='showFilledStars(5)' onmouseout='showHollowStars(5)' onclick='ratingProcess(5, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>";
    }
?>
