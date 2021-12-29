<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Insertion des utilisateurs dans la bdd

    public function register($data)
    {
        // préparer la requête
        $this->db->query("INSERT INTO users(firstname,lastname,email,password) VALUES(:firstname,:lastname,:email,:password)");
        // bind
        $this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // execution
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // vérification email / pseudo / password

    public function login($email, $password)
    {
        // requête préparée
        $this->db->query('SELECT * FROM users WHERE email=:email');

        // bind
        $this->db->bind(':email', $email);

        // execution
        $row = $this->db->single();

        // mdp crypté

        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    // Trouver l'utilisateur par le biais de son email

    public function findUserByEmail($email)
    {
        // On prépare la requête
        $this->db->query("SELECT * FROM users WHERE email = :email");
        // On relie les paramètres de la requets avec les valeurs passées
        $this->db->bind(':email', $email);
        // On execute la requête
        // On stocke la ligne retournée
        $row =  $this->db->single();

        // On compte le nombre de lignes pour l'email
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsers()
    {
        $this->db->query('SELECT * FROM users');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id=:id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function updateUser($data)
    {
        $this->db->query('UPDATE users SET firstname=:firstname,lastname=:lastname,email=:email, WHERE id=:id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':email', $data['email']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        };
    }
}
