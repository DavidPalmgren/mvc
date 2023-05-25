<?php
namespace App\Adventure;
use PHPUnit\Framework\TestCase;

class GameMapTest extends TestCase
{
    public function testAddRoomAndGetRoom()
    {
        $room1 = new Room('room1', 'You are in a dark cave.');
        $gameMap = new GameMap();

        $gameMap->addRoom($room1);
        $retrievedRoom = $gameMap->getRoom('room1');

        $this->assertSame($room1, $retrievedRoom);
    }
}