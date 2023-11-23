<?php
include 'config.php';

class Database {
    private $connection;

    public function __construct() {
        $this->connection = $GLOBALS['connexion'];
    }

    public function saveCharacter($character) {
        // Code to save the character to the database
    }

    public function loadCharacter($characterId) {
        // Code to load the character from the database
    }

    // Similar methods for Room, Combat, and Loot
}