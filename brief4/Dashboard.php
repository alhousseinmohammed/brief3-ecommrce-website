<?php
// session_start();
// if (!isset($_SESSION['admin'])) {
//     header("Location: http://localhost/Ecommerce-Website/client/home.php");
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .table-container {
            display: none;
        }

        .checkbox-container {
            column-count: 3;
            /* or use the scrollable container CSS */
            column-gap: 20px;
            margin-top: 20px;
        }

        .checkContainer {
            display: block;
            margin-bottom: 10px;
        }

        /* .ml-sm-auto {
            margin: 0 !important;
        } */

        .main-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            padding-right: 8%;
        }
    </style>
</head>

<body>
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="index.html">Furni<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard_data.php">Dashboard Data</a>
                    </li>
                    <li><a class="nav-link" href="#products">Products</a></li>
                    <li><a class="nav-link" href="#categories">Categories</a></li>
                    <li><a class="nav-link" href="#users">Users</a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/home.html">Logout</a></li>
                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/User.html"><i class="fa-regular fa-user"></i></a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/cart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-container">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                    </div>

                    <!-- Products Section -->
                    <div id="products" class="mt-4">
                        <h2>Manage Products</h2>
                        <form action="add_product.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price</label>
                                <input type="number" class="form-control" id="product_price" name="price">
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea class="form-control" id="product_description" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="product_image">Product Image URL</label>
                                <input type="file" class="form-control" id="product_image" name="image">
                            </div>
                            <div class="form-group">
                                <p>Categories</p>
                                <div class="checkbox-container">
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

                                    if (isset($data) && is_array($data)) {
                                        foreach ($data as $category) {
                                            echo "
                                        <span class='checkContainer'>
                                            <input class='form-check-input' type='checkbox' name='category_ids[]' value='{$category['category_id']}' id='defaultCheck{$category['category_id']}'>
                                            <label class='form-check-label' for='defaultCheck{$category['category_id']}'>
                                                {$category['category_name']}
                                            </label>
                                        </span>";
                                        }
                                    } else {
                                        echo "<p>No categories found or API response is not as expected.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </form>

                        <button class="btn btn-info mb-3 mt-4" onclick="toggleTable('products-table')">Show/Hide Products Table</button>
                        <div id="products-table-container">
                            <table class="table table-striped" id="products-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $apiurl = 'http://localhost/Ecommerce-Website/brief4/get_products.php';
                                    $response = file_get_contents($apiurl);

                                    if ($response === FALSE) {
                                        die('Error occurred while fetching data from API.');
                                    }

                                    $data = json_decode($response, true);

                                    if ($data === NULL) {
                                        die('Error occurred while decoding JSON response.');
                                    }

                                    if (isset($data) && is_array($data)) {
                                        foreach ($data as $product) {
                                            echo "
                                        <tr>
                                            <td>{$product['product_id']}</td>
                                            <td>{$product['product_name']}</td>
                                            <td>{$product['price']}</td>
                                            <td>{$product['description']}</td>
                                            <td><img src='./product_images/{$product['product_image']}' width='40px' height='40px'></td>
                                            <td><a href='update_product_page.php?id={$product['product_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='delete_product.php?id={$product['product_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                        </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No products found or API response is not as expected.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Categories Section -->
                    <div id="categories" class="mt-4">
                        <h2>Manage Categories</h2>
                        <form action="add_category.php" method="POST">
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>

                        <button class="btn btn-info mb-3 mt-4" onclick="toggleTable('categories-table')">Show/Hide Categories Table</button>
                        <div id="categories-table-container">
                            <table class="table table-striped" id="categories-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Category ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                                echo "
                                            <tr>
                                                <td>{$category['category_id']}</td>
                                                <td>{$category['category_name']}</td>
                                                <td><a href='update_category_page.php?id={$category['category_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='delete_category.php?id={$category['category_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                                </td>
                                            </tr>";
                                            } else {
                                                echo "<tr><td colspan='3'>Invalid category data received.</td></tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No categories found or API response is not as expected.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Users Section -->
                    <div id="users" class="mt-4">
                        <h2>Manage Users</h2>
                        <form action="add_user.php" method="POST">
                            <div class="form-group">
                                <label for="user_name">User Name</label>
                                <input type="text" class="form-control" id="user_name" name="user_name">
                            </div>
                            <div class="form-group">
                                <label for="role_id">Role ID</label>
                                <input type="number" class="form-control" id="role_id" name="role_id">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </form>

                        <button class="btn btn-info mb-3 mt-4" onclick="toggleTable('users-table')">Show/Hide Users Table</button>
                        <div id="users-table-container">
                            <table class="table table-striped" id="users-table">
                                <thead>
                                    <tr>
                                        <th scope="col">User ID</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role ID</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/get_users.php';
                                    $response = file_get_contents($apiurl);

                                    if ($response === FALSE) {
                                        die('Error occurred while fetching data from API.');
                                    }

                                    $data = json_decode($response, true);

                                    if ($data === NULL) {
                                        die('Error occurred while decoding JSON response.');
                                    }

                                    if (is_array($data) && isset($data['data']) && !empty($data['data'])) {
                                        foreach ($data['data'] as $user) {
                                            if (is_array($user) && isset($user['user_id']) && isset($user['user_name']) && isset($user['email']) && isset($user['password']) && isset($user['role_id'])) {
                                                echo "
                                            <tr>
                                                <td>{$user['user_id']}</td>
                                                <td>{$user['user_name']}</td>
                                                <td>{$user['email']}</td>
                                                <td>{$user['role_id']}</td>
                                                <td>{$user['password']}</td>
                                                <td><a href='update_user_page.php?id={$user['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='delete_user.php?id={$user['user_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                                </td>
                                            </tr>";
                                            } else {
                                                echo "<tr><td colspan='6'>Invalid user data received.</td></tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No users found or API response is not as expected.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleTable(tableId) {
            var table = document.getElementById(tableId);
            if (table.style.display === 'none' || table.style.display === '') {
                table.style.display = 'table';
            } else {
                table.style.display = 'none';
            }
        }
    </script>
</body>

</html>