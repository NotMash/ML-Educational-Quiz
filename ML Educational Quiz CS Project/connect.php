<?php
    // Connect to the database on localhost
    $conn = mysqli_connect('localhost', 'root', '', 'schoolquiz');

    if(!$conn){
        echo "Error " . mysqli_connect_error();
    }
?>