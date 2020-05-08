<?php

    require "control_logic/dbconnect.php";

    $id=$username=$directory=$width=$height="";
    $firstname=$lastname=$gender=$dateOfBirth=$email=$location="";
    $following=$followers=0;

    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

        $query1="select username from login where id=$id";
        $query2="select storage_location, width, height from photos where id=(select profile_photo_id from general_users where id=$id);";
        $query3="select firstname, lastname, gender, DATE_FORMAT(date_of_birth, '%d-%b-%Y') as 'dateofbirth', email, location from general_users where id=$id";
        $query4="select count(account_id) as 'following' from following where account_id=$id";
        $query5="select count(following_id) as 'followers' from following where following_id=$id";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        $result3=executeAndGetQuery($query3);
        $result4=executeAndGetQuery($query4);
        $result5=executeAndGetQuery($query5);
        closeDatabaseConnection();

        $username=$result1[0]["username"];

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

        // LOADING ACCOUNT STATS
        $following=$result4[0]["following"];
        $followers=$result5[0]["followers"];
    }
    else
    {
        header("Location:login.php");
    }
?>

<html>

    <head>
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="css/userprofile.css">
        <script src="js/userprofile.js"></script>
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



        <!-- PROFILE CONTENTS -->

        <section class="userprofile-page-section-2">

            <!-- PROFILE PHOTO UPLOAD -->
            <div class="form-container">

                <form action="control_logic/photoupload.php?type=1" method="post" enctype="multipart/form-data">

                    <h2 class="successful-message">
                        <?php if(isset($_GET["successMsg"])) { echo $_GET["successMsg"]; } ?>
                    </h2>

                    <table>
                        <tr><td class="profile-photo"><img src="<?php echo $directory; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="Profile Picture"></td></tr>
                        <tr><td><input type="button" style="margin-top: 12px;" class="profile-feature-clicks" onclick="uploadAPhoto()" value="Upload A Profile Photo"></td></tr>
                        <tr><td><span id="spanProfilePhotoInput" style="display: none;"><input type="file" id="profilePhotoInput" name="profilePhotoInput"></span></td></tr>
                        <tr><td id="errorProfilePhoto" class="error-messages"><?php if(isset($_GET["errormsg"])) { echo $_GET["errormsg"]; } ?></td></tr>
                        <tr><td><input id="uploadBtn" class="button button-accent" style="display: none;" type="submit" onclick="return checkPhotoSize()" value="Upload"></td></tr>
                    </table>

                </form>

            </div>

            <!-- PERSONAL INFORMATION -->
            <div class="form-container2">

                <h1>personal information</h1>

                <table align="center">

                    <tr>
                        <td class="label">First Name:</td><td class="info"><?php echo $firstname; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Last Name:</td><td class="info"><?php echo $lastname; ?></td>
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

                </table>

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
