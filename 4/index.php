<?php
header('Content-Type: text/html; charset=UTF-8');
$bioreg = "/^\s*\w+[\w\s\.,-]*$/";
$reg = "/^\w+[\w\s-]*$/";
$mailreg = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['checkin'] = !empty($_COOKIE['checkin_error']);
  $errors['power'] = !empty($_COOKIE['power_error']);
	
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма имени</div>';
  }
	if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма года</div>';
  }
	if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма email</div>';
  }
	if ($errors['gender']) {
    setcookie('gender_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол</div>';
  }
	if ($errors['limb']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Выберите кол-во конечностей</div>';
  }
	if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Неправильная форма биографии</div>';
  }
	if ($errors['checkin']) {
    setcookie('checkin_error', '', 100000);
    $messages[] = '<div class="error">Примите согласие</div>';
  }
	if ($errors['power']) {
    setcookie('power_error', '', 100000);
    $messages[] = '<div class="error">Выберите суперсилу</div>';
  }
	
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['checkin'] = empty($_COOKIE['checkin_value']) ? '' : $_COOKIE['checkin_value'];
  $values['power'] = empty($_COOKIE['power_value']) ? '' : $_COOKIE['power_value'];

  include('form.php');
}
else {
  $errors = FALSE;
  if (empty($_POST['name']) || !preg_match($reg,$_POST['name'])) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60 * 12);
  }
	
if (empty($_POST['email']) || !preg_match($mailreg,$_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['bio']) || !preg_match($bioreg,$_POST['bio'])) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['limb'])) {
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('limb_value', $_POST['limb'], time() + 30 * 24 * 60 * 60 * 12);
  }
if (empty($_POST['checkin'])) {
    setcookie('checkin_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('checkin_value', $_POST['checkin'], time() + 30 * 24 * 60 * 60 * 12);
  }

if(empty($_POST['power'])){
	setcookie('power_error', '1', time() + 24 * 60 * 60);
	$errors = TRUE;
}
else {
    	setcookie('power_value', $_POST['power'], time() + 30 * 24 * 60 * 60 * 12);
 }

  if ($errors) {
    header('Location: index.php');
    exit();
  }

  $user = 'u52819';
  $pass = '7263482';
  $db = new PDO('mysql:host=localhost;dbname=u52819', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  try {
	  $stmt = $db->prepare("INSERT INTO tabl SET name = ?,email= ?, year= ?, gender= ?, limb= ?, bio= ?,checkin= ?");
	  $stmt->execute([$_POST['name'],$_POST['email'],$_POST['year'],$_POST['gender'],$_POST['limb'],$_POST['bio'],$_POST['checkin']]);

	  $id = $db->lastInsertId();
	  $sppe= $db->prepare("INSERT INTO power SET id_power=:power, id_person=:person");
	  $sppe->bindParam(':person', $id);
	  foreach($_POST['power']  as $ability){
		$sppe->bindParam(':power', $ability);
		if($sppe->execute()==false){
		  print_r($sppe->errorCode());
		  print_r($sppe->errorInfo());
		  exit();
		}
	  }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }
  setcookie('save', '1');
  header('Location: ?save=1');
}
