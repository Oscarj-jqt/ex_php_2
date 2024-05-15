<?php

require_once './Combat.php';
require_once './Narrateur.php';

class Personnage {
    public string $nom;
    public int $pdv = 100;

    const CHOIX = [
        'attaquer' => 'Attaquer un autre personnage',
        'fuir' => 'fuir'
    ];

    function __construct(string $nom) {
        $this->nom = $nom;
    }

    function attaquer(Personnage $qqunDAutre) {
        Narrateur::parler('J\'attaque ' . $qqunDAutre->nom, $this);
        $qqunDAutre->pdv -= ($i = rand(0, 50));
        Narrateur::parler($qqunDAutre->nom . ' perd ' . $i . ' PV');
    }

    function fuir(Combat $combat): bool {
        Narrateur::parler('Je tente de prendre la fuite', $this);

        if (rand(0, 1)) {
            $combat->abandonner($this);
            Narrateur::parler('Je prends la fuite', $this);
            return true;
        } else {
            return false;
        }
    }

    function effectuerTour(Combat $combat) {
        while (
            !in_array(
                $choix = readline('Que voulez-vous faire ? '
                    . PHP_EOL . '1: Attaquer'
                    . PHP_EOL . '2: Prendre la fuite'
                    . PHP_EOL),
                [1, 2]
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
                $this->fuir($combat);
                break;
        }
    }
}
