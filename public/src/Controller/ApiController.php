<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api_index")
     */
    #[Route('/api', name: 'api_index')]
    public function index(RouterInterface $router): Response
    {
        // get routes
        $routes = $router->getRouteCollection()->all();


        $routeSummary = [];
        foreach ($routes as $name => $route) {
            $routeSummary[] = [
                'name' => $name,
                'path' => $route->getPath()
                //'methods' => $route->getMethods()
            ];
        }


        return $this->render('api.html.twig', [
            'routes' => $routeSummary
        ]);
    }

     /**
     * @Route("/api/quote", name="api_quote")
     */
    #[Route('/api/quote', name: 'api_quote')]
    public function quote(): JsonResponse
    {

            // Citat list
            $quotes = [
                "Life is what happens when you're busy making other plans.  John Lennon",
                "The purpose of our lives is to be happy.  Dalai Lama",
                "Get busy living or get busy dying.  Stephen King"
            ];

            // Slumpmasig citat
            $randomQuote = $quotes[array_rand($quotes)];

            // Data och tid
            $currentDate = new \DateTime();

            $data = [
                'quote' => $randomQuote,
                'date' => $currentDate->format('Y-m-d'),
                'timestamp' => $currentDate->format('H:i:s')
            ];

            $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            return new JsonResponse(json_decode($json));

    }
}
