<?php

namespace App\Adventure;

class Room
{
    private string $id;
    private string $description;
    private array $neighbors;

    public function __construct(string $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
        $this->neighbors = [
            'north' => null,
            'south' => null,
            'east' => null,
            'west' => null,
        ];
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
}