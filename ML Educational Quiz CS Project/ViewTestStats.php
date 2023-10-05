<!doctype html>
<html lang="en">
  <head>
    <?php require_once 'Header.php'; ?>

    <title>School Quiz - Quiz Results</title>
  </head>
  <body>
    <?php require_once 'LoggedNavbar.php' ?>
    <div class="container-fluid" style="padding: 5vh 5vw;">

        <?php
            require_once 'connect.php';
            require_once 'Functions.php';

            // Get test stats
            $TestID = $_GET['TestID'];
            $totalRight = getTotal($conn, $TestID, 'right');
            $totalWrong = getTotal($conn, $TestID, 'wrong');
            $totalQuestions = getTotal($conn, $TestID, 'all');

            $rightPercent = ($totalRight / $totalQuestions) * 100;
            $wrongPercent = ($totalWrong / $totalQuestions) * 100;
        ?>

        <div class="row">
            <div class="col">
                <h1 class="display-1 text-center">Quiz #<?php echo $TestID; ?></h1>
                <p class="lead text-center">Congratulations on finishing the quiz! Here are your results:</p>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <!-- Overall test data -->
                        <h3 style="margin-bottom: 3vh;">Overall</h3>
                        <div class="d-flex justify-content-between mb-2">
                            <!-- Right questions / Total questions -->
                            <span><?php echo $totalRight; ?> / <?php echo $totalQuestions; ?></span>
                            <!-- Percentage Correct -->
                            <span style="font-weight: bold;"><?php echo number_format($rightPercent, 0, '.', ','); ?>%</span>
                        </div>
                        <div class="progress mb-3">
                            <!-- Progress bars to visualise questions right and wrong -->
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $rightPercent; ?>%" aria-valuenow="<?php echo $rightPercent; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $totalRight ?> right</div>
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?php echo $wrongPercent; ?>%" aria-valuenow="<?php echo $wrongPercent; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $totalWrong ?> wrong</div>
                        </div>

                        <h4 style="margin-bottom: 3vh;">Questions:</h4>

                        <ul class="list-group">

                            <?php 

                                // List all questions from history table using test id
                                listHistoryQuestions($conn, $TestID);

                            ?>
                        </ul>

                    </div>
                </div>
            </div>
            
            <div class="col">
                
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 style="margin-bottom: 3vh;">Topics</h3>
                        <!-- Display statistics for all topics in this test -->
                        <?php listHistoryTopics($conn, $TestID); ?>

                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h3 style="margin-bottom: 3vh;">Best Topics</h3>
                        <!-- List top 3 topics -->
                        <?php getBestOrWorstTopics($conn, $TestID, 'best'); ?>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom: 3vh;">Worst Topics</h3>
                        <!-- List bottom 3 topics -->
                        <?php getBestOrWorstTopics($conn, $TestID, 'worst'); ?>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php require_once 'Footer.php'; ?>
  </body>
</html>
