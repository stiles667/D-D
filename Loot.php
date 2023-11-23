<?php
class Loot {
    private $magicalItems; // Array of magical items in the loot
    private $cursedItems; // Array of cursed items in the loot

    public function __construct($magicalItems, $cursedItems) {
        $this->magicalItems = $magicalItems;
        $this->cursedItems = $cursedItems;
    }

    
    public function getMagicalItem() {
        // Check if there are any magical items in the loot
        if (count($this->magicalItems) > 0) {
            // Select a random magical item
            $itemIndex = array_rand($this->magicalItems);
            $item = $this->magicalItems[$itemIndex];
    
            // Remove the item from the loot
            unset($this->magicalItems[$itemIndex]);
    
            return $item;
        } else {
            echo "There are no magical items in the loot.";
            return null;
        }
    }
    
    public function getCursedItem() {
        // Check if there are any cursed items in the loot
        if (count($this->cursedItems) > 0) {
            // Select a random cursed item
            $itemIndex = array_rand($this->cursedItems);
            $item = $this->cursedItems[$itemIndex];
    
            // Remove the item from the loot
            unset($this->cursedItems[$itemIndex]);
    
            return $item;
        } else {
            echo "There are no cursed items in the loot.";
            return null;
        }
    }
}