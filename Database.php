<?php
class Database {
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function saveCharacter($character) {
        // Code to save the character to the database
    }

    public function loadCharacter($characterId) {
        // Code to load the character from the database
    }

    // Similar methods for Room, Combat, and Loot
}