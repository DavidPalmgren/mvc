<?php

namespace App\Adventure;

use App\Adventure\Player;
use App\Adventure\GameMap;

class Commands
{
    /**
     * @param string $command from suer input
     * @param Player $player instance
     * @param GameMap $gameMap instance in use (unused) but cant be assed to remove at this point kinda thought id use it but there wasnt really a need.
     *
     * @return string Which describes what happend after you used command can be seen below the command buttons.
     */
    public function processCommand(string $command, Player $player, GameMap $gameMap): string
    {
        $action = $this->parseCommand($command);

        switch ($action) {
            case 'move':
                $direction = $this->parseDirection($command);
                if ($direction === null) {
                    return "please specify direction, example: move north";
                };
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
                    if ($attempt === null) {
                        return "please specify password, example: password mittlösenord";
                    }
                    return $this->passwordCheck($attempt, $player);
                    break;
                }
                return "No computer to put that password into";
                break;
        }
        return '';
    }

    private function parseCommand(string $command): string
    {
        $parts = explode(' ', $command);
        return strtolower($parts[0]);
    }
    //didnt need both of these but w,e
    private function parseDirection(string $command): string|null
    {
        $parts = explode(' ', $command);
        return isset($parts[1]) ? strtolower($parts[1]) : null;
    }

    private function parseItemName(string $command): string|null
    {
        $parts = explode(' ', $command);
        return isset($parts[1]) ? strtolower($parts[1]) : null;
    }
    /**
     * Processes pickup command and returns a string of what happend
     * say you use pickup in dog room/bedroom the dog barks at you as a mini event? lol
     *
     *
     * @param Player $player ur character
     *
     * @return string describing what happend usually what item you picked up
     */
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
        }
        if ($player->getCurrentRoom()->getId() === "west") {
            return "The dog is laying on top of something but barks as you try to approach.";
        }
        return "There are no items to pick up in this room.";
    }

    private function processUseCommand(Player $player, string|null $itemName): string
    {
        if ($itemName === null) {
            return "Please specify an item, example: use wirt's leg.";
        }

        $lowercaseItemName = strtolower($itemName);
        $item = $player->findItemByName($lowercaseItemName);

        if ($item) {
            $response = $item->useItem($player);
            if ($response) {
                return $response;
            }
        }
        return 'You have no such item.';
    }

    /**
     * @param string $password checks that password is entered correctly
     * @param Player $player checks that player is in correct room while PCRoom while using command.
     *
     * @return string
     */
    private function passwordCheck(string $password, Player $player)
    {
        $lowercaseItemName = strtolower($password);
        if ($lowercaseItemName === 'trocadero') {
            $room = $player->getCurrentRoom();
            $room->addItem(new Item('golden_key', 'Golden key', 'It shines brilliant, most likely for the chains surrounding the exit door'));
            return "You logged in succesfully and hear a small noise behind you the vault which was closed has been opened and reveals a golden key, you should [pickup].";
        }
        return "Wrong password was entered the computer stares at you in disbelief kek";
    }
}
