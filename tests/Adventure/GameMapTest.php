<?php
namespace App\Adventure;
use PHPUnit\Framework\TestCase;

class GameMapTest extends TestCase
{
    public function testAddRoomAndGetRoom()
    {
        $room1 = new Room('room1', 'You are in a dark cave.');
        $gameMap = new GameMap('room1');

        $gameMap->addRoom($room1);
        $retrievedRoom = $gameMap->getRoom('room1');

        $this->assertSame($room1, $retrievedRoom);
    }
    public function testGetStartingRoomId()
    {
        $gameMap = new GameMap("roomUno");

        $this->assertEquals("roomUno", $gameMap->getStartingRoomId());
    }
    //tests that game sets up properly even though im 100% shit owrks gotta get that purple parse
    public function testInitializeGameMap()
    {
        $gameMap = new GameMap("roomUno");
        $gameMap = $gameMap->initializeGameMap();

        // Test the rooms
        $rooms = $gameMap->getRooms();

        $this->assertCount(6, $rooms);

        $centerRoom = $rooms['center'];
        $this->assertInstanceOf(Room::class, $centerRoom);
        $this->assertEquals('center', $centerRoom->getId());
        $this->assertEquals("You are in the hallway(center) room. There is a path to the, North, South, East, West. Type move <direction> to get going. You find yourself in a hallway there is not much of note in here besides a [wooden leg] lying on the floor, it doesn't seem very usefull.", $centerRoom->getDescription());
        $this->assertEquals('/adventuregame/scenes/hallway.png', $centerRoom->getImage());

        // Test the neighbors of the center room
        $this->assertCount(4, $centerRoom->getNeighbors());

        $northRoom = $centerRoom->getNeighbor('north');
        $this->assertInstanceOf(Room::class, $northRoom);
        $this->assertEquals('north', $northRoom->getId());

        $southRoom = $centerRoom->getNeighbor('south');
        $this->assertInstanceOf(Room::class, $southRoom);
        $this->assertEquals('south', $southRoom->getId());

        $eastRoom = $centerRoom->getNeighbor('east');
        $this->assertInstanceOf(Room::class, $eastRoom);
        $this->assertEquals('east', $eastRoom->getId());

        $westRoom = $centerRoom->getNeighbor('west');
        $this->assertInstanceOf(Room::class, $westRoom);
        $this->assertEquals('west', $westRoom->getId());

        // Test the items in the rooms
        $centerRoomItems = $centerRoom->getItems();
        $this->assertCount(1, $centerRoomItems);

        $goldenKeyItem = $centerRoomItems[0];
        $this->assertInstanceOf(Item::class, $goldenKeyItem);
        $this->assertEquals('Wirts_leg', $goldenKeyItem->getId());
        $this->assertEquals("wirt's leg", $goldenKeyItem->getName());
        $this->assertEquals('peg-leg of Wirt, who was revealed to have been killed in the siege of Tristram.', $goldenKeyItem->getDescription());
    }
}