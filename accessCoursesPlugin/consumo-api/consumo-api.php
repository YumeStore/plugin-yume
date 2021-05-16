<?php
require_once('end-points.php');

class ConsumoApi
{
    var $url;
    var $token;

    function __construct($url, $token)
    {
        $this->url = $url;
        $this->token = $token;
    }

    public function retornoListaCursos()
    {
        $ch = curl_init($this->url . EndPoints::GetListaCursos . '?page=1&token=' . $this->token);

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => true
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}
