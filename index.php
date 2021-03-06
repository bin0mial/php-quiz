<?php
session_start();
require_once "autoload.php";
try {
    $exam = new Exam();
    $current_page = $exam->getPage();
    if ($current_page == $exam->getQuestion_number()+1) {
        $correction_flag = true;
        if(!($correction = $exam->load_correct_page()))
            die(include "./views/errors/error_403.php");
        session_destroy();
    } else {
        $current_question = $exam->load_exam_page($current_page);
    }
} catch (Exception $ex) {
    if (mode === "production") {
        include("views/errors/error_404.php");
        exit();
    } else {
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        exit();
    }
}
?>
<html>
    <?php include "views/snippets/header.php"; ?>
    <body>
        <?php isset($correction_flag)? include "views/exam/corrections.php" : include "views/exam/questions.php"; ?>
    </body>
</html>