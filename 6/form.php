<head>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<style>
  .error {
    border: 2px solid red;
  }
</style>
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
  <form action="edit.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" /> <br>
    <label> Почта </label> <br>
    <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>"/> <br>
    <label> Год рождения </label> <br>
    <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
      <option value="Выбрать">Выбрать</option>
    <?php
        for($i=1800;$i<=2022;$i++){
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
    <div <?php if ($errors['sex']) {print 'class="error"';} ?>>
      <input name="sex" type="radio" value="1" <?php if($values['sex']=="1") {print 'checked';} ?>/> Мужчина
      <input name="sex" type="radio" value="2" <?php if($values['sex']=="2") {print 'checked';} ?>/> Женщина
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div <?php if ($errors['limb']) {print 'class="error"';} ?>>
      <input name="limb" type="radio" value="1" <?php if($values['limb']=="1") {print 'checked';} ?>/> 1 
      <input name="limb" type="radio" value="2" <?php if($values['limb']=="2") {print 'checked';} ?>/> 2 
      <input name="limb" type="radio" value="3" <?php if($values['limb']=="3") {print 'checked';} ?>/> 3 
      <input name="limb" type="radio" value="4" <?php if($values['limb']=="4") {print 'checked';} ?>/> 4 
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="form1[]" size="3" multiple <?php if ($errors['form1']) {print 'class="error"';} ?>>
      <option value="1" <?php if($values['1']==1){print 'selected';} ?>>Бессмертие</option>
      <option value="2" <?php if($values['2']==1){print 'selected';} ?>>Телепортация</option>
      <option value="3" <?php if($values['3']==1){print 'selected';} ?>>Телепатия</option>
    </select> <br>
    <label> Краткая биография </label> <br>
    <textarea name="bio" rows="10" cols="15"><?php print $values['bio']; ?></textarea> <br>
    <input name='id' hidden value=<?php print($_GET['edit_id']);?>>
    <input type="submit" name='edit' value="Изменить"/>
    <input type="submit" name='del' value="Удалить"/>
  </form>
  </div>
  <form action="admin.php" method="POST">
    <input type="submit" name="back" value="Назад">
  </form>
</body>
