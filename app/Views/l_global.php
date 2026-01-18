<?php
$menuItems = [
    '/' => 'Accueil',
    '/seances' => 'Les séances',
    '/historique' => 'Historique',
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title><?= $titrePage; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/root.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/global.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/' . $cssPage); ?>">
</head>

<body>
    <div class="site-container">
        <?php
        $uri = uri_string();
        ?>

        <?php if ($uri !== '' && $uri !== '/' && strpos($uri, 'seance/detail') === false): ?>

        <div class="d-flex align-items-center mb-4" style="padding: 20px 20px 0;">
            <a href="<?= site_url('/') ?>" class="btn-back">
                <i class="bi bi-arrow-left"></i> Retour à l'accueil
            </a>
        </div>

        <?php endif; ?>

        <?= $this->renderSection('contenu') ?>
    </div>
</body>

</body>

</html>