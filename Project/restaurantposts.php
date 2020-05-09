<?php

    require "control_logic/dbconnect.php";

    $id="";
    $username="";

    if(isset($_COOKIE["restaurantID"]))
    {
        $id=$_COOKIE["restaurantID"];

        $query="select username from login where id=$id";

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
        <title>Posts</title>
        <link rel="stylesheet" type="text/css" href="css/restaurantposts.css">
        <script src="js/posts.js"></script>
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


        <section class="restaurantposts-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- POST UPLOAD & POST VIEWING -->

        <section class="restaurantposts-page-section-2">

            <!-- POST UPLOAD -->

            <div class="form-container">
                <h1>
                    create a post
                    <h2 class="successful-message">
                        <?php if(isset($_GET["successMsg"])) { echo $_GET["successMsg"]; } ?>
                    </h2>
                </h1>

                <form action="control_logic/postupload.php" method="post" onsubmit="return checkPhotoSize()" enctype="multipart/form-data">
                    <table class="big-table">

                        <tr><td><textarea id="postText" name="postText"><?php if(isset($_GET["postText"])) { echo $_GET["postText"]; } ?></textarea></td></tr>
                        <tr><td id="emptyPostText" class="error-messages"></td></tr>

                        <tr><td><input type="button" style="margin-top: 12px;" class="post-feature-clicks" onclick="uploadAPhoto()" value="Upload A Photo"></td></tr>
                        <tr><td><span id="spanPhotoInput" style="display: none;"><input type="file" id="photoInput" name="photoInput"></span></td></tr>
                        <tr><td id="errorPhoto" class="error-messages"><?php if(isset($_GET["errormsg"])) { echo $_GET["errormsg"]; } ?></td></tr>

                        <tr><td align="right"><input id="createBtn" class="button button-accent" type="submit" onclick="return checkPostText()" value="Create"></td></tr>

                    </table>
                </form>
            </div>



            <!-- POST VIEWING -->

            <div class="posts-container">
                <h1>
                    your posts
                </h1>

                <div id="allPosts">

                </div>

            </div>


        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
