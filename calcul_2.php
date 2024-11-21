<?php
$mdp = "exempleMotDePasse";
$cost_start = 4;
$cost_end = 14;


// CALCUL TEMPS POUR HASHAGE
$time_tab = array();
for ($i = $cost_start; $i <= $cost_end; $i++) {
    $start_time = microtime(true);
    $hashed_password = password_hash($mdp, PASSWORD_BCRYPT, ['cost' => $i]);
    $end_time = microtime(true);

    $time_tab[$i] =  $end_time - $start_time;
}

// RENDER HTML
$res = "<div class='result'>";
foreach ($time_tab as $c => $time) {
    $res .= "<p>Le temps d'exécution pour hacher le mot de passe \"{$mdp}\" avec un coût de {$c} est de {$time} secondes.</p>";
}
$res .= "</div>";

$html = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Estimation Temps Collision</title>
</head>
<body>
    <h1>Estimation du Temps de Collision pour Bcrypt</h1>
    {$res}
</body>
</html>
HTML;

echo $html;
?>
