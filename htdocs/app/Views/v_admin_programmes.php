<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="admin-prog-container">
    <h2 class="admin-prog-title"><?= esc($titrePage) ?></h2>

    <?php if (session()->getFlashdata('succes')): ?>
    <div class="admin-prog-alert alert-success">
        <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('succes') ?>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erreur')): ?>
    <div class="admin-prog-alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i> <?= session()->getFlashdata('erreur') ?>
    </div>
    <?php endif; ?>

    <section class="admin-prog-creator">
        <div class="admin-prog-creator-header">
            <h5><i class="bi bi-plus-lg"></i> Nouveau programme</h5>
        </div>
        <?= form_open('categorie/sauvegarder', ['class' => 'admin-prog-form-inline']) ?>
        <input type="text" name="libelle" class="admin-prog-input" placeholder="Ex: Full Body, Pousse/Tire..." required>
        <button type="submit" class="admin-prog-btn-add">
            <i class="bi bi-plus-circle"></i> Créer
        </button>
        <?= form_close() ?>
    </section>

    <section class="admin-prog-list-section">
        <h3 class="admin-prog-subtitle">Programmes enregistrés</h3>
        <div class="admin-prog-table-wrapper">
            <table class="admin-prog-table">
                <thead>
                    <tr>
                        <th>Nom du programme</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($programmes) && is_array($programmes)): ?>
                    <?php foreach ($programmes as $pg): ?>
                    <tr class="admin-prog-row">
                        <td class="admin-prog-cell-name">
                            <?= form_open('categorie/sauvegarder', ['class' => 'admin-prog-inline-edit']) ?>
                            <input type="hidden" name="id" value="<?= $pg['id'] ?>">
                            <input type="text" name="libelle" class="admin-prog-input-edit"
                                value="<?= esc($pg['libelle']) ?>" required>
                            <button type="submit" class="admin-prog-btn-save" title="Enregistrer">
                                <i class="bi bi-save2"></i>
                            </button>
                            <?= form_close() ?>
                        </td>
                        <td class="admin-prog-cell-actions">
                            <div class="admin-prog-actions-group">
                                <a href="<?= site_url('seance/modification/' . $pg['id']) ?>"
                                    class="admin-prog-btn-action btn-manage" title="Gérer les exercices">
                                    <i class="bi bi-list-task"></i>
                                </a>
                                <a href="<?= site_url('categorie/supprimer/' . $pg['id']) ?>"
                                    class="admin-prog-btn-action btn-delete"
                                    onclick="return confirm('Confirmer l\'archivage de ce programme ?')"
                                    title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="2" class="admin-prog-empty">
                            Aucun programme actif trouvé.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?= $this->endSection() ?>