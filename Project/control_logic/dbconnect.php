<?php

    $servername="localhost";
    $dbUsername="root";
    $dbPassword="";
    $dbName="eat_and_rate";

    /*$servername="remotemysql.com";
    $dbUsername="6MNIfyOxEA";
    $dbPassword="eNZHsnf4pb";
    $dbName="6MNIfyOxEA";
    */

    $connection=0;

    function createDatabaseConnection()
    {
        global $servername, $dbUsername, $dbPassword, $dbName, $connection;

        $connection=mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);
        if(!$connection)
        {
            die("Connection Failed: " . mysqli_connect_error());
        }
    }

    function executeQuery($query)
    {
        global $connection;

        if(!mysqli_query($connection, $query))
        {
            echo "Query Not Executed: " . mysqli_error($connection);
        }
    }

    function getLastID()
    {
        global $connection;

        return mysqli_insert_id($connection);
    }

    function executeAndGetQuery($query)
    {
        global $connection;

        $data=array();
        $resultset=mysqli_query($connection, $query);
        if(mysqli_num_rows($resultset))
        {
            while($row=mysqli_fetch_assoc($resultset))
            {
                /*$entity=array();
                foreach($row as $k => $v)
                {
                    $entity[$k]=$row[$k];
                }
                $data[]=$entity;
                */
                $data[]=$row;
            }
        }
        return $data;
    }

    function closeDatabaseConnection()
    {
        global $connection;

        mysqli_close($connection);
    }

?>
