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

    public function move(string $direction): void
    {
        $neighbor = $this->currentRoom->getNeighbor($direction);
        if ($neighbor) {
            $this->currentRoom = $neighbor;
        }
    }

    public function pickupItems(array $items): void
    {
        foreach ($items as $item) {
            $this->inventory[] = $item;
        }
    }

    public function addItem(Item $item)
    {
        $this->inventory[] = $item;
    }

    public function getInventory(): array
    {
        return $this->inventory;
    }

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