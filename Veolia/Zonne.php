<?php
//Start timer
$start_time = microtime(true);
// import File
$filename = 'data.txt';
//Read file & Manipulate content
$data = file($filename);
// 2 input
$largeur = $data[0];
$terrain = $data[1];

// Define "les Contraintes"
const min_largeur = 1;
const max_largeur = 100000;
const min_sommet = 0;
const max_sommet = 100000;

// 1 ≤ n ≤ 100 000
function verifLargeur($largeur)
{
    if (!is_numeric($largeur)) {

        echo (' </br> il ne faut pas mettre une valeur non numéric ');
        exit();

    }

    if ($largeur < 1) {
        echo ('</br> la largeur  ne peut pas étre inférieur à :' . min_largeur);
        exit();

    }

    if ($largeur > 100000) {
        echo ('</br> la largeur ne peut étre supérieur à :' . max_largeur);
        exit();

    }

    return $largeur;
}

// 0 ≤ h ≤ 100 000
function verifSommet($data)
{
    $terrain = $data[1];

    $altitudes = explode(" ", $terrain);

    foreach ($altitudes as $altitude) {
        //if table contains strings
        if (!is_numeric($altitude)) {

            echo (' </br> il ne faut pas mettre une valeur non numéric ');
            exit();
        }

        if ($altitude < 0) {
            echo (' </br> la sommet ne peut pas étre moins de :' . min_sommet);
            exit();

        }

        if ($altitude > 100000) {
            echo ('</br> la sommet ne peut pas étre moins de :' . max_sommet);
            exit();

        }
    }

    return $altitudes;

}
// Get superficie
function getSafezone($largeur, $data)
{

    $terrain = explode(" ", $data[1]);
    $zone = 0;
    $sommet = 0;
    $diff = 0;

    // fetch the continent
    for ($i = 0; $i < $largeur; ++$i) {

        // si plus cours que sommet retourne 0
        $hauteur = $terrain[$i] ?? 0;

        if ($hauteur > $sommet) {
            // Zone danger
            $sommet = $hauteur;
        } else if ($sommet > $hauteur) {
            $zone += $sommet - $hauteur;
            $diff++;

        }
    }
    echo ('Le nombre de surface d\'abri : ' . $diff . '<br>');
    echo ('<br> La superficie safe zone = ' . $zone . '<br>');
}

verifLargeur($largeur);

verifSommet($data);

getSafezone($largeur, $data);

//end timer
$execution_time = (microtime(true) - $start_time);
echo "<br> Temps d'éxécution = " . ($execution_time) . " Secondes <br>";

//Convert ram memory usage
function convert($size)
{

    $unit = array('byte', 'kbyte', 'mByte', 'gbyte', 'tbyte', 'pbyte');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}
//Définir à true pour récupérer la taille totale de la mémoire allouée par le système
echo " <br> La mémoire utilisé = " . convert(memory_get_usage(true));
