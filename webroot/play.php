<?php
//starts the session
session_start();

//checks if the session should be reset
if(isset($_POST['start'])){
   unset($_SESSION['selected']);
   unset($_SESSION['phrase']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Phrase Hunter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<?php 
    include('inc/Game.php');
    include('inc/Phrase.php');
    
    $_SESSION['selected'][] = $_POST;
    
    if(!isset($_SESSION['phrase'])){
        $_SESSION['phrase'] = null;
    } else {
        $_SESSION['phrase'];
    };
   
    $phrase = new Phrase($_SESSION['phrase'], $_SESSION['selected']);
  
    $_SESSION['phrase'] = $phrase->currentPhrase;
    
    $game = new Game($phrase);
    
?>
<body>
<div class="main-container">
        <h2 class="header">Phrase Hunter</h2>    
            <?php 
                  if($game->checkForLose() === true){
                      echo $game->gameOver();
                  } else if($game->checkForWin() === true){
                      echo $game->gameOver();
                  } else {
                    echo $phrase->addPhraseToDisplay(); 
                    echo $game->displayKeyboard();
                    echo $game->displayScore();
                  }
            ?> 
</div>
<script>
//triggers letter submit on keydown input
document.addEventListener('keydown', logKey);

function logKey(e) {
  document.getElementById(e.key).click();
}
</script>
</body>
</html>
