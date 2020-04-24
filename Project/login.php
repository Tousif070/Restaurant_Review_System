<?php

    if(isset($_COOKIE["userID"]))
    {
        header("Location:accounthome.php");
    }

    require "control_logic/dbconnect.php";

    $username=$password="";
    $emptyUsername=$emptyPassword="";
    $errorUsername=$errorPassword="";
    $loginStatus=1;

    // THIS MESSAGE IS SHOWN DURING LOGIN *AFTER* COMPLETING A NEW SIGN UP
    $successMsg="Account created successfully !<br>Log in to your new account";

    // AUTOMATICALLY SETTING THE USERNAME DURING LOGIN AFTER COMPLETING A NEW SIGN UP
    if(isset($_GET["username"]))
    {
        $username=$_GET["username"];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username=$_POST["username"];

        if(empty($username))
        {
            $emptyUsername="Username Is Empty !";
            $loginStatus=0;
        }
        else
        {
            $username=filter_var($username, FILTER_SANITIZE_STRING);
        }

        $password=$_POST["password"];

        if(empty($password))
        {
            $emptyPassword="Password Is Empty !";
            $loginStatus=0;
        }
        else
        {
            $password=filter_var($password, FILTER_SANITIZE_STRING);
        }

        if($loginStatus)
        {
            $query="select id, password, usertype from login where username='$username'";

            createDatabaseConnection();
            $result=executeAndGetQuery($query);
            closeDatabaseConnection();

            if(count($result) > 0)
            {
                $rs=$result[0];

                $password=md5($password);

                if($password == $rs["password"])
                {
                    if($rs["usertype"] == 1)
                    {
                        setcookie("userID", $rs["id"], time() + 36000, "/");
                        header("Location:accounthome.php");
                    }
                    else if($rs["usertype"] == 2)
                    {
                        // REDIRECT TO THE RESTAURANT ACCOUNT
                    }
                }
                else
                {
                    $errorPassword="Invalid Password !";
                    $password="";
                }
            }
            else
            {
                $errorUsername="Invalid Username !";
            }


        }


    }

?>

<html>

    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
    </head>

    <body>

        <header>
            <a class="logo" href="homepage.php">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="100" width="420">
            </a>
            <nav>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="">About</a></li>
                </ul>
            </nav>
        </header>


        <section class="login-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- Login Form -->

        <section class="login-page-section-2">

            <h1 class="successful-message">
                <?php
                    if(isset($_GET["successMsg"]))
                    {
                        if($_GET["successMsg"] == 1)
                        {
                            echo $successMsg;
                        }
                    }
                ?>
            </h1>

            <div class="form-container">

                <h1>
                    Login
                </h1>

                <form action="" method="post">
                    <table>

                        <!-- USERNAME -->
                        <tr><td class="label">Username:</td></tr>
                        <tr><td><input type="text" name="username" value="<?php echo $username; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyUsername.$errorUsername; ?></td></tr>

                        <!-- PASSWORD -->
                        <tr><td class="label">Password:</td></tr>
                        <tr><td><input type="password" name="password" value="<?php echo $password; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyPassword.$errorPassword; ?></td></tr>

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Login"></td></tr>

                    </table>
                </form>
            </div>

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
