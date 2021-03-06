<?php use Core\FH; ?>
<?php $this->setSiteTitle($this->contact->FullName() . ' Düzenle'); ?>


<?php $this->start('body'); ?>
<h1 class="text-center"><?= $this->contact->FullName() . ' adlı kişinin bilgilerini düzenle' ?></h1>
<form class="form" action="<?= $this->postAction ?>" method="POST">
    <?= FH::csrfInput(); ?>
    <?= FH::displayErrors($this->displayErrors); ?>
    <?= FH::inputBlock('text','Ad', 'fname', $this->contact->fname, ["class" => "form-control"]); ?>
    <?= FH::inputBlock('text','Soyad', 'lname', $this->contact->lname, ["class" => "form-control"]); ?>
    <?= FH::inputBlock('email','E-Posta', 'email', $this->contact->email, ["class" => "form-control"]); ?>
    <?= FH::inputBlock('tel','Telefon', 'telephone', $this->contact->telephone, ["class" => "form-control","pattern"=>"[0-9]{3}-[0-9]{2}-[0-9]{3}"]); ?>
    <?= FH::submitBlock('Kaydet', ["class" => "btn btn-primary"], ["class" => "text-right"]) ?>
</form>

<?php $this->end(); ?>