<?php

namespace App\Adventure;

class Room
{
    private string $roomId;
    private string $description;
    private array $neighbors;
    private string $image;
    private array $items;

    public function __construct(string $roomId, string $description, string $image = "", Item $items = null)
    {
        $this->roomId = $roomId;
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
        return $this->roomId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    //set granne Room by direction like north to couple? them is
    // that a good word perhaps dunno
    public function setNeighbor(string $direction, Room $room): void
    {
        $this->neighbors[$direction] = $room;
    }
    //get granne/neighbor of direction
    public function getNeighbor(string $direction): ?Room
    {
        return $this->neighbors[$direction];
    }
    //simply returns all neighbors/granne
    public function getNeighbors(): array
    {
        return $this->neighbors;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $sentImage)
    {
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
