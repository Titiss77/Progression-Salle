<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<?php if (session()->getFlashdata('succes')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('succes') ?></div>
<?php endif; ?>

<h2 class="text-primary text-center mb-4">Modifier le modèle : <?= esc($programme['libelle']) ?></h2>

<div class="text-end mb-3">
    <a href="<?= site_url('exercice/ajouter/' . $programme['id']) ?>" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Ajouter un exercice
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Exercice</th>
                <th class="text-center" style="width: 15%;">Charge (kg)</th>
                <th class="text-center" style="width: 15%;">Séries</th>
                <th class="text-center" style="width: 20%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($exercices)): ?>
            <?php foreach ($exercices as $ex): ?>
            <tr>
                <td>
                    <strong><?= esc($ex['libelle']) ?></strong>
                </td>
                <td class="text-center"><?= esc($ex['charge']) ?></td>
                <td class="text-center"><?= esc($ex['nbSeries']) ?></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="<?= site_url('exercice/monter/' . $ex['id']) ?>"
                            class="btn btn-sm btn-outline-secondary" title="Monter">
                            <i class="bi bi-arrow-up"></i>
                        </a>

                        <a href="<?= site_url('exercice/descendre/' . $ex['id']) ?>"
                            class="btn btn-sm btn-outline-secondary" title="Descendre">
                            <i class="bi bi-arrow-down"></i>
                        </a>
                    </div>

                    <a href="<?= site_url('exercice/modifier/' . $ex['id']) ?>"
                        class="btn btn-sm btn-warning text-white ms-2">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <a href="<?= site_url('exercice/supprimer/' . $ex['id']) ?>" class="btn btn-sm btn-danger ms-1"
                        onclick="return confirm('Supprimer ?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4" class="text-center text-muted">Aucun exercice dans ce modèle.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>