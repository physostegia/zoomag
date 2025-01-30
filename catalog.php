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


$services_query = "SELECT * FROM products";
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
    <title>Products - Pet Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        .filters-sidebar {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="filters-sidebar">
                    <h4 class="mb-4">Filters</h4>
                    
                    <div class="mb-4">
                        <label class="form-label">Category</label>
                        <select class="form-select">
                            <option value="all">All Products</option>
                            <option value="dog-food">Dog Food</option>
                            <option value="cat-food">Cat Food</option>
                            <option value="toys">Toys</option>
                            <option value="accessories">Accessories</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Price Range</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Min">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Max">
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary w-100">Apply Filters</button>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Our Products</h2>
                    <div class="d-flex gap-2">
                        <input type="search" class="form-control" placeholder="Search products...">
                        <select class="form-select" style="width: 200px;">
                            <option value="newest">Newest First</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                        </select>
                    </div>
                </div>
                
                <div class="row g-4">
                    <!-- Sample Product Card -->
                    <?php foreach ($services as $service) : ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card product-card h-100">
                            <img src="https://placehold.co/400x300" class="card-img-top product-img" alt="Product">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $service['sku']; ?></h5>
                                <p class="card-text text-muted"><?php echo $service['description']; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0"><?php echo $service['price']; ?></span>
                                    <form action="server.php" method="POST">
                                    <input type="hidden" name="product" value="<?php echo $service['id']; ?>">
                                    <button type="submit" name="add_to_cart" class="btn btn-primary" >Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- More product cards would be added here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>