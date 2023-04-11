<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];
        
        return $this->render('lucky_number.html.twig', $data);
    }
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }
    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {   
        $lucky_num = random_int(0, 100);
        $lucky_num2 = random_int(0, 2);
        $images = [
            "thrall.webp",
            "peon.webp",
            "tinker.webp"
        ];
        $image = $images[$lucky_num2];
        return $this->render('lucky.html.twig', [
            'lucky_num' => $lucky_num,
            'image' => $image
        ]);
    }
}