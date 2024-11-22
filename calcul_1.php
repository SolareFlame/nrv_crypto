<?php
$mdp = "exempleMotDePasse";
$cost = 4;
$collision_p = 0.01;

// TEMPS POUR HASHAGE
$start_time = microtime(true);
$hashed_password = password_hash($mdp, PASSWORD_BCRYPT, ['cost' => $cost]);
$end_time = microtime(true);

$execution_time = $end_time - $start_time;
$execution_time_formatted = format_time($execution_time);

// NB CALCUL POUR COLLISION
$l = pow(2, 312);
$k = sqrt(9.21 * $l);
$k_with_collision_p = $k * $collision_p;

// TEMPS POUR COLLISION
$estimated_time = $k * $execution_time * $collision_p;
$estimated_time_formatted = format_time($estimated_time);

// RENDER HTML
$html = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Estimation Temps Collision</title>
</head>
<body>
    <h1>Estimation du Temps de Collision pour Bcrypt</h1>
    <div class="result">
        <h2>Temps d'exécution pour hacher le mot de passe :</h2>
        <p>Le temps d'exécution pour hacher le mot de passe "{$mdp}" avec un coût de {$cost} est de {$execution_time} secondes.</p>
        <p>Ce temps correspond à environ {$execution_time_formatted}.</p>
    </div>

    <div class="result">
        <h2>Nombre d'opérations nécessaires pour une collision avec une probabilité de 1% :</h2>
        <p>Avec une probabilité de {$collision_p} de collision, un attaquant devrait effectuer environ {$k_with_collision_p} opérations pour trouver une collision.</p>
    </div>      

    <div class="result">
        <h2>Estimation du temps nécessaire pour une collision par force brute avec une probabilité de 1% ::</h2>
        <p>En supposant que chaque tentative de hachage prend le même temps que celui calculé ci-dessus, il faudrait environ {$estimated_time} secondes pour réaliser une collision avec une probabilité de 1%.</p>
        <p>Ce temps correspond à environ {$estimated_time_formatted}.</p>
        <hr>
    </div>
</body>
</html>
HTML;

echo $html;

function format_time($seconds)
{
    if ($seconds < 60) {
        return "{$seconds} secondes";
    }

    $years = floor($seconds / (365.25 * 24 * 60 * 60));
    $months = floor(($seconds % (365.25 * 24 * 60 * 60)) / (30.4375 * 24 * 60 * 60));
    $days = floor(($seconds % (30.4375 * 24 * 60 * 60)) / (24 * 60 * 60));
    $hours = floor(($seconds % (24 * 60 * 60)) / (60 * 60));
    $minutes = floor(($seconds % (60 * 60)) / 60);
    $seconds = floor($seconds % 60);

    $formatted_time = "";
    if ($years > 0) $formatted_time .= "{$years} années ";
    if ($months > 0) $formatted_time .= "{$months} mois ";
    if ($days > 0) $formatted_time .= "{$days} jours ";
    if ($hours > 0) $formatted_time .= "{$hours} heures ";
    if ($minutes > 0) $formatted_time .= "{$minutes} minutes ";
    if ($seconds > 0) $formatted_time .= "{$seconds} secondes";

    return $formatted_time;
}
?>
