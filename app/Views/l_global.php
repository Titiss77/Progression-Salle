<?php
$menuItems = [
    '/' => 'Accueil',
    '/general' => 'Vue globale',
    '/seances' => 'Toutes les séances',
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
    <nav>
        <ul>
            <?php foreach ($menuItems as $url => $label): ?>
            <li>
                <?= anchor($url, $label); ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?= $this->renderSection('contenu') ?>

    <footer id="piedBlog">

        <nav>
            <ul>
                <?php foreach ($menuItems as $url => $label): ?>
                <li>
                    <?= anchor($url, $label); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </footer>

</body>

</html>