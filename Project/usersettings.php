<?php

    require "dbconnect.php";

    $id=$username=$email=$password=$repeatPassword=$contactNumber="";
    $emptyUsername=$emptyEmail=$emptyPassword=$emptyRepeatPassword=$emptyContactNumber="";
    $errorUsername=$errorEmail=$errorPassword=$errorRepeatPassword=$errorContactNumber="";

    if(isset($_COOKIE["userID"]))
    {
        $id=$_COOKIE["userID"];

        $query1="select username from login where id='$id'";
        $query2="select email, contact_number from general_users where id='$id'";

        createDatabaseConnection();
        $result1=executeAndGetQuery($query1);
        $result2=executeAndGetQuery($query2);
        closeDatabaseConnection();

        $rs1=$result1[0];
        $username=$rs1["username"];

        $rs2=$result2[0];
        $email=$rs2["email"];
        $contactNumber=ltrim($rs2["contact_number"], "+880");
    }
    else
    {
        header("Location:login.php");
    }




?>

<html>

    <head>
        <title>Settings</title>
        <link rel="stylesheet" type="text/css" href="css/usersettings.css">

        <script>
            function validatePassword()
            {
                var validation=true;
                /*var password=document.getElementById("password");
                var repeatPassword=document.getElementById("repeatPassword");
                */
                var password=document.forms["passwordForm"]["password"];
                var repeatPassword=document.forms["passwordForm"]["repeatPassword"];

                if(password.value == "")
                {
                    document.getElementById("errorPassword").innerHTML="Please Enter Your New Password !";
                    validation=false;
                }
                else if(password.value.length < 8)
                {
                    document.getElementById("errorPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
                    validation=false;
                }
                else
                {
                    document.getElementById("errorPassword").innerHTML="";
                }

                if(repeatPassword.value == "")
                {
                    document.getElementById("errorRepeatPassword").innerHTML="Please Enter Your Password Again !";
                    validation=false;
                }
                else if(repeatPassword.value.length < 8)
                {
                    document.getElementById("errorRepeatPassword").innerHTML="Password Should Be Minimum Of 8 Characters !";
                    validation=false;
                }
                else if(password.value != repeatPassword.value)
                {
                    document.getElementById("errorRepeatPassword").innerHTML="Passwords Do Not Match !";
                    validation=false;
                }
                else
                {
                    document.getElementById("errorRepeatPassword").innerHTML="";
                }

                return validation;
            }
        </script>

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


        <section class="usersettings-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- SIGN UP FORM FOR THE USERS -->

        <section class="usersettings-page-section-2">

            <!--
            <div class="form-container">
                <h1>
                    change username & email
                </h1>
                <form action="" method="post">
                    <table>-->

                        <!-- USERNAME --><!--
                        <tr><td class="label">Username:</td></tr>
                        <tr><td><input type="text" name="username" value="<?php echo $username; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyUsername.$errorUsername; ?></td></tr>-->

                        <!-- EMAIL --><!--
                        <tr><td class="label">Email:</td></tr>
                        <tr><td><input type="text" name="email" value="<?php echo $email; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyEmail.$errorEmail; ?></td></tr>

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Save"></td></tr>

                    </table>
                </form>
            </div>-->

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
                <form name="passwordForm" action="changepassword.php" method="post" onsubmit="return validatePassword()">
                    <table>

                        <!-- PASSWORD -->
                        <tr><td class="label">New Password:</td></tr>
                        <tr><td><input id="password" type="password" name="password" value="<?php echo $password; ?>"></td></tr>
                        <tr><td id="errorPassword" class="error-messages"><?php echo $emptyPassword.$errorPassword; ?></td></tr>

                        <!-- REPEAT PASSWORD -->
                        <tr><td class="label">Repeat New Password:</td></tr>
                        <tr><td><input id="repeatPassword" type="password" name="repeatPassword" value="<?php echo $repeatPassword; ?>"></td></tr>
                        <tr><td id="errorRepeatPassword" class="error-messages"><?php echo $emptyRepeatPassword.$errorRepeatPassword; ?></td></tr>

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Save"></td></tr>

                    </table>
                </form>
            </div>

            <!--
            <div class="form-container">
                <h1>
                    change contact number
                </h1>
                <form action="" method="post">
                    <table>-->

                        <!-- CONTACT NUMBER --><!--
                        <tr><td class="label">Contact Number:</td></tr>
                        <tr><td><input type="text" value="+880" style="width: 50px;" disabled> - <input type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" style="width: 60%;"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyContactNumber.$errorContactNumber; ?></td></tr>

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Save"></td></tr>

                    </table>
                </form>
            </div>-->

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
