<?php

namespace App\Adventure;
use App\Adventure\Player;
use App\Adventure\GameMap;

class Commands
{
    public function processCommand(string $command, Player $player, GameMap $gameMap): string
    {
        if ($command === 'north') {
            $player->move('north');
        } elseif ($command === 'east') {
            $player->move('east');
        } elseif ($command === 'south') {
            $player->move('south');
        } elseif ($command === 'west') {
            $player->move('west');
        } elseif ($command === 'pickup') {
            $currentRoom = $player->getCurrentRoom();
            $items = $currentRoom->getItems();
    
            $player->pickupItems($items);
            $currentRoom->removeItems();
    
            $message = '';
            foreach ($items as $item) {
                $message .= "You've picked up {$item->getName()}\n";
            }
    
            return $message;
        }
    
        $currentRoom = $player->getCurrentRoom();
    
        return 'You have moved to ' . $currentRoom->getDescription();
    }
}