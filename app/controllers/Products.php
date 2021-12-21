<?php

class Products extends Controller
{

    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    public function index()
    {
        $products = $this->productModel->getproducts();

        $data = [
            'title' => 'Boutique',
            'products' => $products,
        ];

        $this->view('products/index', $data);
    }

    public function show($id)
    {
        $product = $this->productModel->getProduct($id);

        $data = [
            'product' => $product,
        ];

        $this->view('products/show', $data);
    }
}
