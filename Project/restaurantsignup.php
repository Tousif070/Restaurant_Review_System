<?php

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

    $restaurantName=$username=$password=$repeatPassword=$branchName=$otherBranch=$address=$day=$month=$year=$email=$contactNumber=$about="";
    $emptyRestaurantName=$emptyUsername=$emptyPassword=$emptyRepeatPassword=$emptyBranchName=$emptyAddress=$emptyDate=$emptyEmail=$emptyContactNumber=$emptyAbout="";
    $errorPassword=$errorRepeatPassword=$errorEmail=$errorContactNumber="";
    $signupSuccessMsg="Account created successfully !";
    $submissionStatus=1;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $restaurantName=$_POST["restaurantName"];

        if(empty($restaurantName))
        {
            $emptyRestaurantName="Please Enter The Name Of The Restaurant !";
            $submissionStatus=0;
        }
        else
        {
            $restaurantName=filter_var($restaurantName, FILTER_SANITIZE_STRING);
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

        if(isset($_POST["branchName"]))
        {
            $branchName=$_POST["branchName"];

            if($branchName == "Other")
            {
                $otherBranch=$_POST["otherBranch"];

                if(empty($otherBranch))
                {
                    $emptyBranchName="Please Provide The Branch Name !";
                    $submissionStatus=0;
                }
                else
                {
                    $otherBranch=filter_var($otherBranch, FILTER_SANITIZE_STRING);
                }
            }
        }
        else
        {
            $emptyBranchName="Please Provide The Branch Name !";
            $submissionStatus=0;
        }

        $address=$_POST["address"];

        if(empty($address))
        {
            $emptyAddress="Please Enter The Address !";
            $submissionStatus=0;
        }
        else
        {
            $address=filter_var($address, FILTER_SANITIZE_STRING);
        }

        if(isset($_POST["day"]) && isset($_POST["month"]) && isset($_POST["year"]))
        {
            $day=$_POST["day"];
            $month=$_POST["month"];
            $year=$_POST["year"];
        }
        else
        {
            $emptyDate="Please Select The Date Of Establishment !";
            $submissionStatus=0;
        }

        $email=$_POST["email"];

        if(empty($email))
        {
            $emptyEmail="Please Provide An Email !";
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

        $contactNumber=$_POST["contactNumber"];

        if(empty($contactNumber))
        {
            $emptyContactNumber="Please Enter A Contact Number !";
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

        $about=$_POST["about"];

        if(empty($about))
        {
            $emptyAbout="Please Give A Short Description About The Restaurant !";
            $submissionStatus=0;
        }
        else
        {
            $about=filter_var($about, FILTER_SANITIZE_STRING);
        }

        if($submissionStatus == 1)
        {
            $submissionStatus=2;
        }


    }

?>

<html>

    <head>
        <title>Sign Up For Restaurants</title>
        <link rel="stylesheet" type="text/css" href="css/restaurantsignup.css">
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


        <section class="restaurant-signup-page-section-1">
            <!-- THIS SECTION OVERLAPS WITH THE HEADER AND ACTS AS A BACKGROUND -->
            <!-- THE HEADER FLOATS OVER THIS SECTION -->
        </section>



        <!-- SIGN UP FORM FOR THE RESTAURANTS -->

        <section class="restaurant-signup-page-section-2">

            <h1 class="successful-message">
                <?php
                    if($submissionStatus == 2)
                    {
                        echo $signupSuccessMsg;
                        $restaurantName=$username=$password=$repeatPassword=$branchName=$otherBranch=$address=$day=$month=$year=$email=$contactNumber=$about="";
                    }
                ?>
            </h1>

            <div class="form-container">
                <h1>
                    Create your restaurant account
                </h1>
                <form action="" method="post">
                    <table>

                        <!-- NAME OF THE RESTAURANT -->
                        <tr><td class="label">Name Of Your Restaurant:</td></tr>
                        <tr><td><input type="text" name="restaurantName" value="<?php echo $restaurantName; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyRestaurantName; ?></td></tr>

                        <!-- USERNAME -->
                        <tr><td class="label">Username:</td></tr>
                        <tr><td><input type="text" name="username" value="<?php echo $username; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyUsername; ?></td></tr>

                        <!-- PASSWORD -->
                        <tr><td class="label">Password:</td></tr>
                        <tr><td><input type="password" name="password" value="<?php echo $password; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyPassword.$errorPassword; ?></td></tr>

                        <!-- REPEAT PASSWORD -->
                        <tr><td class="label">Repeat Password:</td></tr>
                        <tr><td><input type="password" name="repeatPassword" value="<?php echo $repeatPassword; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyRepeatPassword.$errorRepeatPassword; ?></td></tr>

                        <!-- BRANCH NAME -->
                        <tr><td class="label">Branch Name:</td></tr>
                        <tr><td>
                            <select name="branchName" style="width: 30%;">
                                <option selected disabled></option>
                                <option <?php if(isset($branchName) && $branchName == "Khilgaon") {echo "selected";} ?> >Khilgaon</option>
                                <option <?php if(isset($branchName) && $branchName == "Baily Road") {echo "selected";} ?> >Baily Road</option>
                                <option <?php if(isset($branchName) && $branchName == "Dhanmondi") {echo "selected";} ?> >Dhanmondi</option>
                                <option <?php if(isset($branchName) && $branchName == "Shyamoli") {echo "selected";} ?> >Shyamoli</option>
                                <option <?php if(isset($branchName) && $branchName == "Mirpur") {echo "selected";} ?> >Mirpur</option>
                                <option <?php if(isset($branchName) && $branchName == "Banani") {echo "selected";} ?> >Banani</option>
                                <option <?php if(isset($branchName) && $branchName == "Gulshan-1") {echo "selected";} ?> >Gulshan-1</option>
                                <option <?php if(isset($branchName) && $branchName == "Gulshan-2") {echo "selected";} ?> >Gulshan-2</option>
                                <option <?php if(isset($branchName) && $branchName == "Bashundhara") {echo "selected";} ?> >Bashundhara</option>
                                <option <?php if(isset($branchName) && $branchName == "Uttara") {echo "selected";} ?> >Uttara</option>
                                <option <?php if(isset($branchName) && $branchName == "Other") {echo "selected";} ?> >Other</option>
                            </select>
                            Other: <input type="text" name="otherBranch" value="<?php echo $otherBranch; ?>" style="width: 30%;">
                        </td></tr>
                        <tr><td class="error-messages"><?php echo $emptyBranchName; ?></td></tr>

                        <!-- ADDRESS -->
                        <tr><td class="label">Address:</td></tr>
                        <tr><td><input type="text" name="address" value="<?php echo $address; ?>"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyAddress; ?></td></tr>

                        <!-- ESTABALISHED IN -->
                        <tr><td class="label">Established In:</td></tr>
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

                        <!-- CONTACT NUMBER -->
                        <tr><td class="label">Contact Number:</td></tr>
                        <tr><td><input type="text" value="+880" style="width: 50px;" disabled> - <input type="text" name="contactNumber" value="<?php echo $contactNumber; ?>" style="width: 50%;"></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyContactNumber.$errorContactNumber; ?></td></tr>

                        <!-- ABOUT YOUR RESTAURANT -->
                        <tr><td class="label">About Your Restaurant:</td></tr>
                        <tr><td><textarea rows="3" name="about"><?php echo $about; ?></textarea></td></tr>
                        <tr><td class="error-messages"><?php echo $emptyAbout; ?></td></tr>

                        <tr><td align="right"><input class="button button-accent" type="submit" value="Submit"></td></tr>

                    </table>
                </form>
            </div>

        </section>

        <!-- FOOTER INCLUDED -->
        <?php include "footer.php" ?>

    </body>

</html>
