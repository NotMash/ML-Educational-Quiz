<!doctype html>
<html lang="en">
	<head>
		<?php require_once 'Header.php'; ?>

		<title>School Quiz - Initial Quiz</title>
	</head>
	<body>
		
		<div class="container-fluid" style="padding: 5vh 5vw;">
			
			<?php

				require_once 'connect.php';
				require_once 'Functions.php';
				session_start();

				// Check if the test is topic specific
				if(isset( $_GET['TopicID'] )){
					$TopicID = $_GET['TopicID'];
				}else{
					$TopicID = '';
				}

				// Check if this the first test
				if(isFirstTest($conn, $_SESSION['StudentID'])){
					echo "
						<div class='row'>
							<div class='col'>
								<h1>Your First Quiz</h1>
								<p class='lead'>Welcome to your first test. No pressure - there is no need to get everything right straight away. Good luck!</p>
							</div>
						</div>
					";
				}else{
					echo "
					<div class='row'>
						<div class='col'>
							<a href='Home.php' class='btn btn-primary mb-3' style='width: 10vw;'>Home</a>
							<p class='lead'>Good luck!</p>
						</div>
					</div>
					";
				}

			?>


			<div class="row">
				<div class="col">
					
					<?php

						/*
							Check if questionCount is get and if its value is 0 - currently showing first question
								Insert new test with start time and date
									Insert all topics into testtopic
								Show first question
									Increment question count
									Redirect to FirstTest.php?QuestionCount&Difficulty++
							Else if questionCount > 0 and questioncount < 30
								If last question was right
									Increase difficulty
								else
									decrease difficulty
								Update total marks in test table
								Insert into history
								Update score in testtopic
							Else we are on 30 - finish the test
								Check if last question was right
								Update total marks in test table
								Insert into history
								Update score in testtopic
								Redirect to ViewTestStat.php
						*/

						// Check if questionCount is get and if its value is 0 - currently showing first question
						if(isset( $_GET['QuestionCount'] ) && isset( $_GET['Difficulty'] ) ){

							$questionCount = $_GET['QuestionCount'];
							$Difficulty = $_GET['Difficulty'];

							if($questionCount == 0){							// Show first question

								// Insert new test with start time and date
								$TestID = insertNewTest($conn);
									
								// Insert all topics into testtopic
								initialiseTestTopic($conn, $TestID);
								
								// Show first question
								displayQuestion($conn, $Difficulty + 1, $questionCount + 1, $TestID, $TopicID);

							}else if($questionCount > 0 && $questionCount < 30){

								/*
									If last question was right
										Increase difficulty
									else
										decrease difficulty
									Update total marks in test table
									Insert into history
									Update score in testtopic
									Show next question
								*/

								$studentAnswer = $_POST['StudentAnswer'];
								$TestID = $_GET['TestID'];
								$lastQuestionID = $_GET['PreviousQuestionID'];

								// If last question was right
								if(checkAnswer( $conn, $lastQuestionID, $studentAnswer )){
									// Increase difficulty
									$Difficulty = $Difficulty + 1;

									$mark = 1;
									
									// If last question was wrong
								}else{
									// Decrease difficulty
									$Difficulty - 1 == 0 ? $Difficulty == 0 : $Difficulty = $Difficulty - 1;
									
									$mark = 0;
								}

								// Update total marks in test table
								updateTotalMarks($conn, $TestID, $mark);
								
								// insert into history
								addToHistory($conn, $lastQuestionID, $TestID, $mark);
								
								// Update score in testtopic
								updateTestTopic($conn, $TestID, $lastQuestionID, $mark);
								
								// Show next question
								displayQuestion($conn, $Difficulty, $questionCount + 1, $TestID, $TopicID,);

							}else{

								/*
									Check if last question was right
									Update total marks in test table
									Insert into history
									Update score in testtopic
									Add endtime to test table
									Redirect to ViewTestStat.php
								*/

								$studentAnswer = $_POST['StudentAnswer'];
								$TestID = $_GET['TestID'];
								$lastQuestionID = $_GET['PreviousQuestionID'];

								if(checkAnswer( $conn, $lastQuestionID, $studentAnswer )){
									$mark = 1;
								}else{
									$mark = 0;
								}

								// Update total marks in test table
								updateTotalMarks($conn, $TestID, $mark);

								// insert into history
								addToHistory($conn, $lastQuestionID, $TestID, $mark);

								// Update score in testtopic
								updateTestTopic($conn, $TestID, $lastQuestionID, $mark);

								// Add endtime to test
								addEndTime($conn, $TestID);

								echo "<script>window.location = 'ViewTestStats.php?TestID=$TestID';</script>";

							}

						}else{
							echo "Either questionCount or Difficulty isn't GOTTEN.";
						}

					?>

				</div>
			</div>

		</div>


		<?php require_once 'Footer.php'; ?>
	</body>
</html>
