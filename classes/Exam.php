<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of exam
 *
 * @author memad
 */
class Exam implements Exam_interface {

    private $PREVIOUS = 0;
    private $NEXT = 1;

    private $url;
    private $page;
    private $questions;
    private $question_number;
   
    
    function getQuestion_number() {
        return count($this->questions);
    }

        
    function getPage() {
        return $this->page;
    }

    
    
    public function __construct() {
        $this->url = Helper::get_current_Page_URL();
        $this->page = ($this->get_current_page_index() > 0) ? (int)$this->get_current_page_index() : 1;
        $this->set_pages_sessions();
        $this->questions = $this->get_questions();
        $this->add_user_question_answer();
    }

    public function load_exam_page($page) {
        if (isset($this->questions[$page - 1])) {
            return $this->questions[$page - 1];
        } else {

            throw new Exception("Question doesn't exist");
        }
    }

    public function load_correct_page(){
        return $this->correct_answers();
    }

    public function move_previous() {
        $current_url = explode("?", $this->url)[0];
        $previous_page = (int) $this->page - 1;
        $previous_page = ($previous_page > 0) ? $previous_page : 1;
        return "$current_url?page=$previous_page";
    }

    public function move_next() {
        $current_url = explode("?", $this->url)[0];
        $next_page = (int) $this->page + 1;
        return "$current_url?page=$next_page";
    }

    private function add_user_question_answer(){
        if(isset($_POST["answer"])){
            $_SESSION["answer:{$_SESSION["prev_page"]}"] = $_POST["answer"];
        }
    }

    public function get_user_question_answer(){
        return isset($_SESSION[USER_ANSWERS_PREFIX.$this->page])?$_SESSION[USER_ANSWERS_PREFIX.$this->page]:false;
    }

    public function correct_answers(){
        $corrector = new Corrector($this->questions);
        return $corrector->correct();
    }

    private function set_pages_sessions(){
        $_SESSION["prev_page"] = isset($_SESSION["current_page"])?$_SESSION["current_page"]:$this->page;
        $_SESSION["current_page"] = $this->page;
    }

    private function get_current_page_index() {
        return isset($_GET["page"]) && is_numeric($_GET["page"])? (int)$_GET["page"] ?: 1 : 1;
    }

    private function get_questions() {
        $exam_file = file(exam_file);
        $answers_file = file(answers_file);
        $answer_number = 0;
        $questions = array();
        foreach ($exam_file as $line) {

            if (substr($line, 0, 1) === "Q") {
                if (isset($new_mcquestion)) {
                    $questions[] = $new_mcquestion;
                }
                $new_mcquestion = new MCQuestion(trim($line), trim($answers_file[$answer_number++]));
            } elseif (substr($line, 0, 1) === "*") {
                $new_tofquestion = new TrueOrFalseQuestion(trim(str_replace("*", "", $line)), trim($answers_file[$answer_number++]));
                $questions[] = $new_tofquestion;
            } else {
                $new_mcquestion->Add_an_Option(trim($line));
            }
        }

        return $questions;
    }

}
