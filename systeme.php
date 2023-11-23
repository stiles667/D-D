<?php
include 'config.php'; // Inclure le fichier de configuration
include 'charactere.php'; // Inclure le fichier de classe Character
include 'systeme.php'; // Inclure le fichier de classe Systeme
class systeme{
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


// Exemple de flux du jeu (très simplifié)
select_character();
start_game();
combat();
loot();
save_progress();

$conn->close(); // Fermer la connexion à la base de données
?>


