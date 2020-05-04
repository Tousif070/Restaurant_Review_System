<?php

    require "dbconnect.php";

    $userID=$postText="";
    $photoID=$restaurantID=-1;
    $uploadDirectory="../images/store/";
    $retrieveDirectory="images/store/";
    $width=$height=0;
    $lastID=0;

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $userID=$_COOKIE["userID"];

        $postText=$_POST["postText"];
        echo $postText;

        if(is_uploaded_file($_FILES["photoInput"]["tmp_name"]))
        {
            $photoCheck=getimagesize($_FILES["photoInput"]["tmp_name"]);

            if($photoCheck != null)
            {
                $photo=$_FILES["photoInput"]["name"];

                // GENERATING UNIQUE FILE NAME
                createDatabaseConnection();
                $query="insert into unique_file_id (status) values ('occupied')";
                executeQuery($query);
                $lastID=getLastID();
                closeDatabaseConnection();

                $photo=$lastID.$photo;
                $uploadDirectory=$uploadDirectory.$photo;
                $retrieveDirectory=$retrieveDirectory.$photo;
                $photoType=strtolower(pathinfo($photo, PATHINFO_EXTENSION));

                if(!($photoType == "png" || $photoType == "jpg" || $photoType == "jpeg"))
                {
                    header("Location:../userposts.php?errormsg=Allowed Image Formats - png, jpg, jpeg !&postText=$postText");
                    exit;
                }

                $width=$photoCheck[0];
                $height=$photoCheck[1];

                // SCALING THE UPLOADED IMAGE TO THE DESIRED DIMENSION
                $diff=0;
                $rate=0;
                $desiredWidth=400;
                if($width > $desiredWidth)
                {
                    $diff=$width - $desiredWidth;
                    $rate=$diff / $width;
                    $width=$desiredWidth;
                    $diff=$height * $rate;
                    $height=$height - $diff;
                }
                else if($width < $desiredWidth)
                {
                    $diff=$desiredWidth - $width;
                    $rate=$diff / $width;
                    $width=$desiredWidth;
                    $diff=$height * $rate;
                    $height=$height + $diff;
                }

                if(move_uploaded_file($_FILES["photoInput"]["tmp_name"], $uploadDirectory))
                {
                    createDatabaseConnection();
                    $query="insert into photos (account_id, storage_location, width, height) values ($userID, '$retrieveDirectory', $width, $height)";
                    executeQuery($query);
                    $photoID=getLastID();
                    closeDatabaseConnection();
                }
                else
                {
                    header("Location:../userposts.php?errormsg=Error Occurred ! Image Could Not Be Uploaded !&postText=$postText");
                    exit;
                }
            }
            else
            {
                header("Location:../userposts.php?errormsg=Please Upload An Image File !&postText=$postText");
                exit;
            }

        }

        if(!empty($_POST["searchedRestaurantID"]))
        {
            $restaurantID=$_POST["searchedRestaurantID"];
        }

        $finalQuery="";

        if($photoID != -1 && $restaurantID != -1)
        {
            $finalQuery="insert into posts (account_id, post_text, photo_id, restaurant_id) values ($userID, '$postText', $photoID, $restaurantID)";
        }
        else if($photoID != -1 && $restaurantID == -1)
        {
            $finalQuery="insert into posts (account_id, post_text, photo_id, restaurant_id) values ($userID, '$postText', $photoID, null)";
        }
        else if($photoID == -1 && $restaurantID != -1)
        {
            $finalQuery="insert into posts (account_id, post_text, photo_id, restaurant_id) values ($userID, '$postText', null, $restaurantID)";
        }
        else if($photoID == -1 && $restaurantID == -1)
        {
            $finalQuery="insert into posts (account_id, post_text, photo_id, restaurant_id) values ($userID, '$postText', null, null)";
        }

        createDatabaseConnection();
        executeQuery($finalQuery);
        closeDatabaseConnection();

        header("Location:../userposts.php?successMsg=your post has been created !");
    }
?>
