<?php
include 'config.php';
include 'character.php';
include 'room.php';
include 'combat.php';
include 'loot.php';
include 'database.php';
class games {
    protected $id;
    protected $character_id ;
    protected $room_id ;
    protected $combat_id ;
    protected $loot_id ;


    function __construct($id, $character_id, $combat_id, $loot_id)
    {
        $this->id = $id;
        $this->character_id = $character_id;
        $this->combat_id = $combat_id;
        $this->loot_id = $loot_id;
    }
    public function getId()
    {
        return $this->id;}
    public function getCharacterId()
    {
        return $this->character_id;}

    public function getCombatId()
    {
        return $this->combat_id;}

        public function getLootId()
        {
            return $this->loot_id;}
            

    

        
}