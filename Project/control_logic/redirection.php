<?php

    if(isset($_GET["destination"]))
    {
        if($_GET["destination"] == 1)
        {
            // FOR GOING TO ACCOUNTHOME
            if(isset($_COOKIE["userID"]))
            {
                header("Location:../accounthome.php");
            }
            else if($_COOKIE["restaurantID"])
            {
                header("Location:../accounthome2.php");
            }
        }
        else if($_GET["destination"] == 2)
        {
            // FOR GOING TO POSTS
            if(isset($_COOKIE["userID"]))
            {
                header("Location:../userposts.php");
            }
            else if($_COOKIE["restaurantID"])
            {
                header("Location:../restaurantposts.php");
            }
        }
        else if($_GET["destination"] == 3)
        {
            // FOR GOING TO PROFILE

        }
    }

?>
