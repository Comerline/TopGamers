<?php
// src/Services/CacheManager.php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use App\Classes\JsonHelper;

/**
 * Description of CacheManager
 *
 * @author dos
 */
class CacheManager {
    
    var $fs = null;
    var $onDisk = "tg-cache.json";
    var $tmp = null;
    
    function __construct($filename = "tg-cache.json") {
        $this->onDisk = $filename;
        $this->tmp = sys_get_temp_dir().'/';
        $this->fs = new Filesystem();
        
    }
    
    function getCacheFName() {
        return $this->onDisk;
    }
    
    //Validity
    function checkAgeValid() {
        if (time()-$this->getCacheLastUpdate() > 24 * 3600) {
            return false;
        } else {
            return true;
        }
    }
    
    function cacheExists() {
        return $this->fs->exists($this->tmp.$this->onDisk);
    }
    
    function cacheIsLegitimate() {
        return JsonHelper::jsonValidator(json_encode($this->readCacheFile()));
    }
    
    
    //FS operations
    function setCacheFName($newname) {
        $this->fs->rename($this->tmp.$this->onDisk, $this->tmp.$newname);
        $this->onDisk = $newname;
    }
    
    function getCacheLastUpdate() {
        if ($this->cacheExists()) {
            return filemtime($this->tmp.$this->onDisk);
        } else {
            return null;
        }
        
    }
    
    function deleteCache() {
        return unlink($this->tmp.$this->onDisk);
    }
    
    function writeCacheFile($json) {
        file_put_contents($this->tmp.$this->onDisk , json_encode($json));
    }
    
    function readCacheFile() { 
        if ($this->cacheExists()) {
            return json_decode(file_get_contents($this->tmp.$this->onDisk), true);
        }
        
    }
    
}
