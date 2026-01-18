<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <?php if (!empty($categories) && is_array($categories)): ?>

    <?php foreach ($categories as $categorie): ?>

    <div class="categorie-section">
        <h2><?= esc($categorie['libelle']) ?></h2>

        <ul>
            <?php foreach ($exercices as $exercice): ?>

            <?php if ($exercice['idCategorie'] == $categorie['id']): ?>
            <li>
                <strong><?= esc($exercice['libelle']) ?></strong>
                <?php if ($exercice['nbSeries']): ?>
                - <?= esc($exercice['nbSeries']) ?> séries
                <?php endif; ?>
                <?php if ($exercice['charge']): ?>
                à <?= esc($exercice['charge']) ?> kg
                <?php endif; ?>
            </li>
            <?php endif; ?>

            <?php endforeach; ?>
        </ul>
    </div>
    <hr>

    <?php endforeach; ?>

    <?php else: ?>
    <p>Aucune catégorie trouvée.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>