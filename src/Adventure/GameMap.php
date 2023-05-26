<?php

namespace App\Adventure;

class GameMap
{
    private array $rooms;
    private string $startingRoomId;

    public function __construct(string $startingRoomId)
    {
        $this->rooms = [];
        $this->startingRoomId = $startingRoomId;
    }

    public function addRoom(Room $room): void
    {
        $this->rooms[$room->getId()] = $room;
    }

    public function getRoom(string $roomId): ?Room
    {
        return $this->rooms[$roomId] ?? null;
    }

    //preset map for my project
    public function initializeGameMap(): GameMap
    {
        $gameMap = new GameMap('center');
    

        $centerRoom = new Room('center', 'You are in the hallway(center) room.');
        $northRoom = new Room('north', 'You are in the exit(north) room.');
        $southRoom = new Room('south', 'You are in the PCRoom(south) room.');
        $eastRoom = new Room('east', 'You are in the kitchen(east) room.');
        $westRoom = new Room('west', 'You are in the bedroom(west) room.');
        $additionalRoom = new Room('additional', 'You are in the livingroom(east-additional) room.');
    
        $centerRoom->setNeighbor('north', $northRoom);
        $centerRoom->setNeighbor('south', $southRoom);
        $centerRoom->setNeighbor('east', $eastRoom);
        $centerRoom->setNeighbor('west', $westRoom);
    
        $northRoom->setNeighbor('south', $centerRoom);
        $southRoom->setNeighbor('north', $centerRoom);
        $eastRoom->setNeighbor('west', $centerRoom);
        $westRoom->setNeighbor('east', $centerRoom);
        $eastRoom->setNeighbor('east', $additionalRoom);
        $additionalRoom->setNeighbor('west', $eastRoom);
    
        $gameMap->addRoom($centerRoom);
        $gameMap->addRoom($northRoom);
        $gameMap->addRoom($southRoom);
        $gameMap->addRoom($eastRoom);
        $gameMap->addRoom($westRoom);
        $gameMap->addRoom($additionalRoom);
    
        return $gameMap;
    }
    

    public function getStartingRoomId(): string
    {
        return $this->startingRoomId;
    }
}
