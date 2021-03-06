<?php

class Corrector implements Corrector_interface
{
    private $questions;
    private $score = 0;
    private $total_score;

    public function __construct($questions)
    {
        $this->questions = $questions;
        $this->total_score = count($questions);
    }

    public function correct()
    {
        if(count($this->filter_answers()) === 0)
            return false;
        $i = 1;
        foreach ($this->questions as $question) {
            if(isset($_SESSION[USER_ANSWERS_PREFIX . $i])) {
                $question_answer = strtolower(trim($question->get_answer()));
                $user_answer = strtolower(trim($_SESSION[USER_ANSWERS_PREFIX . $i++]));
                if ($question_answer === $user_answer) $this->score++;
            }
        }
        return ["score" => $this->score, "total_score" => $this->total_score, "questions" => $this->questions];
    }

    private function filter_answers(){
        return array_filter(array_keys($_SESSION), function ($element){
            return substr($element,0, strlen(USER_ANSWERS_PREFIX)) === USER_ANSWERS_PREFIX;
        });
    }
}