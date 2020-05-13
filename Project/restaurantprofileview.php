<?php

    require "control_logic/dbconnect.php";

    $id=$accountID=$username=$restaurantName=$branchName=$address=$establishedIn=$email=$about="";
    $directory1=$directory2=$width1=$width2=$height1=$height2="";
    $followers=0;
    $rating=$totalRatingCount=0;

    if(isset($_COOKIE["restaurantID"]) || isset($_COOKIE["userID"]))
    {
        $id=$_GET["profileID"];

        createDatabaseConnection();


        $query12="select restaurant_name from restaurants where id=$id";
        $result12=executeAndGetQuery($query12);

        if(count($result12) == 0)
        {
            // AVOIDING PROFILE VIEW ACCESS FOR INVALID RESTAURANTS ID
            if(isset($_COOKIE["userID"]))
            {
                header("Location:accounthome.php");
            }
            else if(isset($_COOKIE["restaurantID"]))
            {
                header("Location:accounthome2.php");
            }
            closeDatabaseConnection();
            exit;
        }


        if(isset($_COOKIE["userID"]))
        {
            $accountID=$_COOKIE["userID"];
        }
        else if(isset($_COOKIE["restaurantID"]))
        {
            $accountID=$_COOKIE["restaurantID"];
            if($id == $accountID) // CANNOT VIEW HIS/HER OWN PROFILE THROUGH PROFILE VIEW
            {
                header("Location:restaurantprofile.php");
                closeDatabaseConnection();
                exit;
            }
        }

        $query1="select username from login where id=$accountID";
        $query2="select restaurant_name, branch_name, address, DATE_FORMAT(established_in, '%d-%b-%Y') as 'establishedin', email, about from restaurants where id=$id";
        $query3="select storage_location, width, height from photos where id=(select profile_photo_id from restaurants where id=$id)";
        $query4="select storage_location, width, height from photos where id=(select menu_photo_id from restaurants where id=$id)";
        $query5="select account_id, following_id from following where account_id=$accountID and following_id=$id";
        $query6="select count(following_id) as 'followers' from following where following_id=$id";
        $query7="select format(avg(rating), 1) as 'rating', count(restaurant_id) as 'total_rating_count' from ratings where restaurant_id=$id";
        $query33="select category_name from food_category join restaurant_food_category on food_category.id=restaurant_food_category.food_category_id where restaurant_food_category.restaurant_id=$id";

        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        $result3=executeAndGetQuery($query3);
        $result4=executeAndGetQuery($query4);
        $result5=executeAndGetQuery($query5);
        $result6=executeAndGetQuery($query6);
        $result7=executeAndGetQuery($query7);
        $result33=executeAndGetQuery($query33);

        if(isset($_COOKIE["userID"]))
        {
            $query8="select rating from ratings where restaurant_id=$id and account_id=$accountID";
            $result8=executeAndGetQuery($query8);
        }

        closeDatabaseConnection();

        $username=$result1[0]["username"];

        // LOADING ALL THE BASIC INFORMATION OF THE RESTAURNT
        $restaurantName=$result2[0]["restaurant_name"];
        $branchName=$result2[0]["branch_name"];
        $address=$result2[0]["address"];
        $establishedIn=$result2[0]["establishedin"];
        $email=$result2[0]["email"];
        $about=$result2[0]["about"];

        // LOADING THE PROFILE PHOTO & THE MENU PHOTO
        if(count($result3) == 1)
        {
            $directory1=$result3[0]["storage_location"];
            $width1=$result3[0]["width"];
            $height1=$result3[0]["height"];
        }
        else
        {
            $directory1="";
            $width1=400;
            $height1=500;
        }

        if(count($result4) == 1)
        {
            $directory2=$result4[0]["storage_location"];
            $width2=$result4[0]["width"];
            $height2=$result4[0]["height"];
        }
        else
        {
            $directory2="";
            $width2=400;
            $height2=500;
        }

        // LOADING ACCOUNT STATS
        $followers=$result6[0]["followers"];

        // LOADING RESTAURANT RATING STATS
        if($result7[0]["rating"] != null)
        {
            $rating=$result7[0]["rating"];
        }
        $totalRatingCount=$result7[0]["total_rating_count"];
    }
    else
    {
        header("Location:login.php");
    }
?>

<html>

    <head>
        <title><?php echo $restaurantName.", ".$branchName; ?></title>
        <link rel="stylesheet" type="text/css" href="css/restaurantprofile.css">
        <link rel="stylesheet" type="text/css" href="css/restaurantposts.css">
        <script src="js/posts.js"></script>
        <script src="js/followingprocess.js"></script>
        <script src="js/ratingprocess.js"></script>
        <script src="js/likedislikeprocess.js"></script>
    </head>

    <body onload="showAllPosts(<?php echo $id; ?>)">

        <header>
            <a class="logo" href="accounthome2.php">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="50" width="220">
            </a>
            <nav>
                <ul>
                    <li>
                        <span class="username"><?php echo $username; ?></span>
                        <div class="dropdown-content">
                            <div class="anchor">
                                <a href="restaurantposts.php">Posts</a>
                            </div>
                            <div class="anchor">
                                <a href="restaurantprofile.php">Profile</a>
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


        <section class="restaurantprofile-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- PROFILE CONTENTS -->

        <section class="restaurantprofile-page-section-2">

            <div class="form-container">

                <table style="width: 100%;">
                    <tr>
                        <td id="followUnfollow" align="center" style="padding-top: 20px;">
                            <?php
                                if(count($result5) == 1)
                                {
                                    echo "<span style='font-size: 18px;'>You Are Following </span>";
                                    echo "<span class='post-username'>$restaurantName, $branchName</span><br>";
                                    echo "<input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='followProcess(0, $id)' value='Unfollow'>";
                                }
                                else if(count($result5) == 0)
                                {
                                    echo "<span style='font-size: 18px;'>You Are Not Following </span>";
                                    echo "<span class='post-username'>$restaurantName, $branchName</span><br>";
                                    echo "<input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='followProcess(1, $id)' value='Follow'>";
                                }
                            ?>
                        </td>
                    </tr>

                    <?php
                        if(isset($_COOKIE["userID"]))
                        {
                            echo "<tr><td id='rating' align='center' style='padding-top: 20px;'>";

                            if(count($result8) == 1)
                            {
                                $myRating=$result8[0]["rating"];
                                echo "<span style='font-family: arial; font-size: 18px;'>You Have Rated $myRating</span>";
                                for($i=0; $i<$myRating; $i++) { echo "<img src='images/filledstar.png' width='16' height='16' style='margin-left: 5px;' alt='Rating Star'>"; }
                                echo "<br><input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='ratingProcess(0, $id)' value='Undo'>";
                            }
                            else if(count($result8) == 0)
                            {
                                echo "<span style='font-family: arial; font-size: 18px;'>Give A Rating:</span>";
                                echo "<img id='star1' onmouseover='showFilledStars(1)' onmouseout='showHollowStars(1)' onclick='ratingProcess(1, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px; cursor: pointer;' alt='Rating Star'>";
                                echo "<img id='star2' onmouseover='showFilledStars(2)' onmouseout='showHollowStars(2)' onclick='ratingProcess(2, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px; cursor: pointer;' alt='Rating Star'>";
                                echo "<img id='star3' onmouseover='showFilledStars(3)' onmouseout='showHollowStars(3)' onclick='ratingProcess(3, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px; cursor: pointer;' alt='Rating Star'>";
                                echo "<img id='star4' onmouseover='showFilledStars(4)' onmouseout='showHollowStars(4)' onclick='ratingProcess(4, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px; cursor: pointer;' alt='Rating Star'>";
                                echo "<img id='star5' onmouseover='showFilledStars(5)' onmouseout='showHollowStars(5)' onclick='ratingProcess(5, $id)' src='images/hollowstar.png' width='16' height='16' style='margin-left: 5px; cursor: pointer;' alt='Rating Star'>";
                            }

                            echo "</td></tr>";
                        }
                    ?>

                    <tr><td align="center"><hr style="width: 95%; height: 2px; background: black; margin: 20px 0 0 0;"></td></tr>

                </table>

                <h1 style="margin: 0;">
                    <?php echo $restaurantName."<br>"; ?>
                    <span style="font-size: 22px;"><?php echo $branchName; ?></span>
                    <span style="font-family: arial; font-size: 20px; display: block; margin-top: 10px;"><?php echo "Rating: ".$rating; ?></span>
                    <span style="font-family: arial; font-size: 14px; font-weight: 500; display: block; margin-top: 4px;"><?php echo "Rated By $totalRatingCount People"; ?></span>
                </h1>

                <table>
                    <tr><td class="profile-photo"><img style="margin-bottom: 20px; margin-top: 20px;" src="<?php echo $directory1; ?>" width="<?php echo $width1; ?>" height="<?php echo $height1; ?>" alt="Profile Picture"></td></tr>
                </table>

            </div>

            <!-- RESTAURANT INFORMATION -->
            <div class="form-container2">

                <h1>
                    <span style="font-size: 24px;">restaurant information</span>
                </h1>


                <table align="center">

                    <tr>
                        <td class="label">Address:</td><td class="info"><?php echo $address; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Established In:</td><td class="info" style="font-family: arial;"><?php echo $establishedIn; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td><td class="info"><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td class="label">About:</td><td class="info"><?php echo $about; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Followers:</td><td class="info"><?php echo $followers; ?></td>
                    </tr>

                </table>

            </div>


            <!-- FOOD CATEGORY -->
            <div class="form-container2">

                <h1>
                    <span style="font-size: 24px;">we serve the following category of food</span>
                </h1>

                <table id="foodCategory" align="center">
                    <?php
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
                    ?>
                </table>

            </div>


            <!-- MENU PHOTO -->
            <div class="form-container2">

                <h1>
                    <span style="font-size: 24px;">Restaurant Menu</span>
                </h1>

                <table>
                    <tr><td class="menu-photo"><img src="<?php echo $directory2; ?>" width="<?php echo $width2; ?>" height="<?php echo $height2; ?>" alt="Restaurant Menu"></td></tr>
                </table>

            </div>



            <div class="posts-container">
                <h2>
                    <?php
                        echo "Posts From ".$restaurantName.", ".$branchName;
                    ?>
                </h2>

                <div id="allPosts">

                </div>

            </div>

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
