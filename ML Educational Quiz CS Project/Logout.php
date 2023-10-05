<?php
    // Destroy all session variables and redirect to Login.php

    session_start();

    session_destroy();

    echo "<script>window.location = 'Login.php';</script>";

?>