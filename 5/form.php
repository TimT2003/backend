<head>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
  <div class="fr1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" /> <br>
    <label> Почта </label> <br>
    <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"/> <br>
    <label> Год рождения </label> <br>
    <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
      <option value="Выбрать">Выбрать</option>
    <?php
        for($i=2000;$i<=2023;$i++){
          if($values['year']==$i){
            printf("<option value=%d selected>%d год</option>",$i,$i);
          }
          else{
            printf("<option value=%d>%d год</option>",$i,$i);
          }
        }
    ?>
    </select> <br>
    <label> Ваш пол </label> <br>
    <div <?php if ($errors['gender']) {print 'class="error"';} ?>>
      <input name="gender" type="radio" value="1" <?php if($values['gender']=="1") {print 'checked';} ?>/> Мужчина
      <input name="gender" type="radio" value="2" <?php if($values['gender']=="2") {print 'checked';} ?>/> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div <?php if ($errors['limb']) {print 'class="error"';} ?>>
      <input name="limb" type="radio" value="1" <?php if($values['limb']=="1") {print 'checked';} ?>/> 1 
      <input name="limb" type="radio" value="2" <?php if($values['limb']=="2") {print 'checked';} ?>/> 10
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="power[]" size="3" multiple <?php if ($errors['powers']) {print 'class="error"';} ?>>
      <option value="1" <?php if($values['1']==1){print 'selected';} ?>>Проход сквозь стены</option>
      <option value="2" <?php if($values['2']==1){print 'selected';} ?>>Дыхание под водой</option>
      <option value="3" <?php if($values['3']==1){print 'selected';} ?>>Ночное зрение</option>
    </select> <br>
    <label> Краткая биография </label> <br>
    <textarea name="bio" rows="10" cols="15"><?php print $values['bio']; ?></textarea> <br>
    <?php 
    $cl_e='';
    $ch='';
    if($values['checkin'] or !empty($_SESSION['login'])){
      $ch='checkin';
    }
    if ($errors['checkin']) {
      $cl_e='class="error"';
    }
    if(empty($_SESSION['login'])){
    print('
    <div  '.$cl_e.' >
    <input name="checkin" type="checkbox" '.$ch.'> Вы согласны с пользовательским соглашением <br>
    </div>');}
    ?>
    <input type="submit" value="Отправить"/>
  </form>
  <?php
  if(empty($_SESSION['login'])){
   echo'
   <div class="login">
    <p>Если у вас есть аккаунт, вы можете <a href="login.php">войти</a></p>
   </div>';
  }
  else{
    echo '
    <div class="logout">
      <form action="index.php" method="post">
        <input name="logout" type="submit" value="Выйти">
      </form>
    </div>';
  } ?>
  </div>
</body>
