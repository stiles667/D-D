<?php
class Character {
    private $name;
    private $hp;
    private $ap;
    private $dp;
    private $experience;
    private $level;

    public function __construct($name, $hp, $ap, $dp, $experience, $level) {
        $this->name = $name;
        $this->hp = $hp;
        $this->ap = $ap;
        $this->dp = $dp;
        $this->experience = $experience;
        $this->level = $level;
    }
    
    public function getHp() {
        return $this->hp;
    }
    
    public function setHp($hp) {
        $this->hp = $hp;
    }

    public function equipWeapon($weapon) {
        // Check if character level is high enough to equip the weapon
        if ($this->level >= $weapon->getRequiredLevel()) {
            $this->equippedWeapon = $weapon;
            echo "Weapon equipped!";
        } else {
            echo "Your level is too low to equip this weapon.";
        }
    }
    public function gainExperience($experience) {
        $this->experience += $experience;
        echo "You gained " . $experience . " experience points.";
    
        // Check if the character has enough experience to level up
        if ($this->experience >= $this->level * 100) {
            $this->levelUp();
        }
    }
    
    public function levelUp() {
        // Increase character level and improve skills
        $this->level++;
        $this->hp += 10; // Increase HP by 10
        $this->ap += 5;  // Increase AP by 5
        $this->dp += 5;  // Increase DP by 5
        echo "You leveled up! Your new level is " . $this->level;
    }
}
