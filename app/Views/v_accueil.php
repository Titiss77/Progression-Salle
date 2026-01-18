<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">

    <h2 class="mb-4 text-center">Tableau de bord</h2>

    <div class="menu-grid">

        <a href="<?= site_url('choix/1') ?>" class="action-card card-primary">
            <div class="icon-wrapper">
                <i class="bi bi-plus-circle-fill"></i>
            </div>
            <div class="text-wrapper">
                <h3>Nouvelle Séance</h3>
                <p>Démarrer un entraînement</p>
            </div>
        </a>

        <a href="<?= site_url('choix/2') ?>" class="action-card card-secondary">
            <div class="icon-wrapper">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="text-wrapper">
                <h3>Gérer les Modèles</h3>
                <p>Éditer ou supprimer une séance type</p>
            </div>
        </a>

        <a href="<?= site_url('/seances') ?>" class="action-card card-quaternary">
            <div class="icon-wrapper">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <div class="text-wrapper">
                <h3>Voir les Modèles</h3>
                <p>Consulter les programmes types</p>
            </div>
        </a>

        <a href="<?= site_url('/historique') ?>" class="action-card card-tertiary">
            <div class="icon-wrapper">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="text-wrapper">
                <h3>Historique</h3>
                <p>Tes performances passées</p>
            </div>
        </a>

    </div>
</div>

<?= $this->endSection() ?>