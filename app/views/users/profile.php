<?php require APPROOT . '/views/inc/header.php' ?>

<div class="card p-3 mb-4">
    <h1 class="card-title mt-4">Vos informations</h1>
    <hr class="mb-5">
    <div class="row">
        <div class="col-md-6">
            <ul class="list-unstyled">
                <?php foreach ($data['users'] as $user) : ?>
                    <?php if ($user->id == $_SESSION['user_id']) : ?>
                        <li>Votre nom : <strong><?= $user->firstname ?></strong></li>
                        <li>Votre prénom : <strong><?= $user->lastname; ?></strong></li>
                        <li>Votre email : <strong><?= $user->email ?></strong></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-6 d-flex flex-column mx-auto profil-buttons">
            <a href="<?= URLROOT ?>/users/edit/<?= $_SESSION['user_id'] ?>" class="btn btn-primary btn-sm mb-1">Modifier vos informations</a>
            <a href="<?= URLROOT ?>/users/edit-password" class="btn btn-success btn-sm mb-1">Modifier votre mot de passe</a>
        </div>
    </div>
</div>

<div class="card p-3">
    <h1 class="card-title mt-4">Vos commandes</h1>
    <hr class="mb-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Acheté le</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $orders = $data['orders']; ?>
            <?php foreach ($orders as $order) : ?>
                <td><?= $orders->reference; ?></td>
                <td><?= $orders->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APPROOT . '/views/inc/footer.php' ?>