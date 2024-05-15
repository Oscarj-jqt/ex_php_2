<?php

// include './Personnage.php'; // Si le fichier existe pas => WARNING
// require './Personnage.php'; // Si le fichier exite pas => ERROR (interruption du processus)

// include_once './Personnage.php'; // S'assure que le fichier n'est inclus qu'une seule fois
require_once './Personnage.php'; // S'assure que le fichier n'est inclus qu'une seule fois

class Combat {
    /** @var array<Personnage> */
    public array $joueurs = [];

    /**
     * Cette méthode ajoute un / des joueur(s) au combat
     * 
     * @param Personnage[] $joueurs Les joueurs à ajouter au combat
     */
    function prendrePart(Personnage ...$joueurs) {
        foreach ($joueurs as $j) {
            $this->joueurs[] = $j; // = array_push($j)
        }
    }

    function abandonner(Personnage $qqun) {
        if ($k = array_search($qqun, $this->joueurs)) {
            unset($this->joueurs[$k]);
        }
    }

    /**
     * "Exécute" le combat
     * Renvoie le vainqueur
     * 
     * @return Personnage Le vainqueur
     */
    function seDerouler(): Personnage|false {
        while (sizeof($this->joueurs) > 1) {
            foreach ($this->joueurs as $j) {
                echo 'C\'est au tour de ' . $j->nom . PHP_EOL;
                $j->effectuerTour($this);

                if (sizeof($this->joueurs) == 1) break;
            }
        }

        return $this->joueurs[array_key_first($this->joueurs)] ?? false;
    }
}

$c = new Combat;
$c->seDerouler();
