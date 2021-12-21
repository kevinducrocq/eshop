<?php

class Carts extends Controller
{
    public function __construct()
    {
        $this->cartModel = $this->model('Cart');
        $this->productModel = $this->model('Product');
        $this->userModel = $this->model('User');
    }

    public function add_to_cart($id)
    {
        if ($this->cartModel->alreadyInCart($id)) {
            // produit déjà dans le panier : on update le montant et la quantité{
            $cartline = $this->cartModel->alreadyInCart($id);
            $data = [
                'qty' => $cartline->qty + $_POST['qty'],
                'amount' => $cartline->amount + ($_POST['qty'] * $_POST['price']),
                'id_product' => $id,
            ];
            $cart = $this->cartModel->update($data);
        } else {
            // produit pas encore dans le panier :  on crée la ligne
            $cart = $this->cartModel->getCurrentCart($_SESSION['cart']);
            $data = [
                'qty' => $_POST['qty'],
                'amount' => $_POST['qty'] * $_POST['price'],
                'id_product' => $id,
                'id_cart' => $cart->id,
            ];
            $cart = $this->cartModel->add($data);
        }
        return true;
    }

    public function widgetCart()
    {
        $html = '';
        if (isset($_SESSION['cart'])) {
            $cart = isCartExist();
            $cartlines = currentCart();
            $html .= '<a href="#" class="dropdown-toggle nav-link  id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge bg-secondary">' . $this->cartModel->getCountProductInCart($_SESSION['cart']) . '</span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">';
            $total = 0;
            foreach ($cartlines as $cartline) :
                $total += $cartline->amount;
                $html .= '<div class="dropdown-item">
                                <div class="d-flex justify-content-between align-items-center">
                                <a class="nav-link" href="' . URLROOT . '/products/show/' . $cartline->id_product . '">
                                    <img src="' . URLROOT . '/images/products/' . getProductInCart($cartline->id_product)->img . '" alt="" width="40">
                                    ' . getProductInCart($cartline->id_product)->name . '
                                </a>
                                <span>
                                x ' . $cartline->qty . '
                                </span>
                                </div>
                          </div>';
            endforeach;

            $html .= '<div class="dropdown-divider"></div>';
            $html .= '<div class="dropdown-item float-end mb-2">
                    Total : ' . number_format($total, 2) . ' &euro;
                    </div>';
            $html .= '<a href="' . URLROOT . '/carts" class="d-flex justify-content-center btn btn-primary see_cart">Voir le panier</a>';

            echo $html;
        }
    }

    public function index()
    {
        $cart = isCartExist();
        $cartlines = currentCart();

        $data = [
            'title' => 'Votre commande' . '<br><span class="h5">N° ' . $cart->reference . '</span>',
            'cartlines' => $cartlines,
            'cart' => $cart,
        ];
        $this->view('carts/index', $data);
    }
}
