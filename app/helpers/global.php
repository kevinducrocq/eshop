<?php

require_once '../app/models/Cart.php';
require_once '../app/models/Product.php';

function isCartExist()
{
    if (isset($_SESSION['cart'])) {
        $cart = new Cart();
        return $cart->getCurrentCart($_SESSION['cart']);
    } else {
        return false;
    }
}

function currentCart()
{
    if (isset($_SESSION['cart'])) {
        $cart = new Cart();
        return $cart->getAllLineInCart($_SESSION['cart']);
    } else {
        return false;
    }
}

function getProductInCart($id)
{
    $product = new Product();
    $product = $product->getProduct($id);
    return $product;
}

function sumProductInCart()
{
    if (isset($_SESSION['cart'])) {
        $cart = new Cart();
        $result = $cart->getCountProductInCart($_SESSION['cart']);
        return $result;
    } else {
        return false;
    }
}
