<?php

namespace App\Adventure;
use App\Adventure\Player;
use App\Adventure\GameMap;

class Commands
{
    public function processCommand(string $command, Player $player, GameMap $gameMap): string
    {
        $action = $this->parseCommand($command);

        switch ($action) {
            case 'move':
                $direction = $this->parseDirection($command);
                $player->move($direction);
                break;

            case 'pickup':
                return $this->processPickupCommand($player);
                break;

            case 'use':
                $itemName = $this->parseItemName($command);
                return $this->processUseCommand($player, $itemName);
                break;
            case 'password':
                if ($player->getCurrentRoom()->getId() === 'south') {
                    $attempt = $this->parseItemName($command);
                    return $this->passwordCheck($attempt, $player);
                    break;
                }else {
                    return "No computer to put that password into";
                    break;
                }


        }

        $currentRoom = $player->getCurrentRoom();
        return 'You have moved to ' . $currentRoom->getDescription();
    }

    private function parseCommand(string $command): string
    {
        $parts = explode(' ', $command);
        return strtolower($parts[0]);
    }

    private function parseDirection(string $command): string
    {
        $parts = explode(' ', $command);
        return strtolower($parts[1]);
    }

    private function parseItemName(string $command): string
    {
        $parts = explode(' ', $command);
        return strtolower($parts[1]);
    }

    private function processPickupCommand(Player $player): string
    {
        $currentRoom = $player->getCurrentRoom();
        $items = $currentRoom->getItems();
    
        if (!empty($items)) {
            $player->pickupItems($items);
            $currentRoom->removeItems();
    
            $message = '';
            foreach ($items as $item) {
                $message .= "You've picked up {$item->getName()}\n";
            }
            return $message;
        } else {
            if ($player->getCurrentRoom()->getId() === "west") {
                return "The dog is laying on top of something but barks as you try to approach.";
            }
            return "There are no items to pick up in this room.";
        }
    }

    private function processUseCommand(Player $player, string $itemName): string
    {
        $lowercaseItemName = strtolower($itemName);
        $item = $player->findItemByName($lowercaseItemName);
    
        if ($item) {
            $response = $item->useItem($player);
            if ($response) {
                return $response;
            }
        } else {
            return 'You have no such item.';
        }
    }

    private function passwordCheck(string $password, Player $player)
    {
        $lowercaseItemName = strtolower($password);
        if ($password === 'trocadero') {
            $room = $player->getCurrentRoom();
            $room->addItem(new Item('golden_key', 'Golden key', 'It shines brilliant, most likely for the chains surrounding the exit door'));
            return "You logged in succesfully and hear a small noise behind you the vault which was closed has been opened and reveals a golden key, you should [pickup].";
        }
    }
}
