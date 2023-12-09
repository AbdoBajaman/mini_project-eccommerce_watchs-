<?php
// Database connection credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommercewatch";


// if(isset($_POST['product_price']))
// {
// // echo ($myprice);

// }
if (!function_exists('calculateTotalPrice')) {
    function calculateTotalPrice(array $prices) {
        $total = 0;
        foreach ($prices as $price) {
            $total += $price;
        }
        return $total;
    }
}

session_start();


$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
// function calculateTotalPrice($prices) {
//     return array_sum($prices);
// }
$tableName = "products";
$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

if (!mysqli_query($connection, $sql)) {
    die("Error creating table: " . mysqli_error($connection));
}

// $title = $_POST['title'];
// $price = $_POST['price'];
if (isset($_POST['add_to_cart'])) {
    $imagePath = $_POST['image_path'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $_SESSION['cart'][] = $imagePath;
    $_SESSION['title'][] = $title;
    $_SESSION['price'][] = $price;
    // print_r($_SESSION['cart']);
    $index = array_search($imagePath, $_SESSION['cart']);
    //   echo $index."this is index";

    //   $_SESSION['quantity'][$index]++;

    if ($index !== false) {
        if (isset($_SESSION['quantity'])) {
            // $_SESSION['quantity'][$index]++;

        } else {
            // $_SESSION['quantity'][$index] = 1;
        }
    } else {
        $_SESSION['cart'][] = $imagePath;
        $_SESSION['title'][] = $title;
        $_SESSION['price'][] = $price;
    }

    $addedToCart = true;
    // print_r($_SESSION['cart']);
    // print_r($_SESSION['title']);
    $_SESSION['cart_total'] = calculateTotalPrice($_SESSION['price']);
}
if (isset($_POST['delete_item'])) {
    $indexToDelete = $_POST['delete_item_index'];

    unset($_SESSION['cart'][$indexToDelete]);
    unset($_SESSION['title'][$indexToDelete]);
    unset($_SESSION['price'][$indexToDelete]);

    $_SESSION['cart'] = array_values($_SESSION['cart']);
    $_SESSION['title'] = array_values($_SESSION['title']);
    $_SESSION['price'] = array_values($_SESSION['price']);
    $_SESSION['cart_total'] = calculateTotalPrice($_SESSION['price']);
}
// function calculateTotalPrice($prices)
// {
//     $total = 0;
//     foreach ($prices as $price) {
//         $total += $price;
//     }
//     return $total;
// }

//   if (isset($_POST['add_to_cart'])) {
//     $imagePath = $_POST['image_path'];
//     $price = $_POST['price'];
//     $_SESSION['cart'][] = $imagePath;
//     $_SESSION['price'][] = $price;
//     print_r( $_SESSION['cart']);
//     print_r( $_SESSION['price']);


// }



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buy"])) {
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart_total'] = calculateTotalPrice($_SESSION['price']);
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Order done successfully!",
                    icon: "success",
                });
            });
        </script>';

        unset($_SESSION['cart']);
        unset($_SESSION['title']);
        unset($_SESSION['price']);
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Cart empty",
                icon: "info",
            });
        });
    </script>';    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Your existing CSS styles and other head content -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== BOXICONS ===============-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">


    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== SWIPER CSS ===============-->

    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <script src="vendor/sweetalert/sweetalert.min.js"></script>




    <style>
        body {
            --body-color: #ffffff;
            background-color: var(--body-color);
            color: #000000;
        }

        .dark-theme {
            --body-color: #222222;
            background-color: white;
            color: #ffffff;
        }

        .bx {
            color: #000000;
        }

        .dark-theme .bx {
            color: white;
        }

        .products__container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .products__card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .products__card:hover {
            transform: scale(1.05);
        }

        .products__card a {
            display: block;
            overflow: hidden;
            height: 250px;
        }

        .products__img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .products__details {
            padding: 20px;
        }

        .products__title {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .imgo:hover {
            transform: scale(1.1);
        }

        .products__price {
            font-size: 16px;
            font-weight: bold;
            color: #ff6347;
        }

        .products__button {
            display: flex;
            align-items: center;
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .products__button:hover {
            background-color: #45a049;
        }

        .bx-heart {
            margin-right: 5px;
        }

        .bxs-heart {
            color: red;
            margin-right: 5px;
        }
    </style>
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Bajaman </title>
    <style>
    </style>

</head>

<body style="    background-color: var(--body-color);">

    <!--==================== HEADER ====================-->
    <header style="color:white;" class="" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">
                <i sty class='bx bxs-watch nav__logo-icon'>Rolex</i>
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link active-link">Home</a>
                    </li>
                    <li class="nav__item">
                        <a href="#featured" class="nav__link">Featured</a>
                    </li>
                    <li class="nav__item">
                        <a href="#products" class="nav__link">Products</a>
                    </li>
                    <li class="nav__item">
                        <a href="#new" class="nav__link">New</a>
                    </li>
                </ul>

                <div class="nav__close" id="nav-close">
                    <i class='bx bx-x'></i>
                </div>
            </div>

            <div class="nav__btns">
                <!-- Theme change button -->
                <i class='bx bx-moon change-theme' id="theme-button"></i>

                <div class="nav__shop" id="cart-shop">
                    <i style="position: relative;" class='bx bx-shopping-bag'>
                        <i style="    position: absolute;
    left: -4px;
    top: -3px;
    font-size: 13px;
    font-family: 'Roboto';">
                            <?php
                            if (isset($_SESSION['cart'])) {
                                echo count($_SESSION["cart"]);
                            } else {
                                echo "0";
                            }


                            // 
                            ?></i>
                    </i>
                </div>

                <div class="nav__toggle" id="nav-toggle">
                    <i class='bx bx-grid-alt'></i>
                </div>
            </div>
        </nav>
    </header>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

    <!-- Modal -->
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->
    <!--==================== CART ====================-->
    <div style="overflow-y: scroll;" class="cart" id="cart">
        <i class='bx bx-x cart__close' id="cart-close"></i>

        <h2 class="cart__title-center">My Cart</h2>

        <div class="cart__container">
            <?php
            if (isset($_SESSION['cart'])) {
               

                foreach ($_SESSION['cart'] as $index => $imagePath) {
                    $title = $_SESSION['title'][$index];
                    $price = $_SESSION['price'][$index];
            ?>
                    <article class="cart__card">
                        <div class="cart__box">
                            <img src="<?php echo $imagePath; ?>" alt="" class="cart__img">
                        </div>

                        <div class="cart__details">
                            <h3 class="cart__title"><?php echo $title; ?></h3>
                            <span class="cart__price" id="price<?php echo $index; ?>"><?php echo $price; ?> Rs</span>

                            <div class="cart__amount">
                                <div class="cart__amount-content">
                                    <span class="cart__amount-box" onclick="decreaseQuantity(<?php echo $index; ?>)">
                                        <i class='bx bx-minus'></i>
                                    </span>

                                    <span id="number<?php echo $index; ?>" class="cart__amount-number">1</span>

                                    <span class="cart__amount-box" onclick="increaseQuantity(<?php echo $index; ?>)">
                                        <i class='bx bx-plus'></i>
                                    </span>
                                </div>

                                <form method="POST">
                                    <input type="hidden" name="delete_item_index" value="<?php echo $index; ?>">
                                    <button type="submit" name="delete_item" class="bx bx-trash-alt cart__amount-trash"></button>
                                </form>
                            </div>
                        </div>
                    </article>
            <?php
                }
            }
            ?>
        </div>



        <div class="cart__prices">
            <form action="" method="post">
                <button name="buy" class="cart__place-order">Place Order</button>
            </form>

            <span class="cart__prices-item"><?php if (isset($_SESSION['cart'])) {
                                                echo count($_SESSION["cart"]);
                                            } else {
                                                echo "0";
                                            } ?> items</span>
            <span class="cart__prices-total">
                <?php

         
                ?>
            </span>
        </div>
        <form method="post" id="placeOrderForm">
            <!-- <input type="hidden" name="Buy" value="1"> -->
        </form>
    </div>


    <!--==================== MAIN ====================-->
    <main class="main">
        <!--==================== HOME ====================-->
        <section class="home" id="home">
            <?php
            $query = "SELECT * FROM products ORDER BY price DESC LIMIT 1";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $imagePath = $row['image_path'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $productId = $row['id']; 
                }
            }
            ?>

            <div class="home__container container grid">
                <div class="home__img-bg">
                    <a href="productdetails.php?id=<?php echo $productId; ?>">
                        <img style="height: 400px;width:400px" src="<?php echo $imagePath; ?>" alt="" class="featured__img imgo">
                    </a>
                </div>

                <div class="home__social">
                    <a href="https://www.facebook.com/" target="_blank" class="home__social-link">
                        Facebook
                    </a>
                    <a href="https://twitter.com/" target="_blank" class="home__social-link">
                        Twitter
                    </a>
                    <a href="https://instagram.com/da7m.bj?utm_source=qr&igshid=MzNlNGNkZWQ4Mg==" target="_blank" class="home__social-link">
                        Instagram
                    </a>
                </div>

                <div class="home__data">
                    <h1 class="home__title">NEW WATCH <br> COLLECTIONS B720</h1>
                    <p class="home__description">
                        Latest arrival of the new imported watches of <?php echo $title ?>,
                        with a modern and resistant design.
                    </p>
                    <span class="home__price"> <?php echo $price . 'Rs' ?> </span>

                    <div class="home__btns">
                        <a href="#" class="button button--gray button--small">
                            Discover
                        </a>

                        <form method="POST">
                            <input type="hidden" name="image_path" value="<?php echo $imagePath ?>">
                            <input type="hidden" name="price" value="<?php echo $price ?>">
                            <input type="hidden" name="title" value="<?php echo $title ?>">
                            <button type="submit" name="add_to_cart" class="button home__button">ADD TO CART</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <!--==================== FEATURED ====================-->
        <section class="featured section container" id="featured">
            <h2 class="section__title">
                Featured
            </h2>

            <div class="featured__container grid">
                <?php

                $query = "SELECT * FROM products ORDER BY price ASC LIMIT 6";
                $result = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    // $productId = $row['id'];
                    $imagePath = $row['image_path'];
                    $title = $row['title'];
                    $price = $row['price'];
                ?>
                    <article class="featured__card">
                        <span class="featured__tag">Sale</span>
                        <a href="productdetails.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo $imagePath; ?>" alt="" class="featured__img">
                        </a>
                        <div class="featured__data">
                            <h3 class="featured__title"><?php echo $title; ?></h3>
                            <span class="featured__price"><?php echo $price; ?>Rs</span>
                        </div>
                        <form method="post">
                            <input type="hidden" name="image_path" value="<?php echo $imagePath ?>">
                            <input type="hidden" name="title" value="<?php echo $title; ?>">
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
                            <button type="submit" class="button featured__button" name="add_to_cart">ADD TO CART</button>
                        </form>
                    </article>
                <?php } ?>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="productInfo"></div>
                    </div>
                </div>
            </div>
        </div>

        <!--==================== STORY ====================-->
        <section class="story section container">
            <?php
            $query = "SELECT * FROM products ORDER BY price DESC LIMIT 1";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $imagePath = $row['image_path'];
                    $title = $row['title'];
                    $price = $row['price'];
                }
            }

            ?>
            <div class="story__container grid">
                <div class="story__data">
                    <h2 class="section__title story__section-title">
                        Our Story
                    </h2>

                    <h1 class="story__title">
                        Inspirational Watch of <br> this year
                    </h1>

                    <p class="story__description">
                        The latest and modern watches of this year, is available in various
                        presentations in this store, discover them now.
                    </p>

                    <a href="#" class="button button--small">Discover</a>
                </div>

                <div class="story__images">
                    <img style="height: 600px; width:400px" src="<?php echo $imagePath ?>" alt="" class="story__img imgo">
                    <div class="story__square"></div>
                </div>
            </div>
        </section>

        <!--==================== PRODUCTS ====================-->
        <section class="products section container" id="products">
            <h2 class="section__title">
                Products
            </h2>

            <div class="products__container grid">
                <?php
                $query = "SELECT * FROM $tableName";
                $result = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $productId = $row['id'];
                    $imagePath = $row['image_path'];
                    $title = $row['title'];
                    $price = $row['price'];

                    $addedToCart = false;
                    if (isset($_SESSION['cart']) && in_array($imagePath, $_SESSION['cart'])) {
                        $addedToCart = true;
                    }
                ?>
                    <article class="products__card">
                        <a href="productdetails.php?id=<?php echo $productId; ?>">
                            <img src="<?php echo $imagePath; ?>" alt="" class="featured__img">
                        </a>
                        <h3 class="products__title"><?php echo $title; ?></h3>
                        <span class="products__price"><?php echo $price; ?>Rs</span>
                        <form method="POST">
                            <input type="hidden" name="image_path" value="<?php echo $imagePath ?>">
                            <input type="hidden" name="price" value="<?php echo $price ?>">
                            <input type="hidden" name="title" value="<?php echo $title ?>">

                            <button type="submit" name="add_to_cart" class="products__button">
                                <?php if ($addedToCart) { ?>
                                    <i style="color: red;" class='bx bxs-heart'></i>
                                <?php } else { ?>
                                    <i class='bx bx-heart'></i>
                                <?php } ?>
                            </button>
                        </form>
                    </article>
                <?php
                }
                ?>
            </div>
        </section>

        <!--==================== TESTIMONIAL ====================-->
        <section style="display: flex; gap: 200px;" class="testimonial section container">
            <div class="testimonial__images">
                <div class="testimonial__square"></div>
                <img style="height: 450px;" src="assets/img/pexels-mister-mister-380782.jpg" alt="" class="testimonial__img">
            </div>

            <div class="testimonial__images">
                <div class="testimonial__square"></div>
                <img src="assets/img/testimonial.png" alt="" class="testimonial__img">
            </div>
            </div>
        </section>

        <!--==================== NEW ====================-->
        <section class="new section container" id="new">
    <h2 class="section__title">
        New Arrivals
    </h2>

    <div class="new__container">
        <div class="swiper new-swiper">
            <div class="swiper-wrapper">

                <?php

                $query = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $productId = $row['id'];
                        $imagePath = $row['image_path'];
                        $title = $row['title'];
                        $price = $row['price'];
                ?>
                        <article style="height: 65%; margin-bottom: 0px" class="new__card swiper-slide">
                            <span class="new__tag">New</span>
                            <a href="productdetails.php?id=<?php echo $productId; ?>">
                                <img src="<?php echo $imagePath; ?>" alt="" class="featured__img">
                            </a>
                            <div class="new__data">
                                <h3 class="new__title"><?php echo $title; ?></h3>
                                <span class="new__price"><?php echo $price; ?></span>
                            </div>
                            <form action="#" method="POST">
                                <input type="hidden" name="image_path" value="<?php echo $imagePath ?>">
                                <input type="hidden" name="price" value="<?php echo $price ?>">
                                <input type="hidden" name="title" value="<?php echo $title; ?>">
                                <button type="submit" class="button new__button" name="add_to_cart">ADD TO CART</button>
                            </form>
                        </article>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>


        <!--==================== NEWSLETTER ====================-->
        <section class="newsletter section container">
            <div class="newsletter__bg grid">
                <div>
                    <h2 class="newsletter__title">Subscribe Our <br> Newsletter</h2>
                    <p class="newsletter__description">
                        Don't miss out on your discounts. Subscribe to our email
                        newsletter to get the best offers, discounts, coupons,
                        gifts and much more.
                    </p>
                </div>

                <form action="" class="newsletter__subscribe">
                    <input type="email" placeholder="Enter your email" class="newsletter__input">
                    <button class="button">
                        SUBSCRIBE
                    </button>
                </form>
            </div>
        </section>
    </main>

    <!--==================== FOOTER ====================-->
    <footer style="background-color: transparent;" class="footer section">
        <div class="footer__container container grid">
            <div class="footer__content">
                <h3 class="footer__title">Our information</h3>

                <ul class="footer__list">
                    <li>Yemen</li>
                    <li>Hadramout/Bwish</li>
                    <li>+96773087640</li>
                </ul>
            </div>
            <div class="footer__content">
                <h3 class="footer__title">About Us</h3>

                <ul class="footer__links">
                    <li>
                        <a href="#" class="footer__link">Support Center</a>
                    </li>
                    <li>
                        <a href="#" class="footer__link">Customer Support</a>
                    </li>
                    <li>
                        <a href="#" class="footer__link">About Us</a>
                    </li>
                    <li>
                        <a href="#" class="footer__link">Copy Right</a>
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Products</h3>

                <ul class="footer__links">
                    <li>
                        <a href="#" class="footer__link">Rolex watchs</a>
                    </li>
                    <!-- <li>
                        <a href="#" class="footer__link">Mountain bikes</a>
                    </li>
                    <li>
                        <a href="#" class="footer__link">Electric</a>
                    </li>
                    <li>
                        <a href="#" class="footer__link">Accesories</a>
                    </li> -->
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Social</h3>

                <ul class="footer__social">
                    <a href="https://www.facebook.com/" target="_blank" class="footer__social-link">
                        <i class='bx bxl-facebook'></i>
                    </a>

                    <a href="https://twitter.com/" target="_blank" class="footer__social-link">
                        <i class='bx bxl-twitter'></i>
                    </a>

                    <a href="https://instagram.com/da7m.bj?utm_source=qr&igshid=MzNlNGNkZWQ4Mg==" target="_blank" class="footer__social-link">
                        <i class='bx bxl-instagram'></i>
                    </a>
                </ul>
            </div>
        </div>

        <span class="footer__copy">&#169; AbdulrahmanBJ. All rigths reserved</span>
    </footer>

    <!--=============== SCROLL UP ===============-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class='bx bx-up-arrow-alt scrollup__icon'></i>
    </a>


    <!--=============== SWIPER JS ===============-->
    <script src="assets/assets/js/swiper-bundle.min.js"></script>

    <!--=============== MAIN JS ===============-->
    <script src="assets/assets/js/main.js"></script>
    <script>
        function placeOrder() {
            document.getElementById("placeOrderForm").submit();

        }

        // function close(){
        //     $('#productModal').modal('hide');

        // }


        function increaseQuantity(index) {
            var quantityElement = document.getElementById('number' + index);
            var priceElement = document.getElementById('price' + index);

            var currentQuantity = parseInt(quantityElement.innerText);
            quantityElement.innerText = currentQuantity + 1;

            var price = parseFloat(<?php echo $_SESSION['price'][$index]; ?>);
            priceElement.innerText = (currentQuantity + 1) * price + ' Rs';

            updateTotalPrice();
        }

        function decreaseQuantity(index) {
            var quantityElement = document.getElementById('number' + index);
            var priceElement = document.getElementById('price' + index);

            var currentQuantity = parseInt(quantityElement.innerText);
            if (currentQuantity > 0) {
                quantityElement.innerText = currentQuantity - 1;



                var price = parseFloat(<?php echo $_SESSION['price'][$index]; ?>);
                var check = (currentQuantity - 1) * price + ' Rs';
                if (check != 0) {
                    priceElement.innerText = (currentQuantity - 1) * price + ' Rs';

                } else {
                    console.log('hh')
                }

                // console.log( priceElement.innerText);

                updateTotalPrice();
            }
        }

        function updateTotalPrice() {
            var total = 0;
            <?php
            foreach ($_SESSION['price'] as $index => $items) {
                echo "total += parseFloat(document.getElementById('price$index').innerText);";
            }
            ?>
            document.querySelector('.cart__prices-total').innerText = total + ' Rs';
        }
    </script>


    <script>
        /*=============== SHOW MENU ===============*/


        /*=============== DARK LIGHT THEME ===============*/
        const themeButton = document.getElementById('theme-button');
        const darkTheme = 'dark-theme';
        const iconTheme = 'bx-sun';

        // Previously selected topic (if user selected)
        const selectedTheme = getCookie('selected-theme');
        const selectedIcon = getCookie('selected-icon');

        // We obtain the current theme that the interface has by validating the dark-theme class
        const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light';
        const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'bx bx-moon' : 'bx bx-sun';

        // We validate if the user previously chose a topic
        if (selectedTheme) {
            // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
            document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme);
            themeButton.classList[selectedIcon === 'bx bx-moon' ? 'add' : 'remove'](iconTheme);
        }

        // Activate / deactivate the theme manually with the button
        themeButton.addEventListener('click', () => {
            console.log('Button clicked!');

            // Add or remove the dark / icon theme
            document.body.classList.toggle(darkTheme);
            themeButton.classList.toggle(iconTheme);
            // We save the theme and the current icon that the user chose in cookies
            setCookie('selected-theme', getCurrentTheme(), 365);
            setCookie('selected-icon', getCurrentIcon(), 365);
        });

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = `expires=${date.toUTCString()}`;
            document.cookie = `${name}=${value};${expires};path=/`;
        }
    </script>
</body>

</html>