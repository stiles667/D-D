<?php
class Room {
    private $special; // Boolean to indicate if the room is special
    private $puzzle; // Puzzle in the room, if any
    private $trap; // Trap in the room, if any
    private $merchant; // Merchant in the room, if any

    public function __construct($special, $puzzle, $trap, $merchant) {
        $this->special = $special;
        $this->puzzle = $puzzle;
        $this->trap = $trap;
        $this->merchant = $merchant;
    }

    public function exitRoom() {
        // Code to exit the room
    }

    public function exploreRoom() {
        // Code to explore the room
    }
}
