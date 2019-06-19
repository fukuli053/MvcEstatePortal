<?php $this->setSiteTitle("Kişilerim"); ?>


<?php $this->start('body'); ?>
<h1 class="text-center">Kişi Ekle</h1>
<div class="bg-danger form-errors"><?= $this->displayErrors ?></div>
<form class="form" action="<?= SROOT ?>contacts/add" method="POST">
    <?= inputBlock('text','Ad', 'fname', '', ["class" => "form-control"]); ?>
    <?= inputBlock('text','Soyad', 'lname', '', ["class" => "form-control"]); ?>
    <?= inputBlock('email','E-Posta', 'email', '', ["class" => "form-control"]); ?>
    <?= inputBlock('tel','Telefon', 'telephone', '', ["class" => "form-control","pattern"=>"[0-9]{3}-[0-9]{2}-[0-9]{3}"]); ?>
    <?= submitBlock('Kaydet', ["class" => "btn btn-primary"], ["class" => "text-right"]) ?>
</form>

<?php $this->end(); ?>