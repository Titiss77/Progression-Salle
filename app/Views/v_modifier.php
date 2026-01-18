<?= $this->extend('l_global') ?>
<?= $this->section('contenu') ?>

<div class="site-container">
    <h2 class="text-primary text-center">Modifier le modèle : <?= esc($categorie['libelle']) ?></h2>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Exercice</th>
                <th>Charge (kg)</th>
                <th>Séries</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exercices as $ex): ?>
            <tr>
                <td><?= esc($ex['libelle']) ?></td>
                <td><?= esc($ex['charge']) ?></td>
                <td><?= esc($ex['nbSeries']) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning">Modifier</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="<?= site_url('/') ?>" class="btn btn-secondary">Retour</a>
    </div>
</div>
<?= $this->endSection() ?>