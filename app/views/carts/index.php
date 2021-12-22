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
        <form action="<?= URLROOT ?>/carts/payment" method="post" id="payment-form">
            <input type="hidden" value="<?= $total ?>" name="total">
            <div class="bg-secondary p-4 mb-3">
                <label for="card-element" class="form-label mb-2">Payer avec Stripe</label>
                <div id="card-element" class="mb-2 bg-white p-2 border border-2"></div>
                <div id="card-errors" role="alert"></div>
                <button class="btn btn-success">Payer</button>
            </div>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3"></script>
<script>
    var stripe = Stripe("pk_test_51Jk8oDCetpwHurzPcGiUml8baZCtsvdo9F3VKLE2qDmWb43dbbk2se5PoP0Eeg7nWjSRcSp5pZ7Q84cn60awmlRG00GrCCOC3F")
    var element = stripe.elements()
    var card = element.create('card')
    card.mount('#card-element')

    card.addEventListener('change', function(e) {
        var displayError = document.getElementById('card-errors')
        if (e.error) {
            displayError.textContent = e.error.message
        } else {
            displayError.textContent = ''
        }
    })

    var form = document.getElementById('payment-form')
    form.addEventListener('submit', function(e) {
        e.preventDefault()
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var displayError = document.getElementById('card-errors')
                displayError.textContent = result.error.message
            } else {
                stripeTokenHandler(result.token)
            }
        })
    })

    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form')
        var hiddenInput = document.createElement('input')
        hiddenInput.setAttribute('type', 'hidden')
        hiddenInput.setAttribute('name', 'stripeToken')
        hiddenInput.setAttribute('value', token.id)
        form.appendChild(hiddenInput)
        form.submit()
    }
</script>

<?php require APPROOT . '/views/inc/footer.php' ?>