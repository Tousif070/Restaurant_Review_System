<?php

    require "dbconnect.php";

    $id="";
    $username="";

    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

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
        <link rel="stylesheet" type="text/css" href="css/accounthome.css">
    </head>

    <body>

        <header>
            <a class="logo" href="accounthome.php">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="100" width="420">
            </a>
            <nav>
                <ul>
                    <li>
                        <span class="username"><?php echo $username; ?></span>
                        <div class="dropdown-content">
                            <div class="anchor">
                                <a href="">Posts</a>
                            </div>
                            <div class="anchor">
                                <a href="">Profile</a>
                            </div>
                            <div class="anchor">
                                <a href="usersettings.php">Settings</a>
                            </div>
                            <div class="anchor">
                                <a href="logout.php">Logout</a>
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

            <!-- THE NEWSFEED LAYOUT WILL BE GIVEN HERE -->

        </section>





        <footer>
            <div class="container">
                <hr>

                <p class="contact-us">
                    For any inquiry or to send your feedback<br>
                    Email us at
                    <span>eat&rate@business.official.com</span>
                </p>

                <p class="docs">
                    <a href="">Terms & Conditions</a> | <a href="">Privacy Policy</a>
                </p>

                <p class="copyright">
                    © 2020 Eat&Rate.com . All Rights Reserved
                </p>

                <hr class="bottomline">
            </div>
        </footer>

    </body>

</html>
