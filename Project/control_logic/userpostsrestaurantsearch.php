<?php
    require "dbconnect.php";

    $text=$_GET["text"];

    $query="select id, restaurant_name from restaurants where restaurant_name like '%$text%'";

    createDatabaseConnection();
    $result=executeAndGetQuery($query);
    closeDatabaseConnection();

    echo "<table>";
    for($i=0; $i<count($result); $i++)
    {
        $x='lego';
        $rs=$result[$i];
        echo "<tr>";
        echo "<td class='items' onclick='selectRestaurant(this.innerHTML, ".$rs['id'].")'>";

        echo $rs["restaurant_name"];

        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
?>
