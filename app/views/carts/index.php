<?php require APPROOT . '/views/inc/header.php' ?>

<h1><?php echo $data['title']; ?></h1>

<div class="row">
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Prix unitaire</th>
                        <th>quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($data['cartlines'] as $cartline) : ?>
                        <?php $total += $cartline->amount ?>
                        <tr>
                            <td>
                                <img src="<?= URLROOT ?>/images/products/<?= getProductInCart($cartline->id_product)->img ?>" width="40" alt="">
                                <?= getProductInCart($cartline->id_product)->name; ?>
                            </td>
                            <td><?= number_format(getProductInCart($cartline->id_product)->price_ttc, 2); ?> &euro;</td>
                            <td><?= $cartline->qty ?></td>
                            <td><?= number_format($cartline->amount, 2) ?> &euro;</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><span class="float-end h4">Total du panier :</span></td>
                        <td><span class="bg-secondary p-2 fw-bold"><?= number_format($total, 2); ?> &euro;</span></td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
    <div class="col-md-4">
                        

    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php' ?>