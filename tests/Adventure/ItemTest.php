<?php
namespace App\Adventure;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testUseGoldenKeyInNorthRoom()
    {
        $item = new Item('golden_key', 'Golden key', 'It shines brilliant, most likely for the chains surrounding the exit door');
        $player = new Player(new Room('north', 'You are in the exit(north) room.'));
        
        $response = $item->useItem($player);
        
        $this->assertEquals("You shove the golden key into the lock and open the door you're finally free from the house. Congratulations player you've escaped succesfully!", $response);
    }

    public function testUseGoldenKeyInNonNorthRoom()
    {
        $item = new Item('golden_key', 'Golden key', 'It shines brilliant, most likely for the chains surrounding the exit door');
        $player = new Player(new Room('south', 'You are in the PCRoom(south) room.'));
        
        $response = $item->useItem($player);
        
        $this->assertEquals('You swing the key aimlessly in the air, the door to heaven does not unlock. You might have better luck using it in the north room.', $response);
    }

    public function testUsePieceOfHamInWestRoom()
    {
        $item = new Item('piece_of_ham', 'Piece of ham', 'Smells great.');
        $player = new Player(new Room('west', 'You are in the bedroom(west) room.'));
        
        $response = $item->useItem($player);
        
        $this->assertEquals('You give the piece of ham to the dog. He seems pleased and moves off the bed, revealing a crumpled up note with drool over it. You promptly pick it up.', $response);
        $inventory = $player->getInventory();
        $this->assertCount(1, $inventory);
        $this->assertEquals('second half of the note', $inventory[0]->getName());
    }

    public function testUseFirstHalfOfNote()
    {
        $item = new Item('first_half_note', 'First half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece');
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        
        $response = $item->useItem($player);
        
        $this->assertEquals('The note has 4 letters written boldly across it: t, r, o, c. But the right side of the note is missing.', $response);
    }

    public function testUseSecondHalfOfNote()
    {
        $item = new Item('second_half_note', 'Second half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece');
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        
        $response = $item->useItem($player);
        
        $this->assertEquals('The note has 5 letters written boldly across it: a, d, e, r, o. But the left side of the note is missing.', $response);
    }
    //tests lastline for default
    public function testUseInvalidItem()
    {
        $item = new Item('invalid_item', 'Invalid item', 'An item with no special effect');
        $player = new Player(new Room('center', 'You are in the hallway(center) room.'));
        
        $response = $item->useItem($player);
        
        $this->assertEquals('You used invalid item, nothing happens.', $response);
    }
}