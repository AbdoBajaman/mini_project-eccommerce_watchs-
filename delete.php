<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommercewatch";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $productId = mysqli_real_escape_string($conn, $_GET["id"]);

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit();
    }
} else {
     
}
$productId = mysqli_real_escape_string($conn, $_GET["id"]);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteColorsQuery = "DELETE FROM product_colors WHERE product_id = '$productId'";
    if (!mysqli_query($conn, $deleteColorsQuery)) {
        echo "Error deleting product_colors records: " . mysqli_error($conn);
        exit();
    }

    $deleteQuery = "DELETE FROM products WHERE id = '$productId'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "success";
        header("Location: indexx.php");
        exit();
    } else {
        echo "Error deleting product record: " . mysqli_error($conn);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Delete Product</title>
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
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            margin-top: 50px;
            border-radius: 10px;
        }

        .table-responsive {
            overflow: hidden;
        }

        .table-wrapper {
            min-width: 100%;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            margin-top: 20px;
            border-radius: 10px;
        }

        .table-title {
            padding-bottom: 15px;
        }

        .table-title h2 {
            margin: 0;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group p {
            margin-bottom: 15px;
        }

        .btn-danger,
        .btn-success {
            margin-right: 10px;
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
                            <h2>Delete <b>Product</b></h2>
                        </div>
                    </div>
                </div>

                <form action="#" method="post">
                    <div class="form-group">
                        <p>Are you sure you want to delete the product?</p>
                        <strong>name:</strong> <?php echo $product['title']; ?><br>
                        <strong>Price:</strong> <?php echo $product['price']; ?>Rs<br>
                        <strong>Description:</strong> <?php echo $product['description']; ?><br>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="delete" class="btn btn-danger"><i class="material-icons">&#xE15C;</i> <span>Delete</span></button>
                        <a href="indexx.php" class="btn btn-success"><i class="material-icons">&#xeaa7;</i> <span>Cancel</span></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

