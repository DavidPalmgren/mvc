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
    

        $centerRoom = new Room('center', 'You are in the hallway(center) room.', "/adventuregame/scenes/hallway.png");
        $northRoom = new Room('north', 'You are in the exit(north) room.', "/adventuregame/scenes/door.png");
        $southRoom = new Room('south', 'You are in the PCRoom(south) room.', "/adventuregame/scenes/pcroom.png");
        $eastRoom = new Room('east', 'You are in the kitchen(east) room.', "/adventuregame/scenes/kitchen.png");
        $westRoom = new Room('west', 'You are in the bedroom(west) room.', "/adventuregame/scenes/bedroomdog.png");
        $additionalRoom = new Room('additional', 'You are in the livingroom(east-additional) room.', "/adventuregame/scenes/livingroom.png");
    
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
    
        $additionalRoom->addItem(new Item('first_half_note', 'First half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece'));
        $westRoom->addItem(new Item('second_half_note', 'Second half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece'));
        $centerRoom->addItem(new Item('golden_key', 'Golden key', 'It shines brilliant, most likely for the chains surrounding the exit door'));
        $eastRoom->addItem(new Item('piece_of_ham', 'Piece of ham', 'Smells great.'));

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
