<?php

namespace App\Utils;

/**
 * Extra classes for JSON
 * @author dos
 */
class JsonHelper {

    /**
     * Checks if json is a valid json string
     * @param json $data
     * @return boolean
     */
    static function jsonValidator($data = null) {
        if (!empty($data)) {
            json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

}
