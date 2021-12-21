<?php require APPROOT . '/views/inc/header.php' ?>
<h1><?php echo $data['title']; ?>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#add_product">
        Ajouter un produit
    </button>

</h1>

<div class="row">
    <div class="col-md-4 col-sm-4">
        <?php include APPROOT . '/views/inc/sidebar_admin.php'; ?>
    </div>
    <div class="col-md-8">
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix HT</th>
                    <th>Prix TTC</th>
                    <th>quantité</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $products = $data['products']; ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td>
                            <img src="<?= URLROOT ?>/images/products/<?= $product->img ?>" alt="" width="60">
                            <?= $product->name ?>
                        </td>
                        <td><?= $product->price_ht ?>&euro;</td>
                        <td><?= $product->price_ttc ?>&euro;</td>
                        <td><?= $product->stock ?></td>
                        <td class="text-nowrap">
                            <a href="<?= URLROOT ?>/admin/edit_product/<?= $product->id ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <?php if ($product->suppr == 0) : ?>
                                <button data-bs-link="<?= URLROOT ?>/admin/suppr_product/<?= $product->id ?>" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#suppr_product"><i class="fas fa-eye-slash"></i></button>
                            <?php else : ?>
                                <button data-bs-link="<?= URLROOT ?>/admin/activate_product/<?= $product->id ?>" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activate_product"><i class="fas fa-eye"></i></button>
                            <?php endif; ?>
                            <button data-bs-link="<?= URLROOT ?>/admin/delete_product/<?= $product->id ?>" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_product"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="add_product" tabindex="-1" aria-labelledby="exampleaddProduct" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input name="name" type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_ht" class="form-label">Prix HT</label>
                        <input name="price_ht" type="text" class="form-control" id="price_ht">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Quantité</label>
                        <input name="stock" type="text" class="form-control" id="stock">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="5" required>
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image du produit</label>
                        <input type="file" name="img" id="img" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal suppr -->
<div class="modal fade" id="suppr_product" tabindex="-1" aria-labelledby="suppr_productLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Vous allez retirer le produit de la vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="" class="btn btn-warning btn-suppr">Confirmer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal activate -->
<div class="modal fade" id="activate_product" tabindex="-1" aria-labelledby="activate_productLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Vous allez remettre le produit en vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="" class="btn btn-success btn-activate">Confirmer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete -->
<div class="modal fade" id="delete_product" tabindex="-1" aria-labelledby="delete_productLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Êtes-vous sûr de vouloir supprimer définitivement le produit?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="" class="btn btn-danger btn-delete">Supprimer</a>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php' ?>