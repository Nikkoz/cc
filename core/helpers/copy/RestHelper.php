<?php

namespace core\helpers\copy;


final class RestHelper
{
    public static function send(array $params)
    {
        $http = ['Content-Type: application/json'];
        $url = 'http://api.coincontrol.2672230.ru/api/db';

        if(!empty($params)) {
            $query = \http_build_query($params);
            $url .= '?' . $query;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        //curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        //curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_PROXY, "109.120.185.5");
        curl_setopt($ch, CURLOPT_PROXYPORT, "80");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http);

        $result = curl_exec($ch);
        $result = json_decode($result);

        //echo '<pre>'.print_r(curl_error($ch),1).'</pre>';
        //echo '<pre>'.print_r(curl_getinfo($ch),1).'</pre>';
        //echo '<pre>'.print_r($result,1).'</pre>';die;

        curl_close($ch);

        return $result ?? null;
    }
}