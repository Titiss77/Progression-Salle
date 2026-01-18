<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="site-container">
    <div class="mt-4">
        <a href="<?= site_url('/') ?>" class="btn btn-secondary">← Retour à l'accueil</a>
    </div>
    <?php if (!empty($seances) && is_array($seances)): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col" style="width: 50%;">Séances</th>
                <th scope="col">Dates</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seances as $seance): ?>
            <tr>
                <td>
                    <strong><?= anchor('seance/detail/'.esc($seance['id']), esc($seance['libelle'])); ?></strong>
                </td>

                <td>
                    <?= esc($seance['date_seance']) ?>
                </td>
                <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-warning">Aucune catégorie trouvée.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>