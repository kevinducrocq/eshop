<?php

class Cart
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function add($data)
    {
        $this->db->query('INSERT INTO cartline (id_product, id_cart, qty, amount) VALUES (:id_product, :id_cart, :qty, :amount)');
        $this->db->bind(':id_product', $data['id_product']);
        $this->db->bind(':id_cart', $data['id_cart']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':amount', $data['amount']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data)
    {
        $this->db->query('UPDATE cartline SET amount = :amount, qty = :qty WHERE id_product = :id_product');
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':id_product', $data['id_product']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // creéation du panier
    public function createCart()
    {
        $uniqid = strtoupper(uniqid());
        $date = new DateTime();
        $this->db->query('INSERT INTO cart (reference,created_at) VALUES (:reference,:created_at)');
        $this->db->bind(':created_at', $date->format('Y-m-d H:i:s'));
        $this->db->bind(':reference', $uniqid);

        if ($this->db->execute()) {
            $_SESSION['cart'] = $uniqid;
            return true;
        } else {
            return false;
        }
    }



    // récupération du panier actuel
    public function getCurrentCart($reference)
    {
        $this->db->query(
            'SELECT *
            FROM cart 
            WHERE reference = :reference'
        );

        $this->db->bind(':reference', $reference);
        $row = $this->db->single();

        return $row;
    }

    //tous les éléments du panier
    public function getAllLineInCart($reference)
    {
        $cart = $this->getCurrentCart($reference);
        $this->db->query('SELECT * FROM cartline WHERE id_cart = :id_cart');
        $this->db->bind(':id_cart', $cart->id);
        return $this->db->resultSet();
    }

    // Nombre de lignes par élément
    public function getCountProductInCart($reference)
    {
        $cart = $this->getCurrentCart($reference);
        $this->db->query('SELECT SUM(qty) as total_product FROM cartline WHERE id_cart = :id_cart');
        $this->db->bind(':id_cart', $cart->id);
        $result = $this->db->resultSet();
        if (is_null($result[0]->total_product)) {
            return 0;
        } else {
            return $result[0]->total_product;
        }
    }

    // Est-ce qu'un produit est déjà dans le panier ?
    public function alreadyInCart($id)
    {
        $this->db->query('SELECT * FROM cartline where id_product = :id_product');
        $this->db->bind(':id_product', $id);
        $row = $this->db->single();
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }
}