
<?php
$host = "localhost"; 
$username = "root";
$password = "";
$database = "ecommercewatch";
session_start();

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


echo $_SESSION['email'];
echo $_SESSION['username'];
echo $_SESSION['image_path'];
echo $_SESSION['created_at'];
// if (!isset($_SESSION["username"])) {
//    header("Location: loging.php");
//    exit();
// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
   $name = mysqli_real_escape_string($conn, $_POST["name"]);
   $price = floatval($_POST["price"]);
   $description = mysqli_real_escape_string($conn, $_POST["description"]);

   $target_dir = "assets/img/";
   $target_file = $target_dir . basename($_FILES["image"]["name"]);
   $image_url = $target_file; 

   if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
       echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
       $image_url = "assets/img/" . basename($_FILES["image"]["name"]);
   } else {
       echo "Sorry, there was an error uploading your file.";
   }

   $insertQuery = "INSERT INTO products (title, price, description, image_path) VALUES ('$name', $price, '$description', '$image_url')";
   if (mysqli_query($conn, $insertQuery)) {
       $product_id = mysqli_insert_id($conn);

       if (isset($_POST['colors']) && is_array($_POST['colors'])) {
           foreach ($_POST['colors'] as $color_id) {
               $insertColorQuery = "INSERT INTO product_colors (product_id, color_id) VALUES ($product_id, $color_id)";
               mysqli_query($conn, $insertColorQuery);
           }
       }

       echo "New record created successfully";
   } else {
       echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
   }
}


function getColors($conn) {
   $colors = [];
   $result = mysqli_query($conn, "SELECT * FROM colors");
   while ($row = mysqli_fetch_assoc($result)) {
       $colors[] = $row;
   }
   return $colors;
}
$colors = getColors($conn);

function getProducts($conn) {
   $products = [];
   $result = mysqli_query($conn, "SELECT p.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS color_names
                                   FROM products p
                                   LEFT JOIN product_colors pc ON p.id = pc.product_id
                                   LEFT JOIN colors c ON pc.color_id = c.id
                                   GROUP BY p.id");
   while ($row = mysqli_fetch_assoc($result)) {
       $products[] = $row;
  
   }
   return $products;
}
$products = getProducts($conn);

// Read Colors
$colors = getColors($conn);


$products = getProducts($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container {
            margin-bottom: 20px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 10px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="file"] {
            padding: 0;
        }

        .color-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .color-option input {
            margin-right: 5px;
        }

        button {
            padding: 12px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .product-list h2 {
            margin-top: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .product-list ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .product-list li {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            flex: 2;
        }

        .product-image {
            flex: 1;
            overflow: hidden;
            border-radius: 4px;
        }

        .product-image img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Add Product Form -->
    <div class="container">
        <div class="form-container">
            <h2>Add Product</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="name">Product Name:</label>
                <input type="text" name="name" required>

                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" required>

                <label for="description">Description:</label>
                <textarea name="description" required></textarea>

                <label for="image">Image:</label>
                <input type="file" name="image" accept="image/*" required>

                <label for="colors">Colors:</label>
                <?php foreach ($colors as $color): ?>
                    <div class="color-option">
                        <input type="checkbox" name="colors[]" value="<?php echo $color['id']; ?>">
                        <label><?php echo $color['name']; ?></label>
                    </div>
                <?php endforeach; ?>

                <button type="submit" name="create">Add Product</button>
            </form>
        </div>

        <hr>

        <div class="product-list">
            <h2>Product List</h2>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <div class="product-info">
                            <strong><?php echo $product['title']; ?></strong><br>
                            <span class="price">Price: <?php echo $product['price']; ?></span><br>
                            <span class="description">Description: <?php echo $product['description']; ?></span><br>
                            <span class="colors">Colors: <?php echo $product['color_names']; ?></span>
                        </div>
                        <div class="product-image">
                            <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['title']; ?>">
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
