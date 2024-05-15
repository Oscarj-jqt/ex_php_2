<?php

require_once './Personnage.php';
require_once './Narrateur.php';
require_once './Combat.php';

class Archer extends Personnage {
    public int $nbrFleches = 10;
    public int $precision = 75;

    function tirerUneFleche(Personnage $cible) {
        if ($this->nbrFleches) {
            Narrateur::parler('Je tire une flèche sur ' . $cible->nom, $this);
            $this->nbrFleches--;

            if (rand(0, 100) <= $this->precision) {
                $i = rand(10, 100);
                Narrateur::parler($cible->nom . ' perd ' . $i . ' PV');
                $cible->pdv -= $i;
            } else {
                Narrateur::parler('J\'ai raté ma cible...', $this);
            }
        }
    }

    function effectuerTour(Combat $combat) {
        while (
            !in_array(
                $choix = readline('Que voulez-vous faire ? '
                    . PHP_EOL . '1: Attaquer'
                    . PHP_EOL . '2: Tirer une flèche'
                    . PHP_EOL . '3: Prendre la fuite'
                    . PHP_EOL),
                [1, 2, 3]
            )
        );

        switch ($choix) {
            case 1:
                $choix = -1;
                while (!isset($combat->joueurs[$choix])) {
                    echo 'Qui voulez-vous attaquer ?' . PHP_EOL;
                    foreach ($combat->joueurs as $key => $joueur) {
                        echo $key . ': ' . $joueur->nom . PHP_EOL;
                    }

                    $choix = readline();
                }

                $cible = $combat->joueurs[$choix];

                $this->attaquer($cible);

                if ($cible->pdv <= 0) {
                    Narrateur::parler($cible->nom . ' est morte au champ d\'honneur.');
                    $combat->abandonner($cible);
                }
                break;

            case 2:
                $choix = -1;
                while (!isset($combat->joueurs[$choix])) {
                    echo 'Sur qui voulez-vous tirer ?' . PHP_EOL;
                    foreach ($combat->joueurs as $key => $joueur) {
                        echo $key . ': ' . $joueur->nom . PHP_EOL;
                    }

                    $choix = readline();
                }

                $cible = $combat->joueurs[$choix];

                $this->tirerUneFleche($cible);

                if ($cible->pdv <= 0) {
                    Narrateur::parler($cible->nom . ' est morte au champ d\'honneur.');
                    $combat->abandonner($cible);
                }
                break;

            case 3:
                $this->fuir($combat);
                break;
        }
    }
}
