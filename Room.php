<?php
class Room {
    private $id;
    private $isSpecial;
    private $puzzle;
    private $trap;
    private $merchant;

    public function __construct($id, $isSpecial, $puzzle, $trap, $merchant) {
        $this->id = $id;
        $this->isSpecial = $isSpecial;
        $this->puzzle = $puzzle;
        $this->trap = $trap;
        $this->merchant = $merchant;
    }

    public function isSpecial() {
        return $this->isSpecial;
    }
    public function getPuzzle() {
        return $this->puzzle;
    }
    public function getTrap() {
        return $this->trap;
    }
    public function getMerchant() {
        return $this->merchant;
    }
    public function exitRoom() {
        // Code to exit the room
    }

    public function exploreRoom() {
        if ($this->isSpecial) {
            echo "You've entered a special room!\n";
        }

        if ($this->puzzle) {
            echo "There's a puzzle here: " . $this->puzzle . "\n";
        }

        if ($this->trap) {
            echo "Watch out! There's a trap: " . $this->trap . "\n";
        }

        if ($this->merchant) {
            echo "You've found a merchant: " . $this->merchant . "\n";
        }

        if (!$this->isSpecial && !$this->puzzle && !$this->trap && !$this->merchant) {
            echo "You've entered a room with a monster!\n";
        }
    }
    public function SpecialRoom() {
        //the puzzle
        if ($this->isSpecial) {
            echo "You've entered a special room!\n";

            if ($this->puzzle) {
                echo "There's a puzzle here: " . $this->puzzle . "\n";
            }
            if ($this->trap) {
                echo "". $this->trap .
                "\n";

            }}
            if ($this->merchant) {
                echo "". $this->merchant .
                "\n";
            }
            if (!$this->isSpecial && !$this->puzzle && !$this->trap) {
                echo "You've entered a room with a monster!\n";
                
            }
            }

   
}