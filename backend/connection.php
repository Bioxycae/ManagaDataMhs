<?php

// Connection ke Database
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "managedatamhs";

// Connection Method'
$conn = mysqli_connect($server, $user, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    };

?>