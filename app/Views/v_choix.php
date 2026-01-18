<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">

    <div class="d-flex align-items-center mb-4">
        <a href="<?= site_url('/') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <h2 class="text-center mb-4"><?= esc($titrePage) ?></h2>

    <?php if (!empty($categories) && is_array($categories)): ?>

    <div class="menu-grid">
        <?php foreach ($categories as $categorie): ?>

        <a href="<?= site_url('choix/'. $selection .'/' . $categorie['id']) ?>" class="action-card card-choice">
            <div class="icon-wrapper">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div class="text-wrapper">
                <h3><?= esc($categorie['libelle']) ?></h3>

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

</div>

<?= $this->endSection() ?>