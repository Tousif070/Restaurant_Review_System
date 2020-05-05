<?php

    require "control_logic/dbconnect.php";

    $id="";
    $username="";

    if(isset($_COOKIE["restaurantID"]))
    {
        $id=$_COOKIE["restaurantID"];

        $query="select username from login where id='$id'";

        createDatabaseConnection();
        $result=executeAndGetQuery($query);
        closeDatabaseConnection();

        $rs=$result[0];
        $username=$rs["username"];
    }
    else
    {
        header("Location:login.php");
    }
?>

<html>

    <head>
        <title><?php echo $username; ?></title>
        <link rel="stylesheet" type="text/css" href="css/accounthome2.css">
    </head>

    <body>

        <header>
            <a class="logo" href="accounthome2.php">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="100" width="420">
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
                                <a href="">Profile</a>
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


        <section class="accounthome2-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- ACCOUNT HOME NEWSFEED -->

        <section class="accounthome2-page-section-2">

            <!-- THE NEWSFEED LAYOUT WILL BE GIVEN HERE -->

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
