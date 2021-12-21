<?php require APPROOT . '/views/inc/header.php' ?>

<?php $product = $data['product']; ?>

<div class="row">
    <div class="col-md-4">
        <img src="<?= URLROOT ?>/images/products/<?= $product->img ?>" class="img-fluid" alt="">
    </div>
    <div class="col-md-8">
        <h1><?= $product->name ?></h1>
        <p><?= nl2br($product->description) ?></p>
        <hr>
        <div class="row">
            <div class="col-md-8 align-self-center">
                <h2><?= number_format($product->price_ttc, 2) ?> &euro;</h2>
            </div>
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
        <button class="btn btn-primary float-end btn-lg add_to_cart" data-price="<?= number_format($product->price_ttc, 2) ?>" data-url="<?= URLROOT ?>/carts/add_to_cart/<?= $product->id ?>">Ajouter au panier</button>
    </div>

</div>

<?php require APPROOT . '/views/inc/footer.php' ?>