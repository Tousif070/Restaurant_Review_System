<?php

    require "control_logic/dbconnect.php";

    $id=$username=$email=$password=$repeatPassword=$contactNumber="";
    $emptyUsername=$emptyEmail=$emptyPassword=$emptyRepeatPassword=$emptyContactNumber="";
    $errorUsername=$errorEmail=$errorPassword=$errorRepeatPassword=$errorContactNumber="";

    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

        $query1="select username from login where id=$id";
        $query2="select email from general_users where id='$id'";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        closeDatabaseConnection();

        $rs1=$result1[0];
        $username=$rs1["username"];

        $email=$result2[0]["email"];
    }
    else if(isset($_COOKIE["restaurantID"]))
    {
        $id=$_COOKIE["restaurantID"];

        $query1="select username from login where id='$id'";
        $query2="select email from restaurants where id='$id'";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        closeDatabaseConnection();

        $rs1=$result1[0];
        $username=$rs1["username"];

        $email=$result2[0]["email"];
    }
    else
    {
        header("Location:login.php");
    }




?>

<html>

    <head>
        <title>Settings</title>
        <link rel="stylesheet" type="text/css" href="css/settings.css">
        <script src="js/settings.js"></script>
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


        <section class="usersettings-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- FORMS TO MAKE SOME CHANGES -->

        <section class="usersettings-page-section-2">



            <!-- CHANGE USERNAME -->
            <div class="form-container">
                <h1>
                    change Username
                    <div class="successful-message">
                        <?php
                            if(isset($_GET["usernameChangeSuccess"]))
                            {
                                if($_GET["usernameChangeSuccess"] == 1)
                                {
                                    echo "username changed successfully !";
                                }
                            }
                        ?>
                    </div>
                </h1>
                <form name="usernameForm" action="control_logic/changeusername.php" method="post">
                    <table>

                        <?php
                            if(isset($_GET["UsernameError"]))
                            {
                                $errorUsername=$_GET["UsernameError"];
                            }
                        ?>

                        <!-- USERNAME -->
                        <tr><td class="label">Username:</td></tr>
                        <tr><td><input id="newusername" type="text" name="newusername" onkeyup="validateUsername()" value="<?php echo $username; ?>"></td></tr>
                        <tr><td class="caution-messages">Only Letters & Numbers</td></tr>
                        <tr><td id="errorUsername" class="error-messages"><?php echo $emptyUsername.$errorUsername; ?></td></tr>

                        <tr><td align="right">
                        <input class="button button-accent" type="submit" value="Save">
                        </td></tr>

                    </table>
                </form>
            </div>



            <!-- CHANGE PASSWORD -->
            <div class="form-container">
                <h1>
                    change password
                    <div class="successful-message">
                        <?php
                            if(isset($_GET["passwordChangeSuccess"]))
                            {
                                if($_GET["passwordChangeSuccess"] == 1)
                                {
                                    echo "password changed successfully !";
                                }
                            }
                        ?>
                    </div>
                </h1>
                <form name="passwordForm" action="control_logic/changepassword.php" method="post" onsubmit="return validatePassword()">
                    <table>

                        <?php
                            if(isset($_GET["PasswordError"]))
                            {
                                $errorPassword=$_GET["PasswordError"];
                                $errorRepeatPassword=$_GET["PasswordError"];
                            }
                        ?>

                        <!-- PASSWORD -->
                        <tr><td class="label">New Password:</td></tr>
                        <tr><td><input id="password" type="password" name="password" value="<?php echo $password; ?>"></td></tr>
                        <tr><td class="caution-messages">Only Letters & Numbers</td></tr>
                        <tr><td id="errorPassword" class="error-messages"><?php echo $emptyPassword.$errorPassword; ?></td></tr>

                        <!-- REPEAT PASSWORD -->
                        <tr><td class="label">Repeat New Password:</td></tr>
                        <tr><td><input id="repeatPassword" type="password" name="repeatPassword" value="<?php echo $repeatPassword; ?>"></td></tr>
                        <tr><td class="caution-messages">Only Letters & Numbers</td></tr>
                        <tr><td id="errorRepeatPassword" class="error-messages"><?php echo $emptyRepeatPassword.$errorRepeatPassword; ?></td></tr>

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Save"></td></tr>

                    </table>
                </form>
            </div>




            <!-- CHANGE EMAIL -->
            <div class="form-container" style="margin-bottom: 0;">
                <h1>
                    change email
                    <div class="successful-message">
                        <?php
                            if(isset($_GET["emailChangeSuccess"]))
                            {
                                if($_GET["emailChangeSuccess"] == 1)
                                {
                                    echo "e-mail changed successfully !";
                                }
                            }
                        ?>
                    </div>
                </h1>
                <form name="emailForm" action="control_logic/changeemail.php" method="post">
                    <table>

                        <?php
                            if(isset($_GET["EmailError"]))
                            {
                                $errorEmail=$_GET["EmailError"];
                            }
                        ?>

                        <!-- EMAIL -->
                        <tr><td class="label">Email:</td></tr>
                        <tr><td><input type="text" name="newemail" value="<?php echo $email; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyEmail.$errorEmail; ?></td></tr>

                        <tr><td align="right">
                        <input class="button button-accent" type="submit" value="Save">
                        </td></tr>

                    </table>
                </form>
            </div>



        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
