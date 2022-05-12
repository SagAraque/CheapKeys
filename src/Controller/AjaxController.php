<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\Reviews;
use App\Entity\Games;
use App\Entity\Platforms;
use App\Utils\Paginator;
use App\Entity\WishlistGames;

class AjaxController extends AbstractController
{

    /**
     * @Route("/ajax/reviews")
     */
    public function reviews(ManagerRegistry $doctrine, Paginator $paginator, Request $request): Response
    {
        $params = $request->query;
        $reviews = $doctrine->getRepository(Reviews::class)->findByGameNoResults(array(
            "id_game" => $params->get('id'),
        ));

        $page = $params->getInt('page');
        $paginator->paginate($reviews, $page);

        return $this->render('ajax/reviews.html.twig',[
            'reviews' => $paginator
        ]);
    }

    /**
     * @Route("/ajax/wishlist")
     */
    public function wishlist(ManagerRegistry $doctrine, Request $request, Security $security)
    {
        $user = $security->getUser();
        
        if($user == null){
            return new Response("", 302);
        }

        $em = $doctrine->getManager();

        $gameId = $request->get('_game');
        $platformId = $request->get('_platform');

        $wishlist = $doctrine->getRepository(WishlistGames::class)->findGameByUser($gameId, $platformId, $user->getUserWishlist());

        if($wishlist == null){
            $game = $doctrine->getRepository(Games::class)->find($gameId);
    
            $platform = $doctrine->getRepository(Platforms::class)->find($platformId);
    
            $wishlist = new WishlistGames();
            $wishlist->setIdGame($game);
            $wishlist->setIdPlatform($platform);
            $wishlist->setIdWishlist($user->getUserWishlist());

            $em->persist($wishlist);
            $em->flush();

            return new Response("Added", 200);
        }else{
            $em->remove($wishlist);
            $em->flush();

            return new Response("Deleted", 200);
        }
        
    }
}
