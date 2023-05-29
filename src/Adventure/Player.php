<?php

namespace App\Adventure;

use App\Adventure\Item;

class Player
{
    private Room $currentRoom;
    private array $inventory;

    public function __construct(Room $startingRoom)
    {
        //dont manually set this it messes with tests!
        $this->currentRoom = $startingRoom;
        $this->inventory = [];
    }

    public function getCurrentRoom(): Room
    {
        return $this->currentRoom;
    }
    /**
     * Checks if the current room has a neighbor in the direction of your movement
     * say you move north it checks that it has a connection to said room then moves you
     * by setting your current room to requested room if all checks pan out
     * 
     * @param string $direction you want to move in
     */
    public function move(string $direction): void
    {
        $neighbor = $this->currentRoom->getNeighbor($direction);
        if ($neighbor) {
            $this->currentRoom = $neighbor;
        }
    }
    /**
     * @param array $items picks up all items
     */
    public function pickupItems(array $items): void
    {
        foreach ($items as $item) {
            $this->inventory[] = $item;
        }
    }
    /**
     * I decided that the item should just get picked up if ur in the room for simplicity
     * i didnt particularly feel like the player had to spell said item out so im really
     * only using this for some later tests since it made stuff simpler for me
     * 
     * @param Item $item picks up said item
     */
    public function addItem(Item $item)
    {
        $this->inventory[] = $item;
    }

    public function getInventory(): array
    {
        return $this->inventory;
    }
    //str lowering everything to make the user input simpler
    //kind of a pain in the dick but makes user experience better hopefully
    public function findItemByName(string $itemName): ?Item
    {
        $lowercaseItemName = strtolower($itemName);

        foreach ($this->inventory as $item) {
            $lowercaseItem = strtolower($item->getName());

            if (strpos($lowercaseItem, $lowercaseItemName) !== false) {
                return $item;
            }
        }
        return null;
    }
}
