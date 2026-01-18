<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">

    <?php if (session()->getFlashdata('succes')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('succes') ?>
    </div>
    <?php endif; ?>

    <div class="mb-4 text-center">
        <span class="text-muted">Séance du <?= date('d/m/Y') ?> :</span>
        <h1 class="text-primary"><?= esc($categorie['libelle']) ?></h1>
        <p class="small text-muted">Remplis tes performances ci-dessous</p>
    </div>

    <?= form_open('seance/enregistrer') ?>

    <input type="hidden" name="idSeance" value="<?= esc($seance['id']) ?>">

    <?php if (!empty($exercices) && is_array($exercices)): ?>

    <?php foreach ($exercices as $exercice): ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary"><?= esc($exercice['libelle']) ?></h5>
                <span class="badge bg-secondary"><?= esc($exercice['nbSeries']) ?> Séries prévues</span>
            </div>
            <small class="text-muted">Charge de référence : <strong><?= esc($exercice['charge']) ?> kg</strong></small>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 20%">Série</th>
                        <th class="text-center" style="width: 40%">Reps</th>
                        <th class="text-center" style="width: 40%">Poids (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= $exercice['nbSeries']; $i++): ?>
                    <tr>
                        <td class="text-center align-middle">
                            <strong>#<?= $i ?></strong>
                        </td>

                        <td>
                            <input type="number" class="form-control text-center"
                                name="perfs[<?= $exercice['id'] ?>][<?= $i ?>][reps]" placeholder="0"
                                inputmode="numeric">
                        </td>

                        <td>
                            <input type="number" class="form-control text-center"
                                name="perfs[<?= $exercice['id'] ?>][<?= $i ?>][poids]"
                                value="<?= esc($exercice['charge']) ?>" step="0.5" inputmode="decimal">
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php endforeach; ?>

    <div class="d-grid gap-2 mt-4 mb-5">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="bi bi-check-circle-fill"></i> Terminer la séance
        </button>
        <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary">Annuler</a>
    </div>

    <?php else: ?>
    <div class="alert alert-warning">
        Aucun exercice n'est configuré pour ce modèle.
    </div>
    <div class="text-center">
        <a href="<?= site_url('/') ?>" class="btn btn-secondary">Retour</a>
    </div>
    <?php endif; ?>

    <?= form_close() ?>
</div>

<?= $this->endSection() ?>