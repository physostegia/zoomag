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


$services_query = "SELECT * FROM orders";
$services_result = mysqli_query($db, $services_query);


if ($services_result) {
    $services = mysqli_fetch_all($services_result, MYSQLI_ASSOC);
} else {
    
    echo "Error fetching services: " . mysqli_error($db);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Pet Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            margin-bottom: 20px;
        }
        .order-item {
            padding: 15px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Order History</h2>
        
        <!-- Sample Order -->
        <div class="card order-card">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-1">Order #ORD-2024-001</h5>
                        <p class="mb-0 text-muted">Placed on January 13, 2024</p>
                    </div>
                    <div class="col text-end">
                        <span class="status-badge bg-success bg-opacity-10 text-success">
                            Delivered
                        </span>
                        <h6 class="mt-2 mb-0">Total: $72.56</h6>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="order-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1">Premium Dog Food</h6>
                            <p class="mb-0 text-muted">Quantity: 2</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <p class="mb-0">$29.99 each</p>
                            <p class="mb-0 fw-bold">Total: $59.98</p>
                        </div>
                    </div>
                </div>
                
                <div class="order-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1">Dog Chew Toy</h6>
                            <p class="mb-0 text-muted">Quantity: 1</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <p class="mb-0">$12.99 each</p>
                            <p class="mb-0 fw-bold">Total: $12.99</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-1">Shipping Address:</p>
                            <p class="mb-0 text-muted">
                                123 Pet Street<br>
                                Apartment 4B<br>
                                New York, NY 10001
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-outline-primary">Track Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Another Sample Order -->
        <div class="card order-card">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-1">Order #ORD-2024-002</h5>
                        <p class="mb-0 text-muted">Placed on January 10, 2024</p>
                    </div>
                    <div class="col text-end">
                        <span class="status-badge bg-primary bg-opacity-10 text-primary">
                            In Transit
                        </span>
                        <h6 class="mt-2 mb-0">Total: $45.98</h6>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="order-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1">Cat Food Premium</h6>
                            <p class="mb-0 text-muted">Quantity: 1</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-2 mt-md-0">
                            <p class="mb-0">$45.98 each</p>
                            <p class="mb-0 fw-bold">Total: $45.98</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-1">Shipping Address:</p>
                            <p class="mb-0 text-muted">
                                123 Pet Street<br>
                                Apartment 4B<br>
                                New York, NY 10001
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-outline-primary">Track Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>