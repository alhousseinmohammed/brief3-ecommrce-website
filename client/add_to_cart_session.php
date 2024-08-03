<?php
session_start();
$product_id = $_GET['product_id'];
$_SESSION['cart'][] = $product_id;
