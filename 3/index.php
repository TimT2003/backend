<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Данные сохранены');
  }
  include('form.php');
}
else{
    $regex_name="/[a-z,A-Z,а-я,А-Я,-]*$/";
    $regex_email="/[a-z]+\w*@[a-z]+\.[a-z]{2,4}$/";
    $errors = FALSE;
    if (empty($_POST['name']) or !preg_matchAll($regex_name,$_POST['name'])) {
    print('Заполните имя.<br/>');
    $errors = TRUE;
    }
    if (empty($_POST['email']) or !preg_match($regex_name,$_POST['email'])){
    print('Заполните почту.<br/>');
    $errors = TRUE;
    }
    if ($_POST['year']=='Выбрать'){
    print('Выберите год рождения.<br/>');
    $errors = TRUE;
    }
    if (empty($_POST['gender'])){
    print('Выберите пол.<br/>');
    $errors = TRUE;
    }
    if (empty($_POST['limb'])){
    print('Выберите сколько у вас конечностей.<br/>');
    $errors = TRUE;
    }
    if(!isset($_POST['power'])){
        print('Выберите хотя бы одну суперспособность.<br/>');
        $errors=TRUE;
    }
    if (empty($_POST['checked'])){
      print('Чек.<br/>');
    $errors = TRUE;
    }
    if ($errors) {
    print_r('Исправьте ошибки');
    exit();
    }

    $user = 'u52819';
    $pass = '7263482';
    $db = new PDO('mysql:host=localhost;dbname=u52819', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    try {
    $stmt = $db->prepare("INSERT INTO application SET name=?,email=?,year=?,gender=?,limb=?,bio=?");
    $stmt -> execute(array($_POST['name'],$_POST['email'],$_POST['year'],$_POST['limb'],$_POST['bio']));
    $id=$db->lastInsertId();
    $som=$db->prepare("INSERT INTO tabl1 SET id_power=:power,id_person=:person");
    $som->bindParam(':person', $id);
    foreach($_POST['power']  as $power){
    $som->bindParam(':power', $power);
    if($sppe->execute()==false){
      print_r($som->errorCode());
      print_r($som->errorInfo());
      exit();
    }
  }
    }
    catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
    }
    header('Location: ?save=1');
}
?>
