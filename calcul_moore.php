<?php
$mdp = "exempleMotDePasse";
$cost = 4;
$cost_f = 14;

// TEMPS POUR HASHAGE ACTUEL
$start_time = microtime(true);
$hashed_password = password_hash($mdp, PASSWORD_BCRYPT, ['cost' => $cost]);
$end_time = microtime(true);

$execution_time = $end_time - $start_time;


// TEMPS POUR HASHAGE FUTUR
$start_time = microtime(true);
$hashed_password = password_hash($mdp, PASSWORD_BCRYPT, ['cost' => $cost_f]);
$end_time = microtime(true);

$execution_time_f = $end_time - $start_time;
$execution_time_f_diff = $execution_time_f/1024;

$html = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Estimation Temps Collision</title>
</head>
<body>
    <h1>Estimation du Temps de Collision pour Bcrypt avec loi de Moore</h1>
    <div class="result">
        <p>Temps d'exécution pour hacher le mot de passe avec un coût de {$cost} : {$execution_time} secondes.</p>
        <p>Temps d'exécution pour hacher le mot de passe avec un coût de {$cost_f} : {$execution_time_f} secondes.</p>
        
        <h2>Si on considère que la puissance de calcul est 1024 fois plus rapide dans 20ans, alors les deux temps d'exécution deviennent :</h2>
        <p>Temps d'exécution pour hacher le mot de passe avec un coût de {$cost} et la vitesse actuelle : {$execution_time} secondes.</p>
        <p>Temps d'exécution pour hacher le mot de passe avec un coût de {$cost_f} et avec une vitesse de calcul 1024x supérieure (théoriquement celle dans 20ans): {$execution_time_f_diff} secondes.</p>
    </div>
</body>
</html>
HTML;

echo $html;

?>
