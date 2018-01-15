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
$error = '';
?>


<?php
/**
 * gjej nurmin e pyetjeve
 */
$query = "SELECT COUNT(DISTINCT(`question_number`)) FROM `questions` ";
$result = $conn->query($query);
$row = $result->fetch_row();
$nrPyetjeve = $row[0];

$questions = "SELECT questions.text AS pyetja, choices.text,choices.is_correct FROM questions
              INNER JOIN choices ON questions.question_number = choices.question_number";

$pyetjet = $conn->query($questions);
$pyetjeFinal = array();

while ($pyetja = $pyetjet->fetch_assoc()) {

    $pyetjeFinal[$pyetja['pyetja']][] = array(
        'option' => $pyetja['text'],
        'is_correct' => $pyetja['is_correct']
    );
}


?>



<?php

session_start();

if (!isset($_SESSION['current'])) {
    $_SESSION['current'] = 0;
    $_SESSION['nrPyetjeve'] = $nrPyetjeve;
    $step = 0;
}
?>
<?php
if(isset($_POST['submit'])) {

    $pergjigja = $_POST['pyetja'];

    if (!isset($pergjigja)) {
        $error = "Ju lutem zgjidhni nje opsion!";
    } elseif($_SESSION['current'] == ($nrPyetjeve-1)){
        $step=$_SESSION['current'];
        $_SESSION['pyetja-'.$step] = $pergjigja;

        header('location:quizResult.php');

    }else {
        $step=$_SESSION['current'];
        $_SESSION['pyetja-'.$step] = $pergjigja;
        $_SESSION['current'] = ++$_SESSION['current'];
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

            padding: 20px;
            background-color: #dadada;
        }

        .quiz {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<h2 class="main_title"> PHP Quizzer</h2>
<div class="quiz">
    <h2 class="title">Question <?php echo $_SESSION['current']+1 ?> of <?php echo $nrPyetjeve ?></h2>
    <form method="post">
    <?php
    $keys = array_keys($pyetjeFinal);

    $i=$_SESSION['current'];
        echo $keys[$i].'<br>';
       $options =  $pyetjeFinal[$keys[$i]];
       foreach($options as $option){
           ?>
           <input type="radio" value="<?php echo $option['is_correct']?>" name="pyetja"><?php echo $option['option']?><br>
    <?php
       }

    ?>
        <span style="color:red"><?php echo $error ?></span>
        <br>
        <input type="submit" value="Submit" name="submit">
    </form>
</div>
</html>

