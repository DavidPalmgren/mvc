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
}
