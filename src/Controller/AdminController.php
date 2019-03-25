<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CacheManager;
/**
 * The other secret controller
 */
class AdminController extends AbstractController {
    /**
     * Deletes local api cache under certain conditions
     * @Route("/deletecache", name="tg_delcache")
     */
    public function deletecache(CacheManager $cm) {
        $request = Request::createFromGlobals();
        $givenPass = $request->get('pass');
        $corrPass = getenv('TG_ADMIN_PASS');
        $cacheFile = getenv('TG_ADMIN_CACHEFILE');
        
        if ($givenPass === $corrPass) {
            $cm->deleteCache($cacheFile);
            $toRender = $this->render('admin/notice-cache.html');
        } else {
            $toRender = $this->render('admin/notice-cache-badkey.html');
        }
        return $toRender;
    }

}
