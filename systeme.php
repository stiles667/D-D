<?php
include 'config.php'; // Inclure le fichier de configuration
include 'charactere.php'; // Inclure le fichier de classe Character

class systeme{
    private $connexion;

    function __construct($connexion) {
        $this->connexion = $connexion;
    }

function select_character() {
    global $character_id;
    // Logique pour permettre à l'utilisateur de sélectionner un personnage
    // Peut-être une requête SQL pour afficher les personnages disponibles et choisir
    // Mettre à jour $character_id avec l'ID du personnage sélectionné
}

function start_game() {
    global $character_id, $monster_id;
    // Logique pour commencer le jeu avec le personnage sélectionné
    // Sélection de la première room, énigme, marchand, etc.
}

function combat() {
    global $character_id, $monster_id;
    // Logique pour gérer le combat avec le monstre
    // Attaque, défense, esquive, etc.
    // Mettre à jour les points d'expérience du personnage en cas de victoire
}

function loot() {
    global $character_id;
    // Logique pour générer un objet aléatoire après la victoire
    // Récompense du coffre après le combat
}

function save_progress() {
    global $character_id;
    // Logique pour sauvegarder la progression du personnage dans la base de données
}
}

// Create a new Systeme instance
$systeme = new Systeme($connexion);

// Example of game flow (very simplified)
$systeme->select_character();
$systeme->start_game();
$systeme->combat();
$systeme->loot();
$systeme->save_progress();

$connexion = null; // Close the database connection
?>


