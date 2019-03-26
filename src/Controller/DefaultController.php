<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GamerManager;

/**
 * The only controller needed
 */
class DefaultController extends AbstractController {

    /**
     * Matches the site base dir
     * @Route("/", name="tg_dashboard")
     */
    public function index(GamerManager $gm) {

        $json = $gm->readGamers();

        $properties = ['urltitle' => 'TopGamers Dashboard',
            'tggames' => $json];
        return $this->render('dashboard.html.twig', $properties);
    }

}
