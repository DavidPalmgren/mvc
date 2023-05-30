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
        $gameMap = new GameMap('center');
        $room1 = new Room('room1', 'You are in a dark cave.');
        $room2 = new Room('room2', 'You find yourself in a lush forest.');
        $player = new Player($room1);
        $gameMap->addRoom($room1);
        $gameMap->addRoom($room2);

        $room1->setNeighbor('north', $room2);
        $player->move('north');
        $currentRoom = $player->getCurrentRoom();

        $this->assertSame($room2, $currentRoom);
    }

    public function testMoveToNonExistentNeighborRoom()
    {
        $room1 = new Room('room1', 'You are in a dark cave.');
        $player = new Player($room1);

        $player->move('north');
        $currentRoom = $player->getCurrentRoom();

        $this->assertSame($room1, $currentRoom);
    }
    public function testFindItemByNameReturnsItemWhenExactMatchFound()
    {
        $room = new Room('Test Room', 'A room for testing');
        $player = new Player($room);

        $item = new Item('key', 'Golden Key', 'A shiny golden key');
        $player->pickupItems([$item]);

        $foundItem = $player->findItemByName('Golden Key');
        $this->assertSame($item, $foundItem);
    }

    public function testFindItemByNameReturnsItemWhenPartialMatchFound()
    {
        $room = new Room('Test Room', 'A room for testing');
        $player = new Player($room);

        $item = new Item('note', 'Secret Note', 'A secret message');
        $player->pickupItems([$item]);

        $foundItem = $player->findItemByName('Note');
        $this->assertSame($item, $foundItem);
    }

    public function testFindItemByNameReturnsNullWhenNoMatchFound()
    {
        $room = new Room('Test Room', 'A room for testing');
        $player = new Player($room);

        $item = new Item('key', 'Golden Key', 'A shiny golden key');
        $player->pickupItems([$item]);

        $foundItem = $player->findItemByName('Sword');
        $this->assertNull($foundItem);
    }
}