<?php

class Phrase{

    public $currentPhrase = '';
    public $selected = Array();
    public $defaultPhrases = [
        'Boldness be my friend',
        'Leave no stone unturned',
        'Broken crayons still color',
        'The adventure begins',
        'Love without limits',
        ];
    
    //chooses a random phrase if the phrase is not set for the session
    public function __construct($phrase = null, $selected = []){
        
        if(!empty($phrase) || !empty($selected)){
            $this->currentPhrase = $phrase;
            $this->selected[] = $selected; 
        } 

        if(empty($phrase)){
            $tempPhrase = array_rand($this->defaultPhrases,1);
            $this->currentPhrase = $this->defaultPhrases[$tempPhrase];
            $this->selected[] = $selected;
        }
        
    }

    //flattens the 'selected' array
    public function flattensArray(){
        $newSelected = [];       
        $flatten = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->selected));
        foreach($flatten as $x) {
          array_push($newSelected, $x);
        };
        if($newSelected[0] === "Start Game"){
            unset($newSelected[0]); 
        }
        if($newSelected[1] === "Start Game"){
            unset($newSelected[1]); 
        }

        return $newSelected;
    }
    //adds the phrase to the display and checks if the letter has been choosen or not
    public function addPhraseToDisplay(){
        
        $newSelectedFlat = $this->flattensArray();
        
        $characters = str_split(strtolower($this->currentPhrase));
        $returnedString = '<div id="phrase" class="section"><ul>';

            for($i = 0; $i < count($characters); $i++){
                
                if($characters[$i] == " "){
                    $returnedString .= '<li class="hide space "> </li>';
                } else if( in_array($characters[$i], $newSelectedFlat) ){
                    $returnedString .= '<li class="show letter ' . $characters[$i] .'">' . $characters[$i] . '</li>';
                } else {
                    $returnedString .= '<li class="hide letter ' . $characters[$i] .'">' . $characters[$i] . '</li>';
                }
                
            }

        $returnedString .= ' </ul></div>';

        return $returnedString;
       
    }
    
    //Checks if the most recent letter chosen is in the current phrase
    public function checkLetter($letter){
        
        if (strpos(strtolower($this->currentPhrase), $letter) === false){
            return false;
        }
            return true;
    }

    //Breaks the current phrase into an array
    public function getLetterArray(){

        $uniquePhraseLetters = array_unique(str_split(str_replace(' ','',strtolower($this->currentPhrase))));
       
        return $uniquePhraseLetters;
    }

    //Checks the users selected letters against the phrase and returns anything not present in the other array
    public function numberLost(){
        $newSelected = $this->flattensArray();       
        
        $checkGetLetter = $this->getLetterArray();
        
        $differnece = array_diff($newSelected, $checkGetLetter);
        
        return $differnece;
    }
}