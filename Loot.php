<?php
class Loot {
    private $magicalItems; // Array of magical items in the loot
    private $cursedItems; // Array of cursed items in the loot

    public function __construct($magicalItems, $cursedItems) {
        $this->magicalItems = $magicalItems;
        $this->cursedItems = $cursedItems;
    }

    public function getMagicalItem() {
        // Code to get a magical item from the loot
    }

    public function getCursedItem() {
        // Code to get a cursed item from the loot
    }
}