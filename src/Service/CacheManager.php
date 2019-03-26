<?php

// src/Services/CacheManager.php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use App\Classes\JsonHelper;

/**
 * A service object that helps us cache JSON objects on disk.
 *
 * @author dos
 */
class CacheManager {

    var $fs = null;
    var $onDisk = null;
    var $tmp = null;

    function __construct() {
        $this->onDisk = $this->cacheDefaultFile();
        $this->tmp = sys_get_temp_dir() . '/';
        $this->fs = new Filesystem();
    }

    function getCacheFName() {
        return $this->onDisk;
    }

    //Validity
    function checkAgeValid() {
        if (time() - $this->getCacheLastUpdate() > 24 * 3600) {
            return false;
        } else {
            return true;
        }
    }

    function cacheExists() {
        return $this->fs->exists($this->tmp . $this->onDisk);
    }

    function cacheIsLegitimate() {
        return JsonHelper::jsonValidator(json_encode($this->readCacheFile()));
    }

    //FS operations
    function setCacheFName($newname) {
        $this->fs->rename($this->tmp . $this->onDisk, $this->tmp . $newname);
        $this->onDisk = $newname;
    }

    function getCacheLastUpdate() {
        if ($this->cacheExists()) {
            return filemtime($this->tmp . $this->onDisk);
        } else {
            return null;
        }
    }

    function deleteCache() {
        $cacheFile = $this->cacheDefaultFile();
        return unlink($this->tmp . $cacheFile);
    }

    function writeCacheFile($json) {
        file_put_contents($this->tmp . $this->onDisk, json_encode($json));
    }

    function readCacheFile() {
        if ($this->cacheExists()) {
            return json_decode(file_get_contents($this->tmp . $this->onDisk), true);
        }
    }

    private function cacheDefaultFile() {
        $currFilename = getenv('TG_ADMIN_CACHEFILE');
        if ($currFilename == null) {
            $currFilename = "tg-cache.json";
        }
        return $currFilename;
    }

}
