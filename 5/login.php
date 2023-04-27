<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_SESSION['login'])) {
  header('Location: index.php');
  }else{
?>
<style>
  .form-sign-in{
    max-width: 960px;
    text-align: center;
    margin: 0 auto;
  }
</style>
<div class="form-sign-in">
<form action="login.php" method="post">
  <label> Логин <label> <br>
  <input name="login" /> <br> 
  <label> Пароль <label> <br>
  <input name="password" type="password"/> <br><br>
  <input type="submit" value="Войти" />
</form>
</div>
<?php
  }
}
else {
  $login=$_POST['login'];
  $password=$_POST['password'];
  $uid=0;
  $error=TRUE;
  $user = 'u52821';
  $pass = '8567731';
  $db1 = new PDO('mysql:host=localhost;dbname=u52821', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  if(!empty($login) and !empty($password)){
    try{
      print('Зашло');
      $chk=$db1->prepare("select * from user_info where login=?");
      print('1');
      $chk->bindParam(1,$login);
      print('2');
      $chk->execute();
      print('3');
      $username=$chk->fetchALL();
      print('4');
      print($password);
      print($username[0]['password']);
      if(password_verify($password,$username[0]['password'])){
        print('5');
        $uid=$username[0]['id'];
        $error=FALSE;
      }
    }
    catch(PDOException $e){
      print('666');
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  if($error==TRUE){
    print('Неправильные логин или пароль <br> Если вы хотите создать нового пользователя <a href="index.php">назад</a> или попытайтесь войти снова <a href="login.php">войти</a>');
    session_destroy();
    exit();
  }
  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $login;
  // Записываем ID пользователя.
  $_SESSION['uid'] = $uid;
  // Делаем перенаправление.
  header('Location: index.php');
}
