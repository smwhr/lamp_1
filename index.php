<?php
  require_once("model/connexion.php");
  require_once("model/GameState.php");
  global $pdo;
  session_start();

  if(!isset($_SESSION['user'])){
    header("Location: /login.php");
    exit;
  }

  if(isset($_POST['reset_best'])){
    $stmt = $pdo->prepare("UPDATE `users` 
                           SET `best_score` = NULL 
                           WHERE `login` = :user_login ;"
                  );
    $stmt->bindParam("user_login",$_SESSION['user']);
    $stmt->execute();
    unset($_SESSION['best_score']);
  }

  if(empty($_SESSION['game_state'])){
    $_SESSION['game_state'] = new GameState();
  }

  if(empty($_SESSION['game_state']->choice) || isset($_POST['reset'])){
    $choice  =  rand(0,100);
    $_SESSION['game_state']->score = 0;
    $_SESSION['game_state']->choice = $choice;;
  }else{
    $choice = $_SESSION['game_state']->choice;
  }

  
  $response = null;
  if( !isset($_POST['guess'])
    || empty($_POST['guess'])){
    $response = "Pas de nombre";
    if(!is_null($_SESSION['game_state']->last_guess)){
      $guess = $_SESSION['game_state']->last_guess;
      if($guess > $choice) {
        $response = "C'est moins";
      }elseif($guess < $choice){
        $response = "C'est plus";
      }
    }
  }else{
    $guess = $_POST['guess'];
    $_SESSION['game_state']->score++;
    $_SESSION['game_state']->last_guess = $guess;

    if($guess > $choice) {
      $response = "C'est moins";
    }elseif($guess < $choice){
      $response = "C'est plus";
    }else{
      $response = "C'est gagné";
      if( !isset($_SESSION['best_score'])
          || $_SESSION['best_score'] > $_SESSION['score']){
          $_SESSION['best_score'] = $_SESSION['score'];

          $_SESSION['game_state']->last_guess = null;
          
          $stmt = $pdo->prepare("UPDATE `users` 
                                 SET `best_score` = :best_score 
                                 WHERE `login` = :user_login ;"
                        );
          $stmt->bindParam("best_score",$_SESSION['best_score']);
          $stmt->bindParam("user_login",$_SESSION['user']);
          $stmt->execute();


      }
      unset($_SESSION['game_state']->choice);
    }
  }

  $sql = "SELECT login, best_score FROM users 
          WHERE best_score IS NOT NULL
          ORDER BY best_score ASC
          ";
  $best_scores =  $pdo->query($sql);

  $stmt = $pdo->prepare("UPDATE `users` 
                         SET `current_game` = :current_game 
                         WHERE `login` = :user_login ;"
                );

  $serialized = serialize($_SESSION['game_state']);
  $stmt->bindParam("current_game",$serialized);
  $stmt->bindParam("user_login",$_SESSION['user']);
  $stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Des papiers dans un bol </title>
</head>
<body>
  <h1>Jeu</h1>
  <?php if(!is_null($_SESSION['game_state']->last_guess)):?>
  Votre dernier coup <?php echo $_SESSION['game_state']->last_guess;?><br>
<?php endif;?>
  <?php echo $response;?> <br>
  Nombre de coup : <?php echo $_SESSION['game_state']->score; ?><br>
  <em>[Meilleur score pour <?php echo $_SESSION['user'];?>: 
  <?php 
    echo !isset($_SESSION['best_score']) 
          ? "Pas de meilleur score" 
          : $_SESSION['best_score'];
  ?>]</em>
  <form method="POST">
    <input type="text" name="guess" autofocus>
    <input type="submit">
    <input type="submit" name="reset" value="reset">
    <input type="submit" name="reset_best" value="reset best">
  </form>
  <em>(La réponse est <?php echo $choice?>)</em>

  <h1>Leaderboard</h1>
  <table style="border: 1px solid black">
    <?php foreach($best_scores as $user_score):?>
      <tr>
        <td style="border: 1px solid black">
          <?php echo $user_score["login"];?>
        </td>
        <td style="border: 1px solid black">
          <?php echo $user_score["best_score"];?>
        </td>
      </tr>
    <?php endforeach;?>
  </table>

  <form method="POST" action="/login.php">
    <input type="submit" name="logout" value="Logout">
  </form>
  
</body>
</html>


TEST
