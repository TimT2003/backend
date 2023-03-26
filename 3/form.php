<head>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<style>
    .form1{
        max-width: 700px;
        text-align: center;
        margin: 0 auto;
    }
</style>
<body>
  <div class="form1">
  <form action="index.php" method="POST">
    <label> ФИО </label> <br>
    <input name="name" /> <br>
    <label> Почта </label> <br>
    <input name="email" type="email" /> <br>
    <label> Год рождения </label> <br>
    <select name="year">
      <option value="Выбрать">Выбрать</option>
    <?php
        for($i=2000;$i<=2022;$i++){
          printf("<option value=%d>%d год</option>",$i,$i);
        }
    ?>
    </select> <br>
    <label> Ваш пол </label> <br>
    <div>
      <input name="gender" type="radio" value="1" /> M
      <input name="gender" type="radio" value="2" /> Ж
    </div>
    <label> Сколько у вас конечностей </label> <br>
    <div>
      <input name="limb" type="radio" value="1" /> 1 
      <input name="limb" type="radio" value="2" /> 10
    </div>
    <label> Выберите суперспособности </label> <br>
    <select name="power[]" size="3" multiple>
      <option value="1">Проход сквозь стены</option>
      <option value="2">Дыхание под водой</option>
      <option value="3">Ночное зрение</option>
       <option value="4">Уметь делать сальто назад</option>
        
    </select> <br>
    <label> Биография </label> <br>
    <textarea name="bio" rows="10" cols="15"></textarea> <br>
    <input name="checkin"  type="checkbox" value="on"> Согласиться <br>
    <input type="submit" value="Отправить"/>
  </form>
  </div>
</body>
