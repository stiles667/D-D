<?php
class Character {
    public $name;
    public $hp;
    public $ap;
    public $dp;
    public $level;
    public $experience;
    public $weapon;

    function equipWeapon($weapon) {
        if ($this->level >= $weapon->minLevel) {
            $this->weapon = $weapon;
            $this->ap += $weapon->ap;
        }
    }

    function gainExperience($points) {
        $this->experience += $points;
        if ($this->experience >= $this->level * 100) {
            $this->levelUp();
        }
    }

    function levelUp() {
        $this->level++;
        $this->hp += 10;
        $this->ap += 5;
        $this->dp += 5;
    }
}

class Weapon {
    public $name;
    public $minLevel;
    public $ap;
}

class Room {
    public $id;
    public $special;
    public $puzzle;
    public $trap;
    public $merchant;

    function explore($character) {
        // Implement the logic of exploring the room
    }
}

class SpecialRoom extends Room {
    function solvePuzzle($character) {
        // Implement the logic of solving the puzzle
    }

    function disarmTrap($character) {
        // Implement the logic of disarming the trap
    }

    function tradeWithMerchant($character) {
        // Implement the logic of trading with the merchant
    }
}
?>