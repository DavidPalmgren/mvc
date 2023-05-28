<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Adventure\GameMap;
use App\Adventure\Player;
use App\Adventure\Room;
use App\Adventure\Item;
use App\Adventure\Commands;

 /**
 * @codeCoverageIgnore
 */
class AdventureGameJsonController extends AbstractController
{
    #[Route("/proj/api/", name: "proj_api")]
    public function jsonNumber(): Response
    {
        return $this->render("AdventureGameTemplates/api.html.twig");
    }
    #[Route("/proj/api/map", name: "proj_api_map")]
    public function jsonMap(): JsonResponse
    {
        $gameMap = new GameMap('center');
        $gameMap = $gameMap->initializeGameMap();
    
        $data = [
            'game-map' => [
                'rooms' => [],
            ],
        ];
    
        foreach ($gameMap->getRooms() as $room) {
            $neighbors = [];
            foreach ($room->getNeighbors() as $direction => $neighbor) {
                $neighbors[$direction] = $neighbor ? $neighbor->getId() : null;
            }
    
            $data['game-map']['rooms'][] = [
                'id' => $room->getId(),
                'description' => $room->getDescription(),
                'neighbors' => $neighbors,
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
    
        return $response;
    }
    //items in room
    #[Route("/proj/api/items", name: "proj_api_items")]
    public function jsonItems(): JsonResponse
    {
        $gameMap = new GameMap('center');
        $gameMap = $gameMap->initializeGameMap();
    
        $data = [
            'rooms' => [],
        ];

        foreach ($gameMap->getRooms() as $room) {
            $items = $room->getItems();
            $roomData = [
                'id' => $room->getId(),
                'description' => $room->getDescription(),
                'items' => [],
            ];

            foreach ($items as $item) {
                $roomData['items'][] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'description' => $item->getDescription(),
                ];
            }
    
            $data['rooms'][] = $roomData;
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
    
        return $response;
    }
    
    #[Route("/proj/api/inventory", name: "proj_api_inventory")]
    public function jsonInventory(SessionInterface $session): JsonResponse
    {
        $player = $session->get('player');
    
        $data = [
            'items' => [],
        ];
    
        if ($player && $player->getInventory()) {
            foreach ($player->getInventory() as $item) {
                $data['items'][] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'description' => $item->getDescription(),
                ];
            }
        }
    
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
    
        return $response;
    }
    #[Route('/proj/api/add-item', name: 'add_item', methods: ['GET', 'POST'])]
    public function addItem(Request $request, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $id = $request->request->get('id');
            $name = $request->request->get('name');
            $description = $request->request->get('description');
    
            $item = new Item($id, $name, $description);
            $player = $session->get('player');
            $player->addItem($item);
    
            return $this->redirectToRoute('proj_api_inventory');
        }
    
        return $this->render('AdventureGameTemplates/proj_api.html.twig');
    }
    #[Route('/proj/api/room-id', name: 'room_by_id', methods: ['GET', 'POST'])]
    public function roomById(Request $request, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $id = $request->request->get('id2');
            $gameMap = new GameMap('center');
            $gameMap = $gameMap->initializeGameMap();
            $room = $gameMap->getRoom($id);
    
            $data = [
                'id' => $room->getId(),
                'description' => $room->getDescription(),
                'neighbors' => $room->getNeighbors(),
                'image' => $room->getImage(),
                'items' => $room->getItems(),
            ];


            $processedItems = [];
            $processedNeighbors = [];

            foreach ($data['items'] as $item) {
                $processedItems[] = [
                    'name' => $item->getName(),
                    'description' => $item->getDescription(),
                ];
            }

            foreach ($data['neighbors'] as $direction => $neighbor) {
                $processedNeighbors[$direction] = [
                    'id' => $neighbor->getId(),
                ];
            }
            $data['items'] = $processedItems;
            $data['neighbors'] = $processedNeighbors;
            
            $response = new JsonResponse($data);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
        
            return $response;
        }
    
        return $this->render('AdventureGameTemplates/proj_api.html.twig');
    }
}