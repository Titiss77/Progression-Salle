<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <h2 class="text-center mb-4"><?= esc($titrePage) ?></h2>

    <?php if ($selection == 2): ?>
    <div class="mt-5 pt-4 border-top">
        <div class="menu-grid-global">
            <a href="<?= site_url('categorie/administrer') ?>" class="action-card card-choice">
                <div class="icon-wrapper">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div class="text-wrapper">
                    <h3>Les programmes</h3>
                    <p>Gérer les programmes</p>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>

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

</div>

<?= $this->endSection() ?>