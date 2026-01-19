<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <h2 class="text-center mb-4"><?= esc($titrePage) ?></h2>

    <?php if (session()->getFlashdata('succes')): ?>
    <div class="alert alert-success shadow-sm border-0">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('succes') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erreur')): ?>
    <div class="alert alert-danger shadow-sm border-0">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('erreur') ?>
    </div>
    <?php endif; ?>

    <div class="card mb-5 border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="bi bi-plus-lg me-2"></i>Nouveau programme</h5>
        </div>
        <div class="card-body">
            <?= form_open('categorie/sauvegarder', ['class' => 'row g-3']) ?>
            <div class="col-md-9">
                <input type="text" name="libelle" class="form-control"
                    placeholder="Ex: Full Body, Pousse/Tire, Jambes..." required>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-plus-circle"></i> Créer
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>

    <h3 class="h5 mb-3 text-muted px-2">Programmes enregistrés</h3>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th style="width: 70%">Nom du programme</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($programmes) && is_array($programmes)): ?>
                <?php foreach ($programmes as $pg): ?>
                <tr>
                    <td>
                        <?= form_open('categorie/sauvegarder', ['class' => 'd-flex gap-2']) ?>
                        <input type="hidden" name="id" value="<?= $pg['id'] ?>">
                        <input type="text" name="libelle" class="form-control form-control-sm border-0 bg-light"
                            value="<?= esc($pg['libelle']) ?>" required>
                        <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0"
                            title="Enregistrer les modifications">
                            <i class="bi bi-save2 text-primary"></i>
                        </button>
                        <?= form_close() ?>
                    </td>
                    <td class="text-end">
                        <div class="btn-group gap-2">
                            <a href="<?= site_url('seance/modification/' . $pg['id']) ?>"
                                class="btn btn-sm btn-outline-secondary" title="Gérer les exercices">
                                <i class="bi bi-list-task"></i>
                            </a>

                            <a href="<?= site_url('categorie/supprimer/' . $pg['id']) ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Attention : supprimer ce programme supprimera peut-être ses exercices. Confirmer ?')"
                                title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center py-4 text-muted italic">
                        Aucun programme n'a encore été créé.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-5 mb-5">
        <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary px-4">
            <i class="bi bi-house-door"></i> Retour à l'accueil
        </a>
    </div>
</div>

<?= $this->endSection() ?>