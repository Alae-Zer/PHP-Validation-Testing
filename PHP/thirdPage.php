<?php
session_start();
if (!isset($_SESSION['formData'])) {
    header("Location: index.php");
    exit;
}

// now i am rechecking this code i dont know what i place the variables into an array but i did it
echo json_encode([
    "questionID" => $_SESSION['formData']['questionID'],
    "title" => $_SESSION['formData']['title'],
    "choices" => $_SESSION['formData']['choices'],
    "answer" => $_SESSION['formData']['answer'],
    "points" => intval($_SESSION['formData']['points'])
]);

// Destroy session when done
session_destroy();
