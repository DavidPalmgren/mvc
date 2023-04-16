<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Card\Card;
use App\Card\CardDeck;
use App\Card\CardGraphic;

class CardGameControllerJson extends AbstractController
{
    #[Route("/api", name: "api_home")]
    public function home(Request $request): Response
    {
        $number = $request->get('number') ?? 5;
        return $this->render('cardgame/apihome.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route("/api/quote", name: "api_quote")]
    public function quote(): Response
    {
        $random_num2 = random_int(0, 2);
        $quotes = [
            "In three words I can sum up everything I've learned about life: it goes on. -Robert Frost",
            "The only thing we have to fear is fear itself. - Franklin D. Roosevelt",
            "Everything that irritates us about others can lead us to an understanding of ourselves. - Carl Jung"
        ];
        $quote = $quotes[$random_num2];
        $data = [
            'quote' => $quote,
            'date' => date("Y-m-d"),
            'timestamp' => time()
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck', name: 'api_deck')]
    public function deck(): JsonResponse
    {

        $deck = new CardDeck();
        $deck->shuffle();
        $deck->sort();

        $cards = [];
        foreach ($deck->getCards() as $card) {
            $cards[] = [
                'rank' => $card->getRank(),
                'suit' => $card->getSuit(),
                'image' => CardGraphic::getCardImage($card),
            ];
        }
        $response = new JsonResponse($cards);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck/shuffle', name: 'api_deck_shuffle', methods: ['POST'])]
    public function deckshuffle(): JsonResponse
    {

        $deck = new CardDeck();
        $deck->shuffle();

        $cards = [];
        foreach ($deck->getCards() as $card) {
            $cards[] = [
                'rank' => $card->getRank(),
                'suit' => $card->getSuit(),
                'image' => CardGraphic::getCardImage($card),
            ];
        }
        $response = new JsonResponse($cards);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/deck/draw', name: 'api_deck_draw_one', methods: ['POST'])]
    #[Route('/api/deck/draw/{number}', name: 'api_deck_draw_multiple', methods: ['POST'])]
    public function deckdraw(Request $request, SessionInterface $session): JsonResponse
    {
        $number = $request->get('number', 1);

        $deck = $session->get('deck', new CardDeck());
        $cards = [];
        for ($i = 0; $i < $number; $i++) {
            $card = $deck->deal();
            if ($card) {
                $cards[] = [
                    'rank' => $card->getRank(),
                    'suit' => $card->getSuit(),
                    'image' => CardGraphic::getCardImage($card),
                ];
            }
        }

        $remaining = count($deck->getCards());
        $session->set('deck', $deck);

        $data = [
            'cards' => $cards,
            'remaining' => $remaining,
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
