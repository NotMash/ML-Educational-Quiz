<?php

    require_once 'connect.php';
    require_once 'Functions.php';
    session_start();

    // Store all values from form
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    // Check if username already exists in the database
    if(!checkUsernameExists($conn, $Username)){

        // Username doesn't exist - insert into database
        if(insertStudent($conn, $FirstName, $LastName, $Username, $Password)){
            $_SESSION['StudentID'] = mysqli_insert_id($conn);
            echo "<script>window.location = 'Home.php';</script>";
        }

    }else{
        // Username exists - redirect with error
        echo "<script>window.location = 'Register.php?Error=Username already exists.';</script>";
    }

?>