<?php

    require "control_logic/dbconnect.php";

    $id=$username=$profileUsername=$directory=$width=$height="";
    $firstname=$lastname=$gender=$dateOfBirth=$email=$location="";
    $followers=0;

    if(isset($_COOKIE["userID"]))
    {
        $id=$_GET["profileID"];
        $userID=$_COOKIE["userID"];

        if($id == $userID)
        {
            // CANNOT VIEW HIS/HER OWN PROFILE THROUGH PROFILE VIEW
            header("Location:accounthome.php");
            exit;
        }

        $query1="select username from login where id=$userID";
        $query2="select storage_location, width, height from photos where id=(select profile_photo_id from general_users where id=$id);";
        $query3="select firstname, lastname, gender, DATE_FORMAT(date_of_birth, '%d-%b-%Y') as 'dateofbirth', email, location from general_users where id=$id";
        $query4="select count(following_id) as 'followers' from following where following_id=$id";
        $query5="select account_id, following_id from following where account_id=$userID and following_id=$id";
        $query6="select username from login where id=$id";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        $result3=executeAndGetQuery($query3);
        $result4=executeAndGetQuery($query4);
        $result5=executeAndGetQuery($query5);
        $result6=executeAndGetQuery($query6);
        closeDatabaseConnection();

        $username=$result1[0]["username"];
        $profileUsername=$result6[0]["username"];

        // LOADING THE PROFILE PHOTO
        if(count($result2) == 1)
        {
            $directory=$result2[0]["storage_location"];
            $width=$result2[0]["width"];
            $height=$result2[0]["height"];
        }
        else
        {
            $directory="";
            $width=400;
            $height=500;
        }

        // LOADING PERSONAL INFORMATION
        $firstname=$result3[0]["firstname"];
        $lastname=$result3[0]["lastname"];
        $gender=$result3[0]["gender"];
        $dateOfBirth=$result3[0]["dateofbirth"];
        $email=$result3[0]["email"];
        $location=$result3[0]["location"];

        // LOADING FOLLOWERS
        $followers=$result4[0]["followers"];
    }
    else
    {
        header("Location:login.php");
    }
?>

<html>

    <head>
        <title><?php echo $profileUsername."'s Profile View"; ?></title>
        <link rel="stylesheet" type="text/css" href="css/userprofile.css">
        <link rel="stylesheet" type="text/css" href="css/userposts.css">
        <script src="js/posts.js"></script>
        <script src="js/followingprocess.js"></script>
    </head>

    <body onload="showAllPosts(<?php echo $id; ?>)">

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


        <section class="userprofile-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>




        <section class="userprofile-page-section-2">

            <div class="form-container">

                <table>

                    <tr>
                        <td id="followUnfollow" align="center" style="padding-top: 20px;">
                            <?php
                                if(count($result5) == 1)
                                {
                                    echo "<span style='font-size: 18px;'>You Are Following </span>";
                                    echo "<span class='post-username'>".$profileUsername."</span><br>";
                                    echo "<input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='followProcess(0, $id)' value='Unfollow'>";
                                }
                                else if(count($result5) == 0)
                                {
                                    echo "<span style='font-size: 18px;'>You Are Not Following </span>";
                                    echo "<span class='post-username'>".$profileUsername."</span><br>";
                                    echo "<input class='button button-accent' style='margin: 15px 0 0 0' type='button' onclick='followProcess(1, $id)' value='Follow'>";
                                }
                            ?>
                        </td>
                    </tr>

                    <tr><td class="profile-photo" style="padding-top: 20px; padding-bottom: 10px;"><img src="<?php echo $directory; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="Profile Picture"></td></tr>
                </table>

                <table align="center">

                    <tr>
                        <td class="label">Name:</td><td class="info"><?php echo $firstname." ".$lastname; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Gender:</td><td class="info"><?php echo $gender; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Date Of Birth:</td><td class="info"><?php echo $dateOfBirth; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email:</td><td class="info"><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Location:</td><td class="info"><?php echo $location; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Followers:</td><td class="info"><?php echo $followers; ?></td>
                    </tr>

                </table>

            </div>



            <div class="posts-container">
                <h2>
                    <?php
                        echo $profileUsername."'s Posts";
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
