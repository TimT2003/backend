<head>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<style>
  .error {
    border: 2px solid red;
  }
  table {
  text-align: center;
  border-spacing: 100px 0;
}
</style>
<body>
  <div class="table">
    <table>
      <tr>
        <th>Имя</th>
        <th>Почта</th>
        <th>Год</th>
        <th>Пол</th>
        <th>Кол-во конечностей</th>
        <th>Сверхсилы</th>
        <th>Био</th>
      </tr>
      <?php
      foreach($users as $user){
      ?>
            <tr>
              <td><?= $user['name']?></td>
              <td><?= $user['email']?></td>
              <td><?= $user['year']?></td>
              <td><?= $user['gender']?></td>
              <td><?= $user['limb']?></td>
              <td><?php 
                $user_pwrs=array(
                    "1"=>FALSE,
                    "2"=>FALSE,
                    "3"=>FALSE
                );
                foreach($pwrs as $pwr){
                    if($pwr['person_id']==$user['id']){
                        if($pwr['power_id']=='1'){
                            $user_pwrs['1']=TRUE;
                        }
                        if($pwr['power_id']=='2'){
                            $user_pwrs['2']=TRUE;
                        }
                        if($pwr['power_id']=='3'){
                            $user_pwrs['3']=TRUE;
                        }
                    }
                }
                if($user_pwrs['1']){echo 'Проход сквозь стены<br>';}
                if($user_pwrs['2']){echo 'Дыхание под водой<br>';}
                if($user_pwrs['3']){echo 'Ночное зрение<br>';}?>
              </td>
              <td><?= $user['bio']?></td>
              <td>
                <form method="get" action="edit.php">
                  <input name=edit_id value="<?= $user['id']?>" hidden>
                  <input type="submit" value=Edit>
                </form>
              </td>
            </tr>
      <?php
       }
      ?>
    </table>
    <?php
    printf('Кол-во пользователей с сверхспособностью "Проход сквозь стены": %d <br>',$pwrs_count[0]);
    printf('Кол-во пользователей с сверхспособностью "Дыхание под водой": %d <br>',$pwrs_count[1]);
    printf('Кол-во пользователей с сверхспособностью "Ночное зрение": %d <br>',$pwrs_count[2]);
    ?>
  </div>
</body>
