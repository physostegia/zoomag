<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="loginStyle.css">
    <script src="scripts.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <div class="header">
        <h2>Регистрация</h2>
  </div>
        
  <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
          <label>Имя пользователя</label>
          <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
          <label>Почта</label>
          <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
          <label>Пароль</label>
          <input type="password" name="password_1">
        </div>
        <div class="input-group">
          <label>Подтвердите пароль</label>
          <input type="password" name="password_2">
        </div>
        <div class="input-group">
          <button type="submit" class="btn" name="reg_user">Регистрация</button>
        </div>
        <p>
                ПРИ АККАУНТЕ? <a href="login.php">вход</a>
        </p>
  </form>
</body>
</html>