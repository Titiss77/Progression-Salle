<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>
<h2 class="text-center text-primary mb-4"><?= $titrePage ?></h2>

<?= form_open('exercice/sauvegarder') ?>

<input type="hidden" name="id" value="<?= isset($exercice) ? esc($exercice['id']) : '' ?>">
<input type="hidden" name="idProgramme" value="<?= esc($idProgramme) ?>">

<div class="card p-4 shadow-sm">

    <?php if (!isset($exercice['id']) && !empty($listeExercices)): ?>
    <div class="mb-4 p-3 bg-light border rounded" id="groupLibelle">
        <label for=" idExistant" class="form-label fw-bold text-primary">Option 1 : Choisir dans la liste</label>
        <select class="form-select" id="idExistant" name="idExistant" onchange="toggleLibelleField()">
            <option value="">-- Créer un nouvel exercice --</option>
            <?php foreach ($listeExercices as $ex): ?>
            <option value="<?= $ex['id'] ?>"><?= esc($ex['libelle']) ?></option>
            <?php endforeach; ?>
        </select>
        <div class="form-text">Si vous sélectionnez un exercice ici, tous le reste sera ignoré.</div>
    </div>
    <hr>
    <?php endif; ?>

    <div class="mb-3" id="groupLibelle">
        <p class="form-label fw-bold text-primary">
            <?= (!isset($exercice['id']) && !empty($listeExercices)) ? 'Option 2 : ' : 'Option 1 : ' ?></p>
        <label for="libelle" class="form-label fw-bold">
            Nom de l'exercice
        </label>
        <input type="text" class="form-control" id="libelle" name="libelle"
            value="<?= isset($exercice) ? esc($exercice['libelle']) : '' ?>">
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
        <a href="<?= site_url('seance/modification/' . $idProgramme) ?>" class="btn btn-secondary">Annuler</a>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-lg"></i> Enregistrer
        </button>
    </div>
</div>

<?= form_close() ?>

<script>
function toggleLibelleField() {
    var select = document.getElementById('idExistant');
    var inputLibelle = document.getElementById('libelle');

    if (select && select.value !== "") {
        inputLibelle.disabled = true;
        inputLibelle.value = ""; // On vide le champ texte
        inputLibelle.required = false;
    } else {
        inputLibelle.disabled = false;
        inputLibelle.required = true;
    }
}
</script>

<?= $this->endSection() ?>