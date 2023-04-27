<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('password', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
    if (!empty($_COOKIE['password'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['password']));
    }
    setcookie('name_value', '', 100000);
    setcookie('mail_value', '', 100000);
    setcookie('year_value', '', 100000);
    setcookie('sex_value', '', 100000);
    setcookie('limb_value', '', 100000);
    setcookie('bio_value', '', 100000);
    setcookie('1_value', '', 100000);
    setcookie('2_value', '', 100000);
    setcookie('3_value', '', 100000);
    setcookie('checked_value', '', 100000);
  }

  $errors = array();
  $error=FALSE;
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['form1'] = !empty($_COOKIE['form1_error']);
  $errors['checked'] = !empty($_COOKIE['checked_error']);
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя.</div>';
    $error=TRUE;
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните или исправьте почту.</div>';
    $error=TRUE;
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Выберите год рождения.</div>';
    $error=TRUE;
  }
  if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
    $error=TRUE;
  }
  if ($errors['limb']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Выберите сколько у вас конечностей.</div>';
    $error=TRUE;
  }
  if ($errors['form1']) {
    setcookie('form1_error', '', 100000);
    $messages[] = '<div class="error">Выберите хотя бы одну суперспособность.</div>';
    $error=TRUE;
  }
  if ($errors['checked']) {
    setcookie('checked_error', '', 100000);
    $messages[] = '<div class="error">Необходимо согласиться с политикой конфиденциальности.</div>';
    $error=TRUE;
  }
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
  $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
  $values['year'] = empty($_COOKIE['year_value']) ? 0 : $_COOKIE['year_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['1'] = empty($_COOKIE['1_value']) ? 0 : $_COOKIE['1_value'];
  $values['2'] = empty($_COOKIE['2_value']) ? 0 : $_COOKIE['2_value'];
  $values['3'] = empty($_COOKIE['3_value']) ? 0 : $_COOKIE['3_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
  $values['checked'] = empty($_COOKIE['checked_value']) ? FALSE : $_COOKIE['checked_value'];
  if (!$error and !empty($_COOKIE[session_name()]) and !empty($_SESSION['login'])) {
    $user = 'u52821';
    $pass = '8567731';
    $db = new PDO('mysql:host=localhost;dbname=u52821', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    try{
      $get=$db->prepare("select * from form where id=?");
      $get->bindParam(1,$_SESSION['uid']);
      $get->execute();
      $inf=$get->fetchALL();
      $values['name']=$inf[0]['name'];
      $values['email']=$inf[0]['email'];
      $values['year']=$inf[0]['year'];
      $values['sex']=$inf[0]['sex'];
      $values['limb']=$inf[0]['limb'];
      $values['bio']=$inf[0]['bio'];
      $values['checked']=$inf[0]['checked'];

      $get2=$db->prepare("select power_id from form1 where person_id=?");
      $get2->bindParam(1,$_SESSION['uid']);
      $get2->execute();
      $inf2=$get2->fetchALL();
      for($i=0;$i<count($inf2);$i++){
        if($inf2[$i]['power_id']=='1'){
          $values['1']=1;
        }
        if($inf2[$i]['power_id']=='2'){
          $values['2']=1;
        }
        if($inf2[$i]['power_id']=='3'){
          $values['3']=1;
        }
      }
    }
    catch(PDOException $e){
      print('Error: '.$e->getMessage());
      exit();
    }
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }
  include('form.php');
}
else {
  if(!empty($_POST['logout'])){
    session_destroy();
    header('Location: index.php');
  }
  else{
    $regex_name='/[a-z,A-Z,а-я,А-Я,-]*$/';
    $regex_email='/[a-z]+\w*@[a-z]+\.[a-z]{2,4}$/';
    $name=$_POST['name'];
    $email=$_POST['email'];
    $year=$_POST['year'];
    $sex=$_POST['sex'];
    $limb=$_POST['limb'];
    $pwrs=$_POST['form1'];
    $bio=$_POST['bio'];
    if(empty($_SESSION['login'])){
      $check=$_POST['checked'];
    }
    $errors = FALSE;
    if (empty($name) or !preg_match($regex_name,$name)) {
      setcookie('name_error', '1', time() + 24*60 * 60);
      setcookie('name_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('name_value', $name, time() + 60 * 60);
      setcookie('name_error','',100000);
    }
    //проверка почты
    if (empty($email) or !preg_match($regex_email,$email)) {
      setcookie('email_error', '1', time() + 24*60 * 60);
      setcookie('email_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('email_value', $email, time() + 60 * 60);
      setcookie('email_error','',100000);
    }
    //проверка года
    if ($year=='Выбрать' or ($year<1800 and $year>2023)) {
      setcookie('year_error', '1', time() + 24 * 60 * 60);
      setcookie('year_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('year_value', intval($year), time() + 60 * 60);
      setcookie('year_error','',100000);
    }
    //проверка пола
    if (!isset($sex)  or ($sex!='1' and $sex!='2')) {
      setcookie('sex_error', '1', time() + 24 * 60 * 60);
      setcookie('sex_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('sex_value', $sex, time() + 60 * 60);
      setcookie('sex_error','',100000);
    }
    //проверка конечностей
    if (!isset($limb)) {
      setcookie('limb_error', '1', time() + 24 * 60 * 60);
      setcookie('limb_value', '', 100000);
      $errors = TRUE;
    }
    else {
      setcookie('limb_value', $limb, time() + 60 * 60);
      setcookie('limb_error','',100000);
    }
    //проверка суперспособностей
    if (!isset($pwrs)) {
      setcookie('form1_error', '1', time() + 24 * 60 * 60);
      setcookie('1_value', '', 100000);
      setcookie('2_value', '', 100000);
      setcookie('3_value', '', 100000);
      $errors = TRUE;
    }
    else {
      $a=array(
        "1_value"=>0,
        "2_value"=>0,
        "3_value"=>0
      );
      foreach($pwrs as $pwr){
        if($pwr=='1'){setcookie('1_value', 1, time() + 60 * 60); $a['1_value']=1;} 
        if($pwr=='2'){setcookie('2_value', 1, time() + 60 * 60);$a['2_value']=1;} 
        if($pwr=='3'){setcookie('3_value', 1, time() + 60 * 60);$a['3_value']=1;} 
      }
      foreach($a as $c=>$val){
        if($val==0){
          setcookie($c,'',100000);
        }
      }
    }
    
    //запись куки для биографии
    setcookie('bio_value',$bio,time()+ 60*60);
    
    //проверка согласия с политикой конфиденциальности
    if(empty($_SESSION['login'])){
      if(!isset($check)){
        setcookie('checked_error','1',time()+ 24*60*60);
        setcookie('checked_value', '', 100000);
        $errors=TRUE;
      }
      else{
        setcookie('checked_value',TRUE,time()+ 60*60);
        setcookie('checked_error','',100000);
      }
    }
    if ($errors) {
      setcookie('save','',100000);
      header('Location: login.php');
    }
    else {
      setcookie('name_error', '', 100000);
      setcookie('email_error', '', 100000);
      setcookie('year_error', '', 100000);
      setcookie('sex_error', '', 100000);
      setcookie('limb_error', '', 100000);
      setcookie('form1_error', '', 100000);
      setcookie('checked_error', '', 100000);
    }
    
    $user = 'u52821';
    $pass = '8567731';
    $db = new PDO('mysql:host=localhost;dbname=u52821', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']) and !$errors) {
    $id=$_SESSION['uid'];
    $upd=$db->prepare("update form set name=?,email=?,year=?,sex=?,limb=?,bio=? where id=?");
    $upd->execute(array($name,$email,$year,$sex,$limb,$bio,$id));
    $del=$db->prepare("delete from form1 where person_id=?");
    $del->execute(array($id));
    $upd1=$db->prepare("insert into form1 set power_id=?,person_id=?");
    foreach($pwrs as $pwr){
      $upd1->execute(array($pwr,$id));
    }
  }
  else {
    if(!$errors){
      $login = 'N'.substr(uniqid(),-6);
      $password = substr(md5(uniqid()),0,15);
      $hashed=password_hash($password,PASSWORD_DEFAULT);
      print($hashed);
      setcookie('login', $login);
      setcookie('password', $password);
      try {
        $stmt = $db->prepare("INSERT INTO form SET name=?,email=?,year=?,sex=?,limb=?,bio=?,checked=?");
        $stmt -> execute(array($name,$email,$year,$sex,$limb,$bio,$check));
        $id=$db->lastInsertId();
        $pwr=$db->prepare("INSERT INTO form1 SET power_id=?,person_id=?");
        foreach($pwrs as $power){ 
          $pwr->execute(array($power,$id));
        }
        $usr=$db->prepare("insert into users set id=?,login=?,password=?");
        $usr->execute(array($id,$login,$hashed));
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
    }
  }
    if(!$errors){
      setcookie('save', '1');
    }
    header('Location: ./');
  }
}
