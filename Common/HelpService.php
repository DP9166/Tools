<?php

class HelpService
{
    public static function send_url($url ,$method='get', $post_arr=null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//¹æ±ÜÖ¤Êé
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // ·ÀÖ¹302 µÁÁ´
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::createHeaders());
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
        }
        $result = curl_exec($ch);
        if(curl_errno($ch)){
            echo 'visit ['.$url.'] curl_get error: '. curl_error($ch) ."\n";
        }
        curl_close($ch);
        return $result;
    }

    public static function createHeaders()
    {
        $time = time();
        $random_str = HelpService::getRandom(6);
        $headers = array();
        $headers[] = 'application/x-www-form-urlencoded;charset=utf-8';
        $headers[] = 'Nonce:' .$random_str;
        $headers[] = 'CurTime:'. $time;
        $headers[] = 'token: f326d2d7-32b8-4f8d-a76e-e5e2e419f829';

        return $headers;
    }

    public static function getRandom($length=12,$base="1234567890abcdefghijklmnopqrstuvwxyz"){
        $len = strlen($base)-1;
        $str = "";
        for($i=0;$i<$length;$i++){
            $str .= $base[rand(0,$len)];
        }
        return $str;
    }
}