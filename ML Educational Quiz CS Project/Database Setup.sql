-- CREATE DATABASE

CREATE DATABASE SchoolQuiz;

USE SchoolQuiz;

-- CREATE TABLE STATEMENTS

CREATE TABLE Admin(
		AdminID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		Username VARCHAR(255) NOT NULL,
		Password VARCHAR(255) NOT NULL
);

CREATE TABLE Student(
		StudentID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		FirstName VARCHAR(255) NOT NULL,
		LastName VARCHAR(255) NOT NULL,
		Username VARCHAR(255) NOT NULL,
		Password VARCHAR(255) NOT NULL
);

CREATE TABLE Test(
		TestID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		TestDate DATE,
		StartTime TIME(0),
		EndTime TIME(0),
		TotalMarks INT,
		StudentID INT,
		FOREIGN KEY (StudentID) REFERENCES Student(StudentID)
);

CREATE TABLE Topic(
		TopicID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		TopicName VARCHAR(255)
);

CREATE TABLE TestTopic(
		TestTopicID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		TestID INT, 
		TopicID INT,
		Score INT,
		FOREIGN KEY (TestID) REFERENCES Test(TestID),
		FOREIGN KEY (TopicID) REFERENCES Topic(TopicID)
);

CREATE TABLE Question(
		QuestionID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		Question LONGTEXT NOT NULL,
		WrongAnswerA LONGTEXT NOT NULL,
		WrongAnswerB LONGTEXT NOT NULL,
		WrongAnswerC LONGTEXT NOT NULL,
		Answer LONGTEXT NOT NULL,
		Difficulty INT NOT NULL,
		TopicID INT,
		FOREIGN KEY (TopicID) REFERENCES Topic(TopicID)
);

CREATE TABLE History(
	HistoryID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	TestID INT,
	QuestionID INT,
	Mark INT,
	FOREIGN KEY (TestID) REFERENCES Test(TestID),
	FOREIGN KEY (QuestionID) REFERENCES Question(QuestionID)
);

INSERT INTO admin(username, password) VALUES('admin', 'admin');

INSERT INTO student(FirstName, LastName, Username, Password) VALUES
(
	'Bob',
	'The Builder',
	'bob',
	'bob'
),
(
	'Robbie',
	'Mendoza',
	'rob',
	'rob'
),
(
	'Berat',
	'Oneil',
	'berat',
	'berat'
);

INSERT INTO topic(TopicName) VALUES('Algebra'), ('Calculus'), ('Trigonometry');

INSERT INTO question(Question, WrongAnswerA, WrongAnswerB, WrongAnswerC, Answer, Difficulty) VALUES
(
	'Easy Question 1',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	1
),
(
	'Easy Question 2',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	2
),
(
	'Easy Question 3',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	3
),
(
	'Easy Question 4',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	4
),
(
	'Medium Question 1',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	5
),
(
	'Medium Question 2',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	6
),
(
	'Medium Question 3',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	7
),
(
	'Medium Question 4',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	8
),
(
	'Medium Question 5',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	9
),
(
	'Hard Question 1',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	10
),
(
	'Hard Question 2',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	11
),
(
	'Hard Question 3',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	12
),
(
	'Hard Question 4',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	13
),
(
	'Hard Question 5',
	'Wrong Answer A',
	'Wrong Answer B',
	'Wrong Answer C',
	'Correct Answer',
	14
);