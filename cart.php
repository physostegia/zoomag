<?php
include 'server.php';
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$username = $_SESSION['username'];

$services_query = "SELECT 
    cart_items.quantity, 
    cart_items.product_id, 
    cart_items.id, 
    products.price
FROM cart_items
JOIN products ON cart_items.product_id = products.id
where user_id ='$username'";
$services_result = mysqli_query($db, $services_query);

if ($services_result) {
    $services = mysqli_fetch_all($services_result, MYSQLI_ASSOC);
} else {
    
    echo "Error fetching services: " . mysqli_error($db);
}
$amount;
foreach($services as $service)
{
$amount += $service['price'] * $service['quantity'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Pet Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .quantity-input {
            width: 70px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Shopping Cart</h2>

        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Sample Cart Item -->
                        <?php foreach ($services as $service) : ?>
                            <div class="cart-item d-flex gap-3 mb-4 pb-4 border-bottom">
                                <img src="https://placehold.co/200x200" class="rounded" alt="Product">

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="mb-0">Premium Dog Food</h5>
                                        <form action="server.php" method="POST">
                                        <input type="hidden" name="product" value="<?php echo $service['product_id']; ?>">
                                        <button type="submit" name="delete_from_cart" class="btn btn-link text-danger p-0">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        </form>
                                    </div>

                                    <p class="text-muted mb-3"><?php echo $service['price']; ?></p>

                                    <div class="d-flex align-items-center gap-2">
                                        <form action="server.php" method="POST">
                                            <input type="hidden" name="product" value="<?php echo $service['product_id']; ?>">
                                            <button type="submit" name="decrease_quantity" value="decrease" class="btn btn-outline-secondary btn-sm">-</button>
                                        </form>
                                        <form action="server.php" method="POST">
                                            <p class="form-control quantity-input text-center"><?php echo $service['quantity']; ?></p>
                                            <input type="hidden" name="product" value="<?php echo $service['product_id']; ?>">
                                        <button type="submit" name="increase_quantity" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                    </form>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <p class="h5 mb-0"><?php echo $service['price'] * $service['quantity'] . '$'; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- More cart items would be added here -->
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>$59.98</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>$5.99</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span>Tax</span>
                            <span>$6.59</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4 pt-4 border-top">
                            <span class="h5 mb-0">Total</span>
                            <span class="h5 mb-0"><?php echo $amount . '$'; ?></span>
                        </div>
                            <form action="server.php" method="POST">
                                <input type="hidden" name="price" value="<?php echo $amount . '$'; ?>">
                        <button type="submit" name="order" class="btn btn-primary w-100">Proceed to Checkout</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>