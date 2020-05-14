<?php
    require "dbconnect.php";

    $text=$_GET["text"];

    $query1="select id, firstname, lastname from general_users where firstname regexp '^$text'";
    $query2="select id, restaurant_name, branch_name from restaurants where restaurant_name regexp '^$text'";

    createDatabaseConnection();
    $result1=executeAndGetQuery($query1);
    $result2=executeAndGetQuery($query2);
    closeDatabaseConnection();

    echo "<table>";

    if(count($result1) > 0)
    {
        echo "<tr><td style='font-weight: bold; padding-bottom: 5px;'>Users or Food Bloggers: </td></tr>";
        for($i=0; $i<count($result1); $i++)
        {
            $rs=$result1[$i];
            $profileID=$rs["id"];
            $name=$rs["firstname"]." ".$rs["lastname"];

            echo "<tr>";
            echo "<td style='padding: 0;'>";

            echo "<a class='items' href='userprofileview.php?profileID=$profileID'>$name</a>";

            echo "</td>";
            echo "</tr>";
        }
    }

    if(count($result2) > 0)
    {
        echo "<tr><td style='font-weight: bold; padding-bottom: 5px;'>Restaurants: </td></tr>";
        for($i=0; $i<count($result2); $i++)
        {
            $rs=$result2[$i];
            $profileID=$rs["id"];
            $name=$rs["restaurant_name"].", ".$rs["branch_name"];

            echo "<tr>";
            echo "<td style='padding: 0;'>";

            echo "<a class='items' href='restaurantprofileview.php?profileID=$profileID'>$name</a>";

            echo "</td>";
            echo "</tr>";
        }
    }

    echo "</table>"

?>
