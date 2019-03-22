<?php
namespace App\Classes;
/**
 * Extra classes for cURL
 *
 * @author dos
 */
class CurlHelper {
    static function urlExists($url) {
        $handle   = curl_init($url);
        if (false === $handle) {
                return false;
        }
        curl_setopt($handle, CURLOPT_HEADER, false);
        curl_setopt($handle, CURLOPT_FAILONERROR, true);
        //Some servers wont respond if no header
        curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") );
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
        $connectable = curl_exec($handle);
        ##print $connectable;
        curl_close($handle);
        return $connectable;
    }
}
