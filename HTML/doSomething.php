<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize the data array
    $data = [
        "questionID" => $_POST["questionID"],
        "title" => $_POST["title"],
        "choices" => [],
        "answer" => $_POST["answer"],
        "points" => intval($_POST["points"])
    ];

    // Get the number of choices
    $choiceCount = intval($_POST["choiceCount"]);
    $alphabet = range("A", "Z");

    // Loop through each choice based on choiceCount and alphabet
    for ($i = 0; $i < $choiceCount; $i++) {
        $choiceKey = "choice" . $alphabet[$i];
        if (isset($_POST[$choiceKey])) {
            $data["choices"][] = $_POST[$choiceKey];
        }
    }

    // Output the JSON-encoded data
    echo json_encode($data);
}
