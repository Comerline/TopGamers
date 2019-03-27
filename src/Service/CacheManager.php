<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use App\Utils\JsonHelper;

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

    /**
     * Returns cache filename
     * @return string
     */
    function getCacheFName() {
        return $this->onDisk;
    }

    /**
     * Checks if cache is newer than a day
     * @return boolean
     */
    function checkAgeValid() {
        if (time() - $this->getCacheLastUpdate() > 24 * 3600) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks if the cache file exists
     * @return boolean
     */
    function cacheExists() {
        return $this->fs->exists($this->tmp . $this->onDisk);
    }

    /**
     * checks if the cache file is good JSON
     * @return boolean
     */
    function cacheIsLegitimate() {
        return JsonHelper::jsonValidator(json_encode($this->readCacheFile()));
    }

    /**
     * Sets the new cache file name, transferring data
     */
    function setCacheFName($newname) {
        $this->fs->rename($this->tmp . $this->onDisk, $this->tmp . $newname);
        $this->onDisk = $newname;
    }

    /**
     * Reads modified time on our json cache file
     * @return time
     */
    private function getCacheLastUpdate() {
        if ($this->cacheExists()) {
            return filemtime($this->tmp . $this->onDisk);
        } else {
            return null;
        }
    }

    /**
     * Deletes the cache file
     * @return boolean
     */
    function deleteCache() {
        $cacheFile = $this->cacheDefaultFile();
        return unlink($this->tmp . $cacheFile);
    }

    /**
     * Writes new cache file
     */
    function writeCacheFile($json) {
        file_put_contents($this->tmp . $this->onDisk, json_encode($json));
    }

    /**
     * Reads content from cache file
     * @return json
     */
    function readCacheFile() {
        if ($this->cacheExists()) {
            return json_decode(file_get_contents($this->tmp . $this->onDisk), true);
        }
    }

    /**
     * If envvar
     * @return string
     */
    private function cacheDefaultFile() {
        $currFilename = getenv('TG_ADMIN_CACHEFILE');
        if (empty($currFilename)) {
            $currFilename = "tg-cache.json";
        }
        return $currFilename;
    }

}
