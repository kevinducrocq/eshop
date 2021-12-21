<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo SITENAME; ?></title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= URLROOT; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= URLROOT ?>">Eshop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">

        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link active" href="<?= URLROOT ?>">Accueil
              <span class="visually-hidden">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?= URLROOT ?>/products">Boutique
            </a>
          </li>

        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item cart-link dropdown" data-url="<?= URLROOT ?>/carts/widgetCart">
          </li>
          <?php if (isset($_SESSION['user_id'])) : ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Bienvenue <?= $_SESSION['user_lastname'] . ' ' . $_SESSION['user_firstname']; ?></a>
              <div class="dropdown-menu">
                <?php if ($_SESSION['user_role'] && $_SESSION['user_role'] == 1) : ?>
                  <a class="dropdown-item" href="<?= URLROOT ?>/admin">Administration</a>
                  <div class="dropdown-divider"></div>
                <?php endif; ?>
                <a class="dropdown-item" href="<?= URLROOT ?>/users/logout">Déconnexion</a>
              </div>
            </li>
        </ul>
      <?php else : ?>

        <ul class=" navbar-nav ms-auto">

          <li class="nav-item">
            <a class="nav-link" href="<?= URLROOT ?>/users/register">Incription</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= URLROOT ?>/users/login">Connexion</a>
          </li>
        <?php endif; ?>
        </ul>

      </div>
    </div>
  </nav>

  <div class="notifications">

  </div>


  <main class="container mt-5">