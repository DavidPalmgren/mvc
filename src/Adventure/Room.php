<?php

namespace App\Adventure;

class Room
{
    private string $id;
    private string $description;
    private array $neighbors;
    private string $image;
    private array $items;

    public function __construct(string $id, string $description, string $image = "", Item $items = null)
    {
        $this->id = $id;
        $this->description = $description;
        $this->neighbors = [
            'north' => null,
            'south' => null,
            'east' => null,
            'west' => null,
        ];
        $this->image = $image;
        $this->items = [];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setNeighbor(string $direction, Room $room): void
    {
        $this->neighbors[$direction] = $room;
    }

    public function getNeighbor(string $direction): ?Room
    {
        return $this->neighbors[$direction];
    }

    public function getNeighbors(): array
    {
        return $this->neighbors;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage(string $sentImage) {
        $this->image = $sentImage;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function removeItems()
    {
        $this->items = [];
    }
}