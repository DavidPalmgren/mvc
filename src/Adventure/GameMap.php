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

    public function getRooms()
    {
        return $this->rooms;
    }

    //preset map for my project
    public function initializeGameMap(): GameMap
    {
        $gameMap = new GameMap('center');


        $centerRoom = new Room('center', "You are in the hallway(center) room. There is a path to the, North, South, East, West. Type move <direction> to get going. You find yourself in a hallway there is not much of note in here besides a [wooden leg] lying on the floor, it doesn't seem very usefull.", "/adventuregame/scenes/hallway.png");
        $northRoom = new Room('north', 'You are in the exit(north) room. There is a path to the, South. You find a door which you inspect, you try to open it but find it locked from the outside if you only have an exquisite golden key youre sure you could get it to open.', "/adventuregame/scenes/door.png");
        $southRoom = new Room('south', 'You are in the PCRoom(south) room. There is a path to the, North. The room has several computers around it although only one seems to be functional, you see a login window on the computer the username is already filled in however what could the password be? [password <password>], in the corner of your eye you find a small vault connected to the computer through a thick wire.', "/adventuregame/scenes/pcroom.png");
        $eastRoom = new Room('east', 'You are in the kitchen(east) room. There is a path to the, East, West. The kitchen is nice and tidy and as you look around the room you find that there is nothing particularly usefull in here besides a [piece of ham] which might cure your or somebody elses hunger.', "/adventuregame/scenes/kitchen.png");
        $westRoom = new Room('west', 'You are in the bedroom(west) room. There is a path to the, East. You find a big rottweiler laying on a bed seemingly guarding a piece of paper, you try to approach but the dog is not having any of it and you back away.', "/adventuregame/scenes/bedroomdog.png");
        $additionalRoom = new Room('additional', 'You are in the livingroom(east-additional) room. There is a path to the, West. You find what seems to be the living room theres a big sofa and what seems to be a half chewed up [note] lying on the ground.', "/adventuregame/scenes/livingroom.png");

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
        //moved to event
        //$westRoom->addItem(new Item('second_half_note', 'Second half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece'));
        $centerRoom->addItem(new Item("Wirts_leg", "Wirt's Leg", "peg-leg of Wirt, who was revealed to have been killed in the siege of Tristram."));
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
