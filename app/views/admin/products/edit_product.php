<?php require APPROOT . '/views/inc/header.php' ?>

<h1><?php echo $data['title']; ?></h1>

<div class="row">
    <div class="col-md-4">
        <?php include APPROOT . '/views/inc/sidebar_admin.php'; ?>
    </div>
    <div class="col-md-8">
        <?php $product = $data['product']; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product->id ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input name="name" type="text" class="form-control" id="name" value="<?= $product->name ?>" required>
            </div>
            <div class="mb-3">
                <label for="price_ht" class="form-label">Prix HT</label>
                <input name="price_ht" type="text" class="form-control" id="price_ht" value="<?= $product->price_ht ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Quantité</label>
                <input name="stock" type="text" class="form-control" id="stock" value="<?= $product->stock ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="5" required><?= $product->description ?></textarea>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Image du produit</label>
                <input type="file" name="img" id="img" class="form-control">
            </div>

            <button type="submit" class="btn btn-warning">Modifier</button>
            <a href="<?= URLROOT ?>/admin/products" class="btn btn-light">Retour</a>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php' ?>