<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">

    <?php if (session()->getFlashdata('succes')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('succes') ?>
    </div>
    <?php endif; ?>

    <div class="mb-4 text-center">
        <span class="text-muted">Séance créée :</span>
        <h1 class="text-primary"><?= esc($categorie['libelle']) ?></h1>
    </div>

    <?php if (!empty($exercices) && is_array($exercices)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Exercice</th>
                    <th scope="col" class="text-center">Séries prévues</th>
                    <th scope="col" class="text-center">Charge réf. (kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exercices as $exercice): ?>
                <tr>
                    <td>
                        <strong><?= esc($exercice['libelle']) ?></strong>
                    </td>
                    <td class="text-center">
                        <?= esc($exercice['nbSeries']) ?>
                    </td>
                    <td class="text-center">
                        <?= esc($exercice['charge']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">
        Aucun exercice n'est configuré pour ce modèle de séance.
    </div>
    <?php endif; ?>

    <div class="mt-4 text-center">
        <a href="<?= site_url('/') ?>" class="btn btn-secondary">Retour à l'accueil</a>
    </div>

</div>

<?= $this->endSection() ?>