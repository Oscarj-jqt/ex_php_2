<?php

require_once './Combat.php';
require_once './Archer.php';
require_once './Personnage.php';

$combat = new Combat;

$j1 = new Archer('Joueur 1');
$j2 = new Personnage('Joueur 2');

$combat->prendrePart($j1, $j2);

$combat->seDerouler();