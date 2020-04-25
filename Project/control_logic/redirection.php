<?php

    if(isset($_COOKIE["userID"]))
    {
        header("Location:../accounthome.php");
    }
    else if($_COOKIE["restaurantID"])
    {
        header("Location:../accounthome2.php");
    }

?>
