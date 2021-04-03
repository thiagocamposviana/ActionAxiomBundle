<?php
namespace Mugo\ActionAxiomBundle\Lib\Utils;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Plugin\History\HistoryPlugin;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

class HTTPHelper
{

    public static function postData($url, $postParams = array(), $headers = array(), $returnCode = false, $stripHeader = false  ) {
        $params = '';
        if( is_array( $postParams ) )
        {
            foreach($postParams as $key=>$value)
            {
                $params .= $key.'='. urlencode( $value ) . '&';
            }
            $params = trim($params, '&');
        }
        else
        {
            $params = $postParams;
        }

        $ch = curl_init();
        if( !empty( $headers ) )
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.28 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        if( $returnCode || !empty( $headers ) )
        {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        $data = curl_exec($ch);
        if( $returnCode )
        {
            $data = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }
        else if( $stripHeader )
        {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $data = substr($data, $header_size);
        }
        curl_close($ch);

        return $data;
    }

    public static function getData($url, $postParams = array(), $headers = array(), $returnCode = false, $stripHeader = false ) {
        if( count($postParams) > 0 )
        {
            $params = '';
            foreach($postParams as $key=>$value)
            {
                $params .= $key.'='. urlencode( $value ) . '&';
            }
            $params = trim($params, '&');
            $url .= '?' . $params;
        }
        
        $ch = curl_init();
        if( !empty( $headers ) )
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");

        if( $returnCode )
        {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }
        $data = curl_exec($ch);
        if( $returnCode )
        {
            $data = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }
        else if( $stripHeader )
        {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $data = substr($data, $header_size);
        }
        curl_close($ch);
        return $data;
    }

}
