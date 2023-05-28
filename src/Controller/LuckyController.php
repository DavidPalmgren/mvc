<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @codeCoverageIgnore
 */
class LuckyController
{
    #[Route("/lucky/hi")]
    public function hifunc(): Response
    {
        return new Response(
            '<html><body>Hi to you!</body></html>'
        );
    }
}
