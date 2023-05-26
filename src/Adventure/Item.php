<?php

namespace App\Adventure;

class Item
{

    private string $id;
    private string $name;
    private string $description;

    public function __construct(string $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return strtolower($this->name);
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function useItem(Player $player): bool|string
    {
        if ($this->getName() === 'golden key') {
            if ($player->getCurrentRoom()->getId() === 'north') {
                return 'You won';
            }
            return 'You swing the key aimlessly in the air, the door to heaven does not unlock.';
        }
        if ($this->getName() === 'piece of ham') {
            if ($player->getCurrentRoom()->getId() === 'west') {
                $item = new Item('second_half_note', 'Second half of the note', 'A note seemingly ripped in half its hard to overlook the teethmarks and drool all over the piece');
                $player->pickupItems([$item]);
                return 'You give the piece of ham to the dog. He seems pleased and moves off the bed, revealing a crumpled up note with drool over it. You promptly pick it up.';
            }
        }
        if ($this->getName() === 'first half of the note') {
            return 'The note has 4 letters written boldly across it: t, r, o, c. But the right side of the note is missing.';
        }
        if ($this->getName() === 'second half of the note') {
            return 'The note has 5 letters written boldly across it: a, d, e, r, o. But the left side of the note is missing.';
        }
        return 'You used ' . $this->getName() . 'nothing happens.';
        
    }

}