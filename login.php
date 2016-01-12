<?php 
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
  if($_POST['username'] == "juadmin"){
    $_SESSION['user'] = $_POST['username'];
    header("Location: /");
    exit;
  }else{
    $errormessage = "Wrong username";
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