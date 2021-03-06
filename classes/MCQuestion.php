<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of question
 *
 * @author memad
 */
class MCQuestion implements Question_interface {
    private $question;
    private $options;
    private $answer;
    
    public function __construct($question, $answer){
        $this->question = $question;
        $this->answer = $answer;
    }
    
    
    
    function get_question() {
        return $this->question;
    }

    function get_options() {
        return $this->options;
    }

    public function get_answer(){
        return $this->answer;
    }
  
    
    function Add_an_Option($option) {
        $this->options[] = $option;
    }


   
}
