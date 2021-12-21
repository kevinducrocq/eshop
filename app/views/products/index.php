<?php require APPROOT . '/views/inc/header.php' ?>
<h1 class="text-white mb-5"><?php echo $data['title']; ?></h1>


<div class="row">

    <?php foreach ($data['products'] as $product) : ?>
        <div class="col-md-3">
            <div class="card flex-grow">
                <a href="<?= URLROOT ?>/products/show/<?= $product->id ?>">
                    <img src="<?= URLROOT ?>/images/products/<?= $product->img ?>" class="card-img-top" alt="<?= $product->name ?>">
                </a>
                <div class="card-body">
                    <h5 class="h4 card-title"><?= $product->name ?></h5>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <span class="price"><?= number_format($product->price_ttc, 2) ?> &euro; </span>
                        <a href="<?= URLROOT ?>/products/show/<?= $product->id ?>" class="btn btn-primary float-end">Voir le produit</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>


<?php require APPROOT . '/views/inc/footer.php' ?>