<?php
/**
 * This file is going to be a brief example of how I think this file will work given the new coding ideas
 * 
 * @author Sarah Stensland
 * @version 1.0.1
 */

// initialize everything
$title = "Questionnaire";
require_once 'header.php';

// if the questionnaire hasn't been made yet
if (!isset($_SESSION['questionnaire'])) {
    // set up questionnaire
} else {
    // continue questionnaire
    $questionnaire = unserialize($_SESSION['questionnaire']);
    $queue = $questionnaire->getFormQueue();
    $currentFormIndex = $_SESSION['CFI'];
    $currentForm = $questionnaire[$currentFormIndex];

    $currentForm->draw();

    if (isset($_GET['submit'])) {
        $currentForm->submitForm();
    } else if (isset($_GET['back'])) {
        $currentForm = $queue->back();
        $currentForm->undoForm();
    } else if (isset($_GET['saveandquit'])) {
        // some kind of logic to ensure everything needed is serialized into the questionnaire object
        // save questionnaire object to database
    } else {
        // unknown option: either means an error or nothing was pressed
    } //end if
} //end if

?>