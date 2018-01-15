<?php

/**
 *
 * core config file to connect with database
 */
$servername = "localhost";
$username = "root";
$password = "root";
$database = 'quizzer';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
/**
 * gjej nurmin e pyetjeve
 */
$query = "SELECT COUNT(DISTINCT(`question_number`)) FROM `questions` ";
$result = $conn->query($query);
$row = $result->fetch_row();
$nrPyetjeve = $row[0];


?>
<html>
<head>
    <style>
        .main_title {
            border-bottom: 5px solid rgba(107, 107, 107, 0.47);
            width: 50%;
            margin: 0 auto;
        }

        h2.title {
            font-weight:bold;
            padding: 20px;
        }

        .quiz {
            width: 50%;
            margin: 0 auto;
        }
        .start {
            padding:10px 15px;
            background-color: #bfbfbf;
            border-radius: 2px;
            text-decoration: none;
            color: #000000;
        }
        .start:hover {
            background-color: #0D3349;
        }
    </style>
</head>
<h2 class="main_title"> PHP Quizzer</h2>
<div class="quiz">
    <h2 class="title">Test Your Php Knowledge</h2>
    <p>This is a multiple choice quiz to test your knowledge of PHP.</p>
    <p><b>Number of Questions: </b><?php echo $nrPyetjeve ?></p>
    <p><b>Type:</b> Multiple Choice</p>
    <p><b>Estimated Time:</b> <?php echo ($nrPyetjeve*0.5).' minutes'?></p>
    <br>
    <a class="start" href="phpQuizzer.php">Start Quiz</a>
</div>
</html>

