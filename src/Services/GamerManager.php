<?php
// src/Services/GamerManager.php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;
use App\Services\CacheManager;
use App\Classes\CurlHelper;

/**
 * Description of GamerManager
 *
 * @author dos
 */
class GamerManager {
    
    var $cache = null;
    
    function __construct() {
        $this->cache = new CacheManager();
    }
    
    //Functions that read data
    function readFromUrl() {
        $linkenv = getenv('TG_JSON_ALLGAMES');
        if (CurlHelper::urlExists($linkenv)) {
            $req = curl_init($linkenv);
            curl_setopt($req, CURLOPT_HEADER, FALSE); 
            curl_setopt($req, CURLOPT_NOBODY, FALSE);
            curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE); 
            $json = curl_exec($req);
            curl_close($req);
            $jsonReturn = json_decode($json, true);
        } else {
            $jsonReturn = null;
        }
        return $jsonReturn;
    }
    
    function readGamers() {
        $jsonReturn = null;
        
        //All the tests
        $cacheExists = $this->getCache()->cacheExists();
        $cacheAgeValid = $this->getCache()->checkAgeValid();
        $cacheIsLegitimate = $this->getCache()->cacheIsLegitimate();
        
        if ($cacheExists && $cacheAgeValid && $cacheIsLegitimate) {
            $jsonReturn = $this->readFromCache();
        } else {
            $json = $this->readFromUrl();
            $this->getCache()->writeCacheFile($json);
            $jsonReturn = $json;
        }
        return $jsonReturn;
    }
    
    
    //Cache access
    function getCache() {
        return $this->cache; 
    }
    
    function readFromCache() {
        return $this->getCache()->readCacheFile();
    }
    
}
