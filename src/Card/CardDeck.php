<?php

namespace App\Card;

use App\Card\Card;

class CardDeck
{
    private $cards;

    /** constructor which i hopelessly believed would increase my points but alas
     * no points were given to griffyndor that day
     */
    public function __construct()
    {
        $this->cards = [];
        $this->initializeDeck();
    }
    
    /**
     * Initializes the card deck by creating and adding all the cards.
     */
    private function initializeDeck()
    {
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
    
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $card = new Card($suit, $rank);
                $this->cards[] = $card;
            }
        }
    }

    /**
     * Creates a new card deck using the provided array of cards.
     * Used primarily for test cases.
     *
     * @param array $cards The array of cards.
     * @return CardDeck The created card deck.
     */
    public static function createDeck(array $cards): CardDeck
    {
        $deck = new self();
        $deck->cards = $cards;
        return $deck;
    }

    /**
     * Shuffles the cards in the deck.
     */
    public function shuffle()
    {
        shuffle($this->cards);
    }

    /**
     * Deals (pops) a card from the deck.
     *
     * @return Card The dealt card
     */
    public function deal()
    {
        return array_pop($this->cards);
    }

    /**
     * Retrieves the number of cards left in the deck.
     *
     * @return int The number of cards left.
     */
    public function cardsLeft()
    {
        return count($this->cards);
    }

    /**
     * Retrieves all the cards in the deck.
     *
     * @return array The array of cards.
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Retrieves a specific card in the deck based on its suit and rank.
     *
     * @param string $suit the suit of the card.
     * @param string $rank the rank of the card.
     * @return Card|null The matching card otherwise null if not found.
     */
    public function getCardBySuitAndRank($suit, $rank)
    {
        $filteredCards = array_filter($this->cards, function ($card) use ($suit, $rank) {
            return $card->getSuit() === $suit && $card->getRank() === $rank;
        });
    
        return reset($filteredCards) ?: null;
    }

    /**
     * Sorts the cards in the deck according to the order of suits and ranks.
     */
    public function sort()
    {
        $sortedCards = array();

        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $card = $this->getCardBySuitAndRank($suit, $rank);
                if ($card) {
                    $sortedCards[] = $card;
                }
            }
        }

        $this->cards = $sortedCards;
    }

    /**
     * Counts the occurrences of each rank/number card in the deck.
     *
     * @return array An array with ranks as keys and counts as values.
     */
    public function cardCount()
    {
        $counts = [];

        foreach ($this->cards as $card) {
            $rank = $card->getRank();
            if (isset($counts[$rank])) {
                $counts[$rank]++;
            } else {
                $counts[$rank] = 1;
            }
        }

        return $counts;
    }
}
