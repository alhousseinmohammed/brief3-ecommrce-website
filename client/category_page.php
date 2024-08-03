<?php
session_start();
if (isset($_SESSION['user_id'])) {
  echo $_SESSION['user_id'];
} else {
  echo "no sign in";
}
$category_id = $_GET['id'];
$apiurl = "http://127.0.0.1/Ecommerce-Website/brief4/get_category.php?id=$category_id";
$response = file_get_contents($apiurl);
$categoryy = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link href="css/tiny-slider.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="file:///C:/Users/Orange/Desktop/furni-1.0.0/category.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <?php echo "
    <title>
{$categoryy['category_name']}
  </title>";
  ?>
  <link rel="stylesheet" href="category_page.css">
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
  <!-- End Header/Navigation -->

  <section id="slider-section">
    <div class="container">
      <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://th.bing.com/th/id/R.942ba578a6305b46ce9105da6f6cf9e9?rik=SWd43oV8Fne05g&pid=ImgRaw&r=0" alt="..." style="width: 1100px; height: 500px" />
          </div>
          <div class="carousel-item">
            <img src="https://th.bing.com/th/id/R.942ba578a6305b46ce9105da6f6cf9e9?rik=SWd43oV8Fne05g&pid=ImgRaw&r=0" alt="..." style="width: 1100px; height: 500px" />
          </div>
          <div class="carousel-item">
            <img src="https://th.bing.com/th/id/R.942ba578a6305b46ce9105da6f6cf9e9?rik=SWd43oV8Fne05g&pid=ImgRaw&r=0" alt="..." style="width: 1100px; height: 500px" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 2: مربع إدخال السعر -->


  <!-- Section 3: الكروت -->
  <div class="product-section">
    <div class="container">
      <div class="row">

        <?php
        $products_url = "http://127.0.0.1/Ecommerce-Website/brief4/get_products_in_categories.php?id=$category_id";
        $products = file_get_contents($products_url);
        $products = json_decode($products, true);
        // var_dump($products);

        foreach ($products as $product) {
          if ($product['onsale'] == 1) {
            echo "<div class='col-12 col-md-4 col-lg-3 mb-5 mb-md-0'>
              <div class='product-card'>
                <a class='product-item' href='http://localhost/Ecommerce-Website/client/product_details.php?id={$product['product_id']}'>
                  <img src='../brief4/product_images/{$product['product_image']}' class='img-fluid product-thumbnail'>
                  <h3 class='product-title'>{$product['product_name']}</h3>
                  <strong class='product-price'><s style='color : red'>&#36; " . $product['price'] * 1.2 . "</s>  &#36; {$product['price']}</strong>
                </a>
                <a href='http://localhost/Ecommerce-Website/client/product_details.php?id={$product['product_id']}' class='btn btn-primary mt-2 d-block'>View Details</a>
              </div>
            </div>";
          } else {
            echo "<div class='col-12 col-md-4 col-lg-3 mb-5 mb-md-0'>
            <div class='product-card'>
              <a class='product-item' href='http://localhost/Ecommerce-Website/client/product_details.php?id={$product['product_id']}'>
                <img src='../brief4/product_images/{$product['product_image']}' class='img-fluid product-thumbnail'>
                <h3 class='product-title'>{$product['product_name']}</h3>
                <strong class='product-price'>&#36; {$product['price']}</strong>
              </a>
              <a href='http://localhost/Ecommerce-Website/client/product_details.php?id={$product['product_id']}' class='btn btn-primary mt-2 d-block'>View Details</a>
            </div>
          </div>";
          }
        }
        ?>
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

</body>

</html>