<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="mt-4">
    <a href="<?= site_url('historique') ?>" class="btn btn-secondary">← Retour à l'historique</a>
</div>

<?php if (!empty($seance) && is_array($seance)): ?>

<div class="mb-4">
    <h2 class="text-primary"><?= esc($seance[0]['titre']); ?></h2>
    <p class="text-muted">
        <i class="bi bi-calendar-event"></i>
        Séance du <?= date('d/m/Y', strtotime($seance[0]['date'])); ?>
    </p>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col" style="width: 40%;">Exercice</th>
            <th scope="col" style="width: 30%;">Répétitions</th>
            <th scope="col" style="width: 30%;">Charges (kg)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($seance as $exo): ?>
        <tr>
            <td>
                <strong><?= esc($exo['libelle']); ?></strong>
            </td>
            <td>
                <?= esc($exo['liste_reps']); ?>
            </td>
            <td>
                <?= esc($exo['liste_poids']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>
<div class="alert alert-warning">
    Aucun exercice trouvé pour cette séance, ou la séance n'existe pas.
</div>
<?php endif; ?>

<?= $this->endSection() ?>