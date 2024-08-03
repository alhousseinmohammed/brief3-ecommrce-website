<?php
// Database connection settings
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

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // SQL query to fetch product details
    $sql = "SELECT p.product_id, p.product_name, p.product_image, p.price, p.description
            FROM products p
            WHERE p.product_id = $product_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $product = null;
    }
} else {
    $product = null;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Detail Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="css/style.css" rel="stylesheet" />
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link rel="shortcut icon" href="favicon.png" />
    <link rel="stylesheet" href="product_details.css">
</head>

<body>
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="home.php">Furni<span>.</span></a>

            <form class="d-flex ms-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button id="btn" class="btn btn-outline-dark" type="submit">Search</button>
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
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/about%20after%20login.html">About</a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/contact%20after%20login.html">Contact</a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/home.html">Logout</a></li>
                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/User.html"><i class="fa-regular fa-user"></i></a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/cart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if ($product) : ?>
            <div class="row">
                <div class="col-md-6 image-section">
                    <img src="../brief4/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                </div>
                <div class="col-md-6 details-section">
                    <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                    <p class="short-description"><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
                </div>
            </div>
            <div class="comments-add-to-cart-section">
                <h2>Add a Comment</h2>
                <textarea placeholder="Write your comment here..."></textarea>
                <button class="submit-comment">Submit Comment</button>
            </div>
            <div class="below-container">
                <button class="add-to-cart" <?php echo "onclick='addProduct({$product['product_id']},{$product['price']})'"; ?>>Add to Cart</button>
            </div>
        <?php else : ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function addProduct(product_id, price) {
            if (sessionStorage.cart) {
                // console.log(sessionStorage.cart)
                const cart = JSON.parse(sessionStorage.getItem('cart'));
                console.log(cart)
                previousTotal = sessionStorage.getItem('total');
                for (let i in cart) {
                    console.log(cart[i])
                    if (cart[i][0] == product_id) {
                        cart[i][1] += 1;
                        // console.log(cart)
                        sessionStorage.setItem('total', Number(previousTotal) + Number(price));
                        sessionStorage.setItem('cart', JSON.stringify(cart));
                        return
                    }
                }
                cart.push([product_id, 1])
                sessionStorage.setItem('cart', JSON.stringify(cart));
                sessionStorage.setItem('total', Number(previousTotal) + Number(price));
                return
            } else {
                sessionStorage.setItem('cart', JSON.stringify([
                    [product_id, 1]
                ]));
                sessionStorage.setItem('total', price)
            }
        }
    </script>
</body>

</html>