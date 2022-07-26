<?php

require_once("functions.php");

if ($_POST['action'] == "start" || $_POST['action'] == "next") {
    // if action is equal to start or next
    // pass post through get question
    // and assign to variable output
    // echo the output in json
    $output = get_question($_POST);
    echo json_encode($output);
} elseif ($_POST['action'] == "end") {
    // if action is equal to end
    // pass post through final score
    // and assign to variable output
    // echo the output in json
    $output = final_score($_POST['score']);
    echo json_encode($output);
}
