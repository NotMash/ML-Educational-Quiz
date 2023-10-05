<!doctype html>
<html lang="en">
  <head>
    <?php require_once 'Header.php'; ?>

    <title>School Quiz - Login</title>
  </head>
  <body>
    
    <!-- Login for the system -->

    <div class="container-fluid d-flex justify-content-center" style="height: 80vh; margin-top: 30vh;">
        <div class="col-sm-3 col-md-3 col-mg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Login</h5>
                    
                    <!-- Send all data to LoginScript.php -->
                    <form method="post" action="LoginScript.php">
                        <div class="input-group">
                            <p class="text-danger">
                                <!-- Output any errors here if they are sent -->
                                <?php

                                    if(isset($_GET['Error'])){
                                        echo $_GET['Error'];
                                    }

                                ?>

                            </p>
                        </div>

                        <!-- Username input -->
                        <div class="input-group mb-3">
                            <input type="text" required autofocus class="form-control" placeholder="Username" aria-label="Username" name="Username" aria-describedby="basic-addon1">
                        </div>

                        <!-- Password input -->
                        <div class="input-group mb-3">
                            <input type="password" required class="form-control" placeholder="Password" aria-label="Username" name="Password" aria-describedby="basic-addon1" id="PasswordInput">
                        </div>

                        <div class="input-group mb-3">
                            <input id="LoginButton" type="submit" value="Login" class="btn btn-primary" style="width: 100%;">
                        </div>

                        <!-- Link to register page -->
                        <div class="input-group">
                            Don't have an account? <a style="margin-left: 3px;" href="Register.php">Create one here.</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php require_once 'Footer.php'; ?>
  </body>
</html>
