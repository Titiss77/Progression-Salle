<?= $this->extend('l_global') ?>

<?= $this->section('contenu') ?>

<div class="d-flex align-items-center mb-4" style="padding: 20px 20px 0;">
    <a href="<?= site_url('historique') ?>" class="btn-back">
        <i class="bi bi-arrow-left"></i> Retour à l'historique
    </a>
</div>

<?php if (!empty($seance) && is_array($seance)): ?>

<?php 
    // --- CALCULS GLOBAUX DE LA SÉANCE ---
    // On initialise les compteurs
    $grandTotalVolume = 0;
    $grandTotalReps = 0;

    // On parcourt les exercices pour additionner les totaux
    foreach ($seance as $calcul) {
        // On s'assure que les clés existent (si vous avez mis à jour la requête SQL)
        $vol = isset($calcul['volume_total']) ? $calcul['volume_total'] : 0;
        $reps = isset($calcul['total_reps']) ? $calcul['total_reps'] : 0;
        
        $grandTotalVolume += $vol;
        $grandTotalReps += $reps;
    }
    ?>

<div class="mb-4">
    <h2 class="text-primary"><?= esc($seance[0]['titre']); ?></h2>
    <p class="text-muted">
        <i class="bi bi-calendar-event"></i>
        Séance du <?= date('d/m/Y', strtotime($seance[0]['date'])); ?>
    </p>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col" style="width: 35%;">Exercice</th>
            <th scope="col" style="width: 25%;">Répétitions</th>
            <th scope="col" style="width: 25%;">Charges (kg)</th>
            <th scope="col" style="width: 15%;" class="text-center">Volume</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($seance as $exo): ?>
        <tr>
            <td>
                <strong><?= esc($exo['libelle']); ?></strong>
            </td>
            <td>
                <?= esc($exo['liste_reps']); ?>
                <br>
                <small class="text-muted">Total: <strong><?= esc($exo['total_reps']); ?></strong> reps</small>
            </td>
            <td>
                <?= esc($exo['liste_poids']); ?>
            </td>
            <td class="text-center align-middle">
                <span class="badge bg-info text-dark" style="font-size: 0.9em;">
                    <?= number_format($exo['volume_total'], 0, ',', ' '); ?> kg
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<section class="mt-5 mb-5">
    <h3 class="mb-4 border-bottom pb-2">Statistiques Globales de la séance</h3>

    <div class="row">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted text-uppercase" style="font-size: 0.9rem;">Volume Total</h5>
                    <p class="display-6 fw-bold text-primary mb-0">
                        <?= number_format($grandTotalVolume, 0, ',', ' '); ?> <small style="font-size: 0.5em">kg</small>
                    </p>
                    <small class="text-muted">Poids total soulevé</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted text-uppercase" style="font-size: 0.9rem;">Total Répétitions</h5>
                    <p class="display-6 fw-bold text-success mb-0">
                        <?= $grandTotalReps; ?>
                    </p>
                    <small class="text-muted">Mouvements effectués</small>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4 mb-3">
            <div class="card h-100 border-secondary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted text-uppercase" style="font-size: 0.9rem;">Intensité Moyenne</h5>
                    <p class="display-6 fw-bold text-secondary mb-0">
                        <?php 
                                // Évite la division par zéro
                                $avg = ($grandTotalReps > 0) ? $grandTotalVolume / $grandTotalReps : 0;
                                echo number_format($avg, 1, ',', ''); 
                            ?> <small style="font-size: 0.5em">kg/rep</small>
                    </p>
                    <small class="text-muted">Poids moyen par répétition</small>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else: ?>
<div class="alert alert-warning">
    Aucun exercice trouvé pour cette séance, ou la séance n'existe pas.
</div>
<?php endif; ?>

<?= $this->endSection() ?>