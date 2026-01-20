<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>
<h2 class="mb-4 text-center">Historique des séances</h2>

<?php if (!empty($seances) && is_array($seances)): ?>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">Séance</th>
                <th scope="col" class="text-center">Date</th>
                <th scope="col" class="text-center">État</th>
                <th scope="col" class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seances as $seance): ?>
            <tr>
                <td class="fw-bold">
                    <?= esc($seance['libelle']); ?>
                </td>

                <td class="text-center">
                    <?= date('d/m/Y', strtotime($seance['date_seance'])) ?>
                </td>

                <td class="text-center">
                    <?php if ($seance['status'] === 'en_cours'): ?>
                    <span class="badge bg-warning text-dark">En cours</span>
                    <?php else: ?>
                    <span class="badge bg-success">Terminée</span>
                    <?php endif; ?>
                </td>

                <td class="text-end">
                    <?php if ($seance['status'] === 'en_cours'): ?>
                    <a href="<?= site_url('seance/creation/' . esc($seance['id'])) ?>" class="btn btn-sm btn-warning"
                        title="Reprendre la séance">
                        <i class="bi bi-pencil-fill"></i> Reprendre
                    </a>
                    <?php else: ?>
                    <a href="<?= site_url('seance/detail/' . esc($seance['id'])) ?>" class="btn btn-sm btn-primary"
                        title="Voir le détail">
                        <i class="bi bi-eye-fill"></i> Voir
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<div class="alert alert-info text-center">
    Aucune séance dans l'historique pour le moment.
</div>
<div class="text-center">
    <a href="<?= site_url('choix/1') ?>" class="btn btn-primary">Créer ma première séance</a>
</div>
<?php endif; ?>

<?= $this->endSection() ?>