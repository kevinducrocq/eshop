<?php require APPROOT . '/views/inc/header.php' ?>

<?php $product = $data['product']; ?>

<div class="row">
    <div class="col-md-4">
        <img src="<?= URLROOT ?>/images/products/<?= $product->img ?>" class="img-fluid" alt="">
    </div>
    <div class="col-md-8">
        <div class="d-flex align-items-center">
            <h1><?= $product->name ?></h1>
            <?php if ($product->stock <= 0) : ?>
                <span class="fw-bold badge bg-danger mx-4">Indisponible</span>
            <?php endif; ?>
            <?php if ($product->stock > 0) : ?>
                <span class="fw-bold badge bg-success mx-4"><?= $product->stock ?> en stock</span>
            <?php endif; ?>
        </div>
        <p><?= nl2br($product->description) ?></p>
        <hr>
        <div class="row">
            <div class="col-md-8 align-self-center">
                <h2><?= number_format($product->price_ttc, 2) ?> &euro;</h2>
            </div>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="col-md-4">
                    <label for="" class="h4">Quantité : </label>
                    <div class="input-group">
                        <button class="input-group-text" id="btn-minus"><i class="fas fa-minus"></i></button>
                        <input id="qty" type="text" value="1" data-max="<?= $product->stock ?>" readonly class="form-control text-center">
                        <button class="input-group-text" id="btn-plus"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
        </div>
        <hr>
        <?php if ($product->stock <= 0) : ?>
            <span class="alert alert-danger float-end" disabled>Produit indisponible</span>
        <?php else : ?>
            <button class="btn btn-primary float-end btn-lg add_to_cart" data-price="<?= number_format($product->price_ttc, 2) ?>" data-url="<?= URLROOT ?>/carts/add_to_cart/<?= $product->id ?>">Ajouter au panier</button>
        <?php endif; ?>
    <?php else : ?>

        <span class="bg-secondary p-2 text-center"><a href="<?=URLROOT?>/users/login" class="fw-bold">Connectez-vous,</a> ou <a href="<?=URLROOT?>/users/register" class="fw-bold">inscrivez-vous</a> pour acheter ce produit</span>

    <?php endif; ?>
    </div>

</div>

<?php require APPROOT . '/views/inc/footer.php' ?>