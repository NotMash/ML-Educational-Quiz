<?php
    session_start();
    require_once 'connect.php';
    require_once 'Functions.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <?php require_once 'Header.php'; ?>

    <title>School Quiz - Home</title>
  </head>
  <body>
        <?php require_once 'LoggedNavbar.php'; ?>

        <div class="container-fluid">

            <?php
                // Check if student has done their first test
                if(isFirstTest($conn, $_SESSION['StudentID'])){
                    // Display prompt to start first test
                    echo '
                        <div class="row" style="padding: 0vh 2vw;">
                        
                            <div class="col alert alert-success" style="margin-top: 3vh;">
                                <p class="lead text-center">Since this is your first time here why don\'t you take an initial test to see where you need assistance.</p>
                                <div class="d-flex justify-content-center">
                                    <a href="StartTest.php?QuestionCount=0&Difficulty=0" class="btn btn-lg btn-success text-center">Start Quiz</a>
                                </div>
                            </div>
                        
                        </div>
                    ';
                }

            ?>


            <div class="row">
                <div class="col-3 bg-info">
                    
                    <!-- Display topic specific quizes -->
                    <div class="list-group" style="height: 91vh; padding-top: 3vh;">
                        <?php listTopicQuizes($conn); ?>
                    </div>

                </div>

                <div class="col-9" style="padding-top: 3vh;">
                    <!-- Display all quiz statistics -->
                    <?php require_once 'DashboardStats.php' ?>

                </div>
            </div>


        </div>

    <?php require_once 'Footer.php'; ?>
  </body>
</html>
