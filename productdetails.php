<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "ecommercewatch";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

  
    $productSql = "SELECT * FROM products WHERE id = $productId";
    $productResult = mysqli_query($conn, $productSql);

    if ($productResult) {
        $product = mysqli_fetch_assoc($productResult);
    } else {
        echo "Error fetching product details: " . mysqli_error($conn);
    }

    $colorSql = "SELECT colors.name FROM product_colors
                 JOIN colors ON product_colors.color_id = colors.id
                 WHERE product_colors.product_id = $productId";

    $colorResult = mysqli_query($conn, $colorSql);

    if ($colorResult) {
        $colors = [];
        while ($color = mysqli_fetch_assoc($colorResult)) {
            $colors[] = $color['name'];
        }
    } else {
        echo "Error fetching colors: " . mysqli_error($conn);
    }
} else {
    echo "Product ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('assets/img/clock-face-glowing-midnight-time-up-generative-ai.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            color: #333;
            margin-top: 20px;
        }

        .product-details {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            display: flex;
            flex-direction: column;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .product-info {
            padding-left: 20px;
        }

        .product-info h2 {
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #555;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="product-details">
        <div style="display: flex; align-items: center;">
            <div>
                <img style="width: 400px; height: 400px; border-radius: 10px; margin-right: 20px;" src="<?php echo $product['image_path']; ?>" alt="Product Image" class="product-image">
            </div>
            <?php if (isset($product)): ?>
                <div class="product-info">
                    <h2><?php echo $product['title']; ?></h2>
                    <p>Price: <?php echo $product['price']; ?>Rs</p>
                    <p>Description: <?php echo $product['description']; ?></p>
                    <?php if (!empty($colors)): ?>
                        <p>Colors: <?php echo implode(', ', $colors); ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>No product details found.</p>
            <?php endif; ?>
        </div>
        <div class="button-container">
            <button class="back-button" onclick="window.location.href='website.php'">Back to Website</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>
