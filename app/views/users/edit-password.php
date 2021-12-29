<?php require APPROOT . '/views/inc/header.php' ?>

<div class="row">
    <div class="col-md-6 mx-auto">

        <div class="card card-body bg-light p-5">

            <h1 class="text-center mb-5">Modification du mot de passe</h1>

            <form action="<?= URLROOT ?>/users/edit-password" method="post">

                <div class="mb-3">
                    <label for="old_password" class="form-label fw-bold">Ancier mot de passe<sup>*</sup></label>
                    <input name="old_password" type="password" class="form-control <?= (!empty($data['old_password_err'])) ? 'is-invalid' : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label fw-bold">Nouveau mot de passe<sup>*</sup></label>
                    <input name="new_password" type="password" class="form-control <?= (!empty($data['new_password_err'])) ? 'is-invalid' : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="confirm_new_password" class="form-label fw-bold">Confirmez le nouveau mot de passe<sup>*</sup></label>
                    <input name="confirm_new_password" type="password" class="form-control <?= (!empty($data['confirm_new_password_err'])) ? 'is-invalid' : '' ?>">
                </div>

                <input type="submit" class="btn btn-primary form-control" value="Modifier">
                <p class="text-center mt-3">Déja inscrit? <a href="<?= URLROOT ?>/users/login">Connectez-vous</a></p>
                <p class="mt-2 text-muted text-center">* champs obligatoires</p>

            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php' ?>