<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .full-height {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            margin: 20px;
            background-color: #3B5D50;
            color: #ffffff;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card i {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        body {
            overflow: hidden;
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
                        <a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php">Dashboard</a>
                    </li>
                    <li><a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php#products">Products</a></li>
                    <li><a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php#categories">Categories</a></li>
                    <li><a class="nav-link" href="http://127.0.0.1/Ecommerce-Website/brief4/dashboard.php#users">Users</a></li>
                    <li><a class="nav-link" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/home.html">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container full-height">
        <div class="row">
            <?php
            $apiurl = 'http://127.0.0.1/Ecommerce-Website/brief4/website_data.php';
            $response = file_get_contents($apiurl);

            if ($response === FALSE) {
                die('<div class="alert alert-danger" role="alert">Error occurred while fetching data from API.</div>');
            }

            $data = json_decode($response, true);

            if ($data === NULL) {
                die('<div class="alert alert-danger" role="alert">Error occurred while decoding JSON response.</div>');
            }

            if (isset($data) && is_array($data)) {
                echo '
            <div class="col-md-3">
                <div class="card text-white">
                    <div class="card-body">
                        <i class="fas fa-box-open"></i>
                        <h5 class="card-title">Products</h5>
                        <p class="card-text">' . $data['product_count'] . '</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white">
                    <div class="card-body">
                        <i class="fas fa-users"></i>
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">' . $data['user_count'] . '</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart"></i>
                        <h5 class="card-title">Orders</h5>
                        <p class="card-text">' . $data['order_count'] . '</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white">
                    <div class="card-body">
                        <i class="fas fa-tags"></i>
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">' . $data['category_count'] . '</p>
                    </div>
                </div>
            </div>';
            } else {
                echo '<div class="alert alert-warning" role="alert">No data found or API response is not as expected.</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>