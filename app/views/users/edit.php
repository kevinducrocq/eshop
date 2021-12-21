<?php require APPROOT . '/views/inc/header.php' ?>


<div class="row">
    <div class="col-md-6 mx-auto">

        <div class="card card-body bg-light p-5">

            <h1 class="text-center mb-5">Modification de vos informations</h1>

            <form action="<?= URLROOT ?>/users/edit/<?= $_SESSION['user_id'] ?>" method="post">
                <?php $user = $data['user']; ?>
                <div class="mb-3">
                    <label for="firstname" class="form-label fw-bold">Nom<sup>*</sup></label>
                    <input name="firstname" type="text" class="form-control <?= (!empty($data['firstname_err'])) ? 'is-invalid' : '' ?>" value="<?= $user->firstname; ?>">
                    <span class="invalid-feedback"><?= $data['firstname_err'] ?></span>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label fw-bold">Prénom<sup>*</sup></label>
                    <input name="lastname" type="text" class="form-control <?= (!empty($data['lastname_err'])) ? 'is-invalid' : '' ?>" value="<?= $user->lastname; ?>">
                    <span class="invalid-feedback"><?= $data['lastname_err'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email<sup>*</sup></label>
                    <input name="email" type="email" class="form-control <?= (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value="<?= $user->email; ?>">
                    <span class="invalid-feedback"><?= $data['email_err'] ?></span>
                </div>

                <input type="submit" class="btn btn-primary form-control" value="Modifier">
                <a href="<?= URLROOT ?>/users/profile" class="btn btn-dark me-auto mt-2"><i class="fas fa-backward"></i> Retour</a>
                <p class="mt-2 text-muted text-center">* champs obligatoires</p>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php' ?>