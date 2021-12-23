<?php require APPROOT . '/views/inc/header.php' ?>

<h1 class="text-white mb-5"><?php echo $data['title']; ?></h1>


<?php if ($data['status'] == 'succeeded') : ?>
    <div class="alert alert-success">
        <span>Féliciations, votre paiement à été accepté, merci pour votre achat !</span>
    </div>
<?php endif; ?>


<?php require APPROOT . '/views/inc/footer.php' ?>