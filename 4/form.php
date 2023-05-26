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
  <div class="form1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?>  /> <br>
    <label> Почта </label> <br>
    <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> /> <br>
    <label> Год рождения </label> <br>
    <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
      <option value="Выбрать">Выбрать</option>
    <?php
        for($i=2000;$i<=2022;$i++){
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
      <input name="gender" type="radio" value="1"  /> Мужчина
      <input name="gender" type="radio" value="2"/> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div <?php if ($errors['limb']) {print 'class="error"';} ?>>
      <input name="limb" type="radio" value="1" /> 1 
      <input name="limb" type="radio" value="2" /> 10 
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="power[]" size="3" multiple <?php if ($errors['powers']) {print 'class="error"';} ?>>
      <option value="1" >Проход сквозь стены</option>
      <option value="2" >Дыхание под водой</option>
      <option value="3" >Ночное зрение</option>
    </select> <br>
    <label> Краткая биография </label> <br>
    <textarea name="bio" rows="10" cols="15"></textarea> <br>
    <div  <?php if ($errors['check']) {print 'class="error"';} ?>>
    <input name="checkin" type="checkbox"> Вы согласны с пользовательским соглашением <br>
    </div>
    <input type="submit" value="Отправить"/>
  </form>
  </div>
</body>
