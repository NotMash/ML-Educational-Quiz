<!doctype html>
<html lang="en">
  <head>
    <?php require_once 'Header.php'; ?>

    <title>School Quiz - Register</title>
  </head>
  <body>
    <!-- Register page - create account to log in to the system -->
    <div class="container-fluid d-flex justify-content-center" style="height: 80vh; margin-top: 20vh;">
        <div class="col-sm-4 col-md-4 col-mg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Register</h5>
                    <!-- Send all form data to RegisterScript.php -->
                    <form method="post" action="RegisterScript.php">      
                        <div class="input-group">
                            <p class="text-danger">
                            
                            <!-- Display error if sent to this page -->
                                <?php

                                    if(isset($_GET['Error'])){
                                        echo $_GET['Error'];
                                    }

                                ?>

                            </p>
                        </div>
                        <!-- First name input -->
                        <div class="input-group mb-3">
                            <input type="text" required autofocus class="form-control" placeholder="First Name" aria-label="Username" name="FirstName" aria-describedby="basic-addon1">
                        </div>

                        <!-- Last name input -->
                        <div class="input-group mb-3">
                            <input type="text" required class="form-control" placeholder="Last Name" aria-label="Username" name="LastName" aria-describedby="basic-addon1">
                        </div>

                        <!-- Username input -->
                        <div class="input-group mb-3">
                            <input type="text" required class="form-control" placeholder="Username" aria-label="Username" name="Username" aria-describedby="basic-addon1">
                        </div>

                        <!-- Password input -->
                        <div class="input-group mb-3">
                            <input type="password" required class="form-control" placeholder="Password" aria-label="Username" name="Password" aria-describedby="basic-addon1" id="PasswordInput">
                        </div>

                        <!-- Confirm Password input -->
                        <div class="input-group mb-3">
                            <input type="password" required id="ConfirmPasswordInput" class="form-control" placeholder="Confirm Password" aria-label="Username" name="ConfirmPassword" aria-describedby="basic-addon1" onkeyup="CheckPassword()">
                        </div>

                        <!-- Error message if passwords do not match -->
                        <div class="input-group">
                            <p id="ConfirmPasswordError" style="font-size: 0.8em; padding-left: 0vw; display: none;" class="text-danger">Passwords do not match.</p>
                        </div>

                        <div class="input-group mb-3">
                            <input id="RegisterButton" type="submit" value="Register" class="btn btn-primary" style="width: 100%;">
                        </div>
                        <!-- Link to login page if user already has an account -->
                        <div class="input-group">
                            Already have an account? <a style="margin-left: 3px;" href="Login.php">Log in here.</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function CheckPassword(){
            // Function for checking if value of password input is the same as the confirm password input
            
            let PassInput = document.getElementById('PasswordInput');
            let ConfirmPassInput = document.getElementById('ConfirmPasswordInput');
            let Error = document.getElementById('ConfirmPasswordError');
            let RegisterButton = document.getElementById('RegisterButton');

            if(ConfirmPassInput.value != PassInput.value){
                ConfirmPassInput.className = "form-control border border-danger";
                Error.style.display = "block";
                RegisterButton.disabled = true;
            }else{
                ConfirmPassInput.className = "form-control border border-success";
                Error.style.display = "none";
                RegisterButton.disabled = false;
            }
        }
    </script>

    <?php require_once 'Footer.php'; ?>
  </body>
</html>
