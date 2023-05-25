<?php

namespace App\Adventure;

class Player
{
    private Room $currentRoom;

    public function __construct(Room $startingRoom)
    {
        $this->currentRoom = $startingRoom;
    }

    public function getCurrentRoom(): Room
    {
        return $this->currentRoom;
    }

    public function move(string $direction): bool
    {
        $neighborRoom = $this->currentRoom->getNeighbor($direction);
        if ($neighborRoom) {
            $this->currentRoom = $neighborRoom;
            return true;
        }
        return false;
    }
}