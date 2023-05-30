<?php

namespace App\Adventure;

class Item
{
    private string $itemId;
    private string $name;
    private string $description;

    public function __construct(string $itemId, string $name, string $description)
    {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->itemId;
    }

    public function getName(): string
    {
        return strtolower($this->name);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    //i sure like making huge blobs but im not convinced it's bad
    //It's fairly straight forward and is just a bunch of if statements
    //sure like i could break it up but this frankly seems simpler
    public function useItem(Player $player): bool|string
    {
        if ($this->getName() === 'golden key') {
            if ($player->getCurrentRoom()->getId() === 'north') {
                $player->getCurrentRoom()->setImage("/adventuregame/scenes/victory.png");
                return "You shove the golden key into the lock and open the door you're finally free from the house. Congratulations player you've escaped succesfully!";
            }
            return 'You swing the key aimlessly in the air, the door to heaven does not unlock. You might have better luck using it in the north room.';
        }
        if ($this->getName() === 'piece of ham') {
            if ($player->getCurrentRoom()->getId() === 'west') {
                $item = new Item('second_half_note', 'Second half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece');
                $player->pickupItems([$item]);
                $player->removeItem($this);
                return 'You give the piece of ham to the dog. He seems pleased and moves off the bed, revealing a crumpled up note with drool over it. You promptly pick it up.';
            }
        }
        if ($this->getName() === 'first half of the note') {
            return 'The note has 4 letters written boldly across it: t, r, o, c. But the right side of the note is missing.';
        }
        if ($this->getName() === 'second half of the note') {
            return 'The note has 5 letters written boldly across it: a, d, e, r, o. But the left side of the note is missing.';
        }
        if ($this->getName() === "Wirt's Leg") {
            return "This seemingly useless item spawns a spirit which tells you to go the eastern most room and look for a note.";
        }
        return 'You used ' . $this->getName() . ', nothing happens.';

    }

}
