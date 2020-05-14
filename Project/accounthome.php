<?php

    require "control_logic/dbconnect.php";

    $id=$username="";

    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

        $query="select username from login where id=$id";
        $query33="select category_name from food_category";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);
        $result33=executeAndGetQuery($query33);
        closeDatabaseConnection();

        $username=$result[0]["username"];
    }
    else
    {
        header("Location:login.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $foodCategory=$_POST["foodCategory"];

        header("Location:accountlist.php?value=1&foodCategory=$foodCategory");
    }
?>

<html>

    <head>
        <title><?php echo $username; ?></title>
        <link rel="stylesheet" type="text/css" href="css/accounthome.css">
        <script src="js/loadnewsfeed.js"></script>
        <script src="js/likedislikeprocess.js"></script>
        <script src="js/smartsearch.js"></script>
        <script>
            function checkFoodCategory()
            {
                var obj=document.getElementById("foodCategory");
                if(obj.options[obj.selectedIndex].text == "Select A Category")
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        </script>
    </head>

    <body onload="loadNewsfeed(<?php echo $id; ?>)">

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



        <!-- ACCOUNT HOME NEWSFEED -->

        <section class="accounthome-page-section-2">

            <div class="form-container">
                <table align="center">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td style="font-size: 18px; font-weight: 700;">Search By Typing A Name:</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" style="margin-top: 10px; width: 250px;" onkeyup="search(this)" placeholder="Name of User or Restaurant">
                                        <div id=searchResults class="searchResult"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="accountlist.php?value=2" class="view-feature-clicks">View All Users/Food Bloggers</a></td>
                                </tr>
                                <tr>
                                    <td><a href="accountlist.php?value=3" class="view-feature-clicks">View All Restaurants</td>
                                </tr>
                            </table>
                        </td>

                        <td style="padding-left: 50px;">

                            <form action="" onsubmit="return checkFoodCategory()" method="post">
                                <table>
                                    <tr>
                                        <td align="right" style="font-size: 18px; font-weight: 700;">Search Restaurants By Food Category:</td>
                                    </tr>
                                    <tr>
                                        <td align="right">
                                            <select id="foodCategory" name="foodCategory" style="width: 250px; margin-top: 9px;">
                                                <option selected disabled>Select A Category</option>
                                                <?php
                                                    for($i=0; $i<count($result33); $i++)
                                                    {
                                                        $name=$result33[$i]["category_name"];
                                                        echo "<option>$name</option>";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right"><input type="submit" class="button button-accent" style="margin-top: 11px;" value="Search"></td>
                                    </tr>
                                </table>
                            </form>

                        </td>
                    </tr>
                </table>
            </div>

            <div id="newsfeed" class="newsfeed-container">

            </div>

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
