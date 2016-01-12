<?php
  session_start();
  if(empty($_SESSION['choice']) || isset($_POST['reset'])){
    $choice  =  rand(0,100);
    $_SESSION['score'] = 0;
    $_SESSION['choice'] = $choice;
  }else{
    $choice = $_SESSION['choice'];
  }

  
  $response = null;
  if( !isset($_POST['guess'])
    || empty($_POST['guess'])){
    $response = "Pas de nombre";
  }else{
    $guess = $_POST['guess'];
    $_SESSION['score']++;
    if($guess > $choice) {
      $response = "C'est moins";
    }elseif($guess < $choice){
      $response = "C'est plus";
    }else{
      $response = "C'est gagné";
      unset($_SESSION['choice']);
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Des papiers dans un bol </title>
</head>
<body>

  <?php echo $response;?>
  Nombre de coup : <?php echo $_SESSION['score']; ?>
  <form method="POST">
    <input type="text" name="guess" autofocus>
    <input type="submit">
    <input type="submit" name="reset" value="reset">
  </form>
  <em>(La réponse est <?php echo $choice?>)</em>
  
</body>
</html>
