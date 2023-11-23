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
            $message = "{$character['name']} enters a level {$room['id']} dungeon room. ";
    
            if ($room['special']) {
                $message .= "It's a special room. ";
            }
            if ($room['puzzle']) {
                $message .= "{$character['name']} encounters a puzzle: {$room['puzzle']}. ";
                echo $message;
                echo "Do you want to solve the puzzle? (yes/no)\n";
                $choice = trim(fgets(STDIN));
                if ($choice == 'yes') {
                    echo "{$character['name']} has solved the puzzle.\n";
                } else {
                    echo "Game over.\n";
                    exit;
                }
            }
            if ($room['trap']) {
                $message .= "{$character['name']} encounters a trap: {$room['trap']}. ";
                echo $message;
                echo "Do you want to disarm the trap? (yes/no)\n";
                $choice = trim(fgets(STDIN));
                if ($choice == 'yes') {
                    echo "{$character['name']} has disarmed the trap.\n";
                } else {
                    echo "Game over.\n";
                    exit;
                }
            }
            if ($room['merchant']) {
                $message .= "{$character['name']} encounters a merchant: {$room['merchant']}. ";
                echo $message;
            }
        } else {
            echo "{$character['name']} enters a room but it's empty. They can rest for a while.";
        }
    }
function combat() {
    global $character_id, $monster_id;

    // Fetch character data
    $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$character_id]);
    $character = $stmt->fetch();

    // Fetch a random monster
    $stmt = $this->connexion->prepare("SELECT * FROM monsters ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $monster = $stmt->fetch();

    if ($monster) {
        // Loop until someone dies
        while ($character['hp'] > 0 && $monster['hp'] > 0) {
            // Get user action
            $action = readline("Choose an action (1 = attack, 2 = dodge, 3 = defend): ");

            switch ($action) {
                case 1: // Attack
                    if ($character['ap'] > $monster['dp']) {
                        $monster['hp'] -= $character['ap'];
                        echo "{$character['name']} attacks and hits the {$monster['name']}! Monster HP: {$monster['hp']}";
                    } else {
                        echo "{$character['name']} attacks but is blocked by the {$monster['name']}!";
                    }
                    break;
                case 2: // Dodge
                    echo "{$character['name']} dodges the attack of the {$monster['name']}!";
                    break;
                case 3: // Defend
                    if ($monster['ap'] > $character['dp']) {
                        $character['hp'] -= $monster['ap'];
                        echo "{$character['name']} tries to defend but is hit by the {$monster['name']}! Character HP: {$character['hp']}";
                    } else {
                        echo "{$character['name']} defends successfully against the attack of the {$monster['name']}!";
                    }
                    break;
            }

            // Monster attacks
            if ($monster['hp'] > 0) {
                $character['hp'] -= $monster['ap'];
                echo "The {$monster['name']} attacks! Character HP: {$character['hp']}";
            }
        }

        // Check who died
        if ($character['hp'] <= 0) {
            echo "{$character['name']} is defeated by the {$monster['name']}!";
        } else {
            echo "{$character['name']} defeats the {$monster['name']}!";
        }
    } else {
        echo "{$character['name']} finds no monsters to fight.";
    }
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
// $systeme->loot();
// $systeme->save_progress();

// $connexion = null; // Close the database connection
?>


