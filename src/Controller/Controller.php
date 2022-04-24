<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Games;

class Controller extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route('/{game_slug}', name:'product')]
    public function product($game_slug, ManagerRegistry $doctrine):Response
    {
        $game = $doctrine->getRepository(Games::class)->find(1);
        // $game = $doctrine->getRepository(Games::class)->findBy(array(
        //     "gameSlug" => $game_slug
        // ));
        
        // echo "<script>alert(". count($game) .")</script>";
        return $this->render('/producto.html.twig',[
            'game' => $game,
        ]);
    }
}
