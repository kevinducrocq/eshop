<?php

class Product
{

    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProducts()
    {
        $this->db->query('SELECT * FROM products ORDER BY id DESC');
        $result = $this->db->resultSet();

        return $result;
    }

    public function getActiveProducts()
    {
        $this->db->query('SELECT * FROM products WHERE suppr=:suppr ORDER BY id DESC');
        $this->db->bind(':suppr', 0);
        $result = $this->db->resultSet();

        return $result;
    }

    public function getProduct($id)
    {
        $this->db->query('SELECT * FROM products WHERE id=:id');
        $this->db->bind('id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function add($datas)
    {
        $this->db->query('INSERT INTO products (name,description,price_ht,price_ttc,stock,img,created_at) VALUES (:name,:description,:price_ht,:price_ttc,:stock,:img,:created_at)');
        $this->db->bind('name', ucfirst($datas['name']));
        $this->db->bind('description', $datas['description']);
        $this->db->bind('price_ht', $datas['price_ht']);
        $this->db->bind('price_ttc', $datas['price_ttc']);
        $this->db->bind('stock', $datas['stock']);
        $this->db->bind('img', $datas['img']);
        $this->db->bind('created_at', $datas['created_at']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($datas)
    {
        $this->db->query(
            'UPDATE products SET 
        name = :name,
        description=:description,
        price_ht=:price_ht,
        price_ttc=:price_ttc,
        stock=:stock,
        img=:img WHERE id=:id'
        );
        $this->db->bind(':name', $datas['name']);
        $this->db->bind(':description', $datas['description']);
        $this->db->bind(':price_ht', $datas['price_ht']);
        $this->db->bind(':price_ttc', $datas['price_ttc']);
        $this->db->bind('stock', $datas['stock']);
        $this->db->bind(':img', $datas['img']);
        $this->db->bind(':id', $datas['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // supprime définitivement le produit
    public function delete($id)
    {
        $this->db->query('DELETE FROM products WHERE id=:id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // désactive le produit
    public function suppr($id)
    {
        $this->db->query('UPDATE products SET suppr=:suppr WHERE id = :id');
        $this->db->bind(':suppr', true);
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function activate($id)
    {
        $this->db->query('UPDATE products SET suppr=:suppr WHERE id = :id');
        $this->db->bind(':suppr', false);
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
