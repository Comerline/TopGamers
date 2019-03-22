<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\GamerManager;
/**
 * The only controller needed
 */
class DefaultController extends AbstractController {
    /**
     * Matches the site base dir
     * @Route("/", name="tg_dashboard")
     */
    public function index() {
        
        $gameobj = new GamerManager();
        $json = $gameobj->readGamers();
        
        $properties = ['urltitle' => 'TopGamers Dashboard',
            'tggames' => $json];
        return $this->render('dashboard.html.twig', $properties);
    }
    
    
    
    
    
    /**
     * Deletes local api cache under certain conditions
     * @Route("/deletecache", name="tg_delcache")
     */
    public function deletecache() {
        
    }

}
