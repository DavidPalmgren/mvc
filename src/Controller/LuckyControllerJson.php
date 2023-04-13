<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api/lucky/number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        //return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/quote", name: "quote")]
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
}
