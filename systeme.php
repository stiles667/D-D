<?php
include 'config.php'; // Inclure le fichier de configuration
include 'charactere.php'; // Inclure le fichier de classe Character

class systeme{
    private $connexion;

    function __construct($connexion) {
        $this->connexion = $connexion;
    }

    function select_character() {
        global $character_id, $connexion;
    
        // Fetch all characters from the database
        $stmt = $connexion->prepare("SELECT * FROM characters");
        $stmt->execute();
        $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Display all characters and let the user select one
        echo "Please select a character:\n";
        foreach ($characters as $index => $character) {
            echo ($index + 1) . ". " . $character['name'] . "\n";
        }
    
        $choice = trim(fgets(STDIN)) - 1;
        if (isset($characters[$choice])) {
            $character_id = $characters[$choice]['id'];
            echo "You have selected " . $characters[$choice]['name'] . ".\n";
        } else {
            echo "Invalid choice. Please try again.\n";
            $this->select_character();
        }
    }

function start_game() {
    global $character_id, $monster_id;

    // Fetch character data
    $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$character_id]);
    $character = $stmt->fetch();

    // Fetch a random room
    $stmt = $this->connexion->prepare("SELECT * FROM rooms ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $room = $stmt->fetch();

    if ($room) {
        // Display character name and characteristics
        $message = "{$character['name']} (HP: {$character['hp']}, AP: {$character['ap']}, DP: {$character['dp']}) enters room {$room['id']}. ";

        if ($room['special']) {
            $message .= "It's a special room. ";
        }
        if ($room['puzzle']) {
            $message .= "Puzzle: {$room['puzzle']}. ";
        }
        if ($room['trap']) {
            $message .= "Trap: {$room['trap']}. ";
        }
        if ($room['merchant']) {
            $message .= "Merchant: {$room['merchant']}. ";
        }
        echo $message;
    } else {
        echo "{$character['name']} enters a room but it's empty. They can rest for a while.";
    }
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

// $systeme->combat();
// $systeme->loot();
// $systeme->save_progress();

// $connexion = null; // Close the database connection
?>


