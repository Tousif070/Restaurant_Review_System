<?php
    require "dbconnect.php";

    $restaurantID=$_COOKIE["restaurantID"];
    $foodCategoryID=$_GET["id"];
    $flag=$_GET["flag"];

    if($flag == "true")
    {
        $query="insert into restaurant_food_category (restaurant_id, food_category_id) values ($restaurantID, $foodCategoryID)";
        createDatabaseConnection();
        executeQuery($query);
    }
    else if($flag == "false")
    {
        $query="delete from restaurant_food_category where restaurant_id=$restaurantID and food_category_id=$foodCategoryID";
        createDatabaseConnection();
        executeQuery($query);
    }

    $query33="select food_category.id as 'id', category_name from food_category join restaurant_food_category on food_category.id=restaurant_food_category.food_category_id where restaurant_food_category.restaurant_id=$restaurantID";
    $result33=executeAndGetQuery($query33);

    if(count($result33) > 0)
    {
        $size=count($result33);
        $i=$k=0;
        while($i < $size)
        {
            $k=$k+3;
            if($k > $size)
            {
                $k=$size;
            }

            echo "<tr>";
            for($i; $i < $k; $i++)
            {
                $name=$result33[$i]["category_name"];
                echo "<td style='font-size: 18px; padding-left: 25px;'><li>$name</li></td>";
            }
            echo "</tr>";
        }
    }

    closeDatabaseConnection();

?>
