<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            display: none;
        }
    </style>
</head>

<body>

    <div id="products-table-container">
        <form id="formm" action="update_product.php?id=<?php echo $_GET['id'] ?>" method="POST">
            <table class="table table-striped" id="products-table">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $apiurl = "http://127.0.0.1/Ecommerce-Website/brief4/get_product.php/?id=" . $_GET['id'];
                    $response = file_get_contents($apiurl);

                    if ($response === FALSE) {
                        die('Error occurred while fetching data from API.');
                    }

                    $product = json_decode($response, true);

                    if ($product === NULL) {
                        die('Error occurred while decoding JSON response.');
                    }

                    if (isset($product)) {
                        echo "
                                <tr>
                                    <td>{$product['product_id']}</td>
                                    <td> <input type='text' name='product_name' value='{$product['product_name']}'></td>
                                    <td> <input type='text' name='price' value='{$product['price']}'></td>
                                    <td> <input type='text' name='description' value='{$product['description']}'></td>
                                    <td>
                                    <a onclick='submitForm()' class='btn btn-warning btn-sm'>Update</a>
                                    <a href='delete_product.php?id={$product['product_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                    </td>
                                </tr>";
                    } else {
                        echo "<tr><td colspan='6'>No products found or API response is not as expected.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        function submitForm() {
            document.getElementById("formm").submit();
        }
    </script>
</body>

</html>