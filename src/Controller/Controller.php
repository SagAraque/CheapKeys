<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Utils\Paginator;
use App\Entity\Games;
use App\Entity\Media;
use App\Entity\Reviews;

class Controller extends AbstractController
{
    /**
     *  @Route("/", name="index")
     */
    public function index(Request $request): Response
    {

        $response = $this->render('/index.html.twig');

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     *  @Route("/{game_slug}", name="product")
     */
    public function product($game_slug, Paginator $paginator, ManagerRegistry $doctrine, Request $request):Response
    {
        $game = $doctrine->getRepository(Games::class)->findBy(array(
            "gameSlug" => $game_slug
        ));

        $media = $doctrine->getRepository(Media::class)->findByGame(array(
            "id" => $game[0]->getIdGame(),
        ));

        $mediaInfo = $doctrine->getRepository(Media::class)->findOneByInfo(array(
            "id" => $game[0]->getIdGame(),
        ));

        $reviews = $doctrine->getRepository(Reviews::class)->findByGameNoResults(array(
            "id_game" => $game[0]->getIdGame(),
        ));

        $paginator->paginate($reviews, 1);
        
        $response = $this->render('/product.html.twig',[
            'game' => $game[0],
            'media' => $media,
            'medIaInfo' => $mediaInfo,
            'reviews' => $paginator
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/store/{data}", requirements={"data"="pc|playstation|xbox|nintendo|ofertas|proximamente"}, name="category")
     */
    public function category($data):Response
    {

        return $this->render('/producto.html.twig',[
            'data' => $data,
        ]);
    }
}
