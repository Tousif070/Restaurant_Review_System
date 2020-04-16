<?php

    setcookie("userID", "", time() - 36500);

    header("Location:login.php");

?>
