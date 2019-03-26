<?php

namespace App\Classes;

/**
 * Extra classes for JSON
 *
 * @author dos
 */
class JsonHelper {

    static function jsonValidator($data = null) {
        if (!empty($data)) {
            json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }

}
