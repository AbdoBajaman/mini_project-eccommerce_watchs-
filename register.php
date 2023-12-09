
<?php
$host = "localhost"; // e.g., localhost
$username = "root";
$password = "";
$database = "ecommercewatch";

$conn = mysqli_connect($host, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Handle image upload
    $targetDirectory = "assets/img/";
    $image_url = $targetDirectory . basename($_FILES["image"]["name"]);

    // Check if the "image" key exists in the $_FILES array
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_url)) {
            // Image uploaded successfully
            $image_url = "assets/img/" . basename($_FILES["image"]["name"]);
        } else {
            // Error uploading the file
            $_SESSION["error"] = "Sorry, there was an error uploading your file.";
            header("Location: register.php"); // Redirect back to registration page
            exit();
        }
    } else {
        // No image uploaded or an error occurred
        $_SESSION["error"] = "No image uploaded or an error occurred.";
        header("Location: register.php"); // Redirect back to registration page
        exit();
    }

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password, image_path) VALUES ('$username', '$email', '$password', '$image_url')";

    if (mysqli_query($conn, $sql)) {
        // Registration successful
        $_SESSION["success"] = "Registration successful";

        // Retrieve user data and store in session
        $sql = "SELECT email, username, image_path, created_at FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $user_data = mysqli_fetch_assoc($result);

        $_SESSION["email"] = $user_data["email"];
        $_SESSION["username"] = $user_data["username"];
        $_SESSION["img_path"] = $user_data["image_path"];
        $_SESSION["created_at"] = $user_data["created_at"];

        header("Location: loging.php"); // Redirect to indexx.php
        exit();
    } else {
        $_SESSION["error"] = "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: register.php"); // Redirect back to registration page
        exit();
    }
}

// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input required class="au-input au-input--full" type="text" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input required class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input required class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
        <label for="formFile" class="form-label">Image</label>
        <div class="custom-file">
            <input aria-required="" type="file" name="image" accept="image/*" class="form-control" required id="id_image">
        </div>
    </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="aggree">Agree the terms and policy
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>
                                <!-- <div class="social-login-content">
                                    <div class="social-button">
                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">register with facebook</button>
                                        <button class="au-btn au-btn--block au-btn--blue2">register with twitter</button>
                                    </div>
                                </div> -->
                                <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="loging.php">Sign In</a>
                                </p>
                            </div>
                            </form>
              
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->