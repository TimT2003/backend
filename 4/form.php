<head>
  <link rel="stylesheet" href="style1.css" type="text/css">
  <style>
    .error {
      margin: 0 auto 2px auto;
      width: 200px;
      border: 2px solid red;
    }
  </style>
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
  <div class="power1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> name_value="<?php print $values['name']; ?>" /> <br>
    <label> Почта </label> <br> 
    <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?>email_value="<?php print $values['email']; ?>" /> <br>
    <label>
      <?php
        printf('Год рождения:');
      ?>
      <br>
      <input name="year" placeholder="year" <?php if ($errors['year']) {print 'class="error"';} ?> year_value="<?php print $values['year']; ?>">
      </label>
    </select> <br>
    <label> Ваш пол </label> <br>
    <div <?php if ($errors['gender']) {print 'class="error"';} ?>gender_value="<?php print $value['gender']; ?>">
      <input name="gender" type="radio" value="1" /> Мужчина
      <input name="gender" type="radio" value="2" /> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div <?php if ($errors['limb']) {print 'class="error"';} ?>limb_value="<?php print $values['limb']; ?>">
      <input name="limb" type="radio" value="1" /> 1 
      <input name="limb" type="radio" value="2" /> 10
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="power[]" size="3" multiple <?php if ($errors['power']) {print 'class="error"';} ?>power_value="<?php print $values['power']; ?>">
      <option value="1">Проход сквозь стены</option>
      <option value="2">Дыхание под водой</option>
      <option value="3">Ночное зрение</option>
    </select> <br>
    <label> Краткая биография </label> <br>
    <textarea <?php if ($errors['bio']) {print 'class="error"';} ?> bio_value="<?php print $values['bio']; ?>" name="bio" rows="10" cols="15"></textarea> <br>
    <div  <?php if ($errors['checkin']) {print 'class="error"';} ?> checkin_value="<?php print $values['checkin']; ?>">
    <input name="checkin" type="checkbox"> Вы согласны с пользовательским соглашением <br>
    </div>
    <input type="submit" value="Отправить"/>
  </form>
  </div>
</body>
