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
$choices = array();
$errors = array();
$successMessage = '';

if (isset($_POST['submit'])) {
    for ($i = 1; $i < 6; $i++) {
        if (isset($_POST['choice-' . $i]) && $_POST['choice-' . $i] !='') {
            $choices[] = $_POST['choice-' . $i];
        }
    }
    if (count($choices) < 2) {
        $errors[] = "You must have at least two choices";
    }

    if (isset($_POST['question'])) {
        $question = $_POST['question'];
    } else {
        $errors[] = "Question is required";
    }

    if (isset($_POST['correct-choice'])) {
        $correctChoice = $_POST['correct-choice'];
    } else {
        $errors[] = "Correct Choice is required!";
    }

    if (count($errors) < 1) {
        /**
         * shto pyetjen dhe opsionet
         */

        $questionQ = "INSERT INTO questions(text) VALUES ('{$question}') ";
        $result = $conn->query($questionQ);

        $lastQuestionId = "SELECT questions.question_number FROM questions ORDER BY questions.question_number DESC LIMIT 1";
        $lastId = $conn->query($lastQuestionId);
        $lastId = $lastId->fetch_assoc()['question_number'];
        $i = 1;
        $isCorrect = 0;

        foreach ($choices as $choice) {
            if ($i == $correctChoice) {
                $isCorrect = 1;
            }
            $questionCh = "INSERT INTO choices(question_number,is_correct,text) VALUES ('{$lastId}','{$isCorrect}','{$choice}') ";
            $addedCh = $conn->query($questionCh);
            $i++;
        }

        $successMessage = "Question Added!";
    }
}


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
            font-weight: bold;
            padding: 20px;
        }

        .quiz {
            width: 50%;
            margin: 0 auto;
        }

        .start {
            padding: 10px 15px;
            background-color: #bfbfbf;
            border-radius: 2px;
            text-decoration: none;
            color: #000000;
        }

        .start:hover {
            background-color: #0D3349;
        }

        input {
            display: block;
            width: 100%;
        }
    </style>
</head>
<h2 class="main_title"> PHP Quizzer</h2>
<div class="quiz">
    <p><b>Add A Question</b></p>
    <br>
    <form method="post">
        <label>Question Text:</label>
        <input type="text" name="question">
        <label>Choice #1:</label>
        <input type="text" name="choice-1">
        <label>Choice #2:</label>
        <input type="text" name="choice-2">
        <label>Choice #3:</label>
        <input type="text" name="choice-3">
        <label>Choice #4:</label>
        <input type="text" name="choice-4">
        <label>Choice #5:</label>
        <input type="text" name="choice-5">
        <br>
        Correct Choice Number:<input style="width: 100px; display: inline" type="text" name="correct-choice">
        <br>
        <span style="color: red;"><?php echo $successMessage ?></span>
        <?php

        foreach ($errors as $error) {
            ?>
            <span style="color: red;"><?php echo $error ?></span>
            <br>
        <?php } ?>
        <input style="width: 150px;" type="submit" name="submit" value="Add Question">
    </form>
    <br><br>
    <a class="start" href="phpQuizzer.php">Start Quiz</a>
</div>
</html>

