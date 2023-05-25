<?php

namespace App\Adventure;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testGetCurrentRoom()
    {
        $room = new Room('room1', 'You are in a dark cave.');
        $player = new Player($room);
        $currentRoom = $player->getCurrentRoom();

        $this->assertSame($room, $currentRoom);
    }

    public function testMoveToNeighborRoom()
    {
        $room1 = new Room('room1', 'You are in a dark cave.');
        $room2 = new Room('room2', 'You find yourself in a lush forest.');
        $player = new Player($room1);

        $room1->setNeighbor('north', $room2);
        $result = $player->move('north');
        $currentRoom = $player->getCurrentRoom();

        $this->assertTrue($result);
        $this->assertSame($room2, $currentRoom);
    }

    public function testMoveToNonExistentNeighborRoom()
    {
        $room1 = new Room('room1', 'You are in a dark cave.');
        $player = new Player($room1);

        $result = $player->move('north');
        $currentRoom = $player->getCurrentRoom();

        $this->assertFalse($result);
        $this->assertSame($room1, $currentRoom);
    }
}