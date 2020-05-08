<?php

    require "dbconnect.php";

    $id="";

    if(isset($_COOKIE["userID"]))
    {

    }
    else if(isset($_COOKIE["restaurantID"]))
    {
        $id=$_COOKIE["restaurantID"];

        if($_GET["value"] == "about")
        {
            $about=$_GET["text"];

            $query="update restaurants set about='$about' where id=$id";

            createDatabaseConnection();
            executeQuery($query);
            closeDatabaseConnection();

            echo "About Section Updated !";
        }
    }
?>
