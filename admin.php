<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
  require('connect.php');
  $pass_hash=array();
  try{
    $get=$db->prepare("select password from admin where login=?");
    $get->execute(array('admin'));
    $pass_hash=$get->fetchAll()[0][0];
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
  }
  
  //аутентификация
  if (empty($_SERVER['PHP_AUTH_USER']) ||
      empty($_SERVER['PHP_AUTH_PW']) ||
      $_SERVER['PHP_AUTH_USER'] != 'admin' ||
      md5($_SERVER['PHP_AUTH_PW']) != md5(123)) {
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
  }
  if(!empty($_COOKIE['del'])){
    echo 'Пользователь '.$_COOKIE['del_user'].' был успешно удалён <br>';
    setcookie('del','',100000);
    setcookie('del_user','',100000);
  }
  print('Вы успешно авторизовались и видите защищенные паролем данные.');
  $users=array();
  $pwrs=array();
  $form1_array=array('1','2','3');
  $pwrs_count=array();
  try{
    $app=$db->prepare("select * from form");
    $app->execute();
    $users=$app->fetchALL();
    $form1=$db->prepare("select power_id,person_id from form1");
    $form1->execute();
    $pwrs=$form1->fetchALL();
    $count=$db->prepare("select count(*) from form1 where power_id=?");
    foreach($form1_array as $pwr){
      $count->execute(array($pwr));
      $pwrs_count[]=$count->fetchAll()[0][0];
    }
  }
  catch(PDOException $e){
    print('Error: '.$e->getMessage());
    exit();
  }
  include('table.php');
}
else{
  header('Location: admin.php');
}
