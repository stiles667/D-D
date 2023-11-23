<?php
include 'config.php'; // Inclure le fichier de configuration
include 'charactere.php'; // Inclure le fichier de classe Character

class systeme{
    private $connexion;
    public $character;


    function __construct($connexion) {
        $this->connexion = $connexion;
        $this->character = new Character();
    }

    function select_character() {
        // Fetch all characters from the database
        $stmt = $this->connexion->prepare("SELECT * FROM characters");
        $stmt->execute();
        $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display all characters and let the user select one
        echo "Please select a character:\n";
        foreach ($characters as $index => $character) {
            echo ($index + 1) . ". " . $character['name'] . "\n";
        }

        $choice = trim(fgets(STDIN)) - 1;
        if (isset($characters[$choice])) {
            $this->character->id = $characters[$choice]['id'];
            echo "You have selected " . $characters[$choice]['name'] . ".\n";
        } else {
            echo "Invalid choice. Please try again.\n";
            $this->select_character();
        }
    }

    function start_game() {
    
        // Fetch character data
        $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
        $stmt->execute([$this->character->id]);
        $character = $stmt->fetch();
        if (!$character) {
            echo "No character found.\n";
            return;
        }
    
        while (true) {
            // Fetch a random room
            $stmt = $this->connexion->prepare("SELECT * FROM rooms WHERE merchant IS NULL ORDER BY RAND() LIMIT 1");
            $stmt->execute();
            $room = $stmt->fetch();
    
            if ($room) {
                // Display character name and characteristics
                echo "{$character['name']} (HP: {$character['hp']}, AP: {$character['ap']}, DP: {$character['dp']}) enters room {$room['id']}. ";
    
                // Check if the room has a puzzle
                if ($room['puzzle']) {
                    // Fetch the puzzle question and choices
                    $stmt = $this->connexion->prepare("SELECT question, choice1, choice2, choice3, answer FROM puzzles WHERE id = ?");
                    $stmt->execute([$room['puzzle']]);
                    $puzzle = $stmt->fetch();
    
                    if ($puzzle) {
                        echo "This room has a puzzle: {$puzzle['question']}\n";
                        echo "1: {$puzzle['choice1']}\n";
                        echo "2: {$puzzle['choice2']}\n";
                        echo "3: {$puzzle['choice3']}\n";
    
                        $answer = readline("Enter your answer (1, 2, or 3): ");
    
                        if ($answer == $puzzle['answer']) {
                            echo "Correct answer! You gain points.\n";
                            // Add points to a random attribute
                            $attribute = array_rand(['hp', 'ap', 'dp']);
                            $character[$attribute] += 10;
                        
                            // Update the character's attribute in the database
                            $stmt = $this->connexion->prepare("UPDATE characters SET $attribute = ? WHERE id = ?");
                            $stmt->execute([$character[$attribute], $this->character->id]);
                        } else {
                            echo "Wrong answer! You lose points.\n";
                            // Subtract points from a random attribute
                            $attribute = array_rand(['hp', 'ap', 'dp']);
                            $character[$attribute] -= 10;
                        
                            // Update the character's attribute in the database
                            $stmt = $this->connexion->prepare("UPDATE characters SET $attribute = ? WHERE id = ?");
                            $stmt->execute([$character[$attribute], $this->character->id]);
                        
                            // Check if the character's HP is 0 or less
                            if ($character['hp'] <= 0) {
                                echo "{$character['name']} has died.";
                                break;
                            }
                        }
                    } else {
                        echo "No puzzle found in this room.\n";
                    }
                }
    
                // Initiate a combat if the room has no merchant and no puzzle
                if (!$room['merchant'] && !$room['puzzle']) {
                    $combatResult = $this->combat();
    
                    if ($combatResult == 'defeat') {
                        echo "{$character['name']} is defeated and the game ends.";
                        break;
                    }
                }
            } else {
                echo "{$character['name']} enters a room but it's empty. They can rest for a while.";
            }
    
            // Ask the player for the next action
            $action = readline("Choose an action (1 = explore the dungeon, 2 = quit game): ");
    
            if ($action == 2) {
                echo "{$character['name']} decides to quit the game.";
                break;
            }
        }
    }
function combat() {
   

    // Fetch character data
    $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
        $stmt->execute([$this->character->id]);
        $character = $stmt->fetch();

    // Fetch a random monster
    $stmt = $this->connexion->prepare("SELECT * FROM monsters ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $monster = $stmt->fetch();

    if ($monster) {
        echo "A {$monster['name']} appears and attacks you!";

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

