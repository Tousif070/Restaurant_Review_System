<?php

    require "control_logic/dbconnect.php";

    $id=$username=$restaurantName=$branchName=$address=$establishedIn=$email=$about="";
    $directory1=$directory2=$width1=$width2=$height1=$height2="";
    $following=$followers=0;
    $rating=0;

    if(isset($_COOKIE["restaurantID"]))
    {
        $id=$_COOKIE["restaurantID"];

        $query1="select username from login where id=$id";
        $query2="select restaurant_name, branch_name, address, DATE_FORMAT(established_in, '%d-%b-%Y') as 'establishedin', email, about from restaurants where id=$id";
        $query3="select storage_location, width, height from photos where id=(select profile_photo_id from restaurants where id=$id)";
        $query4="select storage_location, width, height from photos where id=(select menu_photo_id from restaurants where id=$id)";
        $query5="select count(account_id) as 'following' from following where account_id=$id";
        $query6="select count(following_id) as 'followers' from following where following_id=$id";
        $query7="select format(avg(rating), 1) as 'rating' from ratings where restaurant_id=$id";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        $result3=executeAndGetQuery($query3);
        $result4=executeAndGetQuery($query4);
        $result5=executeAndGetQuery($query5);
        $result6=executeAndGetQuery($query6);
        $result7=executeAndGetQuery($query7);
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
        $following=$result5[0]["following"];
        $followers=$result6[0]["followers"];

        // LOADING RESTAURANT RATING
        if($result7[0]["rating"] != null)
        {
            $rating=$result7[0]["rating"];
        }
    }
    else
    {
        header("Location:login.php");
    }
?>

<html>

    <head>
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="css/restaurantprofile.css">
        <script src="js/restaurantprofile.js"></script>
    </head>

    <body>

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

                <h1>
                    <?php echo $restaurantName."<br>"; ?>
                    <span style="font-size: 22px;"><?php echo $branchName; ?></span>
                    <span style="font-family: arial; font-size: 20px; display: block; margin-top: 10px;"><?php echo "Rating: ".$rating; ?></span>
                </h1>

                <!-- PROFILE PHOTO UPLOAD -->
                <form action="control_logic/photoupload.php?type=1" method="post" enctype="multipart/form-data">

                    <h2 class="successful-message">
                        <?php if(isset($_GET["successMsg"])) { echo $_GET["successMsg"]; } ?>
                    </h2>

                    <table>
                        <tr><td class="profile-photo"><img src="<?php echo $directory1; ?>" width="<?php echo $width1; ?>" height="<?php echo $height1; ?>" alt="Profile Picture"></td></tr>
                        <tr><td><input type="button" style="margin-top: 12px;" class="profile-feature-clicks" onclick="uploadProfilePhoto()" value="Upload A Profile Photo"></td></tr>
                        <tr><td><span id="spanProfilePhotoInput" style="display: none;"><input type="file" id="profilePhotoInput" name="profilePhotoInput"></span></td></tr>
                        <tr><td id="errorProfilePhoto" class="error-messages"><?php if(isset($_GET["errormsg"])) { echo $_GET["errormsg"]; } ?></td></tr>
                        <tr><td><input id="uploadBtn1" class="button button-accent" style="display: none;" type="submit" onclick="return checkProfilePhotoSize()" value="Upload"></td></tr>
                    </table>

                </form>

            </div>

            <!-- RESTAURANT INFORMATION -->
            <div class="form-container2">

                <h1>restaurant information</h1>

                <table align="center">

                    <tr>
                        <td class="label">Address:</td><td class="info"><?php echo $address; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Established In:</td><td class="info"><?php echo $establishedIn; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td><td class="info"><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td class="label" valign="top">About:</td><td class="info"><textarea style="width: 300px; height: 70px;" id="aboutRestaurant" disabled><?php echo $about; ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td id="errorAbout" class="error-messages" style="padding-left: 4px;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input class="button button-accent" type="button" value="Edit" onclick="enableEdit()">
                            <input class="button button-accent" style="margin-right: 0;" type="button" value="Ok" onclick="editAboutRestaurant()">
                        </td>
                    </tr>

                </table>

            </div>

            <!-- MENU PHOTO UPLOAD -->
            <div class="form-container2">

                <h1>
                    <span style="font-size: 24px;">Restaurant Menu</span>
                </h1>

                <form action="control_logic/photoupload.php?type=2" method="post" enctype="multipart/form-data">

                    <h2 class="successful-message">
                        <?php if(isset($_GET["successMsg2"])) { echo $_GET["successMsg2"]; } ?>
                    </h2>

                    <table>
                        <tr><td class="menu-photo"><img src="<?php echo $directory2; ?>" width="<?php echo $width2; ?>" height="<?php echo $height2; ?>" alt="Restaurant Menu"></td></tr>
                        <tr><td><input type="button" style="margin-top: 12px;" class="profile-feature-clicks" onclick="uploadMenuPhoto()" value="Upload A Menu"></td></tr>
                        <tr><td><span id="spanMenuPhotoInput" style="display: none;"><input type="file" id="menuPhotoInput" name="menuPhotoInput"></span></td></tr>
                        <tr><td id="errorMenuPhoto" class="error-messages"><?php if(isset($_GET["errormsg2"])) { echo $_GET["errormsg2"]; } ?></td></tr>
                        <tr><td><input id="uploadBtn2" class="button button-accent" style="display: none;" type="submit" onclick="return checkMenuPhotoSize()" value="Upload"></td></tr>
                    </table>

                </form>

            </div>

            <!-- ACCOUNT STATS -->
            <div class="form-container2">

                <h1>account stats</h1>

                <table align="center">

                    <tr>
                        <td class="label">Following:</td><td class="info"><?php echo $following; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Followers:</td><td class="info"><?php echo $followers; ?></td>
                    </tr>

                </table>

            </div>

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
