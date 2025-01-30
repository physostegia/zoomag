<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
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
  <header></header>
  
    
        <h2 class="center">Вход</h2>
  
         
  <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
                <label>Имя пользователя</label>
                <input type="text" name="username" >
        </div>
        <div class="input-group">
                <label>Пароль</label>
                <input type="password" name="password">
        </div>
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">вход</button>
        </div>
        <p>
                БЕЗ АККАУНТА ЛОЛ? <a href="register.php">регистрация</a>
        </p>
  </form>
  
  
</body>
