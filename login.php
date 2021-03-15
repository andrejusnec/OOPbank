<?php require 'C:\xampp\htdocs\php_proj\OOPbank\default.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff = file_get_contents(DIR.'/data/staff.json');
    $staff = json_decode($staff, 1);
    $vardas = $_POST['vardas'] ?? '';
    $pass = $_POST['pass'] ?? '';
    foreach($staff as $user) {
        if($vardas == $user['name']) {
            if(password_verify($pass, $user['pass'])) {
                    $_SESSION['login'] = 1;
                    $_SESSION['user'] = $user;
                    header('Location: http://localhost/php_proj/OOPbank');
                    die;
            }
        }
    }
    $_SESSION['error'] = '<h1>Username or password is invalid</h1>';
    header('Location: http://localhost/php_proj/OOPbank/login.php');
    die;
}
if(isset($_GET['logout'])) {
  //unset($_SESSION['login']);
  //unset($_SESSION['user']);
  session_destroy();
  header('Location: http://localhost/php_proj/OOPbank/login.php');
    die;
}
if(isset($_SESSION['login']) && $_SESSION['login'] == 1) {
  header('Location: http://localhost/php_proj/OOPbank');
  die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./public/css/app.css">
<link rel="stylesheet" href="./public/css/custom.css">
</head>
<body class="bg">
<div class="topnav">
  <a class="active" href="<?= URL ?>account.php">Log in</a>
  <a href="<?= URL ?>addFunds.php">Register</a>
  <div style="float:right">
      <a href="<?= URL ?>bank.php">TESO BANK</a>
      <img class="logo" src="./img/eso.webp" alt="alt">
  </div>
</div>
<?php if(isset($_SESSION['error'])) {
  echo $_SESSION['error'];
  unset($_SESSION['error']);
}
?>
<div class="login">
<form class="login-form" action="http://localhost/php_proj/OOPbank/login.php" method="post">
  <h1>Login</h1>
  <div class="form-input-material">
    <input type="text" name="vardas" id="username" placeholder=" " autocomplete="off" class="form-control-material" required />
    <label for="username">Username</label>
  </div>
  <div class="form-input-material">
    <input type="password" name="pass" id="password" placeholder=" " autocomplete="off" class="form-control-material" required />
    <label for="password">Password</label>
  </div>
  
  <button class="glow-on-hover" type="submit">LOG IN</button>
</form>
</div>
</body>
</html>