<?php

    require "dbconnect.php";

    $id=$photoID=0;
    $uploadDirectory="../images/store/";
    $retrieveDirectory="images/store/";
    $width=$height=0;
    $lastID=0;

    if(isset($_GET["type"]))
    {
        if($_GET["type"] == 1)
        {
            // FOR UPLOADING PROFILE PHOTO FOR THE GENERAL USERS OR RESTAURANTS

            if(isset($_COOKIE["userID"]))
            {
                $id=$_COOKIE["userID"];

                if(is_uploaded_file($_FILES["profilePhotoInput"]["tmp_name"]))
                {
                    $photoCheck=getimagesize($_FILES["profilePhotoInput"]["tmp_name"]);

                    if($photoCheck != null)
                    {
                        $photo=$_FILES["profilePhotoInput"]["name"];

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
                            header("Location:../userprofile.php?errormsg=Allowed Image Formats - png, jpg, jpeg !");
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

                        if(move_uploaded_file($_FILES["profilePhotoInput"]["tmp_name"], $uploadDirectory))
                        {
                            createDatabaseConnection();
                            $query1="insert into photos (account_id, storage_location, width, height) values ($id, '$retrieveDirectory', $width, $height)";
                            executeQuery($query1);
                            $photoID=getLastID();
                            $query2="update general_users set profile_photo_id=$photoID where id=$id";
                            executeQuery($query2);
                            closeDatabaseConnection();

                            header("Location:../userprofile.php?successMsg=Profile Photo Updated !");
                        }
                        else
                        {
                            header("Location:../userprofile.php?errormsg=Error Occurred ! Image Could Not Be Uploaded !");
                            exit;
                        }
                    }
                    else
                    {
                        header("Location:../userprofile.php?errormsg=Please Upload An Image File !");
                        exit;
                    }
                }
                else
                {
                    header("Location:../userprofile.php?errormsg=No Photo Was Selected !");
                    exit;
                }


            }
            else if(isset($_COOKIE["restaurantID"]))
            {
                $id=$_COOKIE["restaurantID"];

                if(is_uploaded_file($_FILES["profilePhotoInput"]["tmp_name"]))
                {
                    $photoCheck=getimagesize($_FILES["profilePhotoInput"]["tmp_name"]);

                    if($photoCheck != null)
                    {
                        $photo=$_FILES["profilePhotoInput"]["name"];

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
                            header("Location:../restaurantprofile.php?errormsg=Allowed Image Formats - png, jpg, jpeg !");
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

                        if(move_uploaded_file($_FILES["profilePhotoInput"]["tmp_name"], $uploadDirectory))
                        {
                            createDatabaseConnection();
                            $query1="insert into photos (account_id, storage_location, width, height) values ($id, '$retrieveDirectory', $width, $height)";
                            executeQuery($query1);
                            $photoID=getLastID();
                            $query2="update restaurants set profile_photo_id=$photoID where id=$id";
                            executeQuery($query2);
                            closeDatabaseConnection();

                            header("Location:../restaurantprofile.php?successMsg=Profile Photo Updated !");
                        }
                        else
                        {
                            header("Location:../restaurantprofile.php?errormsg=Error Occurred ! Image Could Not Be Uploaded !");
                            exit;
                        }
                    }
                    else
                    {
                        header("Location:../restaurantprofile.php?errormsg=Please Upload An Image File !");
                        exit;
                    }
                }
                else
                {
                    header("Location:../restaurantprofile.php?errormsg=No Photo Was Selected !");
                    exit;
                }


            }
        }
        else if($_GET["type"] == 2)
        {
            // FOR UPLOADING MENU PHOTO FOR THE RESTAURANTS

            if(isset($_COOKIE["restaurantID"]))
            {
                $id=$_COOKIE["restaurantID"];

                if(is_uploaded_file($_FILES["menuPhotoInput"]["tmp_name"]))
                {
                    $photoCheck=getimagesize($_FILES["menuPhotoInput"]["tmp_name"]);

                    if($photoCheck != null)
                    {
                        $photo=$_FILES["menuPhotoInput"]["name"];

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
                            header("Location:../restaurantprofile.php?errormsg2=Allowed Image Formats - png, jpg, jpeg !");
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

                        if(move_uploaded_file($_FILES["menuPhotoInput"]["tmp_name"], $uploadDirectory))
                        {
                            createDatabaseConnection();
                            $query1="insert into photos (account_id, storage_location, width, height) values ($id, '$retrieveDirectory', $width, $height)";
                            executeQuery($query1);
                            $photoID=getLastID();
                            $query2="update restaurants set menu_photo_id=$photoID where id=$id";
                            executeQuery($query2);
                            closeDatabaseConnection();

                            header("Location:../restaurantprofile.php?successMsg2=Restaurant Menu Updated !");
                        }
                        else
                        {
                            header("Location:../restaurantprofile.php?errormsg2=Error Occurred ! Image Could Not Be Uploaded !");
                            exit;
                        }
                    }
                    else
                    {
                        header("Location:../restaurantprofile.php?errormsg2=Please Upload An Image File !");
                        exit;
                    }
                }
                else
                {
                    header("Location:../restaurantprofile.php?errormsg2=No Photo Was Selected !");
                    exit;
                }


            }
        }
    }

?>
