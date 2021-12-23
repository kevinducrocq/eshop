<?php

class Users extends Controller
{


    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->cartModel = $this->model('Cart');
    }

    public function register()
    {
        // Vérifier si on a recourt à la méthode POST

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // valider le formulaire

            //nettoryer les données récupérées via $_POST

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //initialiser les données

            $data = [
                'firstname' => trim($_POST['firstname']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),

                'firstname_err' => '',
                'lastname_err' => '',
                'email_err' => '',
                'confirm_password_err' => ''
            ];

            // Validation des noms et prénoms

            if (empty($data['firstname'])) {
                $data['firstname_err'] = 'Indiquez votre nom';
            }
            if (empty($data['lastname'])) {
                $data['lastname_err'] = 'Indiquez votre prénom';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Indiquez votre email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email déjà enregistré dans notre base de données';
                }
            }
            if (empty($data['password'])) {
                $data['password_err'] = 'Entrez un mot de passe';
            } elseif (strlen($data['password']) < 8) {
                $data['password_err'] = 'Votre mot de passe doit contenir au moins 8 caractères';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Confimez votre mot de passe';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Vos mots de passe ne correspondent pas';
                }
            }

            if (empty($data['firstname_err']) && empty($data['lastname_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                //validation du formulaire

                // crypter le mdp
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->register($data)) {
                    redirect('users/login');
                } else {
                    die('erreur');
                }
            } else {
                // afficher la vue avec les erreurs
                $this->view('users/register', $data);
            }
        } else {
            // Initialiser les données
            $data = [
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',

                'firstname_err' => '',
                'lastname_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if (isLoggedIn()) {
            redirect('pages');
        }
        // Vérifier si on a recourt à la méthode POST

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // valider le formulaire

            //nettoryer les données récupérées via $_POST

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //initialiser les données

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_err' => '',
                'password_err' => '',
            ];

            // Validation des noms et prénoms

            if (empty($data['email'])) {
                $data['email_err'] = 'Indiquez votre email';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Entrez votre mot de passe';
            }

            // vérification de l'email

            if ($this->userModel->findUserByEmail($data['email'])) {
                // l'email est trouvé

            } else {
                // email non-trouvé
                $data['email-err'] = 'Aucune correspondance avec notre base de données';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                //validation du formulaire

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // création d'une session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Mot de passe incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                // afficher la vue avec les erreurs
                $this->view('users/login', $data);
            }
        } else {
            // Initialiser les données
            $data = [
                'email' => '',
                'password' => '',

                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('users/login', $data);
        }
    }

    // méthode pour créer une session
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_firstname'] = $user->firstname;
        $_SESSION['user_lastname'] = $user->lastname;
        $_SESSION['user_role'] = $user->id_role;
        $cart = $this->cartModel->associateUserToCart($user->id, $_SESSION['cart']);

        redirect('pages/index');
    }

    // méthode pour la déconnexion
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_firstname']);
        unset($_SESSION['user_lastname']);
        unset($_SESSION['user_role']);

        session_destroy();

        redirect('users/login');
    }

    public function edit($id)
    {

        $user = $this->userModel->getUserById($id);

        if (!empty($_POST)) {

            $data = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'id' => $_SESSION['user_id'],
                'user' => $user
            ];

            $this->userModel->updateUser($data);

            $_SESSION['status'] = "Vos informations ont bien été modifiées";
            redirect('users/profile');
        } else {
            $data = [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'id' => $_SESSION['user_id'],
                'user' => $user
            ];
        }
        $this->view('users/edit', $data);
    }

    public function editPassword()
    {
        $this->view('users/edit-password');
    }
}
