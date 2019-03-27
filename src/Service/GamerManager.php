<?php

namespace App\Service;

use App\Service\CacheManager;
use App\Utils\CurlHelper;

/**
 * A service object that helps us read our API from different sources.
 *
 * @author dos
 */
class GamerManager {

    var $cache = null;

    function __construct(CacheManager $cm) {
        $this->cache = $cm;
    }

    /**
     * Cache access
     */
    function getCache() {
        return $this->cache;
    }

    /**
     * Reads data from our API server
     * @return json
     */
    private function readFromUrl() {
        $linkenv = getenv('TG_JSON_ALLGAMES');
        if (CurlHelper::urlExists($linkenv)) {
            $req = curl_init($linkenv);
            curl_setopt($req, CURLOPT_HEADER, FALSE);
            curl_setopt($req, CURLOPT_NOBODY, FALSE);
            curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
            $json = curl_exec($req);
            curl_close($req);
            $jsonReturn = $this->filterJson(json_decode($json, true));
        } else {
            $jsonReturn = null;
        }
        return $jsonReturn;
    }

    /**
     * Reads data from our cache file
     * @return json
     */
    private function readFromCache() {
        return $this->getCache()->readCacheFile();
    }

    /**
     * Reads game data from multiple sources.
     * Contains the conditions to read from cache or not.
     * @return json
     */
    function readGamers() {
        $jsonReturn = null;

        //All the tests
        $cacheExists = $this->getCache()->cacheExists();
        $cacheAgeValid = $this->getCache()->checkAgeValid();
        $cacheIsLegitimate = $this->getCache()->cacheIsLegitimate();

        if ($cacheExists && $cacheAgeValid && $cacheIsLegitimate) {
            $jsonReturn = $this->readFromCache();
        }

        if (empty($jsonReturn)) {
            $json = $this->readFromUrl();
            $this->getCache()->writeCacheFile($json);
            $jsonReturn = $json;
        }
        return $jsonReturn;
    }

    /**
     * Itarates through gamer data.
     * @param json $oriJson
     * @return json
     */
    private function filterJson($oriJson) {
        foreach ($oriJson['games'] as $key => $game) {
            $newplayers = [];
            foreach ($game['gamers'] as $player) {
                //players of each game
                $newplayer = $player;
                $newplayer['twitch'] = $this->cleanLink($player['twitch']);
                $newplayers[] = $newplayer;
            }
            $oriJson['games'][$key]['gamers'] = $newplayers;
        }
        return $oriJson;
    }

    /**
     * Filters out bad twitch player links
     * @param json $link
     * @return json
     */
    private function cleanLink($link) {

        $returning = $link;

        if ($link != null && !empty($link)) {
            $twitchLink = $link;
            if (strpos($twitchLink, 'www.twitch.tv') !== false) {
                $fwdslash = strrpos($twitchLink, "/");
                $username = substr($twitchLink, ($fwdslash + 1));
                $returning = "https://player.twitch.tv/?channel=" . $username;
            } else if (strpos($twitchLink, 'player.twitch.tv/?channel=') !== false) {
                //do nothing;
            } else {
                $returning = null;
            }
        }

        return $returning;
    }

}
