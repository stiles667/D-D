<?php
class character {
    protected $id;
    protected $name;
    protected $hp;
    protected $ap;
    protected $dp;
    protected $experience;  
    protected $level;
    protected $inventaire;


    function __construct($id, $name, $hp, $ap, $dp, $experience, $level, $inventaire) {
        $this->id = $id;
        $this->name = $name;
        $this->hp = $hp;
        $this->ap = $ap;
        $this->dp = $dp;
        $this->experience = $experience;
        $this->level = $level;
        $this->inventaire = $inventaire;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function gethp() {
        return $this->hp;
    }
    public function getAp() {
        return $this->ap;
    }
    public function getDp() {
        return $this->dp;
    }
    public function getExperience() {
        return $this->experience;
    }
    public function getLevel() {
        return $this->level;
    }
    public function getInventaire() {
        return $this->inventaire;
    }
    

}

?>
