<?php

    // One file for all functions

    // Check the username exists
    function checkUsernameExists($conn, $username){
        $sql = "SELECT * FROM student WHERE Username = '$username'";

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                // User exists
                return true;
            }else{
                // Nothing found in database
                return false;
            }
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }

    // Insert a new student object into the database
    function insertStudent($conn, $FirstName, $LastName, $Username, $Password){
        $sql = "INSERT INTO student(FirstName, LastName, Username, Password) VALUES('$FirstName', '$LastName', '$Username', '$Password')";

        if(mysqli_query($conn, $sql)){
            return true;
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }

    // Get the student name using the student id of logged in student
    function getStudentName($conn, $StudentID){
        $sql = "SELECT * FROM student WHERE StudentID = $StudentID";

        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_array($result);
            return $row['FirstName'] . ' ' . $row['LastName'];
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Get a question using the provided difficulty and topic
    function getQuestion($conn, $Difficulty, $TopicID){
        
        // If the topic id is set then the question should be of that topic
        if($TopicID == ''){
            $sql = "SELECT * FROM question, topic WHERE topic.TopicID = question.TopicID AND Difficulty = $Difficulty";
        }else{
            $sql = "SELECT * FROM question, topic WHERE topic.TopicID = question.TopicID AND Difficulty = $Difficulty AND topic.TopicID = $TopicID";
        }

        
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                
                $row = mysqli_fetch_array($result);
                
                // Return the question from the database
                return $row;
                
            }else{
                // If no questions exist then change the difficulty
                
                // Get max and min values of difficulty in database
                $sql = "SELECT MAX(Difficulty) as max, MIN(Difficulty) as min FROM question";
                if($result = mysqli_query($conn, $sql)){
                    
                    $row = mysqli_fetch_array($result);
                    $max = $row['max'];
                    $min = $row['min'];
                    
                    // echo "Difficulty: " . $Difficulty;
                    // echo "max: " . $max;
                    // echo "min: " . $min;

                    if($Difficulty < $max && $Difficulty > $min){           // If difficulty is in the range then increment it
                        // echo "difficulty is good";
                        return getQuestion($conn, $Difficulty+1, $TopicID);
                    }else if($Difficulty <= $min){                          // If difficulty is the minimum then increment it
                        // echo "difficulty is lower or equal to min";
                        return getQuestion($conn, $Difficulty+1, $TopicID);
                    }else if($Difficulty >= $max){
                        // echo "difficulty is higher or equal to max";
                        return getQuestion($conn, $Difficulty-1, $TopicID); // If difficulty is the maximum then decrement it
                    }

                }else{
                    echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
                }

            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }

    // Check student answer was correct
    function checkAnswer($conn, $QuestionID, $StudentAnswer){

        // Find the question in the database
        $sql = "SELECT * FROM question WHERE QuestionID = $QuestionID";

        if($result = mysqli_query($conn, $sql)){

            $row = mysqli_fetch_array($result);

            // Compare students answer with question's correct answer
            if(strcmp($row['Answer'], $StudentAnswer) >= 0){            // Students answer == Correct answer in this case
                return true;
            }else{
                return false;
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }

    // Display the question to the user
    function displayQuestion($conn, $Difficulty, $QuestionCount, $TestID, $TopicID){
        // Get a question from the database
        $question = getQuestion($conn, $Difficulty, $TopicID);

        // Store answers into an array
        $answers = array();
        array_push($answers, $question['WrongAnswerA']);
        array_push($answers, $question['WrongAnswerB']);
        array_push($answers, $question['WrongAnswerC']);
        array_push($answers, $question['Answer']);
        
        // Shuffle array to randomize answer sequence
        shuffle($answers);
        
        // Output form with action pointing back to same page
        echo "
        <form method='post' action='StartTest.php?TopicID=$TopicID&QuestionCount=$QuestionCount&Difficulty=$Difficulty&PreviousQuestionID=$question[QuestionID]&TestID=$TestID'>
            <div class='card' style='margin-bottom: 3vh;'>
                <div class='card-body'>
                    <div style='display: flex; justify-content: space-between;'>
                        <h5>$question[Question]</h5>
                        <p style='margin-right: 1vw;' class='text-muted'>$question[TopicName]</p>
                    </div>
                    <ul class='list-group' style='margin-top: 3vh;'>
                        <select class='form-select' name='StudentAnswer'>";
    
        // Echo out answers as dropdown
        foreach($answers as $answer){
            echo "<option value='$answer'>$answer</option>";
        }
                        
        echo "			</select>
                    </ul>
                    <div style='display: flex; flex-direction: row-reverse;'>
                        <input type='submit' value='Next' class='btn btn-primary' style='margin-top: 3vh;'>
                    </div>
                </div>
            </div>
        </form>
        ";
    }

    // Update total marks in the database
    function updateTotalMarks($conn, $TestID, $value){
        // Get current marks
        $sql = "SELECT * FROM test WHERE TestID = $TestID";
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_array($result);
            // If the field TotalMarks is empty then set the $CurrentMarks to 0
            $row['TotalMarks'] == NULL ? $CurrentMarks = 0 : $CurrentMarks = $row['TotalMarks'];
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

        // Check if adding the new value to the current value would result in a negative value - if it does then set the value to 0
        $CurrentMarks + $value < 0 ? $NewMarks = 0 : $NewMarks = ( $CurrentMarks + $value );

        // Update test with new marks
        $sql = "UPDATE test SET TotalMarks = $NewMarks WHERE TestID = $TestID";

        if(!mysqli_query($conn, $sql)){
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }else{
            mysqli_query($conn, $sql);
        }

    }

    // Add the question and its mark to the history table
    function addToHistory($conn, $QuestionID, $TestID, $Mark){
        $sql = "INSERT INTO history(TestID, QuestionID, Mark) VALUES ($TestID, $QuestionID, $Mark)";

        if(mysqli_query($conn, $sql)){
            return true;
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Get the total marks for the test
    function getTotal($conn, $TestID, $type){
        $sql = "SELECT * FROM history WHERE TestID = $TestID";

        // Initialise to 0
        $total = 0;

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){

                // Create an array to store the marks
                $marks = array();

                while($row = mysqli_fetch_array($result)){
                    // Add marks to $total variable then push mark values to the array
                    $total = $total + $row['Mark'];
                    array_push($marks, $row['Mark']);
                }

                // Check if we need correct marks, incorrect marks or total marks
                /**
                 * 
                 * $total: Total correct marks
                 * count($marks): Total marks
                 * count($marks) - $total: Total incorrect marks
                 * 
                 */
                if($type == 'right'){
                    return $total;
                }else if($type == 'all'){
                    return count($marks);
                }else{
                    return count($marks) - $total;
                }

            }else{
                return 0;
            }

        }else{  
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Display the questions shown in the test
    function listHistoryQuestions($conn, $TestID){
        $sql = "
            SELECT 
                * 
            FROM 
                history, 
                question, 
                topic 
            WHERE 
                question.TopicID = topic.TopicID AND 
                question.QuestionID = history.QuestionID AND 
                TestID = $TestID";

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_array($result)){
                    if($row['Mark'] == 1){                  // If the question was correct (mark has a value of 1) then make the theme green
                        echo "
                        <li class='list-group-item list-group-item-success d-flex justify-content-between'>
                            <div class='left-text'>
                                <p style='font-weight: bold; font-size: 1.2em; margin-bottom: 0; margin-top: 1vh; width: 70%;'>
                                    " . $row['Question'] . "
                                </p>
                                <p style='font-size: 0.8em; margin-top: 0; opacity: 0.8;'>
                                    " .$row['TopicName']. "
                                </p>
                            </div>
                            <div>
                                <ion-icon name='checkmark-outline' style='height: 100%; display: block; font-size: 2em; margin-right: 5vw;'></ion-icon>  
                            </div>
                        </li>
                        ";
                    }else{                                  // If the answer was wrong (mark has a value of 0) then make the theme red
                        echo "
                        <li class='list-group-item list-group-item-danger d-flex justify-content-between'>
                            <div class='left-text'>
                                <p style='font-weight: bold; font-size: 1.2em; margin-bottom: 0; margin-top: 1vh; width: 70%;'>
                                    " . $row['Question'] . "
                                </p>
                                <p style='font-size: 0.8em; margin-top: 0; opacity: 0.8;'>
                                    " .$row['TopicName']. "
                                </p>
                            </div>
                            <div>
                                <ion-icon name='close-outline' style='height: 100%; display: block; font-size: 2em; margin-right: 5vw;'></ion-icon>  
                            </div>
                        </li>
                        ";
                    }
                }

            }else{
                echo "
                    <li class='list-group-item'>No questions found.</li>
                ";
            }
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // List all the topic data from the test
    function listHistoryTopics($conn, $TestID){
        /*
            For each topic we need:
            - TopicName (topic)
            - TotalRight (history)
            - TotalWrong (history)
        */

        $sql = "
            SELECT
                TotalQuestions,
                TotalMarks,
                TopicName,
                (TotalMarks / TotalQuestions) * 100 AS Percent
            FROM
                (
                    SELECT 
                        COUNT(question.QuestionID) AS TotalQuestions, 
                        SUM(Mark) AS TotalMarks, 
                        TopicName 
                    FROM 
                        history, 
                        question, 
                        topic 
                    WHERE 
                        history.QuestionID = question.QuestionID AND 
                        question.TopicID = topic.TopicID AND 
                        TestID = $TestID 
                    GROUP BY 
                        TopicName
                ) AS S1
            ORDER BY
                Percent
        ";

        if($result = mysqli_query($conn, $sql)){
            
            if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_array($result)){

                    $rightPercent = $row['Percent'];
                    $wrongPercent = 100 - $rightPercent;

                    $rightPercent = number_format($rightPercent, 0, '.', ',');
                    $wrongPercent = number_format($wrongPercent, 0, '.', ',');

                    $totalWrong = $row['TotalQuestions'] - $row['TotalMarks'];

                    echo "
                        <div class='topic-row mb-3'>
                            <h5 class='text-center'>" .$row['TopicName']. "</h5>
                            <div class='d-flex justify-content-between mb-2'>
                                <span>" .$row['TotalMarks']. " / " .$row['TotalQuestions']. "</span>
                                <span style='font-weight: bold;'>" .$rightPercent. "%</span>
                            </div>
                            <div class='progress'>
                                <div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: " .$rightPercent. "%' aria-valuenow='" .$rightPercent. "' aria-valuemin='0' aria-valuemax='100'>" .$row['TotalMarks']. " right</div>
                                <div class='progress-bar progress-bar-striped bg-danger' role='progressbar' style='width: " .$wrongPercent. "%' aria-valuenow='" .$wrongPercent. "' aria-valuemin='0' aria-valuemax='100'>" .$totalWrong. " wrong</div>
                            </div>
                        </div>
                    ";

                }

            }else{
                echo "<p class='lead'>Weird....I couldn't find any topics...What did you do to the test?</p>";
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Depending on the parameter, get the top 3 topics or the bottom 3 topics
    function getBestOrWorstTopics($conn, $TestID, $Type){
        // For top 3 order the percent descending and opposite for bottom 3
        $Type == 'best' ? $orderBy = 'Percent DESC' : $orderBy = 'Percent';

        $sql = "
            SELECT
                TotalQuestions,
                TotalMarks,
                TopicName,
                TopicID, 
                (TotalMarks / TotalQuestions) * 100 AS Percent
            FROM
                (
                    SELECT 
                    COUNT(question.QuestionID) AS TotalQuestions, 
                    SUM(Mark) AS TotalMarks, 
                    TopicName,
                    topic.TopicID AS TopicID
                FROM 
                    history, 
                    question, 
                    topic 
                WHERE 
                    history.QuestionID = question.QuestionID AND 
                    question.TopicID = topic.TopicID AND 
                    TestID = $TestID 
                GROUP BY 
                    TopicName
                ) AS S1
            ORDER BY
                $orderBy
        ";

        echo "
            <table class='table table-bordered text-center'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Topic</th>
                        <th>Percentage</th>
                        <th>Practice</th>
                    </tr>
                </thead>
                <tbody>
        ";
        
        if($result = mysqli_query($conn, $sql)){
            
            if(mysqli_num_rows($result) > 0){

                $count = 0;

                while($row = mysqli_fetch_array($result)){
                    $count = $count + 1;

                    $rightPercent = $row['Percent'];
                    $wrongPercent = 100 - $rightPercent;

                    $rightPercent = number_format($rightPercent, 0, '.', ',');
                    $wrongPercent = number_format($wrongPercent, 0, '.', ',');

                    $totalWrong = $row['TotalQuestions'] - $row['TotalMarks'];

                    echo "
                    <tr>
                        <td>$count</td>
                        <td>" .$row['TopicName']. "</td>
                        <td>" .$rightPercent. "%</td>
                        <td style='text-align: center;'>
                            <a href='StartTest.php?QuestionCount=0&Difficulty=0&TopicID=" .$row['TopicID']. "'>
                                <ion-icon name='play-outline'></ion-icon>
                            </a>
                        </td>
                    </tr>
                    ";

                }

            }else{
                echo "<p class='lead'>Weird....I couldn't find any topics...What did you do to the test?</p>";
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

        echo "
                </tbody>
            </table>
        ";
    }

    // Update the score in the testtopic table in the database
    function updateTestTopic($conn, $TestID, $QuestionID, $Score){
        
        /*
            If test and topic in table exists
                Get score in table
                If database score + score < 0 
                    set database score to 0
                Else
                    set database score to database score + score
            Else
                If score < 0
                    insert testid, topicid and 0
                else
                    insert testid, topicid and score
        */  

        // Get topic id from question
        $TopicID = getTopicIdFromQuestion($conn, $QuestionID);

        $sql = "SELECT * FROM testtopic WHERE TestID = $TestID AND TopicID = $TopicID";

        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){

                $row = mysqli_fetch_array($result);
                $dbScore = $row['Score'];
                $TestTopicID = $row['TestTopicID'];

                if($dbScore + $Score < 0){
                    $newScore = 0;
                }else{
                    $newScore = $dbScore + $Score;
                }

                $sql = "UPDATE testtopic SET Score = $newScore WHERE TestTopicID = $TestTopicID";

                if(!mysqli_query($conn, $sql)){
                    echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
                }else{
                    mysqli_query($conn, $sql);
                }

            }else{
                $Score < 0 ? $newScore = 0 : $newScore = $Score;

                $sql = "INSERT INTO testtopic(TestID, TopicID, Score) VALUES ($TestID, $TopicID, $newScore)";

                if(!mysqli_query($conn, $sql)){
                    echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
                }else{
                    mysqli_query($conn, $sql);
                }
            }
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
        
    }
    
    // Get the topic id from the question
    function getTopicIdFromQuestion($conn, $QuestionID){

        $sql = "SELECT * FROM question WHERE QuestionID = $QuestionID";
        
        if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_array($result);
            return $row['TopicID'];
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }

    // Create entries in the testtopic table for the newly started test
    function initialiseTestTopic($conn, $TestID){
        $sql = "SELECT * FROM topic";
        if($result = mysqli_query($conn, $sql)){
            while($row = mysqli_fetch_array($result)){

                // For each topic id insert into testtopic with topic id and test id
                $sql = "INSERT INTO testtopic(TestID, TopicID, Score) VALUES($TestID, " .$row['TopicID']. ", 0)";

                if(!mysqli_query($conn, $sql)){
                    echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
                }else{
                    mysqli_query($conn, $sql);
                }

            }
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Insert a new test into the database
    function insertNewTest($conn){
        $sql = "INSERT INTO test(TestDate, StartTime, StudentID) VALUES('" .date("Y-m-d"). "', '" .date("h:i"). "', ". $_SESSION['StudentID'] . ")";
	
        if(!mysqli_query($conn, $sql)){
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }else{
            mysqli_query($conn, $sql);
            return mysqli_insert_id($conn);
        }
    }

    // Check if this is the first test for the student
    function isFirstTest($conn, $StudentID){
        $sql = "SELECT * FROM test WHERE StudentID = $StudentID";
        
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                return false;
            }else{
                return true;
            }
        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Set the end time in the test table
    function addEndTime($conn, $TestID){
        $sql = "UPDATE test SET EndTime = '" .date("h:i"). "' WHERE TestID = $TestID";
	
        if(!mysqli_query($conn, $sql)){
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }else{
            mysqli_query($conn, $sql);
        }
    }

    // Get all students as a leaderboard
    function displayLeaderboard($conn, $orderby){
        /*
            Get every single student's highest test mark
        */

        $sql = "
            SELECT 
                student.StudentID, 
                FirstName, 
                LastName, 
                MAX(TotalMarks) AS TopMark 
            FROM 
                test, 
                student 
            WHERE 
                test.StudentID = student.StudentID AND 
                TotalMarks IS NOT NULL AND
                EndTime IS NOT NULL
            GROUP BY 
                student.StudentID 
            ORDER BY 
                $orderby";

        if($result = mysqli_query($conn, $sql)){

            $count = 0;
            while($row = mysqli_fetch_array($result)){
                $count = $count + 1;

                echo "
                <tr>
                    <th scope='row'>$count</th>
                    <td>" .$row['FirstName']. " " .$row['LastName']. "</td>
                    <td>" .$row['TopMark']. "</td>
                </tr>
                ";

            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }

    // List a link to start a test on a specific topic
    function listTopicQuizes($conn){
        // For each topic list a link
        $sql = "SELECT * FROM topic";

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_array($result)){

                    echo "
                        <a href='StartTest.php?QuestionCount=0&Difficulty=0&TopicID=" .$row['TopicID']. "' class='list-group-item list-group-item-action'>" .$row['TopicName']. " Quiz</a>
                    ";

                }

            }else{
                echo "<li class='list-group-item>Looks like there are no topics...</li>";
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // List all tests and their scores
    function listTestHistory($conn){
        // Query for getting score of the tests
        $sql = "
            SELECT 
                TestID, 
                (Marks / TotalQuestions) * 100 AS Percent, 
                Marks,
                TestDate
            FROM (
                SELECT 
                    test.TestID AS TestID, 
                    COUNT(QuestionID) AS TotalQuestions, 
                    SUM(Mark) AS Marks,
                    TestDate
                FROM 
                    history, 
                    test, 
                    student 
                WHERE 
                    test.StudentID = student.StudentID AND 
                    history.TestID = test.TestID AND 
                    student.StudentID = " .$_SESSION['StudentID']. "
                GROUP BY 
                    test.TestID
            ) AS S1
            ORDER BY 
                TestID ASC
        ";

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_array($result)){

                    $percent = $row['Percent'];
                    // Color code the text depending on the score
                    /**
                     * 0 - 25: Red
                     * 25 - 75: Orange
                     * 75 - 100: Green
                     */
                    if($percent > 0 && $percent < 25){
                        $text = 'danger';
                    }else if($percent > 25 && $percent < 75){
                        $text = 'warning';
                    }else{
                        $text = 'success';
                    }

                    $date = date_create($row['TestDate']);

                    echo "
                    <a href='ViewTestStats.php?TestID=" .$row['TestID']. "' class='list-group-item list-group-item-action d-flex justify-content-between'>
                        <div>
                            <span style='font-weight: bold;'>Quiz #" .$row['TestID']. "</span>
                            <span style='font-size: 0.7em; color: grey;'>" .date_format($date,"d M Y"). "</span>
                        </div>
                        <span class='text-$text'>" .number_format($percent, 0, '.', ','). "%</span>
                    </a>
                    ";

                }

            }else{
                echo "<li class='list-group-item'>No quizes found...</li>";
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Output the data for the Google charts library
    function renderGraphData($conn){
        // For each test we need test id and percentage
        $sql = "
            SELECT 
                TestID, 
                (Marks / TotalQuestions) * 100 AS Percent, 
                Marks 
            FROM (
                SELECT 
                    test.TestID AS TestID, 
                    COUNT(QuestionID) AS TotalQuestions, 
                    SUM(Mark) AS Marks 
                FROM 
                    history, 
                    test, 
                    student 
                WHERE 
                    test.StudentID = student.StudentID AND 
                    history.TestID = test.TestID AND 
                    student.StudentID = " .$_SESSION['StudentID']. "
                GROUP BY 
                    test.TestID
            ) AS S1
            ORDER BY 
                TestID ASC
        ";

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_array($result)){

                    /**
                     * Output in the following format:
                     * [ 'Quiz #', 'Percentage' ],
                     * [ 'Quiz #', 'Percentage' ],
                     * [ 'Quiz #', 'Percentage' ]
                     */

                    echo "
                        ['Quiz #" .$row['TestID']. "', " .number_format($row['Percent'], 0, '.', ','). "],
                    ";

                }

            }else{
                echo "<li class='list-group-item'>No quizes found...</li>";
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // Get the highest, lowest and average scores for the test depending on the parameter
    /**
     * type can have 3 values:
     * "highest percent": Highest score
     * "lowest percent": Lowest score
     * "average percent": Average score
     */
    function getTestStat($conn, $type){
        $sql = "
            SELECT 
                MAX(Percent) AS Highest, 
                MIN(Percent) AS Lowest, 
                AVG(Percent) AS Average 
            FROM (
                SELECT 
                    TestID, 
                    (Marks / TotalQuestions) * 100 AS Percent, 
                    Marks 
                FROM ( 
                    SELECT 
                        test.TestID AS TestID, 
                        COUNT(QuestionID) AS TotalQuestions, 
                        SUM(Mark) AS Marks 
                    FROM 
                        history, 
                        test, 
                        student 
                    WHERE 
                        test.StudentID = student.StudentID AND 
                        history.TestID = test.TestID AND 
                        student.StudentID = " .$_SESSION['StudentID']. " 
                    GROUP BY 
                        test.TestID 
                ) 
                AS S1 
                ORDER BY 
                    TestID ASC
            ) 
            AS S2
        ";

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);

                if($type == 'average percent'){
                    echo number_format($row['Average'], 0, '.', ',');
                }else if($type == 'highest percent'){
                    echo number_format($row['Highest'], 0, '.', ',');
                }else{
                    echo number_format($row['Lowest'], 0, '.', ',');
                }
                
            }else{
                return 0;
            }


        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }
    }

    // List the overall scores of each topic
    function listTopicStats($conn){

        $sql = "
            SELECT 
                (Marks / Total) * 100 AS Percentage,
                TopicID,
                TopicName
            FROM
                (SELECT 
                    topic.TopicID, 
                    TopicName, 
                    SUM(Mark) AS Marks, 
                    COUNT(HistoryID) AS Total 
                FROM 
                    history, 
                    question, 
                    test, 
                    topic 
                WHERE 
                    history.QuestionID = question.QuestionID AND 
                    history.TestID = test.TestID AND 
                    question.TopicID = topic.TopicID AND 
                    StudentID = " .$_SESSION['StudentID']. " 
                GROUP BY 
                    topic.TopicID
                ) AS S1
        ";

        if($result = mysqli_query($conn, $sql)){

            if(mysqli_num_rows($result) > 0){

                while($row = mysqli_fetch_array($result)){
                    
                    $percent = $row['Percentage'];
                    // Color code scores depending on values
                    /**
                     * 0 - 25: Red
                     * 25 - 75: Orange
                     * 75 - 100: Green
                     */
                    if($percent >= 0 && $percent < 25){
                        $text = 'danger';
                    }else if($percent > 25 && $percent < 75){
                        $text = 'warning';
                    }else{
                        $text = 'success';
                    }

                    echo "
                        <tr>
                            <td>" .$row['TopicName']. "</td>
                            <td class='text-$text'>" .number_format($percent, 0, '.', ','). "</td>
                        </tr>
                    ";
                }

            }else{
                echo "
                    <tr>
                        <td colspan='2'>No topic data found...</td>
                    </tr>
                ";
            }

        }else{
            echo "Error on line " . __LINE__ . ": <br>" . mysqli_error($conn) . "<br> sql: <br>" .$sql. "<br> ";
        }

    }
?>