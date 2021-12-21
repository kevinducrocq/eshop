<?php require APPROOT . '/views/inc/header.php' ?>


<div class="row">
    <div class="col-md-6 col-sm-8 mx-auto">

        <div class="card card-body bg-light p-5">

            <h1 class="text-center mb-5">Connexion</h1>

            <form action="<?= URLROOT ?>/users/login" method="post">

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email<sup>*</sup></label>
                    <input name="email" type="text" class="form-control <?= (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?>">
                    <span class="invalid-feedback"><?= $data['email_err'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Mot de passe<sup>*</sup></label>
                    <input name="password" type="password" class="form-control <?= (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['password'] ?>">
                    <span class="invalid-feedback"><?= $data['password_err'] ?></span>
                </div>

                <input type="submit" class="btn btn-primary form-control" value="Se connecter">
                <p class="text-center mt-3">Pas encore inscrit? <a href="<?= URLROOT ?>/users/register">Inscrivez-vous</a></p>
                <p class="mt-3 text-muted text-center">* champs obligatoires</p>
            </form>
        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php' ?>