<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Classes;

class JsonHelper {
    function jsonValidator($data=null) {
        if (!empty($data)) {
            json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }
}


