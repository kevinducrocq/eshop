<?php

class Admin extends Controller
{
    public function __construct()
    {
        if (!isAdmin()) {
            redirect('users/login');
        } else {
            // je suis connecté et j'ai le role admin
            $this->userModel = $this->model('User');
            $this->productModel = $this->model('Product');
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Tableau de bord',
        ];

        $this->view('admin/index', $data);
    }

    public function products()
    {

        if (isset($_POST['name'])) {

            $date = new Datetime();

            $datas = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price_ht' => $_POST['price_ht'],
                'price_ttc' => $_POST['price_ht'] * 1.2,
                'stock' => $_POST['stock'],
                'created_at' => $date->format('Y-m-d'),
            ];

            if (isset($_FILES['img'])) {
                $uploadDir = 'images/products/';
                $uploadFile = $uploadDir . basename($_FILES['img']['name']);
                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                    $datas['img'] = $_FILES['img']['name'];
                }
            }
            $this->productModel->add($datas);

            redirect('admin/products');
        }

        $products = $this->productModel->getProducts();
        $data = [
            'title' => 'Gestion des produits',
            'products' => $products,
        ];
        $this->view('admin/products/index', $data);
    }

    public function edit_product($id)
    {
        $product = $this->productModel->getProduct($id);
        $datas['product'] = $product;
        $datas['title'] = 'Edition du produit ' . $product->name;

        if (!empty($_POST)) {
            $datas = [
                'name' => $_POST['name'],
                'price_ht' => $_POST['price_ht'],
                'price_ttc' => $_POST['price_ht'] * 1.2,
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'id' => $_POST['id'],
            ];

            if (isset($_FILES['img']) && $_FILES['img']['name'] != "") {

                // On remplace avec la nouvelle image
                $uploadDir = 'images/products/';
                $uploadFile = $uploadDir . basename($_FILES['img']['name']);
                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                    $datas['img'] = $_FILES['img']['name'];
                }
            } else {
                // On garde l'ancienne image
                $datas['img'] = $product->img;
            }

            $this->productModel->update($datas);
            redirect('admin/products');
        }

        $this->view('admin/products/edit_product', $datas);
    }

    public function suppr_product($id)
    {
        // Met à jour le produit avec l'attribut suppr à 1 (ou True)
        $this->productModel->suppr($id);
        redirect('admin/products');
    }

    public function activate_product($id)
    {
        // supprime définitivement le produit de la base de données
        $this->productModel->activate($id);
        redirect('admin/products');
    }

    public function delete_product($id)
    {
        // supprime définitivement le produit de la base de données
        $this->productModel->delete($id);
        redirect('admin/products');
    }
}
