<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommercewatch";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    // Retrieve form data
    $productId = mysqli_real_escape_string($conn, $_GET["id"]);
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $price = mysqli_real_escape_string($conn, $_POST["price"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);

    $updateQuery = "UPDATE products SET title = '$title', price = '$price', description = '$description' WHERE id = $productId";

    if (mysqli_query($conn, $updateQuery)) {
        if (isset($_POST['colors'])) {
            // Delete existing colors for the product
            $deleteColorsQuery = "DELETE FROM product_colors WHERE product_id = '$productId'";
            mysqli_query($conn, $deleteColorsQuery);

            // Insert selected colors
            $selectedColors = $_POST['colors'];
            foreach ($selectedColors as $colorId) {
                $insertColorsQuery = "INSERT INTO product_colors (product_id, color_id) VALUES ($productId, $colorId)";
                mysqli_query($conn, $insertColorsQuery);
            }
        }

        header("Location: indexx.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $productId = mysqli_real_escape_string($conn, $_GET["id"]);

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $product = mysqli_fetch_assoc($result);

        $selectedColorsQuery = "SELECT color_id FROM product_colors WHERE product_id = $productId";
        $selectedColorsResult = mysqli_query($conn, $selectedColorsQuery);

        $selectedColorIds = [];
        while ($row = mysqli_fetch_assoc($selectedColorsResult)) {
            $selectedColorIds[] = $row['color_id'];
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit();
    }
} else {
    header("Location: indexx.php");
    exit();
}

$allColorsQuery = "SELECT * FROM colors";
$allColorsResult = mysqli_query($conn, $allColorsQuery);

$allColors = [];
while ($row = mysqli_fetch_assoc($allColorsResult)) {
    $allColors[] = $row;
}

// mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('assets/img/clock-face-glowing-midnight-time-up-generative-ai.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container-xl {
            margin-top: 20px;
        }

        .table-responsive {
            padding: 15px;
        }

        .table-wrapper {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            background-color: rgba(255, 255, 255, 0.8); /* Background color with some transparency */
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
            padding: 20px;
        }

        .table-title h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Edit <b>Product</b></h2>
                        </div>
                    </div>
                </div>

                <form action="#" method="post">
                    <div class="form-group">
                        <label for="title">Name:</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $product['title']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" class="form-control" required><?php echo $product['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="colors">Colors:</label>
                        <?php
                        foreach ($allColors as $color) {
                            $checked = in_array($color['id'], $selectedColorIds) ? 'checked' : '';
                            echo '<div class="form-check">';
                            echo '<input class="form-check-input" type="checkbox" name="colors[]" id="color' . $color['id'] . '" value="' . $color['id'] . '" ' . $checked . '>';
                            echo '<label class="form-check-label" for="color' . $color['id'] . '">' . $color['name'] . '</label>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="edit" class="btn btn-primary"><i class="material-icons">&#xE254;</i> <span>Edit</span></button>
                        <a href="indexx.php" class="btn btn-success"><i class="material-icons">&#xeaa7;</i> <span>Cancel</span></a>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</body>
</html>
