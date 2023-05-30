<?php
namespace App\Adventure;
use PHPUnit\Framework\TestCase;

class CommandsTest extends TestCase
{
    //kollar att spelaren verkligen förflyttar sig
    public function testProcessCommandMove()
    {
        $gameMap = new GameMap('center');
        $gameMap = $gameMap->initializeGameMap();
        $player = new Player($gameMap->getRoom($gameMap->getStartingRoomId()));
        $commands = new Commands();

        $commands->processCommand("move north", $player);

        $this->assertEquals('north', $player->getCurrentRoom()->getId());
    }
    
    //check that shiz works
    public function testProcessCommandPickupNoItems()
    {
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        $gameMap = new GameMap('center');
        $commands = new Commands();

        $result = $commands->processCommand('pickup', $player);

        $this->assertEquals('There are no items to pick up in this room.', $result);
        $this->assertCount(0, $player->getInventory());
    }

    public function testProcessCommandPickupItems()
    {
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        $gameMap = new GameMap('center');
        $room = $player->getCurrentRoom();
        $item1 = new Item('item1', 'Item 1', 'Description of item 1');
        $item2 = new Item('item2', 'Item 2', 'Description of item 2');
        $room->addItem($item1);
        $room->addItem($item2);
        $commands = new Commands();

        $result = $commands->processCommand('pickup', $player);

        $this->assertEquals("You've picked up item 1\nYou've picked up item 2\n", $result);
        $this->assertCount(2, $player->getInventory());
    }

    public function testProcessCommandPickupWithDogBlocking()
    {
        // dog blocking item
        $gameMap = new GameMap('west');
        $player = new Player(new Room('west', 'You are in the bedroom(west) room.'));
        $room = new Room('west', 'You are in the bedroom(west) room.');
        $item = new Item('bone', 'Bone', 'A delicious bone for the dog');
        $room->addItem($item);

        $commands = new Commands();
        $result = $commands->processCommand("pickup", $player);

        $this->assertEquals("The dog is laying on top of something but barks as you try to approach.", $result);
    }

    public function testProcessCommandPasswordWithCorrectPassword()
    {
        $gameMap = new GameMap('south');
        $player = new Player(new Room('south', 'You are in the computer(south) room.'));
        $commands = new Commands();
        $result = $commands->processCommand("password trocadero", $player);

        $this->assertEquals("You logged in succesfully and hear a small noise behind you the vault which was closed has been opened and reveals a golden key, you should [pickup].", $result);
        $this->assertNotEmpty($player->getCurrentRoom()->getItems());
    }

    public function testProcessCommandPasswordWithWrongPassword()
    {
        $gameMap = new GameMap('south');
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        $commands = new Commands();
        $result = $commands->processCommand("password wrongpassword", $player);

        $this->assertEquals("No computer to put that password into", $result);
    }

    public function testProcessCommandUseWithInvalidItem()
    {
        $gameMap = new GameMap('south');
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        $commands = new Commands();
        $result = $commands->processCommand("use key", $player);
        $this->assertEquals("You have no such item.", $result);
    }

    public function testProcessCommandUseWithValidItem()
    {
        $gameMap = new GameMap('north');
        $player = new Player(new Room('north', 'You are in the exit(north) room.', "/adventuregame/scenes/door.png"));
        $item = new Item('golden_key', 'golden key', 'All shiny and what not');
        $player->pickupItems([$item]);
        $commands = new Commands();
        $result = $commands->processCommand("use key", $player);

        $this->assertEquals("You shove the golden key into the lock and open the door you're finally free from the house. Congratulations player you've escaped succesfully!", $result);
    }
    
}