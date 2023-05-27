<?php
namespace App\Adventure;
use PHPUnit\Framework\TestCase;


class RoomTest extends TestCase
{
    public function testGetDescription()
    {
        $room = new Room('room1', 'You are in a dark cave.');
        $description = $room->getDescription();

        $this->assertEquals('You are in a dark cave.', $description);
    }

    public function testSetNeighborAndGetNeighbor()
    {
        $room1 = new Room('room1', 'You are in a dark cave.');
        $room2 = new Room('room2', 'You find yourself in a lush forest.');

        $room1->setNeighbor('north', $room2);
        $neighbor = $room1->getNeighbor('north');

        $this->assertSame($room2, $neighbor);
    }

    public function testRemoveItems()
    {
        $room = new Room('center', 'You are in the hallway(center) room.');
        $item1 = new Item('item1', 'Item 1', 'Description of item 1');
        $item2 = new Item('item2', 'Item 2', 'Description of item 2');

        $room->addItem($item1);
        $room->addItem($item2);

        $room->removeItems();

        $items = $room->getItems();

        $this->assertCount(0, $items);
    }
}
