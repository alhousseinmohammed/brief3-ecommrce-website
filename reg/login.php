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
    <!-- Your navbar and other content here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="../client/home.php">Furni<span>.</span></a>

            <!-- Search Form -->
            <form class="d-flex ms-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
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
                                        echo "<li><a class='dropdown-item' href='../client/category_page.php?id={$category['category_id']}'>{$category['category_name']}</a></li>";
                                    }
                                }
                            }
                            ?>

                        </ul>
                    </li>
                    <li><a class="nav-link" href="http://localhost/ecommerce-Website/client/about.php">About</a></li>
                    <li><a class="nav-link" href="http://localhost/ecommerce-Website/client/contact.php">Contact</a></li>
                    <li><a class="nav-link" href="http://localhost/44.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                </ul>


            </div>
        </div>
    </nav>
    <div class="login-section">
        <div class="login-container">
            <h2>Login</h2>
            <?php if (isset($error_message)) {
                echo "<div class='error-message'>$error_message</div>";
            } ?>
            <form id="loginForm" action="process_login.php" method="post">
                <div class="input-group">
                    <label for="email">E-mail address</label>
                    <input type="email" id="email" name="email" required>
                    <div class="error-message" id="email-error"></div>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <div class="error-message" id="password-error"></div>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <div class="options">
                    <a href="#">Can't remember your password? Recover it.</a>
                    <a href="signup.php">Don't Have an Account? Create it.</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        class Validator {
            constructor(email, password) {
                this.email = email;
                this.password = password;
            }

            validate() {
                let errors = {};

                if (this.email === '') {
                    errors.email = 'Email is required.';
                } else if (this.email.length < 3) {
                    errors.email = 'Email must be at least 3 characters long.';
                } else if (!this.isValidEmail(this.email)) {
                    errors.email = 'Invalid email format.';
                }

                if (this.password === '') {
                    errors.password = 'Password is required.';
                } else if (this.password.length < 6) {
                    errors.password = 'Password must be at least 6 characters long.';
                }

                return errors;
            }

            isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            const validator = new Validator(email, password);
            const errors = validator.validate();

            document.getElementById('email-error').innerText = '';
            document.getElementById('password-error').innerText = '';

            if (Object.keys(errors).length > 0) {
                event.preventDefault();

                if (errors.email) {
                    document.getElementById('email-error').innerText = errors.email;
                }
                if (errors.password) {
                    document.getElementById('password-error').innerText = errors.password;
                }
            }
        });
    </script>
</body>

</html>