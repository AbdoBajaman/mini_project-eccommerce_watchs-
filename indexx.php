<?php
session_start();

// echo $_SESSION['email'];
// echo $_SESSION['username'];
// echo $_SESSION['image_path'];
// echo $_SESSION['created_at'];
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommercewatch";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}




// echo $_SESSION['img_path'];

// echo $_SESSION['created_at'];


// if (!isset($_SESSION["username"])) {
//     header("Location: loging.php");
//     exit();
// }

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CRUD Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('assets/img/clock-face-glowing-midnight-time-up-generative-ai.jpg');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container{
            color: white;
        }
        .navbar {
            /* background-color: #435d7d; */
            
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white;
        }

        .profile-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
        }

        .profile-info {
            display: none;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }

        .table-title {
            padding: 16px 30px;
            margin: -20px -25px 10px;
            border-radius: 10px 10px 0 0;
            background-color: #343a40;
            color: white;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .container {
            margin-top: 20px;
        }

        .btn-success,
        .btn-danger {
            margin-right: 5px;
        }
     
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a style="color:white" class="navbar-brand" href="#">Rolax</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a style="color:white" class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a style="color:white" class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Products</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a style="color: green;" href="create.php" class="btn btn-success"><i class="material-icons" data-toggle="tooltip" title="Create">&#xE147;</i>Create product</a>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Colors</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['title']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['description']; ?></td>
                            <td><img src="<?php echo $product['image_path']; ?>" alt="Product Image" style="max-width: 100px;"></td>
                            <td>
                                <?php
                                $productId = $product['id'];
                                $colorQuery = "SELECT colors.name FROM product_colors
                                               JOIN colors ON product_colors.color_id = colors.id
                                               WHERE product_colors.product_id = $productId";
                                $colorResult = mysqli_query($conn, $colorQuery);

                                while ($color = mysqli_fetch_assoc($colorResult)) {
                                    // print_r( $color);
                                    echo '<span class="badge badge-secondary">' . $color['name'] . '</span> ';
                                }
                                ?>
                            </td>
                            <td>
                                <a style="color: orange;" href="edit.php?id=<?php echo $product['id']; ?>" class="btn btn-warning"><i class="material-icons" data-toggle="tooltip" title="Edit">Edit</i></a>
                                <a style="color: red;" href="delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger"><i  class="material-icons" data-toggle="tooltip" title="Delete">Delete</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>        
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>



</body>
</html>
