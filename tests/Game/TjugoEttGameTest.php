<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use App\Game\Player;
use App\Game\Banker;
use App\Card\Card;
use App\Card\CardDeck;
use App\Game\TjugoEttGame;

/**
 * Test cases for class tjugoettgame.
 */
class TjugoEttGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    
    public function testGameStart()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();
        $this->assertInstanceOf(TjugoEttGame::class, $game);
    }
    public function testPlayerHits()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();
        $game->playerHits();
        
        $hand = $player->getHand();
        $this->assertNotEmpty($hand);
        $game->playerStands();
        $game->endGame();
        $this->assertEquals(1, $game->isGameOver());
        $this->assertEquals("Banker", $game->getWinner());
    }
    public function testPlayerStands()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();
    
        $game->playerStands();
        $this->assertEmpty($player->getHand());
    }
    public function testPlayerBets()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();
        $game->playerHits();
        $game->playerBets(50);
        $this->assertEquals(100, $game->getMoneyPot());
    }
    public function testPlayerWinsRound()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', 'Ace'),
            new Card('Hearts', '10'),
            new Card('Diamonds', '10')
        ];
        foreach($cards as $card) {
            $player->addCard($card);
        }
        $game->playerStands();
        $this->assertEquals(21, $player->getHandValue());
    }
    public function testBankerWinsRound()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', 'Ace'),
            new Card('Hearts', '10'),
            new Card('Diamonds', '10')
        ];
        foreach($cards as $card) {
            $banker->addCard($card);
        }
        $game->playerStands();
        $this->assertEquals(21, $banker->getHandValue());
    }
    public function testPlayerIsBust()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', '5'),
            new Card('Hearts', '10'),
            new Card('Diamonds', '10')
        ];
        foreach($cards as $card) {
            $player->addCard($card);
        }

        $cards2 = [
            new Card('Spades', 'Ace'),
            new Card('Clubs', '10'),
            new Card('Spades', '10')
        ];
        foreach($cards2 as $card2) {
            $banker->addCard($card2);
        }

        $game->playerStands();
        $this->assertEquals("Banker", $game->getWinner());
        $game->playerHits();
        $game->playerStands();
    }
    /**make sure if both draw 21 that banker wins */
    public function test21Draw()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', 'Ace'),
            new Card('Hearts', '10'),
            new Card('Diamonds', '10')
        ];
        foreach($cards as $card) {
            $banker->addCard($card);
        }
        foreach($cards as $card) {
            $player->addCard($card);
        }

        $game->playerStands();
        $this->assertEquals("Banker", $game->getWinner());
    }
    /**if both are bust tests that player wins by def */
    public function testBothIsBust()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', '5'),
            new Card('Hearts', '10'),
            new Card('Diamonds', '10')
        ];
        foreach($cards as $card) {
            $banker->addCard($card);
        }
        foreach($cards as $card) {
            $player->addCard($card);
        }

        $game->playerStands();
        $this->assertEquals("Player", $game->getWinner());
    }
    public function testHittingIntoBustDefaultsToStanding()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();
        $gameOver = 0;

        while (!$gameOver) {
            $game->playerHits();
            $gameOver = $game->isGameOver();
        }
        $this->assertEquals(1, $game->isGameOver());
    }
    public function testBustProbability100()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', '5'),
            new Card('Hearts', '10'),
            new Card('Diamonds', '10')
        ];
        foreach($cards as $card) {
            $player->addCard($card);
        }
        $this->assertEquals(100, $game->bustProbability($player));
    }
    public function testBustProbability0WithAce()
    {
        $deck = new CardDeck();
        $player = new Player("John");
        $banker = new Banker("Banker");
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $cards = [
            new Card('Spades', 'Ace'),
        ];
        foreach($cards as $card) {
            $player->addCard($card);
        }
        $this->assertEquals(0, $game->bustProbability($player));
    }
}