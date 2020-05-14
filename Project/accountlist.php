<?php

    require "control_logic/dbconnect.php";

    $id=$username="";
    $pageTitle="";
    $value=0;
    $foodCategory="";



    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

        $query="select username from login where id=$id";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);
        closeDatabaseConnection();

        $username=$result[0]["username"];
    }
    else if(isset($_COOKIE["restaurantID"]))
    {
        $id=$_COOKIE["restaurantID"];

        $query="select username from login where id=$id";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);
        closeDatabaseConnection();

        $username=$result[0]["username"];
    }
    else
    {
        header("Location:login.php");
        exit;
    }


    if($_GET["value"] == 1)
    {
        $value=1;
        $foodCategory=$_GET["foodCategory"];
        $pageTitle="Food Category - ".$foodCategory;

        $query1="select restaurant_id from restaurant_food_category join food_category on restaurant_food_category.food_category_id=food_category.id where food_category.category_name='$foodCategory'";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
    }
    else if($_GET["value"] == 2)
    {
        $value=2;
        $pageTitle="Users/Food Bloggers";

        $query1="select general_users.id as 'id', firstname, lastname, login.username as 'username' from general_users join login on general_users.id=login.id order by firstname";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
    }
    else if($_GET["value"] == 3)
    {
        $value=3;
        $pageTitle="Restaurants";

        $query1="select id, restaurant_name, branch_name from restaurants order by restaurant_name";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
    }
    else
    {
        header("Location:accounthome.php");
        exit;
    }


?>




<html>

    <head>
        <title><?php echo $pageTitle; ?></title>
        <link rel="stylesheet" type="text/css" href="css/accounthome.css">
    </head>

    <body>

        <header>
            <a class="logo" href="control_logic/redirection.php?destination=1">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="50" width="220">
            </a>
            <nav>
                <ul>
                    <li>
                        <span class="username"><?php echo $username; ?></span>
                        <div class="dropdown-content">
                            <div class="anchor">
                                <a href="control_logic/redirection.php?destination=2">Posts</a>
                            </div>
                            <div class="anchor">
                                <a href="control_logic/redirection.php?destination=3">Profile</a>
                            </div>
                            <div class="anchor">
                                <a href="settings.php">Settings</a>
                            </div>
                            <div class="anchor">
                                <a href="control_logic/logout.php">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>


        <section class="accounthome-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>


        <section class="accounthome-page-section-2">

            <div class="form-container">

                <?php
                    if($value == 1)
                    {
                        if(count($result1) > 4)
                        {
                            echo "<h1 style='font-size: 24px;'>Showing Restaurants For Food Category - $foodCategory</h1>";
                            echo "<div style='margin: auto; width: 80%; font-family: arial; text-align: left;'>";
                        }
                        else if(count($result1) > 0)
                        {
                            echo "<h1 style='font-size: 24px;'>Showing Restaurants For Food Category - $foodCategory</h1>";
                            echo "<div style='margin: auto; width: 80%; height: 500px; font-family: arial; text-align: left;'>";
                        }
                        else
                        {
                            echo "<h1 style='font-size: 24px;'>No Restaurants Found For Food Category - $foodCategory</h1>";
                            echo "<div style='margin: auto; width: 80%; height: 500px; font-family: arial; text-align: left;'>";
                        }
                        for($i=0; $i<count($result1); $i++)
                        {
                            $id=$result1[$i]["restaurant_id"];

                            $query2="select restaurant_name, branch_name from restaurants where id=$id";
                            $result2=executeAndGetQuery($query2);

                            $rs=$result2[0];

                            $name=$rs["restaurant_name"].", ".$rs["branch_name"];

                            $query3="select format(avg(rating), 1) as 'rating', count(restaurant_id) as 'total_rating_count' from ratings where restaurant_id=$id";
                            $result3=executeAndGetQuery($query3);

                            $rating=$totalRatingCount=0;
                            if($result3[0]["rating"] != null)
                            {
                                $rating=$result3[0]["rating"];
                            }
                            $totalRatingCount=$result3[0]["total_rating_count"];

                            echo ($i+1).". <a class='view-feature-clicks' style='font-size: 18px;' href='restaurantprofileview.php?profileID=$id'>$name</a>";
                            echo "<span style='display: block; margin-left: 20px; margin-top: 5px; font-size: 14px;'>Rating: $rating (Rated By $totalRatingCount People)</span>";
                            echo "<hr class='normal-hr'>";
                        }
                        echo "</div>";
                        closeDatabaseConnection();
                    }
                    else if($value == 2)
                    {
                        echo "<h1 style='font-size: 24px;'>users/food bloggers</h1>";
                        if(count($result1) > 4)
                        {
                            echo "<div style='margin: auto; width: 80%; font-family: arial; text-align: left;'>";
                        }
                        else
                        {
                            echo "<div style='margin: auto; width: 80%; height: 500px; font-family: arial; text-align: left;'>";
                        }
                        for($i=0; $i<count($result1); $i++)
                        {
                            $rs=$result1[$i];
                            $id=$rs["id"];
                            $name=$rs["firstname"]." ".$rs["lastname"];
                            $username=$rs["username"];

                            $query2="select count(following_id) as 'followers' from following where following_id=$id";
                            $result2=executeAndGetQuery($query2);

                            $followers=$result2[0]["followers"];

                            echo ($i+1).". <a class='view-feature-clicks' style='font-size: 18px;' href='userprofileview.php?profileID=$id'>$name ($username)</a>";
                            echo "<span style='display: block; margin-left: 20px; margin-top: 5px; font-size: 14px;'>Followers: $followers</span>";
                            echo "<hr class='normal-hr'>";
                        }
                        echo "</div>";
                        closeDatabaseConnection();
                    }
                    else if($value == 3)
                    {
                        echo "<h1 style='font-size: 24px;'>Restaurants</h1>";
                        if(count($result1) > 4)
                        {
                            echo "<div style='margin: auto; width: 80%; font-family: arial; text-align: left;'>";
                        }
                        else
                        {
                            echo "<div style='margin: auto; width: 80%; height: 500px; font-family: arial; text-align: left;'>";
                        }
                        for($i=0; $i<count($result1); $i++)
                        {
                            $rs=$result1[$i];
                            $id=$rs["id"];
                            $name=$rs["restaurant_name"].", ".$rs["branch_name"];

                            $query2="select format(avg(rating), 1) as 'rating', count(restaurant_id) as 'total_rating_count' from ratings where restaurant_id=$id";
                            $result2=executeAndGetQuery($query2);

                            $rating=$totalRatingCount=0;
                            if($result2[0]["rating"] != null)
                            {
                                $rating=$result2[0]["rating"];
                            }
                            $totalRatingCount=$result2[0]["total_rating_count"];

                            echo ($i+1).". <a class='view-feature-clicks' style='font-size: 18px;' href='restaurantprofileview.php?profileID=$id'>$name</a>";
                            echo "<span style='display: block; margin-left: 20px; margin-top: 5px; font-size: 14px;'>Rating: $rating (Rated By $totalRatingCount People)</span>";
                            echo "<hr class='normal-hr'>";
                        }
                        echo "</div>";
                        closeDatabaseConnection();
                    }
                ?>

            </div>

        </section>


        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
