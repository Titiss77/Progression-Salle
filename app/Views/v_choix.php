<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>


<h2 class="text-center mb-4"><?= esc($titrePage) ?></h2>

<?php if (!empty($programmes) && is_array($programmes)): ?>

<div class="menu-grid">
    <?php foreach ($programmes as $programme): ?>

    <a href="<?= site_url($selection . '/' . $programme['id']) ?>" class="action-card card-choice">
        <div class="icon-wrapper">
            <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <div class="text-wrapper">
            <h3><?= esc($programme['libelle']) ?></h3>

            <p><?= esc($texte) ?> cette séance</p>
        </div>
    </a>

    <?php endforeach; ?>
</div>

<?php else: ?>
<div class="alert alert-warning">
    Aucune catégorie d'entraînement n'a été créée.
</div>
<?php endif; ?>


<?= $this->endSection() ?>