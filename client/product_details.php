<?php

// db_connect.php
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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$product = null;
$comments = [];

if ($product_id > 0) {
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id;";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
        $sql_comments = "SELECT content AS user_comment, users.user_name AS comment_user, comment_date 
        FROM comments 
        JOIN users ON users.user_id = comments.user_id 
        WHERE product_id = $product_id;";
        $result_comments = $conn->query($sql_comments);

        if ($result_comments->num_rows > 0) {
            while ($row = $result_comments->fetch_assoc()) {
                $comments[] = $row;
            }
        }
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Detail Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="css/tiny-slider.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="details.css">
    <link rel="shortcut icon" href="favicon.png" />
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
</head>
<!-- Your navbar and other content here -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                                                    ?>"><i class="fa-solid fa-cart-shopping"></i><span id="productsInCart"><?php echo count($_SESSION['cart']) ?> </span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if ($product) : ?>
            <div class="image-section">
                <img class="product-image image-section" src="../brief4/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                <button style="margin-left:35%;margin-top:5%" class="btn btn-success" onclick="addToCart(<?php echo $_GET['id']; ?>)">Add to Cart</button>
            </div>
            <div class="details-section">
                <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <p class="short-description"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
                <h2>Comments</h2>
                <div class="comments-container">
                    <?php foreach ($comments as $comment) : ?>
                        <div class="card mb-3 comment">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($comment['comment_user']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($comment['comment_date']); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars($comment['user_comment']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <h2 style="margin-top:5%">Add a Comment</h2>
                <form action=" <?php if (isset($_SESSION['user_id'])) {
                                    echo "add_comment.php";
                                } else {
                                    echo "../reg/login.php";
                                }  ?>" method="POST">
                    <textarea class="form-control mb-3" name="content" placeholder="Write your comment here..."></textarea>
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                    <button style="margin-left:30%;margin-top:7%" type="submit" class="btn btn-primary">Submit Comment</button>
                </form>

            </div>
            <div class="below-container mt-3">

            </div>
        <?php else : ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>
    <br />
    <script>
        async function addToCart(num) {
            const response = await fetch(`http://localhost/ecommerce-Website/client/add_to_cart_session.php?product_id=${num}`)
            document.querySelector("#productsInCart").textContent = Number(document.querySelector("#productsInCart").textContent) + 1
        }
    </script>
</body>

</html>