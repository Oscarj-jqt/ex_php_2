<?php

require_once './Personnage.php';

class Narrateur {
    static function parler(string $parole, ?Personnage $personnage = null) {
        if (!empty($personnage)) {
            echo $personnage->nom . ' : ';
        }

        echo $parole . PHP_EOL;
    }
}
