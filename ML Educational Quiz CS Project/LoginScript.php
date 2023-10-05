<?php

    require_once 'connect.php';

    session_start();

    // Store username and password values from form
    $username = $_POST['Username'];
    $password = $_POST['Password'];


    // Check if user exists with username and password
    $sql = "SELECT * FROM student WHERE username = '$username' AND password = '$password'";

    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){

            // Store id in session variable and redirect to Home.php
            $row = mysqli_fetch_array($result);
            $_SESSION['StudentID'] = $row['StudentID'];

            echo "<script>window.location = 'Home.php';</script>";

        }else{
            // Login incorrect - redirect to Login page and send error message
            echo "<script>window.location = 'Login.php?Error=Incorrect username or password.';</script>";
        }
    }else{
        echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
    }

?>