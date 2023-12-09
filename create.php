<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommercewatch";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $price = floatval($_POST["price"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);

    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image_url = $target_file; 

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_url = "assets/img/" . basename($_FILES["image"]["name"]);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $insertQuery = "INSERT INTO products (title, price, description, image_path) VALUES ('$title', $price, '$description', '$image_url')";

    if (mysqli_query($conn, $insertQuery)) {
        $productId = mysqli_insert_id($conn);

        if (isset($_POST['colors'])) {
            $selectedColors = $_POST['colors'];
            foreach ($selectedColors as $colorId) {
                $insertColorsQuery = "INSERT INTO product_colors (product_id, color_id) VALUES ($productId, $colorId)";
                mysqli_query($conn, $insertColorsQuery);
            }
        }

        echo "Product created successfully";
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CRUD Create Product</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="./static/css/style.css">
    <style>
        body {
            background-image: url('assets/img/clock-face-glowing-midnight-time-up-generative-ai.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #fff; 
        }

        .container-xl {
            background-color: rgba(188, 158, 158, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            margin: 30px 0;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #343a40;
            color: #fff;
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Create New <b>Product</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="indexx.php" class="btn btn-success"><i class="material-icons">&#xeaa7;</i> <span>Back to Home</span></a>
                    </div>
                </div>
            </div>

            <form style="color: black;" action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>name</label>
                    <input type="text" name="title" maxlength="200" class="form-control" required id="id_title">
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01" class="form-control" required id="id_price">
                </div>

                <div class="form-group">
                    <label for="formFile" class="form-label">Image</label>
                    <div class="custom-file">
                        <input type="file" name="image" accept="image/*" class="form-control" required id="id_image">
                    </div>
                </div>

       
<div class="form-group">
    <label>Colors</label>
    <?php
    $colorQuery = "SELECT * FROM colors";
    $colorResult = mysqli_query($conn, $colorQuery);

    while ($color = mysqli_fetch_assoc($colorResult)) {

        echo '<div style="color:black;" class="form-check">';
        echo '<input class="form-check-input" type="checkbox" name="colors[]" id="color' . $color['id'] . '" value="' . $color['id'] . '" >';
        echo '<label class="form-check-label" for="color' . $color['id'] . '">' . $color['name'] . '</label>';
        echo '</div>';
    }
    ?>
</div>

                    
      

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" cols="40" rows="10" class="form-control" required id="id_description"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>
</div> 

</body>
</html>

