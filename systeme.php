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
                    // Fetch all puzzles
                    $stmt = $this->connexion->prepare("SELECT id, question, choice1, choice2, choice3, answer FROM puzzles");
                    $stmt->execute();
                    $puzzles = $stmt->fetchAll();
                
                    // Select a random puzzle
                    $puzzle = $puzzles[array_rand($puzzles)];
                
                    if ($puzzle) {
                        echo "This room has a puzzle: {$puzzle['question']}\n";
                        echo "1: {$puzzle['choice1']}\n";
                        echo "2: {$puzzle['choice2']}\n";
                        echo "3: {$puzzle['choice3']}\n";
                
                        $answer = readline("Enter your answer (1, 2, or 3): ");
                
                        if ($answer != $puzzle['answer']) {
                            echo "Wrong answer! You lose points.\n";
                            $character['hp'] -= 10; // Subtract 10 from HP

                            // Update the character's HP in the database
                            $stmt = $this->connexion->prepare("UPDATE characters SET hp = ? WHERE id = ?");
                            $stmt->execute([$character['hp'], $character['id']]);
                        } else {
                            echo "Correct answer! You gain points.\n";
                            // Add points to a random attribute
                            $attribute = array_rand(['hp' => 'hp', 'ap' => 'ap', 'dp' => 'dp']);
                            $character[$attribute] += 10;

                            // Update the character's attribute in the database
                            $stmt = $this->connexion->prepare("UPDATE characters SET $attribute = ? WHERE id = ?");
                            $stmt->execute([$character[$attribute], $character['id']]);

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
                if ($room['trap']) {
                    echo "This room has a trap: {$room['trap']}\n";
                    echo "{$character['name']} fell into a trap! You lose health.\n";
                    $character['hp'] -= 15; // Subtract 15 from HP for falling into the trap
                
                    // Update the character's HP in the database
                    // $stmt = $this->connexion->prepare("UPDATE characters SET hp = ? WHERE id = ?");
                    // $stmt->execute([$character['hp'], $character['id']]);
                
                    // Check if the character's HP is 0 or less
                    if ($character['hp'] <= 0) {
                        echo "{$character['name']} has died in a trap.";
                        break;
                    }
                }

                if ($room['merchant']) {
                    // Call the merchant function
                    $this->merchant();
                }
    
                // Initiate a combat if the room has no merchant and no puzzle
                if (!$room['merchant'] && !$room['puzzle'] && !$room['trap']) {
                    $combatResult = $this->combat();
    
                    if ($combatResult == 'defeat') {
                        echo "{$character['name']} est vaincu et le jeu se termine.";
                        break;
                    } else {
                        // Après avoir vaincu le monstre, effectuez le loot
                        $this->loot();
                    }
                }
            } else {
                echo "{$character['name']} enters a room but it's empty. They can rest for a while.";
            }
    
            // Ask the player for the next action
            $action = readline("Choose an action (1 = explore the dungeon, 2 = quit game): ");
    
            if ($action == '1') {
                // Explore the dungeon
                if (!$room['merchant'] && !$room['puzzle'] && !$room['trap']) {
                    $combatResult = $this->combat();
    
                    if ($combatResult == 'defeat') {
                        echo "{$character['name']} has been defeated, and the game ends.";
                        break;
                    } else {
                        // After defeating the monster, perform loot
                        $this->loot();
                    }
                }
            } elseif ($action == '2') {
                // Interact with the merchant
                if ($room['merchant']) {
                    $this->merchant();
                } else {
                    echo "There is no merchant in this room.\n";
                }
            } elseif ($action == '3') {
                // Quit the game
                echo "{$character['name']} decides to quit the game.";
                break;
            } else {
                echo "Invalid choice. Please try again.\n";
            }
        }
    }
  function combat() {
    // Fetch character data
    $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$this->character->id]);
    $character = $stmt->fetch();

    // Save initial stats
    $initialStats = [
        'hp' => $character['hp'],
        'ap' => $character['ap'],
        'dp' => $character['dp']
    ];

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
            exit;
        } else {
            echo "{$character['name']} defeats the {$monster['name']}!";

            // Add a bonus to all stats
            $bonus = 10;
            $character['hp'] += $bonus;
            $character['ap'] += $bonus;
            $character['dp'] += $bonus;

            // Update the character's attributes in the database
            $stmt = $this->connexion->prepare("UPDATE characters SET hp = ?, ap = ?, dp = ? WHERE id = ?");
            $stmt->execute([$character['hp'], $character['ap'], $character['dp'], $this->character->id]);

            // Display bonus message
            echo "{$character['name']} gains a bonus of $bonus to HP, AP, and DP!";
        }
    } else {
        echo "{$character['name']} finds no monsters to fight.";
    }

    // Restore initial stats for the next combat
    $character['hp'] = $initialStats['hp'];
    $character['ap'] = $initialStats['ap'];
    $character['dp'] = $initialStats['dp'];

    // Update the character's attributes in the database
    $stmt = $this->connexion->prepare("UPDATE characters SET hp = ?, ap = ?, dp = ? WHERE id = ?");
    $stmt->execute([$character['hp'], $character['ap'], $character['dp'], $this->character->id]);

    // Check if the character's HP is 0 or less
    if ($character['hp'] <= 0) {
        echo "{$character['name']} has died.";
        exit;
    }
}
function merchant() {
    // Fetch character data
    $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$this->character->id]);
    $character = $stmt->fetch();

    // Check if the current room has a merchant
    $stmt = $this->connexion->prepare("SELECT * FROM rooms WHERE id = ?");
    $stmt->execute([$character['current_room']]);
    $room = $stmt->fetch();

    if ($room && $room['merchant']) {
        echo "You encounter a merchant in this room!\n";
        echo "Merchant: Welcome, adventurer! Would you like to trade?\n";

        // Fetch available items from the merchant
        $stmt = $this->connexion->prepare("SELECT mi.id, mi.merchant, mi.loot_id, l.magical_items, l.cursed_items, l.cursed 
                                          FROM merchantinventory mi 
                                          JOIN loots l ON mi.loot_id = l.id 
                                          WHERE mi.merchant = ?");
        $stmt->execute([$room['merchant']]);
        $merchantItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display available items
        echo "Available items for trade:\n";
        foreach ($merchantItems as $item) {
            echo "{$item['id']}: {$item['magical_items']} - {$item['cursed_items']} (Cursed: {$item['cursed']})\n";
        }

        // Player selects an item to trade
        $selectedItemId = readline("Enter the ID of the item you want to trade (or enter 0 to exit): ");
        
        if ($selectedItemId == 0) {
            echo "Merchant: Farewell, adventurer!\n";
            return;
        }

        // Fetch the selected item from the merchant's inventory
        $stmt = $this->connexion->prepare("SELECT * FROM merchantinventory WHERE id = ?");
        $stmt->execute([$selectedItemId]);
        $selectedItem = $stmt->fetch();

        if ($selectedItem) {
            echo "Merchant: You want to trade {$selectedItem['magical_items']} - {$selectedItem['cursed_items']} (Cursed: {$selectedItem['cursed']}).\n";

            // Player selects an item from their inventory to trade
            echo "Your current inventory:\n";
            // Display the player's inventory (you need to implement this based on your game's inventory system)
            // For example, fetch and display items from a table like "inventory" that links character ID to item ID

            // Player selects an item from their inventory to trade
            $selectedInventoryItemId = readline("Enter the ID of the item from your inventory to trade (or enter 0 to cancel): ");

            if ($selectedInventoryItemId == 0) {
                echo "Merchant: Perhaps another time, adventurer!\n";
                return;
            }

            // Fetch the selected item from the player's inventory
            $stmt = $this->connexion->prepare("SELECT * FROM inventory WHERE id = ?");
            $stmt->execute([$selectedInventoryItemId]);
            $selectedInventoryItem = $stmt->fetch();

            if ($selectedInventoryItem) {
                // Implement the logic for item exchange based on your game's design
                // You may need to update the inventory, character stats, and any other relevant information
                // For example, you can update the character's inventory, remove the traded item from the player's inventory, and add the traded item to the merchant's inventory

                echo "Merchant: Thank you for the trade, adventurer!\n";
            } else {
                echo "Merchant: I'm sorry, but that item is not available for trade.\n";
            }
        } else {
            echo "Merchant: I'm sorry, but that item is not available for trade.\n";
        }
    } else {
        echo "There is no merchant in this room.\n";
    }
}

    
function loot() {
    $characterId = $this->character->id; // Récupère l'ID du personnage

    // Fetch character data
    $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$characterId]);
    $character = $stmt->fetch();
    if (!$character) {
        echo "No character found.\n";
        return;
    }

    // Logique pour générer un objet aléatoire après la victoire
    $stmt = $this->connexion->prepare("SELECT * FROM loots ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $randomItem = $stmt->fetch();

    if ($character['hp'] > 0) {
        if ($randomItem) {
            $magicalItem = $randomItem['magical_items'];
            $cursedItem = $randomItem['cursed_items'];
    
            if ($magicalItem) {
                echo "You found a new magical item: $magicalItem\n";
            } elseif ($cursedItem) {
                echo "You found a new cursed item: $cursedItem\n";
                echo "Warning! This item is cursed!\n";
            } else {
                echo "You found an empty chest. No items found.\n";
            }
    
            // Vérification si le personnage possède déjà cet objet dans son inventaire
            if ($magicalItem || $cursedItem) {
                $itemAlreadyInInventory = false;
    
                if (($magicalItem && strpos($character['inventaire'], $magicalItem) !== false) || ($cursedItem && strpos($character['inventaire'], $cursedItem) !== false)) {
                    $itemAlreadyInInventory = true;
                    echo "You already have this item in your inventory.\n";
                }
    
                if (!$itemAlreadyInInventory) {
                    $choice = readline("Do you want to add this item to your inventory? (yes/no): ");
                    if (strtolower($choice) === 'yes') {
                        $itemName = $magicalItem ?: $cursedItem;
                        $character['inventaire'] .= ", $itemName";
                        $stmt = $this->connexion->prepare("UPDATE characters SET inventaire = ? WHERE id = ?");
                        $stmt->execute([$character['inventaire'], $characterId]);
                        echo "You added the item: $itemName to your inventory.\n";
                    } else {
                        echo "You left the item.\n";
                    }
                }
            }
        } else {
            echo "No item found.\n";
        }
    }
    
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
$systeme->merchant();

// $systeme->combat();
$systeme->loot();
// $systeme->save_progress();

// $connexion = null; // Close the database connection
?>