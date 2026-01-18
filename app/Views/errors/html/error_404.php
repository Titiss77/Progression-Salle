<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 60vh;">

    <div class="card p-5 shadow-lg text-center" style="width: 100%; max-width: 400px;">

        <div class="mb-4">
            <div class="icon-wrapper mx-auto"
                style="background: rgba(231, 76, 60, 0.1); color: var(--color-danger); width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>

        <h1 class="text-primary mb-2">404</h1>
        <h4 class="mb-4">Page introuvable</h4>

        <div class="alert alert-secondary text-muted mb-4" style="text-align: left; font-size: 0.9rem;">
            <?php if (ENVIRONMENT !== 'production'): ?>
            <strong>Erreur technique :</strong><br>
            <?= nl2br(esc($message)) ?>
            <?php else: ?>
            Oups ! La page que vous recherchez n'existe pas ou a été déplacée.
            <?php endif; ?>
        </div>

        <a href="<?= site_url('/') ?>" class="btn btn-primary btn-lg w-100">
            <i class="bi bi-house-door-fill"></i> Retour à l'accueil
        </a>

    </div>

</div>

<?= $this->endSection() ?>