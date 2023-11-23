<?php
class Combat {
    private $character; // The character involved in the combat
    private $monster; // The monster involved in the combat

    public function __construct($character, $monster) {
        $this->character = $character;
        $this->monster = $monster;
    }

    public function fight() {
        while ($this->character->getHp() > 0 && $this->monster->getHp() > 0) {
            // Display the character's options
            echo "1. Attack\n2. Defend\n3. Dodge\n4. Save and Quit\n";
            $choice = readline("Choose an action: ");
    
            switch ($choice) {
                case 1: // Attack
                    $this->monster->setHp($this->monster->getHp() - $this->character->getAp());
                    break;
                case 2: // Defend
                    $this->character->setHp($this->character->getHp() - $this->monster->getAp() / 2);
                    break;
                case 3: // Dodge
                    if (rand(1, 3) != 1) { // Dodge successful
                        echo "You dodged the monster's attack!\n";
                        continue 2; // Skip the monster's turn
                    } else { // Dodge unsuccessful
                        echo "You failed to dodge the monster's attack.\n";
                    }
                    break;
                case 4: // Save and Quit
                    // Code to save the game
                    exit;
            }
    
            // Monster's turn to attack
            $this->character->setHp($this->character->getHp() - $this->monster->getAp());
        }
    }
    
    public function determineWinner(Loot $chest) {
        if ($this->character->getHp() <= 0) {
            echo "The monster has won the fight.\n";
            return $this->monster;
        } else {
            echo "You have won the fight!\n";
            $this->openChest($chest);
            return $this->character;
        }
    }
    public function openChest(Loot $chest) {
        // Get a random item from the chest
        $item = $chest->getMagicalItem();
    
        if ($item) {
            echo "You found a " . $item . " in the chest!\n";
    
            // Check if the item is cursed
            if (in_array($item, $chest->getCursedItems())) {
                echo "Beware, the " . $item . " is cursed!\n";
            }
        } else {
            echo "The chest is empty.\n";
        }
    }
}