<?php 
require_once("config/dbconf.php");
session_start();

if(isset($_POST['logout'])){
  unset($_SESSION['user']);
}

if(isset($_SESSION['user'])){
    header("Location: /");
    exit;
}

$errormessage = null;
if(isset($_POST['username'])){

  global $config;
  $pdo = new PDO($config['host'], $config['user'], $config['password']);

  $stmt = $pdo->prepare("SELECT * FROM users 
                          WHERE login = :login"
                        );
  $stmt->bindParam("login",$_POST['username']);
  $stmt->execute();
  $result = $stmt->fetch();

  if($result === false){
    $errormessage = "Wrong username";
  }else{
    $_SESSION['user'] = $result["login"];
    header("Location: /");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  Merci de vous connecter :
  <form method="POST">
  Login : <input type="text" name="username"><br>
  <input type="submit" value="Log in">
  </form>
  <?php echo $errormessage;?>
</body>
</html>