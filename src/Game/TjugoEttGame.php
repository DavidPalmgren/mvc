<?php

class TjugoEttGame {
    private $deck;
    private $player;
    private $banker;
    private $winner;
    private $gameOver;

    public function __construct(CardDeck $deck, Player $player, Banker $banker) {
        $this->deck = $deck;
        $this->player = $player;
        $this->banker = $banker;
        $this->gameOver = false;
    }

    public function init() {
        $this->deck->shuffle();
        $this->player->resetHand();
        $this->banker->resetHand();
        $this->player->addCard($this->deck->deal());
    }

    public function playerHits() {
        if ($this->gameOver) {
            return;
        }

        $this->player->addCard($this->deck->deal());

        if ($this->player->getHandValue() > 21) {
            $this->bankerWins();
        }
    }

    public function playerStands() {
        if ($this->gameOver) {
            return;
        }

        while ($this->banker->getHandValue() < 17) {
            $this->banker->addCard($this->deck->deal());
        }

        if ($this->banker->getHandValue() > 21 || $this->player->getHandValue() > $this->banker->getHandValue()) {
            $this->playerWins();
        } else {
            $this->bankerWins();
        }
    }

    private function playerWins() {
        $this->winner = "player";
        $this->banker->lose();
        $this->gameOver = true;
    }

    private function bankerWins() {
        $this->winner = "banker";
        $this->player->lose();
        $this->gameOver = true;
    }

    public function getWinner() {
        return $this->$winner;
    }

    public function isGameOver() {
        return $this->gameOver;
    }
}
