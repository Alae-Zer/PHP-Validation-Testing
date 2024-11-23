<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Create Question</title>
</head>

<body>
    <?php
    session_start();
    $alphabet = range("A", "Z");
    //since from page one to two we have a get, so we just get the number of choises and store it in a session once you make it to the third page it gets deleted
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $_SESSION['numChoices'] = $_GET['choices'];
    }
    //and is the $_SESSION['numChoices'] doesnt exist it will take you to the page one
    if (!isset($_SESSION['numChoices'])) {
        header("Location: index.php");
        exit;
    }
    // Initialize variables
    $numChoices = $_SESSION['numChoices'];
    $questionID = $title = $answer = $points = '';
    $errors = ["questionID" => "", "title" => "", "answer" => "", "points" => ""];
    $choices = [];

    //the only time we get a post is when submit the form to it self that means we need to do the checks

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Validate Question ID
        if (empty($_POST['questionID'])) {
            $errors['questionID'] = "Question ID is required.";
        } elseif (!preg_match("/^QU-\d{3}$/", $_POST['questionID'])) {
            $errors['questionID'] = "Question ID must match the pattern QU-NNN.";
        } else {
            $questionID = $_POST['questionID'];
        }

        // Validate Title
        if (empty($_POST['title'])) {
            $errors['title'] = "field cannot be empty.";
        } else {
            $title = $_POST['title'];
        }

        // Validate Choices
        //since alphabet is an array that holds a to z we need to set the array to the number of choises
        //once we have the array we just loop through it and do the checking
        foreach (array_slice($alphabet, 0, $numChoices) as $letter) {
            $choiceKey = "choice_$letter";
            if (empty($_POST[$choiceKey])) {
                $errors[$choiceKey] = "Choice $letter is required.";
            } else {
                $choices[$choiceKey] = $_POST[$choiceKey];
            }
        }

        // Validate Answer
        if (empty($_POST['answer'])) {
            $errors['answer'] = "Answer is required.";
        } elseif (!in_array($_POST['answer'], $choices)) {
            $errors['answer'] = "Answer must match one of the choices.";
        } else {
            $answer = $_POST['answer'];
        }

        // Validate Points
        if (empty($_POST['points'])) {
            $errors['points'] = "Points are required.";
            //one if to check both if the input is a digit and if it negative
        } elseif (!ctype_digit($_POST['points']) || $_POST['points'] <= 0) {
            $errors['points'] = "Points must be a positive integer greater than 0.";
        } else {
            $points = $_POST['points'];
        }

        // If no errors, save form data to session inside a single variable to make it easy and proceed
        if (empty(array_filter($errors))) {
            $_SESSION['formData'] = [
                "questionID" => $questionID,
                "title" => $title,
                "choices" => array_values($choices),
                "answer" => $answer,
                "points" => $points
            ];
            header("Location: thirdPage.php");
            exit;
        }
    }
    ?>

    <h1>Step 2 - Create the Question</h1>
    <form method="POST">
        <label>Question ID:</label>
        <input type="text" name="questionID" value="<?php echo $questionID; ?>">
        <span><?php echo $errors['questionID']; ?></span><br>

        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $title; ?>">
        <span><?php echo $errors['title']; ?></span><br>

        <?php foreach (array_slice($alphabet, 0, $numChoices) as $letter): ?>
            <label>Choice <?php echo $letter; ?>:</label>
            <!--this is a nice trick i leaned called the Null coalescing operator (bad name if you asked me) here is a link to it https://en.wikipedia.org/wiki/Null_coalescing_operator-->
            <input type="text" name="choice_<?php echo $letter; ?>" value="<?php echo $choices["choice_$letter"] ?? ''; ?>">
            <span><?php echo $errors["choice_$letter"] ?? ''; ?></span><br>
        <?php endforeach; ?>

        <label>Answer:</label>
        <input type="text" name="answer" value="<?php echo $answer; ?>">
        <span><?php echo $errors['answer']; ?></span><br>

        <label>Points:</label>
        <input type="text" name="points" value="<?php echo $points; ?>">
        <span><?php echo $errors['points']; ?></span><br>

        <button type="submit">Submit</button>
    </form>
</body>

</html>