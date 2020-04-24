<?php

    require "control_logic/dbconnect.php";

    function isNumber($value)
    {
        $number=array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $flag=0;
        for($i=0; $i<strlen($value); $i++)
        {
            for($j=0; $j<count($number); $j++)
            {
                if($value[$i] == $number[$j])
                {
                    $flag=1;
                    break;
                }
                else
                {
                    $flag=0;
                }
            }
            if(!$flag)
            {
                break;
            }
        }
        return $flag;
    }

    $firstName=$lastName=$username=$password=$repeatPassword=$gender=$day=$month=$year=$email=$location=$otherLocation=$finalLocation=$contactNumber="";
    $emptyFirstName=$emptyLastName=$emptyUsername=$emptyPassword=$emptyRepeatPassword=$emptyGender=$emptyDate=$emptyEmail=$emptyLocation=$emptyContactNumber="";
    $errorUsername=$errorPassword=$errorRepeatPassword=$errorEmail=$errorContactNumber="";
    $submissionStatus=1;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $firstName=$_POST["firstName"];

        if(empty($firstName))
        {
            $emptyFirstName="Please Enter Your First Name !";
            $submissionStatus=0;
        }
        else
        {
            $firstName=filter_var($firstName, FILTER_SANITIZE_STRING);
        }

        $lastName=$_POST["lastName"];

        if(empty($lastName))
        {
            $emptyLastName="Please Enter Your Last Name !";
            $submissionStatus=0;
        }
        else
        {
            $lastName=filter_var($lastName, FILTER_SANITIZE_STRING);
        }

        $username=$_POST["username"];

        if(empty($username))
        {
            $emptyUsername="Please Enter A Username !";
            $submissionStatus=0;
        }
        else
        {
            $username=filter_var($username, FILTER_SANITIZE_STRING);
        }

        $password=$_POST["password"];

        if(empty($password))
        {
            $emptyPassword="Please Enter A Password !";
            $submissionStatus=0;
        }
        else
        {
            $password=filter_var($password, FILTER_SANITIZE_STRING);

            if(strlen($password) < 8)
            {
                $errorPassword="Password Should Be Minimum Of 8 Characters !";
                $submissionStatus=0;
            }
        }

        $repeatPassword=$_POST["repeatPassword"];

        if(empty($repeatPassword))
        {
            $emptyRepeatPassword="Please Enter The Password Again !";
            $submissionStatus=0;
        }
        else
        {
            $repeatPassword=filter_var($repeatPassword, FILTER_SANITIZE_STRING);

            if(strlen($repeatPassword) < 8)
            {
                $errorRepeatPassword="Password Should Be Minimum Of 8 Characters !";
                $submissionStatus=0;
            }
            else if($password != $repeatPassword)
            {
                $errorRepeatPassword="Passwords Do Not Match !";
                $submissionStatus=0;
            }
        }

        if(isset($_POST["gender"]))
        {
            $gender=$_POST["gender"];
        }
        else
        {
            $emptyGender="Please Provide Your Gender !";
            $submissionStatus=0;
        }

        if(isset($_POST["day"]) && isset($_POST["month"]) && isset($_POST["year"]))
        {
            $day=$_POST["day"];
            $month=$_POST["month"];
            $year=$_POST["year"];
        }
        else
        {
            $emptyDate="Please Select Your Date Of Birth !";
            $submissionStatus=0;
        }

        $email=$_POST["email"];

        if(empty($email))
        {
            $emptyEmail="Please Enter Your Email !";
            $submissionStatus=0;
        }
        else
        {
            $email=filter_var($email, FILTER_SANITIZE_EMAIL);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errorEmail="Please Enter A Valid Email !";
                $submissionStatus=0;
            }
        }

        if(isset($_POST["location"]))
        {
            $location=$_POST["location"];
            $finalLocation=$location;

            if($location == "Other")
            {
                $otherLocation=$_POST["otherLocation"];

                if(empty($otherLocation))
                {
                    $emptyLocation="Please Enter The Name Of Your Location !";
                    $submissionStatus=0;
                }
                else
                {
                    $finalLocation=filter_var($otherLocation, FILTER_SANITIZE_STRING);
                }
            }
        }
        else
        {
            $emptyLocation="Please Enter The Name Of Your Location !";
            $submissionStatus=0;
        }

        /*$contactNumber=$_POST["contactNumber"];

        if(empty($contactNumber))
        {
            $emptyContactNumber="Please Enter Your Contact Number !";
            $submissionStatus=0;
        }
        else
        {
            $contactNumber=filter_var($contactNumber, FILTER_SANITIZE_STRING);

            if(strlen($contactNumber) == 10)
            {
                if(!isNumber($contactNumber))
                {
                    $errorContactNumber="Please Enter A Valid Contact Number !";
                    $submissionStatus=0;
                }
            }
            else
            {
                $errorContactNumber="Please Enter A Valid Contact Number !";
                $submissionStatus=0;
            }
        }
        */

        if($submissionStatus)
        {
            $dateOfBirth=$year . "-" . $month . "-" . $day;
            //$finalContactNumber="+880" . $contactNumber;
            $usertype=1;

            $query="select username from login where username='$username'";

            createDatabaseConnection();
            $result=executeAndGetQuery($query);

            if(count($result) == 0)
            {
                $password=md5($password); // PASSWORD ENCRYPTION USING MD5 (MESSAGE DIGEST ALGORITHM - 5)

                $query="insert into login (username, password, usertype) values ('$username', '$password', '$usertype')";

                executeQuery($query);

                $lastID=getLastID();

                $query="insert into general_users (id, firstname, lastname, gender, date_of_birth, email, location, profile_photo_id) values ('$lastID', '$firstName', '$lastName', '$gender', '$dateOfBirth', '$email', '$finalLocation', null)";

                executeQuery($query);

                closeDatabaseConnection();

                header("Location:login.php?successMsg=1&username=$username");
            }
            else
            {
                $errorUsername="Username Already Exists !";
                closeDatabaseConnection();
            }


        }


    }

?>

<html>

    <head>
        <title>Sign Up For Users</title>
        <link rel="stylesheet" type="text/css" href="css/usersignup.css">
        <script src="js/usersignup.js"></script>
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


        <section class="user-signup-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- SIGN UP FORM FOR THE USERS -->

        <section class="user-signup-page-section-2">

            <div class="form-container">
                <h1>
                    Create your user account
                </h1>
                <form action="" method="post">
                    <table>

                        <!-- FIRST NAME -->
                        <tr><td class="label">First Name:</td></tr>
                        <tr><td><input type="text" name="firstName" value="<?php echo $firstName; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyFirstName; ?></td></tr>

                        <!-- LAST NAME -->
                        <tr><td class="label">Last Name:</td></tr>
                        <tr><td><input type="text" name="lastName" value="<?php echo $lastName; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyLastName; ?></td></tr>

                        <!-- USERNAME -->
                        <tr><td class="label">Username:</td></tr>
                        <tr><td><input id="username" type="text" name="username" onkeyup="checkUsername()" value="<?php echo $username; ?>"></td></tr>
                        <tr><td id="errorUsername" class="error-messages"><?php echo $emptyUsername.$errorUsername; ?></td></tr>

                        <!-- PASSWORD -->
                        <tr><td class="label">Password:</td></tr>
                        <tr><td><input id="password" type="password" name="password" onkeyup="checkPassword()" value="<?php echo $password; ?>"></td></tr>
                        <tr><td id="errorPassword" class="error-messages"><?php echo $emptyPassword.$errorPassword; ?></td></tr>

                        <!-- REPEAT PASSWORD -->
                        <tr><td class="label">Repeat Password:</td></tr>
                        <tr><td><input id="repeatPassword" type="password" name="repeatPassword" onkeyup="checkRepeatPassword()" value="<?php echo $repeatPassword; ?>"></td></tr>
                        <tr><td id="errorRepeatPassword" class="error-messages"><?php echo $emptyRepeatPassword.$errorRepeatPassword; ?></td></tr>

                        <!-- GENDER -->
                        <tr><td class="label">Gender:</td></tr>
                        <tr><td>
                            <select name="gender" style="width: 30%;">
                                <option selected disabled></option>
                                <option <?php if(isset($gender) && $gender == "Male") {echo "selected";} ?> >Male</option>
                                <option <?php if(isset($gender) && $gender == "Female") {echo "selected";} ?> >Female</option>
                                <option <?php if(isset($gender) && $gender == "Other") {echo "selected";} ?> >Other</option>
                            </select>
                        </td></tr>
                        <tr><td class="error-messages"><?php echo $emptyGender; ?></td></tr>

                        <!-- DATE OF BIRTH -->
                        <tr><td class="label">Date Of Birth:</td></tr>
                        <tr><td>

                            Day:
                            <select name="day" style="width: 20%;">
                                <option selected disabled></option>
                                <?php
                                    for($i=1; $i<=31; $i++)
                                    {
                                        if($i == $day)
                                        {
                                            echo "<option selected>$i</option>";
                                        }
                                        else
                                        {
                                            echo "<option>$i</option>";
                                        }
                                    }
                                ?>
                            </select>

                            Month:
                            <select name="month" style="width: 20%;">
                                <option selected disabled></option>
                                <?php
                                    for($i=1; $i<=12; $i++)
                                    {
                                        if($i == $month)
                                        {
                                            echo "<option selected>$i</option>";
                                        }
                                        else
                                        {
                                            echo "<option>$i</option>";
                                        }
                                    }
                                ?>
                            </select>

                            Year:
                            <select name="year" style="width: 20%;">
                                <option selected disabled></option>
                                <?php
                                    for($i=1990; $i<=2020;$i++)
                                    {
                                        if($i == $year)
                                        {
                                            echo "<option selected>$i</option>";
                                        }
                                        else
                                        {
                                            echo "<option>$i</option>";
                                        }
                                    }
                                ?>
                            </select>

                        </td></tr>
                        <tr><td class="error-messages"><?php echo $emptyDate; ?></td></tr>

                        <!-- EMAIL -->
                        <tr><td class="label">Email:</td></tr>
                        <tr><td><input type="text" name="email" value="<?php echo $email; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyEmail.$errorEmail; ?></td></tr>

                        <!-- LOCATION -->
                        <tr><td class="label">Name Of Your Location:</td></tr>
                        <tr><td>
                            <select name="location" style="width: 30%;">
                                <option selected disabled></option>
                                <option <?php if(isset($location) && $location == "Khilgaon") {echo "selected";} ?> >Khilgaon</option>
                                <option <?php if(isset($location) && $location == "Baily Road") {echo "selected";} ?> >Baily Road</option>
                                <option <?php if(isset($location) && $location == "Dhanmondi") {echo "selected";} ?> >Dhanmondi</option>
                                <option <?php if(isset($location) && $location == "Shyamoli") {echo "selected";} ?> >Shyamoli</option>
                                <option <?php if(isset($location) && $location == "Mirpur") {echo "selected";} ?> >Mirpur</option>
                                <option <?php if(isset($location) && $location == "Banani") {echo "selected";} ?> >Banani</option>
                                <option <?php if(isset($location) && $location == "Gulshan-1") {echo "selected";} ?> >Gulshan-1</option>
                                <option <?php if(isset($location) && $location == "Gulshan-2") {echo "selected";} ?> >Gulshan-2</option>
                                <option <?php if(isset($location) && $location == "Bashundhara") {echo "selected";} ?> >Bashundhara</option>
                                <option <?php if(isset($location) && $location == "Uttara") {echo "selected";} ?> >Uttara</option>
                                <option <?php if(isset($location) && $location == "Other") {echo "selected";} ?> >Other</option>
                            </select>
                            Other: <input type="text" name="otherLocation" value="<?php echo $otherLocation; ?>" style="width: 30%;">
                        </td></tr>
                        <tr><td class="error-messages"><?php echo $emptyLocation; ?></td></tr>

                        <!-- CONTACT NUMBER
                        <tr><td class="label">Contact Number:</td></tr>
                        <tr><td><input type="text" value="+880" style="width: 50px;" disabled> - <input type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" style="width: 50%;"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyContactNumber.$errorContactNumber; ?></td></tr>
                        -->

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Submit"></td></tr>

                    </table>
                </form>
            </div>

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
