<?php
include 'config.php';

class Database {
    private $connexion;

    public function __construct() {
        $this-> $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);
    }

    public function saveCharacter($character) {
        // Code to save the character to the database
    }

    public function loadCharacter($characterId) {
        $stmt = $this->connexion->prepare("SELECT * FROM characters WHERE id = :id");
        $stmt->execute(['id' => $characterId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveRoom($room) {
        // Code to save the room to the database
    }

    public function loadRoom($roomId) {
        $stmt = $this->connexion->prepare("SELECT * FROM rooms WHERE id = :id");
        $stmt->execute(['id' => $roomId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveCombat($combat) {
        // Code to save the combat to the database
    }

    public function loadCombat($combatId) {
        $stmt = $this->connexion->prepare("SELECT * FROM combats WHERE id = :id");
        $stmt->execute(['id' => $combatId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveLoot($loot) {
        // Code to save the loot to the database
    }

    public function loadLoot($lootId) {
        $stmt = $this->connexion->prepare("SELECT * FROM loots WHERE id = :id");
        $stmt->execute(['id' => $lootId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function loadMonster($monsterId) {
        $stmt = $this->connexion->prepare("SELECT * FROM monsters WHERE id = :id");
        $stmt->execute(['id' => $monsterId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}