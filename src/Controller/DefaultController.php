<?php

// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    public function number() {

        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
                    'number' => $number,
        ]);
    }

    /**
     * Matches the site base dir
     * @Route("/", name="tg_dashboard")
     */
    public function index() {

        //Get the game data from the api
        $linkenv = getenv('TG_JSON_ALLGAMES');
        $json = file_get_contents($linkenv);
        $gameobj = json_decode($json, true);
        $properties = ['urltitle' => 'TopGamers Dashboard',
            'tggames' => $gameobj];
        return $this->render('dashboard.html.twig', $properties);
    }

}
