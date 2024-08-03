<?php

session_start();
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
} else {
    echo "no sign in";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brief4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$result_user = mysqli_fetch_all($result, MYSQLI_ASSOC);
// var_dump($result_user);
// echo json_encode($result);

$query1 = "SELECT DISTINCT order_id, order_total, order_date, num_of_items FROM orders JOIN users ON orders.user_id = users.user_id WHERE orders.user_id = $user_id";
$ids_result = mysqli_query($conn, $query1);
$ids_result = mysqli_fetch_all($ids_result, MYSQLI_ASSOC);
// echo "<br>";
// var_dump($ids_result)
// print_r($ids_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="User.css">
</head>

<body>
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="home.php">Furni<span>.</span></a>

            <!-- Search Form -->
            <form class="d-flex ms-3" method="post" action="products.php">
                <input class="form-control me-2" type="number" placeholder="Filter By Price" aria-label="Search" name="query" required>
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <?php
                            $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_categories.php';
                            $response = file_get_contents($apiurl);

                            if ($response === FALSE) {
                                die('Error occurred while fetching data from API.');
                            }

                            $data = json_decode($response, true);

                            if ($data === NULL) {
                                die('Error occurred while decoding JSON response.');
                            }

                            if (is_array($data) && !empty($data)) {
                                foreach ($data as $category) {
                                    if (is_array($category) && isset($category['category_id']) && isset($category['category_name'])) {
                                        echo "<li><a class='dropdown-item' href='category_page.php?id={$category['category_id']}'>{$category['category_name']}</a></li>";
                                    }
                                }
                            }
                            ?>

                        </ul>
                    </li>
                    <li><a class="nav-link" href="http://localhost/ecommerce-Website/client/about.php">About</a></li>
                    <li><a class="nav-link" href="http://localhost/ecommerce-Website/client/contact.php">Contact</a></li>
                    <li><a class="nav-link" href="<?php
                                                    if (isset($_SESSION['user_id'])) {
                                                        echo "http://localhost/ecommerce-Website/reg/process_logout.php";
                                                    } else {
                                                        echo "http://localhost/ecommerce-Website/reg/login.php";
                                                    }
                                                    ?>"><?php
                                                        if (isset($_SESSION['user_id'])) {
                                                            echo "Log out";
                                                        } else {
                                                            echo "Log In";
                                                        }
                                                        ?></a></li>
                </ul>

                <ul class=" custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="<?php if (isset($_SESSION['user_id'])) {
                                                        echo "http://localhost/ecommerce-Website/client/user.php?id={$_SESSION['user_id']}";
                                                    } else {
                                                        echo "http://localhost/ecommerce-Website/reg/login.php";
                                                    }
                                                    ?>
													 "><i class="fa-regular fa-user"></i></a></li>
                    <li><a class="nav-link" href="<?php if (isset($_SESSION['user_id'])) {
                                                        echo "http://localhost/ecommerce-Website/client/cart.php";
                                                    } else {
                                                        echo "http://localhost/ecommerce-Website/reg/login.php";
                                                    }
                                                    ?>"><i class="fa-solid fa-cart-shopping"></i><?php echo count($_SESSION['cart']) ?></a></li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container">
        <!-- My Account Section -->
        <div class="account-container">
            <h1 class="text-center">My Account</h1>
            <p>Hello, <?php echo $result_user[0]["user_name"]; ?></p>
            <div class="order-history">
                <h4>Order history</h4>

                <?php
                foreach ($ids_result as $order) {
                    $order_id = $order["order_id"];
                    echo '
                  <div class="order-item container d-flex flex-row justify-content-start">
          <div class="container gap-5 d-flex flex-row justify-content-start">';
                    // print_r($result_order) . "<br> <br>";
                    echo  $order["order_date"];


                    echo '</div>' .
                        $order["order_total"] . '$'
                        . '</div>';
                }
                ?>
            </div>
        </div>

        <!-- Account Details Section -->
        <div class="account-details-container">
            <h4>Account Details</h4>
            <div class="details-item">
                <span><?php echo "Username: " . $result_user[0]["user_name"]; ?></span>
                <a href="update_user_name.php?id=<?php echo $result_user[0]["user_id"]; ?>" class="btn btn-link">Edit</a>
            </div>
            <div class="details-item">
                <span><?php echo "Email: " . $result_user[0]["email"]; ?></span></span>
                <form action="change_email.php?id=<?php echo $result_user[0]["user_id"]; ?>" method="post">
                    <input type="text" value="<?php echo $result_user[0]["email"] ?>" name="email">
                    <input type="submit" value="update">
                </form>
            </div>
            <div class="details-item">
                <a href="update_user_password.php?id=<?php echo $result_user[0]["user_id"]; ?>" class="btn btn-link">Change Password</a>
            </div>
        </div>

    </div>
    <footer class="footer-section">
        <div class="container relative">
            <div class="border-top copyright">
                <div class="row pt-4">
                    <div class="col-lg-6">
                        <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
                        </p>
                    </div>

                    <div class="col-lg-6 text-center text-lg-end">
                        <ul class="list-unstyled d-inline-flex ms-auto">
                            <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>