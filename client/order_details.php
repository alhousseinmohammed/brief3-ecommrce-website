<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
    <link rel="stylesheet" href="cart.css">
</head>

<body>

    <!-- Start Header/Navigation -->
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
    <!-- End Header/Navigation -->

    <!-- Start Cart Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Your Cart</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <?php
                        $order_id = $_GET['order_id'];
                        $order_url = "http://localhost/ecommerce-Website/client/get_order_details.php?order_id={$order_id}";
                        $orders = file_get_contents($order_url);
                        $orders = json_decode($orders);
                        if (!empty($orders)) {
                            foreach ($orders as $order) {
                                $order = get_object_vars($order);
                                echo "
                            <tr>
                                <td>{$order['product_name']}</td>
                                <td><img src='../brief4/product_images/{$order['product_image']}' width='40px' height='40px'></td>
                                <td>\${$order['price']}</td>
                                <td>{$order['quantity']}</td>
                                <td>\$" . ($order['price'] * $order['quantity']) . "</td>
                            </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No products found for this order.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Cart Section -->

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

    <!-- Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>
    <script src="js/custom.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Handle quantity increase
            const increaseButtons = document.querySelectorAll('.increase');
            increaseButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    let input = e.target.closest('.input-group').querySelector('.quantity-amount');
                    let currentValue = parseInt(input.value);
                    input.value = currentValue + 1;
                    updateCart({
                        productId: e.target.closest('tr').getAttribute('data-product-id'),
                        quantity: input.value
                    }, 'update');
                });
            });

            // Handle quantity decrease
            const decreaseButtons = document.querySelectorAll('.decrease');
            decreaseButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    let input = e.target.closest('.input-group').querySelector('.quantity-amount');
                    let currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                        updateCart({
                            productId: e.target.closest('tr').getAttribute('data-product-id'),
                            quantity: input.value
                        }, 'update');
                    }
                });
            });

            // Handle item removal
            const removeButtons = document.querySelectorAll('.remove-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    let productRow = e.target.closest('tr');
                    let productId = productRow.getAttribute('data-product-id');

                    updateCart({
                        productId: productId
                    }, 'delete');

                    // Remove the row from the table
                    productRow.remove();
                });
            });

            // Handle coupon code application
            document.querySelector('.btn-black').addEventListener('click', function() {
                var couponCode = document.getElementById('coupon').value;

                // Make an AJAX request to apply the coupon
                fetch('apply-coupon.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'coupon': couponCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the total amount on the page
                            document.querySelector('#total-amount').innerText = '$' + data.newTotal;
                        } else {
                            alert('Invalid coupon code');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Function to update the cart
            function updateCart(data, action) {
                fetch('update-cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            productId: data.productId,
                            quantity: data.quantity,
                            action: action
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Cart updated successfully');
                        } else {
                            console.error('Error updating cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
</body>

</html>