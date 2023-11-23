<?php
include 'config.php';
include 'charactere.php';
include 'room.php';
include 'combat.php';
include 'loot.php';
include 'database.php';
class Game {
    protected $id;
    protected $character;
    protected $connexion;
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
    public function play() {
        // Start the game
        $this->startGame();

        // While the game is not over
        while (!$this->isGameOver()) {
            // Explore the current room
            $this->room->exploreRoom();

            // If there is a monster in the room, start a combat
            if ($this->room->hasMonster()) {
                $this->combat->fight();

                // If the character won the combat, loot the monster
                if ($this->combat->determineWinner($this->loot) == $this->character) {
                    $this->character->gainExperience(100); // Gain 100 experience points
                    $this->character->equipWeapon($this->loot->getMagicalItem());
                }
            }

            // Move to the next room
            $this->room = $this->room->getNextRoom();
        }

        // End the game
        $this->endGame();
    }
}

// Create a new Database instance
$db = new Database();
$game = new Game($gameId, $character, $db, $combat, $loot); // Replace $gameId with the actual game ID
$game->play();