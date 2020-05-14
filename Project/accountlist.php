<?php

    require "control_logic/dbconnect.php";

    $id=$username="";
    $pageTitle="";



    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

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
        $pageTitle="Users/Food Bloggers";

        $query1="select general_users.id as 'id', firstname, lastname, login.username as 'username' from general_users join login on general_users.id=login.id order by firstname";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
    }
    else if($_GET["value"] == 2)
    {
        $pageTitle="Restaurants";

        $query1="select id, restaurant_name, branch_name from restaurants order by restaurant_name";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
    }


?>




<html>

    <head>
        <title><?php echo $pageTitle; ?></title>
        <link rel="stylesheet" type="text/css" href="css/accounthome.css">
    </head>

    <body>

        <header>
            <a class="logo" href="accounthome.php">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="50" width="220">
            </a>
            <nav>
                <ul>
                    <li>
                        <span class="username"><?php echo $username; ?></span>
                        <div class="dropdown-content">
                            <div class="anchor">
                                <a href="userposts.php">Posts</a>
                            </div>
                            <div class="anchor">
                                <a href="userprofile.php">Profile</a>
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
                    if($_GET["value"] == 1)
                    {
                        echo "<h1>users/food bloggers</h1>";
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
                    }
                    else if($_GET["value"] == 2)
                    {
                        echo "<h1>Restaurants</h1>";
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
                    }
                ?>

            </div>

        </section>

        <?php closeDatabaseConnection(); ?>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
