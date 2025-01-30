<?php
session_start();


$username = "";
$email    = "";
$errors = array(); 


$db = mysqli_connect('localhost', 'root', '', 'zoo', 3306);



if (isset($_POST['reg_user'])) {
 
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

 
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
  }

  $services = "SELECT * FROM services";
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { 
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  
  if (count($errors) == 0) {
        $password = md5($password_1);

        $query = "INSERT INTO users (username, email, password) 
                          VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: catalog.php');
  }
}
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
          array_push($errors, "Username is required");
    }
    if (empty($password)) {
          array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
          $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
          $results = mysqli_query($db, $query);
          if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: catalog.php');
          }else {
                  array_push($errors, "Wrong username/password combination");
          }
    }
  }
  
  
  if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product'];
    $user_id = $_SESSION['username'];
    
   
    $query = "SELECT * FROM cart_items WHERE user_id='$user_id' AND product_id='$product_id'";
    $results = mysqli_query($db, $query);
    
    if (mysqli_num_rows($results) > 0) {
       
        $update = "UPDATE cart_items SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'";
        mysqli_query($db, $update);
    } else {
        
        $insert = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)";
        mysqli_query($db, $insert);
    }
    
    header("Location: catalog.php"); 
    
}

if (isset($_POST['increase_quantity'])) {
  $product_id = $_POST['product'];
  $user_id = $_SESSION['username'];
 
  
  echo $product_id . " "; 
  echo $user_id; 
      $query = "UPDATE cart_items SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'";
 
 
  mysqli_query($db, $query);
  header("Location: cart.php"); 
 
}
if (isset($_POST['decrease_quantity'])) {
  $product_id = $_POST['product'];
  $user_id = $_SESSION['username'];
  
  
 
      $query = "UPDATE cart_items SET quantity = GREATEST(quantity - 1, 1) WHERE user_id='$user_id' AND product_id='$product_id'";
  
 
  mysqli_query($db, $query);
 
  header("Location: cart.php"); 
}
if (isset($_POST['delete_from_cart'])) {
  $product_id = $_POST['product'];
  $user_id = $_SESSION['username'];
  
  
 
      $query = "DELETE FROM cart_items 
                WHERE user_id = '$user_id' AND product_id = '$product_id'";
  
 
  mysqli_query($db, $query);
 
  header("Location: cart.php"); 
}

if (isset($_POST['order'])) {
  $user_order_id = $_SESSION['username'];
  $price = $_POST['amount'];
    
echo 1;
    // Шаг 1: Создаем новый заказ в таблице orders
    $order_number = "ORD-" . date("Y-m-d") . "-" . rand(100, 999); // Генерация уникального номера заказа
    $order_date = date("Y-m-d H:i:s"); // Текущее время
    $status = "pending"; // Статус заказа по умолчанию
    echo 2;
    echo $user_order_id . ' ';
    echo $order_number . ' ';
    echo $order_date . ' ';
    echo $status . ' ';
    echo $price . ' ';
    // Вставляем заказ в таблицу orders
    $query_order = "INSERT INTO orders (user_id, order_number, order_date, status, total_amount)
                    VALUES ('$user_order_id', '$order_number', '$order_date', '$status', '$price')";
    mysqli_query($db, $query_order);

    // Получаем id только что вставленного заказа
    $order_id = mysqli_insert_id($db);
    echo $order_id;
    // Шаг 2: Переносим товары из корзины в order_items
    // Получаем все товары из корзины для текущего пользователя
    $query_cart = "SELECT user_id,product_id,quantity,price FROM cart_items JOIN products on products.id = product_id WHERE user_id = '$user_id' ";
    $result_cart = mysqli_query($db, $query_cart);
    $products = mysqli_fetch_all($result_cart, MYSQLI_ASSOC);
    echo 4;
    foreach($products as $product) {
      echo 5;
      $unit = $product['product_id'];
      $quantity = $product['quantity'];
      $price_per_unit = $product['price'];
      $price_amount = $product['price'] * $product['quantity'];
        // Вставляем товар в таблицу order_items
        $query_order_items = "INSERT INTO order_items (order_id, product_id, quantity, price_per_unit, total_price)
                              VALUES ('$order_id', '$unit', '$quantity', '$price_per_unit', '$price_amount')";
        mysqli_query($db, $query_order_items);

       
        
    }

   
    // Шаг 4: Удаляем товары из корзины
    $query_delete_cart = "DELETE FROM cart_items WHERE user_id = '$user_id'";
    mysqli_query($db, $query_delete_cart);

    // Перенаправляем на страницу заказов или на другую страницу
    
}
?>

