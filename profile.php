<?php
// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "ecommercewatch";

// $conn = mysqli_connect($host, $username, $password, $database);

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
session_start();

// echo $_SESSION['email'];
// echo $_SESSION['username'];
// echo $_SESSION['image_path'];
// echo $_SESSION['created_at'];


// $email = mysqli_real_escape_string($conn, $_SESSION['email']);

// $sql = "SELECT * FROM users where id=";
// $result = mysqli_query($conn, $sql);

// $users = [];
// while ($row = mysqli_fetch_assoc($result)) {
//     $users[] = $row;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
          margin-top: 20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;
    background-image: url('assets/img/clock-face-glowing-midnight-time-up-generative-ai.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
        }

        .main-body {
            padding: 15px;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem!important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100%!important;
        }

        .shadow-none {
            box-shadow: none!important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="main-body">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div style="height: 412px;" class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="<?php echo $_SESSION['image_path'] ?>" alt="No img" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?php echo $_SESSION['username'] ?></h4>
                                <p class="text-secondary mb-1">Full Stack Developer</p>
                                <p class="text-muted font-size-sm">Yemen Hadramout-Bwish</p>
                                <!-- <button class="btn btn-primary">Follow</button>
                                <button class="btn btn-outline-primary">Message</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Profile details go here -->

                        <!-- Example detail -->
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $_SESSION['username'] ?>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $_SESSION['email'] ?>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">User</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Admin
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone number</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                +96773087640
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Country</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Yemen
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Age</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                24
                            </div>
                        </div>
                        <hr>


                        <!-- Back to Index Button -->
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-info" href="indexx.php">Back to Home page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>