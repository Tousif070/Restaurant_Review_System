<?php

    if(isset($_COOKIE["userID"]))
    {
        setcookie("userID", "", time() - 36500, "/");
    }

    header("Location:../login.php");

?>
