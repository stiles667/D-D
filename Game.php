<?php
include 'config.php';
include 'character.php';
include 'room.php';
include 'combat.php';
include 'loot.php';
class Game {
    protected $id;
    protected $character;
    
    protected $combat;
    protected $loot;

    function __construct($id, $character,$connexion, $combat, $loot)
    {
        $this->id = $id;
        $this->character = $character;
        $this->connexion = $connexion;
        $this->combat = $combat;
        $this->loot = $loot;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCharacter()
    {
        return $this->character;
    }

   

    public function getCombat()
    {
        return $this->combat;
    }

    public function getLoot()
    {
        return $this->loot;
    }

    public function startGame() {
        $statement = $this->connexion->prepare("SELECT * FROM rooms ORDER BY id");
        $statement->execute();
        $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rooms as $roomData) {
            $this->room = new Room($roomData);
            while ($this->character->getHp() > 0) {
                $this->room->exploreRoom();
                $monster = $this->room->getMonster(); // Assuming getMonster() returns a Monster object
                $this->combat = new Combat($this->character, $monster);
                $this->combat->fight();
                $winner = $this->combat->determineWinner($this->loot);
                if ($winner === $this->character) {
                    $this->character->gainExperience(100); // Assuming the character gains 100 XP for winning
                } else {
                    break; // End the game if the character loses
                }
            }
        }
    }
}
// Create a new Database instance
$db = new Database($config);

// Get the character, room, combat, and loot information from the database
$characterData = $db->getCharacterData($characterId); // Replace $characterId with the actual character ID
$roomData = $db->getRoomData($roomId); // Replace $roomId with the actual room ID
$combatData = $db->getCombatData($combatId); // Replace $combatId with the actual combat ID
$lootData = $db->getLootData($lootId); // Replace $lootId with the actual loot ID

// Create new instances of Character, Room, Combat, and Loot
$character = new Character($characterData);
$room = new Room($roomData);
$combat = new Combat($combatData);
$loot = new Loot($lootData);

// Create a new Game instance
$game = new Game($gameId, $character, $room, $combat, $loot); // Replace $gameId with the actual game ID

// Start the game
$game->startGame();