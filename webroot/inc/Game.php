<?php

class Game{

    private $phrase;
    private $lives = 5;
   

    public function __construct($phrase){
        $this->phrase = $phrase;
        
    }
    
    //applies the keyboard to the page and filters for correct and incorrect letter guesses.
    function displayKeyboard(){
        $selectedVar = $this->phrase->flattensArray();
        $keyRow1 = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'];
        $keyRow2 = ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'];
        $keyRow3 = ['z', 'x', 'c', 'v', 'b', 'n', 'm'];
        
        
        //splits the phrase into an array.
        $aryPhrase = str_split($this->phrase->currentPhrase);        
        
        $keyboard = '
        <form action="play.php" method="post">
          <div id="qwerty" class="section">
            <div class="keyrow">';
            
            foreach($keyRow1 as $key){
              
               if (in_array($key, $selectedVar) && !in_array($key, $aryPhrase))
               { 
                   $keyboard .= '<input  class="key incorrect" id="' . $key . '" type="submit" name="letter" value="' . $key . '"  disabled>';
               } else if(in_array($key, $selectedVar) && in_array($key, $aryPhrase)) {
                   $keyboard .= '<input  class="key correct" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '" disabled>';
               } else {
                   $keyboard .= '<input  class="key" id="' . $key . '" type="submit" name="letter" value="' . $key . '">';
               }
                
            };

            $keyboard .= '</div><div class="keyrow">';
            
            foreach($keyRow2 as $key){
                
                if (in_array($key, $selectedVar) && !in_array($key, $aryPhrase))
               { 
                   $keyboard .= '<input  class="key incorrect" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '"  disabled>';
               } else if(in_array($key, $selectedVar) && in_array($key, $aryPhrase)) {
                   $keyboard .= '<input  class="key correct" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '" disabled>';
               } else {
                   $keyboard .= '<input  class="key" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '">';
               }
            };
            
            $keyboard .= '</div><div class="keyrow">';
            
            foreach($keyRow3 as $key){
                
                if (in_array($key, $selectedVar) && !in_array($key, $aryPhrase))
               { 
                   $keyboard .= '<input  class="key incorrect" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '"  disabled>';
               } else if(in_array($key, $selectedVar) && in_array($key, $aryPhrase)) {
                   $keyboard .= '<input  class="key correct" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '" disabled>';
               } else {
                   $keyboard .= '<input  class="key" id="' . $key . '" type="submit" name="' . $key . '" value="' . $key . '">';
               }
            };
            
            $keyboard .= '</div></div></form>';
                       
        return $keyboard;
    }

    //Displays the score (hearts).
    function displayScore(){

        $numb = $this->phrase->numberLost();
        $livesString = '<div id="scoreboard" class="section"><ol>';
        
        for($x = 0; $x < $this->lives; $x++ ){
            if(count($numb) <= $x){
            $livesString .= '<li class="tries"><img src="images/liveHeart.png" height="35px" widght="30px"></li>'; 
            } else {
            $livesString .= '<li class="tries"><img src="images/lostHeart.png" height="35px" widght="30px"></li>';
            } 
        }
        $livesString .= '</ol></div>';

        return $livesString; 
    }

    //checks if the player has lost the game
    function checkForLose(){
        $lostNumb = count($this->phrase->numberLost());
        
        if($lostNumb >= $this->lives){
            return true;
        }
            return false;
    }
    
    //displays the win or loss screen
    function gameOver(){
        $gameOver = $this->checkForLose();
        if($gameOver === true){
            $loseString = '<h1 id="game-over-message">Sorry you lost. 😢<br> The phrase was: "' . $this->phrase->currentPhrase . '".<br> Better luck next time!</h1>' . '<form action="index.php">
            <input id="btn__reset" type="submit" name="restart" value="Restart Game" />
        </form>';
            return $loseString;
        } else if($gameOver === false && $this->checkForWin() === true){
            $winString = '<h1 id="game-over-message">You WIN! 😃<br> Congratulations on guessing: "' . $this->phrase->currentPhrase . '"</h1><br>' . '<form action="index.php">
            <input id="btn__reset" type="submit" name="restart" value="Restart Game" />
        </form>';
            return $winString;
        }
        return null;
    } 
        
    //displays the win screen
    function checkForWin(){
        $phraseLetters = $this->phrase->getLetterArray();
        $selectedLetters = $this->phrase->flattensArray();

        $result = count(array_intersect($phraseLetters, $selectedLetters));

        $phraseLetters = count($this->phrase->getLetterArray());

        if($result === $phraseLetters){

        return true;
        }
        return false;
    }

}
