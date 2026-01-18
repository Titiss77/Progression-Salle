<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <div class="mt-4">
        <a href="<?= site_url('/') ?>" class="btn btn-secondary">← Retour à l'accueil</a>
    </div>
    <?php if (!empty($categories) && is_array($categories)): ?>

    <?php foreach ($categories as $categorie): ?>

    <div class="categorie-section mb-4">
        <h2 class="mt-4"><?= esc($categorie['libelle']) ?></h2>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="width: 50%;">Exercice</th>
                    <th scope="col">Séries</th>
                    <th scope="col">Charge (kg)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exercices as $exercice): ?>

                <?php if ($exercice['idCategorie'] == $categorie['id']): ?>
                <tr>
                    <td>
                        <strong><?= esc($exercice['libelle']) ?></strong>
                    </td>

                    <td>
                        <?php if (!empty($exercice['nbSeries'])): ?>
                        <?= esc($exercice['nbSeries']) ?>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if (!empty($exercice['charge'])): ?>
                        <?= esc($exercice['charge']) ?> kg
                        <?php else: ?>
                        <span class="text-muted">-</span> <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php endforeach; ?>

    <?php else: ?>
    <div class="alert alert-warning">Aucune catégorie trouvée.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>