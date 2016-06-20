<?php
session_start();
if (isset($_SESSION['questions']) && ! empty($_SESSION['questions'])) {


	if (isset($_SESSION['last_question_correct']) && ! empty($_SESSION['last_question_correct']) && isset($_POST['answer']) && ! empty($_POST['answer'])) {
		$last_question_correct = $_SESSION['last_question_correct'];
		$last_question_answered = $_POST['answer'];
		if ($last_question_correct == $last_question_answered) {
			$_SESSION['correct_answers']++;
		}
	}

	//end of game show results
	if ($_SESSION['no_of_question'] == 5) {

		if (isset($_SESSION['last_question_correct']) && ! empty($_SESSION['last_question_correct']) && isset($_POST['answer']) && ! empty($_POST['answer'])) {
			$last_question_correct = $_SESSION['last_question_correct'];
			$last_question_answered = $_POST['answer'];

			if ($last_question_correct == $last_question_answered) {
				$_SESSION['correct_answers']++;
			}
		}

		header("Location: result.php");
	}

	//get all questions
	$questions = $_SESSION['questions'];


	//get random question
	$no_of_question = array_rand($questions, 1);
	$question = $questions[$no_of_question];

	//unset it from following question
	unset($questions[$no_of_question]);

	//randomize them for html

	$answer[] = $question['correct_answer'];
	$answer[] = $question['dummy_answer1'];
	$answer[] = $question['dummy_answer2'];
	$answer[] = $question['dummy_answer3'];


	$_SESSION['last_question_correct'] = $question['correct_answer'];
	$_SESSION['questions'] = $questions;
	$_SESSION['no_of_question']++;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>

	<!--	<link rel="stylesheet" type="text/css" href="css/index.css">-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body style="text-align: center;">

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">Quiz</a>
		</div>
		<ul class="nav navbar-nav">
			<li class="active"><a href="index.php">Home</a></li>
		</ul>
	</div>
</nav>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<span>QUESTION NO :</span>
		<?php echo "<pre>"; ?>
		<h3><b><?php echo $_SESSION['no_of_question']; ?></b></h3>
		<?php echo "</pre>"; ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row"></div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<?php echo "<pre>"; ?>
		<b><h4><?php echo $question['question']; ?></h4></b>
		<?php echo "</pre>"; ?>
	</div>
	<div class="col-md-4"></div>
</div>
<div class="row">

</div>

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-2">
		<form action="quiz.php" method="post">
			<input type="text" name="answer" value="<?php echo $answer[0]; ?>" hidden><br>
			<input type="submit" value="<?php echo $answer[0]; ?>" class="btn btn-primary"/>
		</form>
	</div>
	<div class="col-md-2">
		<form action="quiz.php" method="post">
			<input type="text" name="answer" value="<?php echo $answer[1]; ?>" hidden><br>
			<input type="submit" value="<?php echo $answer[1]; ?>" class="btn btn-primary"/>
		</form>
	</div>
	<div class="col-md-4"></div>
</div>

<div class="row">

	<div class="col-md-4"></div>
	<div class="col-md-2">
		<form action="quiz.php" method="post">
			<input type="text" name="answer" value="<?php echo $answer[2]; ?>" hidden><br>
			<input type="submit" value="<?php echo $answer[2]; ?>" class="btn btn-primary"/>
		</form>
	</div>
	<div class="col-md-2">
		<form action="quiz.php" method="post">
			<input type="text" name="answer" value="<?php echo $answer[3]; ?>" hidden><br>
			<input type="submit" value="<?php echo $answer[3]; ?>" class="btn btn-primary"/>
		</form>
	</div>
	<div class="col-md-4"></div>

</div>

</body>
</html>