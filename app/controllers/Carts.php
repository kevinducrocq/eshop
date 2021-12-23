<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
            if (isset($_SESSION['user_id'])) :
                if ($this->cartModel->getCartByIdUser($_SESSION['user_id'])) {
                    $cart = $this->cartModel->getCartByIdUser($_SESSION['user_id']);
                } else {
                    $cart = isCartExist();
                }
            else :
                $cart = isCartExist();
            endif;
            $cartlines = currentCart();
            $html .= '<a href="#" class="dropdown-toggle nav-link  id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge bg-secondary">' . $this->cartModel->getCountProductInCart($_SESSION['cart']) . '</span>
                </a>
                <ul class="dropdown-menu shadow-lg" aria-labelledby="navbarDarkDropdownMenuLink">';
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

    public function payment()
    {

        $cart = isCartExist();
        $cartlines = currentCart();

        require_once VENDORROOT . 'autoload.php';
        $key = APISTRIPE;
        \Stripe\Stripe::setApiKey($key);

        if (isset($_POST['stripeToken'])) {

            $customer = \Stripe\Customer::create([
                'description' => $_SESSION['user_firstname'],
                'source' => $_POST['stripeToken'],
                'email' => $_SESSION['user_email']
            ]);

            $charge = \Stripe\Charge::create([
                'amount' => $_POST['total'] * 100,
                'currency' => 'eur',
                'customer' => $customer->id,
            ]);

            if ($charge->status == 'succeeded') {
                // paiement validé 
                foreach ($cartlines as $cartline) {

                    $qty = $cartline->qty;
                    $id_product = $cartline->id_product;
                    $product = $this->productModel->getProduct($id_product);
                    $datas = [
                        'id' => $product->id,
                        'stock' => $product->stock - $qty,
                        'price_ht' => $product->price_ht,
                        'price_ttc' => $product->price_ttc,
                        'img' => $product->img,
                        'description' => $product->description,
                        'name' => $product->name
                    ];
                    $this->productModel->update($datas);
                }
                $cart = $this->cartModel->validate($cart->id);

                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = false;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'kducrocq.dev@gmail.com';                     //SMTP username
                    $mail->Password   = '190812Vs@';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('kducrocq.dev@gmail.com', 'eshop');
                    $mail->addAddress($_SESSION['user_email']);     //Add a recipient
                    // $mail->addReplyTo('kducrocq.dev@gmail.com', 'Eshop');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    // //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Confirmation de votre commande';

                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    $html = '<style type="text/css">
                    body,
                    html, 
                    .body {
                      background: #f3f3f3 !important;
                    }
                  </style>
                  <!-- move the above styles into your custom stylesheet -->
                  
                  <spacer size="16"></spacer>
                  
                  <container>
                  
                    <spacer size="16"></spacer>
                  
                    <row>
                      <columns>
                        <h1>Thanks for your order.</h1>
                        <p>Thanks for shopping with us! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad earum ducimus, non, eveniet neque dolores voluptas architecto sed, voluptatibus aut dolorem odio. Cupiditate a recusandae, illum cum voluptatum modi nostrum.</p>
                  
                        <spacer size="16"></spacer>
                  
                        <callout class="secondary">
                          <row>
                            <columns large="6">
                              <p>
                                <strong>Payment Method</strong><br/>
                                Dubloons
                              </p>
                              <p>
                                <strong>Email Address</strong><br/>
                                thecapn@pirates.org
                              </p>
                              <p>
                                <strong>Order ID</strong><br/>';

                    $html .= $_SESSION['cart'];
                    $html .= '</p>
                    </columns>
                    <columns large="6">
                      <p>
                        <strong>Shipping Method</strong><br/>
                        Boat (1&ndash;2 weeks)<br/>
                        <strong>Shipping Address</strong><br/>
                        Captain Price<br/>
                        123 Maple Rd<br/>
                        Campbell, CA 95112
                      </p>
                    </columns>
                  </row>
                </callout>
          
                <h4>Order Details</h4>
          
                <table>';

                    $total = 0;
                    foreach ($cartlines as $cartline) {
                        $total += $cartline->amount;
                        $html .= '<tr><th>' . $product = $this->productModel->getProduct($cartline->id_product)->name . '</th><th>' . $cartline->qty . '</th><th>' . number_format($cartline->amount, 2) . '&euro;</th></tr>';
                    }

                    $html .= '<tr>
                <td colspan="2"><b>Total</b></td>
                <td>' . number_format($total, 2) . '&euro;</td>
              </tr>
            </table>
      
            <hr/>
            </columns>
            </row>
            </container>
            ';
                    $mail->Body = $html;
                    $mail->send();
                    unset($_SESSION['cart']);
                    // echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }

        $data = [
            'title' => 'Paiement de votre commande',
            'status' => $charge->status,
        ];
        $this->view('carts/payment', $data);
    }
}
