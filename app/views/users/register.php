<?php require APPROOT . '/views/inc/header.php' ?>


<div class="row">
    <div class="col-md-6 mx-auto">

        <div class="card card-body bg-light p-5">

            <h1 class="text-center mb-5">Inscription</h1>
            <!-- <h2 class="h6 text-center mb-5">Merci de remplir tous les champs pour votre inscription</h2> -->

            <form action="<?= URLROOT ?>/users/register" method="post">

                <div class="mb-3">
                    <label for="firstname" class="form-label fw-bold">Nom<sup>*</sup></label>
                    <input name="firstname" type="text" class="form-control <?= (!empty($data['firstname_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['firstname'] ?>">
                    <span class="invalid-feedback"><?= $data['firstname_err'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label fw-bold">Prénom<sup>*</sup></label>
                    <input name="lastname" type="text" class="form-control <?= (!empty($data['lastname_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['lastname'] ?>">
                    <span class="invalid-feedback"><?= $data['lastname_err'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email<sup>*</sup></label>
                    <input name="email" type="email" class="form-control <?= (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?>">
                    <span class="invalid-feedback"><?= $data['email_err'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Mot de passe<sup>*</sup></label>
                    <input name="password" type="password" class="form-control <?= (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value="<?= $data['password'] ?>">
                    <span class="invalid-feedback"><?= $data['password_err'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label fw-bold">Confirmez le mot de passe<sup>*</sup></label>
                    <input name="confirm_password" type="password" class="form-control <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : '' ?>">
                    <span class="invalid-feedback"><?= $data['confirm_password_err'] ?></span>
                </div>

                <input type="submit" class="btn btn-primary form-control" value="S'inscrire">
                <p class="text-center mt-3">Déja inscrit? <a href="<?= URLROOT ?>/users/login">Connectez-vous</a></p>
                <p class="mt-2 text-muted text-center">* champs obligatoires</p>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php' ?>