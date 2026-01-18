<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>
<h2 class="text-center text-primary mb-4"><?= $titrePage ?></h2>

<?= form_open('exercice/sauvegarder') ?>

<input type="hidden" name="id" value="<?= isset($exercice) ? esc($exercice['id']) : '' ?>">
<input type="hidden" name="idCategorie" value="<?= esc($idCategorie) ?>">

<div class="card p-4 shadow-sm">

    <div class="mb-3">
        <label for="libelle" class="form-label fw-bold">Nom de l'exercice</label>
        <input type="text" class="form-control" id="libelle" name="libelle"
            value="<?= isset($exercice) ? esc($exercice['libelle']) : '' ?>" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nbSeries" class="form-label fw-bold">Nombre de séries</label>
            <input type="number" class="form-control" id="nbSeries" name="nbSeries"
                value="<?= isset($exercice) ? esc($exercice['nbSeries']) : '4' ?>" required min="1">
        </div>

        <div class="col-md-6 mb-3">
            <label for="charge" class="form-label fw-bold">Charge de référence (kg)</label>
            <input type="number" class="form-control" id="charge" name="charge" step="0.5"
                value="<?= isset($exercice) ? esc($exercice['charge']) : '0' ?>">
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="<?= site_url('seance/modification/' . $idCategorie) ?>" class="btn btn-secondary">Annuler</a>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i> Enregistrer
        </button>
    </div>
</div>

<?= form_close() ?>

<?= $this->endSection() ?>